<?php

namespace Tests\Feature\Projects;

use App\Models\Project;

/**
 * Class UpdateProjectTest
 * @package Tests\Feature\Projects
 */
class UpdateProjectTest extends AbstractProjectsTest
{
    /**
     * Test render of page for updating of project
     *
     * @test
     * @return void
     */
    public function testRender() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        $project = Project::where('name', $this->test_items[0]['name'])->first();

        $response = $this->get(route('projects.update-form', ['project' => $project->id]));

        $response->assertOk()
            ->assertSee('Редактировать проект')
            ->assertSee('Наименование проекта:')
            ->assertSee('URL-адрес проекта:')
            ->assertSee('API-ключ проекта:');
    }

    /**
     * Test updating when we are using invalid data
     *
     * @test
     * @return void
     */
    public function testFail() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        $project = Project::where('name', $this->test_items[0]['name'])->first();

        $response = $this->post(route('projects.update', ['project' => $project->id]), [
            'name' => '',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas(
            (new Project())->getTable(),
            $this->test_items[0]
        );
    }

    /**
     * Test updating when we are using valid data
     *
     * @test
     * @return void
     */
    public function testSuccess() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        $project = Project::where('name', $this->test_items[0]['name'])->first();

        $this->test_items[0]['name'] = 'New project name 1';
        $this->test_items[0]['site_url'] = 'http://new-project.com';

        $this->post(route('projects.update', ['project' => $project->id]), $this->test_items[0]);

        $this->assertDatabaseHas(
            (new Project())->getTable(),
            $this->test_items[0]
        );
    }
}
