<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * Trait ApplySimpleFilters
 *
 * @package App\Repositories\Traits
 */
trait ApplySimpleFilters
{

    /**
     * Get fields, which will not used for simple filters
     *
     * @return array
     */
    protected function getExcludedFields() : array
    {
        return [
            'limit',
            'offset',
            'sort_by',
            'sort_direction',
        ];
    }

    /**
     * Apply simple filters to query builder
     *
     * @param Builder $query
     * @param array $params
     *
     * @return Builder
     */
    public function applySimpleFilters(Builder $query, array $params): Builder
    {
        $fields = Arr::except($params, $this->getExcludedFields());

        foreach ($fields as $key => $value) {
            $query->where($key, $value);
        }

        return $query;
    }
}
