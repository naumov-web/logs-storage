<?php

namespace App\Http\Controllers\Web;

use App\Services\ProjectsService;
use Illuminate\View\View;

/**
 * Class ProjectsController
 * @package App\Http\Controllers\Web
 */
class ProjectsController extends AbstractAccountController
{

    /**
     * Projects service instance
     * @var ProjectsService
     */
    protected $projects_service;

    /**
     * ProjectsController constructor.
     * @param ProjectsService $projects_service
     */
    public function __construct(ProjectsService $projects_service)
    {
        $this->projects_service = $projects_service;
    }

    /**
     * Render projects list
     *
     * @return View
     */
    public function index() : View
    {
        return view('projects.index');
    }

    /**
     * Render form for addition of project
     *
     * @return View
     */
    public function addForm() : View
    {
        return view('projects.form');
    }

}
