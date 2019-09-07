<?php

namespace App\Http\Controllers\Web;

use App\Helpers\DefaultRequestValues;
use App\Helpers\PaginationValues;
use App\Http\Requests\ListAllRequest;
use App\Http\Requests\ProjectEventTypes\CreateProjectEventTypeRequest;
use App\Http\Requests\ProjectEventTypes\UpdateProjectEventTypeRequest;
use App\Models\Project;
use App\Models\ProjectEventType;
use App\Services\ProjectEventTypesService;
use Illuminate\Http\RedirectResponse;
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
     * @param Project $project
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

    /**
     * Render form for addition of project event type
     *
     * @param Project $project
     * @return View
     */
    public function addForm(Project $project) : View
    {
        return view('project-event-types.form', [
            'project' => $project,
        ]);
    }

    /**
     * Create new project event type
     *
     * @param Project $project
     * @param CreateProjectEventTypeRequest $request
     * @return RedirectResponse
     */
    public function add(Project $project, CreateProjectEventTypeRequest $request) : RedirectResponse
    {
        $data = $request->all();

        $this->service->create($project, $data);

        return redirect(route($this->getListRouteName(), ['project' => $project->id]));
    }

    /**
     * Render form for updating of project event type
     *
     * @param ProjectEventType $event
     * @return View
     */
    public function updateForm(ProjectEventType $event) : View
    {
        return view('project-event-types.form', [
            'model' => $event,
        ]);
    }

    /**
     * Update project event type
     *
     * @param ProjectEventType $event
     * @param UpdateProjectEventTypeRequest $request
     * @return RedirectResponse
     */
    public function update(ProjectEventType $event, UpdateProjectEventTypeRequest $request) : RedirectResponse
    {
        $data = $request->all();

        $this->service->update($event, $data);

        return redirect(route($this->getListRouteName(), ['project' => $event->project->id]));
    }

    /**
     * Delete project event type
     *
     * @param ProjectEventType $event
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(ProjectEventType $event): RedirectResponse
    {
        $project_id = $event->project->id;
        $this->service->delete($event);

        return redirect(route($this->getListRouteName(), ['project' => $project_id]));
    }
}
