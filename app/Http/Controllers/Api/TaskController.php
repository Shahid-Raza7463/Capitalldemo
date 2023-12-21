<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Teammember;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
class TaskController extends Controller
{
   
   public function insertTask(Request $request)
   {
   //dd($request->teammemberid);
   //dd(explode(',',$request->teammemberid));
        $validator = Validator::make($request->all(), [
            'teammemberid' => 'required',
            'taskname' => 'required',
            'description' => 'required',
            'duedate' => 'required',
            'createdby' => 'required',
        ]);
      // dd($request->teammemberid);
  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
              $data=$request->except(['_token','teammemberid']);
				   if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/task/',$filename);
                $data['attachment']=$filename;
            }
				   else {
                    $data['attachment']='';
                }
            $result=DB::table('tasks')->insertGetId([	
                 
                    'taskname'   	=>     $request->taskname,
                    'description'   	=>     $request->description,
                    'duedate'   	=>     $request->duedate,
				'relatedto'   	=>     $request->relatedto,
				'kgsclient_id'   	=>     $request->kgsclient_id,
                 'dataroomclient_id'   	=>     $request->dataroomclient_id,
				 'other'   	=>     $request->other,
				         'file'         =>     $data['attachment'] ??'', 
                    'createdby'   	=>     $request->createdby,
				  'supportby'	=>     $request->supportby,
                    'status'   	=>     0,
				 'task_type'   	=>     0,
                    'created_at'			    =>	   date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
              
                foreach (explode(',',$request->teammemberid) as $teammember) 
              
                {
                 DB::table('taskassign')->insert([	
                     'task_id'         =>     $result, 
                     'teammember_id'         =>     $teammember, 
                    'created_at'			    =>	   date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                    ]);
                  }
            
              
              $teammembers = Teammember::wherein('id',explode(',',$request->teammemberid))->pluck('emailid')->toArray();
              $authname = Teammember::where('id',$request->createdby)->first();
                           foreach ($teammembers as $teammember ) {
                  $data = array(
                   'taskname' =>  $request->taskname,
                   'duedate' =>  $request->duedate,
                   'description' =>  $request->description,
                'authnames' =>  $authname->team_member,
       
              );
             
              Mail::send('emails.taskassign', $data, function ($msg) use($data, $teammember){
                   $msg->to($teammember);
                   $msg->subject('kgs New Task Assign');
         
                });
               }
               
          //   dd($request->teammemberid);
				 $user=User::select('fcm')->where('teammember_id',$request->teammemberid)->get();
				
             $this->sendGCMBulk($user, $request->taskname,'','', 'notification');
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
			'teammember_id'=>'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
                
            DB::table('tasktrails')->insert([
                'task_id' => $request->taskid, 
                 'remark' => $request->remark, 
                'status' => $request->status,
                'createdby' =>  $request->teammember_id, 
                 'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')               
            ]);
				  DB::table('tasks')->where('id',$request->taskid)->update([ 
                  'status'         =>  $request->status,
                  'remark'         =>  $request->remark,
                  'updated_at'         =>  date("Y-m-d") 
                  ]);
                  $result =  DB::table('tasks')
                  ->leftjoin('teammembers','teammembers.id','tasks.teammember_id')
                  ->leftjoin('roles','roles.id','teammembers.role_id')
                  ->where('tasks.id',$request->taskid)->
                 select('tasks.taskname','tasks.file as attachment','tasks.status','tasks.description','tasks.duedate','tasks.remark','teammembers.team_member','roles.rolename')->get();
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
	public function task_detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'taskid' => 'required'
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
              
				$result['task'] = DB::table('tasks')
    ->leftJoin('teammembers as support', 'support.id', 'tasks.supportby')
		 ->leftJoin('teammembers as createdby', 'createdby.id', 'tasks.createdby')		
					->leftJoin('roles', 'roles.id', 'createdby.role_id')	
	->leftJoin('taskassign', 'taskassign.task_id', 'tasks.id')
	->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
    ->where('tasks.task_type', '0')
    ->where('tasks.id', $request->taskid)
    ->select('tasks.id','tasks.taskname','teammembers.team_member','teammembers.id as teammemberId','tasks.duedate','tasks.created_at','tasks.description','createdby.team_member as createdby','roles.rolename','tasks.file','tasks.status')
    ->latest()
    ->first();
				
				// Check if the file exists
if ($result['task'] && $result['task']->file) {
    // Generate the full URL for the file
    $fileUrl = url('backEnd/image/task/' . $result['task']->file);

    // Add the file URL to the task result
    $result['task']->file_url = $fileUrl;
}
					
    if ($result['task']->status == 0) {
       $result['task']->status = "open";
    }
	elseif ($result['task']->status == 2) {
       $result['task']->status = "Cancelled Due to Non Completion";
    } else {
        $result['task']->status = "close";
    }	 
				
				
             $result['taskdetails'] = DB::table('tasktrails')
    ->leftJoin('teammembers', 'teammembers.id', 'tasktrails.createdby')
    ->where('tasktrails.task_id', $request->taskid)
    ->select('tasktrails.remark', 'tasktrails.task_id', 'tasktrails.createdby', 'tasktrails.status', 'tasktrails.created_at', 'teammembers.team_member')
    ->orderBy('created_at', 'asc')
    ->get();



foreach ($result['taskdetails'] as $res) {
    if ($res->status == 0) {
        $res->status = "open";
    }
	elseif ($res->status == 2) {
       $res->status = "Cancelled Due to Non Completion";
    }
	else {
        $res->status = "close";
    }
}

	

if ($result==null) {
    return response()->json(["msg" => "data not found", "code" => "404", "status" => "false"]);
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
public function taskList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'teammemberid' => 'required',
    ]);

