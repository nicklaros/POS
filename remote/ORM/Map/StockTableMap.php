<?php

namespace ORM\Map;

use ORM\Stock;
use ORM\StockQuery;
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
 * This class defines the structure of the 'stock' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StockTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.StockTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'stock';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\Stock';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.Stock';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'stock.ID';

    /**
     * the column name for the PRODUCT_ID field
     */
    const COL_PRODUCT_ID = 'stock.PRODUCT_ID';

    /**
     * the column name for the AMOUNT field
     */
    const COL_AMOUNT = 'stock.AMOUNT';

    /**
     * the column name for the UNIT_ID field
     */
    const COL_UNIT_ID = 'stock.UNIT_ID';

    /**
     * the column name for the BUY field
     */
    const COL_BUY = 'stock.BUY';

    /**
     * the column name for the SELL_PUBLIC field
     */
    const COL_SELL_PUBLIC = 'stock.SELL_PUBLIC';

    /**
     * the column name for the SELL_DISTRIBUTOR field
     */
    const COL_SELL_DISTRIBUTOR = 'stock.SELL_DISTRIBUTOR';

    /**
     * the column name for the SELL_MISC field
     */
    const COL_SELL_MISC = 'stock.SELL_MISC';

    /**
     * the column name for the DISCOUNT field
     */
    const COL_DISCOUNT = 'stock.DISCOUNT';

    /**
     * the column name for the UNLIMITED field
     */
    const COL_UNLIMITED = 'stock.UNLIMITED';

    /**
     * the column name for the STATUS field
     */
    const COL_STATUS = 'stock.STATUS';

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
        self::TYPE_PHPNAME       => array('Id', 'ProductId', 'Amount', 'UnitId', 'Buy', 'SellPublic', 'SellDistributor', 'SellMisc', 'Discount', 'Unlimited', 'Status', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'productId', 'amount', 'unitId', 'buy', 'sellPublic', 'sellDistributor', 'sellMisc', 'discount', 'unlimited', 'status', ),
        self::TYPE_COLNAME       => array(StockTableMap::COL_ID, StockTableMap::COL_PRODUCT_ID, StockTableMap::COL_AMOUNT, StockTableMap::COL_UNIT_ID, StockTableMap::COL_BUY, StockTableMap::COL_SELL_PUBLIC, StockTableMap::COL_SELL_DISTRIBUTOR, StockTableMap::COL_SELL_MISC, StockTableMap::COL_DISCOUNT, StockTableMap::COL_UNLIMITED, StockTableMap::COL_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_PRODUCT_ID', 'COL_AMOUNT', 'COL_UNIT_ID', 'COL_BUY', 'COL_SELL_PUBLIC', 'COL_SELL_DISTRIBUTOR', 'COL_SELL_MISC', 'COL_DISCOUNT', 'COL_UNLIMITED', 'COL_STATUS', ),
        self::TYPE_FIELDNAME     => array('id', 'product_id', 'amount', 'unit_id', 'buy', 'sell_public', 'sell_distributor', 'sell_misc', 'discount', 'unlimited', 'status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ProductId' => 1, 'Amount' => 2, 'UnitId' => 3, 'Buy' => 4, 'SellPublic' => 5, 'SellDistributor' => 6, 'SellMisc' => 7, 'Discount' => 8, 'Unlimited' => 9, 'Status' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'productId' => 1, 'amount' => 2, 'unitId' => 3, 'buy' => 4, 'sellPublic' => 5, 'sellDistributor' => 6, 'sellMisc' => 7, 'discount' => 8, 'unlimited' => 9, 'status' => 10, ),
        self::TYPE_COLNAME       => array(StockTableMap::COL_ID => 0, StockTableMap::COL_PRODUCT_ID => 1, StockTableMap::COL_AMOUNT => 2, StockTableMap::COL_UNIT_ID => 3, StockTableMap::COL_BUY => 4, StockTableMap::COL_SELL_PUBLIC => 5, StockTableMap::COL_SELL_DISTRIBUTOR => 6, StockTableMap::COL_SELL_MISC => 7, StockTableMap::COL_DISCOUNT => 8, StockTableMap::COL_UNLIMITED => 9, StockTableMap::COL_STATUS => 10, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_PRODUCT_ID' => 1, 'COL_AMOUNT' => 2, 'COL_UNIT_ID' => 3, 'COL_BUY' => 4, 'COL_SELL_PUBLIC' => 5, 'COL_SELL_DISTRIBUTOR' => 6, 'COL_SELL_MISC' => 7, 'COL_DISCOUNT' => 8, 'COL_UNLIMITED' => 9, 'COL_STATUS' => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'product_id' => 1, 'amount' => 2, 'unit_id' => 3, 'buy' => 4, 'sell_public' => 5, 'sell_distributor' => 6, 'sell_misc' => 7, 'discount' => 8, 'unlimited' => 9, 'status' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('stock');
        $this->setPhpName('Stock');
        $this->setClassName('\\ORM\\Stock');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'BIGINT', true, 20, null);
        $this->addForeignKey('PRODUCT_ID', 'ProductId', 'BIGINT', 'product', 'ID', false, 20, null);
        $this->addColumn('AMOUNT', 'Amount', 'DECIMAL', false, 10, null);
        $this->addForeignKey('UNIT_ID', 'UnitId', 'BIGINT', 'unit', 'ID', false, 20, null);
        $this->addColumn('BUY', 'Buy', 'INTEGER', false, 10, null);
        $this->addColumn('SELL_PUBLIC', 'SellPublic', 'INTEGER', false, 10, null);
        $this->addColumn('SELL_DISTRIBUTOR', 'SellDistributor', 'INTEGER', false, 10, null);
        $this->addColumn('SELL_MISC', 'SellMisc', 'INTEGER', false, 10, null);
        $this->addColumn('DISCOUNT', 'Discount', 'DECIMAL', false, 5, null);
        $this->addColumn('UNLIMITED', 'Unlimited', 'BOOLEAN', false, 1, null);
        $this->addColumn('STATUS', 'Status', 'CHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Product', '\\ORM\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('Unit', '\\ORM\\Unit', RelationMap::MANY_TO_ONE, array('unit_id' => 'id', ), 'NO ACTION', 'RESTRICT');
        $this->addRelation('Purchase', '\\ORM\\PurchaseDetail', RelationMap::ONE_TO_MANY, array('id' => 'stock_id', ), 'RESTRICT', 'RESTRICT', 'Purchases');
        $this->addRelation('Sales', '\\ORM\\SalesDetail', RelationMap::ONE_TO_MANY, array('id' => 'stock_id', ), 'RESTRICT', 'RESTRICT', 'Saless');
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
        return $withPrefix ? StockTableMap::CLASS_DEFAULT : StockTableMap::OM_CLASS;
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
     * @return array           (Stock object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StockTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StockTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StockTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StockTableMap::OM_CLASS;
            /** @var Stock $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StockTableMap::addInstanceToPool($obj, $key);
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
            $key = StockTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StockTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Stock $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StockTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(StockTableMap::COL_ID);
            $criteria->addSelectColumn(StockTableMap::COL_PRODUCT_ID);
            $criteria->addSelectColumn(StockTableMap::COL_AMOUNT);
            $criteria->addSelectColumn(StockTableMap::COL_UNIT_ID);
            $criteria->addSelectColumn(StockTableMap::COL_BUY);
            $criteria->addSelectColumn(StockTableMap::COL_SELL_PUBLIC);
            $criteria->addSelectColumn(StockTableMap::COL_SELL_DISTRIBUTOR);
            $criteria->addSelectColumn(StockTableMap::COL_SELL_MISC);
            $criteria->addSelectColumn(StockTableMap::COL_DISCOUNT);
            $criteria->addSelectColumn(StockTableMap::COL_UNLIMITED);
            $criteria->addSelectColumn(StockTableMap::COL_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.AMOUNT');
            $criteria->addSelectColumn($alias . '.UNIT_ID');
            $criteria->addSelectColumn($alias . '.BUY');
            $criteria->addSelectColumn($alias . '.SELL_PUBLIC');
            $criteria->addSelectColumn($alias . '.SELL_DISTRIBUTOR');
            $criteria->addSelectColumn($alias . '.SELL_MISC');
            $criteria->addSelectColumn($alias . '.DISCOUNT');
            $criteria->addSelectColumn($alias . '.UNLIMITED');
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
        return Propel::getServiceContainer()->getDatabaseMap(StockTableMap::DATABASE_NAME)->getTable(StockTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(StockTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(StockTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new StockTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Stock or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Stock object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\Stock) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StockTableMap::DATABASE_NAME);
            $criteria->add(StockTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = StockQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            StockTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                StockTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the stock table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StockQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Stock or Criteria object.
     *
     * @param mixed               $criteria Criteria or Stock object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Stock object
        }

        if ($criteria->containsKey(StockTableMap::COL_ID) && $criteria->keyContainsValue(StockTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StockTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = StockQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // StockTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StockTableMap::buildTableMap();
