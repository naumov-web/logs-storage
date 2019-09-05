<?php

namespace App\Http\Controllers\Web;

use App\Helpers\DefaultRequestValues;
use App\Helpers\PaginationValues;
use App\Http\Requests\ListAllRequest;
use App\Models\Project;
use App\Services\ProjectEventTypesService;
use Illuminate\View\View;

/**
 * Class ProjectEventTypesController
 * @package App\Http\Controllers\Web
 */
class ProjectEventTypesController extends AbstractAccountController
{
    use DefaultRequestValues, PaginationValues;

    /**
     * List route name
     * @var string
     */
    public const LIST_ROUTE_NAME = 'project.event-types.list';

    /**
     * Project event types service instance
     * @var ProjectEventTypesService
     */
    protected $service;

    /**
     * ProjectEventTypesController constructor.
     * @param ProjectEventTypesService $service
     */
    public function __construct(ProjectEventTypesService $service)
    {
        $this->service = $service;
    }

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
     * Render project event types list
     *
     * @param \App\Models\Project $project
     * @param ListAllRequest $request
     * @return View
     */
    public function index(Project $project, ListAllRequest $request): View
    {
        $result = $this->service->get($project, $request->all());
        $request_values = $this->getRequestValues();

        return view('project-event-types.index', array_merge(
            $request_values,
            [
                'project' => $project,
                'pages_count' => $this->getPagesCount(
                    $request_values['limit'],
                    $result['count']
                ),
                'items' => $result['items'],
                'list_route_name' => $this->getListRouteName(),
            ]
        ));
    }
}
