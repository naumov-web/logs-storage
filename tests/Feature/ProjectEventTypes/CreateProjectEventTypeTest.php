<?php

namespace Tests\Feature\ProjectEventTypes;

use App\Models\Project;
use App\Models\ProjectEventType;
use Illuminate\Support\Arr;

/**
 * Class CreateProjectEventTypeTest
 * @package Tests\Feature\ProjectEventTypes
 */
class CreateProjectEventTypeTest extends AbstractProjectEventTypesTest
{
    /**
     * Test render of page for addition of project event type
     *
     * @test
     * @return void
     */
    public function testRender() : void
    {
        $this->prepareBeforeTests();
        $this->createTestProjects();

        $project = Project::where('name', $this->test_projects[0]['name'])->first();

        $response = $this->get(route('project.event-types.add-form', ['project' => $project->id]));

        $response->assertOk()
            ->assertSee('Добавить тип события проекта')
            ->assertSee('Наименование типа события проекта:');
    }

    /**
     * Test addition when we are using invalid data
     *
     * @test
     * @return void
     */
    public function testFail() : void
    {
        $this->prepareBeforeTests();
        $this->createTestProjects();

        $response = $this->get(route('project.event-types.add-form', ['project' => self::NON_EXISTING_PROJECT_ID]));

        $response->assertNotFound();

        $project = Project::where('name', $this->test_projects[0]['name'])->first();

        $response = $this->post(
            route('project.event-types.add', ['project' => $project->id]),
            [
                'name' => ''
            ]
        );

        $response->assertStatus(302);
    }

    /**
     * Test addition when we are using valid data
     *
     * @test
     * @return void
     */
    public function testSuccess() : void
    {
        $this->prepareBeforeTests();
        $this->createTestProjects();

        $test_items = $this->test_items;

        foreach ($test_items as $test_item) {
            $project = Project::where('name', $test_item['project']['name'])->first();

            $this->post(
                route('project.event-types.add', ['project' => $project->id]),
                Arr::except($test_item, ['project'])
            );

            $this->assertDatabaseHas(
                (new ProjectEventType())->getTable(),
                array_merge(
                    Arr::except($test_item, ['project']),
                    [
                        'project_id' => $project->id,
                    ]
                )
            );
        }
    }
}
