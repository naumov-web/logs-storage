<?php

namespace App\Repositories;

use App\Clickhouse\ClickhouseAdapter;
use App\Clickhouse\ClickhouseSelectQueryBuilder;
use App\Models\Log;
use Tinderbox\Clickhouse\Exceptions\ClusterException;
use Tinderbox\Clickhouse\Exceptions\ServerProviderException;

/**
 * Class LogsRepository
 * @package App\Repositories
 */
class LogsRepository extends AbstractRepository
{

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
        $query = new ClickhouseSelectQueryBuilder(null);
        $query->setAdapter(new ClickhouseAdapter())
            ->setModel(new ($this->getModelClass()));

        if ($data['project_id'] ?? null) {
            $query->where('project_id', $data['project_id']);
        }
    }

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Log::class;
    }
}
