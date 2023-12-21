<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Teammember;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Tender;
class EveryDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reminder';

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
        $tenderenddate = Tender::select('tenderdate','services','teammember_id','tenderofferedby','status')->get();
       
        $current=Carbon::now();    
        $formatted_dt1=Carbon::parse($current);
//dd(date('Y-m-d'));
        foreach($tenderenddate as $tenderenddates )
        {
         
            $tenderenddatess= $tenderenddates->tenderdate;
           
            $status= $tenderenddates->status;
            $currenttotaldays=$formatted_dt1->diffInDays($tenderenddatess);
     //   dd($status);
            if($currenttotaldays<=6 && $status < 4)
            {
                $teammember_id= $tenderenddates->teammember_id;
                $services= $tenderenddates->services;
               
                $tenderofferedby= $tenderenddates->tenderofferedby;
//dd($tenderofferedby); 
                $teammember_idemail = Teammember::where('id',$teammember_id)->pluck('emailid')->first();
            
                if(  date('Y-m-d') <= $tenderenddatess){

                $data = array(
                    'tenderofferedby' =>  $tenderofferedby,
                    'services' =>  $services,
                    'duedate' =>  $tenderenddatess,
                 'partner' =>  $teammember_idemail
     
            );
           
             Mail::send('emails.tenderreminder', $data, function ($msg) use($data, $teammember_idemail){
                 $msg->to($teammember_idemail);
                 $msg->subject('kgs Tender Reminder');
              });
            }
            }
          
        }
    }
}
