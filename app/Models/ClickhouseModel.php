<?php

namespace App\Models;

use App\Clickhouse\ClickhouseAdapter;
use Illuminate\Database\Eloquent\Model;

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
     * Get table name
     * @return string
     */
    protected abstract function getTableName() : string;

    /**
     * ClickhouseModel constructor.
     * @param array $attributes
     * @throws \Tinderbox\Clickhouse\Exceptions\ClusterException
     * @throws \Tinderbox\Clickhouse\Exceptions\ServerProviderException
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

}
