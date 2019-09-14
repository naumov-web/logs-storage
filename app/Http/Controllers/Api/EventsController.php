<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Events\StoreEventRequest;
use App\Jobs\StoreNewEvent;
use Illuminate\Http\JsonResponse;

/**
 * Class EventsController
 * @package App\Http\Controllers\Api
 */
class EventsController extends AbstractApiController
{

    /**
     * Store new event item
     *
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function store(StoreEventRequest $request) : JsonResponse
    {
        $data = $request->all();

        StoreNewEvent::dispatch($data);

        return response()->json([
            'success' => true
        ]);
    }

}
