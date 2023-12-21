<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\Teammember;
use Image;
class UserController extends Controller
{
	     public function newUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' =>  'required|
                min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
            ,
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
                
              $id = DB::table('teammembers')->insertGetId([
                'role_id' => 15, 
                'team_member' => 'User', 
                'emailid' => $request->email, 
                'created_at' => date('y-m-d'),       
                'updated_at' => date('y-m-d')       
            ]);
           $result = DB::table('users')->insert([
                'teammember_id'   	=>     $id,
                'email'   	=>     $request->email,
                'role_id' => 15, 
                'password'   	=>    Hash::make($request->password),
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
                if(is_null($result)){
                              return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                          }
          else {
            return response()->json(["msg"=>"Submit successfully","status" =>"true","code" =>"10001"]);
          }
         

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
   
    
    public function userUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
                $data=$request->except(['_token']);
                if($request->hasFile('profilepic'))
                {
                    $avatar = $request->file('profilepic');
                    $filename = time().rand(1,100).'.'.$avatar->getClientOriginalExtension();
                    Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
                    $data['profilepic']=$filename;
                }
             
                  $ids = $request->id;
           
              Teammember::find($ids)->update($data);

              $result = DB::table('users')
              ->leftjoin('teammembers','teammembers.id','users.teammember_id')
              ->where('teammembers.id',$request->id)
              ->select('teammembers.*','users.teammember_id')->first();
           
              DB::table('users')->where('teammember_id',$request->id)->update([ 
                'email'         =>  $request->emailid 
                ]);
              $result->profilepic =url('backEnd/image/teammember/profilepic/'.$result->profilepic);

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
                if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
					 DB::table('users')->where('email', $request->email)->update([          
             	
                'fcm'         => $request->fcm
                ]);
                    $result = DB::table('users')
            ->leftjoin('teammembers','teammembers.id','users.teammember_id')
            ->leftjoin('roles','roles.id','teammembers.role_id')
            ->where('teammembers.emailid',$request->email)
            ->select('teammembers.*','users.teammember_id','users.fcm','roles.rolename')->first();
					
			$profilePicPath = asset('backEnd/image/teammember/profilepic/' . $result->profilepic);
			$result->profilepic = $profilePicPath;

					
					$result->officeLat = "28.6415296441173";
					$result->officeLong = "77.23523048248263";
					$result->radiusInMeters = "500";

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
    public function userDetail(Request $request)
 
    {
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
           
        ]);

        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;

            return  response()->json($response);
        }
        try {
            
            $user = DB::table('users')
            ->leftjoin('teammembers','teammembers.id','users.teammember_id')
            ->where('teammembers.id',$request->userid)
            ->select('teammembers.*','users.teammember_id')->first();
          
           $user->profilepic =url('backEnd/image/teammember/profilepic/'.$user->profilepic);
          
            if ($user) {
                $response['output'] = $user;
                $response['status'] = "true";
                $response['code'] = "100001";
            } else {
                $response['code'] = "404";
               $response['status'] = "false";
                $response['msg'] = "data not found";
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
