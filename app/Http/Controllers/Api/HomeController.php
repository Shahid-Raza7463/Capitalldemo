<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Assignmentmapping;
use App\Models\Teammember;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;


class HomeController extends Controller
{
  
    public function homeList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roleid' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try { 
                if ($request->roleid == 11) {
                    $result['assignmentpartnercount'] = DB::table('assignmentmappings')
              ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
              ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
              ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
              ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
               
              ->select('assignmentbudgetings.client_id','assignmentbudgetings.assignmentgenerate_id'
              ,'clients.client_name','assignments.assignment_name')
         ->where('assignmentmappings.leadpartner',$request->teammemberid)->distinct()->get()->count();
         $result['notificationpartnercount'] = 0;
				
					$result['teamcount']=count(Teammember::where('status',1)->get());
					
					$result['leavecount'] = 2;
					
						$currentDate = date('d-m-Y');
					$checkinCount = DB::table('checkins')->where('date', $currentDate)->count();
					$result['checkinCount']=$checkinCount;
    				// dd($checkinCount);
					$checkinofficeCount = DB::table('checkins')
						->where('date', $currentDate)
						->where('checkins.checkin_from','Office')
						->count();
					$result['checkinofficeCount']=$checkinofficeCount;
					$checkinworkfromCount = DB::table('checkins')
						->where('date', $currentDate)
						->where('checkins.checkin_from','Work From Home')
						->count();
					$result['checkinworkfromCount']=$checkinworkfromCount;
					$checkinclientCount = DB::table('checkins')
						->where('date', $currentDate)
						->where('checkins.checkin_from','Client Place')
						->count();
					$result['checkinclientCount']=$checkinclientCount;
					$result['clientcount']=count(Client::where('status',1)->get());
		 $result['taskcount'] = count( DB::table('tasks')
          ->leftJoin('teammembers', 'teammembers.id', '=', 'tasks.teammember_id')
          ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
				  ->where('tasks.task_type','0')  
          ->select('tasks.taskname', 'tasks.created_at', 'tasks.file as attachment', 'tasks.status', 'tasks.description', 'tasks.duedate', 'tasks.remark', 'teammembers.team_member', 'roles.rolename')
          ->orderBy('tasks.id', 'desc')
          ->get());			
        $result['task'] =  DB::table('tasks')
              ->leftjoin('taskassign','taskassign.task_id','tasks.id')
              ->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
			->leftjoin('teammembers as createdby','createdby.id','tasks.createdby')
              ->leftjoin('roles','roles.id','teammembers.role_id')
				   -> where('tasks.task_type','0')  
				  ->where('tasks.createdby',$request->teammemberid)
				 ->orwhere('taskassign.teammember_id',$request->teammemberid)->
              select('tasks.id','tasks.taskname','tasks.created_at','createdby.team_member as createdby',
              'tasks.file as attachment','tasks.status','tasks.description',
              'tasks.duedate','tasks.remark','teammembers.team_member','roles.rolename')->orderBy('tasks.id', 'desc')->get();
					
        foreach($result['task'] as $res)
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
            
              
       		  $result['asset'] = DB::table('assets')
              ->leftjoin('financerequests','financerequests.id','assets.financerequest_id')->
              where('assets.teammember_id',$request->teammemberid)
              ->select('financerequests.modal_name','financerequests.sno','financerequests.assetstatus',
              'financerequests.description','financerequests.kgs','assets.id')->get();
                }
              
				//end if condition
                else {
					
					if($request->roleid==18)
					{
						$currentDate = date('d-m-Y');
					$checkinCount = DB::table('checkins')->where('date', $currentDate)->count();
					$result['checkinCount']=$checkinCount;
    				// dd($checkinCount);
					$checkinofficeCount = DB::table('checkins')
						->where('date', $currentDate)
						->where('checkins.checkin_from','Office')
						->count();
					$result['checkinofficeCount']=$checkinofficeCount;
					$checkinworkfromCount = DB::table('checkins')
						->where('date', $currentDate)
						->where('checkins.checkin_from','Work From Home')
						->count();
					$result['checkinworkfromCount']=$checkinworkfromCount;
					$checkinclientCount = DB::table('checkins')
						->where('date', $currentDate)
						->where('checkins.checkin_from','Client Place')
						->count();
					$result['checkinclientCount']=$checkinclientCount;
					}
					$result['teamcount']=count(Teammember::where('status',1)->get());
							$result['leavecount'] = 2;
	
                    $result['assignmentstaffcount'] =  DB::table('assignmentmappings')
                    ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
                   ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id',
									  'assignmentmappings.assignmentgenerate_id')
                   ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
                   ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                   ->select('assignmentmappings.*','clients.client_name',
                    'assignments.assignment_name')->where('assignmentteammappings.teammember_id',$request->teammemberid)->get()->count();
					$result['clientcount']=count(Client::where('status',1)->get());
                    $result['notificationstaffcount'] = 0;
				
					$result['taskcount']=count(DB::table('tasks')
              ->leftjoin('taskassign','taskassign.task_id','tasks.id')
              ->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
              ->leftjoin('roles','roles.id','teammembers.role_id')
				   -> where('tasks.task_type','0')  
				  ->where('tasks.createdby',$request->teammemberid)
				 ->orwhere('taskassign.teammember_id',$request->teammemberid)->
              select('tasks.id','tasks.taskname','tasks.created_at',
              'tasks.file as attachment','tasks.status','tasks.description',
              'tasks.duedate','tasks.remark','teammembers.team_member','roles.rolename')->orderBy('tasks.id', 'desc')->get());
				
					$result['asset'] = DB::table('assets')
              ->leftjoin('financerequests','financerequests.id','assets.financerequest_id')->
              where('assets.teammember_id',$request->teammemberid)
              ->select('financerequests.modal_name','financerequests.sno','financerequests.assetstatus',
              'financerequests.description','financerequests.kgs','assets.id')->get();
					
                    $result['task'] =  DB::table('tasks')
              ->leftjoin('taskassign','taskassign.task_id','tasks.id')
              ->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
			->leftjoin('teammembers as createdby','createdby.id','tasks.createdby')
              ->leftjoin('roles','roles.id','teammembers.role_id')
				   -> where('tasks.task_type','0')  
				  ->where('tasks.createdby',$request->teammemberid)
				 ->orwhere('taskassign.teammember_id',$request->teammemberid)->
              select('tasks.id','tasks.taskname','tasks.created_at','createdby.team_member as createdby',
              'tasks.file as attachment','tasks.status','tasks.description',
              'tasks.duedate','tasks.remark','teammembers.team_member','roles.rolename')->orderBy('tasks.id', 'desc')->get();
        foreach($result['task'] as $res)
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
	
	 public function teamList()
    {
		   try {
			   
			
       $team = DB::table('teammembers')
		   ->join('roles','roles.id','teammembers.role_id')
		   ->select('teammembers.id','teammembers.team_member','teammembers.emailid','teammembers.mobile_no','roles.rolename')->where('status',1)->get();
			   
			   
		  $response['result'] = $team;
            $response['msg'] = "True";
            $response['code'] = "10001";
		 
		   }
		 
            catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong ". $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }
        return response()->json($response);
    }
	
   
}
