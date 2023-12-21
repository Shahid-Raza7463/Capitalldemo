<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class HolidayReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:holidayreminder';

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
        $holidayData = DB::table('holidays')->where('status', '1')->where('year', '2023')->Select('startdate', 'holidayname')->get();

        foreach ($holidayData as $holiday) {
            $date = Carbon::createFromFormat('Y-m-d', $holiday->startdate ?? '')->subDay();
            $holidaydate = $date->format('Y-m-d');
            //dd($holidaydate);
            if ($holidaydate == date('Y-m-d')) {
                //dd('hi');
                $teammember = DB::table('teammembers')->where('status', '1')->select('emailid', 'team_member')->get();
                foreach ($teammember as $teammembermail) {

                    $data = array(
                        'subject' => "Holiday Reminder",
                        'name' =>   $teammembermail->team_member,
                        'email' =>   $teammembermail->emailid,
                        'holidate' =>   $holiday->startdate,
                        'holiname' =>   $holiday->holidayname,
                    );
                    Mail::send('emails.holidayreminder', $data, function ($msg) use ($data) {
                        $msg->to($data['email']);
                        $msg->subject($data['subject']);
                    });
                }
            }
        }
    }
}
