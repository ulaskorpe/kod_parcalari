<?php
///////////////migration
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverVehicleAssignmentLogsTable extends Migration
{
    protected $connection = 'mongodb';

    public $set_schema_table = 'driver_vehicle_assignment_logs';

    public function up()
    {
        Schema::connection($this->connection)
            ->table($this->set_schema_table, function (Blueprint $collection) {
                $collection->index(['driver_id']);
            });
    }

    public function down()
    {
        Schema::connection($this->connection)
            ->table($this->set_schema_table, function (Blueprint $collection) {
                $collection->drop();
            });
    }
}
/////////MODEL


namespace App\Models\Log;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class DriverVehicleAssignmentLog extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'driver_vehicle_assignment_logs';
}
