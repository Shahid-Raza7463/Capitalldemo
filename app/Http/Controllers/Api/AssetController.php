<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Teammember;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
class AssetController extends Controller
{
   
    public function assetList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teammemberid' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
              $result =  DB::table('assets')
              ->leftjoin('financerequests','financerequests.id','assets.financerequest_id')->
              where('assets.teammember_id',$request->teammemberid)
              ->select('financerequests.modal_name','financerequests.sno','financerequests.assetstatus',
              'financerequests.description','financerequests.kgs')->get();

              if($result->isEmpty()){
             
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
     public function assetassignList(Request $request)
    {
            try {
              $result = DB::table('financerequests')
              ->leftjoin('teammembers','teammembers.id','financerequests.teammemberid')->
              select('financerequests.modal_name',
              'financerequests.sno','financerequests.company_name',
              'financerequests.assetstatus','financerequests.status',
              'financerequests.kgs','teammembers.team_member')->get();
              foreach($result as $res)
              {
              
                  if($res->status == 1)
                  {
                    $res->status = "Approved";
                  }
                  else if($res->status == 2)
                  {
                    $res->status = "Reject";
                  }
                  else{
                    $res->status = "Pending"; 
                  }
            }
              if($result->isEmpty()){
             
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
