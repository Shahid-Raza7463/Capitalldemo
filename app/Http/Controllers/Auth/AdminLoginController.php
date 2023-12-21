<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Admin;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class AdminLoginController extends Controller
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
        $this->middleware('guest:admin');
    }

    public function showloginForm()
    {
        return view('auth.admin-login');
    }
    public function login(Request $request)
    {
     //   dd($request);
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    if (  Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$request->remember)) {
       return redirect()->intended(route('admin.dashboard'));
    }
    return redirect()->back()->with('error', 'Oops! You have entered invalid credentials');
    }
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
   
}