    if ($validator->fails()) {
        $response['msg'] = $validator->errors();
        $response['status'] = 0;
        return response()->json($response);
    }

    try {
        $role = Teammember::where('id', $request->teammemberid)->pluck('role_id')->first();

        $query = DB::table('tasks')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'tasks.teammember_id')
            ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
            ->where('tasks.task_type', '0');

        if ($role == 11) {
            if ($request->has('status')) {
                $query->where('tasks.status', $request->status);
            }
        } else {
            $query->where(function ($q) use ($request) {
                $q->where('tasks.createdby', $request->teammemberid)
                    ->orWhere('taskassign.teammember_id', $request->teammemberid);
            });

            if ($request->has('status')) {
                $query->where(function ($q) use ($request) {
                    $q->where('tasks.status', $request->status)
                        ->orWhereNull('tasks.status');
                });
            }

            $query->leftJoin('taskassign', 'taskassign.task_id', 'tasks.id')
                ->leftJoin('teammembers as assigned_teammembers', 'assigned_teammembers.id', 'taskassign.teammember_id')
                ->leftJoin('roles as assigned_roles', 'assigned_roles.id', 'assigned_teammembers.role_id');
        }

        $result = $query->select(
            'tasks.id', 'tasks.taskname', 'tasks.created_at', 'tasks.file as attachment',
            'tasks.status', 'tasks.description', 'tasks.duedate', 'tasks.remark',
            'teammembers.team_member', 'roles.rolename',
            'assigned_teammembers.team_member as assigned_team_member',
            'assigned_roles.rolename as assigned_rolename'
        )
            ->orderBy('tasks.id', 'desc')
            ->get();

        foreach ($result as $res) {
            if ($res->attachment == null) {
                $res->attachment = null;
            } else {
                $res->attachment = url('backEnd/image/task/' . $res->attachment);
            }

            if ($res->status == 0) {
                $res->status = "pending";
            } elseif ($res->status == 2) {
                $res->status = "CANCELLED DUE TO NON COMPLETION";
            } else {
                $res->status = "completed";
            }

            $res->assigned_team_member = $res->assigned_team_member ?? null;
            $res->assigned_rolename = $res->assigned_rolename ?? null;
        }

        if ($result->isEmpty()) {
            return response()->json(["msg" => "data not found", "code" => "404", "status" => "false"]);
        } else {
            return response()->json(["output" => $result, "status" => "true", "code" => "10001"]);
        }
    } catch (\Exception $e) {
        $response['msg'] = "Something went wrong: " . $e->getMessage();
        $response['status'] = 0;
        $response['code'] = "500";
        Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));

        return response()->json($response);
    }
}
	

public function taskListCount(Request $request)
{
    $validator = Validator::make($request->all(), [
        'teammemberid' => 'required',
    ]);

    if ($validator->fails()) {
        $response['msg'] = $validator->errors();
        $response['status'] = 0;
        return response()->json($response);
    }

    try {
        $role = Teammember::where('id', $request->teammemberid)->pluck('role_id')->first();

        $query = DB::table('tasks')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'tasks.teammember_id')
            ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
            ->where('tasks.task_type', '0');

        if ($role == 11) {
            if ($request->has('status')) {
                $query->where('tasks.status', $request->status);
            }
        } else {
            $query->where(function ($q) use ($request) {
                $q->where('tasks.createdby', $request->teammemberid)
                    ->orWhere('taskassign.teammember_id', $request->teammemberid);
            });

            if ($request->has('status')) {
                $query->where(function ($q) use ($request) {
                    $q->where('tasks.status', $request->status)
                        ->orWhereNull('tasks.status');
                });
            }

            $query->leftJoin('taskassign', 'taskassign.task_id', 'tasks.id')
                ->leftJoin('teammembers as assigned_teammembers', 'assigned_teammembers.id', 'taskassign.teammember_id')
                ->leftJoin('roles as assigned_roles', 'assigned_roles.id', 'assigned_teammembers.role_id');
        }

        $result = $query->select(
            'tasks.id', 'tasks.taskname', 'tasks.created_at', 'tasks.file as attachment',
            'tasks.status', 'tasks.description', 'tasks.duedate', 'tasks.remark',
            'teammembers.team_member', 'roles.rolename',
            'assigned_teammembers.team_member as assigned_team_member',
            'assigned_roles.rolename as assigned_rolename'
        )
            ->orderBy('tasks.id', 'desc')
            ->get();

        // Count based on status
        $statusCount = [
            'pending' => 0,
            'CANCELLED DUE TO NON COMPLETION' => 0,
            'completed' => 0,
        ];

        foreach ($result as $res) {
            if ($res->attachment == null) {
                $res->attachment = null;
            } else {
                $res->attachment = url('backEnd/image/task/' . $res->attachment);
            }

            if ($res->status == 0) {
                $res->status = "pending";
                $statusCount['pending']++;
            } elseif ($res->status == 2) {
                $res->status = "CANCELLED DUE TO NON COMPLETION";
                $statusCount['CANCELLED DUE TO NON COMPLETION']++;
            } else {
                $res->status = "completed";
                $statusCount['completed']++;
            }

            $res->assigned_team_member = $res->assigned_team_member ?? null;
            $res->assigned_rolename = $res->assigned_rolename ?? null;
        }

        if ($result->isEmpty()) {
            return response()->json(["msg" => "data not found", "code" => "404", "status" => "false"]);
        } else {
            return response()->json([ "status" => "true", "code" => "10001", "status_count" => $statusCount]);
        }
    } catch (\Exception $e) {
        $response['msg'] = "Something went wrong: " . $e->getMessage();
        $response['status'] = 0;
        $response['code'] = "500";
        Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));

        return response()->json($response);
    }
}

}

