<?php
use App\Models\JobsStatus;
use Illuminate\Database\Seeder;

class JobsStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $status=new JobsStatus();
        $status->name="Accepted";
        $status->save();

        $status=new JobsStatus();
        $status->name="Unaccepted";
        $status->save();

    }
}
