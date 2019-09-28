<?php

namespace App\Clickhouse\Model;

use App\Clickhouse\Adapter\ClickhouseAdapter;
use App\Clickhouse\Exception\RelationNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Tinderbox\Clickhouse\Exceptions\ClusterException;
use Tinderbox\Clickhouse\Exceptions\ServerProviderException;

/**
 * Class ClickhouseModel
 * @package App\Models
 */
abstract class ClickhouseModel extends Model
{

    /**
     * Guarded fields
     * @var array
     */
    protected $guarded = [];

    /**
     * Clickhouse adapter instance
     * @var ClickhouseAdapter
     */
    protected $adapter;

    /**
     * Relation contents
     * @var array
     */
    protected $relation_contents = [];

    /**
     * Get table name
     * @return string
     */
    public abstract function getTableName() : string;

    /**
     * ClickhouseModel constructor.
     * @param array $attributes
     * @throws ClusterException
     * @throws ServerProviderException
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->adapter = new ClickhouseAdapter();
    }

    /**
     * Save model
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $attributes = $this->getAttributes();

        $this->adapter->insert(
            $this->getTableName(),
            $attributes
        );

        return true;
    }

    /**
     * Get relation names
     *
     * @return array
     */
    protected function getRelationNames() : array
    {
        $refl = new \ReflectionObject($this);
        $names = [];

        foreach ($refl->getMethods() as $method) {
            /**
             * @var $return_type \ReflectionNamedType
             */
            $return_type = $method->getReturnType();
            if (
                $return_type &&
                $return_type->getName() === ClickhouseExternalRelation::class
            ) {
                $names[] = $method->getName();
            }
        }

        return $names;
    }

    /**
     * Set relation content
     *
     * @param string $relation_name
     * @param $content
     * @return void
     * @throws RelationNotFoundException
     */
    public function setRelationContent(string $relation_name, $content) : void
    {
        $relation_names = $this->getRelationNames();

        if (!in_array($relation_name, $relation_names)) {
            throw new RelationNotFoundException('Relation not found!');
        }

        $this->relation_contents[$relation_name] = $content;
    }

    /**
     * Get relation content
     *
     * @param string $relation_name
     * @return mixed|null
     * @throws RelationNotFoundException
     */
    public function getRelationContent(string $relation_name)
    {
        $relation_names = $this->getRelationNames();

        if (!in_array($relation_name, $relation_names)) {
            throw new RelationNotFoundException('Relation not found!');
        }

        return isset($this->relation_contents[$relation_name]) ? $this->relation_contents[$relation_name] : null;
    }

}
