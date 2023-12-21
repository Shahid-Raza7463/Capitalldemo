<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Assetticket;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
class NotificationController extends Controller
{
   
     public function notificationList(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'roleid' => 'required',
        // ]);

  
        // if ($validator->fails()) {
        //     $response['msg'] = $validator->errors();
        //     $response['status'] = 0;
        
        //     return  response()->json($response);
        // }
            try {
                if ($request->roleid == 13){

                    $result =  DB::table('notifications')
                    ->leftjoin('teammembers','teammembers.id','notifications.created_by')
                  ->leftjoin('notificationtargets','notificationtargets.notification_id','notifications.id')
                  ->Where('targettype','3')->orWhere('targettype','2')
                  ->orwhere('notificationtargets.teammember_id',$request->teammemberid)
                  ->select('notifications.title','notifications.created_at','teammembers.team_member')->get();
                }
                else {
                    $result = DB::table('notifications')
                    ->leftjoin('teammembers','teammembers.id','notifications.created_by')
                    ->leftjoin('notificationtargets','notificationtargets.notification_id','notifications.id')
                    ->where('notifications.targettype','2')
                    ->orwhere('notificationtargets.teammember_id',$request->teammemberid)
                      ->select('notifications.title','notifications.created_at','teammembers.team_member')->get();
                }

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
