<?php

namespace App\Http\Controllers;
use App\Models\Teammember;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use DB;
class ProjectController extends Controller
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
        if(auth()->user()->role_id == 11 or auth()->user()->role_id == 14){
            $projectData = DB::table('projects')
       ->leftjoin('clients','clients.id','projects.client_id')
       ->leftjoin('teammembers','teammembers.id','projects.teammember_id')
       ->select('projects.*','clients.client_name','teammembers.team_member')->get();
           // dd($profileDatas);
            return view('backEnd.project.index',compact('projectData'));
                }
           else
           {
            $projectData = DB::table('projects')
            ->leftjoin('clients','clients.id','projects.client_id')->
            where('projects.createdby',auth()->user()->role_id)
            ->leftjoin('teammembers','teammembers.id','projects.teammember_id')
       ->select('projects.*','clients.client_name','teammembers.team_member')->get();
           // dd($profileDatas);
            return view('backEnd.project.index',compact('projectData'));
           }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
        $client = Client::select('id','client_name')->get();
      return view('backEnd.project.create',compact('client','teammember'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // $request->validate([
        //     'companyname' => "required",
        // ]);

        try {
            $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
        //    $data['Status'] = 0;
            $project = Project::Create($data);
          
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
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function show(Outstationconveyance $outstationconveyance)
    { 
       
    
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $client = Client::select('id','client_name')->get();
         $project = project::where('id', $id)->first();
         $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
        // $outstationconveyancesemployee = DB::table('outstationconveyancesemployee')
        // ->leftjoin('teammembers','teammembers.id','outstationconveyancesemployee.teammember_id')
        // ->where('outstationconveyancesemployee.outstationconveyances_id', $id)
        // ->select('outstationconveyancesemployee.*','teammembers.team_member')->get();
        return view('backEnd.project.edit', compact('id','project','client','teammember'));
    }
    public function view($id)
    {
       //  dd($id);
         $project = project::where('id', $id)->first();
         return view('backEnd.project.view', compact('id','project'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
        //   if($request->hasFile('attachment'))
        //     {
        //         $file=$request->file('attachment');
        //             $destinationPath = 'backEnd/image/outstationconveyance';
        //             $name = $file->getClientOriginalName();
        //            $s = $file->move($destinationPath, $name);
        //                  //  dd($s); die;
        //                  $data['attachment'] = $name;
               
        //     }
            $data['updatedby'] = auth()->user()->teammember_id;
            Project::find($id)->update($data);
            $createdby = Project::where('id',$id)->first();
          //  dd($createdby);
          if($request->Status == 1 || $request->Status == 2){
            $teammembermail = Teammember::where('id',$createdby->createdby)->first();
            $data = array(
                  'email' => $teammembermail->emailid ??'',
                   'status' => $createdby->Status ??'',
                   'name' => $teammembermail->team_member ??'',
                   'id' => $id ??''
           );
            // Mail::send('emails.outstationconveyanceapprovelform', $data, function ($msg) use($data , $request){
            //     $msg->to($data['email']);
            //     if($request->Status == 1){
            //         $msg->subject('Outstation Conveyance Request - Approved ');
            //     }
            //     if($request->Status == 2){
            //         $msg->subject('Outstation Conveyance Request- Rejected');
            //     }

// $msg->cc($data['teammembermail']);
    //         });
//              Mail::send('emails.localconveyanceaccountform', $data, function ($msg) use($data){
//                 $msg->to('tarunkumar@kgsomani.com');
//                 $msg->cc('priyankasharma@kgsomani.com');
//                 $msg->subject('Outstation Conveyance Request');
// // $msg->cc($data['teammembermail']);
//              }); 
          }
            
            $output = array('msg' => 'Updated Successfully');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outstationconveyance $outstationconveyance)
    {
        //
    }
}
