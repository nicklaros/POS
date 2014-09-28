<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\PurchaseDetail as ChildPurchaseDetail;
use ORM\PurchaseDetailQuery as ChildPurchaseDetailQuery;
use ORM\Map\PurchaseDetailTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'purchase_detail' table.
 *
 *
 *
 * @method     ChildPurchaseDetailQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPurchaseDetailQuery orderByPurchaseId($order = Criteria::ASC) Order by the purchase_id column
 * @method     ChildPurchaseDetailQuery orderByStockId($order = Criteria::ASC) Order by the stock_id column
 * @method     ChildPurchaseDetailQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildPurchaseDetailQuery orderByTotalPrice($order = Criteria::ASC) Order by the total_price column
 * @method     ChildPurchaseDetailQuery orderByNotificationId($order = Criteria::ASC) Order by the notification_id column
 * @method     ChildPurchaseDetailQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildPurchaseDetailQuery groupById() Group by the id column
 * @method     ChildPurchaseDetailQuery groupByPurchaseId() Group by the purchase_id column
 * @method     ChildPurchaseDetailQuery groupByStockId() Group by the stock_id column
 * @method     ChildPurchaseDetailQuery groupByAmount() Group by the amount column
 * @method     ChildPurchaseDetailQuery groupByTotalPrice() Group by the total_price column
 * @method     ChildPurchaseDetailQuery groupByNotificationId() Group by the notification_id column
 * @method     ChildPurchaseDetailQuery groupByStatus() Group by the status column
 *
 * @method     ChildPurchaseDetailQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPurchaseDetailQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPurchaseDetailQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPurchaseDetailQuery leftJoinPurchase($relationAlias = null) Adds a LEFT JOIN clause to the query using the Purchase relation
 * @method     ChildPurchaseDetailQuery rightJoinPurchase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Purchase relation
 * @method     ChildPurchaseDetailQuery innerJoinPurchase($relationAlias = null) Adds a INNER JOIN clause to the query using the Purchase relation
 *
 * @method     ChildPurchaseDetailQuery leftJoinStock($relationAlias = null) Adds a LEFT JOIN clause to the query using the Stock relation
 * @method     ChildPurchaseDetailQuery rightJoinStock($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Stock relation
 * @method     ChildPurchaseDetailQuery innerJoinStock($relationAlias = null) Adds a INNER JOIN clause to the query using the Stock relation
 *
 * @method     ChildPurchaseDetailQuery leftJoinNotification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notification relation
 * @method     ChildPurchaseDetailQuery rightJoinNotification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notification relation
 * @method     ChildPurchaseDetailQuery innerJoinNotification($relationAlias = null) Adds a INNER JOIN clause to the query using the Notification relation
 *
 * @method     \ORM\PurchaseQuery|\ORM\StockQuery|\ORM\NotificationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPurchaseDetail findOne(ConnectionInterface $con = null) Return the first ChildPurchaseDetail matching the query
 * @method     ChildPurchaseDetail findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPurchaseDetail matching the query, or a new ChildPurchaseDetail object populated from the query conditions when no match is found
 *
 * @method     ChildPurchaseDetail findOneById(string $id) Return the first ChildPurchaseDetail filtered by the id column
 * @method     ChildPurchaseDetail findOneByPurchaseId(string $purchase_id) Return the first ChildPurchaseDetail filtered by the purchase_id column
 * @method     ChildPurchaseDetail findOneByStockId(string $stock_id) Return the first ChildPurchaseDetail filtered by the stock_id column
 * @method     ChildPurchaseDetail findOneByAmount(string $amount) Return the first ChildPurchaseDetail filtered by the amount column
 * @method     ChildPurchaseDetail findOneByTotalPrice(int $total_price) Return the first ChildPurchaseDetail filtered by the total_price column
 * @method     ChildPurchaseDetail findOneByNotificationId(string $notification_id) Return the first ChildPurchaseDetail filtered by the notification_id column
 * @method     ChildPurchaseDetail findOneByStatus(string $status) Return the first ChildPurchaseDetail filtered by the status column
 *
 * @method     ChildPurchaseDetail[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPurchaseDetail objects based on current ModelCriteria
 * @method     ChildPurchaseDetail[]|ObjectCollection findById(string $id) Return ChildPurchaseDetail objects filtered by the id column
 * @method     ChildPurchaseDetail[]|ObjectCollection findByPurchaseId(string $purchase_id) Return ChildPurchaseDetail objects filtered by the purchase_id column
 * @method     ChildPurchaseDetail[]|ObjectCollection findByStockId(string $stock_id) Return ChildPurchaseDetail objects filtered by the stock_id column
 * @method     ChildPurchaseDetail[]|ObjectCollection findByAmount(string $amount) Return ChildPurchaseDetail objects filtered by the amount column
 * @method     ChildPurchaseDetail[]|ObjectCollection findByTotalPrice(int $total_price) Return ChildPurchaseDetail objects filtered by the total_price column
 * @method     ChildPurchaseDetail[]|ObjectCollection findByNotificationId(string $notification_id) Return ChildPurchaseDetail objects filtered by the notification_id column
 * @method     ChildPurchaseDetail[]|ObjectCollection findByStatus(string $status) Return ChildPurchaseDetail objects filtered by the status column
 * @method     ChildPurchaseDetail[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PurchaseDetailQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ORM\Base\PurchaseDetailQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pos', $modelName = '\\ORM\\PurchaseDetail', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPurchaseDetailQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPurchaseDetailQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPurchaseDetailQuery) {
            return $criteria;
        }
        $query = new ChildPurchaseDetailQuery();
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
     * @return ChildPurchaseDetail|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PurchaseDetailTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PurchaseDetailTableMap::DATABASE_NAME);
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
     * @return ChildPurchaseDetail A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, PURCHASE_ID, STOCK_ID, AMOUNT, TOTAL_PRICE, NOTIFICATION_ID, STATUS FROM purchase_detail WHERE ID = :p0';
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
            /** @var ChildPurchaseDetail $obj */
            $obj = new ChildPurchaseDetail();
            $obj->hydrate($row);
            PurchaseDetailTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPurchaseDetail|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the purchase_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPurchaseId(1234); // WHERE purchase_id = 1234
     * $query->filterByPurchaseId(array(12, 34)); // WHERE purchase_id IN (12, 34)
     * $query->filterByPurchaseId(array('min' => 12)); // WHERE purchase_id > 12
     * </code>
     *
     * @see       filterByPurchase()
     *
     * @param     mixed $purchaseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByPurchaseId($purchaseId = null, $comparison = null)
    {
        if (is_array($purchaseId)) {
            $useMinMax = false;
            if (isset($purchaseId['min'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_PURCHASE_ID, $purchaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchaseId['max'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_PURCHASE_ID, $purchaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_PURCHASE_ID, $purchaseId, $comparison);
    }

    /**
     * Filter the query on the stock_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStockId(1234); // WHERE stock_id = 1234
     * $query->filterByStockId(array(12, 34)); // WHERE stock_id IN (12, 34)
     * $query->filterByStockId(array('min' => 12)); // WHERE stock_id > 12
     * </code>
     *
     * @see       filterByStock()
     *
     * @param     mixed $stockId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByStockId($stockId = null, $comparison = null)
    {
        if (is_array($stockId)) {
            $useMinMax = false;
            if (isset($stockId['min'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_STOCK_ID, $stockId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stockId['max'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_STOCK_ID, $stockId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_STOCK_ID, $stockId, $comparison);
    }

    /**
     * Filter the query on the amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount(1234); // WHERE amount = 1234
     * $query->filterByAmount(array(12, 34)); // WHERE amount IN (12, 34)
     * $query->filterByAmount(array('min' => 12)); // WHERE amount > 12
     * </code>
     *
     * @param     mixed $amount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_AMOUNT, $amount, $comparison);
    }

    /**
     * Filter the query on the total_price column
     *
     * Example usage:
     * <code>
     * $query->filterByTotalPrice(1234); // WHERE total_price = 1234
     * $query->filterByTotalPrice(array(12, 34)); // WHERE total_price IN (12, 34)
     * $query->filterByTotalPrice(array('min' => 12)); // WHERE total_price > 12
     * </code>
     *
     * @param     mixed $totalPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByTotalPrice($totalPrice = null, $comparison = null)
    {
        if (is_array($totalPrice)) {
            $useMinMax = false;
            if (isset($totalPrice['min'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_TOTAL_PRICE, $totalPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totalPrice['max'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_TOTAL_PRICE, $totalPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_TOTAL_PRICE, $totalPrice, $comparison);
    }

    /**
     * Filter the query on the notification_id column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationId(1234); // WHERE notification_id = 1234
     * $query->filterByNotificationId(array(12, 34)); // WHERE notification_id IN (12, 34)
     * $query->filterByNotificationId(array('min' => 12)); // WHERE notification_id > 12
     * </code>
     *
     * @see       filterByNotification()
     *
     * @param     mixed $notificationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByNotificationId($notificationId = null, $comparison = null)
    {
        if (is_array($notificationId)) {
            $useMinMax = false;
            if (isset($notificationId['min'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_NOTIFICATION_ID, $notificationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($notificationId['max'])) {
                $this->addUsingAlias(PurchaseDetailTableMap::COL_NOTIFICATION_ID, $notificationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_NOTIFICATION_ID, $notificationId, $comparison);
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
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PurchaseDetailTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \ORM\Purchase object
     *
     * @param \ORM\Purchase|ObjectCollection $purchase The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByPurchase($purchase, $comparison = null)
    {
        if ($purchase instanceof \ORM\Purchase) {
            return $this
                ->addUsingAlias(PurchaseDetailTableMap::COL_PURCHASE_ID, $purchase->getId(), $comparison);
        } elseif ($purchase instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PurchaseDetailTableMap::COL_PURCHASE_ID, $purchase->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
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
     * Filter the query by a related \ORM\Stock object
     *
     * @param \ORM\Stock|ObjectCollection $stock The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByStock($stock, $comparison = null)
    {
        if ($stock instanceof \ORM\Stock) {
            return $this
                ->addUsingAlias(PurchaseDetailTableMap::COL_STOCK_ID, $stock->getId(), $comparison);
        } elseif ($stock instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PurchaseDetailTableMap::COL_STOCK_ID, $stock->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStock() only accepts arguments of type \ORM\Stock or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Stock relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function joinStock($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Stock');

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
            $this->addJoinObject($join, 'Stock');
        }

        return $this;
    }

    /**
     * Use the Stock relation Stock object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\StockQuery A secondary query class using the current class as primary query
     */
    public function useStockQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStock($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Stock', '\ORM\StockQuery');
    }

    /**
     * Filter the query by a related \ORM\Notification object
     *
     * @param \ORM\Notification|ObjectCollection $notification The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function filterByNotification($notification, $comparison = null)
    {
        if ($notification instanceof \ORM\Notification) {
            return $this
                ->addUsingAlias(PurchaseDetailTableMap::COL_NOTIFICATION_ID, $notification->getId(), $comparison);
        } elseif ($notification instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PurchaseDetailTableMap::COL_NOTIFICATION_ID, $notification->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByNotification() only accepts arguments of type \ORM\Notification or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Notification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function joinNotification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Notification');

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
            $this->addJoinObject($join, 'Notification');
        }

        return $this;
    }

    /**
     * Use the Notification relation Notification object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\NotificationQuery A secondary query class using the current class as primary query
     */
    public function useNotificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinNotification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Notification', '\ORM\NotificationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPurchaseDetail $purchaseDetail Object to remove from the list of results
     *
     * @return $this|ChildPurchaseDetailQuery The current query, for fluid interface
     */
    public function prune($purchaseDetail = null)
    {
        if ($purchaseDetail) {
            $this->addUsingAlias(PurchaseDetailTableMap::COL_ID, $purchaseDetail->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the purchase_detail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseDetailTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PurchaseDetailTableMap::clearInstancePool();
            PurchaseDetailTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseDetailTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PurchaseDetailTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PurchaseDetailTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PurchaseDetailTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PurchaseDetailQuery
