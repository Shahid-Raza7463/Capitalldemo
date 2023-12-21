<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BirthdayReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:birthdayreminder';

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
        $today = date('m-d');

        $birthdayDatas = DB::table('teammembers')
            ->where('status', '1')
            ->whereRaw("DATE_FORMAT(dateofbirth, '%m-%d') = ?", [$today])
            ->select('team_member', 'emailid', 'dateofbirth', 'gender')
            ->get();

        // dd($birthdayDatas);
        foreach ($birthdayDatas as $birthdayData) {
            $data = array(
                'subject' => "Happy Birthday" . ' - ' . $birthdayData->team_member . ' - ' . "Wishing You a Day Full of Joy!",
                'name' =>   $birthdayData->team_member,
                'email' =>   $birthdayData->emailid,
                'gender' =>   $birthdayData->gender,
            );
            Mail::send('emails.happybirthday', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject($data['subject']);
            });
        }
    }
}
