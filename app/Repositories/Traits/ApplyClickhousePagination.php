<?php

namespace App\Repositories\Traits;

use App\Clickhouse\ClickhouseSelectQueryBuilder;

/**
 * Trait ApplyClickhousePagination
 * @package App\Repositories\Traits
 */
trait ApplyClickhousePagination
{
    /**
     * Apply pagination params to query builder
     *
     * @param ClickhouseSelectQueryBuilder $query
     * @param array $params
     * @return ClickhouseSelectQueryBuilder
     */
    public function applyClickhousePagination(ClickhouseSelectQueryBuilder $query, array $params) : ClickhouseSelectQueryBuilder
    {
        $default_pagination = config('defaults.pagination');
        $merged_params = array_merge(
            $default_pagination,
            $params
        );

        if ($merged_params['limit'] ?? null) {
            $query->limit($merged_params['limit']);
        }
        if ($merged_params['offset'] ?? null) {
            $query->offset($merged_params['offset']);
        }

        return $query;
    }

}
