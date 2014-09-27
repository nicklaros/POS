<?php

namespace ORM\Map;

use ORM\PurchaseHistory;
use ORM\PurchaseHistoryQuery;
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
 * This class defines the structure of the 'purchase_history' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PurchaseHistoryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.PurchaseHistoryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'purchase_history';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\PurchaseHistory';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.PurchaseHistory';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'purchase_history.ID';

    /**
     * the column name for the USER_ID field
     */
    const COL_USER_ID = 'purchase_history.USER_ID';

    /**
     * the column name for the PURCHASE_ID field
     */
    const COL_PURCHASE_ID = 'purchase_history.PURCHASE_ID';

    /**
     * the column name for the TIME field
     */
    const COL_TIME = 'purchase_history.TIME';

    /**
     * the column name for the OPERATION field
     */
    const COL_OPERATION = 'purchase_history.OPERATION';

    /**
     * the column name for the DATA field
     */
    const COL_DATA = 'purchase_history.DATA';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'PurchaseId', 'Time', 'Operation', 'Data', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'userId', 'purchaseId', 'time', 'operation', 'data', ),
        self::TYPE_COLNAME       => array(PurchaseHistoryTableMap::COL_ID, PurchaseHistoryTableMap::COL_USER_ID, PurchaseHistoryTableMap::COL_PURCHASE_ID, PurchaseHistoryTableMap::COL_TIME, PurchaseHistoryTableMap::COL_OPERATION, PurchaseHistoryTableMap::COL_DATA, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_USER_ID', 'COL_PURCHASE_ID', 'COL_TIME', 'COL_OPERATION', 'COL_DATA', ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'purchase_id', 'time', 'operation', 'data', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'PurchaseId' => 2, 'Time' => 3, 'Operation' => 4, 'Data' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'userId' => 1, 'purchaseId' => 2, 'time' => 3, 'operation' => 4, 'data' => 5, ),
        self::TYPE_COLNAME       => array(PurchaseHistoryTableMap::COL_ID => 0, PurchaseHistoryTableMap::COL_USER_ID => 1, PurchaseHistoryTableMap::COL_PURCHASE_ID => 2, PurchaseHistoryTableMap::COL_TIME => 3, PurchaseHistoryTableMap::COL_OPERATION => 4, PurchaseHistoryTableMap::COL_DATA => 5, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_USER_ID' => 1, 'COL_PURCHASE_ID' => 2, 'COL_TIME' => 3, 'COL_OPERATION' => 4, 'COL_DATA' => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'purchase_id' => 2, 'time' => 3, 'operation' => 4, 'data' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('purchase_history');
        $this->setPhpName('PurchaseHistory');
        $this->setClassName('\\ORM\\PurchaseHistory');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'BIGINT', true, 20, null);
        $this->addForeignKey('USER_ID', 'UserId', 'BIGINT', 'user_detail', 'ID', false, 20, null);
        $this->addForeignKey('PURCHASE_ID', 'PurchaseId', 'BIGINT', 'purchase', 'ID', false, 20, null);
        $this->addColumn('TIME', 'Time', 'TIMESTAMP', false, null, null);
        $this->addColumn('OPERATION', 'Operation', 'CHAR', false, null, null);
        $this->addColumn('DATA', 'Data', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserDetail', '\\ORM\\UserDetail', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('Purchase', '\\ORM\\Purchase', RelationMap::MANY_TO_ONE, array('purchase_id' => 'id', ), 'NO ACTION', 'RESTRICT');
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
        return $withPrefix ? PurchaseHistoryTableMap::CLASS_DEFAULT : PurchaseHistoryTableMap::OM_CLASS;
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
     * @return array           (PurchaseHistory object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PurchaseHistoryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PurchaseHistoryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PurchaseHistoryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PurchaseHistoryTableMap::OM_CLASS;
            /** @var PurchaseHistory $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PurchaseHistoryTableMap::addInstanceToPool($obj, $key);
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
            $key = PurchaseHistoryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PurchaseHistoryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PurchaseHistory $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PurchaseHistoryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PurchaseHistoryTableMap::COL_ID);
            $criteria->addSelectColumn(PurchaseHistoryTableMap::COL_USER_ID);
            $criteria->addSelectColumn(PurchaseHistoryTableMap::COL_PURCHASE_ID);
            $criteria->addSelectColumn(PurchaseHistoryTableMap::COL_TIME);
            $criteria->addSelectColumn(PurchaseHistoryTableMap::COL_OPERATION);
            $criteria->addSelectColumn(PurchaseHistoryTableMap::COL_DATA);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.USER_ID');
            $criteria->addSelectColumn($alias . '.PURCHASE_ID');
            $criteria->addSelectColumn($alias . '.TIME');
            $criteria->addSelectColumn($alias . '.OPERATION');
            $criteria->addSelectColumn($alias . '.DATA');
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
        return Propel::getServiceContainer()->getDatabaseMap(PurchaseHistoryTableMap::DATABASE_NAME)->getTable(PurchaseHistoryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PurchaseHistoryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PurchaseHistoryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PurchaseHistoryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PurchaseHistory or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PurchaseHistory object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseHistoryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\PurchaseHistory) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PurchaseHistoryTableMap::DATABASE_NAME);
            $criteria->add(PurchaseHistoryTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PurchaseHistoryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PurchaseHistoryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PurchaseHistoryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the purchase_history table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PurchaseHistoryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PurchaseHistory or Criteria object.
     *
     * @param mixed               $criteria Criteria or PurchaseHistory object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseHistoryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PurchaseHistory object
        }

        if ($criteria->containsKey(PurchaseHistoryTableMap::COL_ID) && $criteria->keyContainsValue(PurchaseHistoryTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PurchaseHistoryTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PurchaseHistoryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PurchaseHistoryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PurchaseHistoryTableMap::buildTableMap();
