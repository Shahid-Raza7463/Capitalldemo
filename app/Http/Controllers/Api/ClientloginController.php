<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teammember;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
use Image;
use Hash;
use Illuminate\Support\Facades\Mail;
class ClientloginController extends Controller
{
   
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
                $result =   DB::table('clientlogins')->where('email', $request->email)->first();
if (!$result) {
    return response()->json(["msg"=>"Oops! You have entered invalid email","code" =>"404","status" =>"false"]);
 }
 if (!Hash::check( $request->password, $result->password)) {
    return response()->json(["msg"=>"Oops! You have entered invalid password","code" =>"404","status" =>"false"]);
 }
                if (Auth::guard('clientlogin')->attempt(['email' => request('email'), 'password' => request('password')])) {
                    $result = DB::table('clientlogins')->where('email', $request->email)->first();
                  
                 
                    $otp = sprintf("%06d", mt_rand(1,999999));
                  
                    $data = array(
                        'otp' =>  $otp,
                         'email' => $result->email,
                );
               
                 Mail::send('emails.clientotp', $data, function ($msg) use($data){
                     $msg->to($data['email']);
                     $msg->subject('kgs Otp Verify');
                  });
                
                  $result->otp = $otp;
                  return response()->json(["output" => $result,"status" =>"true","code" =>"10001"]);
          }
          else {
            return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
          }
         

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
    public function otpResend(Request $request)
 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
                $resultt =   DB::table('clientlogins')->where('email', $request->email)->first();
                if (!$resultt) {
                    return response()->json(["msg"=>"Oops! You have entered invalid email","code" =>"404","status" =>"false"]);
                 }
                $otp = sprintf("%06d", mt_rand(1,999999));
                  
                $data = array(
                    'otp' =>  $otp,
                     'email' => $resultt->email,
            );
           
             Mail::send('emails.clientotp', $data, function ($msg) use($data){
                 $msg->to($data['email']);
                 $msg->subject('kgs Otp Verify');
              });
            
              $result['otp'] = $otp;
              if(is_null($result)){
             
                return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                          }
          else {
            return response()->json(["output" => $result,"status" =>"true","code" =>"10001"]);
          }
         

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
    
}
