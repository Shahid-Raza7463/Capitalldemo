<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Admin;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Crypt;
use Hash;
use Illuminate\Support\Facades\Mail;
use DB;
use App\Models\Studentlogin;
use Carbon\Carbon;
class StudentLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
//    use AuthenticatesUsers;
    public function __construct()
    {

        $this->middleware('guest:studentlogin')->except('logout');
    }
 public function logout(Request $request){
      // dd($request);
      Auth::guard('studentlogin')->logout();
               
    $request->session()->flush();

    $request->session()->regenerate();

    return Redirect('/student/login');
     
    }
    
  public function studentloginForm()
    {
        return view('auth.studentlogin');
    }

  public function studentregisterForm()
    {
        return view('auth.studentregister');
    }

	  public function forgetPassword()
    {
        return view('auth.passwords.reset');
    }

    public function newPassword($id)
    {
        return view('auth.passwords.confirm',compact('id'));
    }

    public function passwordStore(Request $request, $id = '')
    {
      //  dd($id);
          $request->validate([
              'password' => 'required|string',
              'confirm_password' => 'required|same:password|min:8|string',
          ]);
  
          try {
            $id = Crypt::decrypt($id); 
              DB::table('clientlogins')->where('id',$id)->update([ 
                  'password'         =>  Hash::make($request->password) ,
                  'updated_at'         => date("Y-m-d"),
                  ]);
                  $output = array('msg' => 'Password Updated Successfully Please signin to continue');
                  return redirect('/')->with('status', $output);
          } catch (Exception $e) {
              DB::rollBack();
              Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
              report($e);
              $output = array('msg' => $e->getMessage());
              return back()->withErrors($output)->withInput();
          }
      }
    public function forgetpasswordStore(Request $request)
    { 
        $request->validate([
            'email' => "required|string|email"
        ]);

        try {
            $clientid =   DB::table('clientlogins')->where('email', $request->email)->first();
            if ($clientid == true) {
                $data = array(
                    'id' =>  $clientid->id,
                     'email' => $clientid->email,
            );
           
             Mail::send('emails.clientpasswordreset', $data, function ($msg) use($data){
                 $msg->to($data['email']);
                 $msg->subject('Capitall Password Reset');
              });
             
              $output = array('msg' => 'Reset Password link send to your email please check');
              return redirect('forgetpassword')->with('status', $output);
            } else {
                $output = array('msg' => 'Oops! You have entered invalid email');
                return redirect('forgetpassword')->with('status', $output);
            }
            

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

public function studentlogin(Request $request)
{
 // dd($request);
  $request->validate([
      'email' => ['required', 'string', 'email', 'max:255'],
      'password' => ['required', 'string', 'min:8'],
  ]);
  
$user =   DB::table('studentlogins')->where('email', $request->email)->first();
//dd($user);
if (!$user) {
return redirect()->back()->with('error', 'Oops! You have entered invalid email');
}
if (!Hash::check( $request->password, $user->password)) {
return redirect()->back()->with('error', 'Oops! You have entered invalid password');
}
/*if ( Hash::check( $request->password, $user->password) && $user->status == 1 ) {
//   if ($user->permission == 2 && $user->limitedaccess != 0)
//   {

      $otp = sprintf("%06d", mt_rand(1,999999));
    //  dd($otp);
      $request->session()->put('otp', $otp);
      $request->session()->put('password', $request->password);
      $data = array(
          'otp' =>  $otp,
           'email' => $user->email,
  );
 
   Mail::send('emails.clientotp', $data, function ($msg) use($data){
       $msg->to($data['email']);
       $msg->subject('kgs Otp Verify');
    });
   
      return redirect('studentloginotp/'.Crypt::encrypt($user->id));
      
}*/
  if(Hash::check( $request->password, $user->password) && $user->status == 1){
//  dd('hi');
    
 if (  Auth::guard('studentlogin')->attempt(['email' => $request->email, 'password' => $request->password],$request->remember)) {
    
    return redirect()->intended(route('students.home'));
   }
 }
else{
  return redirect()->back()->with('error', 'Oops! You are inactive users');
}

}
    public function studentloginOtp($id)
    {
      //  dd($id);
        return view('auth.studentloginotp',compact('id'));
    }
//     public function otpResend(Request $request,$id="")
// {
//   //  dd($id);
// 		$id = Crypt::decrypt($id); 
//     $user=DB::table('studentlogins')->where('id',$id)->first();
//     dd($user);
//     $otp = sprintf("%06d", mt_rand(1,999999));
//        $request->session()->put('otp', $otp);
//        $data = array(
//         'otp' =>  $otp,
//          'email' => $user->email,
// );

//  Mail::send('emails.clientotp', $data, function ($msg) use($data){
//      $msg->to($data['email']);
//      $msg->subject('kgs Otp Verify');
//   });
//        return back()->with('alert','otp resend to your mobile number please check');
// }
    
 public function studentotpStore(Request $request)
    {
     //  dd($request);
        $request->validate([
            'otp' => 'required|numeric'
        ]);
        try {
			       $id = Crypt::decrypt($request->id); 
            //    dd($id);
            $mobileno = DB::table('studentlogins')->where('id', $id)->first();
          //  dd($mobileno);
              $otp=$request->otp;
           $otpm = $request->session()->get('otp');
           //    dd($otpm);
           $password = $request->session()->get('password');
           if($otp == $otpm )
            { 
              if(  Auth::guard('studentlogin')->attempt(['email' => $mobileno->email, 'password' => $password],$request->remember))
              //  dd(auth()->user());
             // Auth::login($mobileno);
            //  dd(\Illuminate\Support\Facades\Auth::user());

            //  dd(auth()->user());

            $count = $mobileno->limitedaccess - 1;
                DB::table('studentlogins')->where('id',$id)->update([
                    'limitedaccess' => $count,
                    'updated_at' => date('y-m-d')       
                ]);
             //   dd($count);
             //   dd(auth()->user());
              return redirect()->intended(route('students.home'));
              
            }
            else{
                return back()->with('alert','otp did not match! Please enter valid otp');
             }

           
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function StudentregidterStore(Request $request)
    { 
     //   dd($request);
        $request->validate([
            'name'              =>      'required|string|max:20',
            'email'             =>      'required|email|unique:studentlogins,email',
            'phoneno'           =>      'required|numeric|min:10',
            'password'          =>      'required|alpha_num|min:8|confirmed',
            // 'conform_password'          =>      'required|alpha_num|min:8',
        ]);

        try {

        //   Studentlogin::insertGetId([
        $attemptid = DB::table('studentlogins')->insertGetId([
              'name' =>$request->name,
              'phoneno' =>$request->phoneno,
              'email' =>$request->email,
              'password' =>Hash::make($request->password),
              'status' => '1',
              'created_at'			    =>	   date('y-m-d'),
              'updated_at'              =>    date('y-m-d'),

          ]);
        //  dd($attemptid);
          DB::table('attempts')->insert([ 
            'attempt' => '0',
            'studentid' => $attemptid,
              'created_at'			    =>	   date('y-m-d'),
              'updated_at'              =>    date('y-m-d'),
          ]);

            $output = array('msg' => 'Thanks for Signing up Please Login !');
            return redirect('student/login')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
}