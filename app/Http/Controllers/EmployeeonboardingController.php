<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Employeeonboarding;
use App\Models\Teammember;
use App\Models\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Redirect;
class EmployeeonboardingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function sendMailform(Request $request,$id="")
  {
    $employeeonboarding=DB::table('employeeonboardings')->find($id);
    //dd(   $employeeonboarding);
    return view('backEnd.employeeonboarding.mail',compact('employeeonboarding','id'));
  }
 public function sendMailPreview(Request $request,$id="")
  {
   // dd($request);
    $data=$request->except(['_token']);
			  
    $teammember=DB::table('employeeonboardings')->find($id);
   // dd($teammember);
    if($request->has('photograph'))
    { 
        if($request->hasFile('photograph'))
        {
            $file=$request->file('photograph');
                $destinationPath = 'backEnd/image/photograph';
                $name = $file->getClientOriginalName();
               $s = $file->move($destinationPath, $name);
                     //  dd($s); die;
                     $data['photograph'] = $name;
           
        }
    }
    else
    {
        $data['photograph'] = $teammember->photograph ??'';

    }
  
  //  dd($data['photograph']);
    $data['employeeonboarding_id']=$id;
    $data['status']=1;
    $data['created_at']=date('y-m-d');
    $data['updated_at']= date('y-m-d');
    $employee =  DB::table('employeeonboardingmail')->insertGetId($data);
    $employeeonboarding=DB::table('employeeonboardingmail')->find($employee);
   // dd($employeeonboarding);
  return view('backEnd.employeeonboarding.mailpreview',compact('employeeonboarding','id'));
  }
 
public function sendMail(Request $request,$id="")
  {

 //  dd($request);
   DB::table('employeeonboardingmail')->where('id',$request->id)
   ->update([
    'content'=>$request->content,
   //'mail_status'=>1
  ]);

   $employeeonboarding=DB::table('employeeonboardingmail')->find($request->id);
   //dd($employeeonboarding);
     
    if($employeeonboarding->gender=="Female")
    $gender="Ms.";
    else
    $gender="Mr.";
   // dd($gender);

   $emails=Teammember::select('emailid')->where('status','=',1)
	  // ->where('id',336)->orwhere('id',170)
	   ->get()->pluck('emailid');
  // dd($emails);
    foreach($emails as $email )
    {
  
    $data = array(
        'teammember' => $email ??'',
        'content'   =>$request->content,
       'name'        =>$employeeonboarding->name ??'',
        'gen'           =>$gender ??'',

        //'id' => $staffappointment->teammember_id ??''   
      );
  //dd($data);
     Mail::send('emails.interoductionMail', $data, function ($msg) use($data){
        $msg->to($data['teammember']);
       // $msg->cc(['priyankasharma@kgsomani.com']);
        $msg->subject('Welcome to KGS || '.$data['gen']." ".$data['name']);
      });
    }
    DB::table('employeeonboardings')->where('id',$request->emp_id)
    ->update([
    // 'content'=>$request->content,
    'mail_status'=>1
   ]);
 
    
   //   dd($a);
      $output = array('msg' => 'Mail Send Successfully');
    return Redirect::route('employeeonboarding')->with('success', $output);

  }
    public function index(Request $request)
    {
		 if(auth()->user()->teammember_id == 427 || auth()->user()->teammember_id == 74 || auth()->user()->teammember_id == 48 ){
			    $employeeonboardingDatas  = DB::table('employeeonboardings')
          ->leftjoin('roles','roles.id','employeeonboardings.role')
			  ->select('employeeonboardings.*','roles.rolename')->get();
     // dd($employeeonboardingDatas);
       return view('backEnd.employeeonboarding.otherindex',compact('employeeonboardingDatas'));
		 }
		elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 18 || auth()->user()->teammember_id == 155){
          $employeeonboardingDatasManager  = DB::table('employeeonboardings')
			     ->leftjoin('roles','roles.id','employeeonboardings.role')
                  ->whereNotIn('employeeonboardings.role', [15, 19])
			  ->select('employeeonboardings.*','roles.rolename')->orderBy('employeeonboardings.dateofjoining','desc')->get();

              $employeeonboardingDatasStaff  = DB::table('employeeonboardings')
              ->leftjoin('roles','roles.id','employeeonboardings.role')
              ->where('employeeonboardings.role',15)
           ->select('employeeonboardings.*','roles.rolename')->orderBy('employeeonboardings.dateofjoining','desc')->get();

           $employeeonboardingDatasIntern  = DB::table('employeeonboardings')
           ->leftjoin('roles','roles.id','employeeonboardings.role')
           ->where('employeeonboardings.role',19)
        ->select('employeeonboardings.*','roles.rolename')->orderBy('employeeonboardings.dateofjoining','desc')->get();
     // dd($employeeonboardingDatas);
         return view('backEnd.employeeonboarding.index',compact('employeeonboardingDatasManager','employeeonboardingDatasStaff','employeeonboardingDatasIntern'));
		}
		else{
			  $employeeonboardingDatasManager  = DB::table('employeeonboardings')
          ->leftjoin('roles','roles.id','employeeonboardings.role')
          ->where('employeeonboardings.role',14)
			  ->select('employeeonboardings.*','roles.rolename')->orderBy('employeeonboardings.dateofjoining','desc')->get();

              $employeeonboardingDatasStaff  = DB::table('employeeonboardings')
              ->leftjoin('roles','roles.id','employeeonboardings.role')
              ->where('employeeonboardings.role',15)
                  ->select('employeeonboardings.*','roles.rolename')->orderBy('employeeonboardings.dateofjoining','desc')->get();

                  $employeeonboardingDatasIntern  = DB::table('employeeonboardings')
                  ->leftjoin('roles','roles.id','employeeonboardings.role')
                  ->where('employeeonboardings.role',19)
                      ->select('employeeonboardings.*','roles.rolename')->orderBy('employeeonboardings.dateofjoining','desc')->get();
        
         return view('backEnd.employeeonboarding.otherindex',compact('employeeonboardingDatasManager','employeeonboardingDatasStaff','employeeonboardingDatasIntern'));
		}
		

  }
	  public function capitallcred(Request $request)
  {
    if ($request->ajax()) {
      //  dd($request);
         if (isset($request->id)) {

          $id=DB::table('employeeonboardings')->where('id',$request->id)->first();
          return response()->json($id);

         }
        }
   
  }

