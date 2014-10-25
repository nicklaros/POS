<?php

namespace ORM\Base;

use \Exception;
use \PDO;
use ORM\Stock as ChildStock;
use ORM\StockQuery as ChildStockQuery;
use ORM\Map\StockTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'stock' table.
 *
 *
 *
 * @method     ChildStockQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStockQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildStockQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildStockQuery orderByUnitId($order = Criteria::ASC) Order by the unit_id column
 * @method     ChildStockQuery orderByBuy($order = Criteria::ASC) Order by the buy column
 * @method     ChildStockQuery orderBySellPublic($order = Criteria::ASC) Order by the sell_public column
 * @method     ChildStockQuery orderBySellDistributor($order = Criteria::ASC) Order by the sell_distributor column
 * @method     ChildStockQuery orderBySellMisc($order = Criteria::ASC) Order by the sell_misc column
 * @method     ChildStockQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 * @method     ChildStockQuery orderByUnlimited($order = Criteria::ASC) Order by the unlimited column
 * @method     ChildStockQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildStockQuery groupById() Group by the id column
 * @method     ChildStockQuery groupByProductId() Group by the product_id column
 * @method     ChildStockQuery groupByAmount() Group by the amount column
 * @method     ChildStockQuery groupByUnitId() Group by the unit_id column
 * @method     ChildStockQuery groupByBuy() Group by the buy column
 * @method     ChildStockQuery groupBySellPublic() Group by the sell_public column
 * @method     ChildStockQuery groupBySellDistributor() Group by the sell_distributor column
 * @method     ChildStockQuery groupBySellMisc() Group by the sell_misc column
 * @method     ChildStockQuery groupByDiscount() Group by the discount column
 * @method     ChildStockQuery groupByUnlimited() Group by the unlimited column
 * @method     ChildStockQuery groupByStatus() Group by the status column
 *
 * @method     ChildStockQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildStockQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildStockQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildStockQuery leftJoinUnit($relationAlias = null) Adds a LEFT JOIN clause to the query using the Unit relation
 * @method     ChildStockQuery rightJoinUnit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Unit relation
 * @method     ChildStockQuery innerJoinUnit($relationAlias = null) Adds a INNER JOIN clause to the query using the Unit relation
 *
 * @method     ChildStockQuery leftJoinPurchase($relationAlias = null) Adds a LEFT JOIN clause to the query using the Purchase relation
 * @method     ChildStockQuery rightJoinPurchase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Purchase relation
 * @method     ChildStockQuery innerJoinPurchase($relationAlias = null) Adds a INNER JOIN clause to the query using the Purchase relation
 *
 * @method     ChildStockQuery leftJoinSales($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sales relation
 * @method     ChildStockQuery rightJoinSales($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sales relation
 * @method     ChildStockQuery innerJoinSales($relationAlias = null) Adds a INNER JOIN clause to the query using the Sales relation
 *
 * @method     \ORM\ProductQuery|\ORM\UnitQuery|\ORM\PurchaseDetailQuery|\ORM\SalesDetailQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStock findOne(ConnectionInterface $con = null) Return the first ChildStock matching the query
 * @method     ChildStock findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStock matching the query, or a new ChildStock object populated from the query conditions when no match is found
 *
 * @method     ChildStock findOneById(string $id) Return the first ChildStock filtered by the id column
 * @method     ChildStock findOneByProductId(string $product_id) Return the first ChildStock filtered by the product_id column
 * @method     ChildStock findOneByAmount(string $amount) Return the first ChildStock filtered by the amount column
 * @method     ChildStock findOneByUnitId(string $unit_id) Return the first ChildStock filtered by the unit_id column
 * @method     ChildStock findOneByBuy(int $buy) Return the first ChildStock filtered by the buy column
 * @method     ChildStock findOneBySellPublic(int $sell_public) Return the first ChildStock filtered by the sell_public column
 * @method     ChildStock findOneBySellDistributor(int $sell_distributor) Return the first ChildStock filtered by the sell_distributor column
 * @method     ChildStock findOneBySellMisc(int $sell_misc) Return the first ChildStock filtered by the sell_misc column
 * @method     ChildStock findOneByDiscount(string $discount) Return the first ChildStock filtered by the discount column
 * @method     ChildStock findOneByUnlimited(boolean $unlimited) Return the first ChildStock filtered by the unlimited column
 * @method     ChildStock findOneByStatus(string $status) Return the first ChildStock filtered by the status column
 *
 * @method     ChildStock[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStock objects based on current ModelCriteria
 * @method     ChildStock[]|ObjectCollection findById(string $id) Return ChildStock objects filtered by the id column
 * @method     ChildStock[]|ObjectCollection findByProductId(string $product_id) Return ChildStock objects filtered by the product_id column
 * @method     ChildStock[]|ObjectCollection findByAmount(string $amount) Return ChildStock objects filtered by the amount column
 * @method     ChildStock[]|ObjectCollection findByUnitId(string $unit_id) Return ChildStock objects filtered by the unit_id column
 * @method     ChildStock[]|ObjectCollection findByBuy(int $buy) Return ChildStock objects filtered by the buy column
 * @method     ChildStock[]|ObjectCollection findBySellPublic(int $sell_public) Return ChildStock objects filtered by the sell_public column
 * @method     ChildStock[]|ObjectCollection findBySellDistributor(int $sell_distributor) Return ChildStock objects filtered by the sell_distributor column
 * @method     ChildStock[]|ObjectCollection findBySellMisc(int $sell_misc) Return ChildStock objects filtered by the sell_misc column
 * @method     ChildStock[]|ObjectCollection findByDiscount(string $discount) Return ChildStock objects filtered by the discount column
 * @method     ChildStock[]|ObjectCollection findByUnlimited(boolean $unlimited) Return ChildStock objects filtered by the unlimited column
 * @method     ChildStock[]|ObjectCollection findByStatus(string $status) Return ChildStock objects filtered by the status column
 * @method     ChildStock[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StockQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ORM\Base\StockQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pos', $modelName = '\\ORM\\Stock', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStockQuery) {
            return $criteria;
        }
        $query = new ChildStockQuery();
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
     * @return ChildStock|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StockTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockTableMap::DATABASE_NAME);
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
     * @return ChildStock A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, PRODUCT_ID, AMOUNT, UNIT_ID, BUY, SELL_PUBLIC, SELL_DISTRIBUTOR, SELL_MISC, DISCOUNT, UNLIMITED, STATUS FROM stock WHERE ID = :p0';
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
            /** @var ChildStock $obj */
            $obj = new ChildStock();
            $obj->hydrate($row);
            StockTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStock|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StockTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StockTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StockTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StockTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(StockTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(StockTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_PRODUCT_ID, $productId, $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(StockTableMap::COL_AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(StockTableMap::COL_AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_AMOUNT, $amount, $comparison);
    }

    /**
     * Filter the query on the unit_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUnitId(1234); // WHERE unit_id = 1234
     * $query->filterByUnitId(array(12, 34)); // WHERE unit_id IN (12, 34)
     * $query->filterByUnitId(array('min' => 12)); // WHERE unit_id > 12
     * </code>
     *
     * @see       filterByUnit()
     *
     * @param     mixed $unitId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByUnitId($unitId = null, $comparison = null)
    {
        if (is_array($unitId)) {
            $useMinMax = false;
            if (isset($unitId['min'])) {
                $this->addUsingAlias(StockTableMap::COL_UNIT_ID, $unitId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unitId['max'])) {
                $this->addUsingAlias(StockTableMap::COL_UNIT_ID, $unitId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_UNIT_ID, $unitId, $comparison);
    }

    /**
     * Filter the query on the buy column
     *
     * Example usage:
     * <code>
     * $query->filterByBuy(1234); // WHERE buy = 1234
     * $query->filterByBuy(array(12, 34)); // WHERE buy IN (12, 34)
     * $query->filterByBuy(array('min' => 12)); // WHERE buy > 12
     * </code>
     *
     * @param     mixed $buy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByBuy($buy = null, $comparison = null)
    {
        if (is_array($buy)) {
            $useMinMax = false;
            if (isset($buy['min'])) {
                $this->addUsingAlias(StockTableMap::COL_BUY, $buy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buy['max'])) {
                $this->addUsingAlias(StockTableMap::COL_BUY, $buy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_BUY, $buy, $comparison);
    }

    /**
     * Filter the query on the sell_public column
     *
     * Example usage:
     * <code>
     * $query->filterBySellPublic(1234); // WHERE sell_public = 1234
     * $query->filterBySellPublic(array(12, 34)); // WHERE sell_public IN (12, 34)
     * $query->filterBySellPublic(array('min' => 12)); // WHERE sell_public > 12
     * </code>
     *
     * @param     mixed $sellPublic The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterBySellPublic($sellPublic = null, $comparison = null)
    {
        if (is_array($sellPublic)) {
            $useMinMax = false;
            if (isset($sellPublic['min'])) {
                $this->addUsingAlias(StockTableMap::COL_SELL_PUBLIC, $sellPublic['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellPublic['max'])) {
                $this->addUsingAlias(StockTableMap::COL_SELL_PUBLIC, $sellPublic['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_SELL_PUBLIC, $sellPublic, $comparison);
    }

    /**
     * Filter the query on the sell_distributor column
     *
     * Example usage:
     * <code>
     * $query->filterBySellDistributor(1234); // WHERE sell_distributor = 1234
     * $query->filterBySellDistributor(array(12, 34)); // WHERE sell_distributor IN (12, 34)
     * $query->filterBySellDistributor(array('min' => 12)); // WHERE sell_distributor > 12
     * </code>
     *
     * @param     mixed $sellDistributor The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterBySellDistributor($sellDistributor = null, $comparison = null)
    {
        if (is_array($sellDistributor)) {
            $useMinMax = false;
            if (isset($sellDistributor['min'])) {
                $this->addUsingAlias(StockTableMap::COL_SELL_DISTRIBUTOR, $sellDistributor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellDistributor['max'])) {
                $this->addUsingAlias(StockTableMap::COL_SELL_DISTRIBUTOR, $sellDistributor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_SELL_DISTRIBUTOR, $sellDistributor, $comparison);
    }

    /**
     * Filter the query on the sell_misc column
     *
     * Example usage:
     * <code>
     * $query->filterBySellMisc(1234); // WHERE sell_misc = 1234
     * $query->filterBySellMisc(array(12, 34)); // WHERE sell_misc IN (12, 34)
     * $query->filterBySellMisc(array('min' => 12)); // WHERE sell_misc > 12
     * </code>
     *
     * @param     mixed $sellMisc The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterBySellMisc($sellMisc = null, $comparison = null)
    {
        if (is_array($sellMisc)) {
            $useMinMax = false;
            if (isset($sellMisc['min'])) {
                $this->addUsingAlias(StockTableMap::COL_SELL_MISC, $sellMisc['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellMisc['max'])) {
                $this->addUsingAlias(StockTableMap::COL_SELL_MISC, $sellMisc['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_SELL_MISC, $sellMisc, $comparison);
    }

    /**
     * Filter the query on the discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount(1234); // WHERE discount = 1234
     * $query->filterByDiscount(array(12, 34)); // WHERE discount IN (12, 34)
     * $query->filterByDiscount(array('min' => 12)); // WHERE discount > 12
     * </code>
     *
     * @param     mixed $discount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (is_array($discount)) {
            $useMinMax = false;
            if (isset($discount['min'])) {
                $this->addUsingAlias(StockTableMap::COL_DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discount['max'])) {
                $this->addUsingAlias(StockTableMap::COL_DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_DISCOUNT, $discount, $comparison);
    }

    /**
     * Filter the query on the unlimited column
     *
     * Example usage:
     * <code>
     * $query->filterByUnlimited(true); // WHERE unlimited = true
     * $query->filterByUnlimited('yes'); // WHERE unlimited = true
     * </code>
     *
     * @param     boolean|string $unlimited The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByUnlimited($unlimited = null, $comparison = null)
    {
        if (is_string($unlimited)) {
            $unlimited = in_array(strtolower($unlimited), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StockTableMap::COL_UNLIMITED, $unlimited, $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StockTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \ORM\Product object
     *
     * @param \ORM\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \ORM\Product) {
            return $this
                ->addUsingAlias(StockTableMap::COL_PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockTableMap::COL_PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \ORM\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

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
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\ORM\ProductQuery');
    }

    /**
     * Filter the query by a related \ORM\Unit object
     *
     * @param \ORM\Unit|ObjectCollection $unit The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockQuery The current query, for fluid interface
     */
    public function filterByUnit($unit, $comparison = null)
    {
        if ($unit instanceof \ORM\Unit) {
            return $this
                ->addUsingAlias(StockTableMap::COL_UNIT_ID, $unit->getId(), $comparison);
        } elseif ($unit instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockTableMap::COL_UNIT_ID, $unit->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUnit() only accepts arguments of type \ORM\Unit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Unit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function joinUnit($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Unit');

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
            $this->addJoinObject($join, 'Unit');
        }

        return $this;
    }

    /**
     * Use the Unit relation Unit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\UnitQuery A secondary query class using the current class as primary query
     */
    public function useUnitQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUnit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Unit', '\ORM\UnitQuery');
    }

    /**
     * Filter the query by a related \ORM\PurchaseDetail object
     *
     * @param \ORM\PurchaseDetail|ObjectCollection $purchaseDetail  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockQuery The current query, for fluid interface
     */
    public function filterByPurchase($purchaseDetail, $comparison = null)
    {
        if ($purchaseDetail instanceof \ORM\PurchaseDetail) {
            return $this
                ->addUsingAlias(StockTableMap::COL_ID, $purchaseDetail->getStockId(), $comparison);
        } elseif ($purchaseDetail instanceof ObjectCollection) {
            return $this
                ->usePurchaseQuery()
                ->filterByPrimaryKeys($purchaseDetail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPurchase() only accepts arguments of type \ORM\PurchaseDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Purchase relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
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
     * Use the Purchase relation PurchaseDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\PurchaseDetailQuery A secondary query class using the current class as primary query
     */
    public function usePurchaseQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPurchase($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Purchase', '\ORM\PurchaseDetailQuery');
    }

    /**
     * Filter the query by a related \ORM\SalesDetail object
     *
     * @param \ORM\SalesDetail|ObjectCollection $salesDetail  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockQuery The current query, for fluid interface
     */
    public function filterBySales($salesDetail, $comparison = null)
    {
        if ($salesDetail instanceof \ORM\SalesDetail) {
            return $this
                ->addUsingAlias(StockTableMap::COL_ID, $salesDetail->getStockId(), $comparison);
        } elseif ($salesDetail instanceof ObjectCollection) {
            return $this
                ->useSalesQuery()
                ->filterByPrimaryKeys($salesDetail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySales() only accepts arguments of type \ORM\SalesDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sales relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
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
     * Use the Sales relation SalesDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ORM\SalesDetailQuery A secondary query class using the current class as primary query
     */
    public function useSalesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSales($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sales', '\ORM\SalesDetailQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStock $stock Object to remove from the list of results
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function prune($stock = null)
    {
        if ($stock) {
            $this->addUsingAlias(StockTableMap::COL_ID, $stock->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stock table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StockTableMap::clearInstancePool();
            StockTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StockTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // StockQuery
