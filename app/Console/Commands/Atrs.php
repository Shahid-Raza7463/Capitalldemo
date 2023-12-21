<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class Atrs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ats';

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
        $homecharteredaccountantDatas = DB::connection('mysql2')->table('Home_chartered_accountant')->get();
	//	dd($homecharteredaccountantDatas); die;
        foreach($homecharteredaccountantDatas as $ab)
        {
        $data=DB::table('Home_chartered_accountant')->where('email',$ab->email)->first();
//dd($data); die;
        if ($data == null) {
            DB::table('Home_chartered_accountant')->insert([	
            'name' =>$ab->name,
            'gender' =>$ab->gender,
            'age' =>$ab->age,
            'address' =>$ab->address,
            'email' =>$ab->email,
            'contact_no' =>$ab->contact_no,
            'marks_12' =>$ab->marks_12,
            'year_12' =>$ab->year_12,
            'work_experience' =>$ab->work_experience,
            'reference' =>$ab->reference,
            'resume' =>$ab->resume,
            'applied_on' =>$ab->applied_on,
            'status' =>$ab->status,
            'remarks' =>$ab->remarks,
          
     ]);
        }
     }
		
		 $homearticleshipDatas = DB::connection('mysql2')->table('Home_articleship')->get();
		
		      foreach($homearticleshipDatas as $ab)
         {
         $datas=DB::table('Home_articleship')->where('email',$ab->email)->first();
//dd($datas);
         if ($datas == null) {
             DB::table('Home_articleship')->insert([	
             'icai_no' =>$ab->icai_no,
             'name' =>$ab->name,
             'gender' =>$ab->gender,
             'age' =>$ab->age,
             'address' =>$ab->address,
             'email' =>$ab->email,
             'contact_no' =>$ab->contact_no,
             'marks_10' =>$ab->marks_10,
             'year_10' =>$ab->year_10,
             'marks_12' =>$ab->marks_12,
             'year_12' =>$ab->year_12,
             'scheme' =>$ab->scheme,
             'if_ipcc' =>$ab->if_ipcc,
              'experience' =>$ab->experience,
              'reference' =>$ab->reference,
             'resume' =>$ab->resume,
             'remarks' =>$ab->remarks,
             'applied_on' =>$ab->applied_on,
             'status' =>$ab->status,
           
      ]);
         }
        }
    }
}
