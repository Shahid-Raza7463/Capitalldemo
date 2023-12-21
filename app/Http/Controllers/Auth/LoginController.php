<?php

namespace App\Http\Controllers\Auth;
use App\Notifications\TwoFactorCode;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use Auth;
use Crypt;
use Hash;
use Illuminate\Support\Facades\Mail;
class LoginController extends Controller
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	function authenticated(Request $request, $user)
    {
		 $user->generateTwoFactorCode();
    $user->notify(new TwoFactorCode());
          DB::table('userloginactiviteies')->insert([
    'teammember_id' => auth()->user()->teammember_id, 
    'ip_address' => $request->getClientIp(),
    'lastlogindateandtime' => Carbon::now()->toDateTimeString(),
    'created_at' => date('y-m-d'),     
    'updated_at' => date('y-m-d')       
]);
	\Auth::logoutOtherDevices(request('password'));	
    }
	 public function maxAttempts()
{
    //Lock out on 5th Login Attempt
    return 4;
}

public function decayMinutes()
{
    //Lock for 1 minute
    return 1;
}
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
  //   public function index()
//    {
  //      return view('auth.login');
//    }
	public function forgetPassword()
    {
        return view('auth.passwords.authreset');
    }
    public function newPassword($id)
    {
		   $user = User::where('passwordResetToken', $id)->where('passwordResetExpiresAt', '>', Carbon::now())->first();
//dd($user);
        if (!$user) {
            $output = array('msg' => 'The password reset link is expired.');
            return redirect('/')->with('status', $output);
        }
		
        return view('auth.passwords.confirm',compact('id'));
    }
    public function passwordStore(Request $request, $id = '')
    {
      //  dd($id);
          $request->validate([
           'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
          ]);
  
          try {
               DB::table('users')->where('passwordResetToken',$id)->update([ 
                  'password'         =>  Hash::make($request->password) ,
                  'updated_at'         => date("Y-m-d"),
				    'passwordResetToken'         => '',
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
     public function index()
    {
        return view('auth.loginaccess');
    }
	   public function authforgetpasswordStore(Request $request)
    { 
        $request->validate([
            'email' => "required|string|email"
        ]);

        try {
            $authid =   DB::table('users')->where('email', $request->email)->where('status','1')->first();
            if ($authid == true) {
				
				     $user = User::find($authid->id);
           
                $user->passwordResetToken = Str::random(60);
            
               
                // Set the expiration time for the password reset token.
                $user->passwordResetExpiresAt = Carbon::now()->addMinutes(60);
            
              //  dd($user->passwordResetExpiresAt);
                // Save the user with the new password reset token and expiration time.
                $user->save();
            
                // Generate the password reset URL.
                $url = $user->passwordResetToken;
				
                $data = array(
                    'id' =>  $authid->id,
                     'email' => $authid->email,
					  'url' => $url,
            );
           
             Mail::send('emails.clientpasswordreset', $data, function ($msg) use($data){
                 $msg->to($data['email']);
                 $msg->subject('VSA Password Reset');
              });
             
              $output = array('msg' => 'Reset Password link send to your email please check');
              return redirect('authforgetpassword')->with('status', $output);
            } else {
                $output = array('msg' => 'Oops! You have entered invalid email');
                return redirect('authforgetpassword')->with('status', $output);
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
      protected function credentials(Request $request)
{        
    $role = Role::select('id')->get();
   return ['email' => $request->email, 'password' => $request->password, 'status' => 1,'role_id'  => $role ];

}
}
