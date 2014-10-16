<?php

namespace ORM\Map;

use ORM\SalesDetail;
use ORM\SalesDetailQuery;
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
 * This class defines the structure of the 'sales_detail' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SalesDetailTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.SalesDetailTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'sales_detail';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\SalesDetail';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.SalesDetail';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'sales_detail.ID';

    /**
     * the column name for the SALES_ID field
     */
    const COL_SALES_ID = 'sales_detail.SALES_ID';

    /**
     * the column name for the TYPE field
     */
    const COL_TYPE = 'sales_detail.TYPE';

    /**
     * the column name for the STOCK_ID field
     */
    const COL_STOCK_ID = 'sales_detail.STOCK_ID';

    /**
     * the column name for the AMOUNT field
     */
    const COL_AMOUNT = 'sales_detail.AMOUNT';

    /**
     * the column name for the UNIT_PRICE field
     */
    const COL_UNIT_PRICE = 'sales_detail.UNIT_PRICE';

    /**
     * the column name for the DISCOUNT field
     */
    const COL_DISCOUNT = 'sales_detail.DISCOUNT';

    /**
     * the column name for the TOTAL_PRICE field
     */
    const COL_TOTAL_PRICE = 'sales_detail.TOTAL_PRICE';

    /**
     * the column name for the BUY field
     */
    const COL_BUY = 'sales_detail.BUY';

    /**
     * the column name for the SELL_PUBLIC field
     */
    const COL_SELL_PUBLIC = 'sales_detail.SELL_PUBLIC';

    /**
     * the column name for the SELL_DISTRIBUTOR field
     */
    const COL_SELL_DISTRIBUTOR = 'sales_detail.SELL_DISTRIBUTOR';

    /**
     * the column name for the SELL_MISC field
     */
    const COL_SELL_MISC = 'sales_detail.SELL_MISC';

    /**
     * the column name for the STATUS field
     */
    const COL_STATUS = 'sales_detail.STATUS';

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
        self::TYPE_PHPNAME       => array('Id', 'SalesId', 'Type', 'StockId', 'Amount', 'UnitPrice', 'Discount', 'TotalPrice', 'Buy', 'SellPublic', 'SellDistributor', 'SellMisc', 'Status', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'salesId', 'type', 'stockId', 'amount', 'unitPrice', 'discount', 'totalPrice', 'buy', 'sellPublic', 'sellDistributor', 'sellMisc', 'status', ),
        self::TYPE_COLNAME       => array(SalesDetailTableMap::COL_ID, SalesDetailTableMap::COL_SALES_ID, SalesDetailTableMap::COL_TYPE, SalesDetailTableMap::COL_STOCK_ID, SalesDetailTableMap::COL_AMOUNT, SalesDetailTableMap::COL_UNIT_PRICE, SalesDetailTableMap::COL_DISCOUNT, SalesDetailTableMap::COL_TOTAL_PRICE, SalesDetailTableMap::COL_BUY, SalesDetailTableMap::COL_SELL_PUBLIC, SalesDetailTableMap::COL_SELL_DISTRIBUTOR, SalesDetailTableMap::COL_SELL_MISC, SalesDetailTableMap::COL_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_SALES_ID', 'COL_TYPE', 'COL_STOCK_ID', 'COL_AMOUNT', 'COL_UNIT_PRICE', 'COL_DISCOUNT', 'COL_TOTAL_PRICE', 'COL_BUY', 'COL_SELL_PUBLIC', 'COL_SELL_DISTRIBUTOR', 'COL_SELL_MISC', 'COL_STATUS', ),
        self::TYPE_FIELDNAME     => array('id', 'sales_id', 'type', 'stock_id', 'amount', 'unit_price', 'discount', 'total_price', 'buy', 'sell_public', 'sell_distributor', 'sell_misc', 'status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'SalesId' => 1, 'Type' => 2, 'StockId' => 3, 'Amount' => 4, 'UnitPrice' => 5, 'Discount' => 6, 'TotalPrice' => 7, 'Buy' => 8, 'SellPublic' => 9, 'SellDistributor' => 10, 'SellMisc' => 11, 'Status' => 12, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'salesId' => 1, 'type' => 2, 'stockId' => 3, 'amount' => 4, 'unitPrice' => 5, 'discount' => 6, 'totalPrice' => 7, 'buy' => 8, 'sellPublic' => 9, 'sellDistributor' => 10, 'sellMisc' => 11, 'status' => 12, ),
        self::TYPE_COLNAME       => array(SalesDetailTableMap::COL_ID => 0, SalesDetailTableMap::COL_SALES_ID => 1, SalesDetailTableMap::COL_TYPE => 2, SalesDetailTableMap::COL_STOCK_ID => 3, SalesDetailTableMap::COL_AMOUNT => 4, SalesDetailTableMap::COL_UNIT_PRICE => 5, SalesDetailTableMap::COL_DISCOUNT => 6, SalesDetailTableMap::COL_TOTAL_PRICE => 7, SalesDetailTableMap::COL_BUY => 8, SalesDetailTableMap::COL_SELL_PUBLIC => 9, SalesDetailTableMap::COL_SELL_DISTRIBUTOR => 10, SalesDetailTableMap::COL_SELL_MISC => 11, SalesDetailTableMap::COL_STATUS => 12, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_SALES_ID' => 1, 'COL_TYPE' => 2, 'COL_STOCK_ID' => 3, 'COL_AMOUNT' => 4, 'COL_UNIT_PRICE' => 5, 'COL_DISCOUNT' => 6, 'COL_TOTAL_PRICE' => 7, 'COL_BUY' => 8, 'COL_SELL_PUBLIC' => 9, 'COL_SELL_DISTRIBUTOR' => 10, 'COL_SELL_MISC' => 11, 'COL_STATUS' => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'sales_id' => 1, 'type' => 2, 'stock_id' => 3, 'amount' => 4, 'unit_price' => 5, 'discount' => 6, 'total_price' => 7, 'buy' => 8, 'sell_public' => 9, 'sell_distributor' => 10, 'sell_misc' => 11, 'status' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
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
        $this->setName('sales_detail');
        $this->setPhpName('SalesDetail');
        $this->setClassName('\\ORM\\SalesDetail');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'BIGINT', true, 20, null);
        $this->addForeignKey('SALES_ID', 'SalesId', 'BIGINT', 'sales', 'ID', false, 20, null);
        $this->addColumn('TYPE', 'Type', 'CHAR', false, null, null);
        $this->addForeignKey('STOCK_ID', 'StockId', 'BIGINT', 'stock', 'ID', false, 20, null);
        $this->addColumn('AMOUNT', 'Amount', 'DECIMAL', false, 10, null);
        $this->addColumn('UNIT_PRICE', 'UnitPrice', 'INTEGER', false, 10, null);
        $this->addColumn('DISCOUNT', 'Discount', 'DECIMAL', false, 5, null);
        $this->addColumn('TOTAL_PRICE', 'TotalPrice', 'INTEGER', false, 10, null);
        $this->addColumn('BUY', 'Buy', 'INTEGER', false, 10, null);
        $this->addColumn('SELL_PUBLIC', 'SellPublic', 'INTEGER', false, 10, null);
        $this->addColumn('SELL_DISTRIBUTOR', 'SellDistributor', 'INTEGER', false, 10, null);
        $this->addColumn('SELL_MISC', 'SellMisc', 'INTEGER', false, 10, null);
        $this->addColumn('STATUS', 'Status', 'CHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Sales', '\\ORM\\Sales', RelationMap::MANY_TO_ONE, array('sales_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('Stock', '\\ORM\\Stock', RelationMap::MANY_TO_ONE, array('stock_id' => 'id', ), 'RESTRICT', 'RESTRICT');
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
        return $withPrefix ? SalesDetailTableMap::CLASS_DEFAULT : SalesDetailTableMap::OM_CLASS;
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
     * @return array           (SalesDetail object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SalesDetailTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SalesDetailTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SalesDetailTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SalesDetailTableMap::OM_CLASS;
            /** @var SalesDetail $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SalesDetailTableMap::addInstanceToPool($obj, $key);
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
            $key = SalesDetailTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SalesDetailTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SalesDetail $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SalesDetailTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SalesDetailTableMap::COL_ID);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_SALES_ID);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_TYPE);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_STOCK_ID);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_AMOUNT);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_UNIT_PRICE);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_DISCOUNT);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_TOTAL_PRICE);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_BUY);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_SELL_PUBLIC);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_SELL_DISTRIBUTOR);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_SELL_MISC);
            $criteria->addSelectColumn(SalesDetailTableMap::COL_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.SALES_ID');
            $criteria->addSelectColumn($alias . '.TYPE');
            $criteria->addSelectColumn($alias . '.STOCK_ID');
            $criteria->addSelectColumn($alias . '.AMOUNT');
            $criteria->addSelectColumn($alias . '.UNIT_PRICE');
            $criteria->addSelectColumn($alias . '.DISCOUNT');
            $criteria->addSelectColumn($alias . '.TOTAL_PRICE');
            $criteria->addSelectColumn($alias . '.BUY');
            $criteria->addSelectColumn($alias . '.SELL_PUBLIC');
            $criteria->addSelectColumn($alias . '.SELL_DISTRIBUTOR');
            $criteria->addSelectColumn($alias . '.SELL_MISC');
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
        return Propel::getServiceContainer()->getDatabaseMap(SalesDetailTableMap::DATABASE_NAME)->getTable(SalesDetailTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SalesDetailTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SalesDetailTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SalesDetailTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SalesDetail or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SalesDetail object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SalesDetailTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\SalesDetail) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SalesDetailTableMap::DATABASE_NAME);
            $criteria->add(SalesDetailTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SalesDetailQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SalesDetailTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SalesDetailTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the sales_detail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SalesDetailQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SalesDetail or Criteria object.
     *
     * @param mixed               $criteria Criteria or SalesDetail object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SalesDetailTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SalesDetail object
        }

        if ($criteria->containsKey(SalesDetailTableMap::COL_ID) && $criteria->keyContainsValue(SalesDetailTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SalesDetailTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SalesDetailQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SalesDetailTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SalesDetailTableMap::buildTableMap();
