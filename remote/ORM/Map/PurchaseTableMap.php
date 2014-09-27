<?php

namespace ORM\Map;

use ORM\Purchase;
use ORM\PurchaseQuery;
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
 * This class defines the structure of the 'purchase' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PurchaseTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.PurchaseTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'purchase';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\Purchase';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.Purchase';

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
    const COL_ID = 'purchase.ID';

    /**
     * the column name for the DATE field
     */
    const COL_DATE = 'purchase.DATE';

    /**
     * the column name for the SECOND_PARTY_ID field
     */
    const COL_SECOND_PARTY_ID = 'purchase.SECOND_PARTY_ID';

    /**
     * the column name for the TOTAL_PRICE field
     */
    const COL_TOTAL_PRICE = 'purchase.TOTAL_PRICE';

    /**
     * the column name for the PAID field
     */
    const COL_PAID = 'purchase.PAID';

    /**
     * the column name for the NOTE field
     */
    const COL_NOTE = 'purchase.NOTE';

    /**
     * the column name for the STATUS field
     */
    const COL_STATUS = 'purchase.STATUS';

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
        self::TYPE_PHPNAME       => array('Id', 'Date', 'SecondPartyId', 'TotalPrice', 'Paid', 'Note', 'Status', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'date', 'secondPartyId', 'totalPrice', 'paid', 'note', 'status', ),
        self::TYPE_COLNAME       => array(PurchaseTableMap::COL_ID, PurchaseTableMap::COL_DATE, PurchaseTableMap::COL_SECOND_PARTY_ID, PurchaseTableMap::COL_TOTAL_PRICE, PurchaseTableMap::COL_PAID, PurchaseTableMap::COL_NOTE, PurchaseTableMap::COL_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_DATE', 'COL_SECOND_PARTY_ID', 'COL_TOTAL_PRICE', 'COL_PAID', 'COL_NOTE', 'COL_STATUS', ),
        self::TYPE_FIELDNAME     => array('id', 'date', 'second_party_id', 'total_price', 'paid', 'note', 'status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Date' => 1, 'SecondPartyId' => 2, 'TotalPrice' => 3, 'Paid' => 4, 'Note' => 5, 'Status' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'date' => 1, 'secondPartyId' => 2, 'totalPrice' => 3, 'paid' => 4, 'note' => 5, 'status' => 6, ),
        self::TYPE_COLNAME       => array(PurchaseTableMap::COL_ID => 0, PurchaseTableMap::COL_DATE => 1, PurchaseTableMap::COL_SECOND_PARTY_ID => 2, PurchaseTableMap::COL_TOTAL_PRICE => 3, PurchaseTableMap::COL_PAID => 4, PurchaseTableMap::COL_NOTE => 5, PurchaseTableMap::COL_STATUS => 6, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_DATE' => 1, 'COL_SECOND_PARTY_ID' => 2, 'COL_TOTAL_PRICE' => 3, 'COL_PAID' => 4, 'COL_NOTE' => 5, 'COL_STATUS' => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'date' => 1, 'second_party_id' => 2, 'total_price' => 3, 'paid' => 4, 'note' => 5, 'status' => 6, ),
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
        $this->setName('purchase');
        $this->setPhpName('Purchase');
        $this->setClassName('\\ORM\\Purchase');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'BIGINT', true, 20, null);
        $this->addColumn('DATE', 'Date', 'DATE', false, null, null);
        $this->addForeignKey('SECOND_PARTY_ID', 'SecondPartyId', 'BIGINT', 'second_party', 'ID', false, 20, null);
        $this->addColumn('TOTAL_PRICE', 'TotalPrice', 'INTEGER', false, 10, null);
        $this->addColumn('PAID', 'Paid', 'INTEGER', false, 10, null);
        $this->addColumn('NOTE', 'Note', 'CHAR', false, 32, null);
        $this->addColumn('STATUS', 'Status', 'CHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SecondParty', '\\ORM\\SecondParty', RelationMap::MANY_TO_ONE, array('second_party_id' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('Debit', '\\ORM\\Debit', RelationMap::ONE_TO_MANY, array('id' => 'purchase_id', ), 'CASCADE', 'CASCADE', 'Debits');
        $this->addRelation('Detail', '\\ORM\\PurchaseDetail', RelationMap::ONE_TO_MANY, array('id' => 'purchase_id', ), 'CASCADE', 'RESTRICT', 'Details');
        $this->addRelation('History', '\\ORM\\PurchaseHistory', RelationMap::ONE_TO_MANY, array('id' => 'purchase_id', ), 'NO ACTION', 'RESTRICT', 'Histories');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to purchase     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        DebitTableMap::clearInstancePool();
        PurchaseDetailTableMap::clearInstancePool();
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
        return $withPrefix ? PurchaseTableMap::CLASS_DEFAULT : PurchaseTableMap::OM_CLASS;
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
     * @return array           (Purchase object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PurchaseTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PurchaseTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PurchaseTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PurchaseTableMap::OM_CLASS;
            /** @var Purchase $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PurchaseTableMap::addInstanceToPool($obj, $key);
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
            $key = PurchaseTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PurchaseTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Purchase $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PurchaseTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PurchaseTableMap::COL_ID);
            $criteria->addSelectColumn(PurchaseTableMap::COL_DATE);
            $criteria->addSelectColumn(PurchaseTableMap::COL_SECOND_PARTY_ID);
            $criteria->addSelectColumn(PurchaseTableMap::COL_TOTAL_PRICE);
            $criteria->addSelectColumn(PurchaseTableMap::COL_PAID);
            $criteria->addSelectColumn(PurchaseTableMap::COL_NOTE);
            $criteria->addSelectColumn(PurchaseTableMap::COL_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.DATE');
            $criteria->addSelectColumn($alias . '.SECOND_PARTY_ID');
            $criteria->addSelectColumn($alias . '.TOTAL_PRICE');
            $criteria->addSelectColumn($alias . '.PAID');
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
        return Propel::getServiceContainer()->getDatabaseMap(PurchaseTableMap::DATABASE_NAME)->getTable(PurchaseTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PurchaseTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PurchaseTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PurchaseTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Purchase or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Purchase object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\Purchase) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PurchaseTableMap::DATABASE_NAME);
            $criteria->add(PurchaseTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PurchaseQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PurchaseTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PurchaseTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the purchase table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PurchaseQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Purchase or Criteria object.
     *
     * @param mixed               $criteria Criteria or Purchase object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Purchase object
        }

        if ($criteria->containsKey(PurchaseTableMap::COL_ID) && $criteria->keyContainsValue(PurchaseTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PurchaseTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PurchaseQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PurchaseTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PurchaseTableMap::buildTableMap();
