<?php


namespace App\Http\Controllers\Web;

use App\Helpers\DefaultRequestValues;
use App\Helpers\PaginationValues;
use App\Http\Requests\Logs\GetLogsListRequest;
use App\Services\LogsService;
use App\Services\ProjectsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class LogsController
 * @package App\Http\Controllers\Web
 */
class LogsController extends AbstractAccountController
{

    use DefaultRequestValues, PaginationValues;

    /**
     * List route name
     * @var string
     */
    public const LIST_ROUTE_NAME = 'projects.list';

    /**
     * Projects service instance
     * @var ProjectsService
     */
    protected $projects_service;

    /**
     * Logs service instance
     * @var LogsService
     */
    protected $logs_service;

    /**
     * Get list route name
     *
     * @return string
     */
    protected function getListRouteName(): string
    {
        return self::LIST_ROUTE_NAME;
    }

    /**
     * LogsController constructor.
     * @param ProjectsService $projects_service
     * @param LogsService $logs_service
     */
    public function __construct(ProjectsService $projects_service, LogsService $logs_service)
    {
        $this->projects_service = $projects_service;
        $this->logs_service = $logs_service;
    }

    /**
     * Get logs list
     *
     * @param GetLogsListRequest $request
     * @return Factory|View
     */
    public function index(GetLogsListRequest $request) : View
    {
        $data = $request->all();
        $projects = $this->projects_service->index([]);

        $logs = $this->logs_service->index($data);

        return view('logs.index', [
            'projects' => $projects['items'],
            'items' => $logs['items'],
            'count' => $logs['count'],
        ]);
    }
}
