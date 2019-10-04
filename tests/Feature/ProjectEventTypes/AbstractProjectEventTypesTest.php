<?php

namespace Tests\Feature\ProjectEventTypes;

use App\Repositories\ProjectEventTypesRepository;
use App\Services\ProjectEventTypesService;
use Tests\Feature\BaseAccountTest;

/**
 * Class AbstractProjectEventTypesTest
 * @package Tests\Feature\ProjectEventTypes
 */
class AbstractProjectEventTypesTest extends BaseAccountTest
{
    /**
     * Projects data for testing
     * @var array
     */
    protected $test_items = [
        [
            'project' => [
                'name' => 'Проект 1'
            ],
            'name' => 'Событие 1-1',
        ],
        [
            'project' => [
                'name' => 'Проект 1'
            ],
            'name' => 'Событие 1-2',
        ],
        [
            'project' => [
                'name' => 'Проект 1'
            ],
            'name' => 'Событие 1-3',
        ],
        [
            'project' => [
                'name' => 'Проект 2'
            ],
            'name' => 'Событие 2-1',
        ],
        [
            'project' => [
                'name' => 'Проект 2'
            ],
            'name' => 'Событие 2-2',
        ],
    ];

    /**
     * Test project items
     * @var array
     */
    protected $test_projects = [
        [
            'name' => 'Проект 1'
        ],
        [
            'name' => 'Проект 2'
        ]
    ];

    /**
     * Project event types service instance
     * @var ProjectEventTypesService
     */
    protected $project_event_types_service;

    /**
     * AbstractProjectEventTypesTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->project_event_types_service = new ProjectEventTypesService(
            new ProjectEventTypesRepository()
        );
    }

    /**
     * Create test projects
     *
     * @return void
     */
    protected function createTestProjects() : void
    {

    }

    /**
     * Create test items for update, delete and show list
     *
     * @return void
     */
    protected function createTestItems() : void
    {
        $this->createTestProjects();
        
        foreach ($this->test_items as $test_item) {
            $this->project_event_types_service->store($test_item);
        }
    }
}
