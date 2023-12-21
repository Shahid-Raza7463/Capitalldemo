<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Title;
use App\Models\Role;
use App\Models\User;
use App\Models\Teammember;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Image;
use Hash;
use DB;
use Illuminate\Support\Facades\Mail;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct()
    {
        $this->middleware('auth');
    }
	public function taskassignmentlist($id)
	{
		 $taskDatas = DB::table('tasks')
        ->leftjoin('teammembers as support','support.id','tasks.supportby')  
        ->where('tasks.assignment_id',$id)  
        ->select('tasks.*','support.team_member as supportteammember')->latest()->get();
//   dd($taskDatas);
    return view('backEnd.task.index',compact('taskDatas'));

	}
     public function index()
    {
        return view('backEnd.task.statusindex'); 
    }

	 public function taskAssignment(Request $request)
    {
       
        if ($request->ajax()) {

          if (isset($request->category_id)) {
                    echo "<option>Please Select One</option>";
                    foreach ( DB::table('assignmentbudgetings')
                    ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
                    ->where('assignmentbudgetings.client_id',$request->category_id)->
                    select('assignments.*','assignmentbudgetings.assignmentgenerate_id','assignmentbudgetings.duedate')
                    ->get() as $sub) {
                 
                        echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name .'('. date('F d,Y', strtotime($sub->duedate)).')'.'('.$sub->assignmentgenerate_id.')'. "</option>";
                    }
             
                
            }
        }
         
      
    }
	 public function list($id)
  {
    //dd($id);
        if(auth()->user()->teammember_id == 432){
            $taskDatas = DB::table('tasks')
            ->leftjoin('teammembers as support','support.id','tasks.supportby')->
              where('tasks.task_type','0')  
              ->where('tasks.status',$id)  
            ->select('tasks.*','support.team_member as supportteammember')->latest()->get();
    //   dd($taskDatas);
        return view('backEnd.task.index',compact('taskDatas'));
    }
		  elseif(auth()->user()->role_id == 11){
            $taskDatas = DB::table('tasks')
            ->leftjoin('teammembers as support','support.id','tasks.supportby')->
              where('tasks.task_type','0')  
              ->where('tasks.status',$id)  
            ->select('tasks.*','support.team_member as supportteammember')->latest()->get();
    //   dd($taskDatas);
        return view('backEnd.task.index',compact('taskDatas'));
    }
    else {
        $taskDatas = DB::table('tasks')
        ->leftjoin('teammembers as support','support.id','tasks.supportby')->
          where('tasks.task_type','0')  
          ->where('tasks.status',$id)  
          ->where('tasks.createdby',auth()->user()->teammember_id)
        ->select('tasks.*','support.team_member as supportteammember')->latest()->get();
   //  dd($taskDatas);

     $taskassignDatas = DB::table('tasks')
     ->leftjoin('taskassign','taskassign.task_id','tasks.id')
     ->leftjoin('teammembers as support','support.id','tasks.supportby')
     ->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
     ->where('tasks.task_type','0')  
     ->where('tasks.status',$id)  
     ->where('taskassign.teammember_id',auth()->user()->teammember_id)
         ->select('tasks.*','support.team_member as supportteammember')->get();
    // dd($taskassignDatas);

      return view('backEnd.task.taskassemble',compact('taskDatas','taskassignDatas'));
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$dataroom =DB::table('clientlogins')
        ->join('clients','clients.id','clientlogins.client_id')
        ->select('clients.client_name','clients.id')
        ->distinct('clients.client_name')
			->orderBy('client_name', 'asc')->get();
       // dd($dataroom);
        $client =DB::table('clients')->orderBy('client_name', 'asc')->get();
        $teammember = Teammember::where('role_id','!=',11)->where('status',1)->where('role_id','!=',12)
			->where('id','!=',310)->with('title','role')
			->orderBy('team_member', 'asc')->get();
        return view('backEnd.task.create',compact('teammember','client','dataroom'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
           $request->validate([
                'taskname' => "required",
              'duedate' => "required"
          ]);

            try {
     $data=$request->except(['_token']);
                if($request->hasFile('attachment'))
                {
                    $file=$request->file('attachment');
                    $filename = time().$file->getClientOriginalName();
                    $file->move('backEnd/image/task',$filename);
                    $data['attachment']=$filename;
                }
                else {
                    $data['attachment']='';
                }
            $id=DB::table('tasks')->insertGetId([	
                'taskname'         =>     $request->taskname, 
               'description'         =>     $request->description, 
               'status'         =>     0, 
				 'task_type'         =>     0, 
				'duedate'         =>     $request->duedate, 	
				'relatedto'         =>     $request->relatedto, 	
				'dataroomclient_id'         =>     $request->dataroomclient_id, 	
				'assignment_id'         =>     $request->assignment_id, 	
				'kgsclient_id'         =>     $request->kgsclient_id, 	
				'other'         =>     $request->other, 	
				'supportby'         =>     $request->supportby, 	
				  'file'         =>      $data['attachment'], 
               'createdby'         =>     auth()->user()->teammember_id, 	
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);
               foreach ($request->teammember_id as $teammember ) 
               {
                DB::table('taskassign')->insert([	
                    'task_id'         =>     $id, 
                   'teammember_id'         =>     $teammember, 	
                   'created_at'			    =>	   date('Y-m-d H:i:s'),
                   'updated_at'              =>    date('Y-m-d H:i:s'),
                   ]);  
               }
                        $teammembers = Teammember::wherein('id',$request->teammember_id)->pluck('emailid')->toArray();
				   $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
                        foreach ($teammembers as $teammember ) {
               $data = array(
                'taskname' =>  $request->taskname,
                'duedate' =>  $request->duedate,
                'description' =>  $request->description,
				     'authnames' =>  $authname->team_member,
    
           );
          
           Mail::send('emails.taskassign', $data, function ($msg) use($data, $teammember){
                $msg->to($teammember);
                $msg->subject('VSA New Task Assign');
			
             });
            }
	
                $output = array('msg' => 'Create Successfully');
                return back()->with('success', $output);
            } catch (Exception $e) {
                DB::rollBack();
                Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                report($e);
                $output = array('msg' => $e->getMessage());
                return back()->withErrors($output)->withInput();
            }
        
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title=Title::latest()->get();
        $teamrole=Role::latest()->get();
        $teammember=Teammember::latest()->get();
        $task = task::where('id', $id)->first();
		   $taskassign =  DB::table('taskassign')->where('task_id',$id)->get();
        return view('backEnd.task.edit', compact('id', 'task','title','teamrole','teammember','taskassign'));
    }
 public function taskUpdate(Request $request)
    {
        try {
            DB::table('tasktrails')->insert([
                'task_id' => $request->task_id, 
                 'remark' => $request->remark, 
                'status' => $request->status,
                'createdby' =>  auth()->user()->teammember_id, 
                 'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')               
            ]); 
            
            DB::table('tasks')->where('id',$request->task_id)->update([	
                'status' => $request->status   
                 ]);
                 $tasks =  DB::table('tasks')->where('id',$request->task_id)->first();
                 if(auth()->user()->teammember_id == $tasks->createdby){
                 $taskassign =  DB::table('taskassign')->where('task_id',$request->task_id)->pluck('teammember_id');
                $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
                 $teammembers = Teammember::wherein('id',$taskassign)->pluck('emailid')->toArray();
               //  dd($teammembers);
                 foreach ($teammembers as $teammember ) {
        $data = array(
         'taskname' =>  $tasks->taskname,
         'duedate' =>  $tasks->duedate,
         'description' =>  $request->remark,
'authnames' =>  $authname->team_member,
    );
   
     Mail::send('emails.taskassigns', $data, function ($msg) use($data, $teammember){
         $msg->to($teammember);
         $msg->subject('VSA New Task Instruction');
      });
     }
    }
    if(auth()->user()->teammember_id != $tasks->createdby){
        $teammember = Teammember::where('id',$tasks->createdby)->pluck('emailid')->toArray();
         $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
$data = array(
'taskname' =>  $tasks->taskname,
'duedate' =>  $tasks->duedate,
'description' =>  $request->remark,
 'authnames' =>  $authname->team_member,
);

Mail::send('emails.taskassigns', $data, function ($msg) use($data, $teammember){
$msg->to($teammember);
$msg->subject('VSA New Task Instruction');
});

}
            $output = array('msg' => 'Submit Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
    }
	 public function update_subtask(Request $request)
    {
        try {
 
            DB::table('tasktrails')->where('id',$request->trailid)->update([	
                'status' => $request->status   
                 ]);
          
            $output = array('msg' => 'Update Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
    }
    public function viewTask($id)
   {
      //  dd($id);
        $task = DB::table('tasks')
        ->leftjoin('teammembers','teammembers.id','tasks.createdby')
        ->where('tasks.id', $id)
        ->select('tasks.*',
        'teammembers.team_member')->first();
        $tasktrails = DB::table('tasktrails')
        ->leftjoin('teammembers','teammembers.id','tasktrails.createdby')
        ->where('tasktrails.task_id',$id)
        ->where('tasktrails.client_id',auth()->user()->client_id)->orderBy('created_at', 'asc')->select('tasktrails.*',
        'teammembers.team_member')->get();
      // dd($viewinfo);
        return view('backEnd.task.view', compact('id', 'task','tasktrails'));
    }
	   public function taskMail(Request $request)
    {
       // dd($request);
        $request->validate([
             'subject' => "required",
           'email' => "required"
       ]);

         try {
            $task = Task::where('id', $request->taskid)->first();
            foreach ($request->email as $emails) {
                $data = array(
                 'taskname' =>  $task->taskname,
                 'duedate' =>  $task->duedate,
                 'subject' =>  $request->subject,
                 'description' =>  $task->description,
                 'msg' =>  $request->msg,
                 'email' =>  $emails,
     
            );
           
             Mail::send('emails.taskremindermail', $data, function ($msg) use($data){
                 $msg->to($data['email']);
                 $msg->subject($data['subject']);
              });
             }

				  $taskid = $request->taskid;
      //    dd($value);
            $task = 'Task Reminder Send ';
             $this->activityLog($request, $taskid, $task);
             $output = array('msg' => 'Mail Send Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
     
 }
 public function activityLog($request, $taskid,$task){
    $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
              DB::table('trail')->insert([
                    'createdby' => auth()->user()->teammember_id, 
                    'ip_address' => $request->ip(), 
                    'pagetitle' => $pagename, 
                    'pageid' => $taskid, 
                    'type' => 'Task', 
                    'description' => $task, 
                    'created_at' => date('y-m-d H:i:s'),       
                    'updated_at' => date('y-m-d H:i:s')       
                ]);
  }
 public function resetPassword($id)
    {
       // dd($id);
        $task = task::where('id', $id)->first();
        return view('backEnd.task.resetpassword', compact('id', 'task'));
    }
       public function taskComplete(Request $request)
    {
        // dd($id);
          $request->validate([
              'status' => 'required',
              'remark' => 'required'
          ]);
  
          try {
              $date = date("Y-m-d") ;
             
              DB::table('tasks')->where('id',$request->rid)->update([ 
                  'status'         =>  $request->status ,
                  'remark'         =>  $request->remark ,
                  'updated_at'         =>  $date
                  ]);
                  $output = array('msg' => 'Updated Successfully');
                  return redirect('task')->with('success', $output);
          } catch (Exception $e) {
              DB::rollBack();
              Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
              report($e);
              $output = array('msg' => $e->getMessage());
              return back()->withErrors($output)->withInput();
          }
      }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
    {
        $request->validate([
            'taskname' => "required",
            'duedate' => "required"
        ]);
        try {
            $data=$request->except(['_token','teammember_id']);
          
            task::find($id)->update($data);
            foreach ($request->teammember_id as $teammember ) 
            {
             DB::table('taskassign')->insert([	
                 'task_id'         =>     $id, 
                'teammember_id'         =>     $teammember, 	
                'created_at'			    =>	   date('Y-m-d H:i:s'),
                'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);  
            }
                     $teammembers = Teammember::wherein('id',$request->teammember_id)->pluck('emailid')->toArray();
                     foreach ($teammembers as $teammember ) {
            $data = array(
             'taskname' =>  $request->taskname,
             'duedate' =>  $request->duedate,
             'description' =>  $request->description,
 
        );
       
         Mail::send('emails.taskassign', $data, function ($msg) use($data, $teammember){
             $msg->to($teammember);
             $msg->subject('VSA Task Assign');
          });
         }
            $output = array('msg' => 'Updated Successfully');
            return redirect('task')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
      //  dd($id);
        try {
            Task::destroy($id);
            $output = array('msg' => 'Deleted Successfully');
            return redirect('task')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
	 public function task_repeat($id)
    {
    //  dd($id);
        try {
           $task = DB::table('tasks')->where('id',$id)->first();
           $taskassign = DB::table('taskassign')->where('task_id',$id)->get();
        //   dd($taskassign);
           $currentdate = date('Y-m-d');
           $date = Carbon::createFromFormat('Y-m-d',$currentdate ??'')->addDays(4);
           $duedate = $date->format('Y-m-d');
         //  dd($task);
            $id=DB::table('tasks')->insertGetId([	
                'taskname'         =>     $task->taskname, 
               'description'         =>     $task->description, 
               'status'         =>     0, 
				 'task_type'         =>     0, 
				'duedate'         =>     $duedate, 	
				'supportby'         =>     $task->supportby, 	
				  'file'         =>      $task->attachment, 
               'createdby'         =>     auth()->user()->teammember_id, 	
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);
               foreach ($taskassign as $teammember ) 
               {
                DB::table('taskassign')->insert([	
                    'task_id'         =>     $id, 
                   'teammember_id'         =>     $teammember->teammember_id, 	
                   'created_at'			    =>	   date('Y-m-d H:i:s'),
                   'updated_at'              =>    date('Y-m-d H:i:s'),
                   ]);  
               }
                        $teammembers = DB::table('taskassign')
                        ->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
                        ->where('taskassign.task_id',$id)
                        ->select('teammembers.emailid')->get();

//dd($teammembers);
				   $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
                        foreach ($teammembers as $teammembermail ) {
               $data = array(
                'taskname' =>  $task->taskname,
                'duedate' =>  $duedate,
                'description' =>  $task->description,
				     'authnames' =>  $authname->team_member,
                     'email' =>   $teammembermail->emailid,
           );
          
           Mail::send('emails.taskassign', $data, function ($msg) use($data){
            $msg->to($data['email']);
                $msg->subject('kgs New Repeated Task Assign');
			
             });
            }
            $output = array('msg' => 'create Successfully');
            return redirect('task')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
	
	public function Reportsection(Request $request)
  {
 //dd($request);
    $employeename = Teammember::where('role_id', '!=', 11)->where('status', 1)->with('title', 'role')->get();
   
    $result = DB::table('tasks')->select(DB::raw('YEAR(created_at) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    return view('backEnd.task.taskreport', compact('employeename','years'));

  }
 
  public function taskfiltersection(Request $request)
  {
      if ($request->ajax()) {
       // dd($request);
       $employeeIds = (int) $request->employeeid;
      // dd($employeeIds);
          $month = $request->month;
          $yearly = $request->yearly;
          $status =$request->status;
  
          $taskData = DB::table('tasks')
              ->leftJoin('taskassign','taskassign.task_id','tasks.id')
              ->leftJoin('teammembers', 'teammembers.id', '=', 'taskassign.teammember_id')
              ->leftJoin('teammembers as team', 'team.id', '=', 'tasks.supportby')
              ->leftJoin('teammembers as teams', 'teams.id', '=', 'tasks.createdby')
              ->where('taskassign.teammember_id', $employeeIds)
              ->when(!is_null($status), function ($query) use ($status) {
                return $query->where('tasks.status', $status);
            })
             
             ->when($month != 0, function ($query) use ($month) {
                 return $query->whereMonth('tasks.created_at', $month);
             })
             ->when($yearly != 0, function ($query) use ($yearly) {
                 return $query->whereYear('tasks.created_at', $yearly);
             })
              ->select(
                  'tasks.id',
                  'tasks.taskname',
                  'tasks.created_at',
                  'tasks.duedate',
                  'tasks.status',
                  'teams.team_member as assignby',
                  'teammembers.team_member as assign',
                  'team.team_member as supportby',
              )
              ->get();
   //       dd($taskData);
       
          return response()->json($taskData);
      }
  }
}
