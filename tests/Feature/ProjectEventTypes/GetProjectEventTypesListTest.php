<?php

namespace Tests\Feature\ProjectEventTypes;

use App\Models\Project;
use App\Models\ProjectEventType;
use Illuminate\Foundation\Testing\TestResponse;

/**
 * Class GetProjectEventTypesListTest
 * @package Tests\Feature\ProjectEventTypes
 */
class GetProjectEventTypesListTest extends AbstractProjectEventTypesTest
{
    /**
     * Test render of page with project event types list
     *
     * @test
     * @return void
     */
    public function testRender() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        foreach ($this->test_projects as $test_project) {
            $project = Project::where('name', $test_project['name'])->first();

            $response = $this->get(route('project.event-types.list', ['project' => $project->id]));

            $items = ProjectEventType::where('project_id', $project->id)->get();

            $this->checkResponse($response, $items->toArray());
        }
    }

    /**
     * Test render of page with project event types list and pagination
     *
     * @test
     * @return void
     */
    public function testPagination() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        $limit = 1;

        foreach ($this->test_projects as $test_project) {

            $project = Project::where('name', $test_project['name'])->first();
            $count = 0;

            $project_events = [];

            foreach ($this->test_items as $test_item) {
                if ($test_item['project']['name'] == $test_project['name']) {
                    $count++;
                    $project_events[] = [
                        'name' => $test_item['name']
                    ];
                }
            }

            $pages_count = ceil($count / $limit);

            for($i = 0; $i < $pages_count; $i++) {
                $response = $this->get(
                    route(
                        'project.event-types.list',
                        [
                            'project' => $project->id,
                            'offset' => $i * $limit,
                            'limit' => $limit,
                        ]
                    )
                );

                $this->checkResponse(
                    $response,
                    array_slice(
                        $project_events,
                        count($project_events) - ($i + 1),
                        $limit
                    )
                );

            }
        }
    }

    /**
     * Check response
     *
     * @param TestResponse $response
     * @param array $items
     * @return void
     */
    protected function checkResponse(TestResponse $response, array $items) : void
    {
        $response->assertOk()
            ->assertSee('Типы событий проекта')
            ->assertSee('Добавить')
            ->assertSee('Id')
            ->assertSee('Наименование');

        foreach ($items as $item) {
            if ($item['id'] ?? null) {
                $response->assertSee($item['id']);
            }

            $response->assertSee($item['name']);
        }
    }
}
