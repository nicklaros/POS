<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\Role as ChildRole;
use ORM\RolePermissionQuery as ChildRolePermissionQuery;
use ORM\RoleQuery as ChildRoleQuery;
use ORM\Map\RolePermissionTableMap;
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

abstract class RolePermission implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ORM\\Map\\RolePermissionTableMap';


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
     * The value for the pay_credit field.
     * @var        boolean
     */
    protected $pay_credit;

    /**
     * The value for the read_credit field.
     * @var        boolean
     */
    protected $read_credit;

    /**
     * The value for the pay_debit field.
     * @var        boolean
     */
    protected $pay_debit;

    /**
     * The value for the read_debit field.
     * @var        boolean
     */
    protected $read_debit;

    /**
     * The value for the create_product field.
     * @var        boolean
     */
    protected $create_product;

    /**
     * The value for the read_product field.
     * @var        boolean
     */
    protected $read_product;

    /**
     * The value for the update_product field.
     * @var        boolean
     */
    protected $update_product;

    /**
     * The value for the destroy_product field.
     * @var        boolean
     */
    protected $destroy_product;

    /**
     * The value for the create_purchase field.
     * @var        boolean
     */
    protected $create_purchase;

    /**
     * The value for the read_purchase field.
     * @var        boolean
     */
    protected $read_purchase;

    /**
     * The value for the update_purchase field.
     * @var        boolean
     */
    protected $update_purchase;

    /**
     * The value for the destroy_purchase field.
     * @var        boolean
     */
    protected $destroy_purchase;

    /**
     * The value for the create_role field.
     * @var        boolean
     */
    protected $create_role;

    /**
     * The value for the read_role field.
     * @var        boolean
     */
    protected $read_role;

    /**
     * The value for the update_role field.
     * @var        boolean
     */
    protected $update_role;

    /**
     * The value for the destroy_role field.
     * @var        boolean
     */
    protected $destroy_role;

    /**
     * The value for the create_sales field.
     * @var        boolean
     */
    protected $create_sales;

    /**
     * The value for the read_sales field.
     * @var        boolean
     */
    protected $read_sales;

    /**
     * The value for the update_sales field.
     * @var        boolean
     */
    protected $update_sales;

    /**
     * The value for the destroy_sales field.
     * @var        boolean
     */
    protected $destroy_sales;

    /**
     * The value for the create_second_party field.
     * @var        boolean
     */
    protected $create_second_party;

    /**
     * The value for the read_second_party field.
     * @var        boolean
     */
    protected $read_second_party;

    /**
     * The value for the update_second_party field.
     * @var        boolean
     */
    protected $update_second_party;

    /**
     * The value for the destroy_second_party field.
     * @var        boolean
     */
    protected $destroy_second_party;

    /**
     * The value for the create_stock field.
     * @var        boolean
     */
    protected $create_stock;

    /**
     * The value for the read_stock field.
     * @var        boolean
     */
    protected $read_stock;

    /**
     * The value for the update_stock field.
     * @var        boolean
     */
    protected $update_stock;

    /**
     * The value for the destroy_stock field.
     * @var        boolean
     */
    protected $destroy_stock;

    /**
     * The value for the create_unit field.
     * @var        boolean
     */
    protected $create_unit;

    /**
     * The value for the read_unit field.
     * @var        boolean
     */
    protected $read_unit;

    /**
     * The value for the update_unit field.
     * @var        boolean
     */
    protected $update_unit;

    /**
     * The value for the destroy_unit field.
     * @var        boolean
     */
    protected $destroy_unit;

    /**
     * The value for the create_user field.
     * @var        boolean
     */
    protected $create_user;

    /**
     * The value for the read_user field.
     * @var        boolean
     */
    protected $read_user;

    /**
     * The value for the update_user field.
     * @var        boolean
     */
    protected $update_user;

    /**
     * The value for the destroy_user field.
     * @var        boolean
     */
    protected $destroy_user;

    /**
     * The value for the reset_pass_user field.
     * @var        boolean
     */
    protected $reset_pass_user;

    /**
     * @var        ChildRole
     */
    protected $aRole;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of ORM\Base\RolePermission object.
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
     * Compares this with another <code>RolePermission</code> instance.  If
     * <code>obj</code> is an instance of <code>RolePermission</code>, delegates to
     * <code>equals(RolePermission)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|RolePermission The current object, for fluid interface
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
     * Get the [pay_credit] column value.
     *
     * @return boolean
     */
    public function getPayCredit()
    {
        return $this->pay_credit;
    }

    /**
     * Get the [pay_credit] column value.
     *
     * @return boolean
     */
    public function isPayCredit()
    {
        return $this->getPayCredit();
    }

    /**
     * Get the [read_credit] column value.
     *
     * @return boolean
     */
    public function getReadCredit()
    {
        return $this->read_credit;
    }

    /**
     * Get the [read_credit] column value.
     *
     * @return boolean
     */
    public function isReadCredit()
    {
        return $this->getReadCredit();
    }

    /**
     * Get the [pay_debit] column value.
     *
     * @return boolean
     */
    public function getPayDebit()
    {
        return $this->pay_debit;
    }

    /**
     * Get the [pay_debit] column value.
     *
     * @return boolean
     */
    public function isPayDebit()
    {
        return $this->getPayDebit();
    }

    /**
     * Get the [read_debit] column value.
     *
     * @return boolean
     */
    public function getReadDebit()
    {
        return $this->read_debit;
    }

    /**
     * Get the [read_debit] column value.
     *
     * @return boolean
     */
    public function isReadDebit()
    {
        return $this->getReadDebit();
    }

    /**
     * Get the [create_product] column value.
     *
     * @return boolean
     */
    public function getCreateProduct()
    {
        return $this->create_product;
    }

    /**
     * Get the [create_product] column value.
     *
     * @return boolean
     */
    public function isCreateProduct()
    {
        return $this->getCreateProduct();
    }

    /**
     * Get the [read_product] column value.
     *
     * @return boolean
     */
    public function getReadProduct()
    {
        return $this->read_product;
    }

    /**
     * Get the [read_product] column value.
     *
     * @return boolean
     */
    public function isReadProduct()
    {
        return $this->getReadProduct();
    }

    /**
     * Get the [update_product] column value.
     *
     * @return boolean
     */
    public function getUpdateProduct()
    {
        return $this->update_product;
    }

    /**
     * Get the [update_product] column value.
     *
     * @return boolean
     */
    public function isUpdateProduct()
    {
        return $this->getUpdateProduct();
    }

    /**
     * Get the [destroy_product] column value.
     *
     * @return boolean
     */
    public function getDestroyProduct()
    {
        return $this->destroy_product;
    }

    /**
     * Get the [destroy_product] column value.
     *
     * @return boolean
     */
    public function isDestroyProduct()
    {
        return $this->getDestroyProduct();
    }

    /**
     * Get the [create_purchase] column value.
     *
     * @return boolean
     */
    public function getCreatePurchase()
    {
        return $this->create_purchase;
    }

    /**
     * Get the [create_purchase] column value.
     *
     * @return boolean
     */
    public function isCreatePurchase()
    {
        return $this->getCreatePurchase();
    }

    /**
     * Get the [read_purchase] column value.
     *
     * @return boolean
     */
    public function getReadPurchase()
    {
        return $this->read_purchase;
    }

    /**
     * Get the [read_purchase] column value.
     *
     * @return boolean
     */
    public function isReadPurchase()
    {
        return $this->getReadPurchase();
    }

    /**
     * Get the [update_purchase] column value.
     *
     * @return boolean
     */
    public function getUpdatePurchase()
    {
        return $this->update_purchase;
    }

    /**
     * Get the [update_purchase] column value.
     *
     * @return boolean
     */
    public function isUpdatePurchase()
    {
        return $this->getUpdatePurchase();
    }

    /**
     * Get the [destroy_purchase] column value.
     *
     * @return boolean
     */
    public function getDestroyPurchase()
    {
        return $this->destroy_purchase;
    }

    /**
     * Get the [destroy_purchase] column value.
     *
     * @return boolean
     */
    public function isDestroyPurchase()
    {
        return $this->getDestroyPurchase();
    }

    /**
     * Get the [create_role] column value.
     *
     * @return boolean
     */
    public function getCreateRole()
    {
        return $this->create_role;
    }

    /**
     * Get the [create_role] column value.
     *
     * @return boolean
     */
    public function isCreateRole()
    {
        return $this->getCreateRole();
    }

    /**
     * Get the [read_role] column value.
     *
     * @return boolean
     */
    public function getReadRole()
    {
        return $this->read_role;
    }

    /**
     * Get the [read_role] column value.
     *
     * @return boolean
     */
    public function isReadRole()
    {
        return $this->getReadRole();
    }

    /**
     * Get the [update_role] column value.
     *
     * @return boolean
     */
    public function getUpdateRole()
    {
        return $this->update_role;
    }

    /**
     * Get the [update_role] column value.
     *
     * @return boolean
     */
    public function isUpdateRole()
    {
        return $this->getUpdateRole();
    }

    /**
     * Get the [destroy_role] column value.
     *
     * @return boolean
     */
    public function getDestroyRole()
    {
        return $this->destroy_role;
    }

    /**
     * Get the [destroy_role] column value.
     *
     * @return boolean
     */
    public function isDestroyRole()
    {
        return $this->getDestroyRole();
    }

    /**
     * Get the [create_sales] column value.
     *
     * @return boolean
     */
    public function getCreateSales()
    {
        return $this->create_sales;
    }

    /**
     * Get the [create_sales] column value.
     *
     * @return boolean
     */
    public function isCreateSales()
    {
        return $this->getCreateSales();
    }

    /**
     * Get the [read_sales] column value.
     *
     * @return boolean
     */
    public function getReadSales()
    {
        return $this->read_sales;
    }

    /**
     * Get the [read_sales] column value.
     *
     * @return boolean
     */
    public function isReadSales()
    {
        return $this->getReadSales();
    }

    /**
     * Get the [update_sales] column value.
     *
     * @return boolean
     */
    public function getUpdateSales()
    {
        return $this->update_sales;
    }

    /**
     * Get the [update_sales] column value.
     *
     * @return boolean
     */
    public function isUpdateSales()
    {
        return $this->getUpdateSales();
    }

    /**
     * Get the [destroy_sales] column value.
     *
     * @return boolean
     */
    public function getDestroySales()
    {
        return $this->destroy_sales;
    }

    /**
     * Get the [destroy_sales] column value.
     *
     * @return boolean
     */
    public function isDestroySales()
    {
        return $this->getDestroySales();
    }

    /**
     * Get the [create_second_party] column value.
     *
     * @return boolean
     */
    public function getCreateSecondParty()
    {
        return $this->create_second_party;
    }

    /**
     * Get the [create_second_party] column value.
     *
     * @return boolean
     */
    public function isCreateSecondParty()
    {
        return $this->getCreateSecondParty();
    }

    /**
     * Get the [read_second_party] column value.
     *
     * @return boolean
     */
    public function getReadSecondParty()
    {
        return $this->read_second_party;
    }

    /**
     * Get the [read_second_party] column value.
     *
     * @return boolean
     */
    public function isReadSecondParty()
    {
        return $this->getReadSecondParty();
    }

    /**
     * Get the [update_second_party] column value.
     *
     * @return boolean
     */
    public function getUpdateSecondParty()
    {
        return $this->update_second_party;
    }

    /**
     * Get the [update_second_party] column value.
     *
     * @return boolean
     */
    public function isUpdateSecondParty()
    {
        return $this->getUpdateSecondParty();
    }

    /**
     * Get the [destroy_second_party] column value.
     *
     * @return boolean
     */
    public function getDestroySecondParty()
    {
        return $this->destroy_second_party;
    }

    /**
     * Get the [destroy_second_party] column value.
     *
     * @return boolean
     */
    public function isDestroySecondParty()
    {
        return $this->getDestroySecondParty();
    }

    /**
     * Get the [create_stock] column value.
     *
     * @return boolean
     */
    public function getCreateStock()
    {
        return $this->create_stock;
    }

    /**
     * Get the [create_stock] column value.
     *
     * @return boolean
     */
    public function isCreateStock()
    {
        return $this->getCreateStock();
    }

    /**
     * Get the [read_stock] column value.
     *
     * @return boolean
     */
    public function getReadStock()
    {
        return $this->read_stock;
    }

    /**
     * Get the [read_stock] column value.
     *
     * @return boolean
     */
    public function isReadStock()
    {
        return $this->getReadStock();
    }

    /**
     * Get the [update_stock] column value.
     *
     * @return boolean
     */
    public function getUpdateStock()
    {
        return $this->update_stock;
    }

    /**
     * Get the [update_stock] column value.
     *
     * @return boolean
     */
    public function isUpdateStock()
    {
        return $this->getUpdateStock();
    }

    /**
     * Get the [destroy_stock] column value.
     *
     * @return boolean
     */
    public function getDestroyStock()
    {
        return $this->destroy_stock;
    }

    /**
     * Get the [destroy_stock] column value.
     *
     * @return boolean
     */
    public function isDestroyStock()
    {
        return $this->getDestroyStock();
    }

    /**
     * Get the [create_unit] column value.
     *
     * @return boolean
     */
    public function getCreateUnit()
    {
        return $this->create_unit;
    }

    /**
     * Get the [create_unit] column value.
     *
     * @return boolean
     */
    public function isCreateUnit()
    {
        return $this->getCreateUnit();
    }

    /**
     * Get the [read_unit] column value.
     *
     * @return boolean
     */
    public function getReadUnit()
    {
        return $this->read_unit;
    }

    /**
     * Get the [read_unit] column value.
     *
     * @return boolean
     */
    public function isReadUnit()
    {
        return $this->getReadUnit();
    }

    /**
     * Get the [update_unit] column value.
     *
     * @return boolean
     */
    public function getUpdateUnit()
    {
        return $this->update_unit;
    }

    /**
     * Get the [update_unit] column value.
     *
     * @return boolean
     */
    public function isUpdateUnit()
    {
        return $this->getUpdateUnit();
    }

    /**
     * Get the [destroy_unit] column value.
     *
     * @return boolean
     */
    public function getDestroyUnit()
    {
        return $this->destroy_unit;
    }

    /**
     * Get the [destroy_unit] column value.
     *
     * @return boolean
     */
    public function isDestroyUnit()
    {
        return $this->getDestroyUnit();
    }

    /**
     * Get the [create_user] column value.
     *
     * @return boolean
     */
    public function getCreateUser()
    {
        return $this->create_user;
    }

    /**
     * Get the [create_user] column value.
     *
     * @return boolean
     */
    public function isCreateUser()
    {
        return $this->getCreateUser();
    }

    /**
     * Get the [read_user] column value.
     *
     * @return boolean
     */
    public function getReadUser()
    {
        return $this->read_user;
    }

    /**
     * Get the [read_user] column value.
     *
     * @return boolean
     */
    public function isReadUser()
    {
        return $this->getReadUser();
    }

    /**
     * Get the [update_user] column value.
     *
     * @return boolean
     */
    public function getUpdateUser()
    {
        return $this->update_user;
    }

    /**
     * Get the [update_user] column value.
     *
     * @return boolean
     */
    public function isUpdateUser()
    {
        return $this->getUpdateUser();
    }

    /**
     * Get the [destroy_user] column value.
     *
     * @return boolean
     */
    public function getDestroyUser()
    {
        return $this->destroy_user;
    }

    /**
     * Get the [destroy_user] column value.
     *
     * @return boolean
     */
    public function isDestroyUser()
    {
        return $this->getDestroyUser();
    }

    /**
     * Get the [reset_pass_user] column value.
     *
     * @return boolean
     */
    public function getResetPassUser()
    {
        return $this->reset_pass_user;
    }

    /**
     * Get the [reset_pass_user] column value.
     *
     * @return boolean
     */
    public function isResetPassUser()
    {
        return $this->getResetPassUser();
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RolePermissionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RolePermissionTableMap::translateFieldName('PayCredit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pay_credit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RolePermissionTableMap::translateFieldName('ReadCredit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_credit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RolePermissionTableMap::translateFieldName('PayDebit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pay_debit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RolePermissionTableMap::translateFieldName('ReadDebit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_debit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RolePermissionTableMap::translateFieldName('CreateProduct', TableMap::TYPE_PHPNAME, $indexType)];
            $this->create_product = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : RolePermissionTableMap::translateFieldName('ReadProduct', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_product = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : RolePermissionTableMap::translateFieldName('UpdateProduct', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_product = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : RolePermissionTableMap::translateFieldName('DestroyProduct', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destroy_product = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : RolePermissionTableMap::translateFieldName('CreatePurchase', TableMap::TYPE_PHPNAME, $indexType)];
            $this->create_purchase = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : RolePermissionTableMap::translateFieldName('ReadPurchase', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_purchase = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : RolePermissionTableMap::translateFieldName('UpdatePurchase', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_purchase = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : RolePermissionTableMap::translateFieldName('DestroyPurchase', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destroy_purchase = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : RolePermissionTableMap::translateFieldName('CreateRole', TableMap::TYPE_PHPNAME, $indexType)];
            $this->create_role = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : RolePermissionTableMap::translateFieldName('ReadRole', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_role = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : RolePermissionTableMap::translateFieldName('UpdateRole', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_role = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : RolePermissionTableMap::translateFieldName('DestroyRole', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destroy_role = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : RolePermissionTableMap::translateFieldName('CreateSales', TableMap::TYPE_PHPNAME, $indexType)];
            $this->create_sales = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : RolePermissionTableMap::translateFieldName('ReadSales', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_sales = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : RolePermissionTableMap::translateFieldName('UpdateSales', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_sales = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : RolePermissionTableMap::translateFieldName('DestroySales', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destroy_sales = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : RolePermissionTableMap::translateFieldName('CreateSecondParty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->create_second_party = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : RolePermissionTableMap::translateFieldName('ReadSecondParty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_second_party = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : RolePermissionTableMap::translateFieldName('UpdateSecondParty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_second_party = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : RolePermissionTableMap::translateFieldName('DestroySecondParty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destroy_second_party = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : RolePermissionTableMap::translateFieldName('CreateStock', TableMap::TYPE_PHPNAME, $indexType)];
            $this->create_stock = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : RolePermissionTableMap::translateFieldName('ReadStock', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_stock = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : RolePermissionTableMap::translateFieldName('UpdateStock', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_stock = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : RolePermissionTableMap::translateFieldName('DestroyStock', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destroy_stock = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : RolePermissionTableMap::translateFieldName('CreateUnit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->create_unit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : RolePermissionTableMap::translateFieldName('ReadUnit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_unit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : RolePermissionTableMap::translateFieldName('UpdateUnit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_unit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : RolePermissionTableMap::translateFieldName('DestroyUnit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destroy_unit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : RolePermissionTableMap::translateFieldName('CreateUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->create_user = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : RolePermissionTableMap::translateFieldName('ReadUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read_user = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : RolePermissionTableMap::translateFieldName('UpdateUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_user = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : RolePermissionTableMap::translateFieldName('DestroyUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destroy_user = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : RolePermissionTableMap::translateFieldName('ResetPassUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reset_pass_user = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 38; // 38 = RolePermissionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ORM\\RolePermission'), 0, $e);
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
        if ($this->aRole !== null && $this->id !== $this->aRole->getId()) {
            $this->aRole = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [id] column.
     *
     * @param  string $v new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_ID] = true;
        }

        if ($this->aRole !== null && $this->aRole->getId() !== $v) {
            $this->aRole = null;
        }

        return $this;
    } // setId()

    /**
     * Sets the value of the [pay_credit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setPayCredit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->pay_credit !== $v) {
            $this->pay_credit = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_PAY_CREDIT] = true;
        }

        return $this;
    } // setPayCredit()

    /**
     * Sets the value of the [read_credit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadCredit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_credit !== $v) {
            $this->read_credit = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_CREDIT] = true;
        }

        return $this;
    } // setReadCredit()

    /**
     * Sets the value of the [pay_debit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setPayDebit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->pay_debit !== $v) {
            $this->pay_debit = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_PAY_DEBIT] = true;
        }

        return $this;
    } // setPayDebit()

    /**
     * Sets the value of the [read_debit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadDebit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_debit !== $v) {
            $this->read_debit = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_DEBIT] = true;
        }

        return $this;
    } // setReadDebit()

    /**
     * Sets the value of the [create_product] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setCreateProduct($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->create_product !== $v) {
            $this->create_product = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_CREATE_PRODUCT] = true;
        }

        return $this;
    } // setCreateProduct()

    /**
     * Sets the value of the [read_product] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadProduct($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_product !== $v) {
            $this->read_product = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_PRODUCT] = true;
        }

        return $this;
    } // setReadProduct()

    /**
     * Sets the value of the [update_product] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setUpdateProduct($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->update_product !== $v) {
            $this->update_product = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_UPDATE_PRODUCT] = true;
        }

        return $this;
    } // setUpdateProduct()

    /**
     * Sets the value of the [destroy_product] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setDestroyProduct($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->destroy_product !== $v) {
            $this->destroy_product = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_DESTROY_PRODUCT] = true;
        }

        return $this;
    } // setDestroyProduct()

    /**
     * Sets the value of the [create_purchase] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setCreatePurchase($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->create_purchase !== $v) {
            $this->create_purchase = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_CREATE_PURCHASE] = true;
        }

        return $this;
    } // setCreatePurchase()

    /**
     * Sets the value of the [read_purchase] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadPurchase($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_purchase !== $v) {
            $this->read_purchase = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_PURCHASE] = true;
        }

        return $this;
    } // setReadPurchase()

    /**
     * Sets the value of the [update_purchase] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setUpdatePurchase($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->update_purchase !== $v) {
            $this->update_purchase = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_UPDATE_PURCHASE] = true;
        }

        return $this;
    } // setUpdatePurchase()

    /**
     * Sets the value of the [destroy_purchase] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setDestroyPurchase($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->destroy_purchase !== $v) {
            $this->destroy_purchase = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_DESTROY_PURCHASE] = true;
        }

        return $this;
    } // setDestroyPurchase()

    /**
     * Sets the value of the [create_role] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setCreateRole($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->create_role !== $v) {
            $this->create_role = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_CREATE_ROLE] = true;
        }

        return $this;
    } // setCreateRole()

    /**
     * Sets the value of the [read_role] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadRole($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_role !== $v) {
            $this->read_role = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_ROLE] = true;
        }

        return $this;
    } // setReadRole()

    /**
     * Sets the value of the [update_role] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setUpdateRole($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->update_role !== $v) {
            $this->update_role = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_UPDATE_ROLE] = true;
        }

        return $this;
    } // setUpdateRole()

    /**
     * Sets the value of the [destroy_role] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setDestroyRole($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->destroy_role !== $v) {
            $this->destroy_role = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_DESTROY_ROLE] = true;
        }

        return $this;
    } // setDestroyRole()

    /**
     * Sets the value of the [create_sales] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setCreateSales($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->create_sales !== $v) {
            $this->create_sales = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_CREATE_SALES] = true;
        }

        return $this;
    } // setCreateSales()

    /**
     * Sets the value of the [read_sales] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadSales($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_sales !== $v) {
            $this->read_sales = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_SALES] = true;
        }

        return $this;
    } // setReadSales()

    /**
     * Sets the value of the [update_sales] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setUpdateSales($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->update_sales !== $v) {
            $this->update_sales = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_UPDATE_SALES] = true;
        }

        return $this;
    } // setUpdateSales()

    /**
     * Sets the value of the [destroy_sales] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setDestroySales($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->destroy_sales !== $v) {
            $this->destroy_sales = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_DESTROY_SALES] = true;
        }

        return $this;
    } // setDestroySales()

    /**
     * Sets the value of the [create_second_party] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setCreateSecondParty($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->create_second_party !== $v) {
            $this->create_second_party = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_CREATE_SECOND_PARTY] = true;
        }

        return $this;
    } // setCreateSecondParty()

    /**
     * Sets the value of the [read_second_party] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadSecondParty($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_second_party !== $v) {
            $this->read_second_party = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_SECOND_PARTY] = true;
        }

        return $this;
    } // setReadSecondParty()

    /**
     * Sets the value of the [update_second_party] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setUpdateSecondParty($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->update_second_party !== $v) {
            $this->update_second_party = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_UPDATE_SECOND_PARTY] = true;
        }

        return $this;
    } // setUpdateSecondParty()

    /**
     * Sets the value of the [destroy_second_party] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setDestroySecondParty($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->destroy_second_party !== $v) {
            $this->destroy_second_party = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_DESTROY_SECOND_PARTY] = true;
        }

        return $this;
    } // setDestroySecondParty()

    /**
     * Sets the value of the [create_stock] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setCreateStock($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->create_stock !== $v) {
            $this->create_stock = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_CREATE_STOCK] = true;
        }

        return $this;
    } // setCreateStock()

    /**
     * Sets the value of the [read_stock] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadStock($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_stock !== $v) {
            $this->read_stock = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_STOCK] = true;
        }

        return $this;
    } // setReadStock()

    /**
     * Sets the value of the [update_stock] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setUpdateStock($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->update_stock !== $v) {
            $this->update_stock = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_UPDATE_STOCK] = true;
        }

        return $this;
    } // setUpdateStock()

    /**
     * Sets the value of the [destroy_stock] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setDestroyStock($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->destroy_stock !== $v) {
            $this->destroy_stock = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_DESTROY_STOCK] = true;
        }

        return $this;
    } // setDestroyStock()

    /**
     * Sets the value of the [create_unit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setCreateUnit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->create_unit !== $v) {
            $this->create_unit = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_CREATE_UNIT] = true;
        }

        return $this;
    } // setCreateUnit()

    /**
     * Sets the value of the [read_unit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadUnit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_unit !== $v) {
            $this->read_unit = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_UNIT] = true;
        }

        return $this;
    } // setReadUnit()

    /**
     * Sets the value of the [update_unit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setUpdateUnit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->update_unit !== $v) {
            $this->update_unit = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_UPDATE_UNIT] = true;
        }

        return $this;
    } // setUpdateUnit()

    /**
     * Sets the value of the [destroy_unit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setDestroyUnit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->destroy_unit !== $v) {
            $this->destroy_unit = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_DESTROY_UNIT] = true;
        }

        return $this;
    } // setDestroyUnit()

    /**
     * Sets the value of the [create_user] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setCreateUser($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->create_user !== $v) {
            $this->create_user = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_CREATE_USER] = true;
        }

        return $this;
    } // setCreateUser()

    /**
     * Sets the value of the [read_user] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setReadUser($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read_user !== $v) {
            $this->read_user = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_READ_USER] = true;
        }

        return $this;
    } // setReadUser()

    /**
     * Sets the value of the [update_user] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setUpdateUser($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->update_user !== $v) {
            $this->update_user = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_UPDATE_USER] = true;
        }

        return $this;
    } // setUpdateUser()

    /**
     * Sets the value of the [destroy_user] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setDestroyUser($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->destroy_user !== $v) {
            $this->destroy_user = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_DESTROY_USER] = true;
        }

        return $this;
    } // setDestroyUser()

    /**
     * Sets the value of the [reset_pass_user] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     */
    public function setResetPassUser($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->reset_pass_user !== $v) {
            $this->reset_pass_user = $v;
            $this->modifiedColumns[RolePermissionTableMap::COL_RESET_PASS_USER] = true;
        }

        return $this;
    } // setResetPassUser()

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
            $con = Propel::getServiceContainer()->getReadConnection(RolePermissionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRolePermissionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aRole = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see RolePermission::setDeleted()
     * @see RolePermission::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolePermissionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRolePermissionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RolePermissionTableMap::DATABASE_NAME);
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
                RolePermissionTableMap::addInstanceToPool($this);
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

            if ($this->aRole !== null) {
                if ($this->aRole->isModified() || $this->aRole->isNew()) {
                    $affectedRows += $this->aRole->save($con);
                }
                $this->setRole($this->aRole);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RolePermissionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_PAY_CREDIT)) {
            $modifiedColumns[':p' . $index++]  = 'PAY_CREDIT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_CREDIT)) {
            $modifiedColumns[':p' . $index++]  = 'READ_CREDIT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_PAY_DEBIT)) {
            $modifiedColumns[':p' . $index++]  = 'PAY_DEBIT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_DEBIT)) {
            $modifiedColumns[':p' . $index++]  = 'READ_DEBIT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_PRODUCT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_PRODUCT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_PRODUCT)) {
            $modifiedColumns[':p' . $index++]  = 'READ_PRODUCT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_PRODUCT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_PRODUCT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_PRODUCT)) {
            $modifiedColumns[':p' . $index++]  = 'DESTROY_PRODUCT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_PURCHASE)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_PURCHASE';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_PURCHASE)) {
            $modifiedColumns[':p' . $index++]  = 'READ_PURCHASE';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_PURCHASE)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_PURCHASE';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_PURCHASE)) {
            $modifiedColumns[':p' . $index++]  = 'DESTROY_PURCHASE';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_ROLE';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'READ_ROLE';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_ROLE';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'DESTROY_ROLE';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_SALES)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_SALES';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_SALES)) {
            $modifiedColumns[':p' . $index++]  = 'READ_SALES';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_SALES)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_SALES';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_SALES)) {
            $modifiedColumns[':p' . $index++]  = 'DESTROY_SALES';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_SECOND_PARTY)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_SECOND_PARTY';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_SECOND_PARTY)) {
            $modifiedColumns[':p' . $index++]  = 'READ_SECOND_PARTY';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_SECOND_PARTY)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_SECOND_PARTY';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_SECOND_PARTY)) {
            $modifiedColumns[':p' . $index++]  = 'DESTROY_SECOND_PARTY';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_STOCK)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_STOCK';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_STOCK)) {
            $modifiedColumns[':p' . $index++]  = 'READ_STOCK';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_STOCK)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_STOCK';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_STOCK)) {
            $modifiedColumns[':p' . $index++]  = 'DESTROY_STOCK';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_UNIT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_UNIT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_UNIT)) {
            $modifiedColumns[':p' . $index++]  = 'READ_UNIT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_UNIT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_UNIT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_UNIT)) {
            $modifiedColumns[':p' . $index++]  = 'DESTROY_UNIT';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_USER)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_USER';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_USER)) {
            $modifiedColumns[':p' . $index++]  = 'READ_USER';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_USER)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_USER';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_USER)) {
            $modifiedColumns[':p' . $index++]  = 'DESTROY_USER';
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_RESET_PASS_USER)) {
            $modifiedColumns[':p' . $index++]  = 'RESET_PASS_USER';
        }

        $sql = sprintf(
            'INSERT INTO role_permission (%s) VALUES (%s)',
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
                    case 'PAY_CREDIT':
                        $stmt->bindValue($identifier, (int) $this->pay_credit, PDO::PARAM_INT);
                        break;
                    case 'READ_CREDIT':
                        $stmt->bindValue($identifier, (int) $this->read_credit, PDO::PARAM_INT);
                        break;
                    case 'PAY_DEBIT':
                        $stmt->bindValue($identifier, (int) $this->pay_debit, PDO::PARAM_INT);
                        break;
                    case 'READ_DEBIT':
                        $stmt->bindValue($identifier, (int) $this->read_debit, PDO::PARAM_INT);
                        break;
                    case 'CREATE_PRODUCT':
                        $stmt->bindValue($identifier, (int) $this->create_product, PDO::PARAM_INT);
                        break;
                    case 'READ_PRODUCT':
                        $stmt->bindValue($identifier, (int) $this->read_product, PDO::PARAM_INT);
                        break;
                    case 'UPDATE_PRODUCT':
                        $stmt->bindValue($identifier, (int) $this->update_product, PDO::PARAM_INT);
                        break;
                    case 'DESTROY_PRODUCT':
                        $stmt->bindValue($identifier, (int) $this->destroy_product, PDO::PARAM_INT);
                        break;
                    case 'CREATE_PURCHASE':
                        $stmt->bindValue($identifier, (int) $this->create_purchase, PDO::PARAM_INT);
                        break;
                    case 'READ_PURCHASE':
                        $stmt->bindValue($identifier, (int) $this->read_purchase, PDO::PARAM_INT);
                        break;
                    case 'UPDATE_PURCHASE':
                        $stmt->bindValue($identifier, (int) $this->update_purchase, PDO::PARAM_INT);
                        break;
                    case 'DESTROY_PURCHASE':
                        $stmt->bindValue($identifier, (int) $this->destroy_purchase, PDO::PARAM_INT);
                        break;
                    case 'CREATE_ROLE':
                        $stmt->bindValue($identifier, (int) $this->create_role, PDO::PARAM_INT);
                        break;
                    case 'READ_ROLE':
                        $stmt->bindValue($identifier, (int) $this->read_role, PDO::PARAM_INT);
                        break;
                    case 'UPDATE_ROLE':
                        $stmt->bindValue($identifier, (int) $this->update_role, PDO::PARAM_INT);
                        break;
                    case 'DESTROY_ROLE':
                        $stmt->bindValue($identifier, (int) $this->destroy_role, PDO::PARAM_INT);
                        break;
                    case 'CREATE_SALES':
                        $stmt->bindValue($identifier, (int) $this->create_sales, PDO::PARAM_INT);
                        break;
                    case 'READ_SALES':
                        $stmt->bindValue($identifier, (int) $this->read_sales, PDO::PARAM_INT);
                        break;
                    case 'UPDATE_SALES':
                        $stmt->bindValue($identifier, (int) $this->update_sales, PDO::PARAM_INT);
                        break;
                    case 'DESTROY_SALES':
                        $stmt->bindValue($identifier, (int) $this->destroy_sales, PDO::PARAM_INT);
                        break;
                    case 'CREATE_SECOND_PARTY':
                        $stmt->bindValue($identifier, (int) $this->create_second_party, PDO::PARAM_INT);
                        break;
                    case 'READ_SECOND_PARTY':
                        $stmt->bindValue($identifier, (int) $this->read_second_party, PDO::PARAM_INT);
                        break;
                    case 'UPDATE_SECOND_PARTY':
                        $stmt->bindValue($identifier, (int) $this->update_second_party, PDO::PARAM_INT);
                        break;
                    case 'DESTROY_SECOND_PARTY':
                        $stmt->bindValue($identifier, (int) $this->destroy_second_party, PDO::PARAM_INT);
                        break;
                    case 'CREATE_STOCK':
                        $stmt->bindValue($identifier, (int) $this->create_stock, PDO::PARAM_INT);
                        break;
                    case 'READ_STOCK':
                        $stmt->bindValue($identifier, (int) $this->read_stock, PDO::PARAM_INT);
                        break;
                    case 'UPDATE_STOCK':
                        $stmt->bindValue($identifier, (int) $this->update_stock, PDO::PARAM_INT);
                        break;
                    case 'DESTROY_STOCK':
                        $stmt->bindValue($identifier, (int) $this->destroy_stock, PDO::PARAM_INT);
                        break;
                    case 'CREATE_UNIT':
                        $stmt->bindValue($identifier, (int) $this->create_unit, PDO::PARAM_INT);
                        break;
                    case 'READ_UNIT':
                        $stmt->bindValue($identifier, (int) $this->read_unit, PDO::PARAM_INT);
                        break;
                    case 'UPDATE_UNIT':
                        $stmt->bindValue($identifier, (int) $this->update_unit, PDO::PARAM_INT);
                        break;
                    case 'DESTROY_UNIT':
                        $stmt->bindValue($identifier, (int) $this->destroy_unit, PDO::PARAM_INT);
                        break;
                    case 'CREATE_USER':
                        $stmt->bindValue($identifier, (int) $this->create_user, PDO::PARAM_INT);
                        break;
                    case 'READ_USER':
                        $stmt->bindValue($identifier, (int) $this->read_user, PDO::PARAM_INT);
                        break;
                    case 'UPDATE_USER':
                        $stmt->bindValue($identifier, (int) $this->update_user, PDO::PARAM_INT);
                        break;
                    case 'DESTROY_USER':
                        $stmt->bindValue($identifier, (int) $this->destroy_user, PDO::PARAM_INT);
                        break;
                    case 'RESET_PASS_USER':
                        $stmt->bindValue($identifier, (int) $this->reset_pass_user, PDO::PARAM_INT);
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
        $pos = RolePermissionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPayCredit();
                break;
            case 2:
                return $this->getReadCredit();
                break;
            case 3:
                return $this->getPayDebit();
                break;
            case 4:
                return $this->getReadDebit();
                break;
            case 5:
                return $this->getCreateProduct();
                break;
            case 6:
                return $this->getReadProduct();
                break;
            case 7:
                return $this->getUpdateProduct();
                break;
            case 8:
                return $this->getDestroyProduct();
                break;
            case 9:
                return $this->getCreatePurchase();
                break;
            case 10:
                return $this->getReadPurchase();
                break;
            case 11:
                return $this->getUpdatePurchase();
                break;
            case 12:
                return $this->getDestroyPurchase();
                break;
            case 13:
                return $this->getCreateRole();
                break;
            case 14:
                return $this->getReadRole();
                break;
            case 15:
                return $this->getUpdateRole();
                break;
            case 16:
                return $this->getDestroyRole();
                break;
            case 17:
                return $this->getCreateSales();
                break;
            case 18:
                return $this->getReadSales();
                break;
            case 19:
                return $this->getUpdateSales();
                break;
            case 20:
                return $this->getDestroySales();
                break;
            case 21:
                return $this->getCreateSecondParty();
                break;
            case 22:
                return $this->getReadSecondParty();
                break;
            case 23:
                return $this->getUpdateSecondParty();
                break;
            case 24:
                return $this->getDestroySecondParty();
                break;
            case 25:
                return $this->getCreateStock();
                break;
            case 26:
                return $this->getReadStock();
                break;
            case 27:
                return $this->getUpdateStock();
                break;
            case 28:
                return $this->getDestroyStock();
                break;
            case 29:
                return $this->getCreateUnit();
                break;
            case 30:
                return $this->getReadUnit();
                break;
            case 31:
                return $this->getUpdateUnit();
                break;
            case 32:
                return $this->getDestroyUnit();
                break;
            case 33:
                return $this->getCreateUser();
                break;
            case 34:
                return $this->getReadUser();
                break;
            case 35:
                return $this->getUpdateUser();
                break;
            case 36:
                return $this->getDestroyUser();
                break;
            case 37:
                return $this->getResetPassUser();
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
        if (isset($alreadyDumpedObjects['RolePermission'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['RolePermission'][$this->getPrimaryKey()] = true;
        $keys = RolePermissionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPayCredit(),
            $keys[2] => $this->getReadCredit(),
            $keys[3] => $this->getPayDebit(),
            $keys[4] => $this->getReadDebit(),
            $keys[5] => $this->getCreateProduct(),
            $keys[6] => $this->getReadProduct(),
            $keys[7] => $this->getUpdateProduct(),
            $keys[8] => $this->getDestroyProduct(),
            $keys[9] => $this->getCreatePurchase(),
            $keys[10] => $this->getReadPurchase(),
            $keys[11] => $this->getUpdatePurchase(),
            $keys[12] => $this->getDestroyPurchase(),
            $keys[13] => $this->getCreateRole(),
            $keys[14] => $this->getReadRole(),
            $keys[15] => $this->getUpdateRole(),
            $keys[16] => $this->getDestroyRole(),
            $keys[17] => $this->getCreateSales(),
            $keys[18] => $this->getReadSales(),
            $keys[19] => $this->getUpdateSales(),
            $keys[20] => $this->getDestroySales(),
            $keys[21] => $this->getCreateSecondParty(),
            $keys[22] => $this->getReadSecondParty(),
            $keys[23] => $this->getUpdateSecondParty(),
            $keys[24] => $this->getDestroySecondParty(),
            $keys[25] => $this->getCreateStock(),
            $keys[26] => $this->getReadStock(),
            $keys[27] => $this->getUpdateStock(),
            $keys[28] => $this->getDestroyStock(),
            $keys[29] => $this->getCreateUnit(),
            $keys[30] => $this->getReadUnit(),
            $keys[31] => $this->getUpdateUnit(),
            $keys[32] => $this->getDestroyUnit(),
            $keys[33] => $this->getCreateUser(),
            $keys[34] => $this->getReadUser(),
            $keys[35] => $this->getUpdateUser(),
            $keys[36] => $this->getDestroyUser(),
            $keys[37] => $this->getResetPassUser(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aRole) {
                $result['Role'] = $this->aRole->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\ORM\RolePermission
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RolePermissionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ORM\RolePermission
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPayCredit($value);
                break;
            case 2:
                $this->setReadCredit($value);
                break;
            case 3:
                $this->setPayDebit($value);
                break;
            case 4:
                $this->setReadDebit($value);
                break;
            case 5:
                $this->setCreateProduct($value);
                break;
            case 6:
                $this->setReadProduct($value);
                break;
            case 7:
                $this->setUpdateProduct($value);
                break;
            case 8:
                $this->setDestroyProduct($value);
                break;
            case 9:
                $this->setCreatePurchase($value);
                break;
            case 10:
                $this->setReadPurchase($value);
                break;
            case 11:
                $this->setUpdatePurchase($value);
                break;
            case 12:
                $this->setDestroyPurchase($value);
                break;
            case 13:
                $this->setCreateRole($value);
                break;
            case 14:
                $this->setReadRole($value);
                break;
            case 15:
                $this->setUpdateRole($value);
                break;
            case 16:
                $this->setDestroyRole($value);
                break;
            case 17:
                $this->setCreateSales($value);
                break;
            case 18:
                $this->setReadSales($value);
                break;
            case 19:
                $this->setUpdateSales($value);
                break;
            case 20:
                $this->setDestroySales($value);
                break;
            case 21:
                $this->setCreateSecondParty($value);
                break;
            case 22:
                $this->setReadSecondParty($value);
                break;
            case 23:
                $this->setUpdateSecondParty($value);
                break;
            case 24:
                $this->setDestroySecondParty($value);
                break;
            case 25:
                $this->setCreateStock($value);
                break;
            case 26:
                $this->setReadStock($value);
                break;
            case 27:
                $this->setUpdateStock($value);
                break;
            case 28:
                $this->setDestroyStock($value);
                break;
            case 29:
                $this->setCreateUnit($value);
                break;
            case 30:
                $this->setReadUnit($value);
                break;
            case 31:
                $this->setUpdateUnit($value);
                break;
            case 32:
                $this->setDestroyUnit($value);
                break;
            case 33:
                $this->setCreateUser($value);
                break;
            case 34:
                $this->setReadUser($value);
                break;
            case 35:
                $this->setUpdateUser($value);
                break;
            case 36:
                $this->setDestroyUser($value);
                break;
            case 37:
                $this->setResetPassUser($value);
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
        $keys = RolePermissionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPayCredit($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setReadCredit($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPayDebit($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setReadDebit($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreateProduct($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setReadProduct($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setUpdateProduct($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDestroyProduct($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCreatePurchase($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setReadPurchase($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUpdatePurchase($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setDestroyPurchase($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setCreateRole($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setReadRole($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setUpdateRole($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setDestroyRole($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setCreateSales($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setReadSales($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setUpdateSales($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setDestroySales($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setCreateSecondParty($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setReadSecondParty($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setUpdateSecondParty($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setDestroySecondParty($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setCreateStock($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setReadStock($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->setUpdateStock($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->setDestroyStock($arr[$keys[28]]);
        }
        if (array_key_exists($keys[29], $arr)) {
            $this->setCreateUnit($arr[$keys[29]]);
        }
        if (array_key_exists($keys[30], $arr)) {
            $this->setReadUnit($arr[$keys[30]]);
        }
        if (array_key_exists($keys[31], $arr)) {
            $this->setUpdateUnit($arr[$keys[31]]);
        }
        if (array_key_exists($keys[32], $arr)) {
            $this->setDestroyUnit($arr[$keys[32]]);
        }
        if (array_key_exists($keys[33], $arr)) {
            $this->setCreateUser($arr[$keys[33]]);
        }
        if (array_key_exists($keys[34], $arr)) {
            $this->setReadUser($arr[$keys[34]]);
        }
        if (array_key_exists($keys[35], $arr)) {
            $this->setUpdateUser($arr[$keys[35]]);
        }
        if (array_key_exists($keys[36], $arr)) {
            $this->setDestroyUser($arr[$keys[36]]);
        }
        if (array_key_exists($keys[37], $arr)) {
            $this->setResetPassUser($arr[$keys[37]]);
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
     * @return $this|\ORM\RolePermission The current object, for fluid interface
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
        $criteria = new Criteria(RolePermissionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RolePermissionTableMap::COL_ID)) {
            $criteria->add(RolePermissionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_PAY_CREDIT)) {
            $criteria->add(RolePermissionTableMap::COL_PAY_CREDIT, $this->pay_credit);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_CREDIT)) {
            $criteria->add(RolePermissionTableMap::COL_READ_CREDIT, $this->read_credit);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_PAY_DEBIT)) {
            $criteria->add(RolePermissionTableMap::COL_PAY_DEBIT, $this->pay_debit);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_DEBIT)) {
            $criteria->add(RolePermissionTableMap::COL_READ_DEBIT, $this->read_debit);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_PRODUCT)) {
            $criteria->add(RolePermissionTableMap::COL_CREATE_PRODUCT, $this->create_product);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_PRODUCT)) {
            $criteria->add(RolePermissionTableMap::COL_READ_PRODUCT, $this->read_product);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_PRODUCT)) {
            $criteria->add(RolePermissionTableMap::COL_UPDATE_PRODUCT, $this->update_product);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_PRODUCT)) {
            $criteria->add(RolePermissionTableMap::COL_DESTROY_PRODUCT, $this->destroy_product);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_PURCHASE)) {
            $criteria->add(RolePermissionTableMap::COL_CREATE_PURCHASE, $this->create_purchase);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_PURCHASE)) {
            $criteria->add(RolePermissionTableMap::COL_READ_PURCHASE, $this->read_purchase);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_PURCHASE)) {
            $criteria->add(RolePermissionTableMap::COL_UPDATE_PURCHASE, $this->update_purchase);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_PURCHASE)) {
            $criteria->add(RolePermissionTableMap::COL_DESTROY_PURCHASE, $this->destroy_purchase);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_ROLE)) {
            $criteria->add(RolePermissionTableMap::COL_CREATE_ROLE, $this->create_role);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_ROLE)) {
            $criteria->add(RolePermissionTableMap::COL_READ_ROLE, $this->read_role);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_ROLE)) {
            $criteria->add(RolePermissionTableMap::COL_UPDATE_ROLE, $this->update_role);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_ROLE)) {
            $criteria->add(RolePermissionTableMap::COL_DESTROY_ROLE, $this->destroy_role);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_SALES)) {
            $criteria->add(RolePermissionTableMap::COL_CREATE_SALES, $this->create_sales);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_SALES)) {
            $criteria->add(RolePermissionTableMap::COL_READ_SALES, $this->read_sales);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_SALES)) {
            $criteria->add(RolePermissionTableMap::COL_UPDATE_SALES, $this->update_sales);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_SALES)) {
            $criteria->add(RolePermissionTableMap::COL_DESTROY_SALES, $this->destroy_sales);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_SECOND_PARTY)) {
            $criteria->add(RolePermissionTableMap::COL_CREATE_SECOND_PARTY, $this->create_second_party);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_SECOND_PARTY)) {
            $criteria->add(RolePermissionTableMap::COL_READ_SECOND_PARTY, $this->read_second_party);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_SECOND_PARTY)) {
            $criteria->add(RolePermissionTableMap::COL_UPDATE_SECOND_PARTY, $this->update_second_party);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_SECOND_PARTY)) {
            $criteria->add(RolePermissionTableMap::COL_DESTROY_SECOND_PARTY, $this->destroy_second_party);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_STOCK)) {
            $criteria->add(RolePermissionTableMap::COL_CREATE_STOCK, $this->create_stock);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_STOCK)) {
            $criteria->add(RolePermissionTableMap::COL_READ_STOCK, $this->read_stock);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_STOCK)) {
            $criteria->add(RolePermissionTableMap::COL_UPDATE_STOCK, $this->update_stock);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_STOCK)) {
            $criteria->add(RolePermissionTableMap::COL_DESTROY_STOCK, $this->destroy_stock);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_UNIT)) {
            $criteria->add(RolePermissionTableMap::COL_CREATE_UNIT, $this->create_unit);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_UNIT)) {
            $criteria->add(RolePermissionTableMap::COL_READ_UNIT, $this->read_unit);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_UNIT)) {
            $criteria->add(RolePermissionTableMap::COL_UPDATE_UNIT, $this->update_unit);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_UNIT)) {
            $criteria->add(RolePermissionTableMap::COL_DESTROY_UNIT, $this->destroy_unit);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_CREATE_USER)) {
            $criteria->add(RolePermissionTableMap::COL_CREATE_USER, $this->create_user);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_READ_USER)) {
            $criteria->add(RolePermissionTableMap::COL_READ_USER, $this->read_user);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_UPDATE_USER)) {
            $criteria->add(RolePermissionTableMap::COL_UPDATE_USER, $this->update_user);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_DESTROY_USER)) {
            $criteria->add(RolePermissionTableMap::COL_DESTROY_USER, $this->destroy_user);
        }
        if ($this->isColumnModified(RolePermissionTableMap::COL_RESET_PASS_USER)) {
            $criteria->add(RolePermissionTableMap::COL_RESET_PASS_USER, $this->reset_pass_user);
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
        $criteria = new Criteria(RolePermissionTableMap::DATABASE_NAME);
        $criteria->add(RolePermissionTableMap::COL_ID, $this->id);

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

        //relation role_permission_fk_2e540b to table role
        if ($this->aRole && $hash = spl_object_hash($this->aRole)) {
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
     * @param      object $copyObj An object of \ORM\RolePermission (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setPayCredit($this->getPayCredit());
        $copyObj->setReadCredit($this->getReadCredit());
        $copyObj->setPayDebit($this->getPayDebit());
        $copyObj->setReadDebit($this->getReadDebit());
        $copyObj->setCreateProduct($this->getCreateProduct());
        $copyObj->setReadProduct($this->getReadProduct());
        $copyObj->setUpdateProduct($this->getUpdateProduct());
        $copyObj->setDestroyProduct($this->getDestroyProduct());
        $copyObj->setCreatePurchase($this->getCreatePurchase());
        $copyObj->setReadPurchase($this->getReadPurchase());
        $copyObj->setUpdatePurchase($this->getUpdatePurchase());
        $copyObj->setDestroyPurchase($this->getDestroyPurchase());
        $copyObj->setCreateRole($this->getCreateRole());
        $copyObj->setReadRole($this->getReadRole());
        $copyObj->setUpdateRole($this->getUpdateRole());
        $copyObj->setDestroyRole($this->getDestroyRole());
        $copyObj->setCreateSales($this->getCreateSales());
        $copyObj->setReadSales($this->getReadSales());
        $copyObj->setUpdateSales($this->getUpdateSales());
        $copyObj->setDestroySales($this->getDestroySales());
        $copyObj->setCreateSecondParty($this->getCreateSecondParty());
        $copyObj->setReadSecondParty($this->getReadSecondParty());
        $copyObj->setUpdateSecondParty($this->getUpdateSecondParty());
        $copyObj->setDestroySecondParty($this->getDestroySecondParty());
        $copyObj->setCreateStock($this->getCreateStock());
        $copyObj->setReadStock($this->getReadStock());
        $copyObj->setUpdateStock($this->getUpdateStock());
        $copyObj->setDestroyStock($this->getDestroyStock());
        $copyObj->setCreateUnit($this->getCreateUnit());
        $copyObj->setReadUnit($this->getReadUnit());
        $copyObj->setUpdateUnit($this->getUpdateUnit());
        $copyObj->setDestroyUnit($this->getDestroyUnit());
        $copyObj->setCreateUser($this->getCreateUser());
        $copyObj->setReadUser($this->getReadUser());
        $copyObj->setUpdateUser($this->getUpdateUser());
        $copyObj->setDestroyUser($this->getDestroyUser());
        $copyObj->setResetPassUser($this->getResetPassUser());
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
     * @return \ORM\RolePermission Clone of current object.
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
     * Declares an association between this object and a ChildRole object.
     *
     * @param  ChildRole $v
     * @return $this|\ORM\RolePermission The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRole(ChildRole $v = null)
    {
        if ($v === null) {
            $this->setId(NULL);
        } else {
            $this->setId($v->getId());
        }

        $this->aRole = $v;

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setPermission($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildRole object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildRole The associated ChildRole object.
     * @throws PropelException
     */
    public function getRole(ConnectionInterface $con = null)
    {
        if ($this->aRole === null && (($this->id !== "" && $this->id !== null))) {
            $this->aRole = ChildRoleQuery::create()->findPk($this->id, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aRole->setPermission($this);
        }

        return $this->aRole;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aRole) {
            $this->aRole->removePermission($this);
        }
        $this->id = null;
        $this->pay_credit = null;
        $this->read_credit = null;
        $this->pay_debit = null;
        $this->read_debit = null;
        $this->create_product = null;
        $this->read_product = null;
        $this->update_product = null;
        $this->destroy_product = null;
        $this->create_purchase = null;
        $this->read_purchase = null;
        $this->update_purchase = null;
        $this->destroy_purchase = null;
        $this->create_role = null;
        $this->read_role = null;
        $this->update_role = null;
        $this->destroy_role = null;
        $this->create_sales = null;
        $this->read_sales = null;
        $this->update_sales = null;
        $this->destroy_sales = null;
        $this->create_second_party = null;
        $this->read_second_party = null;
        $this->update_second_party = null;
        $this->destroy_second_party = null;
        $this->create_stock = null;
        $this->read_stock = null;
        $this->update_stock = null;
        $this->destroy_stock = null;
        $this->create_unit = null;
        $this->read_unit = null;
        $this->update_unit = null;
        $this->destroy_unit = null;
        $this->create_user = null;
        $this->read_user = null;
        $this->update_user = null;
        $this->destroy_user = null;
        $this->reset_pass_user = null;
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

        $this->aRole = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RolePermissionTableMap::DEFAULT_STRING_FORMAT);
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
