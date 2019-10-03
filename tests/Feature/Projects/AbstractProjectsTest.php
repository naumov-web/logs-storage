<?php

namespace Tests\Feature\Projects;

use App\Repositories\ProjectsRepository;
use App\Services\ProjectsService;
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
    protected $test_items = [
        [
            'name' => 'Test project 1',
        ],
        [
            'name' => 'Test project 2',
            'site_url' => 'http://test-project.com',
        ],
        [
            'name' => 'Test project 3',
            'site_url' => 'http://test-project3.com',
        ],
        [
            'name' => 'Test project 4',
            'site_url' => 'http://test-project4.com',
        ],
        [
            'name' => 'Test project 5',
            'site_url' => 'http://test-project5.com',
        ],
        [
            'name' => 'Test project 6',
            'site_url' => 'http://test-project6.com',
        ],
    ];

    /**
     * Projects service instance
     * @var ProjectsService
     */
    protected $projects_service;

    /**
     * AbstractProjectsTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->projects_service = new ProjectsService(
            new ProjectsRepository()
        );
    }

    /**
     * Create test items for update, delete and show list
     *
     * @return void
     */
    protected function createTestItems() : void
    {
        foreach ($this->test_items as $test_item) {
            $this->projects_service->store($test_item);
        }
    }

}
