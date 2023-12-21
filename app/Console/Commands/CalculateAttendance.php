<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculateAttendance extends Command
{
    protected $signature = 'attendance:calculate';

    protected $description = 'calculate attendance on the 26th of every month';

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
        $currentDate = now();
        $totalDays = now()->subMonth()->daysInMonth;
        $currentMonth = $currentDate->format('F');
        $currentMonthDigit = $currentDate->format('m');
        $currentYear = $currentDate->format('Y');

        $prevMonth = $currentDate->copy()->subMonth()->format('m'); //used in holidays counting
        $currentMonthInDigit = $currentDate->copy()->format('m');   //used in holidays counting


        $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
            ->where('attendances.month', $currentMonth)
            ->whereYear('attendances.created_at', $currentYear)
            ->whereNotNull('teammembers.joining_date')
            ->get();


        foreach ($teammembers as $team) {

            $getholidaydates = DB::table('holidays')
                ->whereBetween('startdate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
                ->whereBetween('enddate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
                ->where('startdate', '>', $team->joining_date)
                ->get();
            $holidayCount = 0;
            foreach ($getholidaydates as $holiday) {
                $holidayCount += intval($holiday->number_of_dates);
            }

            $keysToFilter = [
                'twentysix',
                'twentyseven',
                'twentyeight',
                'twentynine',
                'thirty',
                'thirtyone',
                'one',
                'two',
                'three',
                'four',
                'five',
                'six',
                'seven',
                'eight',
                'nine',
                'ten',
                'eleven',
                'twelve',
                'thirteen',
                'fourteen',
                'fifteen',
                'sixteen',
                'seventeen',
                'eighteen',
                'ninghteen',
                'twenty',
                'twentyone',
                'twentytwo',
                'twentythree',
                'twentyfour',
                'twentyfive'
            ];

            $daysToRemove = [];

            if ($totalDays < 31) {
                $daysToRemove[] = 'thirtyone';
            }

            if ($totalDays < 30) {
                $daysToRemove[] = 'thirty';
            }

            if ($totalDays < 29) {
                $daysToRemove[] = 'twentynine';
            }

            $keysToFilter = array_diff($keysToFilter, $daysToRemove);



            $days = array_intersect_key($team->toArray(), array_flip($keysToFilter));


            $dayspresent = 0;
            $totalCount = 0;
            $absentCount = 0;



            $dayMapping = [
                'twentysix' => 26,
                'twentyseven' => 27,
                'twentyeight' => 28,
                'twentynine' => 29,
                'thirty' => 30,
                'thirtyone' => 31,
                'one' => 1,
                'two' => 2,
                'three' => 3,
                'four' => 4,
                'five' => 5,
                'six' => 6,
                'seven' => 7,
                'eight' => 8,
                'nine' => 9,
                'ten' => 10,
                'eleven' => 11,
                'twelve' => 12,
                'thirteen' => 13,
                'fourteen' => 14,
                'fifteen' => 15,
                'sixteen' => 16,
                'seventeen' => 17,
                'eighteen' => 18,
                'ninghteen' => 19,
                'twenty' => 20,
                'twentyone' => 21,
                'twentytwo' => 22,
                'twentythree' => 23,
                'twentyfour' => 24,
                'twentyfive' => 25,
            ];

            switch ($totalDays) {
                case 30:
                    unset($dayMapping['thirtyone']);
                    break;
                case 29:
                    unset($dayMapping['thirtyone'], $dayMapping['thirty']);
                    break;
                case 28:
                    unset($dayMapping['thirtyone'], $dayMapping['thirty'], $dayMapping['twentynine']);
                    break;
            }



            foreach ($days as $key => $value) {
                if ($value === null) {

                    // Absent
                    // Check if the day's date is not in the holidays table
                    $dayOfMonth = $dayMapping[$key] ?? 0;

                    $month = $currentMonth;

                    if (in_array($dayOfMonth, [26, 27, 28, 29, 30, 31])) {
                        // Adjust the month if the day falls within 26-31 range
                        $currentDate = DateTime::createFromFormat('F', $currentMonth)->modify('first day of')->format('Y-m-d');
                        $previousMonth = DateTime::createFromFormat('Y-m-d', $currentDate)->modify('-1 month')->format('F');
                        $month = $previousMonth;
                    }
                    $monthNumeric = date('m', strtotime($month));
                    $absentDate = date('Y-m-d', strtotime("$currentYear-$monthNumeric-$dayOfMonth"));


                    $isHoliday = DB::table('holidays')->where(function ($query) use ($absentDate) {
                        $query->where('startdate', '<=', $absentDate)
                            ->where('enddate', '>=', $absentDate);
                    })->exists();


                    if (!$isHoliday) {

                        $absentCount++;
                    } else {
                        if ($absentDate < $team->joining_date) {
                            $absentCount++;
                        }
                    }
                    continue;
                }

                switch ($value) {

                    case is_numeric($value):

                        $dayOfMonth = $dayMapping[$key] ?? 0;

                        $month = $currentMonth;

                        if (in_array($dayOfMonth, [26, 27, 28, 29, 30, 31])) {
                            // Adjust the month if the day falls within 26-31 range
                            $currentDate = DateTime::createFromFormat('F', $currentMonth)->modify('first day of')->format('Y-m-d');
                            $previousMonth = DateTime::createFromFormat('Y-m-d', $currentDate)->modify('-1 month')->format('F');
                            $month = $previousMonth;
                        }
                        $monthNumeric = date('m', strtotime($month));
                        $targetDate = date('Y-m-d', strtotime("$currentYear-$monthNumeric-$dayOfMonth"));


                        $isHoliday = DB::table('holidays')->where(function ($query) use ($targetDate) {
                            $query->where('startdate', '<=', $targetDate)
                                ->where('enddate', '>=', $targetDate);
                        })->exists();
                        if (!$isHoliday) {
                            $dayspresent++;
                        }

                        break;
                }
            }

            $attendance_existing = DB::table('attendances')->where('employee_name', $team->employee_name)->where('month', $currentMonth)->first();

            if ($dayspresent == 0) {
                $holidayCount = 0;
            }

            $totalCount = $dayspresent +  $attendance_existing->casual_leave + $attendance_existing->sick_leave  + $attendance_existing->birthday_religious + $holidayCount;





            $attendanceData = [


                'no_of_days_present' => $dayspresent,
                'totaldaystobepaid' => $totalCount,
                'total_no_of_days' => $totalDays,
                'absent' => $absentCount,

            ];
            // dd($currentMonth);
            DB::table('attendances')->where('employee_name', $team->employee_name)->where('month', $currentMonth)->update($attendanceData);
        }



        return "Attendance updated";
    }
}
