<?php

namespace ORM\Base;

use \DateTime;
use \Exception;
use \PDO;
use ORM\Credit as ChildCredit;
use ORM\CreditQuery as ChildCreditQuery;
use ORM\Sales as ChildSales;
use ORM\SalesDetail as ChildSalesDetail;
use ORM\SalesDetailQuery as ChildSalesDetailQuery;
use ORM\SalesHistory as ChildSalesHistory;
use ORM\SalesHistoryQuery as ChildSalesHistoryQuery;
use ORM\SalesQuery as ChildSalesQuery;
use ORM\SecondParty as ChildSecondParty;
use ORM\SecondPartyQuery as ChildSecondPartyQuery;
use ORM\UserDetail as ChildUserDetail;
use ORM\UserDetailQuery as ChildUserDetailQuery;
use ORM\Map\SalesTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

abstract class Sales implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ORM\\Map\\SalesTableMap';


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
     * The value for the date field.
     * @var        \DateTime
     */
    protected $date;

    /**
     * The value for the second_party_id field.
     * @var        string
     */
    protected $second_party_id;

    /**
     * The value for the buy_price field.
     * @var        int
     */
    protected $buy_price;

    /**
     * The value for the total_price field.
     * @var        int
     */
    protected $total_price;

    /**
     * The value for the paid field.
     * @var        int
     */
    protected $paid;

    /**
     * The value for the cashier_id field.
     * @var        string
     */
    protected $cashier_id;

    /**
     * The value for the note field.
     * @var        string
     */
    protected $note;

    /**
     * The value for the status field.
     * @var        string
     */
    protected $status;

    /**
     * @var        ChildSecondParty
     */
    protected $aSecondParty;

    /**
     * @var        ChildUserDetail
     */
    protected $aCashier;

    /**
     * @var        ObjectCollection|ChildCredit[] Collection to store aggregation of ChildCredit objects.
     */
    protected $collCredits;
    protected $collCreditsPartial;

    /**
     * @var        ObjectCollection|ChildSalesDetail[] Collection to store aggregation of ChildSalesDetail objects.
     */
    protected $collDetails;
    protected $collDetailsPartial;

    /**
     * @var        ObjectCollection|ChildSalesHistory[] Collection to store aggregation of ChildSalesHistory objects.
     */
    protected $collHistories;
    protected $collHistoriesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCredit[]
     */
    protected $creditsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSalesDetail[]
     */
    protected $detailsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSalesHistory[]
     */
    protected $historiesScheduledForDeletion = null;

    /**
     * Initializes internal state of ORM\Base\Sales object.
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
     * Compares this with another <code>Sales</code> instance.  If
     * <code>obj</code> is an instance of <code>Sales</code>, delegates to
     * <code>equals(Sales)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Sales The current object, for fluid interface
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
     * Get the [optionally formatted] temporal [date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return string|\DateTime Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = NULL)
    {
        if ($format === null) {
            return $this->date;
        } else {
            return $this->date instanceof \DateTime ? $this->date->format($format) : null;
        }
    }

    /**
     * Get the [second_party_id] column value.
     *
     * @return string
     */
    public function getSecondPartyId()
    {
        return $this->second_party_id;
    }

    /**
     * Get the [buy_price] column value.
     *
     * @return int
     */
    public function getBuyPrice()
    {
        return $this->buy_price;
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
     * Get the [paid] column value.
     *
     * @return int
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Get the [cashier_id] column value.
     *
     * @return string
     */
    public function getCashierId()
    {
        return $this->cashier_id;
    }

    /**
     * Get the [note] column value.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SalesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SalesTableMap::translateFieldName('Date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SalesTableMap::translateFieldName('SecondPartyId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->second_party_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SalesTableMap::translateFieldName('BuyPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buy_price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SalesTableMap::translateFieldName('TotalPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->total_price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SalesTableMap::translateFieldName('Paid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->paid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SalesTableMap::translateFieldName('CashierId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cashier_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SalesTableMap::translateFieldName('Note', TableMap::TYPE_PHPNAME, $indexType)];
            $this->note = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SalesTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = SalesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ORM\\Sales'), 0, $e);
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
        if ($this->aSecondParty !== null && $this->second_party_id !== $this->aSecondParty->getId()) {
            $this->aSecondParty = null;
        }
        if ($this->aCashier !== null && $this->cashier_id !== $this->aCashier->getId()) {
            $this->aCashier = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SalesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->date !== null || $dt !== null) {
            if ($dt !== $this->date) {
                $this->date = $dt;
                $this->modifiedColumns[SalesTableMap::COL_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setDate()

    /**
     * Set the value of [second_party_id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setSecondPartyId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->second_party_id !== $v) {
            $this->second_party_id = $v;
            $this->modifiedColumns[SalesTableMap::COL_SECOND_PARTY_ID] = true;
        }

        if ($this->aSecondParty !== null && $this->aSecondParty->getId() !== $v) {
            $this->aSecondParty = null;
        }

        return $this;
    } // setSecondPartyId()

    /**
     * Set the value of [buy_price] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setBuyPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->buy_price !== $v) {
            $this->buy_price = $v;
            $this->modifiedColumns[SalesTableMap::COL_BUY_PRICE] = true;
        }

        return $this;
    } // setBuyPrice()

    /**
     * Set the value of [total_price] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setTotalPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->total_price !== $v) {
            $this->total_price = $v;
            $this->modifiedColumns[SalesTableMap::COL_TOTAL_PRICE] = true;
        }

        return $this;
    } // setTotalPrice()

    /**
     * Set the value of [paid] column.
     *
     * @param  int $v new value
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setPaid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->paid !== $v) {
            $this->paid = $v;
            $this->modifiedColumns[SalesTableMap::COL_PAID] = true;
        }

        return $this;
    } // setPaid()

    /**
     * Set the value of [cashier_id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setCashierId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cashier_id !== $v) {
            $this->cashier_id = $v;
            $this->modifiedColumns[SalesTableMap::COL_CASHIER_ID] = true;
        }

        if ($this->aCashier !== null && $this->aCashier->getId() !== $v) {
            $this->aCashier = null;
        }

        return $this;
    } // setCashierId()

    /**
     * Set the value of [note] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->note !== $v) {
            $this->note = $v;
            $this->modifiedColumns[SalesTableMap::COL_NOTE] = true;
        }

        return $this;
    } // setNote()

    /**
     * Set the value of [status] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[SalesTableMap::COL_STATUS] = true;
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
            $con = Propel::getServiceContainer()->getReadConnection(SalesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSalesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSecondParty = null;
            $this->aCashier = null;
            $this->collCredits = null;

            $this->collDetails = null;

            $this->collHistories = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Sales::setDeleted()
     * @see Sales::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SalesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSalesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SalesTableMap::DATABASE_NAME);
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
                SalesTableMap::addInstanceToPool($this);
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

            if ($this->aSecondParty !== null) {
                if ($this->aSecondParty->isModified() || $this->aSecondParty->isNew()) {
                    $affectedRows += $this->aSecondParty->save($con);
                }
                $this->setSecondParty($this->aSecondParty);
            }

            if ($this->aCashier !== null) {
                if ($this->aCashier->isModified() || $this->aCashier->isNew()) {
                    $affectedRows += $this->aCashier->save($con);
                }
                $this->setCashier($this->aCashier);
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

            if ($this->creditsScheduledForDeletion !== null) {
                if (!$this->creditsScheduledForDeletion->isEmpty()) {
                    \ORM\CreditQuery::create()
                        ->filterByPrimaryKeys($this->creditsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->creditsScheduledForDeletion = null;
                }
            }

            if ($this->collCredits !== null) {
                foreach ($this->collCredits as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->detailsScheduledForDeletion !== null) {
                if (!$this->detailsScheduledForDeletion->isEmpty()) {
                    \ORM\SalesDetailQuery::create()
                        ->filterByPrimaryKeys($this->detailsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->detailsScheduledForDeletion = null;
                }
            }

            if ($this->collDetails !== null) {
                foreach ($this->collDetails as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->historiesScheduledForDeletion !== null) {
                if (!$this->historiesScheduledForDeletion->isEmpty()) {
                    foreach ($this->historiesScheduledForDeletion as $history) {
                        // need to save related object because we set the relation to null
                        $history->save($con);
                    }
                    $this->historiesScheduledForDeletion = null;
                }
            }

            if ($this->collHistories !== null) {
                foreach ($this->collHistories as $referrerFK) {
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

        $this->modifiedColumns[SalesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SalesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SalesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(SalesTableMap::COL_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'DATE';
        }
        if ($this->isColumnModified(SalesTableMap::COL_SECOND_PARTY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'SECOND_PARTY_ID';
        }
        if ($this->isColumnModified(SalesTableMap::COL_BUY_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'BUY_PRICE';
        }
        if ($this->isColumnModified(SalesTableMap::COL_TOTAL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'TOTAL_PRICE';
        }
        if ($this->isColumnModified(SalesTableMap::COL_PAID)) {
            $modifiedColumns[':p' . $index++]  = 'PAID';
        }
        if ($this->isColumnModified(SalesTableMap::COL_CASHIER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CASHIER_ID';
        }
        if ($this->isColumnModified(SalesTableMap::COL_NOTE)) {
            $modifiedColumns[':p' . $index++]  = 'NOTE';
        }
        if ($this->isColumnModified(SalesTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'STATUS';
        }

        $sql = sprintf(
            'INSERT INTO sales (%s) VALUES (%s)',
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
                    case 'DATE':
                        $stmt->bindValue($identifier, $this->date ? $this->date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'SECOND_PARTY_ID':
                        $stmt->bindValue($identifier, $this->second_party_id, PDO::PARAM_INT);
                        break;
                    case 'BUY_PRICE':
                        $stmt->bindValue($identifier, $this->buy_price, PDO::PARAM_INT);
                        break;
                    case 'TOTAL_PRICE':
                        $stmt->bindValue($identifier, $this->total_price, PDO::PARAM_INT);
                        break;
                    case 'PAID':
                        $stmt->bindValue($identifier, $this->paid, PDO::PARAM_INT);
                        break;
                    case 'CASHIER_ID':
                        $stmt->bindValue($identifier, $this->cashier_id, PDO::PARAM_INT);
                        break;
                    case 'NOTE':
                        $stmt->bindValue($identifier, $this->note, PDO::PARAM_STR);
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
        $pos = SalesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDate();
                break;
            case 2:
                return $this->getSecondPartyId();
                break;
            case 3:
                return $this->getBuyPrice();
                break;
            case 4:
                return $this->getTotalPrice();
                break;
            case 5:
                return $this->getPaid();
                break;
            case 6:
                return $this->getCashierId();
                break;
            case 7:
                return $this->getNote();
                break;
            case 8:
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
        if (isset($alreadyDumpedObjects['Sales'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Sales'][$this->getPrimaryKey()] = true;
        $keys = SalesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDate(),
            $keys[2] => $this->getSecondPartyId(),
            $keys[3] => $this->getBuyPrice(),
            $keys[4] => $this->getTotalPrice(),
            $keys[5] => $this->getPaid(),
            $keys[6] => $this->getCashierId(),
            $keys[7] => $this->getNote(),
            $keys[8] => $this->getStatus(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSecondParty) {
                $result['SecondParty'] = $this->aSecondParty->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCashier) {
                $result['Cashier'] = $this->aCashier->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCredits) {
                $result['Credits'] = $this->collCredits->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDetails) {
                $result['Details'] = $this->collDetails->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collHistories) {
                $result['Histories'] = $this->collHistories->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\ORM\Sales
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SalesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ORM\Sales
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDate($value);
                break;
            case 2:
                $this->setSecondPartyId($value);
                break;
            case 3:
                $this->setBuyPrice($value);
                break;
            case 4:
                $this->setTotalPrice($value);
                break;
            case 5:
                $this->setPaid($value);
                break;
            case 6:
                $this->setCashierId($value);
                break;
            case 7:
                $this->setNote($value);
                break;
            case 8:
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
        $keys = SalesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDate($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSecondPartyId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setBuyPrice($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTotalPrice($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPaid($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCashierId($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setNote($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setStatus($arr[$keys[8]]);
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
     * @return $this|\ORM\Sales The current object, for fluid interface
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
        $criteria = new Criteria(SalesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SalesTableMap::COL_ID)) {
            $criteria->add(SalesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SalesTableMap::COL_DATE)) {
            $criteria->add(SalesTableMap::COL_DATE, $this->date);
        }
        if ($this->isColumnModified(SalesTableMap::COL_SECOND_PARTY_ID)) {
            $criteria->add(SalesTableMap::COL_SECOND_PARTY_ID, $this->second_party_id);
        }
        if ($this->isColumnModified(SalesTableMap::COL_BUY_PRICE)) {
            $criteria->add(SalesTableMap::COL_BUY_PRICE, $this->buy_price);
        }
        if ($this->isColumnModified(SalesTableMap::COL_TOTAL_PRICE)) {
            $criteria->add(SalesTableMap::COL_TOTAL_PRICE, $this->total_price);
        }
        if ($this->isColumnModified(SalesTableMap::COL_PAID)) {
            $criteria->add(SalesTableMap::COL_PAID, $this->paid);
        }
        if ($this->isColumnModified(SalesTableMap::COL_CASHIER_ID)) {
            $criteria->add(SalesTableMap::COL_CASHIER_ID, $this->cashier_id);
        }
        if ($this->isColumnModified(SalesTableMap::COL_NOTE)) {
            $criteria->add(SalesTableMap::COL_NOTE, $this->note);
        }
        if ($this->isColumnModified(SalesTableMap::COL_STATUS)) {
            $criteria->add(SalesTableMap::COL_STATUS, $this->status);
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
        $criteria = new Criteria(SalesTableMap::DATABASE_NAME);
        $criteria->add(SalesTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ORM\Sales (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDate($this->getDate());
        $copyObj->setSecondPartyId($this->getSecondPartyId());
        $copyObj->setBuyPrice($this->getBuyPrice());
        $copyObj->setTotalPrice($this->getTotalPrice());
        $copyObj->setPaid($this->getPaid());
        $copyObj->setCashierId($this->getCashierId());
        $copyObj->setNote($this->getNote());
        $copyObj->setStatus($this->getStatus());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCredits() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCredit($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDetails() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDetail($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getHistories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHistory($relObj->copy($deepCopy));
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
     * @return \ORM\Sales Clone of current object.
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
     * Declares an association between this object and a ChildSecondParty object.
     *
     * @param  ChildSecondParty $v
     * @return $this|\ORM\Sales The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSecondParty(ChildSecondParty $v = null)
    {
        if ($v === null) {
            $this->setSecondPartyId(NULL);
        } else {
            $this->setSecondPartyId($v->getId());
        }

        $this->aSecondParty = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSecondParty object, it will not be re-added.
        if ($v !== null) {
            $v->addSales($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSecondParty object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSecondParty The associated ChildSecondParty object.
     * @throws PropelException
     */
    public function getSecondParty(ConnectionInterface $con = null)
    {
        if ($this->aSecondParty === null && (($this->second_party_id !== "" && $this->second_party_id !== null))) {
            $this->aSecondParty = ChildSecondPartyQuery::create()->findPk($this->second_party_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSecondParty->addSaless($this);
             */
        }

        return $this->aSecondParty;
    }

    /**
     * Declares an association between this object and a ChildUserDetail object.
     *
     * @param  ChildUserDetail $v
     * @return $this|\ORM\Sales The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCashier(ChildUserDetail $v = null)
    {
        if ($v === null) {
            $this->setCashierId(NULL);
        } else {
            $this->setCashierId($v->getId());
        }

        $this->aCashier = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUserDetail object, it will not be re-added.
        if ($v !== null) {
            $v->addSales($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUserDetail object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUserDetail The associated ChildUserDetail object.
     * @throws PropelException
     */
    public function getCashier(ConnectionInterface $con = null)
    {
        if ($this->aCashier === null && (($this->cashier_id !== "" && $this->cashier_id !== null))) {
            $this->aCashier = ChildUserDetailQuery::create()->findPk($this->cashier_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCashier->addSaless($this);
             */
        }

        return $this->aCashier;
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
        if ('Credit' == $relationName) {
            return $this->initCredits();
        }
        if ('Detail' == $relationName) {
            return $this->initDetails();
        }
        if ('History' == $relationName) {
            return $this->initHistories();
        }
    }

    /**
     * Clears out the collCredits collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCredits()
     */
    public function clearCredits()
    {
        $this->collCredits = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCredits collection loaded partially.
     */
    public function resetPartialCredits($v = true)
    {
        $this->collCreditsPartial = $v;
    }

    /**
     * Initializes the collCredits collection.
     *
     * By default this just sets the collCredits collection to an empty array (like clearcollCredits());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCredits($overrideExisting = true)
    {
        if (null !== $this->collCredits && !$overrideExisting) {
            return;
        }
        $this->collCredits = new ObjectCollection();
        $this->collCredits->setModel('\ORM\Credit');
    }

    /**
     * Gets an array of ChildCredit objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSales is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCredit[] List of ChildCredit objects
     * @throws PropelException
     */
    public function getCredits(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCreditsPartial && !$this->isNew();
        if (null === $this->collCredits || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCredits) {
                // return empty collection
                $this->initCredits();
            } else {
                $collCredits = ChildCreditQuery::create(null, $criteria)
                    ->filterBySales($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCreditsPartial && count($collCredits)) {
                        $this->initCredits(false);

                        foreach ($collCredits as $obj) {
                            if (false == $this->collCredits->contains($obj)) {
                                $this->collCredits->append($obj);
                            }
                        }

                        $this->collCreditsPartial = true;
                    }

                    return $collCredits;
                }

                if ($partial && $this->collCredits) {
                    foreach ($this->collCredits as $obj) {
                        if ($obj->isNew()) {
                            $collCredits[] = $obj;
                        }
                    }
                }

                $this->collCredits = $collCredits;
                $this->collCreditsPartial = false;
            }
        }

        return $this->collCredits;
    }

    /**
     * Sets a collection of ChildCredit objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $credits A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSales The current object (for fluent API support)
     */
    public function setCredits(Collection $credits, ConnectionInterface $con = null)
    {
        /** @var ChildCredit[] $creditsToDelete */
        $creditsToDelete = $this->getCredits(new Criteria(), $con)->diff($credits);


        $this->creditsScheduledForDeletion = $creditsToDelete;

        foreach ($creditsToDelete as $creditRemoved) {
            $creditRemoved->setSales(null);
        }

        $this->collCredits = null;
        foreach ($credits as $credit) {
            $this->addCredit($credit);
        }

        $this->collCredits = $credits;
        $this->collCreditsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Credit objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Credit objects.
     * @throws PropelException
     */
    public function countCredits(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCreditsPartial && !$this->isNew();
        if (null === $this->collCredits || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCredits) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCredits());
            }

            $query = ChildCreditQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySales($this)
                ->count($con);
        }

        return count($this->collCredits);
    }

    /**
     * Method called to associate a ChildCredit object to this object
     * through the ChildCredit foreign key attribute.
     *
     * @param  ChildCredit $l ChildCredit
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function addCredit(ChildCredit $l)
    {
        if ($this->collCredits === null) {
            $this->initCredits();
            $this->collCreditsPartial = true;
        }

        if (!$this->collCredits->contains($l)) {
            $this->doAddCredit($l);
        }

        return $this;
    }

    /**
     * @param ChildCredit $credit The ChildCredit object to add.
     */
    protected function doAddCredit(ChildCredit $credit)
    {
        $this->collCredits[]= $credit;
        $credit->setSales($this);
    }

    /**
     * @param  ChildCredit $credit The ChildCredit object to remove.
     * @return $this|ChildSales The current object (for fluent API support)
     */
    public function removeCredit(ChildCredit $credit)
    {
        if ($this->getCredits()->contains($credit)) {
            $pos = $this->collCredits->search($credit);
            $this->collCredits->remove($pos);
            if (null === $this->creditsScheduledForDeletion) {
                $this->creditsScheduledForDeletion = clone $this->collCredits;
                $this->creditsScheduledForDeletion->clear();
            }
            $this->creditsScheduledForDeletion[]= $credit;
            $credit->setSales(null);
        }

        return $this;
    }

    /**
     * Clears out the collDetails collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDetails()
     */
    public function clearDetails()
    {
        $this->collDetails = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDetails collection loaded partially.
     */
    public function resetPartialDetails($v = true)
    {
        $this->collDetailsPartial = $v;
    }

    /**
     * Initializes the collDetails collection.
     *
     * By default this just sets the collDetails collection to an empty array (like clearcollDetails());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDetails($overrideExisting = true)
    {
        if (null !== $this->collDetails && !$overrideExisting) {
            return;
        }
        $this->collDetails = new ObjectCollection();
        $this->collDetails->setModel('\ORM\SalesDetail');
    }

    /**
     * Gets an array of ChildSalesDetail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSales is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSalesDetail[] List of ChildSalesDetail objects
     * @throws PropelException
     */
    public function getDetails(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDetailsPartial && !$this->isNew();
        if (null === $this->collDetails || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDetails) {
                // return empty collection
                $this->initDetails();
            } else {
                $collDetails = ChildSalesDetailQuery::create(null, $criteria)
                    ->filterBySales($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDetailsPartial && count($collDetails)) {
                        $this->initDetails(false);

                        foreach ($collDetails as $obj) {
                            if (false == $this->collDetails->contains($obj)) {
                                $this->collDetails->append($obj);
                            }
                        }

                        $this->collDetailsPartial = true;
                    }

                    return $collDetails;
                }

                if ($partial && $this->collDetails) {
                    foreach ($this->collDetails as $obj) {
                        if ($obj->isNew()) {
                            $collDetails[] = $obj;
                        }
                    }
                }

                $this->collDetails = $collDetails;
                $this->collDetailsPartial = false;
            }
        }

        return $this->collDetails;
    }

    /**
     * Sets a collection of ChildSalesDetail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $details A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSales The current object (for fluent API support)
     */
    public function setDetails(Collection $details, ConnectionInterface $con = null)
    {
        /** @var ChildSalesDetail[] $detailsToDelete */
        $detailsToDelete = $this->getDetails(new Criteria(), $con)->diff($details);


        $this->detailsScheduledForDeletion = $detailsToDelete;

        foreach ($detailsToDelete as $detailRemoved) {
            $detailRemoved->setSales(null);
        }

        $this->collDetails = null;
        foreach ($details as $detail) {
            $this->addDetail($detail);
        }

        $this->collDetails = $details;
        $this->collDetailsPartial = false;

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
    public function countDetails(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDetailsPartial && !$this->isNew();
        if (null === $this->collDetails || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDetails) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDetails());
            }

            $query = ChildSalesDetailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySales($this)
                ->count($con);
        }

        return count($this->collDetails);
    }

    /**
     * Method called to associate a ChildSalesDetail object to this object
     * through the ChildSalesDetail foreign key attribute.
     *
     * @param  ChildSalesDetail $l ChildSalesDetail
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function addDetail(ChildSalesDetail $l)
    {
        if ($this->collDetails === null) {
            $this->initDetails();
            $this->collDetailsPartial = true;
        }

        if (!$this->collDetails->contains($l)) {
            $this->doAddDetail($l);
        }

        return $this;
    }

    /**
     * @param ChildSalesDetail $detail The ChildSalesDetail object to add.
     */
    protected function doAddDetail(ChildSalesDetail $detail)
    {
        $this->collDetails[]= $detail;
        $detail->setSales($this);
    }

    /**
     * @param  ChildSalesDetail $detail The ChildSalesDetail object to remove.
     * @return $this|ChildSales The current object (for fluent API support)
     */
    public function removeDetail(ChildSalesDetail $detail)
    {
        if ($this->getDetails()->contains($detail)) {
            $pos = $this->collDetails->search($detail);
            $this->collDetails->remove($pos);
            if (null === $this->detailsScheduledForDeletion) {
                $this->detailsScheduledForDeletion = clone $this->collDetails;
                $this->detailsScheduledForDeletion->clear();
            }
            $this->detailsScheduledForDeletion[]= $detail;
            $detail->setSales(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Sales is new, it will return
     * an empty collection; or if this Sales has previously
     * been saved, it will retrieve related Details from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Sales.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSalesDetail[] List of ChildSalesDetail objects
     */
    public function getDetailsJoinStock(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSalesDetailQuery::create(null, $criteria);
        $query->joinWith('Stock', $joinBehavior);

        return $this->getDetails($query, $con);
    }

    /**
     * Clears out the collHistories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHistories()
     */
    public function clearHistories()
    {
        $this->collHistories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHistories collection loaded partially.
     */
    public function resetPartialHistories($v = true)
    {
        $this->collHistoriesPartial = $v;
    }

    /**
     * Initializes the collHistories collection.
     *
     * By default this just sets the collHistories collection to an empty array (like clearcollHistories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHistories($overrideExisting = true)
    {
        if (null !== $this->collHistories && !$overrideExisting) {
            return;
        }
        $this->collHistories = new ObjectCollection();
        $this->collHistories->setModel('\ORM\SalesHistory');
    }

    /**
     * Gets an array of ChildSalesHistory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSales is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSalesHistory[] List of ChildSalesHistory objects
     * @throws PropelException
     */
    public function getHistories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHistoriesPartial && !$this->isNew();
        if (null === $this->collHistories || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHistories) {
                // return empty collection
                $this->initHistories();
            } else {
                $collHistories = ChildSalesHistoryQuery::create(null, $criteria)
                    ->filterBySales($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHistoriesPartial && count($collHistories)) {
                        $this->initHistories(false);

                        foreach ($collHistories as $obj) {
                            if (false == $this->collHistories->contains($obj)) {
                                $this->collHistories->append($obj);
                            }
                        }

                        $this->collHistoriesPartial = true;
                    }

                    return $collHistories;
                }

                if ($partial && $this->collHistories) {
                    foreach ($this->collHistories as $obj) {
                        if ($obj->isNew()) {
                            $collHistories[] = $obj;
                        }
                    }
                }

                $this->collHistories = $collHistories;
                $this->collHistoriesPartial = false;
            }
        }

        return $this->collHistories;
    }

    /**
     * Sets a collection of ChildSalesHistory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $histories A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSales The current object (for fluent API support)
     */
    public function setHistories(Collection $histories, ConnectionInterface $con = null)
    {
        /** @var ChildSalesHistory[] $historiesToDelete */
        $historiesToDelete = $this->getHistories(new Criteria(), $con)->diff($histories);


        $this->historiesScheduledForDeletion = $historiesToDelete;

        foreach ($historiesToDelete as $historyRemoved) {
            $historyRemoved->setSales(null);
        }

        $this->collHistories = null;
        foreach ($histories as $history) {
            $this->addHistory($history);
        }

        $this->collHistories = $histories;
        $this->collHistoriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SalesHistory objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SalesHistory objects.
     * @throws PropelException
     */
    public function countHistories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHistoriesPartial && !$this->isNew();
        if (null === $this->collHistories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHistories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHistories());
            }

            $query = ChildSalesHistoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySales($this)
                ->count($con);
        }

        return count($this->collHistories);
    }

    /**
     * Method called to associate a ChildSalesHistory object to this object
     * through the ChildSalesHistory foreign key attribute.
     *
     * @param  ChildSalesHistory $l ChildSalesHistory
     * @return $this|\ORM\Sales The current object (for fluent API support)
     */
    public function addHistory(ChildSalesHistory $l)
    {
        if ($this->collHistories === null) {
            $this->initHistories();
            $this->collHistoriesPartial = true;
        }

        if (!$this->collHistories->contains($l)) {
            $this->doAddHistory($l);
        }

        return $this;
    }

    /**
     * @param ChildSalesHistory $history The ChildSalesHistory object to add.
     */
    protected function doAddHistory(ChildSalesHistory $history)
    {
        $this->collHistories[]= $history;
        $history->setSales($this);
    }

    /**
     * @param  ChildSalesHistory $history The ChildSalesHistory object to remove.
     * @return $this|ChildSales The current object (for fluent API support)
     */
    public function removeHistory(ChildSalesHistory $history)
    {
        if ($this->getHistories()->contains($history)) {
            $pos = $this->collHistories->search($history);
            $this->collHistories->remove($pos);
            if (null === $this->historiesScheduledForDeletion) {
                $this->historiesScheduledForDeletion = clone $this->collHistories;
                $this->historiesScheduledForDeletion->clear();
            }
            $this->historiesScheduledForDeletion[]= $history;
            $history->setSales(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Sales is new, it will return
     * an empty collection; or if this Sales has previously
     * been saved, it will retrieve related Histories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Sales.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSalesHistory[] List of ChildSalesHistory objects
     */
    public function getHistoriesJoinUserDetail(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSalesHistoryQuery::create(null, $criteria);
        $query->joinWith('UserDetail', $joinBehavior);

        return $this->getHistories($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSecondParty) {
            $this->aSecondParty->removeSales($this);
        }
        if (null !== $this->aCashier) {
            $this->aCashier->removeSales($this);
        }
        $this->id = null;
        $this->date = null;
        $this->second_party_id = null;
        $this->buy_price = null;
        $this->total_price = null;
        $this->paid = null;
        $this->cashier_id = null;
        $this->note = null;
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
            if ($this->collCredits) {
                foreach ($this->collCredits as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDetails) {
                foreach ($this->collDetails as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collHistories) {
                foreach ($this->collHistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCredits = null;
        $this->collDetails = null;
        $this->collHistories = null;
        $this->aSecondParty = null;
        $this->aCashier = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SalesTableMap::DEFAULT_STRING_FORMAT);
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
