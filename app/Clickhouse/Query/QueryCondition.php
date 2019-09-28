<?php

namespace App\Clickhouse\Query;

/**
 * Class QueryCondition
 * @package App\Clickhouse
 */
class QueryCondition
{

    /**
     * Field name
     * @var string
     */
    protected $field_name;

    /**
     * Operation
     * @var string
     */
    protected $operation;

    /**
     * Value for condition
     * @var mixed
     */
    protected $value;

    /**
     * QueryCondition constructor.
     * @param string $field_name
     * @param string $operation
     * @param $value
     */
    public function __construct(string $field_name, string $operation, $value)
    {
        $this->field_name = $field_name;
        $this->operation = $operation;
        $this->value = $value;
    }

    /**
     * Get part of sql query
     *
     * @return string
     */
    public function toSql() : string
    {
        $template = '({field_name} {operation} {value})';

        $value = $this->transformValue($this->value);

        return str_replace(
            [
                '{field_name}',
                '{operation}',
                '{value}',
            ],
            [
                $this->field_name,
                $this->operation,
                $value,
            ],
            $template
        );
    }

    /**
     * Transform value for SQL query
     *
     * @param $value
     * @return mixed
     */
    protected function transformValue($value)
    {
        if (is_numeric($value)) {
            return $value;
        }
        if (is_bool($value)) {
            return $value;
        }

        return '\'' . $value . '\'';
    }

}
