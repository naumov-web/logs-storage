<?php

namespace App\Helpers;

/**
 * Trait DefaultRequestValues
 * @package App\Helpers
 */
trait DefaultRequestValues
{

    /**
     * Get request values with merged values
     *
     * @return array
     */
    protected function getRequestValues() : array
    {
        $data = request()->all();

        return array_merge(
            config('defaults.pagination'),
            config('defaults.sorting'),
            $data
        );
    }

}
