<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TimesheetMonday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:timesheetmonday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Successfully';

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
     * @return int
     */
    public function handle()
    {
        // if ('Monday' == date('l', time())) {
        DB::table('timesheetday')->where('id', '1')->update([
            'date'  => date('Y-m-d'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
        // }
    }
}
