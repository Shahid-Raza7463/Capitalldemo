<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TimesheetnotfillstaffReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:timesheetnotfillstaffreminder';

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
        // dd(date('l', time()));
        if ('Wednesday' == date('l', time()) || 'Saturday' == date('l', time())) {
            // Get data that is not fill timesheet
            $teammember =  DB::table('teammembers')
                ->whereNotIn('id', function ($query) {
                    $query->select('createdby')->from('timesheetusers');
                })
                ->where('teammembers.status', 1)
                ->whereIn('teammembers.role_id', [13, 14, 15]);

            $teammemberChunks = array_chunk($teammember->pluck('id')->toArray(), 1000);

            foreach ($teammemberChunks as $chunk) {
                $teammembersChunk = DB::table('teammembers')
                    ->whereIn('id', $chunk)
                    ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
                    ->get();
                // dd($teammembersChunk);
                foreach ($teammembersChunk as $teammembermail) {
                    $data = array(
                        'subject' => "Reminder || Timesheet not filled till date",
                        'name' =>   $teammembermail->team_member,
                        'email' =>   $teammembermail->emailid,
                    );
                    Mail::send('emails.timesheetnotfilledstaffremidner', $data, function ($msg) use ($data) {
                        $msg->to($data['email']);
                        $msg->subject($data['subject']);
                    });
                }
            }


            // 222222222222222222222222222222222222
            // another mail start from hare
            $teammembers = DB::table('teammembers')
                ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
                ->where('teammembers.status', 1)
                ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek())
                ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
                ->distinct('timesheetusers.createdby')
                ->get();

            // Get the last submission date for each user only sunday and suterday
            foreach ($teammembers as $user) {
                $lastSubmissionDate = DB::table('timesheetusers')
                    // get all date of this user
                    ->where('createdby', $user->id)
                    ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
                    ->where('status', '!=', 0)
                    ->where(function ($query) {
                        $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
                            ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
                    })

                    ->max('date');

                // Format the date as 'd-m-y'
                // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
                $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

                $user->last_submission_date = $lastSubmissionDate;
            }

            // find previus sunday 
            $previewsunday = now()->subWeeks(1)->endOfWeek();
            $previewsundayformate = $previewsunday->format('d-m-Y');

            // find previus saturday
            $previewsaturday = now()->subWeeks(1)->endOfWeek();
            // Subtract one day from sunday
            $previewsaturdaydate = $previewsaturday->subDay();
            $previewsaturdaydateformate = $previewsaturdaydate->format('d-m-Y');

            foreach ($teammembers as $teammembermail) {
                // both date store in an array 
                $validDates = [$previewsundayformate, $previewsaturdaydateformate];
                if (!in_array($teammembermail->last_submission_date, $validDates)) {
                    $data = array(
                        'subject' => "Reminder || Timesheet not filled Last Week",
                        'name' =>   $teammembermail->team_member,
                        'email' =>   $teammembermail->emailid,
                    );
                    Mail::send('emails.timesheetnotfilledstafflastweekremidner', $data, function ($msg) use ($data) {
                        $msg->to($data['email']);
                        $msg->subject($data['subject']);
                    });
                }
            }
        }
    }
    
}
