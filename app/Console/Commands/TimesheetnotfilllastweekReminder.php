<?php

namespace App\Console\Commands;

use App\Exports\TimesheetLastWeekExport;
use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TimesheetnotfilllastweekReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:timesheetnotfilllastweekreminder';

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

    //!  Old code 

    // public function handle()
    // {
    //     $teammember =  DB::table('teammembers')
    //         ->leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.created_at', '<', now()->subWeek())
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();
    //     dd($teammember);
    //     $data = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' =>   $teammember,
    //     );
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $data, function ($msg) use ($data) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         $msg->subject($data['subject']);
    //     });
    // }
    public function handle()
    {
        // if ('Wednesday' == date('l', time()) || 'Saturday' == date('l', time())) {
        $teammember = DB::table('teammembers')
            ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            ->where('teammembers.status', 1)
            ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek())
            ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
            ->distinct('timesheetusers.createdby')
            ->get();

        // Get the last submission date for each user only sunday and suterday
        foreach ($teammember as $user) {
            $lastSubmissionDate = DB::table('timesheetusers')
                // get all date of this user
                ->where('createdby', $user->id)
                ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
                ->where('status', '!=', 0)
                ->where(function ($query) {
                    $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
                        ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
                })
                // ->distinct('date')
                ->max('date');

            // Format the date as 'd-m-y'
            // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
            $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

            $user->last_submission_date = $lastSubmissionDate;
        }
        // dd($teammember);
        // Create an array for the Excel export (excluding 'id')
        $excelData = $teammember->filter(function ($user) {
            return !empty($user->last_submission_date);
        })->map(function ($user) {
            return [
                'team_member' => $user->team_member,
                'emailid' => $user->emailid,
                'last_submission_date' => $user->last_submission_date,
            ];
        })->toArray();

        $export = new TimesheetLastWeekExport(collect($excelData));
        $excelFileName = 'Timesheet_last_week.xlsx';
        Excel::store($export, $excelFileName);

        // Modify the data for the email (excluding 'id')
        $emailData = array(
            'subject' => "Timesheet Not filled Last Week",
            'teammember' => $teammember->map(function ($user) {
                return (object) [
                    'team_member' => $user->team_member,
                    'emailid' => $user->emailid,
                    'last_submission_date' => $user->last_submission_date,
                ];
            }),
        );

        // dd($teammember);

        // Attach the Excel file to the email
        Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
            $msg->to('itsupport_delhi@vsa.co.in');
            $msg->cc('Admin_delhi@vsa.co.in');
            // Attach the Excel file to the email
            $msg->attach(storage_path('app/' . $excelFileName), [
                'as' => $excelFileName,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            $msg->subject($emailData['subject']);
        });
        // }
    }
}
