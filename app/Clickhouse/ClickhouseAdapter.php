<?php

namespace App\Clickhouse;

use Tinderbox\Clickhouse\Client;
use Tinderbox\Clickhouse\Cluster;
use Tinderbox\Clickhouse\ServerProvider;

/**
 * Class ClickhouseAdapter
 * @package App\Clickhouse
 */
class ClickhouseAdapter
{

    public const SERVER_PREFIX = 'server-';

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

    protected $default_server;

    /**
     * ClickhouseAdapter constructor.
     * @throws \Tinderbox\Clickhouse\Exceptions\ClusterException
     */
    public function __construct()
    {
        $config = config('database.clickhouse');

        $servers = [];
        foreach ($config['servers'] as $i => $server) {
            $servers[self::SERVER_PREFIX . $i] = $server;
        }

        $cluster = new Cluster($config['cluster_name'], $servers);

        $serverProvider = new ServerProvider();
        $serverProvider->addCluster($cluster);

        $this->client = new Client($serverProvider);
        $this->default_cluster = $config['default_cluster'];
        $this->default_server = $config['default_server'];
    }

    public function executeRaw(string $query)
    {
        $this->client->read([
            $query
        ]);
    }

}
