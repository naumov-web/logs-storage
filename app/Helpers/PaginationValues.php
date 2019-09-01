<?php

namespace App\Helpers;

/**
 * Trait PaginationValues
 * @package App\Helpers
 */
trait PaginationValues
{

    /**
     * Get pagination values
     *
     * @param int $limit
     * @param int $count
     * @return int
     */
    protected function getPagesCount(int $limit, int $count) : int
    {
        return (int)ceil($count / $limit);
    }

}
