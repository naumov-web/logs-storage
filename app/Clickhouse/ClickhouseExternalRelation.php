<?php

namespace App\Clickhouse;

/**
 * Class ClickhouseExternalRelation
 * @package App\Clickhouse
 */
class ClickhouseExternalRelation
{

    /**
     * Has one relation type
     * @var string
     */
    const HAS_ONE = 'has_one';

    /**
     * Has many relation type
     * @var string
     */
    const HAS_MANY = 'has_many';

    /**
     * Name of related class
     * @var string
     */
    protected $class;

    /**
     * Name of field
     * @var string
     */
    protected $field_name;

    /**
     * Type of relation
     * @var string
     */
    protected $type;

    /**
     * ClickhouseExternalRelation constructor.
     * @param string $type
     * @param string $class
     * @param string $field_name
     */
    public function __construct(string $type, string $class, string $field_name)
    {
        $this->class = $class;
        $this->field_name = $field_name;
        $this->type = $type;
    }

    /**
     * Get field name
     *
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->field_name;
    }

    /**
     * Get class name
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * Get relation type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
