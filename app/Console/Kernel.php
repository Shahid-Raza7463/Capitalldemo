<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
           Commands\EveryDay::class,
		Commands\TimesheetMonday::class,
           Commands\TaskReminder::class,
		 Commands\InvoiceReminder::class,
		 Commands\HolidayReminder::class,
		Commands\TimesheetReminder::class,
	   Commands\BirthdayReminder::class,
		Commands\OutstandingReminder::class,
		Commands\TimesheetCron::class,
		Commands\Atrs::class,
		Commands\UpdateAttendanceCommand::class,
		Commands\CalculateAttendance::class,
		Commands\TimesheetnotfilllastweekReminder::class,
		Commands\TimesheetnotfillReminder::class,
			Commands\TimesheetnotfillstaffReminder::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->command('command:reminder')->daily();
        $schedule->command('command:taskreminder')->daily()->withoutOverlapping();
		 $schedule->command('command:holidayreminder')->daily()->withoutOverlapping();
		$schedule->command('command:invoicereminder')->daily()->withoutOverlapping();
		$schedule->command('command:timesheetreminder')->daily()->withoutOverlapping();
		$schedule->command('command:birthdayreminder')->daily()->withoutOverlapping();
		$schedule->command('command:outstandingreminder')->daily()->withoutOverlapping();
		$schedule->command('demo:cron')->daily()->withoutOverlapping();
		$schedule->command('demo:ats')->daily()->withoutOverlapping();
	$schedule->command('attendance:update')->monthlyOn(26, '00:00')->emailOutputTo('sukhbahadur@capitall.io');
		$schedule->command('attendance:calculate')->daily()->withoutOverlapping();
			$schedule->command('command:timesheetnotfilllastweekreminder')->daily()->withoutOverlapping();
		$schedule->command('command:timesheetnotfilllastweekreminder')->daily()->withoutOverlapping();
		$schedule->command('command:timesheetnotfillreminder')->daily()->withoutOverlapping();
			$schedule->command('command:timesheetnotfillstaffreminder')->daily()->withoutOverlapping();
		$schedule->command('command:timesheetmonday')->daily()->withoutOverlapping();
		
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
