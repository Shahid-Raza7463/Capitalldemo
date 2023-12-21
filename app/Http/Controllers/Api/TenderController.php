<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Tender;
use App\Models\Teammember;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
class TenderController extends Controller
{
  
    public function tenderDetails(Request $request)
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
              $role = Teammember::where('id', $request->teammemberid)->pluck('role_id')->first();
                if($role == 11){
              $result = Tender::latest()->get();
                }
                else {
                    $result = Tender::where('teammember_id',$request->teammemberid)->get();
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
