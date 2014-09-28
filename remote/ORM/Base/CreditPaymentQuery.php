<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\CreditPayment as ChildCreditPayment;
use ORM\CreditPaymentQuery as ChildCreditPaymentQuery;
use ORM\Map\CreditPaymentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'credit_payment' table.
 *
 *
 *
 * @method     ChildCreditPaymentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCreditPaymentQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method     ChildCreditPaymentQuery orderByCreditId($order = Criteria::ASC) Order by the credit_id column
 * @method     ChildCreditPaymentQuery orderByCashierId($order = Criteria::ASC) Order by the cashier_id column
 * @method     ChildCreditPaymentQuery orderByPaid($order = Criteria::ASC) Order by the paid column
 * @method     ChildCreditPaymentQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildCreditPaymentQuery groupById() Group by the id column
 * @method     ChildCreditPaymentQuery groupByDate() Group by the date column
 * @method     ChildCreditPaymentQuery groupByCreditId() Group by the credit_id column
 * @method     ChildCreditPaymentQuery groupByCashierId() Group by the cashier_id column
 * @method     ChildCreditPaymentQuery groupByPaid() Group by the paid column
 * @method     ChildCreditPaymentQuery groupByStatus() Group by the status column
 *
 * @method     ChildCreditPaymentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCreditPaymentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCreditPaymentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCreditPaymentQuery leftJoinCredit($relationAlias = null) Adds a LEFT JOIN clause to the query using the Credit relation
 * @method     ChildCreditPaymentQuery rightJoinCredit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Credit relation
 * @method     ChildCreditPaymentQuery innerJoinCredit($relationAlias = null) Adds a INNER JOIN clause to the query using the Credit relation
 *
 * @method     ChildCreditPaymentQuery leftJoinCashier($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cashier relation
 * @method     ChildCreditPaymentQuery rightJoinCashier($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cashier relation
 * @method     ChildCreditPaymentQuery innerJoinCashier($relationAlias = null) Adds a INNER JOIN clause to the query using the Cashier relation
 *
 * @method     \ORM\CreditQuery|\ORM\UserDetailQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCreditPayment findOne(ConnectionInterface $con = null) Return the first ChildCreditPayment matching the query
 * @method     ChildCreditPayment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCreditPayment matching the query, or a new ChildCreditPayment object populated from the query conditions when no match is found
 *
 * @method     ChildCreditPayment findOneById(string $id) Return the first ChildCreditPayment filtered by the id column
 * @method     ChildCreditPayment findOneByDate(string $date) Return the first ChildCreditPayment filtered by the date column
 * @method     ChildCreditPayment findOneByCreditId(string $credit_id) Return the first ChildCreditPayment filtered by the credit_id column
 * @method     ChildCreditPayment findOneByCashierId(string $cashier_id) Return the first ChildCreditPayment filtered by the cashier_id column
 * @method     ChildCreditPayment findOneByPaid(int $paid) Return the first ChildCreditPayment filtered by the paid column
 * @method     ChildCreditPayment findOneByStatus(string $status) Return the first ChildCreditPayment filtered by the status column
 *
 * @method     ChildCreditPayment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCreditPayment objects based on current ModelCriteria
 * @method     ChildCreditPayment[]|ObjectCollection findById(string $id) Return ChildCreditPayment objects filtered by the id column
 * @method     ChildCreditPayment[]|ObjectCollection findByDate(string $date) Return ChildCreditPayment objects filtered by the date column
 * @method     ChildCreditPayment[]|ObjectCollection findByCreditId(string $credit_id) Return ChildCreditPayment objects filtered by the credit_id column
 * @method     ChildCreditPayment[]|ObjectCollection findByCashierId(string $cashier_id) Return ChildCreditPayment objects filtered by the cashier_id column
 * @method     ChildCreditPayment[]|ObjectCollection findByPaid(int $paid) Return ChildCreditPayment objects filtered by the paid column
 * @method     ChildCreditPayment[]|ObjectCollection findByStatus(string $status) Return ChildCreditPayment objects filtered by the status column
 * @method     ChildCreditPayment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CreditPaymentQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ORM\Base\CreditPaymentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pos', $modelName = '\\ORM\\CreditPayment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCreditPaymentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCreditPaymentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCreditPaymentQuery) {
            return $criteria;
        }
        $query = new ChildCreditPaymentQuery();
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
     * @return ChildCreditPayment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CreditPaymentTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CreditPaymentTableMap::DATABASE_NAME);
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
     * @return ChildCreditPayment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, DATE, CREDIT_ID, CASHIER_ID, PAID, STATUS FROM credit_payment WHERE ID = :p0';
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
            /** @var ChildCreditPayment $obj */
            $obj = new ChildCreditPayment();
            $obj->hydrate($row);
            CreditPaymentTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCreditPayment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CreditPaymentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CreditPaymentTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditPaymentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date > '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditPaymentTableMap::COL_DATE, $date, $comparison);
    }

    /**
     * Filter the query on the credit_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCreditId(1234); // WHERE credit_id = 1234
     * $query->filterByCreditId(array(12, 34)); // WHERE credit_id IN (12, 34)
     * $query->filterByCreditId(array('min' => 12)); // WHERE credit_id > 12
     * </code>
     *
     * @see       filterByCredit()
     *
     * @param     mixed $creditId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterByCreditId($creditId = null, $comparison = null)
    {
        if (is_array($creditId)) {
            $useMinMax = false;
            if (isset($creditId['min'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_CREDIT_ID, $creditId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creditId['max'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_CREDIT_ID, $creditId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditPaymentTableMap::COL_CREDIT_ID, $creditId, $comparison);
    }

    /**
     * Filter the query on the cashier_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCashierId(1234); // WHERE cashier_id = 1234
     * $query->filterByCashierId(array(12, 34)); // WHERE cashier_id IN (12, 34)
     * $query->filterByCashierId(array('min' => 12)); // WHERE cashier_id > 12
     * </code>
     *
     * @see       filterByCashier()
     *
     * @param     mixed $cashierId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterByCashierId($cashierId = null, $comparison = null)
    {
        if (is_array($cashierId)) {
            $useMinMax = false;
            if (isset($cashierId['min'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_CASHIER_ID, $cashierId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cashierId['max'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_CASHIER_ID, $cashierId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditPaymentTableMap::COL_CASHIER_ID, $cashierId, $comparison);
    }

    /**
     * Filter the query on the paid column
     *
     * Example usage:
     * <code>
     * $query->filterByPaid(1234); // WHERE paid = 1234
     * $query->filterByPaid(array(12, 34)); // WHERE paid IN (12, 34)
     * $query->filterByPaid(array('min' => 12)); // WHERE paid > 12
     * </code>
     *
     * @param     mixed $paid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterByPaid($paid = null, $comparison = null)
    {
        if (is_array($paid)) {
            $useMinMax = false;
            if (isset($paid['min'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_PAID, $paid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paid['max'])) {
                $this->addUsingAlias(CreditPaymentTableMap::COL_PAID, $paid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditPaymentTableMap::COL_PAID, $paid, $comparison);
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
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CreditPaymentTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \ORM\Credit object
     *
     * @param \ORM\Credit|ObjectCollection $credit The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterByCredit($credit, $comparison = null)
    {
        if ($credit instanceof \ORM\Credit) {
            return $this
                ->addUsingAlias(CreditPaymentTableMap::COL_CREDIT_ID, $credit->getId(), $comparison);
        } elseif ($credit instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CreditPaymentTableMap::COL_CREDIT_ID, $credit->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCredit() only accepts arguments of type \ORM\Credit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Credit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function joinCredit($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Credit');

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
            $this->addJoinObject($join, 'Credit');
        }

        return $this;
    }

    /**
     * Use the Credit relation Credit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\CreditQuery A secondary query class using the current class as primary query
     */
    public function useCreditQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCredit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Credit', '\ORM\CreditQuery');
    }

    /**
     * Filter the query by a related \ORM\UserDetail object
     *
     * @param \ORM\UserDetail|ObjectCollection $userDetail The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function filterByCashier($userDetail, $comparison = null)
    {
        if ($userDetail instanceof \ORM\UserDetail) {
            return $this
                ->addUsingAlias(CreditPaymentTableMap::COL_CASHIER_ID, $userDetail->getId(), $comparison);
        } elseif ($userDetail instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CreditPaymentTableMap::COL_CASHIER_ID, $userDetail->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCashier() only accepts arguments of type \ORM\UserDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cashier relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function joinCashier($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cashier');

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
            $this->addJoinObject($join, 'Cashier');
        }

        return $this;
    }

    /**
     * Use the Cashier relation UserDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\UserDetailQuery A secondary query class using the current class as primary query
     */
    public function useCashierQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCashier($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cashier', '\ORM\UserDetailQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCreditPayment $creditPayment Object to remove from the list of results
     *
     * @return $this|ChildCreditPaymentQuery The current query, for fluid interface
     */
    public function prune($creditPayment = null)
    {
        if ($creditPayment) {
            $this->addUsingAlias(CreditPaymentTableMap::COL_ID, $creditPayment->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the credit_payment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CreditPaymentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CreditPaymentTableMap::clearInstancePool();
            CreditPaymentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CreditPaymentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CreditPaymentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CreditPaymentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CreditPaymentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CreditPaymentQuery
