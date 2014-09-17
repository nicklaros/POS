<?php

namespace ORM\Map;

use ORM\RolePermission;
use ORM\RolePermissionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'role_permission' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RolePermissionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.RolePermissionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'role_permission';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\RolePermission';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.RolePermission';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 24;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 24;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'role_permission.ID';

    /**
     * the column name for the PAY_CREDIT field
     */
    const COL_PAY_CREDIT = 'role_permission.PAY_CREDIT';

    /**
     * the column name for the READ_CREDIT field
     */
    const COL_READ_CREDIT = 'role_permission.READ_CREDIT';

    /**
     * the column name for the CREATE_PRODUCT field
     */
    const COL_CREATE_PRODUCT = 'role_permission.CREATE_PRODUCT';

    /**
     * the column name for the READ_PRODUCT field
     */
    const COL_READ_PRODUCT = 'role_permission.READ_PRODUCT';

    /**
     * the column name for the UPDATE_PRODUCT field
     */
    const COL_UPDATE_PRODUCT = 'role_permission.UPDATE_PRODUCT';

    /**
     * the column name for the DESTROY_PRODUCT field
     */
    const COL_DESTROY_PRODUCT = 'role_permission.DESTROY_PRODUCT';

    /**
     * the column name for the CREATE_PURCHASE field
     */
    const COL_CREATE_PURCHASE = 'role_permission.CREATE_PURCHASE';

    /**
     * the column name for the READ_PURCHASE field
     */
    const COL_READ_PURCHASE = 'role_permission.READ_PURCHASE';

    /**
     * the column name for the UPDATE_PURCHASE field
     */
    const COL_UPDATE_PURCHASE = 'role_permission.UPDATE_PURCHASE';

    /**
     * the column name for the DESTROY_PURCHASE field
     */
    const COL_DESTROY_PURCHASE = 'role_permission.DESTROY_PURCHASE';

    /**
     * the column name for the CREATE_SALES field
     */
    const COL_CREATE_SALES = 'role_permission.CREATE_SALES';

    /**
     * the column name for the READ_SALES field
     */
    const COL_READ_SALES = 'role_permission.READ_SALES';

    /**
     * the column name for the UPDATE_SALES field
     */
    const COL_UPDATE_SALES = 'role_permission.UPDATE_SALES';

    /**
     * the column name for the DESTROY_SALES field
     */
    const COL_DESTROY_SALES = 'role_permission.DESTROY_SALES';

    /**
     * the column name for the CREATE_STOCK field
     */
    const COL_CREATE_STOCK = 'role_permission.CREATE_STOCK';

    /**
     * the column name for the READ_STOCK field
     */
    const COL_READ_STOCK = 'role_permission.READ_STOCK';

    /**
     * the column name for the UPDATE_STOCK field
     */
    const COL_UPDATE_STOCK = 'role_permission.UPDATE_STOCK';

    /**
     * the column name for the DESTROY_STOCK field
     */
    const COL_DESTROY_STOCK = 'role_permission.DESTROY_STOCK';

    /**
     * the column name for the CREATE_USER field
     */
    const COL_CREATE_USER = 'role_permission.CREATE_USER';

    /**
     * the column name for the READ_USER field
     */
    const COL_READ_USER = 'role_permission.READ_USER';

    /**
     * the column name for the UPDATE_USER field
     */
    const COL_UPDATE_USER = 'role_permission.UPDATE_USER';

    /**
     * the column name for the DESTROY_USER field
     */
    const COL_DESTROY_USER = 'role_permission.DESTROY_USER';

    /**
     * the column name for the RESET_PASS_USER field
     */
    const COL_RESET_PASS_USER = 'role_permission.RESET_PASS_USER';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'PayCredit', 'ReadCredit', 'CreateProduct', 'ReadProduct', 'UpdateProduct', 'DestroyProduct', 'CreatePurchase', 'ReadPurchase', 'UpdatePurchase', 'DestroyPurchase', 'CreateSales', 'ReadSales', 'UpdateSales', 'DestroySales', 'CreateStock', 'ReadStock', 'UpdateStock', 'DestroyStock', 'CreateUser', 'ReadUser', 'UpdateUser', 'DestroyUser', 'ResetPassUser', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'payCredit', 'readCredit', 'createProduct', 'readProduct', 'updateProduct', 'destroyProduct', 'createPurchase', 'readPurchase', 'updatePurchase', 'destroyPurchase', 'createSales', 'readSales', 'updateSales', 'destroySales', 'createStock', 'readStock', 'updateStock', 'destroyStock', 'createUser', 'readUser', 'updateUser', 'destroyUser', 'resetPassUser', ),
        self::TYPE_COLNAME       => array(RolePermissionTableMap::COL_ID, RolePermissionTableMap::COL_PAY_CREDIT, RolePermissionTableMap::COL_READ_CREDIT, RolePermissionTableMap::COL_CREATE_PRODUCT, RolePermissionTableMap::COL_READ_PRODUCT, RolePermissionTableMap::COL_UPDATE_PRODUCT, RolePermissionTableMap::COL_DESTROY_PRODUCT, RolePermissionTableMap::COL_CREATE_PURCHASE, RolePermissionTableMap::COL_READ_PURCHASE, RolePermissionTableMap::COL_UPDATE_PURCHASE, RolePermissionTableMap::COL_DESTROY_PURCHASE, RolePermissionTableMap::COL_CREATE_SALES, RolePermissionTableMap::COL_READ_SALES, RolePermissionTableMap::COL_UPDATE_SALES, RolePermissionTableMap::COL_DESTROY_SALES, RolePermissionTableMap::COL_CREATE_STOCK, RolePermissionTableMap::COL_READ_STOCK, RolePermissionTableMap::COL_UPDATE_STOCK, RolePermissionTableMap::COL_DESTROY_STOCK, RolePermissionTableMap::COL_CREATE_USER, RolePermissionTableMap::COL_READ_USER, RolePermissionTableMap::COL_UPDATE_USER, RolePermissionTableMap::COL_DESTROY_USER, RolePermissionTableMap::COL_RESET_PASS_USER, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_PAY_CREDIT', 'COL_READ_CREDIT', 'COL_CREATE_PRODUCT', 'COL_READ_PRODUCT', 'COL_UPDATE_PRODUCT', 'COL_DESTROY_PRODUCT', 'COL_CREATE_PURCHASE', 'COL_READ_PURCHASE', 'COL_UPDATE_PURCHASE', 'COL_DESTROY_PURCHASE', 'COL_CREATE_SALES', 'COL_READ_SALES', 'COL_UPDATE_SALES', 'COL_DESTROY_SALES', 'COL_CREATE_STOCK', 'COL_READ_STOCK', 'COL_UPDATE_STOCK', 'COL_DESTROY_STOCK', 'COL_CREATE_USER', 'COL_READ_USER', 'COL_UPDATE_USER', 'COL_DESTROY_USER', 'COL_RESET_PASS_USER', ),
        self::TYPE_FIELDNAME     => array('id', 'pay_credit', 'read_credit', 'create_product', 'read_product', 'update_product', 'destroy_product', 'create_purchase', 'read_purchase', 'update_purchase', 'destroy_purchase', 'create_sales', 'read_sales', 'update_sales', 'destroy_sales', 'create_stock', 'read_stock', 'update_stock', 'destroy_stock', 'create_user', 'read_user', 'update_user', 'destroy_user', 'reset_pass_user', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PayCredit' => 1, 'ReadCredit' => 2, 'CreateProduct' => 3, 'ReadProduct' => 4, 'UpdateProduct' => 5, 'DestroyProduct' => 6, 'CreatePurchase' => 7, 'ReadPurchase' => 8, 'UpdatePurchase' => 9, 'DestroyPurchase' => 10, 'CreateSales' => 11, 'ReadSales' => 12, 'UpdateSales' => 13, 'DestroySales' => 14, 'CreateStock' => 15, 'ReadStock' => 16, 'UpdateStock' => 17, 'DestroyStock' => 18, 'CreateUser' => 19, 'ReadUser' => 20, 'UpdateUser' => 21, 'DestroyUser' => 22, 'ResetPassUser' => 23, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'payCredit' => 1, 'readCredit' => 2, 'createProduct' => 3, 'readProduct' => 4, 'updateProduct' => 5, 'destroyProduct' => 6, 'createPurchase' => 7, 'readPurchase' => 8, 'updatePurchase' => 9, 'destroyPurchase' => 10, 'createSales' => 11, 'readSales' => 12, 'updateSales' => 13, 'destroySales' => 14, 'createStock' => 15, 'readStock' => 16, 'updateStock' => 17, 'destroyStock' => 18, 'createUser' => 19, 'readUser' => 20, 'updateUser' => 21, 'destroyUser' => 22, 'resetPassUser' => 23, ),
        self::TYPE_COLNAME       => array(RolePermissionTableMap::COL_ID => 0, RolePermissionTableMap::COL_PAY_CREDIT => 1, RolePermissionTableMap::COL_READ_CREDIT => 2, RolePermissionTableMap::COL_CREATE_PRODUCT => 3, RolePermissionTableMap::COL_READ_PRODUCT => 4, RolePermissionTableMap::COL_UPDATE_PRODUCT => 5, RolePermissionTableMap::COL_DESTROY_PRODUCT => 6, RolePermissionTableMap::COL_CREATE_PURCHASE => 7, RolePermissionTableMap::COL_READ_PURCHASE => 8, RolePermissionTableMap::COL_UPDATE_PURCHASE => 9, RolePermissionTableMap::COL_DESTROY_PURCHASE => 10, RolePermissionTableMap::COL_CREATE_SALES => 11, RolePermissionTableMap::COL_READ_SALES => 12, RolePermissionTableMap::COL_UPDATE_SALES => 13, RolePermissionTableMap::COL_DESTROY_SALES => 14, RolePermissionTableMap::COL_CREATE_STOCK => 15, RolePermissionTableMap::COL_READ_STOCK => 16, RolePermissionTableMap::COL_UPDATE_STOCK => 17, RolePermissionTableMap::COL_DESTROY_STOCK => 18, RolePermissionTableMap::COL_CREATE_USER => 19, RolePermissionTableMap::COL_READ_USER => 20, RolePermissionTableMap::COL_UPDATE_USER => 21, RolePermissionTableMap::COL_DESTROY_USER => 22, RolePermissionTableMap::COL_RESET_PASS_USER => 23, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_PAY_CREDIT' => 1, 'COL_READ_CREDIT' => 2, 'COL_CREATE_PRODUCT' => 3, 'COL_READ_PRODUCT' => 4, 'COL_UPDATE_PRODUCT' => 5, 'COL_DESTROY_PRODUCT' => 6, 'COL_CREATE_PURCHASE' => 7, 'COL_READ_PURCHASE' => 8, 'COL_UPDATE_PURCHASE' => 9, 'COL_DESTROY_PURCHASE' => 10, 'COL_CREATE_SALES' => 11, 'COL_READ_SALES' => 12, 'COL_UPDATE_SALES' => 13, 'COL_DESTROY_SALES' => 14, 'COL_CREATE_STOCK' => 15, 'COL_READ_STOCK' => 16, 'COL_UPDATE_STOCK' => 17, 'COL_DESTROY_STOCK' => 18, 'COL_CREATE_USER' => 19, 'COL_READ_USER' => 20, 'COL_UPDATE_USER' => 21, 'COL_DESTROY_USER' => 22, 'COL_RESET_PASS_USER' => 23, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'pay_credit' => 1, 'read_credit' => 2, 'create_product' => 3, 'read_product' => 4, 'update_product' => 5, 'destroy_product' => 6, 'create_purchase' => 7, 'read_purchase' => 8, 'update_purchase' => 9, 'destroy_purchase' => 10, 'create_sales' => 11, 'read_sales' => 12, 'update_sales' => 13, 'destroy_sales' => 14, 'create_stock' => 15, 'read_stock' => 16, 'update_stock' => 17, 'destroy_stock' => 18, 'create_user' => 19, 'read_user' => 20, 'update_user' => 21, 'destroy_user' => 22, 'reset_pass_user' => 23, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('role_permission');
        $this->setPhpName('RolePermission');
        $this->setClassName('\\ORM\\RolePermission');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'BIGINT' , 'role', 'ID', true, 20, null);
        $this->addColumn('PAY_CREDIT', 'PayCredit', 'BOOLEAN', false, 1, null);
        $this->addColumn('READ_CREDIT', 'ReadCredit', 'BOOLEAN', false, 1, null);
        $this->addColumn('CREATE_PRODUCT', 'CreateProduct', 'BOOLEAN', false, 1, null);
        $this->addColumn('READ_PRODUCT', 'ReadProduct', 'BOOLEAN', false, 1, null);
        $this->addColumn('UPDATE_PRODUCT', 'UpdateProduct', 'BOOLEAN', false, 1, null);
        $this->addColumn('DESTROY_PRODUCT', 'DestroyProduct', 'BOOLEAN', false, 1, null);
        $this->addColumn('CREATE_PURCHASE', 'CreatePurchase', 'BOOLEAN', false, 1, null);
        $this->addColumn('READ_PURCHASE', 'ReadPurchase', 'BOOLEAN', false, 1, null);
        $this->addColumn('UPDATE_PURCHASE', 'UpdatePurchase', 'BOOLEAN', false, 1, null);
        $this->addColumn('DESTROY_PURCHASE', 'DestroyPurchase', 'BOOLEAN', false, 1, null);
        $this->addColumn('CREATE_SALES', 'CreateSales', 'BOOLEAN', false, 1, null);
        $this->addColumn('READ_SALES', 'ReadSales', 'BOOLEAN', false, 1, null);
        $this->addColumn('UPDATE_SALES', 'UpdateSales', 'BOOLEAN', false, 1, null);
        $this->addColumn('DESTROY_SALES', 'DestroySales', 'BOOLEAN', false, 1, null);
        $this->addColumn('CREATE_STOCK', 'CreateStock', 'BOOLEAN', false, 1, null);
        $this->addColumn('READ_STOCK', 'ReadStock', 'BOOLEAN', false, 1, null);
        $this->addColumn('UPDATE_STOCK', 'UpdateStock', 'BOOLEAN', false, 1, null);
        $this->addColumn('DESTROY_STOCK', 'DestroyStock', 'BOOLEAN', false, 1, null);
        $this->addColumn('CREATE_USER', 'CreateUser', 'BOOLEAN', false, 1, null);
        $this->addColumn('READ_USER', 'ReadUser', 'BOOLEAN', false, 1, null);
        $this->addColumn('UPDATE_USER', 'UpdateUser', 'BOOLEAN', false, 1, null);
        $this->addColumn('DESTROY_USER', 'DestroyUser', 'BOOLEAN', false, 1, null);
        $this->addColumn('RESET_PASS_USER', 'ResetPassUser', 'BOOLEAN', false, 1, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Role', '\\ORM\\Role', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', 'RESTRICT');
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? RolePermissionTableMap::CLASS_DEFAULT : RolePermissionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (RolePermission object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RolePermissionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RolePermissionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RolePermissionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RolePermissionTableMap::OM_CLASS;
            /** @var RolePermission $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RolePermissionTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = RolePermissionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RolePermissionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var RolePermission $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RolePermissionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(RolePermissionTableMap::COL_ID);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_PAY_CREDIT);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_READ_CREDIT);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_CREATE_PRODUCT);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_READ_PRODUCT);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_UPDATE_PRODUCT);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_DESTROY_PRODUCT);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_CREATE_PURCHASE);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_READ_PURCHASE);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_UPDATE_PURCHASE);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_DESTROY_PURCHASE);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_CREATE_SALES);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_READ_SALES);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_UPDATE_SALES);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_DESTROY_SALES);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_CREATE_STOCK);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_READ_STOCK);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_UPDATE_STOCK);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_DESTROY_STOCK);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_CREATE_USER);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_READ_USER);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_UPDATE_USER);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_DESTROY_USER);
            $criteria->addSelectColumn(RolePermissionTableMap::COL_RESET_PASS_USER);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PAY_CREDIT');
            $criteria->addSelectColumn($alias . '.READ_CREDIT');
            $criteria->addSelectColumn($alias . '.CREATE_PRODUCT');
            $criteria->addSelectColumn($alias . '.READ_PRODUCT');
            $criteria->addSelectColumn($alias . '.UPDATE_PRODUCT');
            $criteria->addSelectColumn($alias . '.DESTROY_PRODUCT');
            $criteria->addSelectColumn($alias . '.CREATE_PURCHASE');
            $criteria->addSelectColumn($alias . '.READ_PURCHASE');
            $criteria->addSelectColumn($alias . '.UPDATE_PURCHASE');
            $criteria->addSelectColumn($alias . '.DESTROY_PURCHASE');
            $criteria->addSelectColumn($alias . '.CREATE_SALES');
            $criteria->addSelectColumn($alias . '.READ_SALES');
            $criteria->addSelectColumn($alias . '.UPDATE_SALES');
            $criteria->addSelectColumn($alias . '.DESTROY_SALES');
            $criteria->addSelectColumn($alias . '.CREATE_STOCK');
            $criteria->addSelectColumn($alias . '.READ_STOCK');
            $criteria->addSelectColumn($alias . '.UPDATE_STOCK');
            $criteria->addSelectColumn($alias . '.DESTROY_STOCK');
            $criteria->addSelectColumn($alias . '.CREATE_USER');
            $criteria->addSelectColumn($alias . '.READ_USER');
            $criteria->addSelectColumn($alias . '.UPDATE_USER');
            $criteria->addSelectColumn($alias . '.DESTROY_USER');
            $criteria->addSelectColumn($alias . '.RESET_PASS_USER');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(RolePermissionTableMap::DATABASE_NAME)->getTable(RolePermissionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RolePermissionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RolePermissionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RolePermissionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a RolePermission or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or RolePermission object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolePermissionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\RolePermission) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RolePermissionTableMap::DATABASE_NAME);
            $criteria->add(RolePermissionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = RolePermissionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RolePermissionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RolePermissionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the role_permission table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RolePermissionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a RolePermission or Criteria object.
     *
     * @param mixed               $criteria Criteria or RolePermission object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolePermissionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from RolePermission object
        }


        // Set the correct dbName
        $query = RolePermissionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RolePermissionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RolePermissionTableMap::buildTableMap();
