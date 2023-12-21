<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TimesheetReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:timesheetreminder';

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
        // if ('Wednesday' == date('l', time()) || 'Saturday' == date('l', time())) {
        // $teammember = DB::table('teammembers')->where('status', '1')
        $teammember = DB::table('teammembers')->where('status', 1)
            ->where('role_id', '!=', '11')->where('role_id', '!=', '12')->where('role_id', '!=', '13')
            ->where('emailid', '!=', 'parveenved@kgsomani.com')
            ->select('emailid', 'team_member')->get();
        //   $teammember = DB::table('teammembers')->where('status','1')
        //  ->where('role_id','16')
        //  ->select('emailid','team_member')->get();
        // dd($teammember);
        foreach ($teammember as $teammembermail) {

            $data = array(
                'subject' => "Reminder || Timesheet Submission",
                'name' =>   $teammembermail->team_member,
                'email' =>   $teammembermail->emailid,
            );
            Mail::send('emails.timesheetreminder', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject($data['subject']);
            });
        }
        // }
    }
}
