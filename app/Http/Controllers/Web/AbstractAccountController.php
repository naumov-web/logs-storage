<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

/**
 * Class AbstractAccountController
 * @package App\Http\Controllers\Web
 */
abstract class AbstractAccountController extends Controller
{

    /**
     * Get route name for list of items
     * @return string
     */
    protected abstract function getListRouteName() : string;

}
