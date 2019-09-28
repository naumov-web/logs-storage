<?php

namespace App\Repositories;

use App\Clickhouse\Adapter\ClickhouseAdapter;
use App\Clickhouse\Query\ClickhouseSelectQueryBuilder;
use App\Models\Log;
use App\Repositories\Traits\ApplyClickhousePagination;
use Tinderbox\Clickhouse\Exceptions\ClusterException;
use Tinderbox\Clickhouse\Exceptions\ServerProviderException;

/**
 * Class LogsRepository
 * @package App\Repositories
 */
class LogsRepository extends AbstractRepository
{

    use ApplyClickhousePagination;

    /**
     * Get logs data
     *
     * @param array $data
     * @return array
     * @throws ClusterException
     * @throws ServerProviderException
     */
    public function index(array $data) : array
    {
        $model_class = $this->getModelClass();
        $model = new $model_class();

        $query = new ClickhouseSelectQueryBuilder();
        $query->setAdapter(new ClickhouseAdapter())
            ->setModel($model);

        if ($data['project_id'] ?? null) {
            $query->where('project_id', $data['project_id']);
        }

        $query->with([
            'project',
            'project_event_type',
        ]);

        $count = $query->count();

        $this->applyClickhousePagination($query, $data);

        $items = $query->get();

        return [
            'count' => $count,
            'items' => $items,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Log::class;
    }
}
