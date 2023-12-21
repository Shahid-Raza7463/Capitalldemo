<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Teammember;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
class TeammemberController extends Controller
{
   

    public function teammemberList(Request $request)
    {
      
            try {
              $result =  DB::table('teammembers')
              ->leftjoin('roles','roles.id','teammembers.role_id')
              ->select('teammembers.team_member','roles.rolename',
              'teammembers.id')->get();
           
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
