<?php

namespace Tests\Feature\ProjectEventTypes;

use App\Models\ProjectEventType;
use Illuminate\Support\Arr;

/**
 * Class UpdateProjectEventTypeTest
 * @package Tests\Feature\ProjectEventTypes
 */
class UpdateProjectEventTypeTest extends AbstractProjectEventTypesTest
{
    /**
     * Test render of page for updating of project event type
     *
     * @test
     * @return void
     */
    public function testRender() : void
    {
        $this->prepareBeforeTests();
        $this->createTestItems();

        $event_type = ProjectEventType::where('name', $this->test_items[0]['name'])->first();
        $this->checkFormRender($event_type);

        $event_type = ProjectEventType::where('name', end($this->test_items)['name'])->first();
        $this->checkFormRender($event_type);
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
        $this->createTestItems();

        $event_type = ProjectEventType::where('name', $this->test_items[0]['name'])->first();
        $this->checkInvalidSubmit($event_type, $this->test_items[0]);

        $event_type = ProjectEventType::where('name', end($this->test_items)['name'])->first();
        $this->checkInvalidSubmit($event_type, end($this->test_items));
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
        $this->createTestItems();

        $event_type = ProjectEventType::where('name', $this->test_items[0]['name'])->first();
        $this->checkValidSubmit($event_type, $this->test_items[0]);

        $event_type = ProjectEventType::where('name', end($this->test_items)['name'])->first();
        $this->checkValidSubmit($event_type, end($this->test_items));
    }

    /**
     * Check rendering of form
     *
     * @param ProjectEventType $event_type
     * @return void
     */
    protected function checkFormRender(ProjectEventType $event_type) : void
    {
        $response = $this->get(route('project.event-types.update-form', ['event' => $event_type->id]));

        $response->assertOk()
            ->assertSee('Редактировать тип события проекта')
            ->assertSee('Наименование типа события проекта:')
            ->assertSee('Сохранить');
    }

    /**
     * Check invalid submit
     *
     * @param ProjectEventType $event_type
     * @param array $origin_data
     * @return void
     */
    protected function checkInvalidSubmit(ProjectEventType $event_type, array $origin_data) : void
    {
        $response = $this->post(
            route('project.event-types.update', ['event' => $event_type->id]),
            [
                'name' => ''
            ]
        );

        $response->assertStatus(302);
        $this->assertDatabaseHas(
            (new ProjectEventType())->getTable(),
            $this->filterItemData($origin_data)
        );
    }

    /**
     * Check valid submit
     *
     * @param ProjectEventType $event_type
     * @param array $origin_data
     * @return void
     */
    protected function checkValidSubmit(ProjectEventType $event_type, array $origin_data) : void
    {
        $new_data = [];
        $new_data['name'] = $origin_data['name'] . '-new';

        $this->post(
            route('project.event-types.update', ['event' => $event_type->id]),
            $new_data
        );

        $this->assertDatabaseHas(
            (new ProjectEventType())->getTable(),
            array_merge(
                $new_data,
                [
                    'id' => $event_type->id,
                ]
            )
        );
    }
}
