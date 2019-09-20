<?php


namespace App\Clickhouse;

use App\Models\ClickhouseModel;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Support\Collection;

/**
 * Class ClickhouseSelectQueryBuilder
 * @package App\Clickhouse
 */
class ClickhouseSelectQueryBuilder extends QueryBuilder
{

    /**
     * Fields block variable name
     * @var string
     */
    const FIELDS_VARIABLE_NAME = '{%fields_list%}';

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
     * Execute select query
     * @return Collection
     */
    public function get() : Collection
    {
        $sql = $this->buildRaw();

        $rows = $this->adapter->executeSelect($sql);

        $result = new Collection();

        foreach ($rows as $row) {
            /**
             * @var ClickhouseModel $model
             */
            $model = new (get_class($this->model));
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
        $sql = $this->buildRaw();
    }

    /**
     * Create raw without "field" section
     * @return string
     */
    protected function buildRaw() : string
    {
        $sql = 'SELECT ' . self::FIELDS_VARIABLE_NAME . ' FROM ' . $this->model->getTableName();

        return $sql;
    }

}
