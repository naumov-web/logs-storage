<?php

use App\Clickhouse\ClickhouseAdapter;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLogsTable
 */
class CreateLogsTable extends Migration
{

    /**
     * Clickhouse adapter
     * @var ClickhouseAdapter
     */
    protected $adapter;

    /**
     * CreateLogsTable constructor.
     * @throws \Tinderbox\Clickhouse\Exceptions\ClusterException
     * @throws \Tinderbox\Clickhouse\Exceptions\ServerProviderException
     */
    public function __construct()
    {
        $this->adapter = new ClickhouseAdapter();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = '
            CREATE TABLE logs
            (
                event_date Date,
                event_time DateTime,
                project_id Int64,
                event_type_id Int64,
                external_user_id Int64,
                data String
            ) ENGINE = MergeTree()
            PARTITION BY toYYYYMM(event_date)
            ORDER BY event_time
        ';

        $this->adapter->executeRaw($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = 'DROP TABLE logs';

        $this->adapter->executeRaw($sql);
    }
}
