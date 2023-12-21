<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staffappointmentletter;
use App\Models\Teammember ;
use DB;
use Redirect;
use Illuminate\Support\Facades\Mail;

class StaffappointmentletterController extends Controller
{	
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(auth()->user()->teammember_id == 160 or auth()->user()->teammember_id == 157 or auth()->user()->teammember_id == 155
		 or auth()->user()->teammember_id == 447 or auth()->user()->teammember_id == 556  ){
    $staffappointmentData = DB::table('staffappointmentletters')
    ->leftjoin('teammembers','teammembers.id','staffappointmentletters.teammember_id')
    ->leftjoin('roles','roles.id','teammembers.role_id')
    ->leftjoin('companydetails','companydetails.id','staffappointmentletters.organization')
    ->select('staffappointmentletters.*','teammembers.team_member','teammembers.emailid','roles.rolename','companydetails.company_name')->get();
        
     return view('backEnd.staffappointmentletter.index',compact('staffappointmentData'));
   }
		  
        abort(403, ' you have no permission to access this page ');
  }
   public function create(Request $request)
 {
    $teammember = Teammember::where('role_id','!=',11)->where('status',1)
             ->where('role_id','!=',12)->with('title','role')->get();
    $organization = DB::table('companydetails')->get();
  //  dd($organization);
  return view('backEnd.staffappointmentletter.create',compact('teammember','organization'));
     
 } 
    public function store(Request $request)
    { 
     //   dd($request);
        
        try {
           
             DB::table('staffappointmentletters')->insertGetId([	
              'teammember_id'   =>  $request->teammember_id,
              'appointmentletterdate'  =>  $request->appointmentletterdate,
              'designation'  =>  $request->designation,
              'employeeeffectivedate'  =>  $request->employeeeffectivedate,
              'organization'  =>  $request->organization,
              'location'  =>  $request->location,
              'salary'  =>  $request->salary,
              'salaryremarks'  =>  $request->salaryremarks,
              'noticeperiod'  =>  $request->noticeperiod,
              'createdby'         =>     auth()->user()->teammember_id,
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);
           
            $output = array('msg' => 'Create Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
}


public function staffappointmentView($id)
{
    $teammember = DB::table('staffappointmentletters')
      ->leftjoin('teammembers','teammembers.id','staffappointmentletters.teammember_id')
   ->where('staffappointmentletters.id',$id)
      ->select('staffappointmentletters.*','teammembers.team_member','teammembers.permanentaddress','teammembers.communicationaddress')->first();
	
     //    dd($staffappointmentData);
     return view('backEnd.staffappointmentletter.view', compact('id','teammember'));
}

public function edit($id)
{
 
    $teammember = Teammember::where('role_id','!=',11)->where('status',1)
    ->where('role_id','!=',12)->with('title','role')->get();
    $organization = DB::table('companydetails')->get();
    $staffappointment = Staffappointmentletter::where('id', $id)->first();
  //  dd($neft);
  
    return view('backEnd.staffappointmentletter.edit', compact('teammember','staffappointment','organization'));
}

public function update(Request $request, $id)
    {
  // dd($request);
        try  {
            $data=$request->except(['_token']);
  
    DB::table('staffappointmentletters')->where('id',$id)->update([	
      
      'teammember_id'   =>  $request->teammember_id,
      'appointmentletterdate'  =>  $request->appointmentletterdate,
      'designation'  =>  $request->designation,
      'employeeeffectivedate'  =>  $request->employeeeffectivedate,
      'organization'  =>  $request->organization,
      'location'  =>  $request->location,
      'salary'  =>  $request->salary,
      'salaryremarks'  =>  $request->salaryremarks,
      'noticeperiod'  =>  $request->noticeperiod,
      'updatedby'         =>     auth()->user()->teammember_id,
       'updated_at'              =>    date('Y-m-d H:i:s'),

  ]);  

         $output = array('msg' => 'Updated Successfully');
         return redirect('staffappointmentletter')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
     public function destroy($id)
   {
  
    //  dd($id);
    try {
      Staffappointmentletter::destroy($id);
        $output = array('msg' => 'Deleted Successfully');
        return redirect('staffappointmentletter')->with('statuss', $output);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}
	public function mailVerify(Request $request)
{
  //if ($request->ajax()) {
   // dd($request);
    $staffappointment = DB::table('staffappointmentletters')
    ->leftjoin('teammembers','teammembers.id','staffappointmentletters.teammember_id')
    ->leftjoin('roles','roles.id','teammembers.role_id')
    ->leftjoin('companydetails','companydetails.id','staffappointmentletters.organization')
    ->where('staffappointmentletters.id',$request->id)
    ->select('staffappointmentletters.*','teammembers.team_member','teammembers.emailid','roles.rolename','companydetails.company_name')->first();
     
    
   // dd($staffappointmentData);
    $data = array(
      'teammember' => $staffappointment->emailid ??'',
      'name'        =>$staffappointment->team_member ??'',
      'id' => $staffappointment->teammember_id ??''   
    );

$a=Mail::send('emails.StaffappointmentletterMail', $data, function ($msg) use($data){
  $msg->to($data['teammember']);
  $msg->cc(['priyankasharma@kgsomani.com']);
  $msg->subject('E-Verify | Appointment Letter');
});
  DB::table('staffappointmentletters')->where('id',$request->id)->update(['e_verify'=>1]);

  $output = array('msg' => 'Mail Send Successfully');
  return Redirect::back()->with('success', $output);

  

      // }

}

}
