<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;

/**
 * Class StatisticController
 * @package App\Http\Controllers\Web
 */
class StatisticController extends AbstractAccountController
{

    /**
     * List route name
     * @var string
     */
    public const LIST_ROUTE_NAME = 'statistic.show';

    /**
     * @inheritDoc
     */
    protected function getListRouteName(): string
    {
        return self::LIST_ROUTE_NAME;
    }

    /**
     * Show statistic
     *
     * @return View
     */
    public function show() : View
    {
        return view('statistic.show');
    }
}
