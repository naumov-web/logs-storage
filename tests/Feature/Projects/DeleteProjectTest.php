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
        $this->checkDeleting($project, $this->test_items[0]);

        $project = Project::query()->where('name', end($this->test_items)['name'])->first();
        $this->checkDeleting($project, end($this->test_items));
    }

    /**
     * Check deleting of project
     *
     * @param Project $project
     * @param array $origin_data
     * @return void
     */
    protected function checkDeleting(Project $project, array $origin_data) : void
    {
        $this->get(route('projects.delete', ['project' => $project->id]))
            ->assertStatus(302);

        $this->assertSoftDeleted(
            (new Project())->getTable(),
            array_merge(
                $origin_data,
                [
                    'id' => $project->id,
                ]
            )
        );
    }

}
