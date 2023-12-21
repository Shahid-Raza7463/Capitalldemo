<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class InvoiceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:invoicereminder';

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
        $invoiceData = DB::table('invoices')->where('status','3')->get();
        foreach ($invoiceData as $invoiceDatas ) {
            $teammembermail = DB::table('teammembers')->where('id',$invoiceDatas->partner)->pluck('emailid')->first();
            $clientname   = DB::table('clients')->where('id',$invoiceDatas->client_id)->pluck('client_name')->first();
            $data = array(
                'subject' => "Kgs Invoice Reminder",
                'clientname' =>   $clientname,
                'email' =>   $teammembermail,
                'invoiceid' =>  $invoiceDatas->id,
           );
           Mail::send('emails.invoicereminder', $data, function ($msg) use($data){
            $msg->to($data['email']);
            $msg->subject($data['subject']);
         }); 
        }
    }
}
