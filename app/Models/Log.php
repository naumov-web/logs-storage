<?php

namespace App\Models;

use App\Clickhouse\ClickhouseExternalRelation;

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
    public function getTableName(): string
    {
        return 'logs';
    }

    /**
     * Get external project relation
     *
     * @return ClickhouseExternalRelation
     */
    public function project() : ClickhouseExternalRelation
    {
        return new ClickhouseExternalRelation(
            ClickhouseExternalRelation::HAS_ONE,
            Project::class,
            'project_id'
        );
    }

    /**
     * Get external project event type relation
     *
     * @return ClickhouseExternalRelation
     */
    public function project_event_type() : ClickhouseExternalRelation
    {
        return new ClickhouseExternalRelation(
            ClickhouseExternalRelation::HAS_ONE,
            ProjectEventType::class,
            'event_type_id'
        );
    }
}
