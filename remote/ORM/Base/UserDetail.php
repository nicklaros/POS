<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\CreditPayment as ChildCreditPayment;
use ORM\CreditPaymentQuery as ChildCreditPaymentQuery;
use ORM\DebitPayment as ChildDebitPayment;
use ORM\DebitPaymentQuery as ChildDebitPaymentQuery;
use ORM\PurchaseHistory as ChildPurchaseHistory;
use ORM\PurchaseHistoryQuery as ChildPurchaseHistoryQuery;
use ORM\RowHistory as ChildRowHistory;
use ORM\RowHistoryQuery as ChildRowHistoryQuery;
use ORM\Sales as ChildSales;
use ORM\SalesHistory as ChildSalesHistory;
use ORM\SalesHistoryQuery as ChildSalesHistoryQuery;
use ORM\SalesQuery as ChildSalesQuery;
use ORM\User as ChildUser;
use ORM\UserDetail as ChildUserDetail;
use ORM\UserDetailQuery as ChildUserDetailQuery;
use ORM\UserQuery as ChildUserQuery;
use ORM\Map\UserDetailTableMap;
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

abstract class UserDetail implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ORM\\Map\\UserDetailTableMap';


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
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ObjectCollection|ChildCreditPayment[] Collection to store aggregation of ChildCreditPayment objects.
     */
    protected $collCreditPayments;
    protected $collCreditPaymentsPartial;

    /**
     * @var        ObjectCollection|ChildDebitPayment[] Collection to store aggregation of ChildDebitPayment objects.
     */
    protected $collDebitPayments;
    protected $collDebitPaymentsPartial;

    /**
     * @var        ObjectCollection|ChildPurchaseHistory[] Collection to store aggregation of ChildPurchaseHistory objects.
     */
    protected $collPurchaseHistories;
    protected $collPurchaseHistoriesPartial;

    /**
     * @var        ObjectCollection|ChildRowHistory[] Collection to store aggregation of ChildRowHistory objects.
     */
    protected $collHistories;
    protected $collHistoriesPartial;

    /**
     * @var        ObjectCollection|ChildSales[] Collection to store aggregation of ChildSales objects.
     */
    protected $collSaless;
    protected $collSalessPartial;

    /**
     * @var        ObjectCollection|ChildSalesHistory[] Collection to store aggregation of ChildSalesHistory objects.
     */
    protected $collSalesHistories;
    protected $collSalesHistoriesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCreditPayment[]
     */
    protected $creditPaymentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDebitPayment[]
     */
    protected $debitPaymentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPurchaseHistory[]
     */
    protected $purchaseHistoriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRowHistory[]
     */
    protected $historiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSales[]
     */
    protected $salessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSalesHistory[]
     */
    protected $salesHistoriesScheduledForDeletion = null;

    /**
     * Initializes internal state of ORM\Base\UserDetail object.
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
     * Compares this with another <code>UserDetail</code> instance.  If
     * <code>obj</code> is an instance of <code>UserDetail</code>, delegates to
     * <code>equals(UserDetail)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|UserDetail The current object, for fluid interface
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
     * Get the [phone] column value.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserDetailTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserDetailTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserDetailTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserDetailTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = UserDetailTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ORM\\UserDetail'), 0, $e);
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
        if ($this->aUser !== null && $this->id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserDetailTableMap::COL_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[UserDetailTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [address] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[UserDetailTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [phone] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[UserDetailTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

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
            $con = Propel::getServiceContainer()->getReadConnection(UserDetailTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserDetailQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->collCreditPayments = null;

            $this->collDebitPayments = null;

            $this->collPurchaseHistories = null;

            $this->collHistories = null;

            $this->collSaless = null;

            $this->collSalesHistories = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see UserDetail::setDeleted()
     * @see UserDetail::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserDetailTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserDetailQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserDetailTableMap::DATABASE_NAME);
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
                UserDetailTableMap::addInstanceToPool($this);
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

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
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

            if ($this->creditPaymentsScheduledForDeletion !== null) {
                if (!$this->creditPaymentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->creditPaymentsScheduledForDeletion as $creditPayment) {
                        // need to save related object because we set the relation to null
                        $creditPayment->save($con);
                    }
                    $this->creditPaymentsScheduledForDeletion = null;
                }
            }

            if ($this->collCreditPayments !== null) {
                foreach ($this->collCreditPayments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->debitPaymentsScheduledForDeletion !== null) {
                if (!$this->debitPaymentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->debitPaymentsScheduledForDeletion as $debitPayment) {
                        // need to save related object because we set the relation to null
                        $debitPayment->save($con);
                    }
                    $this->debitPaymentsScheduledForDeletion = null;
                }
            }

            if ($this->collDebitPayments !== null) {
                foreach ($this->collDebitPayments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->purchaseHistoriesScheduledForDeletion !== null) {
                if (!$this->purchaseHistoriesScheduledForDeletion->isEmpty()) {
                    foreach ($this->purchaseHistoriesScheduledForDeletion as $purchaseHistory) {
                        // need to save related object because we set the relation to null
                        $purchaseHistory->save($con);
                    }
                    $this->purchaseHistoriesScheduledForDeletion = null;
                }
            }

            if ($this->collPurchaseHistories !== null) {
                foreach ($this->collPurchaseHistories as $referrerFK) {
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

            if ($this->salesHistoriesScheduledForDeletion !== null) {
                if (!$this->salesHistoriesScheduledForDeletion->isEmpty()) {
                    foreach ($this->salesHistoriesScheduledForDeletion as $salesHistory) {
                        // need to save related object because we set the relation to null
                        $salesHistory->save($con);
                    }
                    $this->salesHistoriesScheduledForDeletion = null;
                }
            }

            if ($this->collSalesHistories !== null) {
                foreach ($this->collSalesHistories as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserDetailTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(UserDetailTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(UserDetailTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'ADDRESS';
        }
        if ($this->isColumnModified(UserDetailTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'PHONE';
        }

        $sql = sprintf(
            'INSERT INTO user_detail (%s) VALUES (%s)',
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
                    case 'NAME':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'ADDRESS':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case 'PHONE':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = UserDetailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getAddress();
                break;
            case 3:
                return $this->getPhone();
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
        if (isset($alreadyDumpedObjects['UserDetail'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['UserDetail'][$this->getPrimaryKey()] = true;
        $keys = UserDetailTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getAddress(),
            $keys[3] => $this->getPhone(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCreditPayments) {
                $result['CreditPayments'] = $this->collCreditPayments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDebitPayments) {
                $result['DebitPayments'] = $this->collDebitPayments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPurchaseHistories) {
                $result['PurchaseHistories'] = $this->collPurchaseHistories->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collHistories) {
                $result['Histories'] = $this->collHistories->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSaless) {
                $result['Saless'] = $this->collSaless->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSalesHistories) {
                $result['SalesHistories'] = $this->collSalesHistories->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\ORM\UserDetail
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserDetailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ORM\UserDetail
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setAddress($value);
                break;
            case 3:
                $this->setPhone($value);
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
        $keys = UserDetailTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAddress($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPhone($arr[$keys[3]]);
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
     * @return $this|\ORM\UserDetail The current object, for fluid interface
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
        $criteria = new Criteria(UserDetailTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserDetailTableMap::COL_ID)) {
            $criteria->add(UserDetailTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserDetailTableMap::COL_NAME)) {
            $criteria->add(UserDetailTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(UserDetailTableMap::COL_ADDRESS)) {
            $criteria->add(UserDetailTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(UserDetailTableMap::COL_PHONE)) {
            $criteria->add(UserDetailTableMap::COL_PHONE, $this->phone);
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
        $criteria = new Criteria(UserDetailTableMap::DATABASE_NAME);
        $criteria->add(UserDetailTableMap::COL_ID, $this->id);

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

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation user_detail_fk_ffc53a to table user
        if ($this->aUser && $hash = spl_object_hash($this->aUser)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

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
     * @param      object $copyObj An object of \ORM\UserDetail (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setName($this->getName());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setPhone($this->getPhone());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCreditPayments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCreditPayment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDebitPayments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDebitPayment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPurchaseHistories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPurchaseHistory($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getHistories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHistory($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSaless() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSales($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSalesHistories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSalesHistory($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \ORM\UserDetail Clone of current object.
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
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setId(NULL);
        } else {
            $this->setId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setDetail($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && (($this->id !== "" && $this->id !== null))) {
            $this->aUser = ChildUserQuery::create()->findPk($this->id, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aUser->setDetail($this);
        }

        return $this->aUser;
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
        if ('CreditPayment' == $relationName) {
            return $this->initCreditPayments();
        }
        if ('DebitPayment' == $relationName) {
            return $this->initDebitPayments();
        }
        if ('PurchaseHistory' == $relationName) {
            return $this->initPurchaseHistories();
        }
        if ('History' == $relationName) {
            return $this->initHistories();
        }
        if ('Sales' == $relationName) {
            return $this->initSaless();
        }
        if ('SalesHistory' == $relationName) {
            return $this->initSalesHistories();
        }
    }

    /**
     * Clears out the collCreditPayments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCreditPayments()
     */
    public function clearCreditPayments()
    {
        $this->collCreditPayments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCreditPayments collection loaded partially.
     */
    public function resetPartialCreditPayments($v = true)
    {
        $this->collCreditPaymentsPartial = $v;
    }

    /**
     * Initializes the collCreditPayments collection.
     *
     * By default this just sets the collCreditPayments collection to an empty array (like clearcollCreditPayments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCreditPayments($overrideExisting = true)
    {
        if (null !== $this->collCreditPayments && !$overrideExisting) {
            return;
        }
        $this->collCreditPayments = new ObjectCollection();
        $this->collCreditPayments->setModel('\ORM\CreditPayment');
    }

    /**
     * Gets an array of ChildCreditPayment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserDetail is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCreditPayment[] List of ChildCreditPayment objects
     * @throws PropelException
     */
    public function getCreditPayments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCreditPaymentsPartial && !$this->isNew();
        if (null === $this->collCreditPayments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCreditPayments) {
                // return empty collection
                $this->initCreditPayments();
            } else {
                $collCreditPayments = ChildCreditPaymentQuery::create(null, $criteria)
                    ->filterByCashier($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCreditPaymentsPartial && count($collCreditPayments)) {
                        $this->initCreditPayments(false);

                        foreach ($collCreditPayments as $obj) {
                            if (false == $this->collCreditPayments->contains($obj)) {
                                $this->collCreditPayments->append($obj);
                            }
                        }

                        $this->collCreditPaymentsPartial = true;
                    }

                    return $collCreditPayments;
                }

                if ($partial && $this->collCreditPayments) {
                    foreach ($this->collCreditPayments as $obj) {
                        if ($obj->isNew()) {
                            $collCreditPayments[] = $obj;
                        }
                    }
                }

                $this->collCreditPayments = $collCreditPayments;
                $this->collCreditPaymentsPartial = false;
            }
        }

        return $this->collCreditPayments;
    }

    /**
     * Sets a collection of ChildCreditPayment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $creditPayments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function setCreditPayments(Collection $creditPayments, ConnectionInterface $con = null)
    {
        /** @var ChildCreditPayment[] $creditPaymentsToDelete */
        $creditPaymentsToDelete = $this->getCreditPayments(new Criteria(), $con)->diff($creditPayments);


        $this->creditPaymentsScheduledForDeletion = $creditPaymentsToDelete;

        foreach ($creditPaymentsToDelete as $creditPaymentRemoved) {
            $creditPaymentRemoved->setCashier(null);
        }

        $this->collCreditPayments = null;
        foreach ($creditPayments as $creditPayment) {
            $this->addCreditPayment($creditPayment);
        }

        $this->collCreditPayments = $creditPayments;
        $this->collCreditPaymentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CreditPayment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CreditPayment objects.
     * @throws PropelException
     */
    public function countCreditPayments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCreditPaymentsPartial && !$this->isNew();
        if (null === $this->collCreditPayments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCreditPayments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCreditPayments());
            }

            $query = ChildCreditPaymentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCashier($this)
                ->count($con);
        }

        return count($this->collCreditPayments);
    }

    /**
     * Method called to associate a ChildCreditPayment object to this object
     * through the ChildCreditPayment foreign key attribute.
     *
     * @param  ChildCreditPayment $l ChildCreditPayment
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function addCreditPayment(ChildCreditPayment $l)
    {
        if ($this->collCreditPayments === null) {
            $this->initCreditPayments();
            $this->collCreditPaymentsPartial = true;
        }

        if (!$this->collCreditPayments->contains($l)) {
            $this->doAddCreditPayment($l);
        }

        return $this;
    }

    /**
     * @param ChildCreditPayment $creditPayment The ChildCreditPayment object to add.
     */
    protected function doAddCreditPayment(ChildCreditPayment $creditPayment)
    {
        $this->collCreditPayments[]= $creditPayment;
        $creditPayment->setCashier($this);
    }

    /**
     * @param  ChildCreditPayment $creditPayment The ChildCreditPayment object to remove.
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function removeCreditPayment(ChildCreditPayment $creditPayment)
    {
        if ($this->getCreditPayments()->contains($creditPayment)) {
            $pos = $this->collCreditPayments->search($creditPayment);
            $this->collCreditPayments->remove($pos);
            if (null === $this->creditPaymentsScheduledForDeletion) {
                $this->creditPaymentsScheduledForDeletion = clone $this->collCreditPayments;
                $this->creditPaymentsScheduledForDeletion->clear();
            }
            $this->creditPaymentsScheduledForDeletion[]= $creditPayment;
            $creditPayment->setCashier(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UserDetail is new, it will return
     * an empty collection; or if this UserDetail has previously
     * been saved, it will retrieve related CreditPayments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UserDetail.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCreditPayment[] List of ChildCreditPayment objects
     */
    public function getCreditPaymentsJoinCredit(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCreditPaymentQuery::create(null, $criteria);
        $query->joinWith('Credit', $joinBehavior);

        return $this->getCreditPayments($query, $con);
    }

    /**
     * Clears out the collDebitPayments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDebitPayments()
     */
    public function clearDebitPayments()
    {
        $this->collDebitPayments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDebitPayments collection loaded partially.
     */
    public function resetPartialDebitPayments($v = true)
    {
        $this->collDebitPaymentsPartial = $v;
    }

    /**
     * Initializes the collDebitPayments collection.
     *
     * By default this just sets the collDebitPayments collection to an empty array (like clearcollDebitPayments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDebitPayments($overrideExisting = true)
    {
        if (null !== $this->collDebitPayments && !$overrideExisting) {
            return;
        }
        $this->collDebitPayments = new ObjectCollection();
        $this->collDebitPayments->setModel('\ORM\DebitPayment');
    }

    /**
     * Gets an array of ChildDebitPayment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserDetail is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDebitPayment[] List of ChildDebitPayment objects
     * @throws PropelException
     */
    public function getDebitPayments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDebitPaymentsPartial && !$this->isNew();
        if (null === $this->collDebitPayments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDebitPayments) {
                // return empty collection
                $this->initDebitPayments();
            } else {
                $collDebitPayments = ChildDebitPaymentQuery::create(null, $criteria)
                    ->filterByCashier($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDebitPaymentsPartial && count($collDebitPayments)) {
                        $this->initDebitPayments(false);

                        foreach ($collDebitPayments as $obj) {
                            if (false == $this->collDebitPayments->contains($obj)) {
                                $this->collDebitPayments->append($obj);
                            }
                        }

                        $this->collDebitPaymentsPartial = true;
                    }

                    return $collDebitPayments;
                }

                if ($partial && $this->collDebitPayments) {
                    foreach ($this->collDebitPayments as $obj) {
                        if ($obj->isNew()) {
                            $collDebitPayments[] = $obj;
                        }
                    }
                }

                $this->collDebitPayments = $collDebitPayments;
                $this->collDebitPaymentsPartial = false;
            }
        }

        return $this->collDebitPayments;
    }

    /**
     * Sets a collection of ChildDebitPayment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $debitPayments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function setDebitPayments(Collection $debitPayments, ConnectionInterface $con = null)
    {
        /** @var ChildDebitPayment[] $debitPaymentsToDelete */
        $debitPaymentsToDelete = $this->getDebitPayments(new Criteria(), $con)->diff($debitPayments);


        $this->debitPaymentsScheduledForDeletion = $debitPaymentsToDelete;

        foreach ($debitPaymentsToDelete as $debitPaymentRemoved) {
            $debitPaymentRemoved->setCashier(null);
        }

        $this->collDebitPayments = null;
        foreach ($debitPayments as $debitPayment) {
            $this->addDebitPayment($debitPayment);
        }

        $this->collDebitPayments = $debitPayments;
        $this->collDebitPaymentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DebitPayment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DebitPayment objects.
     * @throws PropelException
     */
    public function countDebitPayments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDebitPaymentsPartial && !$this->isNew();
        if (null === $this->collDebitPayments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDebitPayments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDebitPayments());
            }

            $query = ChildDebitPaymentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCashier($this)
                ->count($con);
        }

        return count($this->collDebitPayments);
    }

    /**
     * Method called to associate a ChildDebitPayment object to this object
     * through the ChildDebitPayment foreign key attribute.
     *
     * @param  ChildDebitPayment $l ChildDebitPayment
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function addDebitPayment(ChildDebitPayment $l)
    {
        if ($this->collDebitPayments === null) {
            $this->initDebitPayments();
            $this->collDebitPaymentsPartial = true;
        }

        if (!$this->collDebitPayments->contains($l)) {
            $this->doAddDebitPayment($l);
        }

        return $this;
    }

    /**
     * @param ChildDebitPayment $debitPayment The ChildDebitPayment object to add.
     */
    protected function doAddDebitPayment(ChildDebitPayment $debitPayment)
    {
        $this->collDebitPayments[]= $debitPayment;
        $debitPayment->setCashier($this);
    }

    /**
     * @param  ChildDebitPayment $debitPayment The ChildDebitPayment object to remove.
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function removeDebitPayment(ChildDebitPayment $debitPayment)
    {
        if ($this->getDebitPayments()->contains($debitPayment)) {
            $pos = $this->collDebitPayments->search($debitPayment);
            $this->collDebitPayments->remove($pos);
            if (null === $this->debitPaymentsScheduledForDeletion) {
                $this->debitPaymentsScheduledForDeletion = clone $this->collDebitPayments;
                $this->debitPaymentsScheduledForDeletion->clear();
            }
            $this->debitPaymentsScheduledForDeletion[]= $debitPayment;
            $debitPayment->setCashier(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UserDetail is new, it will return
     * an empty collection; or if this UserDetail has previously
     * been saved, it will retrieve related DebitPayments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UserDetail.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDebitPayment[] List of ChildDebitPayment objects
     */
    public function getDebitPaymentsJoinDebit(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDebitPaymentQuery::create(null, $criteria);
        $query->joinWith('Debit', $joinBehavior);

        return $this->getDebitPayments($query, $con);
    }

    /**
     * Clears out the collPurchaseHistories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPurchaseHistories()
     */
    public function clearPurchaseHistories()
    {
        $this->collPurchaseHistories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPurchaseHistories collection loaded partially.
     */
    public function resetPartialPurchaseHistories($v = true)
    {
        $this->collPurchaseHistoriesPartial = $v;
    }

    /**
     * Initializes the collPurchaseHistories collection.
     *
     * By default this just sets the collPurchaseHistories collection to an empty array (like clearcollPurchaseHistories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPurchaseHistories($overrideExisting = true)
    {
        if (null !== $this->collPurchaseHistories && !$overrideExisting) {
            return;
        }
        $this->collPurchaseHistories = new ObjectCollection();
        $this->collPurchaseHistories->setModel('\ORM\PurchaseHistory');
    }

    /**
     * Gets an array of ChildPurchaseHistory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserDetail is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPurchaseHistory[] List of ChildPurchaseHistory objects
     * @throws PropelException
     */
    public function getPurchaseHistories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchaseHistoriesPartial && !$this->isNew();
        if (null === $this->collPurchaseHistories || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPurchaseHistories) {
                // return empty collection
                $this->initPurchaseHistories();
            } else {
                $collPurchaseHistories = ChildPurchaseHistoryQuery::create(null, $criteria)
                    ->filterByUserDetail($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPurchaseHistoriesPartial && count($collPurchaseHistories)) {
                        $this->initPurchaseHistories(false);

                        foreach ($collPurchaseHistories as $obj) {
                            if (false == $this->collPurchaseHistories->contains($obj)) {
                                $this->collPurchaseHistories->append($obj);
                            }
                        }

                        $this->collPurchaseHistoriesPartial = true;
                    }

                    return $collPurchaseHistories;
                }

                if ($partial && $this->collPurchaseHistories) {
                    foreach ($this->collPurchaseHistories as $obj) {
                        if ($obj->isNew()) {
                            $collPurchaseHistories[] = $obj;
                        }
                    }
                }

                $this->collPurchaseHistories = $collPurchaseHistories;
                $this->collPurchaseHistoriesPartial = false;
            }
        }

        return $this->collPurchaseHistories;
    }

    /**
     * Sets a collection of ChildPurchaseHistory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $purchaseHistories A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function setPurchaseHistories(Collection $purchaseHistories, ConnectionInterface $con = null)
    {
        /** @var ChildPurchaseHistory[] $purchaseHistoriesToDelete */
        $purchaseHistoriesToDelete = $this->getPurchaseHistories(new Criteria(), $con)->diff($purchaseHistories);


        $this->purchaseHistoriesScheduledForDeletion = $purchaseHistoriesToDelete;

        foreach ($purchaseHistoriesToDelete as $purchaseHistoryRemoved) {
            $purchaseHistoryRemoved->setUserDetail(null);
        }

        $this->collPurchaseHistories = null;
        foreach ($purchaseHistories as $purchaseHistory) {
            $this->addPurchaseHistory($purchaseHistory);
        }

        $this->collPurchaseHistories = $purchaseHistories;
        $this->collPurchaseHistoriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PurchaseHistory objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PurchaseHistory objects.
     * @throws PropelException
     */
    public function countPurchaseHistories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchaseHistoriesPartial && !$this->isNew();
        if (null === $this->collPurchaseHistories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPurchaseHistories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPurchaseHistories());
            }

            $query = ChildPurchaseHistoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserDetail($this)
                ->count($con);
        }

        return count($this->collPurchaseHistories);
    }

    /**
     * Method called to associate a ChildPurchaseHistory object to this object
     * through the ChildPurchaseHistory foreign key attribute.
     *
     * @param  ChildPurchaseHistory $l ChildPurchaseHistory
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function addPurchaseHistory(ChildPurchaseHistory $l)
    {
        if ($this->collPurchaseHistories === null) {
            $this->initPurchaseHistories();
            $this->collPurchaseHistoriesPartial = true;
        }

        if (!$this->collPurchaseHistories->contains($l)) {
            $this->doAddPurchaseHistory($l);
        }

        return $this;
    }

    /**
     * @param ChildPurchaseHistory $purchaseHistory The ChildPurchaseHistory object to add.
     */
    protected function doAddPurchaseHistory(ChildPurchaseHistory $purchaseHistory)
    {
        $this->collPurchaseHistories[]= $purchaseHistory;
        $purchaseHistory->setUserDetail($this);
    }

    /**
     * @param  ChildPurchaseHistory $purchaseHistory The ChildPurchaseHistory object to remove.
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function removePurchaseHistory(ChildPurchaseHistory $purchaseHistory)
    {
        if ($this->getPurchaseHistories()->contains($purchaseHistory)) {
            $pos = $this->collPurchaseHistories->search($purchaseHistory);
            $this->collPurchaseHistories->remove($pos);
            if (null === $this->purchaseHistoriesScheduledForDeletion) {
                $this->purchaseHistoriesScheduledForDeletion = clone $this->collPurchaseHistories;
                $this->purchaseHistoriesScheduledForDeletion->clear();
            }
            $this->purchaseHistoriesScheduledForDeletion[]= $purchaseHistory;
            $purchaseHistory->setUserDetail(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UserDetail is new, it will return
     * an empty collection; or if this UserDetail has previously
     * been saved, it will retrieve related PurchaseHistories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UserDetail.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPurchaseHistory[] List of ChildPurchaseHistory objects
     */
    public function getPurchaseHistoriesJoinPurchase(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPurchaseHistoryQuery::create(null, $criteria);
        $query->joinWith('Purchase', $joinBehavior);

        return $this->getPurchaseHistories($query, $con);
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
        $this->collHistories->setModel('\ORM\RowHistory');
    }

    /**
     * Gets an array of ChildRowHistory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserDetail is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRowHistory[] List of ChildRowHistory objects
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
                $collHistories = ChildRowHistoryQuery::create(null, $criteria)
                    ->filterByUserDetail($this)
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
     * Sets a collection of ChildRowHistory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $histories A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function setHistories(Collection $histories, ConnectionInterface $con = null)
    {
        /** @var ChildRowHistory[] $historiesToDelete */
        $historiesToDelete = $this->getHistories(new Criteria(), $con)->diff($histories);


        $this->historiesScheduledForDeletion = $historiesToDelete;

        foreach ($historiesToDelete as $historyRemoved) {
            $historyRemoved->setUserDetail(null);
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
     * Returns the number of related RowHistory objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RowHistory objects.
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

            $query = ChildRowHistoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserDetail($this)
                ->count($con);
        }

        return count($this->collHistories);
    }

    /**
     * Method called to associate a ChildRowHistory object to this object
     * through the ChildRowHistory foreign key attribute.
     *
     * @param  ChildRowHistory $l ChildRowHistory
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function addHistory(ChildRowHistory $l)
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
     * @param ChildRowHistory $history The ChildRowHistory object to add.
     */
    protected function doAddHistory(ChildRowHistory $history)
    {
        $this->collHistories[]= $history;
        $history->setUserDetail($this);
    }

    /**
     * @param  ChildRowHistory $history The ChildRowHistory object to remove.
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function removeHistory(ChildRowHistory $history)
    {
        if ($this->getHistories()->contains($history)) {
            $pos = $this->collHistories->search($history);
            $this->collHistories->remove($pos);
            if (null === $this->historiesScheduledForDeletion) {
                $this->historiesScheduledForDeletion = clone $this->collHistories;
                $this->historiesScheduledForDeletion->clear();
            }
            $this->historiesScheduledForDeletion[]= $history;
            $history->setUserDetail(null);
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
     * If this ChildUserDetail is new, it will return
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
                    ->filterByCashier($this)
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
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function setSaless(Collection $saless, ConnectionInterface $con = null)
    {
        /** @var ChildSales[] $salessToDelete */
        $salessToDelete = $this->getSaless(new Criteria(), $con)->diff($saless);


        $this->salessScheduledForDeletion = $salessToDelete;

        foreach ($salessToDelete as $salesRemoved) {
            $salesRemoved->setCashier(null);
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
                ->filterByCashier($this)
                ->count($con);
        }

        return count($this->collSaless);
    }

    /**
     * Method called to associate a ChildSales object to this object
     * through the ChildSales foreign key attribute.
     *
     * @param  ChildSales $l ChildSales
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
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
        $sales->setCashier($this);
    }

    /**
     * @param  ChildSales $sales The ChildSales object to remove.
     * @return $this|ChildUserDetail The current object (for fluent API support)
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
            $sales->setCashier(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UserDetail is new, it will return
     * an empty collection; or if this UserDetail has previously
     * been saved, it will retrieve related Saless from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UserDetail.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSales[] List of ChildSales objects
     */
    public function getSalessJoinSecondParty(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSalesQuery::create(null, $criteria);
        $query->joinWith('SecondParty', $joinBehavior);

        return $this->getSaless($query, $con);
    }

    /**
     * Clears out the collSalesHistories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSalesHistories()
     */
    public function clearSalesHistories()
    {
        $this->collSalesHistories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSalesHistories collection loaded partially.
     */
    public function resetPartialSalesHistories($v = true)
    {
        $this->collSalesHistoriesPartial = $v;
    }

    /**
     * Initializes the collSalesHistories collection.
     *
     * By default this just sets the collSalesHistories collection to an empty array (like clearcollSalesHistories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSalesHistories($overrideExisting = true)
    {
        if (null !== $this->collSalesHistories && !$overrideExisting) {
            return;
        }
        $this->collSalesHistories = new ObjectCollection();
        $this->collSalesHistories->setModel('\ORM\SalesHistory');
    }

    /**
     * Gets an array of ChildSalesHistory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserDetail is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSalesHistory[] List of ChildSalesHistory objects
     * @throws PropelException
     */
    public function getSalesHistories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSalesHistoriesPartial && !$this->isNew();
        if (null === $this->collSalesHistories || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSalesHistories) {
                // return empty collection
                $this->initSalesHistories();
            } else {
                $collSalesHistories = ChildSalesHistoryQuery::create(null, $criteria)
                    ->filterByUserDetail($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSalesHistoriesPartial && count($collSalesHistories)) {
                        $this->initSalesHistories(false);

                        foreach ($collSalesHistories as $obj) {
                            if (false == $this->collSalesHistories->contains($obj)) {
                                $this->collSalesHistories->append($obj);
                            }
                        }

                        $this->collSalesHistoriesPartial = true;
                    }

                    return $collSalesHistories;
                }

                if ($partial && $this->collSalesHistories) {
                    foreach ($this->collSalesHistories as $obj) {
                        if ($obj->isNew()) {
                            $collSalesHistories[] = $obj;
                        }
                    }
                }

                $this->collSalesHistories = $collSalesHistories;
                $this->collSalesHistoriesPartial = false;
            }
        }

        return $this->collSalesHistories;
    }

    /**
     * Sets a collection of ChildSalesHistory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $salesHistories A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function setSalesHistories(Collection $salesHistories, ConnectionInterface $con = null)
    {
        /** @var ChildSalesHistory[] $salesHistoriesToDelete */
        $salesHistoriesToDelete = $this->getSalesHistories(new Criteria(), $con)->diff($salesHistories);


        $this->salesHistoriesScheduledForDeletion = $salesHistoriesToDelete;

        foreach ($salesHistoriesToDelete as $salesHistoryRemoved) {
            $salesHistoryRemoved->setUserDetail(null);
        }

        $this->collSalesHistories = null;
        foreach ($salesHistories as $salesHistory) {
            $this->addSalesHistory($salesHistory);
        }

        $this->collSalesHistories = $salesHistories;
        $this->collSalesHistoriesPartial = false;

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
    public function countSalesHistories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSalesHistoriesPartial && !$this->isNew();
        if (null === $this->collSalesHistories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSalesHistories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSalesHistories());
            }

            $query = ChildSalesHistoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserDetail($this)
                ->count($con);
        }

        return count($this->collSalesHistories);
    }

    /**
     * Method called to associate a ChildSalesHistory object to this object
     * through the ChildSalesHistory foreign key attribute.
     *
     * @param  ChildSalesHistory $l ChildSalesHistory
     * @return $this|\ORM\UserDetail The current object (for fluent API support)
     */
    public function addSalesHistory(ChildSalesHistory $l)
    {
        if ($this->collSalesHistories === null) {
            $this->initSalesHistories();
            $this->collSalesHistoriesPartial = true;
        }

        if (!$this->collSalesHistories->contains($l)) {
            $this->doAddSalesHistory($l);
        }

        return $this;
    }

    /**
     * @param ChildSalesHistory $salesHistory The ChildSalesHistory object to add.
     */
    protected function doAddSalesHistory(ChildSalesHistory $salesHistory)
    {
        $this->collSalesHistories[]= $salesHistory;
        $salesHistory->setUserDetail($this);
    }

    /**
     * @param  ChildSalesHistory $salesHistory The ChildSalesHistory object to remove.
     * @return $this|ChildUserDetail The current object (for fluent API support)
     */
    public function removeSalesHistory(ChildSalesHistory $salesHistory)
    {
        if ($this->getSalesHistories()->contains($salesHistory)) {
            $pos = $this->collSalesHistories->search($salesHistory);
            $this->collSalesHistories->remove($pos);
            if (null === $this->salesHistoriesScheduledForDeletion) {
                $this->salesHistoriesScheduledForDeletion = clone $this->collSalesHistories;
                $this->salesHistoriesScheduledForDeletion->clear();
            }
            $this->salesHistoriesScheduledForDeletion[]= $salesHistory;
            $salesHistory->setUserDetail(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UserDetail is new, it will return
     * an empty collection; or if this UserDetail has previously
     * been saved, it will retrieve related SalesHistories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UserDetail.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSalesHistory[] List of ChildSalesHistory objects
     */
    public function getSalesHistoriesJoinSales(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSalesHistoryQuery::create(null, $criteria);
        $query->joinWith('Sales', $joinBehavior);

        return $this->getSalesHistories($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUser) {
            $this->aUser->removeDetail($this);
        }
        $this->id = null;
        $this->name = null;
        $this->address = null;
        $this->phone = null;
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
            if ($this->collCreditPayments) {
                foreach ($this->collCreditPayments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDebitPayments) {
                foreach ($this->collDebitPayments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPurchaseHistories) {
                foreach ($this->collPurchaseHistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collHistories) {
                foreach ($this->collHistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSaless) {
                foreach ($this->collSaless as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSalesHistories) {
                foreach ($this->collSalesHistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCreditPayments = null;
        $this->collDebitPayments = null;
        $this->collPurchaseHistories = null;
        $this->collHistories = null;
        $this->collSaless = null;
        $this->collSalesHistories = null;
        $this->aUser = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserDetailTableMap::DEFAULT_STRING_FORMAT);
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
