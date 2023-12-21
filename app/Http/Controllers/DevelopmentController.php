<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Title;
use App\Models\Role;
use App\Models\User;
use App\Models\Teammember;
use Illuminate\Http\Request;
use Image;
use Hash;
use DB;
use Illuminate\Support\Facades\Mail;
class DevelopmentController extends Controller
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
		
		 
        $developmentDatas  = DB::table('developments')
        ->leftjoin('teammembers','teammembers.id','developments.testingby')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->select('developments.*','teammembers.team_member','roles.rolename')
        ->get();
    //    dd($developmentDatas);
        return view('backEnd.development.index',compact('developmentDatas')); 
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::where('role_id','!=',11)->where('status',1)->where('role_id','!=',12)
			->where('id','!=',310)->with('title','role')->get();
        return view('backEnd.development.create',compact('teammember'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
      //   dd($request);
           $request->validate([
                'taskname' => "required",
              'duedate' => "required"
          ]);

            try {
                $data=$request->except(['_token']);
               
            
            DB::table('developments')->insert([	
                'taskname'         =>     $request->taskname, 
               'remarks'         =>     $request->remarks, 
               'status'         =>     $request->status,
				'duedate'         =>     $request->duedate, 	
				'taskgivenby'     =>     $request->taskgivenby, 	
				'testingdate'   =>     $request->testingdate, 
                'testingby'   =>     $request->testingby, 
                'createdby'         =>     auth()->user()->teammember_id, 	
                'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);
	
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

    public function show($id)
    {
      //  dd($id);
        $development = DB::table('developments')->where('id',$id)->first();
        return view('backEnd.development.view',compact('development','teammember'));
}


}
