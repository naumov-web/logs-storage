<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ApplyPagination
 *
 * @package App\Repositories\Traits
 */
trait ApplyPagination
{

    /**
     * Apply pagination params to query builder
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function applyPagination(Builder $query, array $params) : Builder
    {
        $default_pagination = config('defaults.pagination');
        $merged_params = array_merge(
            $default_pagination,
            $params
        );

        $query->when($merged_params['limit'] ?? null, function ($query, $limit) {
            $query->limit($limit);
        });
        $query->when($merged_params['offset'] ?? null, function ($query, $offset) {
            $query->offset($offset);
        });

        return $query;
    }

}
