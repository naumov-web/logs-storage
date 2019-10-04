<?php

namespace Tests\Feature\Projects;

use App\Models\Project;

/**
 * Class DeleteProjectTest
 * @package Tests\Feature\Projects
 */
class DeleteProjectTest extends AbstractProjectsTest
{

    /**
     * Test deleting of project
     *
     * @test
     * @return void
     */
    public function testDelete() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        $project = Project::query()->where('name', $this->test_items[0]['name'])->first();

        $this->get(route('projects.delete', ['project' => $project->id]))
            ->assertStatus(302);

        $this->assertSoftDeleted(
            (new Project())->getTable(),
            $this->test_items[0]
        );

        $project = Project::query()->where('name', end($this->test_items)['name'])->first();

        $this->get(route('projects.delete', ['project' => $project->id]))
            ->assertStatus(302);

        $this->assertSoftDeleted(
            (new Project())->getTable(),
            end($this->test_items)
        );
    }

}
