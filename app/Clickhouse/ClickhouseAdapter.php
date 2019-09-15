<?php

namespace App\Clickhouse;

use Tinderbox\Clickhouse\Client;
use Tinderbox\Clickhouse\Cluster;
use Tinderbox\Clickhouse\Common\ServerOptions;
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
     * @throws \Tinderbox\Clickhouse\Exceptions\ClusterException
     * @throws \Tinderbox\Clickhouse\Exceptions\ServerProviderException
     */
    public function __construct()
    {
        $config = config('database.connections.clickhouse');

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
            ->using('clickhouse-server')
            ->writeOne($query);
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

    }

}
