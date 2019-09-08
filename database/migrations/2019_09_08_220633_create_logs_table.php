<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
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
        ';
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = 'DROP TABLE logs;';
    }
}
