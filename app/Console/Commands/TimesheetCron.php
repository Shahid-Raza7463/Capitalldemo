<?php

namespace App\Console\Commands;

use App\Models\Timesheet;
use App\Models\Timesheetuser;
use Illuminate\Console\Command;
use DB;

class TimesheetCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

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
     * @return int
     */
    public function handle()
    {


        //\Log::info("Cron is working fine!");

        $collection = Timesheetuser::
            //join('timesheets','timesheets.id','timesheetusers.timesheetid')
            get();
        // dd($collection);
        $collection
            // Group models by sub_id and name
            ->groupBy(function ($item) {
                return $item->client_id . '_' . $item->assignment_id
                    . '_' . $item->partner . '_' . $item->date . '_' . $item->hour
                    . '_' . $item->workitem . '_' . $item->createdby;
            })
            // Filter to remove non-duplicates
            ->filter(function ($arr) {
                return $arr->count() > 1;
            })
            // Process duplicates groups
            ->each(function ($arr) {
                $arr
                    // Sort by id  (so first item will be original)
                    ->sortBy('id')
                    // Remove first (original) item from dupes collection
                    ->splice(1)
                    // Remove duplicated models from DB
                    ->each(function ($model) {
                        $model->delete();
                    });
            });


        Log::info($collection);
        $zerotimesheet = Timesheetuser::where('hour', 0)->get();

        foreach ($zerotimesheet as $ts) {
            $ts->delete();
        }
        $timesheet = Timesheet::whereDoesntHave('timesheetusers')->get();
        foreach ($timesheet as  $timesheet) {
            # code...
            $timesheet->delete();
        }


        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
    }
}
