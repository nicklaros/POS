<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\Notification as ChildNotification;
use ORM\NotificationQuery as ChildNotificationQuery;
use ORM\Map\NotificationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'notification' table.
 *
 *
 *
 * @method     ChildNotificationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildNotificationQuery orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildNotificationQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildNotificationQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     ChildNotificationQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildNotificationQuery groupById() Group by the id column
 * @method     ChildNotificationQuery groupByTime() Group by the time column
 * @method     ChildNotificationQuery groupByType() Group by the type column
 * @method     ChildNotificationQuery groupByData() Group by the data column
 * @method     ChildNotificationQuery groupByStatus() Group by the status column
 *
 * @method     ChildNotificationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNotificationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNotificationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNotificationQuery leftJoinOnUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the OnUser relation
 * @method     ChildNotificationQuery rightJoinOnUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OnUser relation
 * @method     ChildNotificationQuery innerJoinOnUser($relationAlias = null) Adds a INNER JOIN clause to the query using the OnUser relation
 *
 * @method     ChildNotificationQuery leftJoinPurchaseDetail($relationAlias = null) Adds a LEFT JOIN clause to the query using the PurchaseDetail relation
 * @method     ChildNotificationQuery rightJoinPurchaseDetail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PurchaseDetail relation
 * @method     ChildNotificationQuery innerJoinPurchaseDetail($relationAlias = null) Adds a INNER JOIN clause to the query using the PurchaseDetail relation
 *
 * @method     \ORM\NotificationOnUserQuery|\ORM\PurchaseDetailQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNotification findOne(ConnectionInterface $con = null) Return the first ChildNotification matching the query
 * @method     ChildNotification findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNotification matching the query, or a new ChildNotification object populated from the query conditions when no match is found
 *
 * @method     ChildNotification findOneById(string $id) Return the first ChildNotification filtered by the id column
 * @method     ChildNotification findOneByTime(string $time) Return the first ChildNotification filtered by the time column
 * @method     ChildNotification findOneByType(string $type) Return the first ChildNotification filtered by the type column
 * @method     ChildNotification findOneByData(string $data) Return the first ChildNotification filtered by the data column
 * @method     ChildNotification findOneByStatus(string $status) Return the first ChildNotification filtered by the status column
 *
 * @method     ChildNotification[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNotification objects based on current ModelCriteria
 * @method     ChildNotification[]|ObjectCollection findById(string $id) Return ChildNotification objects filtered by the id column
 * @method     ChildNotification[]|ObjectCollection findByTime(string $time) Return ChildNotification objects filtered by the time column
 * @method     ChildNotification[]|ObjectCollection findByType(string $type) Return ChildNotification objects filtered by the type column
 * @method     ChildNotification[]|ObjectCollection findByData(string $data) Return ChildNotification objects filtered by the data column
 * @method     ChildNotification[]|ObjectCollection findByStatus(string $status) Return ChildNotification objects filtered by the status column
 * @method     ChildNotification[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NotificationQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ORM\Base\NotificationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pos', $modelName = '\\ORM\\Notification', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNotificationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNotificationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNotificationQuery) {
            return $criteria;
        }
        $query = new ChildNotificationQuery();
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
     * @return ChildNotification|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = NotificationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotificationTableMap::DATABASE_NAME);
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
     * @return ChildNotification A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, TIME, TYPE, DATA, STATUS FROM notification WHERE ID = :p0';
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
            /** @var ChildNotification $obj */
            $obj = new ChildNotification();
            $obj->hydrate($row);
            NotificationTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildNotification|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NotificationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NotificationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the time column
     *
     * Example usage:
     * <code>
     * $query->filterByTime('2011-03-14'); // WHERE time = '2011-03-14'
     * $query->filterByTime('now'); // WHERE time = '2011-03-14'
     * $query->filterByTime(array('max' => 'yesterday')); // WHERE time > '2011-03-13'
     * </code>
     *
     * @param     mixed $time The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_TIME, $time, $comparison);
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
     * @return $this|ChildNotificationQuery The current query, for fluid interface
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

        return $this->addUsingAlias(NotificationTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the data column
     *
     * Example usage:
     * <code>
     * $query->filterByData('fooValue');   // WHERE data = 'fooValue'
     * $query->filterByData('%fooValue%'); // WHERE data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $data The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByData($data = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($data)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $data)) {
                $data = str_replace('*', '%', $data);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_DATA, $data, $comparison);
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
     * @return $this|ChildNotificationQuery The current query, for fluid interface
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

        return $this->addUsingAlias(NotificationTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \ORM\NotificationOnUser object
     *
     * @param \ORM\NotificationOnUser|ObjectCollection $notificationOnUser  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByOnUser($notificationOnUser, $comparison = null)
    {
        if ($notificationOnUser instanceof \ORM\NotificationOnUser) {
            return $this
                ->addUsingAlias(NotificationTableMap::COL_ID, $notificationOnUser->getNotificationId(), $comparison);
        } elseif ($notificationOnUser instanceof ObjectCollection) {
            return $this
                ->useOnUserQuery()
                ->filterByPrimaryKeys($notificationOnUser->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOnUser() only accepts arguments of type \ORM\NotificationOnUser or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OnUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function joinOnUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OnUser');

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
            $this->addJoinObject($join, 'OnUser');
        }

        return $this;
    }

    /**
     * Use the OnUser relation NotificationOnUser object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\NotificationOnUserQuery A secondary query class using the current class as primary query
     */
    public function useOnUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOnUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OnUser', '\ORM\NotificationOnUserQuery');
    }

    /**
     * Filter the query by a related \ORM\PurchaseDetail object
     *
     * @param \ORM\PurchaseDetail|ObjectCollection $purchaseDetail  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByPurchaseDetail($purchaseDetail, $comparison = null)
    {
        if ($purchaseDetail instanceof \ORM\PurchaseDetail) {
            return $this
                ->addUsingAlias(NotificationTableMap::COL_ID, $purchaseDetail->getNotificationId(), $comparison);
        } elseif ($purchaseDetail instanceof ObjectCollection) {
            return $this
                ->usePurchaseDetailQuery()
                ->filterByPrimaryKeys($purchaseDetail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPurchaseDetail() only accepts arguments of type \ORM\PurchaseDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PurchaseDetail relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function joinPurchaseDetail($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PurchaseDetail');

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
            $this->addJoinObject($join, 'PurchaseDetail');
        }

        return $this;
    }

    /**
     * Use the PurchaseDetail relation PurchaseDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\PurchaseDetailQuery A secondary query class using the current class as primary query
     */
    public function usePurchaseDetailQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPurchaseDetail($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PurchaseDetail', '\ORM\PurchaseDetailQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNotification $notification Object to remove from the list of results
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function prune($notification = null)
    {
        if ($notification) {
            $this->addUsingAlias(NotificationTableMap::COL_ID, $notification->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the notification table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NotificationTableMap::clearInstancePool();
            NotificationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NotificationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NotificationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NotificationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NotificationQuery
