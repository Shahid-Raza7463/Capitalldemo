<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Teammember;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class TaskReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:taskreminder';

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
         $tenderenddate = Task::select('reminder','status','teammember_id','duedate','taskname','description')->get();
        $current=Carbon::now();    
        $formatted_dt1=Carbon::parse($current);

        foreach($tenderenddate as $task )
        {
         
            $reminder= $task->reminder;
            $duedate= $task->duedate;
            $taskname= $task->taskname;
            $description= $task->description;
            $status= $task->status;
            $currenttotaldays=$formatted_dt1->diffInDays($duedate);
     //   dd($status);
            if(  $currenttotaldays<=6 && date('Y-m-d') <  $duedate &&  $status != 1)
            {
                $teammember_id= $task->teammember_id;
           
                $teammember_idemail = Teammember::where('id',$teammember_id)->pluck('emailid')->first(); 
       

                $data = array(
                 'taskname' =>  $taskname,
                 'description' =>  $description,
                 'duedate' =>  $duedate
     
            );
           
             Mail::send('emails.taskreminder', $data, function ($msg) use($data, $teammember_idemail){
                 $msg->to($teammember_idemail);
                 $msg->subject('kgs Task Reminder');
              });
            
            }
          
        }
    }
}
