<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\SecondParty as ChildSecondParty;
use ORM\SecondPartyQuery as ChildSecondPartyQuery;
use ORM\Map\SecondPartyTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'second_party' table.
 *
 *
 *
 * @method     ChildSecondPartyQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSecondPartyQuery orderByRegisteredDate($order = Criteria::ASC) Order by the registered_date column
 * @method     ChildSecondPartyQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSecondPartyQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildSecondPartyQuery orderByBirthday($order = Criteria::ASC) Order by the birthday column
 * @method     ChildSecondPartyQuery orderByGender($order = Criteria::ASC) Order by the gender column
 * @method     ChildSecondPartyQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildSecondPartyQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildSecondPartyQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildSecondPartyQuery groupById() Group by the id column
 * @method     ChildSecondPartyQuery groupByRegisteredDate() Group by the registered_date column
 * @method     ChildSecondPartyQuery groupByName() Group by the name column
 * @method     ChildSecondPartyQuery groupByAddress() Group by the address column
 * @method     ChildSecondPartyQuery groupByBirthday() Group by the birthday column
 * @method     ChildSecondPartyQuery groupByGender() Group by the gender column
 * @method     ChildSecondPartyQuery groupByPhone() Group by the phone column
 * @method     ChildSecondPartyQuery groupByType() Group by the type column
 * @method     ChildSecondPartyQuery groupByStatus() Group by the status column
 *
 * @method     ChildSecondPartyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSecondPartyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSecondPartyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSecondPartyQuery leftJoinPurchase($relationAlias = null) Adds a LEFT JOIN clause to the query using the Purchase relation
 * @method     ChildSecondPartyQuery rightJoinPurchase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Purchase relation
 * @method     ChildSecondPartyQuery innerJoinPurchase($relationAlias = null) Adds a INNER JOIN clause to the query using the Purchase relation
 *
 * @method     ChildSecondPartyQuery leftJoinSales($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sales relation
 * @method     ChildSecondPartyQuery rightJoinSales($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sales relation
 * @method     ChildSecondPartyQuery innerJoinSales($relationAlias = null) Adds a INNER JOIN clause to the query using the Sales relation
 *
 * @method     \ORM\PurchaseQuery|\ORM\SalesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSecondParty findOne(ConnectionInterface $con = null) Return the first ChildSecondParty matching the query
 * @method     ChildSecondParty findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSecondParty matching the query, or a new ChildSecondParty object populated from the query conditions when no match is found
 *
 * @method     ChildSecondParty findOneById(string $id) Return the first ChildSecondParty filtered by the id column
 * @method     ChildSecondParty findOneByRegisteredDate(string $registered_date) Return the first ChildSecondParty filtered by the registered_date column
 * @method     ChildSecondParty findOneByName(string $name) Return the first ChildSecondParty filtered by the name column
 * @method     ChildSecondParty findOneByAddress(string $address) Return the first ChildSecondParty filtered by the address column
 * @method     ChildSecondParty findOneByBirthday(string $birthday) Return the first ChildSecondParty filtered by the birthday column
 * @method     ChildSecondParty findOneByGender(string $gender) Return the first ChildSecondParty filtered by the gender column
 * @method     ChildSecondParty findOneByPhone(string $phone) Return the first ChildSecondParty filtered by the phone column
 * @method     ChildSecondParty findOneByType(string $type) Return the first ChildSecondParty filtered by the type column
 * @method     ChildSecondParty findOneByStatus(string $status) Return the first ChildSecondParty filtered by the status column
 *
 * @method     ChildSecondParty[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSecondParty objects based on current ModelCriteria
 * @method     ChildSecondParty[]|ObjectCollection findById(string $id) Return ChildSecondParty objects filtered by the id column
 * @method     ChildSecondParty[]|ObjectCollection findByRegisteredDate(string $registered_date) Return ChildSecondParty objects filtered by the registered_date column
 * @method     ChildSecondParty[]|ObjectCollection findByName(string $name) Return ChildSecondParty objects filtered by the name column
 * @method     ChildSecondParty[]|ObjectCollection findByAddress(string $address) Return ChildSecondParty objects filtered by the address column
 * @method     ChildSecondParty[]|ObjectCollection findByBirthday(string $birthday) Return ChildSecondParty objects filtered by the birthday column
 * @method     ChildSecondParty[]|ObjectCollection findByGender(string $gender) Return ChildSecondParty objects filtered by the gender column
 * @method     ChildSecondParty[]|ObjectCollection findByPhone(string $phone) Return ChildSecondParty objects filtered by the phone column
 * @method     ChildSecondParty[]|ObjectCollection findByType(string $type) Return ChildSecondParty objects filtered by the type column
 * @method     ChildSecondParty[]|ObjectCollection findByStatus(string $status) Return ChildSecondParty objects filtered by the status column
 * @method     ChildSecondParty[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SecondPartyQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ORM\Base\SecondPartyQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pos', $modelName = '\\ORM\\SecondParty', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSecondPartyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSecondPartyQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSecondPartyQuery) {
            return $criteria;
        }
        $query = new ChildSecondPartyQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSecondParty|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SecondPartyTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SecondPartyTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSecondParty A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, REGISTERED_DATE, NAME, ADDRESS, BIRTHDAY, GENDER, PHONE, TYPE, STATUS FROM second_party WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSecondParty $obj */
            $obj = new ChildSecondParty();
            $obj->hydrate($row);
            SecondPartyTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSecondParty|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SecondPartyTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SecondPartyTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SecondPartyTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SecondPartyTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the registered_date column
     *
     * Example usage:
     * <code>
     * $query->filterByRegisteredDate('2011-03-14'); // WHERE registered_date = '2011-03-14'
     * $query->filterByRegisteredDate('now'); // WHERE registered_date = '2011-03-14'
     * $query->filterByRegisteredDate(array('max' => 'yesterday')); // WHERE registered_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $registeredDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByRegisteredDate($registeredDate = null, $comparison = null)
    {
        if (is_array($registeredDate)) {
            $useMinMax = false;
            if (isset($registeredDate['min'])) {
                $this->addUsingAlias(SecondPartyTableMap::COL_REGISTERED_DATE, $registeredDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registeredDate['max'])) {
                $this->addUsingAlias(SecondPartyTableMap::COL_REGISTERED_DATE, $registeredDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_REGISTERED_DATE, $registeredDate, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address)) {
                $address = str_replace('*', '%', $address);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the birthday column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthday('2011-03-14'); // WHERE birthday = '2011-03-14'
     * $query->filterByBirthday('now'); // WHERE birthday = '2011-03-14'
     * $query->filterByBirthday(array('max' => 'yesterday')); // WHERE birthday > '2011-03-13'
     * </code>
     *
     * @param     mixed $birthday The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByBirthday($birthday = null, $comparison = null)
    {
        if (is_array($birthday)) {
            $useMinMax = false;
            if (isset($birthday['min'])) {
                $this->addUsingAlias(SecondPartyTableMap::COL_BIRTHDAY, $birthday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthday['max'])) {
                $this->addUsingAlias(SecondPartyTableMap::COL_BIRTHDAY, $birthday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_BIRTHDAY, $birthday, $comparison);
    }

    /**
     * Filter the query on the gender column
     *
     * Example usage:
     * <code>
     * $query->filterByGender('fooValue');   // WHERE gender = 'fooValue'
     * $query->filterByGender('%fooValue%'); // WHERE gender LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gender The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByGender($gender = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gender)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $gender)) {
                $gender = str_replace('*', '%', $gender);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_GENDER, $gender, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phone)) {
                $phone = str_replace('*', '%', $phone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SecondPartyTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \ORM\Purchase object
     *
     * @param \ORM\Purchase|ObjectCollection $purchase  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterByPurchase($purchase, $comparison = null)
    {
        if ($purchase instanceof \ORM\Purchase) {
            return $this
                ->addUsingAlias(SecondPartyTableMap::COL_ID, $purchase->getSecondPartyId(), $comparison);
        } elseif ($purchase instanceof ObjectCollection) {
            return $this
                ->usePurchaseQuery()
                ->filterByPrimaryKeys($purchase->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPurchase() only accepts arguments of type \ORM\Purchase or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Purchase relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function joinPurchase($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Purchase');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Purchase');
        }

        return $this;
    }

    /**
     * Use the Purchase relation Purchase object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\PurchaseQuery A secondary query class using the current class as primary query
     */
    public function usePurchaseQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPurchase($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Purchase', '\ORM\PurchaseQuery');
    }

    /**
     * Filter the query by a related \ORM\Sales object
     *
     * @param \ORM\Sales|ObjectCollection $sales  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSecondPartyQuery The current query, for fluid interface
     */
    public function filterBySales($sales, $comparison = null)
    {
        if ($sales instanceof \ORM\Sales) {
            return $this
                ->addUsingAlias(SecondPartyTableMap::COL_ID, $sales->getSecondPartyId(), $comparison);
        } elseif ($sales instanceof ObjectCollection) {
            return $this
                ->useSalesQuery()
                ->filterByPrimaryKeys($sales->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySales() only accepts arguments of type \ORM\Sales or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sales relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function joinSales($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sales');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Sales');
        }

        return $this;
    }

    /**
     * Use the Sales relation Sales object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\SalesQuery A secondary query class using the current class as primary query
     */
    public function useSalesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSales($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sales', '\ORM\SalesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSecondParty $secondParty Object to remove from the list of results
     *
     * @return $this|ChildSecondPartyQuery The current query, for fluid interface
     */
    public function prune($secondParty = null)
    {
        if ($secondParty) {
            $this->addUsingAlias(SecondPartyTableMap::COL_ID, $secondParty->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the second_party table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SecondPartyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SecondPartyTableMap::clearInstancePool();
            SecondPartyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SecondPartyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SecondPartyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SecondPartyTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SecondPartyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SecondPartyQuery
