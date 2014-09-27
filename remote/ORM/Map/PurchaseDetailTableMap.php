<?php

namespace ORM\Map;

use ORM\PurchaseDetail;
use ORM\PurchaseDetailQuery;
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
 * This class defines the structure of the 'purchase_detail' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PurchaseDetailTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.PurchaseDetailTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'purchase_detail';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\PurchaseDetail';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.PurchaseDetail';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'purchase_detail.ID';

    /**
     * the column name for the PURCHASE_ID field
     */
    const COL_PURCHASE_ID = 'purchase_detail.PURCHASE_ID';

    /**
     * the column name for the STOCK_ID field
     */
    const COL_STOCK_ID = 'purchase_detail.STOCK_ID';

    /**
     * the column name for the AMOUNT field
     */
    const COL_AMOUNT = 'purchase_detail.AMOUNT';

    /**
     * the column name for the TOTAL_PRICE field
     */
    const COL_TOTAL_PRICE = 'purchase_detail.TOTAL_PRICE';

    /**
     * the column name for the NOTIFICATION_ID field
     */
    const COL_NOTIFICATION_ID = 'purchase_detail.NOTIFICATION_ID';

    /**
     * the column name for the STATUS field
     */
    const COL_STATUS = 'purchase_detail.STATUS';

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
        self::TYPE_PHPNAME       => array('Id', 'PurchaseId', 'StockId', 'Amount', 'TotalPrice', 'NotificationId', 'Status', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'purchaseId', 'stockId', 'amount', 'totalPrice', 'notificationId', 'status', ),
        self::TYPE_COLNAME       => array(PurchaseDetailTableMap::COL_ID, PurchaseDetailTableMap::COL_PURCHASE_ID, PurchaseDetailTableMap::COL_STOCK_ID, PurchaseDetailTableMap::COL_AMOUNT, PurchaseDetailTableMap::COL_TOTAL_PRICE, PurchaseDetailTableMap::COL_NOTIFICATION_ID, PurchaseDetailTableMap::COL_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_PURCHASE_ID', 'COL_STOCK_ID', 'COL_AMOUNT', 'COL_TOTAL_PRICE', 'COL_NOTIFICATION_ID', 'COL_STATUS', ),
        self::TYPE_FIELDNAME     => array('id', 'purchase_id', 'stock_id', 'amount', 'total_price', 'notification_id', 'status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PurchaseId' => 1, 'StockId' => 2, 'Amount' => 3, 'TotalPrice' => 4, 'NotificationId' => 5, 'Status' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'purchaseId' => 1, 'stockId' => 2, 'amount' => 3, 'totalPrice' => 4, 'notificationId' => 5, 'status' => 6, ),
        self::TYPE_COLNAME       => array(PurchaseDetailTableMap::COL_ID => 0, PurchaseDetailTableMap::COL_PURCHASE_ID => 1, PurchaseDetailTableMap::COL_STOCK_ID => 2, PurchaseDetailTableMap::COL_AMOUNT => 3, PurchaseDetailTableMap::COL_TOTAL_PRICE => 4, PurchaseDetailTableMap::COL_NOTIFICATION_ID => 5, PurchaseDetailTableMap::COL_STATUS => 6, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_PURCHASE_ID' => 1, 'COL_STOCK_ID' => 2, 'COL_AMOUNT' => 3, 'COL_TOTAL_PRICE' => 4, 'COL_NOTIFICATION_ID' => 5, 'COL_STATUS' => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'purchase_id' => 1, 'stock_id' => 2, 'amount' => 3, 'total_price' => 4, 'notification_id' => 5, 'status' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('purchase_detail');
        $this->setPhpName('PurchaseDetail');
        $this->setClassName('\\ORM\\PurchaseDetail');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'BIGINT', true, 20, null);
        $this->addForeignKey('PURCHASE_ID', 'PurchaseId', 'BIGINT', 'purchase', 'ID', false, 20, null);
        $this->addForeignKey('STOCK_ID', 'StockId', 'BIGINT', 'stock', 'ID', false, 20, null);
        $this->addColumn('AMOUNT', 'Amount', 'DECIMAL', false, 10, null);
        $this->addColumn('TOTAL_PRICE', 'TotalPrice', 'INTEGER', false, 10, null);
        $this->addForeignKey('NOTIFICATION_ID', 'NotificationId', 'BIGINT', 'notification', 'ID', false, 20, null);
        $this->addColumn('STATUS', 'Status', 'CHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Purchase', '\\ORM\\Purchase', RelationMap::MANY_TO_ONE, array('purchase_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('Stock', '\\ORM\\Stock', RelationMap::MANY_TO_ONE, array('stock_id' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('Notification', '\\ORM\\Notification', RelationMap::MANY_TO_ONE, array('notification_id' => 'id', ), 'RESTRICT', 'RESTRICT');
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
        return $withPrefix ? PurchaseDetailTableMap::CLASS_DEFAULT : PurchaseDetailTableMap::OM_CLASS;
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
     * @return array           (PurchaseDetail object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PurchaseDetailTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PurchaseDetailTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PurchaseDetailTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PurchaseDetailTableMap::OM_CLASS;
            /** @var PurchaseDetail $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PurchaseDetailTableMap::addInstanceToPool($obj, $key);
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
            $key = PurchaseDetailTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PurchaseDetailTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PurchaseDetail $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PurchaseDetailTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PurchaseDetailTableMap::COL_ID);
            $criteria->addSelectColumn(PurchaseDetailTableMap::COL_PURCHASE_ID);
            $criteria->addSelectColumn(PurchaseDetailTableMap::COL_STOCK_ID);
            $criteria->addSelectColumn(PurchaseDetailTableMap::COL_AMOUNT);
            $criteria->addSelectColumn(PurchaseDetailTableMap::COL_TOTAL_PRICE);
            $criteria->addSelectColumn(PurchaseDetailTableMap::COL_NOTIFICATION_ID);
            $criteria->addSelectColumn(PurchaseDetailTableMap::COL_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PURCHASE_ID');
            $criteria->addSelectColumn($alias . '.STOCK_ID');
            $criteria->addSelectColumn($alias . '.AMOUNT');
            $criteria->addSelectColumn($alias . '.TOTAL_PRICE');
            $criteria->addSelectColumn($alias . '.NOTIFICATION_ID');
            $criteria->addSelectColumn($alias . '.STATUS');
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
        return Propel::getServiceContainer()->getDatabaseMap(PurchaseDetailTableMap::DATABASE_NAME)->getTable(PurchaseDetailTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PurchaseDetailTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PurchaseDetailTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PurchaseDetailTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PurchaseDetail or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PurchaseDetail object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseDetailTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\PurchaseDetail) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PurchaseDetailTableMap::DATABASE_NAME);
            $criteria->add(PurchaseDetailTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PurchaseDetailQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PurchaseDetailTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PurchaseDetailTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the purchase_detail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PurchaseDetailQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PurchaseDetail or Criteria object.
     *
     * @param mixed               $criteria Criteria or PurchaseDetail object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseDetailTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PurchaseDetail object
        }

        if ($criteria->containsKey(PurchaseDetailTableMap::COL_ID) && $criteria->keyContainsValue(PurchaseDetailTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PurchaseDetailTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PurchaseDetailQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PurchaseDetailTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PurchaseDetailTableMap::buildTableMap();
