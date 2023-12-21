<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use App\Models\Teammember;
use Illuminate\Support\Facades\Log;

class UpdateAttendanceCommand extends Command
{
    protected $signature = 'attendance:update';

    protected $description = 'Update attendance table with 0 on the 26th of every month';

    public function handle()
    {
        $output = $this->getOutput();
        $output->writeln('Inside Attendence command');
        Log::info('This is the HTTP response from the command');
        // Get the current date
        $currentDate = now();

        // Check if it's the 26th of the month
        if ($currentDate->day == 26) {
            // Retrieve all team members who are active and not in specific roles or email IDs
            $teammembers = Teammember::where(function ($query) {
                $query->where('status', 1)
                      ->orWhereIn('id', ['558','418','645','549','318','660','647','685']);})   //manual attendance - support staff
                ->whereNotIn('role_id', ['11', '12', '13'])
                ->whereNotIn('emailid', ['parveenved@kgsomani.com'])
                ->whereNotIn('id', ['310','641','640','649','637','315','203','670','686','687'])  //Secretarial KGS, Bharat, Gaurav Amoli, Ashish Sharma, Sachin Shukla, 
                ->select('id', 'joining_date')
                ->get();

            // Get the current month
            $currentMonth = $currentDate->addMonth()->format('F');

            // Update the attendance table for the selected team members with a value of 0
            foreach ($teammembers as $teammember) {

                // Check if the attendance record already exists for the employee and month
                $existingRecord = Attendance::where('employee_name', $teammember->id)
                    ->where('month', $currentMonth)
                    ->first();

                if ($existingRecord == null) {
                    Attendance::create([
                        'employee_name' => $teammember->id,
                        'employee_status' => 1,
                        'dateofjoining' => $teammember->joining_date,
                        'month' => $currentMonth,
                        'created_at' => $currentDate

                    ]);
                }
            }

            $this->info('Attendance table updated successfully.');
        } else {
            $this->info('No action required.');
        }
    }
}
