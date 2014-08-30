<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\RolePermission as ChildRolePermission;
use ORM\RolePermissionQuery as ChildRolePermissionQuery;
use ORM\Map\RolePermissionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'role_permission' table.
 *
 *
 *
 * @method     ChildRolePermissionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRolePermissionQuery orderByCreateUser($order = Criteria::ASC) Order by the create_user column
 * @method     ChildRolePermissionQuery orderByReadUser($order = Criteria::ASC) Order by the read_user column
 * @method     ChildRolePermissionQuery orderByUpdateUser($order = Criteria::ASC) Order by the update_user column
 * @method     ChildRolePermissionQuery orderByDestroyUser($order = Criteria::ASC) Order by the destroy_user column
 * @method     ChildRolePermissionQuery orderByResetPassUser($order = Criteria::ASC) Order by the reset_pass_user column
 *
 * @method     ChildRolePermissionQuery groupById() Group by the id column
 * @method     ChildRolePermissionQuery groupByCreateUser() Group by the create_user column
 * @method     ChildRolePermissionQuery groupByReadUser() Group by the read_user column
 * @method     ChildRolePermissionQuery groupByUpdateUser() Group by the update_user column
 * @method     ChildRolePermissionQuery groupByDestroyUser() Group by the destroy_user column
 * @method     ChildRolePermissionQuery groupByResetPassUser() Group by the reset_pass_user column
 *
 * @method     ChildRolePermissionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRolePermissionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRolePermissionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRolePermissionQuery leftJoinRole($relationAlias = null) Adds a LEFT JOIN clause to the query using the Role relation
 * @method     ChildRolePermissionQuery rightJoinRole($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Role relation
 * @method     ChildRolePermissionQuery innerJoinRole($relationAlias = null) Adds a INNER JOIN clause to the query using the Role relation
 *
 * @method     \ORM\RoleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRolePermission findOne(ConnectionInterface $con = null) Return the first ChildRolePermission matching the query
 * @method     ChildRolePermission findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRolePermission matching the query, or a new ChildRolePermission object populated from the query conditions when no match is found
 *
 * @method     ChildRolePermission findOneById(string $id) Return the first ChildRolePermission filtered by the id column
 * @method     ChildRolePermission findOneByCreateUser(boolean $create_user) Return the first ChildRolePermission filtered by the create_user column
 * @method     ChildRolePermission findOneByReadUser(boolean $read_user) Return the first ChildRolePermission filtered by the read_user column
 * @method     ChildRolePermission findOneByUpdateUser(boolean $update_user) Return the first ChildRolePermission filtered by the update_user column
 * @method     ChildRolePermission findOneByDestroyUser(boolean $destroy_user) Return the first ChildRolePermission filtered by the destroy_user column
 * @method     ChildRolePermission findOneByResetPassUser(boolean $reset_pass_user) Return the first ChildRolePermission filtered by the reset_pass_user column
 *
 * @method     ChildRolePermission[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRolePermission objects based on current ModelCriteria
 * @method     ChildRolePermission[]|ObjectCollection findById(string $id) Return ChildRolePermission objects filtered by the id column
 * @method     ChildRolePermission[]|ObjectCollection findByCreateUser(boolean $create_user) Return ChildRolePermission objects filtered by the create_user column
 * @method     ChildRolePermission[]|ObjectCollection findByReadUser(boolean $read_user) Return ChildRolePermission objects filtered by the read_user column
 * @method     ChildRolePermission[]|ObjectCollection findByUpdateUser(boolean $update_user) Return ChildRolePermission objects filtered by the update_user column
 * @method     ChildRolePermission[]|ObjectCollection findByDestroyUser(boolean $destroy_user) Return ChildRolePermission objects filtered by the destroy_user column
 * @method     ChildRolePermission[]|ObjectCollection findByResetPassUser(boolean $reset_pass_user) Return ChildRolePermission objects filtered by the reset_pass_user column
 * @method     ChildRolePermission[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RolePermissionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ORM\Base\RolePermissionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pos', $modelName = '\\ORM\\RolePermission', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRolePermissionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRolePermissionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRolePermissionQuery) {
            return $criteria;
        }
        $query = new ChildRolePermissionQuery();
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
     * @return ChildRolePermission|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RolePermissionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RolePermissionTableMap::DATABASE_NAME);
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
     * @return ChildRolePermission A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, CREATE_USER, READ_USER, UPDATE_USER, DESTROY_USER, RESET_PASS_USER FROM role_permission WHERE ID = :p0';
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
            /** @var ChildRolePermission $obj */
            $obj = new ChildRolePermission();
            $obj->hydrate($row);
            RolePermissionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRolePermission|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RolePermissionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RolePermissionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @see       filterByRole()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RolePermissionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RolePermissionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RolePermissionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the create_user column
     *
     * Example usage:
     * <code>
     * $query->filterByCreateUser(true); // WHERE create_user = true
     * $query->filterByCreateUser('yes'); // WHERE create_user = true
     * </code>
     *
     * @param     boolean|string $createUser The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByCreateUser($createUser = null, $comparison = null)
    {
        if (is_string($createUser)) {
            $createUser = in_array(strtolower($createUser), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RolePermissionTableMap::COL_CREATE_USER, $createUser, $comparison);
    }

    /**
     * Filter the query on the read_user column
     *
     * Example usage:
     * <code>
     * $query->filterByReadUser(true); // WHERE read_user = true
     * $query->filterByReadUser('yes'); // WHERE read_user = true
     * </code>
     *
     * @param     boolean|string $readUser The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByReadUser($readUser = null, $comparison = null)
    {
        if (is_string($readUser)) {
            $readUser = in_array(strtolower($readUser), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RolePermissionTableMap::COL_READ_USER, $readUser, $comparison);
    }

    /**
     * Filter the query on the update_user column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateUser(true); // WHERE update_user = true
     * $query->filterByUpdateUser('yes'); // WHERE update_user = true
     * </code>
     *
     * @param     boolean|string $updateUser The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByUpdateUser($updateUser = null, $comparison = null)
    {
        if (is_string($updateUser)) {
            $updateUser = in_array(strtolower($updateUser), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RolePermissionTableMap::COL_UPDATE_USER, $updateUser, $comparison);
    }

    /**
     * Filter the query on the destroy_user column
     *
     * Example usage:
     * <code>
     * $query->filterByDestroyUser(true); // WHERE destroy_user = true
     * $query->filterByDestroyUser('yes'); // WHERE destroy_user = true
     * </code>
     *
     * @param     boolean|string $destroyUser The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByDestroyUser($destroyUser = null, $comparison = null)
    {
        if (is_string($destroyUser)) {
            $destroyUser = in_array(strtolower($destroyUser), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RolePermissionTableMap::COL_DESTROY_USER, $destroyUser, $comparison);
    }

    /**
     * Filter the query on the reset_pass_user column
     *
     * Example usage:
     * <code>
     * $query->filterByResetPassUser(true); // WHERE reset_pass_user = true
     * $query->filterByResetPassUser('yes'); // WHERE reset_pass_user = true
     * </code>
     *
     * @param     boolean|string $resetPassUser The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByResetPassUser($resetPassUser = null, $comparison = null)
    {
        if (is_string($resetPassUser)) {
            $resetPassUser = in_array(strtolower($resetPassUser), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RolePermissionTableMap::COL_RESET_PASS_USER, $resetPassUser, $comparison);
    }

    /**
     * Filter the query by a related \ORM\Role object
     *
     * @param \ORM\Role|ObjectCollection $role The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByRole($role, $comparison = null)
    {
        if ($role instanceof \ORM\Role) {
            return $this
                ->addUsingAlias(RolePermissionTableMap::COL_ID, $role->getId(), $comparison);
        } elseif ($role instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RolePermissionTableMap::COL_ID, $role->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRole() only accepts arguments of type \ORM\Role or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Role relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function joinRole($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Role');

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
            $this->addJoinObject($join, 'Role');
        }

        return $this;
    }

    /**
     * Use the Role relation Role object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\RoleQuery A secondary query class using the current class as primary query
     */
    public function useRoleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRole($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Role', '\ORM\RoleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRolePermission $rolePermission Object to remove from the list of results
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function prune($rolePermission = null)
    {
        if ($rolePermission) {
            $this->addUsingAlias(RolePermissionTableMap::COL_ID, $rolePermission->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the role_permission table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolePermissionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RolePermissionTableMap::clearInstancePool();
            RolePermissionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RolePermissionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RolePermissionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RolePermissionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RolePermissionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RolePermissionQuery
