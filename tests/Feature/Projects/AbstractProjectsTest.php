<?php

namespace Tests\Feature\Projects;

use Tests\Feature\BaseAccountTest;

/**
 * Class AbstractProjectsTest
 * @package Tests\Feature\Projects
 */
abstract class AbstractProjectsTest extends BaseAccountTest
{

    /**
     * Projects data for testing
     * @var array
     */
    protected $projects_data = [
        [
            'name' => 'Test project 1',
        ],
        [
            'name' => 'Test project 2',
            'site_url' => 'http://test-project.com',
        ]
    ];

}
