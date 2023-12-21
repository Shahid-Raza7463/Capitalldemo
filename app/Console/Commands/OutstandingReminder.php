<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Exports\OutstandingExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as BaseExcel;
class OutstandingReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:outstandingreminder';

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
        $outstanding = DB::table('outstandings')->
        select('Partner')->distinct()->get();
       // dd($outstanding); die;
        foreach ($outstanding as $outstandingsDatas) {
            $teammembermail = DB::table('teammembers')->where('id',$outstandingsDatas->Partner)->pluck('emailid')->first();
            $teammemberid = DB::table('teammembers')->where('id',$outstandingsDatas->Partner)->pluck('id')->first();
            $filename = "Outstanding.xlsx";
            $report_id = $teammemberid;
          //  dd($report_id);
            $attachment = Excel::raw(
                new OutstandingExport($report_id), 
                BaseExcel::XLSX
            );
            //dd($attachment);
            $data = array(
                'subject' => "Kgs Outstanding Reminder",
                'email' =>   $teammembermail,
           );
           Mail::send('emails.outstandingreminder', $data, function ($msg) use($data, $attachment ,$filename){
            $msg->to($data['email']);
            $msg->subject($data['subject']);
            $msg->cc('accounts@kgsomani.com');
            $msg->attachData($attachment, $filename);
         }); 
        }
    }
}
