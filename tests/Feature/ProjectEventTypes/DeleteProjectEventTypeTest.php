<?php

namespace Tests\Feature\ProjectEventTypes;

use App\Models\ProjectEventType;

/**
 * Class DeleteProjectEventTypeTest
 * @package Tests\Feature\ProjectEventTypes
 */
class DeleteProjectEventTypeTest extends AbstractProjectEventTypesTest
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

        $event_type = ProjectEventType::where('name', $this->test_items[0]['name'])->first();
        $this->checkDeleting($event_type, $this->test_items[0]);

        $event_type = ProjectEventType::where('name', end($this->test_items)['name'])->first();
        $this->checkDeleting($event_type, end($this->test_items));
    }

    /**
     * Check deleting of project event type
     *
     * @param ProjectEventType $event_type
     * @param array $origin_data
     * @return void
     */
    protected function checkDeleting(ProjectEventType $event_type, array $origin_data) : void
    {
        $this->get(route('project.event-types.delete', ['event' => $event_type->id]))
            ->assertStatus(302);

        $this->assertSoftDeleted(
            (new ProjectEventType())->getTable(),
            array_merge(
                $this->filterItemData($origin_data),
                [
                    'id' => $event_type->id,
                ]
            )
        );
    }
}
