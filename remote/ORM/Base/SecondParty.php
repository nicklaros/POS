<?php

namespace ORM\Base;

use \DateTime;
use \Exception;
use \PDO;
use ORM\Purchase as ChildPurchase;
use ORM\PurchaseQuery as ChildPurchaseQuery;
use ORM\Sales as ChildSales;
use ORM\SalesQuery as ChildSalesQuery;
use ORM\SecondParty as ChildSecondParty;
use ORM\SecondPartyQuery as ChildSecondPartyQuery;
use ORM\Map\SecondPartyTableMap;
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

abstract class SecondParty implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ORM\\Map\\SecondPartyTableMap';


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
     * The value for the registered_date field.
     * @var        \DateTime
     */
    protected $registered_date;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the address field.
     * @var        string
     */
    protected $address;

    /**
     * The value for the birthday field.
     * @var        \DateTime
     */
    protected $birthday;

    /**
     * The value for the gender field.
     * @var        string
     */
    protected $gender;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * The value for the type field.
     * @var        string
     */
    protected $type;

    /**
     * The value for the status field.
     * @var        string
     */
    protected $status;

    /**
     * @var        ObjectCollection|ChildPurchase[] Collection to store aggregation of ChildPurchase objects.
     */
    protected $collPurchases;
    protected $collPurchasesPartial;

    /**
     * @var        ObjectCollection|ChildSales[] Collection to store aggregation of ChildSales objects.
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
     * @var ObjectCollection|ChildPurchase[]
     */
    protected $purchasesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSales[]
     */
    protected $salessScheduledForDeletion = null;

    /**
     * Initializes internal state of ORM\Base\SecondParty object.
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
     * Compares this with another <code>SecondParty</code> instance.  If
     * <code>obj</code> is an instance of <code>SecondParty</code>, delegates to
     * <code>equals(SecondParty)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SecondParty The current object, for fluid interface
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
     * Get the [optionally formatted] temporal [registered_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return string|\DateTime Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getRegisteredDate($format = NULL)
    {
        if ($format === null) {
            return $this->registered_date;
        } else {
            return $this->registered_date instanceof \DateTime ? $this->registered_date->format($format) : null;
        }
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [address] column value.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the [optionally formatted] temporal [birthday] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return string|\DateTime Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getBirthday($format = NULL)
    {
        if ($format === null) {
            return $this->birthday;
        } else {
            return $this->birthday instanceof \DateTime ? $this->birthday->format($format) : null;
        }
    }

    /**
     * Get the [gender] column value.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get the [phone] column value.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SecondPartyTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SecondPartyTableMap::translateFieldName('RegisteredDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->registered_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SecondPartyTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SecondPartyTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SecondPartyTableMap::translateFieldName('Birthday', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->birthday = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SecondPartyTableMap::translateFieldName('Gender', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gender = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SecondPartyTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SecondPartyTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SecondPartyTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = SecondPartyTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ORM\\SecondParty'), 0, $e);
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
    } // ensureConsistency

    /**
     * Set the value of [id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SecondPartyTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Sets the value of [registered_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setRegisteredDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->registered_date !== null || $dt !== null) {
            if ($dt !== $this->registered_date) {
                $this->registered_date = $dt;
                $this->modifiedColumns[SecondPartyTableMap::COL_REGISTERED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setRegisteredDate()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[SecondPartyTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [address] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[SecondPartyTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Sets the value of [birthday] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setBirthday($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->birthday !== null || $dt !== null) {
            if ($dt !== $this->birthday) {
                $this->birthday = $dt;
                $this->modifiedColumns[SecondPartyTableMap::COL_BIRTHDAY] = true;
            }
        } // if either are not null

        return $this;
    } // setBirthday()

    /**
     * Set the value of [gender] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setGender($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gender !== $v) {
            $this->gender = $v;
            $this->modifiedColumns[SecondPartyTableMap::COL_GENDER] = true;
        }

        return $this;
    } // setGender()

    /**
     * Set the value of [phone] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[SecondPartyTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

    /**
     * Set the value of [type] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[SecondPartyTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [status] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[SecondPartyTableMap::COL_STATUS] = true;
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
            $con = Propel::getServiceContainer()->getReadConnection(SecondPartyTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSecondPartyQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

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
     * @see SecondParty::setDeleted()
     * @see SecondParty::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SecondPartyTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSecondPartyQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SecondPartyTableMap::DATABASE_NAME);
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
                SecondPartyTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[SecondPartyTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SecondPartyTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SecondPartyTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_REGISTERED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'REGISTERED_DATE';
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'ADDRESS';
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_BIRTHDAY)) {
            $modifiedColumns[':p' . $index++]  = 'BIRTHDAY';
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_GENDER)) {
            $modifiedColumns[':p' . $index++]  = 'GENDER';
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'PHONE';
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'TYPE';
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'STATUS';
        }

        $sql = sprintf(
            'INSERT INTO second_party (%s) VALUES (%s)',
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
                    case 'REGISTERED_DATE':
                        $stmt->bindValue($identifier, $this->registered_date ? $this->registered_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'NAME':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'ADDRESS':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case 'BIRTHDAY':
                        $stmt->bindValue($identifier, $this->birthday ? $this->birthday->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'GENDER':
                        $stmt->bindValue($identifier, $this->gender, PDO::PARAM_STR);
                        break;
                    case 'PHONE':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case 'TYPE':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
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
        $pos = SecondPartyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getRegisteredDate();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getAddress();
                break;
            case 4:
                return $this->getBirthday();
                break;
            case 5:
                return $this->getGender();
                break;
            case 6:
                return $this->getPhone();
                break;
            case 7:
                return $this->getType();
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
        if (isset($alreadyDumpedObjects['SecondParty'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SecondParty'][$this->getPrimaryKey()] = true;
        $keys = SecondPartyTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getRegisteredDate(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getAddress(),
            $keys[4] => $this->getBirthday(),
            $keys[5] => $this->getGender(),
            $keys[6] => $this->getPhone(),
            $keys[7] => $this->getType(),
            $keys[8] => $this->getStatus(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
     * @return $this|\ORM\SecondParty
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SecondPartyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ORM\SecondParty
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setRegisteredDate($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setAddress($value);
                break;
            case 4:
                $this->setBirthday($value);
                break;
            case 5:
                $this->setGender($value);
                break;
            case 6:
                $this->setPhone($value);
                break;
            case 7:
                $this->setType($value);
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
        $keys = SecondPartyTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setRegisteredDate($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setAddress($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setBirthday($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setGender($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPhone($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setType($arr[$keys[7]]);
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
     * @return $this|\ORM\SecondParty The current object, for fluid interface
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
        $criteria = new Criteria(SecondPartyTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SecondPartyTableMap::COL_ID)) {
            $criteria->add(SecondPartyTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_REGISTERED_DATE)) {
            $criteria->add(SecondPartyTableMap::COL_REGISTERED_DATE, $this->registered_date);
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_NAME)) {
            $criteria->add(SecondPartyTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_ADDRESS)) {
            $criteria->add(SecondPartyTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_BIRTHDAY)) {
            $criteria->add(SecondPartyTableMap::COL_BIRTHDAY, $this->birthday);
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_GENDER)) {
            $criteria->add(SecondPartyTableMap::COL_GENDER, $this->gender);
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_PHONE)) {
            $criteria->add(SecondPartyTableMap::COL_PHONE, $this->phone);
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_TYPE)) {
            $criteria->add(SecondPartyTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(SecondPartyTableMap::COL_STATUS)) {
            $criteria->add(SecondPartyTableMap::COL_STATUS, $this->status);
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
        $criteria = new Criteria(SecondPartyTableMap::DATABASE_NAME);
        $criteria->add(SecondPartyTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ORM\SecondParty (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setRegisteredDate($this->getRegisteredDate());
        $copyObj->setName($this->getName());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setBirthday($this->getBirthday());
        $copyObj->setGender($this->getGender());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setType($this->getType());
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
     * @return \ORM\SecondParty Clone of current object.
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
        $this->collPurchases->setModel('\ORM\Purchase');
    }

    /**
     * Gets an array of ChildPurchase objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSecondParty is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPurchase[] List of ChildPurchase objects
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
                $collPurchases = ChildPurchaseQuery::create(null, $criteria)
                    ->filterBySecondParty($this)
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
     * Sets a collection of ChildPurchase objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $purchases A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSecondParty The current object (for fluent API support)
     */
    public function setPurchases(Collection $purchases, ConnectionInterface $con = null)
    {
        /** @var ChildPurchase[] $purchasesToDelete */
        $purchasesToDelete = $this->getPurchases(new Criteria(), $con)->diff($purchases);


        $this->purchasesScheduledForDeletion = $purchasesToDelete;

        foreach ($purchasesToDelete as $purchaseRemoved) {
            $purchaseRemoved->setSecondParty(null);
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
     * Returns the number of related Purchase objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Purchase objects.
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

            $query = ChildPurchaseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySecondParty($this)
                ->count($con);
        }

        return count($this->collPurchases);
    }

    /**
     * Method called to associate a ChildPurchase object to this object
     * through the ChildPurchase foreign key attribute.
     *
     * @param  ChildPurchase $l ChildPurchase
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function addPurchase(ChildPurchase $l)
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
     * @param ChildPurchase $purchase The ChildPurchase object to add.
     */
    protected function doAddPurchase(ChildPurchase $purchase)
    {
        $this->collPurchases[]= $purchase;
        $purchase->setSecondParty($this);
    }

    /**
     * @param  ChildPurchase $purchase The ChildPurchase object to remove.
     * @return $this|ChildSecondParty The current object (for fluent API support)
     */
    public function removePurchase(ChildPurchase $purchase)
    {
        if ($this->getPurchases()->contains($purchase)) {
            $pos = $this->collPurchases->search($purchase);
            $this->collPurchases->remove($pos);
            if (null === $this->purchasesScheduledForDeletion) {
                $this->purchasesScheduledForDeletion = clone $this->collPurchases;
                $this->purchasesScheduledForDeletion->clear();
            }
            $this->purchasesScheduledForDeletion[]= $purchase;
            $purchase->setSecondParty(null);
        }

        return $this;
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
        $this->collSaless->setModel('\ORM\Sales');
    }

    /**
     * Gets an array of ChildSales objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSecondParty is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSales[] List of ChildSales objects
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
                $collSaless = ChildSalesQuery::create(null, $criteria)
                    ->filterBySecondParty($this)
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
     * Sets a collection of ChildSales objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $saless A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSecondParty The current object (for fluent API support)
     */
    public function setSaless(Collection $saless, ConnectionInterface $con = null)
    {
        /** @var ChildSales[] $salessToDelete */
        $salessToDelete = $this->getSaless(new Criteria(), $con)->diff($saless);


        $this->salessScheduledForDeletion = $salessToDelete;

        foreach ($salessToDelete as $salesRemoved) {
            $salesRemoved->setSecondParty(null);
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
     * Returns the number of related Sales objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Sales objects.
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

            $query = ChildSalesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySecondParty($this)
                ->count($con);
        }

        return count($this->collSaless);
    }

    /**
     * Method called to associate a ChildSales object to this object
     * through the ChildSales foreign key attribute.
     *
     * @param  ChildSales $l ChildSales
     * @return $this|\ORM\SecondParty The current object (for fluent API support)
     */
    public function addSales(ChildSales $l)
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
     * @param ChildSales $sales The ChildSales object to add.
     */
    protected function doAddSales(ChildSales $sales)
    {
        $this->collSaless[]= $sales;
        $sales->setSecondParty($this);
    }

    /**
     * @param  ChildSales $sales The ChildSales object to remove.
     * @return $this|ChildSecondParty The current object (for fluent API support)
     */
    public function removeSales(ChildSales $sales)
    {
        if ($this->getSaless()->contains($sales)) {
            $pos = $this->collSaless->search($sales);
            $this->collSaless->remove($pos);
            if (null === $this->salessScheduledForDeletion) {
                $this->salessScheduledForDeletion = clone $this->collSaless;
                $this->salessScheduledForDeletion->clear();
            }
            $this->salessScheduledForDeletion[]= $sales;
            $sales->setSecondParty(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SecondParty is new, it will return
     * an empty collection; or if this SecondParty has previously
     * been saved, it will retrieve related Saless from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SecondParty.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSales[] List of ChildSales objects
     */
    public function getSalessJoinCashier(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSalesQuery::create(null, $criteria);
        $query->joinWith('Cashier', $joinBehavior);

        return $this->getSaless($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->registered_date = null;
        $this->name = null;
        $this->address = null;
        $this->birthday = null;
        $this->gender = null;
        $this->phone = null;
        $this->type = null;
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
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SecondPartyTableMap::DEFAULT_STRING_FORMAT);
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
