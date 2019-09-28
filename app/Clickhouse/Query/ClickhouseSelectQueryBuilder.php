<?php


namespace App\Clickhouse\Query;

use App\Clickhouse\Adapter\ClickhouseAdapter;
use App\Clickhouse\Model\ClickhouseExternalRelation;
use App\Clickhouse\Model\ClickhouseModel;
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
     * Default where condition operation
     * @var string
     */
    const DEFAULT_WHERE_OPERATION = '=';

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
     * Relations, which will be added
     * @var array
     */
    protected $with = [];

    /**
     * Related models
     *
     * Structure:
     * [
     *      'relation_name' => [
     *          // Related models
     *      ]
     * ]
     *
     * @var array
     */
    protected $related_models = [];

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
        $this->where_conditions[] = new QueryCondition($field_name, self::DEFAULT_WHERE_OPERATION, $value);

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
     * Set relations, which will be added to general model
     *
     * @param array $relations
     * @return ClickhouseSelectQueryBuilder
     */
    public function with(array $relations) : ClickhouseSelectQueryBuilder
    {
        $this->with = $relations;

        return $this;
    }

    /**
     * Load relations
     *
     * @param Collection $items
     * @return void
     */
    protected function loadRelations(Collection $items) : void
    {
        foreach ($this->with as $relation_name) {
            $this->related_models[$relation_name] = [];

            $this->loadRelation($items, $relation_name);
        }
    }

    /**
     * Load one relation
     *
     * @param Collection $items
     * @param string $relation_name
     * @return void
     */
    protected function loadRelation(Collection $items, string $relation_name) : void
    {
        /**
         * @var $relation ClickhouseExternalRelation
         */
        $relation = $this->model->$relation_name();
        $field_name = $relation->getFieldName();
        $class = $relation->getClass();

        $ids = [];
        foreach ($items as $item) {
            $id = $item->{$field_name};
            if ($id) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            return;
        }

        /**
         * @var $related_items Collection
         */
        $related_items = $class::query()->whereIn('id', $ids)->get();
        $this->related_models[$relation_name] = $related_items->toArray();
    }

    /**
     * Distribute related models
     *
     * @param Collection $items
     * @return Collection
     * @throws \App\Clickhouse\Exception\RelationNotFoundException
     */
    protected function distributeRelatedModels(Collection $items) : Collection
    {
        foreach ($items as $item) {
            /**
             * @var $item ClickhouseModel
             */
            foreach ($this->with as $relation_name) {
                /**
                 * @var $relation ClickhouseExternalRelation
                 */
                $relation = $item->$relation_name();
                $field = $relation->getFieldName();

                $relation_content = $this->getRelationContent(
                    $relation_name,
                    $relation->getType(),
                    $item->{$field}
                );

                $item->setRelationContent($relation_name, $relation_content);
            }
        }

        return $items;
    }

    /**
     * Get relation content
     *
     * @param string $name
     * @param string $type
     * @param int $id
     * @return array|mixed
     */
    protected function getRelationContent(string $name, string $type, int $id)
    {
        $related_items = $this->related_models[$name];
        $result = [];

        foreach ($related_items as $related_item) {
            if ($related_item['id'] == $id) {
                if ($type === ClickhouseExternalRelation::HAS_ONE) {
                    return $related_item;
                } else {
                    $result[] = $related_item;
                }
            }
        }

        return $result;
    }

    /**
     * Execute select query
     * @return Collection
     * @throws \App\Clickhouse\Exception\RelationNotFoundException
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

        $this->loadRelations($result);
        $result = $this->distributeRelatedModels($result);

        return $result;
    }

    /**
     * Execute select query
     * @return int
     */
    public function count() : int
    {
        $sql_template = $this->buildRawTemplate($use_limit = false);
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
     * @param bool $use_limit
     * @return string
     */
    protected function buildRawTemplate(bool $use_limit = true) : string
    {
        $sql = 'SELECT ' . self::FIELDS_VARIABLE_NAME . ' FROM ' . $this->model->getTableName();
        $sql = $this->addWhereConditions($sql);

        if ($use_limit) {
            if ($this->limit) {
                $sql .= (' LIMIT ' . $this->limit);
            }
            if ($this->offset) {
                $sql .= (' OFFSET ' . $this->offset);
            }
        }

        return $sql;
    }

    /**
     * Add "WHERE" conditions string
     *
     * @param string $sql
     * @return string
     */
    protected function addWhereConditions(string $sql) : string
    {
        $result = $sql;

        if (count($this->where_conditions) > 0) {
            $conditions = [];

            foreach ($this->where_conditions as $where_condition) {
                $conditions[] = $where_condition->toSql();
            }

            $result .= (' WHERE ' . implode(' AND ', $conditions));
        }

        return $result;
    }

}
