<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;

/**
 * Class ProjectsController
 * @package App\Http\Controllers\Web
 */
class ProjectsController extends AbstractAccountController
{

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
