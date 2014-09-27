<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\Credit as ChildCredit;
use ORM\CreditQuery as ChildCreditQuery;
use ORM\Map\CreditTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'credit' table.
 *
 *
 *
 * @method     ChildCreditQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCreditQuery orderBySalesId($order = Criteria::ASC) Order by the sales_id column
 * @method     ChildCreditQuery orderByTotal($order = Criteria::ASC) Order by the total column
 * @method     ChildCreditQuery orderByPaid($order = Criteria::ASC) Order by the paid column
 * @method     ChildCreditQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildCreditQuery groupById() Group by the id column
 * @method     ChildCreditQuery groupBySalesId() Group by the sales_id column
 * @method     ChildCreditQuery groupByTotal() Group by the total column
 * @method     ChildCreditQuery groupByPaid() Group by the paid column
 * @method     ChildCreditQuery groupByStatus() Group by the status column
 *
 * @method     ChildCreditQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCreditQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCreditQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCreditQuery leftJoinSales($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sales relation
 * @method     ChildCreditQuery rightJoinSales($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sales relation
 * @method     ChildCreditQuery innerJoinSales($relationAlias = null) Adds a INNER JOIN clause to the query using the Sales relation
 *
 * @method     ChildCreditQuery leftJoinPayment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Payment relation
 * @method     ChildCreditQuery rightJoinPayment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Payment relation
 * @method     ChildCreditQuery innerJoinPayment($relationAlias = null) Adds a INNER JOIN clause to the query using the Payment relation
 *
 * @method     \ORM\SalesQuery|\ORM\CreditPaymentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCredit findOne(ConnectionInterface $con = null) Return the first ChildCredit matching the query
 * @method     ChildCredit findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCredit matching the query, or a new ChildCredit object populated from the query conditions when no match is found
 *
 * @method     ChildCredit findOneById(string $id) Return the first ChildCredit filtered by the id column
 * @method     ChildCredit findOneBySalesId(string $sales_id) Return the first ChildCredit filtered by the sales_id column
 * @method     ChildCredit findOneByTotal(int $total) Return the first ChildCredit filtered by the total column
 * @method     ChildCredit findOneByPaid(int $paid) Return the first ChildCredit filtered by the paid column
 * @method     ChildCredit findOneByStatus(string $status) Return the first ChildCredit filtered by the status column
 *
 * @method     ChildCredit[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCredit objects based on current ModelCriteria
 * @method     ChildCredit[]|ObjectCollection findById(string $id) Return ChildCredit objects filtered by the id column
 * @method     ChildCredit[]|ObjectCollection findBySalesId(string $sales_id) Return ChildCredit objects filtered by the sales_id column
 * @method     ChildCredit[]|ObjectCollection findByTotal(int $total) Return ChildCredit objects filtered by the total column
 * @method     ChildCredit[]|ObjectCollection findByPaid(int $paid) Return ChildCredit objects filtered by the paid column
 * @method     ChildCredit[]|ObjectCollection findByStatus(string $status) Return ChildCredit objects filtered by the status column
 * @method     ChildCredit[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CreditQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ORM\Base\CreditQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pos', $modelName = '\\ORM\\Credit', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCreditQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCreditQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCreditQuery) {
            return $criteria;
        }
        $query = new ChildCreditQuery();
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
     * @return ChildCredit|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CreditTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CreditTableMap::DATABASE_NAME);
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
     * @return ChildCredit A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, SALES_ID, TOTAL, PAID, STATUS FROM credit WHERE ID = :p0';
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
            /** @var ChildCredit $obj */
            $obj = new ChildCredit();
            $obj->hydrate($row);
            CreditTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCredit|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCreditQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CreditTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCreditQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CreditTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCreditQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CreditTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CreditTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the sales_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySalesId(1234); // WHERE sales_id = 1234
     * $query->filterBySalesId(array(12, 34)); // WHERE sales_id IN (12, 34)
     * $query->filterBySalesId(array('min' => 12)); // WHERE sales_id > 12
     * </code>
     *
     * @see       filterBySales()
     *
     * @param     mixed $salesId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCreditQuery The current query, for fluid interface
     */
    public function filterBySalesId($salesId = null, $comparison = null)
    {
        if (is_array($salesId)) {
            $useMinMax = false;
            if (isset($salesId['min'])) {
                $this->addUsingAlias(CreditTableMap::COL_SALES_ID, $salesId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($salesId['max'])) {
                $this->addUsingAlias(CreditTableMap::COL_SALES_ID, $salesId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditTableMap::COL_SALES_ID, $salesId, $comparison);
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total > 12
     * </code>
     *
     * @param     mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCreditQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(CreditTableMap::COL_TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(CreditTableMap::COL_TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditTableMap::COL_TOTAL, $total, $comparison);
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
     * @return $this|ChildCreditQuery The current query, for fluid interface
     */
    public function filterByPaid($paid = null, $comparison = null)
    {
        if (is_array($paid)) {
            $useMinMax = false;
            if (isset($paid['min'])) {
                $this->addUsingAlias(CreditTableMap::COL_PAID, $paid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paid['max'])) {
                $this->addUsingAlias(CreditTableMap::COL_PAID, $paid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CreditTableMap::COL_PAID, $paid, $comparison);
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
     * @return $this|ChildCreditQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CreditTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \ORM\Sales object
     *
     * @param \ORM\Sales|ObjectCollection $sales The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCreditQuery The current query, for fluid interface
     */
    public function filterBySales($sales, $comparison = null)
    {
        if ($sales instanceof \ORM\Sales) {
            return $this
                ->addUsingAlias(CreditTableMap::COL_SALES_ID, $sales->getId(), $comparison);
        } elseif ($sales instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CreditTableMap::COL_SALES_ID, $sales->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCreditQuery The current query, for fluid interface
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
     * Filter the query by a related \ORM\CreditPayment object
     *
     * @param \ORM\CreditPayment|ObjectCollection $creditPayment  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCreditQuery The current query, for fluid interface
     */
    public function filterByPayment($creditPayment, $comparison = null)
    {
        if ($creditPayment instanceof \ORM\CreditPayment) {
            return $this
                ->addUsingAlias(CreditTableMap::COL_ID, $creditPayment->getCreditId(), $comparison);
        } elseif ($creditPayment instanceof ObjectCollection) {
            return $this
                ->usePaymentQuery()
                ->filterByPrimaryKeys($creditPayment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPayment() only accepts arguments of type \ORM\CreditPayment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Payment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCreditQuery The current query, for fluid interface
     */
    public function joinPayment($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Payment');

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
            $this->addJoinObject($join, 'Payment');
        }

        return $this;
    }

    /**
     * Use the Payment relation CreditPayment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\CreditPaymentQuery A secondary query class using the current class as primary query
     */
    public function usePaymentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPayment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Payment', '\ORM\CreditPaymentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCredit $credit Object to remove from the list of results
     *
     * @return $this|ChildCreditQuery The current query, for fluid interface
     */
    public function prune($credit = null)
    {
        if ($credit) {
            $this->addUsingAlias(CreditTableMap::COL_ID, $credit->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the credit table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CreditTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CreditTableMap::clearInstancePool();
            CreditTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CreditTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CreditTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CreditTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CreditTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CreditQuery
