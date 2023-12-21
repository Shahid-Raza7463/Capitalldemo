<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Carbon\Carbon;
class TwoFactorController extends Controller
{
    public function index() 
    {
        return view('auth.twoFactor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = auth()->user();
   $currenttime = Carbon::now();
      if($user->two_factor_expires_at->lt($currenttime))
        {
         //   die;
            $user->resetTwoFactorCode();
        
            auth()->logout();
            $output = array('msg' => 'The two factor code has expired. Please login again.');
            return redirect('/login')->with('status', $output);
        }
        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            $user->resetTwoFactorCode();

            return redirect()->route('home');
        }
        return redirect()->back()
            ->withErrors(['two_factor_code' => 
                'The two factor code you have entered does not match']);

    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('The two factor code has been sent again');
    }
}