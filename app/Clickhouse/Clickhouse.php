<?php

namespace App\Clickhouse;

use Tinderbox\Clickhouse\ServerProvider;

class Clickhouse
{
    protected $client;

    public function __construct()
    {
        $config = config('database.clickhouse');

        $serverProvider = new ServerProvider();
        
    }
}
