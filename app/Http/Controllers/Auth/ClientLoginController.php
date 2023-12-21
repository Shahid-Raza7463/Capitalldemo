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
use Carbon\Carbon;
class ClientLoginController extends Controller
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
        $this->middleware('guest:clientlogin')->except('logout');
    }
public function logout(Request $request){
      // dd($request);
      Auth::guard('clientlogin')->logout();
    
           
    $request->session()->flush();

    $request->session()->regenerate();

    
            return Redirect('/');
    
    }
    public function showloginForm()
    {
        return view('auth.clientlogin');
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
//     public function login(Request $request)
//     {
//      //   dd($request);
//         $request->validate([
//             'email' => ['required', 'string', 'email', 'max:255'],
//             'password' => ['required', 'string', 'min:8'],
//         ]);
//         $clientid =   DB::table('clients')->where('emailid',$request->email)->pluck('id')->first();
//     $accesscount =   DB::table('clientaccess')->where('client_id',$clientid)->pluck('accesscount')->first();
// if ($accesscount == 0) {
//     return redirect()->back()->with('error', 'Your login count expired Please contact to administrator !');
// }
//     if (  Auth::guard('client')->attempt(['emailid' => $request->email, 'password' => $request->password],$request->remember) && $accesscount != 0 ) {
    
     

//         DB::table('clientlogs')->insert([
//             'client_id' => $clientid, 
//             'ip_address' => $request->getClientIp(), 
//             'lastlogindateandtime' => Carbon::now()->toDateTimeString(),
//             'created_at' => date('y-m-d'),     
//             'updated_at' => date('y-m-d')       
//         ]);
        
//         $count = $accesscount - 1;
//         DB::table('clientaccess')->where('client_id',$clientid)->update([
//             'accesscount' => $count,
//             'updated_at' => date('y-m-d')       
//         ]);
//         return redirect()->intended(route('client.home'));

      
   
//     }
//     return redirect()->back()->with('error', 'Oops! You have entered invalid credentials');
//     }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request)
      {
       // dd($request);
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        
$user =   DB::table('clientlogins')->where('email', $request->email)->first();
if (!$user) {
    return redirect()->back()->with('error', 'Oops! You have entered invalid email');
 }
 if (!Hash::check( $request->password, $user->password)) {
    return redirect()->back()->with('error', 'Oops! You have entered invalid password');
 }
    if ( Hash::check( $request->password, $user->password) && $user->status == 1 && $user->twofactorauthentication == 1) {
        if ($user->permission == 2 && $user->limitedaccess != 0)
        {

            $otp = sprintf("%06d", mt_rand(1,999999));
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
         
            return redirect('loginotp/'.Crypt::encrypt($user->id));
          
        }
        elseif ($user->permission == 1) {
          
            $otp = sprintf("%06d", mt_rand(1,999999));
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
         
            return redirect('loginotp/'.Crypt::encrypt($user->id));
        }
    else{
        return redirect()->back()->with('error', 'Your login count expired Please contact to administrator !');
    }
   
    }
    elseif(Hash::check( $request->password, $user->password) && $user->status == 1 && $user->twofactorauthentication == 2){
  // dd($user->twofactorauthentication);
        if (  Auth::guard('clientlogin')->attempt(['email' => $request->email, 'password' => $request->password],$request->remember)) {
           $mobileno = DB::table('clientlogins')->where('email', $request->email)->first();
         //   dd($mobileno);
            DB::table('clientlogs')->insert([
              'client_id' => $mobileno->client_id, 
              'clientlogin_id' => $mobileno->id, 
              'ip_address' => $request->getClientIp(), 
              'lastlogindateandtime' => Carbon::now()->toDateTimeString(),
              'created_at' => date('y-m-d'),     
              'updated_at' => date('y-m-d')       
          ]);
			return redirect()->intended(route('client.home'));
         }
    }
    else{
        return redirect()->back()->with('error', 'Oops! You are inactive users');
    }
   
    }
    public function loginOtp($id)
    {
        return view('auth.loginotp',compact('id'));
    }
    public function otpResend(Request $request,$id="")
{
		$id = Crypt::decrypt($id); 
    $user=DB::table('clientlogins')->where('id',$id)->first();
   // dd($user);
    $otp = sprintf("%06d", mt_rand(1,999999));
       $request->session()->put('otp', $otp);
       $data = array(
        'otp' =>  $otp,
         'email' => $user->email,
);

 Mail::send('emails.clientotp', $data, function ($msg) use($data){
     $msg->to($data['email']);
     $msg->subject('kgs Otp Verify');
  });
       return back()->with('alert','otp resend to your mobile number please check');
}
    public function otpStore(Request $request)
    {
       // dd($request);
        $request->validate([
            'otp' => 'required|numeric'
        ]);
        try {
			       $id = Crypt::decrypt($request->id); 
            $mobileno = DB::table('clientlogins')->where('id', $id)->first();
         //   dd($mobileno);
              $otp=$request->otp;
           $otpm = $request->session()->get('otp');
           $password = $request->session()->get('password');
            if($otp == $otpm )
            {
                Auth::guard('clientlogin')->attempt(['email' => $mobileno->email, 'password' => $password],$request->remember);
                   DB::table('clientlogs')->insert([
            'client_id' => $mobileno->client_id, 
            'clientlogin_id' => $mobileno->id, 
            'ip_address' => $request->getClientIp(), 
            'lastlogindateandtime' => Carbon::now()->toDateTimeString(),
            'created_at' => date('y-m-d'),     
            'updated_at' => date('y-m-d')       
        ]);
            $count = $mobileno->limitedaccess - 1;
                DB::table('clientlogins')->where('id',$id)->update([
                    'limitedaccess' => $count,
                    'updated_at' => date('y-m-d')       
                ]);
              return redirect()->intended(route('client.home'));
              
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
}
