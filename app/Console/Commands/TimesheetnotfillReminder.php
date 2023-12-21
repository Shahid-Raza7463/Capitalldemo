<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel; // Import Excel facade
use App\Exports\TeammemberExport;

class TimesheetnotfillReminder extends Command
{
    // ... (existing code)

    protected $signature = 'command:timesheetnotfillreminder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if ('Wednesday' == date('l', time()) || 'Saturday' == date('l', time())) {
            $createdby = DB::table('timesheetusers')->select('createdby')->distinct()->get()->pluck('createdby')->toArray();
            $teammemberOnlySave = DB::table('teammembers')
                ->leftJoin('timesheets', 'timesheets.created_by', 'teammembers.id')
                ->where('teammembers.status', 1)
                ->whereIn('timesheets.created_by', $createdby)
                ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
                ->groupBy('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
                ->havingRaw('COUNT(DISTINCT timesheets.id) = COUNT(CASE WHEN timesheets.status = 0 THEN 1 ELSE NULL END)')
                ->get();


            //  team members who have never filled a timesheet
            $teammemberNeverFilled = DB::table('teammembers')
                ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
                ->whereNull('timesheetusers.createdby')
                ->where('teammembers.status', 1)
                // ->whereIn('teammembers.status', [1, 0])
                ->whereIn('teammembers.role_id', [14, 15, 13, 11])
                ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
                ->get();

            // Create an array for the Excel export
            $excelData = $teammemberOnlySave->map(function ($user) {
                return [
                    'team_member' => $user->team_member,
                    'emailid' => $user->emailid,
                ];
            })->merge(
                $teammemberNeverFilled->map(function ($user) {
                    return [
                        'team_member' => $user->team_member,
                        'emailid' => $user->emailid,
                    ];
                })
            )->toArray();

            // Store the Excel file
            $export = new TeammemberExport(collect($excelData));
            $excelFileName = 'Timesheet_Not_Submitted.xlsx';
            Excel::store($export, $excelFileName);

            // get data on mail blade file
            $emailData = array(
                'subject' => "Timesheet not filled till date",
                'teammemberOnlySave' => $teammemberOnlySave->map(function ($user) {
                    return (object) [
                        'team_member' => $user->team_member,
                        'emailid' => $user->emailid,
                        // 'last_submission_date' => $user->last_submission_date,
                    ];
                }),
            );


            Mail::send('emails.timesheetnotfilledremidner', $emailData, function ($msg) use ($emailData, $excelFileName) {
                //    $msg->to('sukhbahadur1993@gmail.com');
                $msg->to('itsupport_delhi@vsa.co.in');
                $msg->cc('Admin_delhi@vsa.co.in');
                // Attach the Excel file to the email
                $msg->attach(storage_path('app/' . $excelFileName), [
                    'as' => $excelFileName,
                    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ]);
                $msg->subject($emailData['subject']);
            });
        }
    }
}
