<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Illuminate\Http\Response;

/**
 * Class СreateProjectTest
 * @package Tests\Feature\Projects
 */
class CreateProjectTest extends AbstractProjectsTest
{

    /**
     * Test render of page for addition of project
     *
     * @test
     * @return void
     */
    public function testRender() : void
    {
        $this->prepareBeforeTests();

        $response = $this->get(route('projects.add-form'));

        $response->assertStatus(200)
            ->assertSee('Добавить проект')
            ->assertSee('Наименование проекта:')
            ->assertSee('URL-адрес проекта:')
            ->assertSee('API-ключ проекта:');
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

        $response = $this->post(route('projects.add'), [
            'name' => '',
        ]);

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

        foreach ($this->projects_data as $projects_item) {
            $this->post(route('projects.add'), $projects_item);

            $this->assertDatabaseHas(
                (new Project())->getTable(),
                $projects_item
            );
        }
    }

}
