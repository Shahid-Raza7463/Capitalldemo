<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\SecretarialTask;
use App\Models\Title;
use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use App\Models\Teammember;
use Illuminate\Http\Request;
use Image;
use Hash;
use DB;
use Illuminate\Support\Facades\Mail;
class HrtaskController extends Controller
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
    public function index()
  {
        if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
          $taskDatas = DB::table('tasks')->where('task_type',4)
          ->latest()->get();
     //   dd($taskDatas);
        return view('backEnd.hrticket.index',compact('taskDatas'));
    }
    else {
        $taskDatas = DB::table('tasks')
      //  ->leftjoin('taskassign','taskassign.task_id','tasks.id')
        ->leftjoin('teammembers','teammembers.id','tasks.createdby')
        ->where('task_type','=',4)
      
			->where('tasks.createdby',auth()->user()->teammember_id)->select('tasks.*')->get();
     //   dd($taskDatas);
        return view('backEnd.hrticket.index',compact('taskDatas'));
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		 $client = Client::latest()->get();
        $teammember = Teammember::where('role_id','!=',11)->where('status',1)->where('role_id','!=',12)
        ->where('role_id','!=',12)->with('title','role')->get();
        return view('backEnd.hrticket.create',compact('teammember','client'));
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
  //    dd($request);

            try {
                $data=$request->except(['_token']);

            $id=DB::table('tasks')->insertGetId([	
                'taskname'         =>     $request->taskname, 
               'description'         =>     $request->description, 
               'status'         => 0, 
               'task_type'         =>     4, 
				  'client_id'         =>     $request->client_id, 
               'duedate'         =>     $request->duedate, 	
				 'priority'         =>     $request->priority, 	
               'addtional_details'         =>     $request->addtional_details, 	
               'createdby'         =>     auth()->user()->teammember_id, 
             //  'to'	                =>310,
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);

               if($request->has('teammember_id'))
               {

               foreach ($request->teammember_id as $teammember ) 
               {
                DB::table('taskassign')->insert([	
                    'task_id'         =>     $id, 
                   'teammember_id'         =>     $teammember, 	
                   'created_at'			    =>	   date('Y-m-d H:i:s'),
                   'updated_at'              =>    date('Y-m-d H:i:s'),
                   ]);  
               }
            }
            DB::table('taskassign')->insert([	
                'task_id'         =>     $id, 
               'teammember_id'         =>     310, 	
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]); 
               if($request->has('file'))
               {
               foreach ($request->file as $files ) 
               {
                    $file=$files;
                    $extension=$file->getClientOriginalExtension();
                    $filename=time().'.'.$extension;
                    $file->move('backEnd/image/secretarialtask/',$filename);
                   $data['file']=$filename;
                
                DB::table('task_attachments')->insert([
                    'taskid' => $id, 
                    'file' =>   $data['file'] ??'',
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                ]);

            }
             }
  $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
             if($request->has('teammember_id'))
             {
             
             $teammembers = Teammember::wherein('id',$request->teammember_id)->pluck('emailid')->toArray();
             
            foreach ($teammembers as $teammember ) {
               $data = array(
                'taskname' =>  $request->taskname,
                'duedate' =>  $request->duedate,
                'description' =>  $request->description,
     'authnames' =>  $authname->team_member,
           );
            }
            $data['ccmail']=$teammembers;
         
            Mail::send('emails.hrticketassign', $data, function ($msg) use($data){
                $msg->to('hr@kgsomani.com');
                $msg->cc($data['ccmail']);
                $msg->subject('kgs New Hr Ticket Created ');
            
             });

        }
        else
        {
           $data = array(
                'taskname' =>  $request->taskname,
                'duedate' =>  $request->duedate,
                'description' =>  $request->description,
                'authnames' =>  $authname->team_member,
           );
        Mail::send('emails.hrticketassign', $data, function ($msg) use($data){
            $msg->to('hr@kgsomani.com');
        //    $msg->cc($data['ccmail']);
            $msg->subject('kgs New Hr Ticket Created');
        
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
      //  dd($id);
        $title=Title::latest()->get();
        $teamrole=Role::latest()->get();
       // dd($teamrole);
        $teammember=Teammember::latest()->get();
        $task = task::where('id', $id)->first();
		$taskassign =  DB::table('taskassign')->where('task_id',$id)->get();
 // dd($taskassign);
        return view('backEnd.hrticket.edit', compact('id', 'task','title','teamrole','teammember','taskassign'));
    }
 public function hrticketUpdate(Request $request)
    {
 //       dd($request);
        try {
            $id =  DB::table('tasktrails')->insertGetId([
                'task_id' => $request->task_id, 
                 'remark' => $request->remark, 
                'status' => $request->status,
                'createdby' =>  auth()->user()->teammember_id, 
                 'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')               
            ]); 
            
			    if($request->has('file'))
            {
            foreach ($request->file as $files ) 
            {
                 $file=$files;
                 $extension=$file->getClientOriginalExtension();
                 $filename=time().'.'.$extension;
                 $file->move('backEnd/image/secretarialtask/',$filename);
                $data['file']=$filename;
             
             DB::table('task_attachments')->insert([
                 'tasktrailsid' => $id, 
                 'file' =>   $data['file'] ??'',
                 'created_at'			    =>	   date('y-m-d'),
                 'updated_at'              =>    date('y-m-d'),
             ]);

         }
          }
			
            DB::table('tasks')->where('id',$request->task_id)->update([	
                'status' => $request->status   
                 ]);
                 $tasks =  DB::table('tasks')->where('id',$request->task_id)->first();
                $assignby= DB::table('teammembers')->where('id',$tasks->createdby)->first();
               
                 //dd(auth()->user()->teammember_id);
                 if(auth()->user()->role_id == 18){
                 $taskassign =  DB::table('taskassign')->where('task_id',$request->task_id)
                 ->pluck('teammember_id');
                // dd($assignby);
                 $teammembers = Teammember::wherein('id',$taskassign)->pluck('emailid')->toArray();
   //dd($teammembers);
                 if($teammembers !=  null)
                 {
                    
                    if($request->status==1)
                    {
                            $data = array(
                 'taskname' =>  $tasks->taskname,
                 'duedate' =>  $tasks->duedate,
                  'description' =>  $request->remark,
                    'assignby'  =>$assignby->emailid,
                    'assignbyname'  =>$assignby->team_member,
            );
           
            Mail::send('emails.hrtaskdone', $data, function ($msg) use($data, $teammembers){
                $msg->to($data['assignby']);
                 $msg->cc($teammembers);
                 $msg->subject('kgs Hr Ticket Closed');
              });
            }
                          }
                 else
                 {
                    if($request->status==1)
            {
                    $data = array(
         'taskname' =>  $tasks->taskname,
         'duedate' =>  $tasks->duedate,
          'description' =>  $request->remark,
            'assignby'  =>$assignby->emailid,
            'assignbyname'  =>$assignby->team_member,
    );
   
    Mail::send('emails.hrtaskdone', $data, function ($msg) use($data){
        $msg->to($data['assignby']);
      //   $msg->cc($teammembers);
         $msg->subject('kgs Hr Ticket Closed');
      });
    }
 
                 }
            //    dd($teammembers);
            
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
    public function viewhrticketTask($id)
   {
      //dd($id);
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
        return view('backEnd.hrticket.view', compact('id', 'task','tasktrails'));
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
      //  dd($id);
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
       
         Mail::send('emails.secretastarialkassign', $data, function ($msg) use($data, $teammember){
             $msg->to($teammember);
             $msg->subject('kgs Task Assign');
          });
         }
            $output = array('msg' => 'Updated Successfully');
            return redirect('secretaryoftask')->with('success', $output);
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
}
