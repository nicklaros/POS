<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\Sales as ChildSales;
use ORM\SalesDetailQuery as ChildSalesDetailQuery;
use ORM\SalesQuery as ChildSalesQuery;
use ORM\Stock as ChildStock;
use ORM\StockQuery as ChildStockQuery;
use ORM\Map\SalesDetailTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class SalesDetail implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ORM\\Map\\SalesDetailTableMap';


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
     * The value for the sales_id field.
     * @var        string
     */
    protected $sales_id;

    /**
     * The value for the type field.
     * @var        string
     */
    protected $type;

    /**
     * The value for the stock_id field.
     * @var        string
     */
    protected $stock_id;

    /**
     * The value for the amount field.
     * @var        string
     */
    protected $amount;

    /**
     * The value for the unit_price field.
     * @var        int
     */
    protected $unit_price;

    /**
     * The value for the discount field.
     * @var        string
     */
    protected $discount;

    /**
     * The value for the total_price field.
     * @var        int
     */
    protected $total_price;

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
     * The value for the status field.
     * @var        string
     */
    protected $status;

    /**
     * @var        ChildSales
     */
    protected $aSales;

    /**
     * @var        ChildStock
     */
    protected $aStock;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of ORM\Base\SalesDetail object.
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
     * Compares this with another <code>SalesDetail</code> instance.  If
     * <code>obj</code> is an instance of <code>SalesDetail</code>, delegates to
     * <code>equals(SalesDetail)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SalesDetail The current object, for fluid interface
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
     * Get the [sales_id] column value.
     *
     * @return string
     */
    public function getSalesId()
    {
        return $this->sales_id;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [stock_id] column value.
     *
     * @return string
     */
    public function getStockId()
    {
        return $this->stock_id;
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
     * Get the [unit_price] column value.
     *
     * @return int
     */
    public function getUnitPrice()
    {
        return $this->unit_price;
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
     * Get the [total_price] column value.
     *
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->total_price;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SalesDetailTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SalesDetailTableMap::translateFieldName('SalesId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sales_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SalesDetailTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SalesDetailTableMap::translateFieldName('StockId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stock_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SalesDetailTableMap::translateFieldName('Amount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SalesDetailTableMap::translateFieldName('UnitPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unit_price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SalesDetailTableMap::translateFieldName('Discount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SalesDetailTableMap::translateFieldName('TotalPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->total_price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SalesDetailTableMap::translateFieldName('Buy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buy = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SalesDetailTableMap::translateFieldName('SellPublic', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_public = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SalesDetailTableMap::translateFieldName('SellDistributor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_distributor = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SalesDetailTableMap::translateFieldName('SellMisc', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_misc = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SalesDetailTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = SalesDetailTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ORM\\SalesDetail'), 0, $e);
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
        if ($this->aSales !== null && $this->sales_id !== $this->aSales->getId()) {
            $this->aSales = null;
        }
        if ($this->aStock !== null && $this->stock_id !== $this->aStock->getId()) {
            $this->aStock = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [sales_id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setSalesId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sales_id !== $v) {
            $this->sales_id = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_SALES_ID] = true;
        }

        if ($this->aSales !== null && $this->aSales->getId() !== $v) {
            $this->aSales = null;
        }

        return $this;
    } // setSalesId()

    /**
     * Set the value of [type] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [stock_id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setStockId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stock_id !== $v) {
            $this->stock_id = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_STOCK_ID] = true;
        }

        if ($this->aStock !== null && $this->aStock->getId() !== $v) {
            $this->aStock = null;
        }

        return $this;
    } // setStockId()

    /**
     * Set the value of [amount] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->amount !== $v) {
            $this->amount = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_AMOUNT] = true;
        }

        return $this;
    } // setAmount()

    /**
     * Set the value of [unit_price] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setUnitPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->unit_price !== $v) {
            $this->unit_price = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_UNIT_PRICE] = true;
        }

        return $this;
    } // setUnitPrice()

    /**
     * Set the value of [discount] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setDiscount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discount !== $v) {
            $this->discount = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_DISCOUNT] = true;
        }

        return $this;
    } // setDiscount()

    /**
     * Set the value of [total_price] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setTotalPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->total_price !== $v) {
            $this->total_price = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_TOTAL_PRICE] = true;
        }

        return $this;
    } // setTotalPrice()

    /**
     * Set the value of [buy] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setBuy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->buy !== $v) {
            $this->buy = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_BUY] = true;
        }

        return $this;
    } // setBuy()

    /**
     * Set the value of [sell_public] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setSellPublic($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_public !== $v) {
            $this->sell_public = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_SELL_PUBLIC] = true;
        }

        return $this;
    } // setSellPublic()

    /**
     * Set the value of [sell_distributor] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setSellDistributor($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_distributor !== $v) {
            $this->sell_distributor = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_SELL_DISTRIBUTOR] = true;
        }

        return $this;
    } // setSellDistributor()

    /**
     * Set the value of [sell_misc] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setSellMisc($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_misc !== $v) {
            $this->sell_misc = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_SELL_MISC] = true;
        }

        return $this;
    } // setSellMisc()

    /**
     * Set the value of [status] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[SalesDetailTableMap::COL_STATUS] = true;
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
            $con = Propel::getServiceContainer()->getReadConnection(SalesDetailTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSalesDetailQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSales = null;
            $this->aStock = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SalesDetail::setDeleted()
     * @see SalesDetail::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SalesDetailTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSalesDetailQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SalesDetailTableMap::DATABASE_NAME);
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
                SalesDetailTableMap::addInstanceToPool($this);
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

            if ($this->aSales !== null) {
                if ($this->aSales->isModified() || $this->aSales->isNew()) {
                    $affectedRows += $this->aSales->save($con);
                }
                $this->setSales($this->aSales);
            }

            if ($this->aStock !== null) {
                if ($this->aStock->isModified() || $this->aStock->isNew()) {
                    $affectedRows += $this->aStock->save($con);
                }
                $this->setStock($this->aStock);
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

        $this->modifiedColumns[SalesDetailTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SalesDetailTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SalesDetailTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_SALES_ID)) {
            $modifiedColumns[':p' . $index++]  = 'SALES_ID';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'TYPE';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_STOCK_ID)) {
            $modifiedColumns[':p' . $index++]  = 'STOCK_ID';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'AMOUNT';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_UNIT_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'UNIT_PRICE';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_DISCOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'DISCOUNT';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_TOTAL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'TOTAL_PRICE';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_BUY)) {
            $modifiedColumns[':p' . $index++]  = 'BUY';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_SELL_PUBLIC)) {
            $modifiedColumns[':p' . $index++]  = 'SELL_PUBLIC';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_SELL_DISTRIBUTOR)) {
            $modifiedColumns[':p' . $index++]  = 'SELL_DISTRIBUTOR';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_SELL_MISC)) {
            $modifiedColumns[':p' . $index++]  = 'SELL_MISC';
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'STATUS';
        }

        $sql = sprintf(
            'INSERT INTO sales_detail (%s) VALUES (%s)',
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
                    case 'SALES_ID':
                        $stmt->bindValue($identifier, $this->sales_id, PDO::PARAM_INT);
                        break;
                    case 'TYPE':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case 'STOCK_ID':
                        $stmt->bindValue($identifier, $this->stock_id, PDO::PARAM_INT);
                        break;
                    case 'AMOUNT':
                        $stmt->bindValue($identifier, $this->amount, PDO::PARAM_STR);
                        break;
                    case 'UNIT_PRICE':
                        $stmt->bindValue($identifier, $this->unit_price, PDO::PARAM_INT);
                        break;
                    case 'DISCOUNT':
                        $stmt->bindValue($identifier, $this->discount, PDO::PARAM_STR);
                        break;
                    case 'TOTAL_PRICE':
                        $stmt->bindValue($identifier, $this->total_price, PDO::PARAM_INT);
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
        $pos = SalesDetailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSalesId();
                break;
            case 2:
                return $this->getType();
                break;
            case 3:
                return $this->getStockId();
                break;
            case 4:
                return $this->getAmount();
                break;
            case 5:
                return $this->getUnitPrice();
                break;
            case 6:
                return $this->getDiscount();
                break;
            case 7:
                return $this->getTotalPrice();
                break;
            case 8:
                return $this->getBuy();
                break;
            case 9:
                return $this->getSellPublic();
                break;
            case 10:
                return $this->getSellDistributor();
                break;
            case 11:
                return $this->getSellMisc();
                break;
            case 12:
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
        if (isset($alreadyDumpedObjects['SalesDetail'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SalesDetail'][$this->getPrimaryKey()] = true;
        $keys = SalesDetailTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getSalesId(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getStockId(),
            $keys[4] => $this->getAmount(),
            $keys[5] => $this->getUnitPrice(),
            $keys[6] => $this->getDiscount(),
            $keys[7] => $this->getTotalPrice(),
            $keys[8] => $this->getBuy(),
            $keys[9] => $this->getSellPublic(),
            $keys[10] => $this->getSellDistributor(),
            $keys[11] => $this->getSellMisc(),
            $keys[12] => $this->getStatus(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSales) {
                $result['Sales'] = $this->aSales->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aStock) {
                $result['Stock'] = $this->aStock->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\ORM\SalesDetail
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SalesDetailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ORM\SalesDetail
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setSalesId($value);
                break;
            case 2:
                $this->setType($value);
                break;
            case 3:
                $this->setStockId($value);
                break;
            case 4:
                $this->setAmount($value);
                break;
            case 5:
                $this->setUnitPrice($value);
                break;
            case 6:
                $this->setDiscount($value);
                break;
            case 7:
                $this->setTotalPrice($value);
                break;
            case 8:
                $this->setBuy($value);
                break;
            case 9:
                $this->setSellPublic($value);
                break;
            case 10:
                $this->setSellDistributor($value);
                break;
            case 11:
                $this->setSellMisc($value);
                break;
            case 12:
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
        $keys = SalesDetailTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSalesId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setStockId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setAmount($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUnitPrice($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDiscount($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setTotalPrice($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setBuy($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setSellPublic($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setSellDistributor($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setSellMisc($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setStatus($arr[$keys[12]]);
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
     * @return $this|\ORM\SalesDetail The current object, for fluid interface
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
        $criteria = new Criteria(SalesDetailTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SalesDetailTableMap::COL_ID)) {
            $criteria->add(SalesDetailTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_SALES_ID)) {
            $criteria->add(SalesDetailTableMap::COL_SALES_ID, $this->sales_id);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_TYPE)) {
            $criteria->add(SalesDetailTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_STOCK_ID)) {
            $criteria->add(SalesDetailTableMap::COL_STOCK_ID, $this->stock_id);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_AMOUNT)) {
            $criteria->add(SalesDetailTableMap::COL_AMOUNT, $this->amount);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_UNIT_PRICE)) {
            $criteria->add(SalesDetailTableMap::COL_UNIT_PRICE, $this->unit_price);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_DISCOUNT)) {
            $criteria->add(SalesDetailTableMap::COL_DISCOUNT, $this->discount);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_TOTAL_PRICE)) {
            $criteria->add(SalesDetailTableMap::COL_TOTAL_PRICE, $this->total_price);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_BUY)) {
            $criteria->add(SalesDetailTableMap::COL_BUY, $this->buy);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_SELL_PUBLIC)) {
            $criteria->add(SalesDetailTableMap::COL_SELL_PUBLIC, $this->sell_public);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_SELL_DISTRIBUTOR)) {
            $criteria->add(SalesDetailTableMap::COL_SELL_DISTRIBUTOR, $this->sell_distributor);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_SELL_MISC)) {
            $criteria->add(SalesDetailTableMap::COL_SELL_MISC, $this->sell_misc);
        }
        if ($this->isColumnModified(SalesDetailTableMap::COL_STATUS)) {
            $criteria->add(SalesDetailTableMap::COL_STATUS, $this->status);
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
        $criteria = new Criteria(SalesDetailTableMap::DATABASE_NAME);
        $criteria->add(SalesDetailTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ORM\SalesDetail (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSalesId($this->getSalesId());
        $copyObj->setType($this->getType());
        $copyObj->setStockId($this->getStockId());
        $copyObj->setAmount($this->getAmount());
        $copyObj->setUnitPrice($this->getUnitPrice());
        $copyObj->setDiscount($this->getDiscount());
        $copyObj->setTotalPrice($this->getTotalPrice());
        $copyObj->setBuy($this->getBuy());
        $copyObj->setSellPublic($this->getSellPublic());
        $copyObj->setSellDistributor($this->getSellDistributor());
        $copyObj->setSellMisc($this->getSellMisc());
        $copyObj->setStatus($this->getStatus());
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
     * @return \ORM\SalesDetail Clone of current object.
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
     * Declares an association between this object and a ChildSales object.
     *
     * @param  ChildSales $v
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSales(ChildSales $v = null)
    {
        if ($v === null) {
            $this->setSalesId(NULL);
        } else {
            $this->setSalesId($v->getId());
        }

        $this->aSales = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSales object, it will not be re-added.
        if ($v !== null) {
            $v->addDetail($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSales object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSales The associated ChildSales object.
     * @throws PropelException
     */
    public function getSales(ConnectionInterface $con = null)
    {
        if ($this->aSales === null && (($this->sales_id !== "" && $this->sales_id !== null))) {
            $this->aSales = ChildSalesQuery::create()->findPk($this->sales_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSales->addDetails($this);
             */
        }

        return $this->aSales;
    }

    /**
     * Declares an association between this object and a ChildStock object.
     *
     * @param  ChildStock $v
     * @return $this|\ORM\SalesDetail The current object (for fluent API support)
     * @throws PropelException
     */
    public function setStock(ChildStock $v = null)
    {
        if ($v === null) {
            $this->setStockId(NULL);
        } else {
            $this->setStockId($v->getId());
        }

        $this->aStock = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildStock object, it will not be re-added.
        if ($v !== null) {
            $v->addSales($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildStock object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildStock The associated ChildStock object.
     * @throws PropelException
     */
    public function getStock(ConnectionInterface $con = null)
    {
        if ($this->aStock === null && (($this->stock_id !== "" && $this->stock_id !== null))) {
            $this->aStock = ChildStockQuery::create()->findPk($this->stock_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aStock->addSaless($this);
             */
        }

        return $this->aStock;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSales) {
            $this->aSales->removeDetail($this);
        }
        if (null !== $this->aStock) {
            $this->aStock->removeSales($this);
        }
        $this->id = null;
        $this->sales_id = null;
        $this->type = null;
        $this->stock_id = null;
        $this->amount = null;
        $this->unit_price = null;
        $this->discount = null;
        $this->total_price = null;
        $this->buy = null;
        $this->sell_public = null;
        $this->sell_distributor = null;
        $this->sell_misc = null;
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
        } // if ($deep)

        $this->aSales = null;
        $this->aStock = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SalesDetailTableMap::DEFAULT_STRING_FORMAT);
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
