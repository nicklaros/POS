<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\Product as ChildProduct;
use ORM\ProductQuery as ChildProductQuery;
use ORM\PurchaseDetail as ChildPurchaseDetail;
use ORM\PurchaseDetailQuery as ChildPurchaseDetailQuery;
use ORM\SalesDetail as ChildSalesDetail;
use ORM\SalesDetailQuery as ChildSalesDetailQuery;
use ORM\Stock as ChildStock;
use ORM\StockQuery as ChildStockQuery;
use ORM\Unit as ChildUnit;
use ORM\UnitQuery as ChildUnitQuery;
use ORM\Map\StockTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class Stock implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ORM\\Map\\StockTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        string
     */
    protected $id;

    /**
     * The value for the product_id field.
     * @var        string
     */
    protected $product_id;

    /**
     * The value for the amount field.
     * @var        string
     */
    protected $amount;

    /**
     * The value for the unit_id field.
     * @var        string
     */
    protected $unit_id;

    /**
     * The value for the buy field.
     * @var        int
     */
    protected $buy;

    /**
     * The value for the sell_public field.
     * @var        int
     */
    protected $sell_public;

    /**
     * The value for the sell_distributor field.
     * @var        int
     */
    protected $sell_distributor;

    /**
     * The value for the sell_misc field.
     * @var        int
     */
    protected $sell_misc;

    /**
     * The value for the discount field.
     * @var        string
     */
    protected $discount;

    /**
     * The value for the unlimited field.
     * @var        boolean
     */
    protected $unlimited;

    /**
     * The value for the status field.
     * @var        string
     */
    protected $status;

    /**
     * @var        ChildProduct
     */
    protected $aProduct;

    /**
     * @var        ChildUnit
     */
    protected $aUnit;

    /**
     * @var        ObjectCollection|ChildPurchaseDetail[] Collection to store aggregation of ChildPurchaseDetail objects.
     */
    protected $collPurchases;
    protected $collPurchasesPartial;

    /**
     * @var        ObjectCollection|ChildSalesDetail[] Collection to store aggregation of ChildSalesDetail objects.
     */
    protected $collSaless;
    protected $collSalessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPurchaseDetail[]
     */
    protected $purchasesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSalesDetail[]
     */
    protected $salessScheduledForDeletion = null;

    /**
     * Initializes internal state of ORM\Base\Stock object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Stock</code> instance.  If
     * <code>obj</code> is an instance of <code>Stock</code>, delegates to
     * <code>equals(Stock)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Stock The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [product_id] column value.
     *
     * @return string
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Get the [amount] column value.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the [unit_id] column value.
     *
     * @return string
     */
    public function getUnitId()
    {
        return $this->unit_id;
    }

    /**
     * Get the [buy] column value.
     *
     * @return int
     */
    public function getBuy()
    {
        return $this->buy;
    }

    /**
     * Get the [sell_public] column value.
     *
     * @return int
     */
    public function getSellPublic()
    {
        return $this->sell_public;
    }

    /**
     * Get the [sell_distributor] column value.
     *
     * @return int
     */
    public function getSellDistributor()
    {
        return $this->sell_distributor;
    }

    /**
     * Get the [sell_misc] column value.
     *
     * @return int
     */
    public function getSellMisc()
    {
        return $this->sell_misc;
    }

    /**
     * Get the [discount] column value.
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Get the [unlimited] column value.
     *
     * @return boolean
     */
    public function getUnlimited()
    {
        return $this->unlimited;
    }

    /**
     * Get the [unlimited] column value.
     *
     * @return boolean
     */
    public function isUnlimited()
    {
        return $this->getUnlimited();
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : StockTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : StockTableMap::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : StockTableMap::translateFieldName('Amount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : StockTableMap::translateFieldName('UnitId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unit_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : StockTableMap::translateFieldName('Buy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buy = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : StockTableMap::translateFieldName('SellPublic', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_public = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : StockTableMap::translateFieldName('SellDistributor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_distributor = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : StockTableMap::translateFieldName('SellMisc', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_misc = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : StockTableMap::translateFieldName('Discount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : StockTableMap::translateFieldName('Unlimited', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unlimited = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : StockTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = StockTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ORM\\Stock'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aProduct !== null && $this->product_id !== $this->aProduct->getId()) {
            $this->aProduct = null;
        }
        if ($this->aUnit !== null && $this->unit_id !== $this->aUnit->getId()) {
            $this->aUnit = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[StockTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [product_id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setProductId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->product_id !== $v) {
            $this->product_id = $v;
            $this->modifiedColumns[StockTableMap::COL_PRODUCT_ID] = true;
        }

        if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
            $this->aProduct = null;
        }

        return $this;
    } // setProductId()

    /**
     * Set the value of [amount] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->amount !== $v) {
            $this->amount = $v;
            $this->modifiedColumns[StockTableMap::COL_AMOUNT] = true;
        }

        return $this;
    } // setAmount()

    /**
     * Set the value of [unit_id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setUnitId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->unit_id !== $v) {
            $this->unit_id = $v;
            $this->modifiedColumns[StockTableMap::COL_UNIT_ID] = true;
        }

        if ($this->aUnit !== null && $this->aUnit->getId() !== $v) {
            $this->aUnit = null;
        }

        return $this;
    } // setUnitId()

    /**
     * Set the value of [buy] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setBuy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->buy !== $v) {
            $this->buy = $v;
            $this->modifiedColumns[StockTableMap::COL_BUY] = true;
        }

        return $this;
    } // setBuy()

    /**
     * Set the value of [sell_public] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setSellPublic($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_public !== $v) {
            $this->sell_public = $v;
            $this->modifiedColumns[StockTableMap::COL_SELL_PUBLIC] = true;
        }

        return $this;
    } // setSellPublic()

    /**
     * Set the value of [sell_distributor] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setSellDistributor($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_distributor !== $v) {
            $this->sell_distributor = $v;
            $this->modifiedColumns[StockTableMap::COL_SELL_DISTRIBUTOR] = true;
        }

        return $this;
    } // setSellDistributor()

    /**
     * Set the value of [sell_misc] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setSellMisc($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_misc !== $v) {
            $this->sell_misc = $v;
            $this->modifiedColumns[StockTableMap::COL_SELL_MISC] = true;
        }

        return $this;
    } // setSellMisc()

    /**
     * Set the value of [discount] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setDiscount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discount !== $v) {
            $this->discount = $v;
            $this->modifiedColumns[StockTableMap::COL_DISCOUNT] = true;
        }

        return $this;
    } // setDiscount()

    /**
     * Sets the value of the [unlimited] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setUnlimited($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->unlimited !== $v) {
            $this->unlimited = $v;
            $this->modifiedColumns[StockTableMap::COL_UNLIMITED] = true;
        }

        return $this;
    } // setUnlimited()

    /**
     * Set the value of [status] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[StockTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildStockQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProduct = null;
            $this->aUnit = null;
            $this->collPurchases = null;

            $this->collSaless = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Stock::setDeleted()
     * @see Stock::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildStockQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                StockTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProduct !== null) {
                if ($this->aProduct->isModified() || $this->aProduct->isNew()) {
                    $affectedRows += $this->aProduct->save($con);
                }
                $this->setProduct($this->aProduct);
            }

            if ($this->aUnit !== null) {
                if ($this->aUnit->isModified() || $this->aUnit->isNew()) {
                    $affectedRows += $this->aUnit->save($con);
                }
                $this->setUnit($this->aUnit);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->purchasesScheduledForDeletion !== null) {
                if (!$this->purchasesScheduledForDeletion->isEmpty()) {
                    foreach ($this->purchasesScheduledForDeletion as $purchase) {
                        // need to save related object because we set the relation to null
                        $purchase->save($con);
                    }
                    $this->purchasesScheduledForDeletion = null;
                }
            }

            if ($this->collPurchases !== null) {
                foreach ($this->collPurchases as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->salessScheduledForDeletion !== null) {
                if (!$this->salessScheduledForDeletion->isEmpty()) {
                    foreach ($this->salessScheduledForDeletion as $sales) {
                        // need to save related object because we set the relation to null
                        $sales->save($con);
                    }
                    $this->salessScheduledForDeletion = null;
                }
            }

            if ($this->collSaless !== null) {
                foreach ($this->collSaless as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[StockTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StockTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StockTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(StockTableMap::COL_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PRODUCT_ID';
        }
        if ($this->isColumnModified(StockTableMap::COL_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'AMOUNT';
        }
        if ($this->isColumnModified(StockTableMap::COL_UNIT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'UNIT_ID';
        }
        if ($this->isColumnModified(StockTableMap::COL_BUY)) {
            $modifiedColumns[':p' . $index++]  = 'BUY';
        }
        if ($this->isColumnModified(StockTableMap::COL_SELL_PUBLIC)) {
            $modifiedColumns[':p' . $index++]  = 'SELL_PUBLIC';
        }
        if ($this->isColumnModified(StockTableMap::COL_SELL_DISTRIBUTOR)) {
            $modifiedColumns[':p' . $index++]  = 'SELL_DISTRIBUTOR';
        }
        if ($this->isColumnModified(StockTableMap::COL_SELL_MISC)) {
            $modifiedColumns[':p' . $index++]  = 'SELL_MISC';
        }
        if ($this->isColumnModified(StockTableMap::COL_DISCOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'DISCOUNT';
        }
        if ($this->isColumnModified(StockTableMap::COL_UNLIMITED)) {
            $modifiedColumns[':p' . $index++]  = 'UNLIMITED';
        }
        if ($this->isColumnModified(StockTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'STATUS';
        }

        $sql = sprintf(
            'INSERT INTO stock (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'PRODUCT_ID':
                        $stmt->bindValue($identifier, $this->product_id, PDO::PARAM_INT);
                        break;
                    case 'AMOUNT':
                        $stmt->bindValue($identifier, $this->amount, PDO::PARAM_STR);
                        break;
                    case 'UNIT_ID':
                        $stmt->bindValue($identifier, $this->unit_id, PDO::PARAM_INT);
                        break;
                    case 'BUY':
                        $stmt->bindValue($identifier, $this->buy, PDO::PARAM_INT);
                        break;
                    case 'SELL_PUBLIC':
                        $stmt->bindValue($identifier, $this->sell_public, PDO::PARAM_INT);
                        break;
                    case 'SELL_DISTRIBUTOR':
                        $stmt->bindValue($identifier, $this->sell_distributor, PDO::PARAM_INT);
                        break;
                    case 'SELL_MISC':
                        $stmt->bindValue($identifier, $this->sell_misc, PDO::PARAM_INT);
                        break;
                    case 'DISCOUNT':
                        $stmt->bindValue($identifier, $this->discount, PDO::PARAM_STR);
                        break;
                    case 'UNLIMITED':
                        $stmt->bindValue($identifier, (int) $this->unlimited, PDO::PARAM_INT);
                        break;
                    case 'STATUS':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = StockTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getProductId();
                break;
            case 2:
                return $this->getAmount();
                break;
            case 3:
                return $this->getUnitId();
                break;
            case 4:
                return $this->getBuy();
                break;
            case 5:
                return $this->getSellPublic();
                break;
            case 6:
                return $this->getSellDistributor();
                break;
            case 7:
                return $this->getSellMisc();
                break;
            case 8:
                return $this->getDiscount();
                break;
            case 9:
                return $this->getUnlimited();
                break;
            case 10:
                return $this->getStatus();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Stock'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Stock'][$this->getPrimaryKey()] = true;
        $keys = StockTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getProductId(),
            $keys[2] => $this->getAmount(),
            $keys[3] => $this->getUnitId(),
            $keys[4] => $this->getBuy(),
            $keys[5] => $this->getSellPublic(),
            $keys[6] => $this->getSellDistributor(),
            $keys[7] => $this->getSellMisc(),
            $keys[8] => $this->getDiscount(),
            $keys[9] => $this->getUnlimited(),
            $keys[10] => $this->getStatus(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProduct) {
                $result['Product'] = $this->aProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUnit) {
                $result['Unit'] = $this->aUnit->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPurchases) {
                $result['Purchases'] = $this->collPurchases->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSaless) {
                $result['Saless'] = $this->collSaless->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\ORM\Stock
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = StockTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ORM\Stock
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setProductId($value);
                break;
            case 2:
                $this->setAmount($value);
                break;
            case 3:
                $this->setUnitId($value);
                break;
            case 4:
                $this->setBuy($value);
                break;
            case 5:
                $this->setSellPublic($value);
                break;
            case 6:
                $this->setSellDistributor($value);
                break;
            case 7:
                $this->setSellMisc($value);
                break;
            case 8:
                $this->setDiscount($value);
                break;
            case 9:
                $this->setUnlimited($value);
                break;
            case 10:
                $this->setStatus($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = StockTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProductId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAmount($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUnitId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setBuy($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSellPublic($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSellDistributor($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSellMisc($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDiscount($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setUnlimited($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setStatus($arr[$keys[10]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return $this|\ORM\Stock The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(StockTableMap::DATABASE_NAME);

        if ($this->isColumnModified(StockTableMap::COL_ID)) {
            $criteria->add(StockTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(StockTableMap::COL_PRODUCT_ID)) {
            $criteria->add(StockTableMap::COL_PRODUCT_ID, $this->product_id);
        }
        if ($this->isColumnModified(StockTableMap::COL_AMOUNT)) {
            $criteria->add(StockTableMap::COL_AMOUNT, $this->amount);
        }
        if ($this->isColumnModified(StockTableMap::COL_UNIT_ID)) {
            $criteria->add(StockTableMap::COL_UNIT_ID, $this->unit_id);
        }
        if ($this->isColumnModified(StockTableMap::COL_BUY)) {
            $criteria->add(StockTableMap::COL_BUY, $this->buy);
        }
        if ($this->isColumnModified(StockTableMap::COL_SELL_PUBLIC)) {
            $criteria->add(StockTableMap::COL_SELL_PUBLIC, $this->sell_public);
        }
        if ($this->isColumnModified(StockTableMap::COL_SELL_DISTRIBUTOR)) {
            $criteria->add(StockTableMap::COL_SELL_DISTRIBUTOR, $this->sell_distributor);
        }
        if ($this->isColumnModified(StockTableMap::COL_SELL_MISC)) {
            $criteria->add(StockTableMap::COL_SELL_MISC, $this->sell_misc);
        }
        if ($this->isColumnModified(StockTableMap::COL_DISCOUNT)) {
            $criteria->add(StockTableMap::COL_DISCOUNT, $this->discount);
        }
        if ($this->isColumnModified(StockTableMap::COL_UNLIMITED)) {
            $criteria->add(StockTableMap::COL_UNLIMITED, $this->unlimited);
        }
        if ($this->isColumnModified(StockTableMap::COL_STATUS)) {
            $criteria->add(StockTableMap::COL_STATUS, $this->status);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(StockTableMap::DATABASE_NAME);
        $criteria->add(StockTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \ORM\Stock (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProductId($this->getProductId());
        $copyObj->setAmount($this->getAmount());
        $copyObj->setUnitId($this->getUnitId());
        $copyObj->setBuy($this->getBuy());
        $copyObj->setSellPublic($this->getSellPublic());
        $copyObj->setSellDistributor($this->getSellDistributor());
        $copyObj->setSellMisc($this->getSellMisc());
        $copyObj->setDiscount($this->getDiscount());
        $copyObj->setUnlimited($this->getUnlimited());
        $copyObj->setStatus($this->getStatus());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPurchases() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPurchase($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSaless() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSales($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \ORM\Stock Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildProduct object.
     *
     * @param  ChildProduct $v
     * @return $this|\ORM\Stock The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProduct(ChildProduct $v = null)
    {
        if ($v === null) {
            $this->setProductId(NULL);
        } else {
            $this->setProductId($v->getId());
        }

        $this->aProduct = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProduct object, it will not be re-added.
        if ($v !== null) {
            $v->addStock($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProduct object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildProduct The associated ChildProduct object.
     * @throws PropelException
     */
    public function getProduct(ConnectionInterface $con = null)
    {
        if ($this->aProduct === null && (($this->product_id !== "" && $this->product_id !== null))) {
            $this->aProduct = ChildProductQuery::create()->findPk($this->product_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProduct->addStocks($this);
             */
        }

        return $this->aProduct;
    }

    /**
     * Declares an association between this object and a ChildUnit object.
     *
     * @param  ChildUnit $v
     * @return $this|\ORM\Stock The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUnit(ChildUnit $v = null)
    {
        if ($v === null) {
            $this->setUnitId(NULL);
        } else {
            $this->setUnitId($v->getId());
        }

        $this->aUnit = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUnit object, it will not be re-added.
        if ($v !== null) {
            $v->addStock($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUnit object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUnit The associated ChildUnit object.
     * @throws PropelException
     */
    public function getUnit(ConnectionInterface $con = null)
    {
        if ($this->aUnit === null && (($this->unit_id !== "" && $this->unit_id !== null))) {
            $this->aUnit = ChildUnitQuery::create()->findPk($this->unit_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUnit->addStocks($this);
             */
        }

        return $this->aUnit;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Purchase' == $relationName) {
            return $this->initPurchases();
        }
        if ('Sales' == $relationName) {
            return $this->initSaless();
        }
    }

    /**
     * Clears out the collPurchases collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPurchases()
     */
    public function clearPurchases()
    {
        $this->collPurchases = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPurchases collection loaded partially.
     */
    public function resetPartialPurchases($v = true)
    {
        $this->collPurchasesPartial = $v;
    }

    /**
     * Initializes the collPurchases collection.
     *
     * By default this just sets the collPurchases collection to an empty array (like clearcollPurchases());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPurchases($overrideExisting = true)
    {
        if (null !== $this->collPurchases && !$overrideExisting) {
            return;
        }
        $this->collPurchases = new ObjectCollection();
        $this->collPurchases->setModel('\ORM\PurchaseDetail');
    }

    /**
     * Gets an array of ChildPurchaseDetail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildStock is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPurchaseDetail[] List of ChildPurchaseDetail objects
     * @throws PropelException
     */
    public function getPurchases(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchasesPartial && !$this->isNew();
        if (null === $this->collPurchases || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPurchases) {
                // return empty collection
                $this->initPurchases();
            } else {
                $collPurchases = ChildPurchaseDetailQuery::create(null, $criteria)
                    ->filterByStock($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPurchasesPartial && count($collPurchases)) {
                        $this->initPurchases(false);

                        foreach ($collPurchases as $obj) {
                            if (false == $this->collPurchases->contains($obj)) {
                                $this->collPurchases->append($obj);
                            }
                        }

                        $this->collPurchasesPartial = true;
                    }

                    return $collPurchases;
                }

                if ($partial && $this->collPurchases) {
                    foreach ($this->collPurchases as $obj) {
                        if ($obj->isNew()) {
                            $collPurchases[] = $obj;
                        }
                    }
                }

                $this->collPurchases = $collPurchases;
                $this->collPurchasesPartial = false;
            }
        }

        return $this->collPurchases;
    }

    /**
     * Sets a collection of ChildPurchaseDetail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $purchases A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildStock The current object (for fluent API support)
     */
    public function setPurchases(Collection $purchases, ConnectionInterface $con = null)
    {
        /** @var ChildPurchaseDetail[] $purchasesToDelete */
        $purchasesToDelete = $this->getPurchases(new Criteria(), $con)->diff($purchases);


        $this->purchasesScheduledForDeletion = $purchasesToDelete;

        foreach ($purchasesToDelete as $purchaseRemoved) {
            $purchaseRemoved->setStock(null);
        }

        $this->collPurchases = null;
        foreach ($purchases as $purchase) {
            $this->addPurchase($purchase);
        }

        $this->collPurchases = $purchases;
        $this->collPurchasesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PurchaseDetail objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PurchaseDetail objects.
     * @throws PropelException
     */
    public function countPurchases(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchasesPartial && !$this->isNew();
        if (null === $this->collPurchases || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPurchases) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPurchases());
            }

            $query = ChildPurchaseDetailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStock($this)
                ->count($con);
        }

        return count($this->collPurchases);
    }

    /**
     * Method called to associate a ChildPurchaseDetail object to this object
     * through the ChildPurchaseDetail foreign key attribute.
     *
     * @param  ChildPurchaseDetail $l ChildPurchaseDetail
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function addPurchase(ChildPurchaseDetail $l)
    {
        if ($this->collPurchases === null) {
            $this->initPurchases();
            $this->collPurchasesPartial = true;
        }

        if (!$this->collPurchases->contains($l)) {
            $this->doAddPurchase($l);
        }

        return $this;
    }

    /**
     * @param ChildPurchaseDetail $purchase The ChildPurchaseDetail object to add.
     */
    protected function doAddPurchase(ChildPurchaseDetail $purchase)
    {
        $this->collPurchases[]= $purchase;
        $purchase->setStock($this);
    }

    /**
     * @param  ChildPurchaseDetail $purchase The ChildPurchaseDetail object to remove.
     * @return $this|ChildStock The current object (for fluent API support)
     */
    public function removePurchase(ChildPurchaseDetail $purchase)
    {
        if ($this->getPurchases()->contains($purchase)) {
            $pos = $this->collPurchases->search($purchase);
            $this->collPurchases->remove($pos);
            if (null === $this->purchasesScheduledForDeletion) {
                $this->purchasesScheduledForDeletion = clone $this->collPurchases;
                $this->purchasesScheduledForDeletion->clear();
            }
            $this->purchasesScheduledForDeletion[]= $purchase;
            $purchase->setStock(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Stock is new, it will return
     * an empty collection; or if this Stock has previously
     * been saved, it will retrieve related Purchases from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Stock.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPurchaseDetail[] List of ChildPurchaseDetail objects
     */
    public function getPurchasesJoinPurchase(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPurchaseDetailQuery::create(null, $criteria);
        $query->joinWith('Purchase', $joinBehavior);

        return $this->getPurchases($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Stock is new, it will return
     * an empty collection; or if this Stock has previously
     * been saved, it will retrieve related Purchases from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Stock.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPurchaseDetail[] List of ChildPurchaseDetail objects
     */
    public function getPurchasesJoinNotification(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPurchaseDetailQuery::create(null, $criteria);
        $query->joinWith('Notification', $joinBehavior);

        return $this->getPurchases($query, $con);
    }

    /**
     * Clears out the collSaless collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSaless()
     */
    public function clearSaless()
    {
        $this->collSaless = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSaless collection loaded partially.
     */
    public function resetPartialSaless($v = true)
    {
        $this->collSalessPartial = $v;
    }

    /**
     * Initializes the collSaless collection.
     *
     * By default this just sets the collSaless collection to an empty array (like clearcollSaless());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSaless($overrideExisting = true)
    {
        if (null !== $this->collSaless && !$overrideExisting) {
            return;
        }
        $this->collSaless = new ObjectCollection();
        $this->collSaless->setModel('\ORM\SalesDetail');
    }

    /**
     * Gets an array of ChildSalesDetail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildStock is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSalesDetail[] List of ChildSalesDetail objects
     * @throws PropelException
     */
    public function getSaless(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSalessPartial && !$this->isNew();
        if (null === $this->collSaless || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSaless) {
                // return empty collection
                $this->initSaless();
            } else {
                $collSaless = ChildSalesDetailQuery::create(null, $criteria)
                    ->filterByStock($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSalessPartial && count($collSaless)) {
                        $this->initSaless(false);

                        foreach ($collSaless as $obj) {
                            if (false == $this->collSaless->contains($obj)) {
                                $this->collSaless->append($obj);
                            }
                        }

                        $this->collSalessPartial = true;
                    }

                    return $collSaless;
                }

                if ($partial && $this->collSaless) {
                    foreach ($this->collSaless as $obj) {
                        if ($obj->isNew()) {
                            $collSaless[] = $obj;
                        }
                    }
                }

                $this->collSaless = $collSaless;
                $this->collSalessPartial = false;
            }
        }

        return $this->collSaless;
    }

    /**
     * Sets a collection of ChildSalesDetail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $saless A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildStock The current object (for fluent API support)
     */
    public function setSaless(Collection $saless, ConnectionInterface $con = null)
    {
        /** @var ChildSalesDetail[] $salessToDelete */
        $salessToDelete = $this->getSaless(new Criteria(), $con)->diff($saless);


        $this->salessScheduledForDeletion = $salessToDelete;

        foreach ($salessToDelete as $salesRemoved) {
            $salesRemoved->setStock(null);
        }

        $this->collSaless = null;
        foreach ($saless as $sales) {
            $this->addSales($sales);
        }

        $this->collSaless = $saless;
        $this->collSalessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SalesDetail objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SalesDetail objects.
     * @throws PropelException
     */
    public function countSaless(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSalessPartial && !$this->isNew();
        if (null === $this->collSaless || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSaless) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSaless());
            }

            $query = ChildSalesDetailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStock($this)
                ->count($con);
        }

        return count($this->collSaless);
    }

    /**
     * Method called to associate a ChildSalesDetail object to this object
     * through the ChildSalesDetail foreign key attribute.
     *
     * @param  ChildSalesDetail $l ChildSalesDetail
     * @return $this|\ORM\Stock The current object (for fluent API support)
     */
    public function addSales(ChildSalesDetail $l)
    {
        if ($this->collSaless === null) {
            $this->initSaless();
            $this->collSalessPartial = true;
        }

        if (!$this->collSaless->contains($l)) {
            $this->doAddSales($l);
        }

        return $this;
    }

    /**
     * @param ChildSalesDetail $sales The ChildSalesDetail object to add.
     */
    protected function doAddSales(ChildSalesDetail $sales)
    {
        $this->collSaless[]= $sales;
        $sales->setStock($this);
    }

    /**
     * @param  ChildSalesDetail $sales The ChildSalesDetail object to remove.
     * @return $this|ChildStock The current object (for fluent API support)
     */
    public function removeSales(ChildSalesDetail $sales)
    {
        if ($this->getSaless()->contains($sales)) {
            $pos = $this->collSaless->search($sales);
            $this->collSaless->remove($pos);
            if (null === $this->salessScheduledForDeletion) {
                $this->salessScheduledForDeletion = clone $this->collSaless;
                $this->salessScheduledForDeletion->clear();
            }
            $this->salessScheduledForDeletion[]= $sales;
            $sales->setStock(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Stock is new, it will return
     * an empty collection; or if this Stock has previously
     * been saved, it will retrieve related Saless from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Stock.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSalesDetail[] List of ChildSalesDetail objects
     */
    public function getSalessJoinSales(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSalesDetailQuery::create(null, $criteria);
        $query->joinWith('Sales', $joinBehavior);

        return $this->getSaless($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aProduct) {
            $this->aProduct->removeStock($this);
        }
        if (null !== $this->aUnit) {
            $this->aUnit->removeStock($this);
        }
        $this->id = null;
        $this->product_id = null;
        $this->amount = null;
        $this->unit_id = null;
        $this->buy = null;
        $this->sell_public = null;
        $this->sell_distributor = null;
        $this->sell_misc = null;
        $this->discount = null;
        $this->unlimited = null;
        $this->status = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPurchases) {
                foreach ($this->collPurchases as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSaless) {
                foreach ($this->collSaless as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPurchases = null;
        $this->collSaless = null;
        $this->aProduct = null;
        $this->aUnit = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StockTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
