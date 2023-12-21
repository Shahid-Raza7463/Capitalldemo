<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Client;
use App\Models\Role;
use App\Models\Ganttchart;
use App\Models\Ganttstaff;
use App\Models\Teammember;
use App\Models\Permission;
use App\Models\Assignmentbudgeting;
use App\imports\Ganttimport;
use DB;
use Excel;
class GnattchartController extends Controller
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
      public function editAssign($id){
       
        $ganttcharts = DB::table('ganttcharts')->get();
        $ganttstaffs = DB::table('ganttstaffs')
        ->leftjoin('teammembers','teammembers.id','ganttstaffs.ganttstaff_id')->get();
      //  dd($ganttstaffs);
        $assign = DB::table('ganttstaffs')->where('id',$id)->first();
        return view('backEnd.gnatt.editassign',compact('assign','ganttcharts','ganttstaffs','id'));
    }
    public function updateAssign(Request $request,$id='')
    {
        $request->validate([
            'startdate'=>'required',
            'enddate'=>'required'
           ]);

        try{
            DB::table('ganttstaffs')->where('id',$id)->update([	
                'startdate'         =>   $request->startdate,
                'enddate'         =>    $request->enddate,
                 'updated_at' => date('y-m-d')     
                 ]);
            $output = array('msg'=>'staff Updated Successfully');
            return redirect('gnattchart/assignlist')->with('success',$output);

        }catch(Exception $e){
            DB::rollBack();
            Log::emergency("File:". $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
     public function gnattchartAssignlist(){
       
        $ganntassign = DB::table('ganttstaffs')
        ->leftjoin('ganttcharts','ganttcharts.id','ganttstaffs.clientname')
        ->leftjoin('teammembers','teammembers.id','ganttstaffs.ganttstaff_id')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->select('ganttstaffs.*','teammembers.team_member','ganttcharts.name','roles.rolename')->get();
        return view('backEnd.gnatt.assignlist',compact('ganntassign'));
    }
    public function ganttUpload(Request $request )
    {
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Ganttimport, $file);
            
            foreach ($dataa[0] as $key => $value) {
                $financename=DB::table('ganttcharts')->where('name',$value['name'])->select('name')->pluck('name')->first();
             //   dd($value['clientname']);
             if($financename == NULL){
                $db['name']=$value['name'];
                 $data= Ganttchart::Create($db);
               }
              
 }
           $output = array('msg' => 'Excel file upload Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
 public function index()
    {
     
         $staff = Teammember::where('role_id','15')->where('status',1)->orwhere('role_id','14')->with('role')->get();
          $client = Ganttchart::latest()->get();
        $tasks =  DB::table('ganttstaffs')
        ->leftjoin('ganttcharts','ganttcharts.id','ganttstaffs.clientname')
        ->where('ganttstaffs.ganttstaff_id','')
        ->orwhere('ganttstaffs.ganttstaff_id',auth()->user()->teammember_id)
        ->select('ganttstaffs.*','ganttcharts.name')->get();
//dd($tasks);
        return view('backEnd.gnatt.index',compact('tasks','staff','client'));
     
    }   
    public function gnattStore(Request $request)
   {
       // dd($request);
        // $request->validate([
        //     'title' => "required",
        //     'team_member' => "required",
        //     'mobile_no' => "required|numeric",
        //     'pancardno' => "required|numeric",
        //     'profilepic' => "required|mimes:jpeg,png,jpg,gif,svg",
        //     'team_member' => "required"
        // ]);

        try {
            $data=$request->except(['_token']);
            if($request->has('title_id')){
            $staff = Teammember::where('role_id','15')->orwhere('role_id','14')->get();
            $editstaff = Teammember::where('id', $request->title_id)->first();
              $client =  Ganttchart::latest()->get();
            $tasks = DB::table('ganttstaffs')
            ->leftjoin('ganttcharts','ganttcharts.id','ganttstaffs.clientname')
            ->where('ganttstaffs.ganttstaff_id',$request->title_id)
            ->select('ganttstaffs.*','ganttcharts.name')->get();
            //dd($tasks);
            return view('backEnd.gnatt.index',compact('tasks','staff','editstaff','client'));
            }
            else {
                $staff = Teammember::where('role_id','15')->orwhere('role_id','14')->get();
            $editstaff = Teammember::where('id', $request->client)->first();
              $client =  Ganttchart::latest()->get();
            $tasks =   DB::table('ganttstaffs')
            ->leftjoin('ganttcharts','ganttcharts.id','ganttstaffs.clientname')
            ->leftjoin('teammembers','teammembers.id','ganttstaffs.ganttstaff_id')
            ->where('ganttcharts.id',$request->client)
            ->select('ganttstaffs.*','teammembers.team_member as name')->get();
            //dd($tasks);
            return view('backEnd.gnatt.index',compact('tasks','staff','editstaff','client'));
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(auth()->user()->role_id == 11 or auth()->user()->role_id == 12){
            $page = Page::latest()->get();
            return view('backEnd.teamlevel.create',compact('page'));
        }
        abort(403, ' you have no permission to access this page ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ganttchartClientStore(Request $request)
     {
     
        // $request->validate([
        //     'title' => "required",
        //     'team_member' => "required",
        //     'mobile_no' => "required|numeric",
        //     'pancardno' => "required|numeric",
        //     'profilepic' => "required|mimes:jpeg,png,jpg,gif,svg",
        //     'team_member' => "required"
        // ]);

        try {
            $data=$request->except(['_token']);
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
     * @param  \App\Models\teamlevel  $teamlevel
     * @return \Illuminate\Http\Response
     */
    public function show(teamlevel $teamlevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\teamlevel  $teamlevel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::latest()->get();
        $teamlevel = Permission::where('role_id', $id)->get();
        $teamrole = Role::where('id',$id)->first();
      //  dd($teamrole->id);
        // $teamlevel = DB::table('roles')
        // ->leftjoin('permissions','permissions.role_id','roles.id')
        // ->where('roles.id',$id)
        // ->select('roles.*','permissions.page_id')->get();
       // dd($teamlevel);
       // $permission = Permission::all();
    //    $teamlevel = DB::select("
    //    select mp.id,mp.pagename,(CASE 
    //     WHEN  (page_id IS not NULL)  THEN 'true'
    //     ELSE 'false'
    //    END) as Status  from permissions as ca inner join pages as mp on ca.page_id=mp.id where ca.role_id=$id
    //    union all
    
    //  select mp.id,mp.pagename, ('false') as Status from pages as mp  where id not in (
    //    select page_id from permissions where role_id=$id)");
    
        return view('backEnd.teamlevel.edit', compact('id', 'teamlevel','page','teamrole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\teamlevel  $teamlevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        // $request->validate([
        //     'team_member' => "required",
        //     'mobile_no' => "required|numeric",
        //     'pancardno' => "required|numeric",
        //     'team_member' => "required"
        // ]);
        try {
            $data=$request->except(['_token']);
            DB::table('roles')->where('id', $id)->update([          
             	
                'rolename'         => $request->rolename,
                'updated_at'              =>    date('y-m-d'),
                ]);
             
               DB::table('permissions')->where([

                'role_id'   =>   $id,       

                ])->delete();

                foreach($request->page_id as $page_id){
                    DB::table('permissions')->insert([
                                'role_id'   	=>     $id,
                                'page_id'     =>     $page_id,
                                'created_at'			    =>	   date('y-m-d'),
                                'updated_at'              =>    date('y-m-d'),
                            ]);
                }
            $output = array('msg' => 'Updated Successfully');
            return redirect('teamlevel')->with('status', $output);
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
     * @param  \App\Models\teamlevel  $teamlevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(teamlevel $teamlevel)
    {
        //
    }
}
