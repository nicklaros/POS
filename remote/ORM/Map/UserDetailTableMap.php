<?php

namespace ORM\Map;

use ORM\UserDetail;
use ORM\UserDetailQuery;
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
 * This class defines the structure of the 'user_detail' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserDetailTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.UserDetailTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'user_detail';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\UserDetail';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.UserDetail';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'user_detail.ID';

    /**
     * the column name for the NAME field
     */
    const COL_NAME = 'user_detail.NAME';

    /**
     * the column name for the ADDRESS field
     */
    const COL_ADDRESS = 'user_detail.ADDRESS';

    /**
     * the column name for the PHONE field
     */
    const COL_PHONE = 'user_detail.PHONE';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Address', 'Phone', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'name', 'address', 'phone', ),
        self::TYPE_COLNAME       => array(UserDetailTableMap::COL_ID, UserDetailTableMap::COL_NAME, UserDetailTableMap::COL_ADDRESS, UserDetailTableMap::COL_PHONE, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_NAME', 'COL_ADDRESS', 'COL_PHONE', ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'address', 'phone', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Address' => 2, 'Phone' => 3, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'name' => 1, 'address' => 2, 'phone' => 3, ),
        self::TYPE_COLNAME       => array(UserDetailTableMap::COL_ID => 0, UserDetailTableMap::COL_NAME => 1, UserDetailTableMap::COL_ADDRESS => 2, UserDetailTableMap::COL_PHONE => 3, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_NAME' => 1, 'COL_ADDRESS' => 2, 'COL_PHONE' => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'address' => 2, 'phone' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
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
        $this->setName('user_detail');
        $this->setPhpName('UserDetail');
        $this->setClassName('\\ORM\\UserDetail');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'BIGINT' , 'user', 'ID', true, 20, null);
        $this->addColumn('NAME', 'Name', 'CHAR', true, 128, null);
        $this->addColumn('ADDRESS', 'Address', 'CHAR', false, 128, null);
        $this->addColumn('PHONE', 'Phone', 'CHAR', false, 20, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\ORM\\User', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('CreditPayment', '\\ORM\\CreditPayment', RelationMap::ONE_TO_MANY, array('id' => 'cashier_id', ), 'RESTRICT', 'RESTRICT', 'CreditPayments');
        $this->addRelation('DebitPayment', '\\ORM\\DebitPayment', RelationMap::ONE_TO_MANY, array('id' => 'cashier_id', ), 'RESTRICT', 'RESTRICT', 'DebitPayments');
        $this->addRelation('PurchaseHistory', '\\ORM\\PurchaseHistory', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'RESTRICT', 'RESTRICT', 'PurchaseHistories');
        $this->addRelation('History', '\\ORM\\RowHistory', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'RESTRICT', 'RESTRICT', 'Histories');
        $this->addRelation('Sales', '\\ORM\\Sales', RelationMap::ONE_TO_MANY, array('id' => 'cashier_id', ), 'RESTRICT', 'RESTRICT', 'Saless');
        $this->addRelation('SalesHistory', '\\ORM\\SalesHistory', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'RESTRICT', 'RESTRICT', 'SalesHistories');
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
        return $withPrefix ? UserDetailTableMap::CLASS_DEFAULT : UserDetailTableMap::OM_CLASS;
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
     * @return array           (UserDetail object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserDetailTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserDetailTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserDetailTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserDetailTableMap::OM_CLASS;
            /** @var UserDetail $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserDetailTableMap::addInstanceToPool($obj, $key);
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
            $key = UserDetailTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserDetailTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var UserDetail $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserDetailTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UserDetailTableMap::COL_ID);
            $criteria->addSelectColumn(UserDetailTableMap::COL_NAME);
            $criteria->addSelectColumn(UserDetailTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(UserDetailTableMap::COL_PHONE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.ADDRESS');
            $criteria->addSelectColumn($alias . '.PHONE');
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
        return Propel::getServiceContainer()->getDatabaseMap(UserDetailTableMap::DATABASE_NAME)->getTable(UserDetailTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserDetailTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserDetailTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserDetailTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a UserDetail or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or UserDetail object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserDetailTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\UserDetail) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserDetailTableMap::DATABASE_NAME);
            $criteria->add(UserDetailTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = UserDetailQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserDetailTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserDetailTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user_detail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserDetailQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a UserDetail or Criteria object.
     *
     * @param mixed               $criteria Criteria or UserDetail object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserDetailTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from UserDetail object
        }


        // Set the correct dbName
        $query = UserDetailQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserDetailTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserDetailTableMap::buildTableMap();
