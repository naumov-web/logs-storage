<?php

namespace App\Http\Controllers\Web;

use App\Helpers\DefaultRequestValues;
use App\Helpers\PaginationValues;
use App\Http\Requests\ListAllRequest;
use App\Http\Requests\Projects\CreateProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class ProjectsController
 * @package App\Http\Controllers\Web
 */
class ProjectsController extends AbstractAccountController
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
    protected $service;

    /**
     * ProjectsController constructor.
     * @param ProjectsService $service
     */
    public function __construct(ProjectsService $service)
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
     * Render projects list
     *
     * @param ListAllRequest $request
     * @return View
     */
    public function index(ListAllRequest $request): View
    {
        $result = $this->service->index($request->all());
        $request_values = $this->getRequestValues();

        return view('projects.index', array_merge(
            $request_values,
            [
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
     * Render form for addition of project
     *
     * @return View
     */
    public function addForm(): View
    {
        return view('projects.form');
    }

    /**
     * Create new project
     *
     * @param CreateProjectRequest $request
     * @return RedirectResponse
     */
    public function add(CreateProjectRequest $request): RedirectResponse
    {
        $data = $request->all();

        $this->service->store($data);

        return redirect(route($this->getListRouteName()));
    }

    /**
     * Render form for updating of project
     *
     * @param Project $project
     * @return View
     */
    public function updateForm(Project $project): View
    {
        return view('projects.form', [
            'model' => $this->service->show($project)
        ]);
    }

    /**
     * Update project
     *
     * @param Project $project
     * @param UpdateProjectRequest $request
     * @return RedirectResponse
     */
    public function update(Project $project, UpdateProjectRequest $request): RedirectResponse
    {
        $this->service->update($project, $request->all());

        return redirect(route($this->getListRouteName()));
    }

    /**
     * Delete project
     *
     * @param Project $project
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Project $project): RedirectResponse
    {
        $this->service->delete($project);

        return redirect(route($this->getListRouteName()));
    }

}
