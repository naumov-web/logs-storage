<?php

namespace App\Models;

/**
 * Class Log
 * @package App\Models
 */
class Log extends ClickhouseModel
{

    /**
     * Get table name
     * @return string
     */
    protected function getTableName(): string
    {
        return 'logs';
    }
}
