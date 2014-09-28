<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\Purchase as ChildPurchase;
use ORM\PurchaseQuery as ChildPurchaseQuery;
use ORM\Map\PurchaseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'purchase' table.
 *
 *
 *
 * @method     ChildPurchaseQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPurchaseQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method     ChildPurchaseQuery orderBySecondPartyId($order = Criteria::ASC) Order by the second_party_id column
 * @method     ChildPurchaseQuery orderByTotalPrice($order = Criteria::ASC) Order by the total_price column
 * @method     ChildPurchaseQuery orderByPaid($order = Criteria::ASC) Order by the paid column
 * @method     ChildPurchaseQuery orderByNote($order = Criteria::ASC) Order by the note column
 * @method     ChildPurchaseQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildPurchaseQuery groupById() Group by the id column
 * @method     ChildPurchaseQuery groupByDate() Group by the date column
 * @method     ChildPurchaseQuery groupBySecondPartyId() Group by the second_party_id column
 * @method     ChildPurchaseQuery groupByTotalPrice() Group by the total_price column
 * @method     ChildPurchaseQuery groupByPaid() Group by the paid column
 * @method     ChildPurchaseQuery groupByNote() Group by the note column
 * @method     ChildPurchaseQuery groupByStatus() Group by the status column
 *
 * @method     ChildPurchaseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPurchaseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPurchaseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPurchaseQuery leftJoinSecondParty($relationAlias = null) Adds a LEFT JOIN clause to the query using the SecondParty relation
 * @method     ChildPurchaseQuery rightJoinSecondParty($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SecondParty relation
 * @method     ChildPurchaseQuery innerJoinSecondParty($relationAlias = null) Adds a INNER JOIN clause to the query using the SecondParty relation
 *
 * @method     ChildPurchaseQuery leftJoinDebit($relationAlias = null) Adds a LEFT JOIN clause to the query using the Debit relation
 * @method     ChildPurchaseQuery rightJoinDebit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Debit relation
 * @method     ChildPurchaseQuery innerJoinDebit($relationAlias = null) Adds a INNER JOIN clause to the query using the Debit relation
 *
 * @method     ChildPurchaseQuery leftJoinDetail($relationAlias = null) Adds a LEFT JOIN clause to the query using the Detail relation
 * @method     ChildPurchaseQuery rightJoinDetail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Detail relation
 * @method     ChildPurchaseQuery innerJoinDetail($relationAlias = null) Adds a INNER JOIN clause to the query using the Detail relation
 *
 * @method     ChildPurchaseQuery leftJoinHistory($relationAlias = null) Adds a LEFT JOIN clause to the query using the History relation
 * @method     ChildPurchaseQuery rightJoinHistory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the History relation
 * @method     ChildPurchaseQuery innerJoinHistory($relationAlias = null) Adds a INNER JOIN clause to the query using the History relation
 *
 * @method     \ORM\SecondPartyQuery|\ORM\DebitQuery|\ORM\PurchaseDetailQuery|\ORM\PurchaseHistoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPurchase findOne(ConnectionInterface $con = null) Return the first ChildPurchase matching the query
 * @method     ChildPurchase findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPurchase matching the query, or a new ChildPurchase object populated from the query conditions when no match is found
 *
 * @method     ChildPurchase findOneById(string $id) Return the first ChildPurchase filtered by the id column
 * @method     ChildPurchase findOneByDate(string $date) Return the first ChildPurchase filtered by the date column
 * @method     ChildPurchase findOneBySecondPartyId(string $second_party_id) Return the first ChildPurchase filtered by the second_party_id column
 * @method     ChildPurchase findOneByTotalPrice(int $total_price) Return the first ChildPurchase filtered by the total_price column
 * @method     ChildPurchase findOneByPaid(int $paid) Return the first ChildPurchase filtered by the paid column
 * @method     ChildPurchase findOneByNote(string $note) Return the first ChildPurchase filtered by the note column
 * @method     ChildPurchase findOneByStatus(string $status) Return the first ChildPurchase filtered by the status column
 *
 * @method     ChildPurchase[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPurchase objects based on current ModelCriteria
 * @method     ChildPurchase[]|ObjectCollection findById(string $id) Return ChildPurchase objects filtered by the id column
 * @method     ChildPurchase[]|ObjectCollection findByDate(string $date) Return ChildPurchase objects filtered by the date column
 * @method     ChildPurchase[]|ObjectCollection findBySecondPartyId(string $second_party_id) Return ChildPurchase objects filtered by the second_party_id column
 * @method     ChildPurchase[]|ObjectCollection findByTotalPrice(int $total_price) Return ChildPurchase objects filtered by the total_price column
 * @method     ChildPurchase[]|ObjectCollection findByPaid(int $paid) Return ChildPurchase objects filtered by the paid column
 * @method     ChildPurchase[]|ObjectCollection findByNote(string $note) Return ChildPurchase objects filtered by the note column
 * @method     ChildPurchase[]|ObjectCollection findByStatus(string $status) Return ChildPurchase objects filtered by the status column
 * @method     ChildPurchase[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PurchaseQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ORM\Base\PurchaseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pos', $modelName = '\\ORM\\Purchase', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPurchaseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPurchaseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPurchaseQuery) {
            return $criteria;
        }
        $query = new ChildPurchaseQuery();
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
     * @return ChildPurchase|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PurchaseTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PurchaseTableMap::DATABASE_NAME);
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
     * @return ChildPurchase A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, DATE, SECOND_PARTY_ID, TOTAL_PRICE, PAID, NOTE, STATUS FROM purchase WHERE ID = :p0';
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
            /** @var ChildPurchase $obj */
            $obj = new ChildPurchase();
            $obj->hydrate($row);
            PurchaseTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPurchase|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PurchaseTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PurchaseTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseTableMap::COL_DATE, $date, $comparison);
    }

    /**
     * Filter the query on the second_party_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySecondPartyId(1234); // WHERE second_party_id = 1234
     * $query->filterBySecondPartyId(array(12, 34)); // WHERE second_party_id IN (12, 34)
     * $query->filterBySecondPartyId(array('min' => 12)); // WHERE second_party_id > 12
     * </code>
     *
     * @see       filterBySecondParty()
     *
     * @param     mixed $secondPartyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterBySecondPartyId($secondPartyId = null, $comparison = null)
    {
        if (is_array($secondPartyId)) {
            $useMinMax = false;
            if (isset($secondPartyId['min'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_SECOND_PARTY_ID, $secondPartyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($secondPartyId['max'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_SECOND_PARTY_ID, $secondPartyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseTableMap::COL_SECOND_PARTY_ID, $secondPartyId, $comparison);
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
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByTotalPrice($totalPrice = null, $comparison = null)
    {
        if (is_array($totalPrice)) {
            $useMinMax = false;
            if (isset($totalPrice['min'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_TOTAL_PRICE, $totalPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totalPrice['max'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_TOTAL_PRICE, $totalPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseTableMap::COL_TOTAL_PRICE, $totalPrice, $comparison);
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
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByPaid($paid = null, $comparison = null)
    {
        if (is_array($paid)) {
            $useMinMax = false;
            if (isset($paid['min'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_PAID, $paid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paid['max'])) {
                $this->addUsingAlias(PurchaseTableMap::COL_PAID, $paid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchaseTableMap::COL_PAID, $paid, $comparison);
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByNote('%fooValue%'); // WHERE note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $note The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $note)) {
                $note = str_replace('*', '%', $note);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PurchaseTableMap::COL_NOTE, $note, $comparison);
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
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PurchaseTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \ORM\SecondParty object
     *
     * @param \ORM\SecondParty|ObjectCollection $secondParty The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterBySecondParty($secondParty, $comparison = null)
    {
        if ($secondParty instanceof \ORM\SecondParty) {
            return $this
                ->addUsingAlias(PurchaseTableMap::COL_SECOND_PARTY_ID, $secondParty->getId(), $comparison);
        } elseif ($secondParty instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PurchaseTableMap::COL_SECOND_PARTY_ID, $secondParty->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySecondParty() only accepts arguments of type \ORM\SecondParty or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SecondParty relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function joinSecondParty($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SecondParty');

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
            $this->addJoinObject($join, 'SecondParty');
        }

        return $this;
    }

    /**
     * Use the SecondParty relation SecondParty object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\SecondPartyQuery A secondary query class using the current class as primary query
     */
    public function useSecondPartyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSecondParty($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SecondParty', '\ORM\SecondPartyQuery');
    }

    /**
     * Filter the query by a related \ORM\Debit object
     *
     * @param \ORM\Debit|ObjectCollection $debit  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByDebit($debit, $comparison = null)
    {
        if ($debit instanceof \ORM\Debit) {
            return $this
                ->addUsingAlias(PurchaseTableMap::COL_ID, $debit->getPurchaseId(), $comparison);
        } elseif ($debit instanceof ObjectCollection) {
            return $this
                ->useDebitQuery()
                ->filterByPrimaryKeys($debit->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDebit() only accepts arguments of type \ORM\Debit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Debit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function joinDebit($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Debit');

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
            $this->addJoinObject($join, 'Debit');
        }

        return $this;
    }

    /**
     * Use the Debit relation Debit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\DebitQuery A secondary query class using the current class as primary query
     */
    public function useDebitQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDebit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Debit', '\ORM\DebitQuery');
    }

    /**
     * Filter the query by a related \ORM\PurchaseDetail object
     *
     * @param \ORM\PurchaseDetail|ObjectCollection $purchaseDetail  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByDetail($purchaseDetail, $comparison = null)
    {
        if ($purchaseDetail instanceof \ORM\PurchaseDetail) {
            return $this
                ->addUsingAlias(PurchaseTableMap::COL_ID, $purchaseDetail->getPurchaseId(), $comparison);
        } elseif ($purchaseDetail instanceof ObjectCollection) {
            return $this
                ->useDetailQuery()
                ->filterByPrimaryKeys($purchaseDetail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDetail() only accepts arguments of type \ORM\PurchaseDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Detail relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function joinDetail($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Detail');

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
            $this->addJoinObject($join, 'Detail');
        }

        return $this;
    }

    /**
     * Use the Detail relation PurchaseDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\PurchaseDetailQuery A secondary query class using the current class as primary query
     */
    public function useDetailQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDetail($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Detail', '\ORM\PurchaseDetailQuery');
    }

    /**
     * Filter the query by a related \ORM\PurchaseHistory object
     *
     * @param \ORM\PurchaseHistory|ObjectCollection $purchaseHistory  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchaseQuery The current query, for fluid interface
     */
    public function filterByHistory($purchaseHistory, $comparison = null)
    {
        if ($purchaseHistory instanceof \ORM\PurchaseHistory) {
            return $this
                ->addUsingAlias(PurchaseTableMap::COL_ID, $purchaseHistory->getPurchaseId(), $comparison);
        } elseif ($purchaseHistory instanceof ObjectCollection) {
            return $this
                ->useHistoryQuery()
                ->filterByPrimaryKeys($purchaseHistory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByHistory() only accepts arguments of type \ORM\PurchaseHistory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the History relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function joinHistory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('History');

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
            $this->addJoinObject($join, 'History');
        }

        return $this;
    }

    /**
     * Use the History relation PurchaseHistory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\PurchaseHistoryQuery A secondary query class using the current class as primary query
     */
    public function useHistoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinHistory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'History', '\ORM\PurchaseHistoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPurchase $purchase Object to remove from the list of results
     *
     * @return $this|ChildPurchaseQuery The current query, for fluid interface
     */
    public function prune($purchase = null)
    {
        if ($purchase) {
            $this->addUsingAlias(PurchaseTableMap::COL_ID, $purchase->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the purchase table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PurchaseTableMap::clearInstancePool();
            PurchaseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PurchaseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PurchaseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PurchaseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PurchaseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PurchaseQuery
