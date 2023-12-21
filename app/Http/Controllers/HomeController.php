<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Artisan;
use Log;
use App\Models\Candidateonboarding;
use DB;
use App\Models\Articleonboarding;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function cron () {
        
        $exitCode = Artisan::call('migrate:fresh'); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	public function calculateAttendance()
  {

    $exitCode = Artisan::call('attendance:calculate')->daily();

    return  redirect('/');
  }
	public function timesheetnotfilllastweekreminder()
  {

    $exitCode = Artisan::call('command:timesheetnotfilllastweekreminder')->daily();

    return  redirect('/');
  }
		public function timesheetmonday()
  {

    $exitCode = Artisan::call('command:timesheetmonday')->daily();

    return  redirect('/');
  }
	
	public function timesheetnotfillreminder()
  {

    $exitCode = Artisan::call('command:timesheetnotfillreminder')->daily();

    return  redirect('/');
  }
	public function timesheetnotfillstaffreminder()
  {

    $exitCode = Artisan::call('command:timesheetnotfillstaffreminder')->daily();

    return  redirect('/');
  }
//	public function UpdateAttendance()
//  {

 //   $exitCode = Artisan::call('attendance:update')->monthlyOn(26, '14:30')->emailOutputTo('sukhbahadur@capitall.io');

 //   return  redirect('/');

    //  dd($exitCode);
    // return what you want
//  }
	public function ats () {
        
        $exitCode = Artisan::call('command:ats')->daily(); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	public function Att () {
        
    $payrolls =  DB::table('timesheets')
    ->where('date','>=','2023-04-26')
     ->where('date','<=','2023-05-25')
     ->select('timesheets.created_by')->distinct()
   ->get();
// dd($payrolls);
   foreach ($payrolls as $value) {
    $noofdaysaspertimesheet = DB::table('timesheets')
    ->where('created_by',$value->created_by)
    ->where('date','>=','2023-04-26')
  ->where('date','<=','2023-05-25')
  ->select('timesheets.*')
  ->get();
//  dd($noofdaysaspertimesheet);
  foreach ($noofdaysaspertimesheet as $noofdaysaspertimesheetvalue) {
// dd($noofdaysaspertimesheetvalue);
  $total = DB::table('timesheetusers')

  ->where('timesheetusers.timesheetid',$noofdaysaspertimesheetvalue->id)
  ->sum('hour');

   // dd($total);

   $attendances = DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)
    ->where('month','May')->first();
  //  dd($value->created_by);
    if($attendances ==  null){
        DB::table('attendances')->insert([	
            'employee_name'         =>     $noofdaysaspertimesheetvalue->created_by,
            'month'         =>    'May',

        ]);
    }
 //   dd($noofdaysaspertimesheetvalue);
if ($noofdaysaspertimesheetvalue->date == '2023-04-26') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentysix'         =>     $total,
        ]);
}

if ($noofdaysaspertimesheetvalue->date == '2023-04-27') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentyseven'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-04-28') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentyeight'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-04-29') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentynine'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-04-30') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'thirty'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-04-31') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'thirtyone'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-01') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'one'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-02') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'two'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-03') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'three'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-04') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'four'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-05') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'five'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-06') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'six'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-07') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'seven'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-08') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'eight'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-09') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'nine'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-10') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'ten'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-11') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'eleven'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-12') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twelve'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-13') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'thirteen'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-14') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'fourteen'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-15') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'fifteen'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-16') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'sixteen'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-17') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'seventeen'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-18') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'eighteen'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-19') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'ninghteen'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-20') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twenty'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-21') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentyone'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-22') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentytwo'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-23') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentythree'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-24') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentyfour'         =>     $total,
        ]);
}
if ($noofdaysaspertimesheetvalue->date == '2023-05-25') {
DB::table('attendances')->where('employee_name',$noofdaysaspertimesheetvalue->created_by)

->where('month','May')->update([	
      'twentyfive'         =>     $total,
        ]);
}

   
            }
   }
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	public function scheduler () {
        
        $exitCode = Artisan::call('command:reminder')->daily(); 
        $exitCode = Artisan::call('command:taskreminder')->daily()->withoutOverlapping(); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	public function birthdayReminder () {
        
        $exitCode = Artisan::call('command:birthdayreminder')->daily(); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	public function timesheetDuplicate () {
        
        $exitCode = Artisan::call('demo:cron')->daily(); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	public function UpdateAttendance()
  {

    $exitCode = Artisan::call('attendance:update')->monthlyOn(26, '14:30')->emailOutputTo('mohdsuhail@capitall.io');

    return  redirect('/');

    //  dd($exitCode);
    // return what you want
  }
	 public function outstandingReminder () {
        
        $exitCode = Artisan::call('command:outstandingreminder')->daily(); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	 public function invoiceReminder () {
        
        $exitCode = Artisan::call('command:invoicereminder')->daily(); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	 public function timesheetreminder () {
        
        $exitCode = Artisan::call('command:timesheetreminder')->daily(); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	 public function holidayReminder () {
        
        $exitCode = Artisan::call('command:holidayreminder')->daily(); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index');
    }
	public function candidateonboardingFormKgs()
  {
    return view('candidateonboarding-kgs');
  }
  public function candidateonboardingFormInternKgs()
  {
    return view('Interncandidateonboarding-kgs');
  }
	
  public function candidateonboardingFormCapitall()
  {
    return view('candidateonboarding-capitall');
  }
  public function candidateonboardingFormKgsAdvisors()
  {
    return view('candidateonboarding-kgsadvisors');
  }
  public function candidateonboardingFormWomennovator()
  {
    return view('candidateonboarding-womennovator');
  }

  public function candidateonboardingFormInternCapitall()
  {
    return view('Interncandidateonboarding-capitall');
  }
  public function candidateonboardingFormInternKgsAdvisors()
  {
    return view('Interncandidateonboarding-kgsadvisors');
  }
  public function candidateonboardingFormInternWomennovator()
  {
    return view('Interncandidateonboarding-womennovator');
  }


  
    public function store(Request $request)
    {
		//dd($request);
        $request->validate([
            'resume' => "required",
             'marksheet_x' => "required",
             'marksheet_xii' => "required",
       ]);

         try {
			  $draftemails = DB::table('draftemails')->where('email',$request->personal_email)->first();
             $data=$request->except(['_token','two_residence_proof','payslip']);
             if($request->hasFile('resume'))
             {
                          $file=$request->file('resume');
                          $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                               $data['resume'] = $name;
             }
             if($request->hasFile('nda'))
             {
                      $file=$request->file('nda');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['nda'] = $name;
             }
             if($request->hasFile('marksheet_x'))
             {
                      $file=$request->file('marksheet_x');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['marksheet_x'] = $name;
             }
             if($request->hasFile('marksheet_xii'))
             {
                      $file=$request->file('marksheet_xii');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['marksheet_xii'] = $name;
             }
             if($request->hasFile('bachelor_degree'))
             {
                      $file=$request->file('bachelor_degree');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['bachelor_degree'] = $name;
             }
             if($request->hasFile('master_degree'))
             {
                      $file=$request->file('master_degree');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['master_degree'] = $name;
             }
             if($request->hasFile('marksheet_ipcc'))
             {
                      $file=$request->file('marksheet_ipcc');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['marksheet_ipcc'] = $name;
             }
             if($request->hasFile('ca_final'))
             {
                      $file=$request->file('ca_final');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['ca_final'] = $name;
             }
             if($request->hasFile('membership_certificate'))
             {
                      $file=$request->file('membership_certificate');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['membership_certificate'] = $name;
             }
             if($request->hasFile('addidation_qualification'))
             {
                      $file=$request->file('addidation_qualification');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['addidation_qualification'] = $name;
             }
             if($request->hasFile('relieving_letter'))
             {
                      $file=$request->file('relieving_letter');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['relieving_letter'] = $name;
             }
             if($request->hasFile('pancard'))
             {
                      $file=$request->file('pancard');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['pancard'] = $name;
             }
             if($request->hasFile('photograph'))
             {
                      $file=$request->file('photograph');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['photograph'] = $name;
             }
   if($request->hasFile('offerappointmentletter'))
             {
                      $file=$request->file('offerappointmentletter');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['offerappointmentletter'] = $name;
             }
			   if($request->hasFile('payslipsone'))
             {
                      $file=$request->file('payslipsone');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['payslipsone'] = $name;
             }
			   if($request->hasFile('payslipstwo'))
             {
                      $file=$request->file('payslipstwo');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['payslipstwo'] = $name;
             }
			   if($request->hasFile('payslipsthree'))
             {
                      $file=$request->file('payslipsthree');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['payslipsthree'] = $name;
             }
			   if($request->hasFile('residence_prooftwo'))
             {
                      $file=$request->file('residence_prooftwo');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['residence_prooftwo'] = $name;
             }
			   if($request->hasFile('residence_proofone'))
             {
                      $file=$request->file('residence_proofone');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['residence_proofone'] = $name;
             }
			 if($request->hasFile('pfformupload'))
             {
                      $file=$request->file('pfformupload');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['pfformupload'] = $name;
             }
			  if($request->hasFile('outupload'))
             {
                      $file=$request->file('outupload');
                      $name = time().$file->getClientOriginalName();
                          $path = $file->storeAs('candidateonboarding',$name,'s3');
                          $data['outupload'] = $name;
             }
			   $data['role'] =  $draftemails->role_id;
			$data['department']  = $draftemails->department_id;
			$data['dateofjoining'] =  $draftemails->joiningdate;
			 $data['designation'] =  $draftemails->designation;
             $candidateonboarding = Candidateonboarding::Create($data);
               $data = array(
                'name' => $request->your_full_name ??'',
                'email' => $request->personal_email ??'',
          );
           Mail::send('emails.candidateform', $data, function ($msg) use($data){
               $msg->to('priyankasharma@kgsomani.com','deepikajaiswal@kgsomani.com');
               $msg->subject('Onboarding Documents');
            }); 
             $output = array('msg' => 'Submit Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
 }
	 public function articleonboardingForm()
 {
     return view('articleonboarding');
 }
 public function articlestore(Request $request)
  {
    //  $request->validate([
    //      'resume' => "required",
    //       'marksheet_x' => "required",
    //       'marksheet_xii' => "required",
    // ]);
    //dd($request);
    try {
      $draftemails = DB::table('draftemails')->where('email', $request->emailid)->first();

      $data = $request->except(['_token', 'previous_organization_form', 'date_of_leaving', 'date_of_joining']);
      //  dd($data);
      if ($request->hasFile('document10th')) {
        $file = $request->file('document10th');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['document10th'] = $name;
      }
      if ($request->hasFile('document12th')) {
        $file = $request->file('document12th');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['document12th'] = $name;
      }
      if ($request->hasFile('bcomcertificate')) {
        $file = $request->file('bcomcertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['bcomcertificate'] = $name;
      }
      if ($request->hasFile('noc')) {
        $file = $request->file('noc');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['noc'] = $name;
      }
      if ($request->hasFile('cptcertificate')) {
        $file = $request->file('cptcertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['cptcertificate'] = $name;
      }
      if ($request->hasFile('ipcccertificate')) {
        $file = $request->file('ipcccertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['ipcccertificate'] = $name;
      }
      if ($request->hasFile('ipcccertificatetwo')) {
        $file = $request->file('ipcccertificatetwo');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['ipcccertificatetwo'] = $name;
      }
      if ($request->hasFile('octrainingcertificate')) {
        $file = $request->file('octrainingcertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['octrainingcertificate'] = $name;
      }
      if ($request->hasFile('itttrainingcertificate')) {
        $file = $request->file('itttrainingcertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['itttrainingcertificate'] = $name;
      }
      if ($request->hasFile('residenceproof')) {
        $file = $request->file('residenceproof');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['residenceproof'] = $name;
      }
      if ($request->hasFile('residenceprooftwo')) {
        $file = $request->file('residenceprooftwo');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['residenceprooftwo'] = $name;
      }
      if ($request->hasFile('pancard')) {
        $file = $request->file('pancard');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['pancard'] = $name;
      }
      if ($request->hasFile('aadharcard')) {
        $file = $request->file('aadharcard');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['aadharcard'] = $name;
      }
      if ($request->hasFile('photograph')) {
        $file = $request->file('photograph');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['photograph'] = $name;
      }
      if ($request->hasFile('copyof')) {
        $file = $request->file('copyof');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['copyof'] = $name;
      }
      if ($request->hasFile('copyoftwo')) {
        $file = $request->file('copyoftwo');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['copyoftwo'] = $name;
      }
      if ($request->hasFile('additional')) {
        $file = $request->file('additional');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['additional'] = $name;
      }
      if ($request->hasFile('bachelorattached')) {
        $file = $request->file('bachelorattached');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['bachelorattached'] = $name;
      }
      $data['role'] =  $draftemails->role_id;
      $data['department']  = $draftemails->department_id;
      $data['doj'] =  $draftemails->joiningdate;
      $data['designation'] =  $draftemails->designation;
      $articleonboarding = Articleonboarding::Create($data);
      $articleonboarding->save();
      $id = $articleonboarding->id;
      //   dd($id);
      if ($request->previous_organization_form[0] != null) {
        $count = count($request->previous_organization_form);
        // dd($count);
        for ($i = 0; $i < $count; $i++) {
          DB::table('articletrainingdetails')->insert([
            'articleonboarding_id'     =>     $id,
            'previous_organization_form'     =>     $request->previous_organization_form[$i],
            'date_of_joining'     =>     $request->date_of_joining[$i],
            'date_of_leaving' =>  $request->date_of_leaving[$i],
            'created_at'          =>     date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
          ]);
        }
      }
      $data = array(
        'name' => $request->name ?? '',
        'email' => $request->emailid ?? '',
      );
      Mail::send('emails.articlemailform', $data, function ($msg) use ($data) {
        $msg->to('priyankasharma@kgsomani.com', 'deepikajaiswal@kgsomani.com');
        $msg->subject('Onboarding Documents/Articleship Training');
      });
      $output = array('msg' => 'Submit Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
}