public function sendcapitallcred(Request $request)
  {
    
    $email = DB::table('employeeonboardings')->where('id', $request->teamid)
      ->pluck('personal_email')->first();
     
    $teammember = DB::table('teammembers')->where('personalemail', $email)->first();
    
    if ($teammember) {
      $password = mt_rand(10000,99999);
      $hashed = Hash::make($password);
      

      DB::table('users')->insert([
        'teammember_id' => $teammember->id,
        'role_id' => $teammember->role_id,
        'email' => $request->email,
        'password' => $hashed,
        'status' => 1,
        'created_at'          =>     date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
      ]);

      DB::table('teammembers')->where('personalemail', $email)->update([
        'emailid' => $request->email,

      ]);

      $data = array(
        'subject' => "Capitall Login Credentials",
        'name' =>   $teammember->team_member,
        'email' =>   $email,
        'username' => $request->email,
        'password' => $password,

      );
      $mail = Mail::send('emails.capitallcred', $data, function ($msg) use ($data) {
        $msg->to($data['email']);
        $msg->subject($data['subject']);
      });
      DB::table('employeeonboardings')->where('id', $request->teamid)->update(['cred_status' => 1]);
    } else {
      $candidateonboarding = DB::table('employeeonboardings')->where('id', $request->teamid)
        ->first();

      /*andidateonboarding);

      DB::table('teammembers')->insert([ 
        'team_member' =>$candidateonboarding->your_full_name,
        'personalemail' =>$candidateonboarding->personal_email,
        'employment_status'=>$candidateonboarding->department,
        'mobile_no'=>$candidateonboarding->phoneno,
        'department'=>$candidateonboarding->department,
        'fathername'=>$candidateonboarding->father_name,
        'dateofbirth'=>$candidateonboarding->dateofbirth,
        'pancardno'=>$candidateonboarding->pancard,
        'emergencycontactnumber' =>$candidateonboarding->emergency_contact_number,
        'profilepic' =>$candidateonboarding->photograph,
        'adharcardnumber'=>$candidateonboarding->adharcardno,
        'nameofbank' =>$candidateonboarding->bank_name,
        'bankaccountnumber' =>$candidateonboarding->account_number,
        'ifsccode' =>$candidateonboarding->ifsc_code,
        'mothername'=>$candidateonboarding->mother_name,
        'mothernumber'=>$candidateonboarding->mothecontactno,
        'fathernumber'=>$candidateonboarding->fathercontactno,
        'role_id' =>$candidateonboarding->role,
         'designation' =>$candidateonboarding->designation,
          'communicationaddress' =>$candidateonboarding->currentaddress,
          'permanentaddress' =>$candidateonboarding->permanentaddress,
          'joining_date'=>$candidateonboarding->dateofjoining,
          'qualification'=>$candidateonboarding->highestqualification,
        'status' => '1', 
        'created_at' => date('y-m-d'), 
        'updated_at' => date('y-m-d')
    ]); 
*/
      $output = array('msg' => 'Something Went wrong');
      return back()->with('success', $output);
    }
    $output = array('msg' => 'Capitall Credentials Send Successfully');
    return back()->with('success', $output);
    //return Redirect->back()->with('success', $output);

  }

 
}
