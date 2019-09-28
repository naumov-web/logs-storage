<?php

namespace App\Clickhouse\Adapter;

use Tinderbox\Clickhouse\Client;
use Tinderbox\Clickhouse\Cluster;
use Tinderbox\Clickhouse\Exceptions\ClusterException;
use Tinderbox\Clickhouse\Exceptions\ServerProviderException;
use Tinderbox\Clickhouse\Query\Result;
use Tinderbox\Clickhouse\Server;
use Tinderbox\Clickhouse\ServerProvider;

/**
 * Class ClickhouseAdapter
 * @package App\Clickhouse
 */
class ClickhouseAdapter
{

    /**
     * Clickhouse client
     * @var Client
     */
    protected $client;

    /**
     * Default cluster name
     * @var string
     */
    protected $default_cluster;

    /**
     * Default server
     * @var string
     */
    protected $default_server;

    /**
     * ClickhouseAdapter constructor.
     * @throws ClusterException
     * @throws ServerProviderException
     */
    public function __construct()
    {
        $connection_name = config('database.clickhouse_default');
        $config = config('database.connections.' . $connection_name);

        $servers = [];
        foreach ($config['servers'] as $i => $server) {
            $servers[$server['host']] = new Server(
                $server['host'],
                $server['port'],
                $server['database'],
                $server['username'],
                $server['password']
            );
        }

        $cluster = new Cluster($config['cluster_name'], $servers);

        $serverProvider = new ServerProvider();
        $serverProvider->addCluster($cluster);

        $this->client = new Client($serverProvider);
        $this->default_cluster = $config['default_cluster'];
        $this->default_server = $config['default_server'];
    }

    /**
     * Execute raw query
     *
     * @param string $query
     * @return void
     */
    public function executeRaw(string $query) : void
    {
        $this->client
            ->onCluster($this->default_cluster)
            ->using($this->default_server)
            ->writeOne($query);
    }

    /**
     * Execute "SELECT" request
     *
     * @param string $query
     * @return array
     */
    public function executeSelect(string $query) : array
    {
        $result = $this->client
            ->onCluster($this->default_cluster)
            ->using($this->default_server)
            ->readOne($query);

        return $this->toArray($result);
    }

    /**
     * Get rows array from query result
     *
     * @param Result $query_result
     * @return array
     */
    protected function toArray(Result $query_result) : array
    {
        return $query_result->rows;
    }

    /**
     * Insert one row
     *
     * @param string $table
     * @param array $attributes
     * @return void
     */
    public function insert(string $table, array $attributes) : void
    {
        $sql = 'INSERT INTO ' . $table . '(' .
            implode(',', array_keys($attributes)) .
            ') VALUES (';

        $i = 0;
        foreach ($attributes as $attribute) {
            if ($i) {
                $sql .= ',';
            }
            $sql .= $this->rawValue($attribute);

            $i++;
        }

        $sql .= ')';

        $this->executeRaw($sql);
    }

    /**
     * Convert mixed value to string
     *
     * @param $value
     * @return string
     */
    protected function rawValue($value) : string
    {
        if (is_string($value)) {
            return ('\'' . addslashes($value) . '\'');
        }
        else {
            return $value;
        }
    }

}
