<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Teammember;
use App\Models\Staffrequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
class StaffrequestController extends Controller
{
   
    public function staffRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ganttchart_id' => 'required',
            'noofstaff' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'teammember_id' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
              $result =  DB::table('staffrequests')->insert([
                'createdby'   	=>     $request->teammember_id,
                'status'   	=>     0,
                'comment'   	=>     $request->comment,
                'noofstaff'   	=>     $request->noofstaff,
                'startdate'   	=>     $request->startdate,
                'enddate'   	=>     $request->enddate,
                'ganttchart_id'   	=>     $request->ganttchart_id,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
                          if(is_null($result)){
                              return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                          }
          else {
            return response()->json(["msg"=>"insert successfully","status" =>"true","code" =>"10001"]);
          }
         

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
	public function taskComplete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'taskid' => 'required',
            'status' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
                
              DB::table('tasks')->where('id',$request->taskid)->update([ 
                  'status'         =>  $request->status ,
                  'remark'         =>  $request->remark ,
                  'updated_at'         =>  date("Y-m-d") 
                  ]);
                  $result =  DB::table('tasks')
                  ->leftjoin('teammembers','teammembers.id','tasks.teammember_id')
                  ->leftjoin('roles','roles.id','teammembers.role_id')
                  ->where('tasks.id',$request->taskid)->
                 select('tasks.taskname','tasks.attachment','tasks.status','tasks.description','tasks.duedate','tasks.remark','teammembers.team_member','roles.rolename')->get();
            //   dd($result);
            foreach($result as $res)
                    {
                      if($res->attachment == null)
                      {
                        
                        $res->attachment = null; 
                      }
                      else {
                        $res->attachment = url('backEnd/image/task/'.$res->attachment);
                      }
                      if($res->status == 0)
                      {
                        $res->status = "pending";
                      }
                      else {
                        $res->status = "completed";
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
    public function staffrequestList(Request $request)
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
              $role = Teammember::where('id', $request->teammemberid)->first();
              if($role->role_id == 11 || $role->id == 23)
              {
                  $result = DB::table('staffrequests')
                  ->leftjoin('ganttcharts','ganttcharts.id','staffrequests.ganttchart_id')
                  ->leftjoin('teammembers','teammembers.id','staffrequests.createdby')
                ->select('staffrequests.*','ganttcharts.name','teammembers.team_member')->get();
              }
          
               else {
                  $result = DB::table('staffrequests')
                  ->leftjoin('ganttcharts','ganttcharts.id','staffrequests.ganttchart_id')
                  ->leftjoin('teammembers','teammembers.id','staffrequests.createdby')
                  ->where('createdby',$request->teammemberid)
                ->select('staffrequests.*','ganttcharts.name','teammembers.team_member')->get();
               } 
        foreach($result as $res)
                {
                  if($res->status == 0)
                  {
                    $res->status = "pending";
                  }
                  elseif($res->status == 1)
                  {
                    $res->status = "approved";
                  }
                  else {
                    $res->status = "reject";
                  }
             
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
