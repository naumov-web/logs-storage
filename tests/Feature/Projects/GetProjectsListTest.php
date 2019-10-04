<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Collection;

/**
 * Class GetProjectsListTest
 * @package Tests\Feature\Projects
 */
class GetProjectsListTest extends AbstractProjectsTest
{

    /**
     * Test render of page with projects list
     *
     * @test
     * @return void
     */
    public function testRender() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        $response = $this->get(route('projects.list'));

        $projects = Project::all();

        $this->checkResponse($response, $projects->toArray());
    }

    /**
     * Test render of page with projects list
     *
     * @test
     * @return void
     */
    public function testPagination() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        $limit = 3;
        $pages_count = ceil(count($this->test_items) / $limit);

        for ($i = 0; $i < $pages_count; $i++) {
            $response = $this->get(route('projects.list', [
                'limit' => $limit,
                'offset' => $i * $limit
            ]));

            $this->checkResponse(
                $response,
                array_slice(
                    $this->test_items,
                    count($this->test_items) - $i * $limit,
                    $limit
                )
            );
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
            ->assertSee('Проекты')
            ->assertSee('Добавить')
            ->assertSee('Id')
            ->assertSee('Наименование')
            ->assertSee('Сайт');



        foreach ($items as $item) {
            if ($item['id'] ?? null) {
                $response->assertSee($item['id']);
            }

            $response->assertSee($item['name']);

            if ($item['site_url'] ?? null) {
                $response->assertSee($item['site_url']);
            }
        }
    }

}
