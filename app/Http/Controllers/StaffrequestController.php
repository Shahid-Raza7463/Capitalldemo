<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staffrequest;
use App\Models\Ganttchart;
use App\Models\Teammember;
use DB;
use Image;
use File;
use Illuminate\Support\Facades\Mail;
class StaffrequestController extends Controller
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
   public function viewList($id)
    {  

       
        $staffrequest = DB::table('staffrequests')->where('status', $id)->first();

            $staffrequestDatas = DB::table('staffrequests')
            ->leftjoin('ganttcharts','ganttcharts.id','staffrequests.ganttchart_id')
				  ->leftjoin('teammembers','teammembers.id','staffrequests.createdby')->
            where('staffrequests.status', $id)
          ->select('staffrequests.*','ganttcharts.name','teammembers.team_member')->get();
          
             return view('backEnd.staffrequest.list',compact('staffrequest','staffrequestDatas','id'));
      
    }
    public function index()
    {
        if(auth()->user()->role_id == 11 || auth()->user()->id == 27 || auth()->user()->role_id == 18)
        {
            $staffrequestDatas = DB::table('staffrequests')
            ->leftjoin('ganttcharts','ganttcharts.id','staffrequests.ganttchart_id')
				 ->leftjoin('teammembers','teammembers.id','staffrequests.createdby')
          ->select('staffrequests.*','ganttcharts.name','teammembers.team_member')->get();
            return view('backEnd.staffrequest.index',compact('staffrequestDatas'));
        }
		
         else {
            $staffrequestDatas = DB::table('staffrequests')
            ->leftjoin('ganttcharts','ganttcharts.id','staffrequests.ganttchart_id')
				 ->leftjoin('teammembers','teammembers.id','staffrequests.createdby')
            ->where('createdby',auth()->user()->teammember_id)
          ->select('staffrequests.*','ganttcharts.name','teammembers.team_member')->get();
            return view('backEnd.staffrequest.index',compact('staffrequestDatas'));
         } 
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function create()
    {
        $ganttchart = Ganttchart::latest()->get();
      //dd($ganttchart);
        return view('backEnd.staffrequest.create',compact('ganttchart'));
  
    }
    public function viewStaff($id)
    {
        $staffrequest = Staffrequest::where('id',$id)->first();
        $staff = Teammember::where('role_id','15')->where('status',1)->orwhere('role_id','14')->with('role')->get();
        $client = Ganttchart::where('id',$staffrequest->ganttchart_id)->get();
		     $stafflog = DB::table('trail')
            ->leftjoin('teammembers','teammembers.id','trail.createdby')
            ->where('pageid', $id)->where('type','Staff Request')->select('trail.*','teammembers.team_member')->get();
        return view('backEnd.staffrequest.view',compact('staff','client','staffrequest','id','stafflog'));
  
    }
    public function staffRequest(Request $request)
    {
      // dd($id);
        $request->validate([
            'status' => 'required'
        ]);

        try {
            $date = date("Y-m-d") ;
           
            DB::table('staffrequests')->where('id',$request->rid)->update([ 
                'status'         =>  $request->status ,
                'updated_at'         =>  $date
                ]);
			  if($request->status == 1){
                $count=count($request->ganttstaff_id);
                // dd($count);
                 for($i=0;$i<$count;$i++){
                    DB::table('ganttstaffs')->insert([
                        'clientname'         =>     $request->clientname, 	
                        'startdate'	            =>      $request->startdate[$i],
                         'enddate'         =>     $request->enddate[$i],
                        'ganttstaff_id'   	=>     $request->ganttstaff_id[$i],
                        'color'         =>    '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                        'created_at'			    =>	   date('y-m-d'),
                        'updated_at'              =>    date('y-m-d'),
                    ]);
					    $client =  DB::table('ganttcharts')->where('id',$request->clientname)->pluck('name')->first();
                    $staffmail = Teammember::where('id', $request->ganttstaff_id[$i])->pluck('emailid')->first(); 
                    $data = array(
                        'client' =>  $client,
                        'startdate' =>  $request->startdate[$i],
                        'enddate' =>  $request->enddate[$i],
                   );
                  
                    Mail::send('emails.staffassign', $data, function ($msg) use($data, $staffmail){
                        $msg->to($staffmail);
                        $msg->subject('kgs Staff Assigned');
                     });
                    }
                }
			 if($request->status == 2){
                    $description = 'Staffrequest Reject by';
                    $pageid =$request->rid;
                    $this->activityLog($request, $pageid, $description);
                }
                if($request->status == 1){
                    $description = 'Staffrequest Approved by';
                    $pageid = $request->rid;
                    $this->activityLog($request, $pageid, $description);
                }
                $output = array('msg' => 'staffrequest Updated Successfully');
                return redirect('staffrequest')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
      //  dd($request);
        $request->validate([
            'ganttchart_id' => "required",
            'noofstaff' => "required"
        ]);

        try {
            $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
            $data['status'] = 0;
            $clientModel = Staffrequest::Create($data);
               $clientModel->save();
            $stafrqsidd = $clientModel->id;
            $client = Ganttchart::where('id',$request->ganttchart_id)->first(); 
            $admin = Teammember::where('id',23)->pluck('emailid')->first(); 
           $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
            $data = array(
             'ganttchart_id' =>  $client->name,
             'noofstaff' =>  $request->noofstaff,
             'startdate' =>  $request->startdate,
             'enddate' =>  $request->enddate,
             'comment' =>  $request->comment,
 'authnames' =>  $authname->team_member,
        );
       
         Mail::send('emails.staffrequest', $data, function ($msg) use($data, $admin){
             $msg->to($admin);
             $msg->subject('kgs Staff Request');
			 $msg->cc('office@kgsomani.com');
          });
			 $description = 'Staffrequest Raised by';
          $pageid = $stafrqsidd;
          $this->activityLog($request, $pageid, $description);
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
     * @param  \App\Models\staffrequest  $staffrequest
     * @return \Illuminate\Http\Response
     */
    public function show(staffrequest $staffrequest)
    {
        //
    }
	   public function destroy($id)
    {
      //  dd($id);
        try {
            Staffrequest::destroy($id);
          
            $output = array('msg' => 'Deleted Successfully');
            return redirect('staffrequest')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
  public function activityLog($request, $pageid,$description){
        $actionName = class_basename($request->route()->getActionname());
                $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                  DB::table('trail')->insert([
                        'createdby' => auth()->user()->teammember_id, 
                        'ip_address' => $request->ip(), 
                        'pagetitle' => $pagename, 
                        'pageid' => $pageid, 
                        'type' => 'Staff Request', 
                        'description' => $description, 
                        'created_at' => date('y-m-d H:i:s'),       
                        'updated_at' => date('y-m-d')       
                    ]);
      }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\staffrequest  $staffrequest
     * @return \Illuminate\Http\Response
     */
  }
