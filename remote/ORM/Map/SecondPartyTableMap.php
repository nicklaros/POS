<?php

namespace ORM\Map;

use ORM\SecondParty;
use ORM\SecondPartyQuery;
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
 * This class defines the structure of the 'second_party' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SecondPartyTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ORM.Map.SecondPartyTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pos';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'second_party';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ORM\\SecondParty';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ORM.SecondParty';

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
    const COL_ID = 'second_party.ID';

    /**
     * the column name for the REGISTERED_DATE field
     */
    const COL_REGISTERED_DATE = 'second_party.REGISTERED_DATE';

    /**
     * the column name for the NAME field
     */
    const COL_NAME = 'second_party.NAME';

    /**
     * the column name for the ADDRESS field
     */
    const COL_ADDRESS = 'second_party.ADDRESS';

    /**
     * the column name for the BIRTHDAY field
     */
    const COL_BIRTHDAY = 'second_party.BIRTHDAY';

    /**
     * the column name for the GENDER field
     */
    const COL_GENDER = 'second_party.GENDER';

    /**
     * the column name for the PHONE field
     */
    const COL_PHONE = 'second_party.PHONE';

    /**
     * the column name for the TYPE field
     */
    const COL_TYPE = 'second_party.TYPE';

    /**
     * the column name for the STATUS field
     */
    const COL_STATUS = 'second_party.STATUS';

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
        self::TYPE_PHPNAME       => array('Id', 'RegisteredDate', 'Name', 'Address', 'Birthday', 'Gender', 'Phone', 'Type', 'Status', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'registeredDate', 'name', 'address', 'birthday', 'gender', 'phone', 'type', 'status', ),
        self::TYPE_COLNAME       => array(SecondPartyTableMap::COL_ID, SecondPartyTableMap::COL_REGISTERED_DATE, SecondPartyTableMap::COL_NAME, SecondPartyTableMap::COL_ADDRESS, SecondPartyTableMap::COL_BIRTHDAY, SecondPartyTableMap::COL_GENDER, SecondPartyTableMap::COL_PHONE, SecondPartyTableMap::COL_TYPE, SecondPartyTableMap::COL_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_REGISTERED_DATE', 'COL_NAME', 'COL_ADDRESS', 'COL_BIRTHDAY', 'COL_GENDER', 'COL_PHONE', 'COL_TYPE', 'COL_STATUS', ),
        self::TYPE_FIELDNAME     => array('id', 'registered_date', 'name', 'address', 'birthday', 'gender', 'phone', 'type', 'status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'RegisteredDate' => 1, 'Name' => 2, 'Address' => 3, 'Birthday' => 4, 'Gender' => 5, 'Phone' => 6, 'Type' => 7, 'Status' => 8, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'registeredDate' => 1, 'name' => 2, 'address' => 3, 'birthday' => 4, 'gender' => 5, 'phone' => 6, 'type' => 7, 'status' => 8, ),
        self::TYPE_COLNAME       => array(SecondPartyTableMap::COL_ID => 0, SecondPartyTableMap::COL_REGISTERED_DATE => 1, SecondPartyTableMap::COL_NAME => 2, SecondPartyTableMap::COL_ADDRESS => 3, SecondPartyTableMap::COL_BIRTHDAY => 4, SecondPartyTableMap::COL_GENDER => 5, SecondPartyTableMap::COL_PHONE => 6, SecondPartyTableMap::COL_TYPE => 7, SecondPartyTableMap::COL_STATUS => 8, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_REGISTERED_DATE' => 1, 'COL_NAME' => 2, 'COL_ADDRESS' => 3, 'COL_BIRTHDAY' => 4, 'COL_GENDER' => 5, 'COL_PHONE' => 6, 'COL_TYPE' => 7, 'COL_STATUS' => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'registered_date' => 1, 'name' => 2, 'address' => 3, 'birthday' => 4, 'gender' => 5, 'phone' => 6, 'type' => 7, 'status' => 8, ),
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
        $this->setName('second_party');
        $this->setPhpName('SecondParty');
        $this->setClassName('\\ORM\\SecondParty');
        $this->setPackage('ORM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'BIGINT', true, 20, null);
        $this->addColumn('REGISTERED_DATE', 'RegisteredDate', 'DATE', false, null, null);
        $this->addColumn('NAME', 'Name', 'CHAR', false, 128, null);
        $this->addColumn('ADDRESS', 'Address', 'CHAR', false, 128, null);
        $this->addColumn('BIRTHDAY', 'Birthday', 'DATE', false, null, null);
        $this->addColumn('GENDER', 'Gender', 'CHAR', false, null, null);
        $this->addColumn('PHONE', 'Phone', 'CHAR', false, 20, null);
        $this->addColumn('TYPE', 'Type', 'CHAR', false, null, null);
        $this->addColumn('STATUS', 'Status', 'CHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Purchase', '\\ORM\\Purchase', RelationMap::ONE_TO_MANY, array('id' => 'second_party_id', ), 'RESTRICT', 'RESTRICT', 'Purchases');
        $this->addRelation('Sales', '\\ORM\\Sales', RelationMap::ONE_TO_MANY, array('id' => 'second_party_id', ), 'RESTRICT', 'RESTRICT', 'Saless');
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
        return $withPrefix ? SecondPartyTableMap::CLASS_DEFAULT : SecondPartyTableMap::OM_CLASS;
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
     * @return array           (SecondParty object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SecondPartyTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SecondPartyTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SecondPartyTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SecondPartyTableMap::OM_CLASS;
            /** @var SecondParty $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SecondPartyTableMap::addInstanceToPool($obj, $key);
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
            $key = SecondPartyTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SecondPartyTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SecondParty $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SecondPartyTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SecondPartyTableMap::COL_ID);
            $criteria->addSelectColumn(SecondPartyTableMap::COL_REGISTERED_DATE);
            $criteria->addSelectColumn(SecondPartyTableMap::COL_NAME);
            $criteria->addSelectColumn(SecondPartyTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(SecondPartyTableMap::COL_BIRTHDAY);
            $criteria->addSelectColumn(SecondPartyTableMap::COL_GENDER);
            $criteria->addSelectColumn(SecondPartyTableMap::COL_PHONE);
            $criteria->addSelectColumn(SecondPartyTableMap::COL_TYPE);
            $criteria->addSelectColumn(SecondPartyTableMap::COL_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.REGISTERED_DATE');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.ADDRESS');
            $criteria->addSelectColumn($alias . '.BIRTHDAY');
            $criteria->addSelectColumn($alias . '.GENDER');
            $criteria->addSelectColumn($alias . '.PHONE');
            $criteria->addSelectColumn($alias . '.TYPE');
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
        return Propel::getServiceContainer()->getDatabaseMap(SecondPartyTableMap::DATABASE_NAME)->getTable(SecondPartyTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SecondPartyTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SecondPartyTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SecondPartyTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SecondParty or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SecondParty object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SecondPartyTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ORM\SecondParty) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SecondPartyTableMap::DATABASE_NAME);
            $criteria->add(SecondPartyTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SecondPartyQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SecondPartyTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SecondPartyTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the second_party table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SecondPartyQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SecondParty or Criteria object.
     *
     * @param mixed               $criteria Criteria or SecondParty object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SecondPartyTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SecondParty object
        }

        if ($criteria->containsKey(SecondPartyTableMap::COL_ID) && $criteria->keyContainsValue(SecondPartyTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SecondPartyTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SecondPartyQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SecondPartyTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SecondPartyTableMap::buildTableMap();
