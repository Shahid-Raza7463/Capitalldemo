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
class CalendarController extends Controller
{
  
    public function calendarList(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'teammemberid' => 'required',
        // ]);

  
        // if ($validator->fails()) {
        //     $response['msg'] = $validator->errors();
        //     $response['status'] = 0;
        
        //     return  response()->json($response);
        // }
            try {
              if($request->teammemberid != null){
              $result= DB::table('ganttstaffs')
              ->leftjoin('ganttcharts','ganttcharts.id','ganttstaffs.clientname')
             ->where('ganttstaffs.ganttstaff_id',$request->teammemberid)
              ->select('ganttstaffs.startdate','ganttstaffs.enddate','ganttstaffs.color','ganttcharts.name')->get();
                }

             elseif($request->client != null){
               $result=  DB::table('ganttstaffs')
               ->leftjoin('ganttcharts','ganttcharts.id','ganttstaffs.clientname')
               ->leftjoin('teammembers','teammembers.id','ganttstaffs.ganttstaff_id')
               ->where('ganttcharts.id',$request->client)
               ->select('ganttstaffs.startdate','ganttstaffs.enddate'
               ,'ganttstaffs.color','ganttcharts.name','teammembers.team_member as teammember')->get();
             }
             else{
                $result = DB::table('ganttcharts')
                ->select('id','name')->get();
 
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
