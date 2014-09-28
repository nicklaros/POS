<?php

namespace ORM\Map;

use ORM\Sales;
use ORM\SalesQuery;
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
 * This class defines the structure of the 'sales' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SalesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.SalesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'sales';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\Sales';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.Sales';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'sales.ID';

    /**
     * the column name for the DATE field
     */
    const COL_DATE = 'sales.DATE';

    /**
     * the column name for the SECOND_PARTY_ID field
     */
    const COL_SECOND_PARTY_ID = 'sales.SECOND_PARTY_ID';

    /**
     * the column name for the BUY_PRICE field
     */
    const COL_BUY_PRICE = 'sales.BUY_PRICE';

    /**
     * the column name for the TOTAL_PRICE field
     */
    const COL_TOTAL_PRICE = 'sales.TOTAL_PRICE';

    /**
     * the column name for the PAID field
     */
    const COL_PAID = 'sales.PAID';

    /**
     * the column name for the CASHIER_ID field
     */
    const COL_CASHIER_ID = 'sales.CASHIER_ID';

    /**
     * the column name for the NOTE field
     */
    const COL_NOTE = 'sales.NOTE';

    /**
     * the column name for the STATUS field
     */
    const COL_STATUS = 'sales.STATUS';

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
        self::TYPE_PHPNAME       => array('Id', 'Date', 'SecondPartyId', 'BuyPrice', 'TotalPrice', 'Paid', 'CashierId', 'Note', 'Status', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'date', 'secondPartyId', 'buyPrice', 'totalPrice', 'paid', 'cashierId', 'note', 'status', ),
        self::TYPE_COLNAME       => array(SalesTableMap::COL_ID, SalesTableMap::COL_DATE, SalesTableMap::COL_SECOND_PARTY_ID, SalesTableMap::COL_BUY_PRICE, SalesTableMap::COL_TOTAL_PRICE, SalesTableMap::COL_PAID, SalesTableMap::COL_CASHIER_ID, SalesTableMap::COL_NOTE, SalesTableMap::COL_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_DATE', 'COL_SECOND_PARTY_ID', 'COL_BUY_PRICE', 'COL_TOTAL_PRICE', 'COL_PAID', 'COL_CASHIER_ID', 'COL_NOTE', 'COL_STATUS', ),
        self::TYPE_FIELDNAME     => array('id', 'date', 'second_party_id', 'buy_price', 'total_price', 'paid', 'cashier_id', 'note', 'status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Date' => 1, 'SecondPartyId' => 2, 'BuyPrice' => 3, 'TotalPrice' => 4, 'Paid' => 5, 'CashierId' => 6, 'Note' => 7, 'Status' => 8, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'date' => 1, 'secondPartyId' => 2, 'buyPrice' => 3, 'totalPrice' => 4, 'paid' => 5, 'cashierId' => 6, 'note' => 7, 'status' => 8, ),
        self::TYPE_COLNAME       => array(SalesTableMap::COL_ID => 0, SalesTableMap::COL_DATE => 1, SalesTableMap::COL_SECOND_PARTY_ID => 2, SalesTableMap::COL_BUY_PRICE => 3, SalesTableMap::COL_TOTAL_PRICE => 4, SalesTableMap::COL_PAID => 5, SalesTableMap::COL_CASHIER_ID => 6, SalesTableMap::COL_NOTE => 7, SalesTableMap::COL_STATUS => 8, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_DATE' => 1, 'COL_SECOND_PARTY_ID' => 2, 'COL_BUY_PRICE' => 3, 'COL_TOTAL_PRICE' => 4, 'COL_PAID' => 5, 'COL_CASHIER_ID' => 6, 'COL_NOTE' => 7, 'COL_STATUS' => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'date' => 1, 'second_party_id' => 2, 'buy_price' => 3, 'total_price' => 4, 'paid' => 5, 'cashier_id' => 6, 'note' => 7, 'status' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('sales');
        $this->setPhpName('Sales');
        $this->setClassName('\\ORM\\Sales');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'BIGINT', true, 20, null);
        $this->addColumn('DATE', 'Date', 'DATE', false, null, null);
        $this->addForeignKey('SECOND_PARTY_ID', 'SecondPartyId', 'BIGINT', 'second_party', 'ID', false, 20, null);
        $this->addColumn('BUY_PRICE', 'BuyPrice', 'INTEGER', false, 10, null);
        $this->addColumn('TOTAL_PRICE', 'TotalPrice', 'INTEGER', false, 10, null);
        $this->addColumn('PAID', 'Paid', 'INTEGER', false, 10, null);
        $this->addForeignKey('CASHIER_ID', 'CashierId', 'BIGINT', 'user_detail', 'ID', false, 20, null);
        $this->addColumn('NOTE', 'Note', 'CHAR', false, 32, null);
        $this->addColumn('STATUS', 'Status', 'CHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SecondParty', '\\ORM\\SecondParty', RelationMap::MANY_TO_ONE, array('second_party_id' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('Cashier', '\\ORM\\UserDetail', RelationMap::MANY_TO_ONE, array('cashier_id' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('Credit', '\\ORM\\Credit', RelationMap::ONE_TO_MANY, array('id' => 'sales_id', ), 'CASCADE', 'CASCADE', 'Credits');
        $this->addRelation('Detail', '\\ORM\\SalesDetail', RelationMap::ONE_TO_MANY, array('id' => 'sales_id', ), 'CASCADE', 'RESTRICT', 'Details');
        $this->addRelation('History', '\\ORM\\SalesHistory', RelationMap::ONE_TO_MANY, array('id' => 'sales_id', ), 'NO ACTION', 'RESTRICT', 'Histories');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to sales     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CreditTableMap::clearInstancePool();
        SalesDetailTableMap::clearInstancePool();
    }

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
        return $withPrefix ? SalesTableMap::CLASS_DEFAULT : SalesTableMap::OM_CLASS;
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
     * @return array           (Sales object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SalesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SalesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SalesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SalesTableMap::OM_CLASS;
            /** @var Sales $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SalesTableMap::addInstanceToPool($obj, $key);
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
            $key = SalesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SalesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Sales $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SalesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SalesTableMap::COL_ID);
            $criteria->addSelectColumn(SalesTableMap::COL_DATE);
            $criteria->addSelectColumn(SalesTableMap::COL_SECOND_PARTY_ID);
            $criteria->addSelectColumn(SalesTableMap::COL_BUY_PRICE);
            $criteria->addSelectColumn(SalesTableMap::COL_TOTAL_PRICE);
            $criteria->addSelectColumn(SalesTableMap::COL_PAID);
            $criteria->addSelectColumn(SalesTableMap::COL_CASHIER_ID);
            $criteria->addSelectColumn(SalesTableMap::COL_NOTE);
            $criteria->addSelectColumn(SalesTableMap::COL_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.DATE');
            $criteria->addSelectColumn($alias . '.SECOND_PARTY_ID');
            $criteria->addSelectColumn($alias . '.BUY_PRICE');
            $criteria->addSelectColumn($alias . '.TOTAL_PRICE');
            $criteria->addSelectColumn($alias . '.PAID');
            $criteria->addSelectColumn($alias . '.CASHIER_ID');
            $criteria->addSelectColumn($alias . '.NOTE');
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
        return Propel::getServiceContainer()->getDatabaseMap(SalesTableMap::DATABASE_NAME)->getTable(SalesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SalesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SalesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SalesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Sales or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Sales object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SalesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\Sales) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SalesTableMap::DATABASE_NAME);
            $criteria->add(SalesTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SalesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SalesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SalesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the sales table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SalesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Sales or Criteria object.
     *
     * @param mixed               $criteria Criteria or Sales object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SalesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Sales object
        }

        if ($criteria->containsKey(SalesTableMap::COL_ID) && $criteria->keyContainsValue(SalesTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SalesTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SalesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SalesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SalesTableMap::buildTableMap();
