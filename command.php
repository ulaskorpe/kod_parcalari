php artisan make:command UlasCommand

commands/kernel.php >> UlasCommand::class

<?php

namespace App\Console\Commands;

use App\Models\Log\DriverStateChangeLog;
use Illuminate\Console\Command;

class UlasConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ulas:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        for($i=0;$i<1000;$i++){
//        $Log = new DriverStateChangeLog();
//        $Log["user_id"] = "xxx";
//        $Log["driver_id"] = rand(10,500);
//        $Log["is_online"] = 13;
//        $Log->save();
//        }
    }
}
?>

terminalde  :: php artisan ulas:command

