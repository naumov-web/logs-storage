<?php

namespace App\Jobs;

use App\Repositories\EventsRepository;
use App\Repositories\ProjectsRepository;
use App\Services\EventsService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class StoreNewEvent
 * @package App\Jobs
 */
class StoreNewEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * New event data
     * @var array
     */
    protected $data;

    /**
     * Events service instance
     * @var EventsService
     */
    protected $service;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->service = new EventsService(
            new EventsRepository(),
            new ProjectsRepository()
        );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->service->create($this->data);
    }
}
