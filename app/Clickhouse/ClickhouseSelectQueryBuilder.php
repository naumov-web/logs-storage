<?php


namespace App\Clickhouse;

use App\Models\ClickhouseModel;
use Illuminate\Support\Collection;

/**
 * Class ClickhouseSelectQueryBuilder
 * @package App\Clickhouse
 */
class ClickhouseSelectQueryBuilder
{

    /**
     * Fields block variable name
     * @var string
     */
    const FIELDS_VARIABLE_NAME = '{%fields_list%}';

    /**
     * Fields for selecting of rows count
     * @var string
     */
    const COUNT_FIELDS = 'COUNT()';

    /**
     * Clickhouse adapter instance
     * @var ClickhouseAdapter
     */
    protected $adapter;

    /**
     * Clickhouse model instance
     * @var ClickhouseModel
     */
    protected $model;

    /**
     * Where conditions
     * @var array
     */
    protected $where_conditions = [];

    /**
     * Limit
     * @var int
     */
    protected $limit;

    /**
     * Offset
     * @var int
     */
    protected $offset;

    /**
     * Selected fields
     * @var string
     */
    protected $select = '*';

    /**
     * Set adapter for executing of queries
     * @param ClickhouseAdapter $adapter
     * @return ClickhouseSelectQueryBuilder
     */
    public function setAdapter(ClickhouseAdapter $adapter) : ClickhouseSelectQueryBuilder
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Set clickhouse model
     * @param ClickhouseModel $model
     * @return ClickhouseSelectQueryBuilder
     */
    public function setModel(ClickhouseModel $model) : ClickhouseSelectQueryBuilder
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Add "WHERE" condition
     *
     * @param string $field_name
     * @param string $value
     * @return ClickhouseSelectQueryBuilder
     */
    public function where(string $field_name, string $value) : ClickhouseSelectQueryBuilder
    {

        return $this;
    }

    /**
     * Set limit
     *
     * @param int $limit
     * @return ClickhouseSelectQueryBuilder
     */
    public function limit(int $limit) : ClickhouseSelectQueryBuilder
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Set offset
     *
     * @param int $offset
     * @return ClickhouseSelectQueryBuilder
     */
    public function offset(int $offset) : ClickhouseSelectQueryBuilder
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Set select fields
     *
     * @param string $select
     * @return ClickhouseSelectQueryBuilder
     */
    public function select(string $select) : ClickhouseSelectQueryBuilder
    {
        $this->select = $select;

        return $this;
    }

    /**
     * Execute select query
     * @return Collection
     */
    public function get() : Collection
    {
        $sql = $this->buildRaw();

        $rows = $this->adapter->executeSelect($sql);

        $result = new Collection();
        $model_class = get_class($this->model);

        foreach ($rows as $row) {
            /**
             * @var ClickhouseModel $model
             */
            $model = new $model_class();
            $model->fill($row);

            $result->add($model);
        }

        return $result;
    }

    /**
     * Execute select query
     * @return int
     */
    public function count() : int
    {
        $sql_template = $this->buildRawTemplate();
        $sql = str_replace(self::FIELDS_VARIABLE_NAME, self::COUNT_FIELDS, $sql_template);

        $rows = $this->adapter->executeSelect($sql);

        return isset($rows[0][self::COUNT_FIELDS]) ? $rows[0][self::COUNT_FIELDS] : 0;
    }

    /**
     * Create raw without "field" section
     * @return string
     */
    protected function buildRaw() : string
    {
        $sql_template = $this->buildRawTemplate();

        return str_replace(self::FIELDS_VARIABLE_NAME, $this->select, $sql_template);
    }

    /**
     * Build raw sql template
     * @return string
     */
    protected function buildRawTemplate() : string
    {
        $sql = 'SELECT ' . self::FIELDS_VARIABLE_NAME . ' FROM ' . $this->model->getTableName();

        if ($this->limit) {
            $sql .= (' LIMIT ' . $this->limit);
        }
        if ($this->offset) {
            $sql .= (' OFFSET ' . $this->offset);
        }

        return $sql;
    }

}
