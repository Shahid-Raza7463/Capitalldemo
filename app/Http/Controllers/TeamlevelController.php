<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Role;
use App\Models\Permission;
use DB;
class TeamlevelController extends Controller
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
         if(auth()->user()->role_id == 11 or auth()->user()->role_id == 12){
        $teamlevelDatas = Role::where('id','!=','11')->get();
        return view('backEnd.teamlevel.index',compact('teamlevelDatas'));
         }
        abort(403, ' you have no permission to access this page ');
    
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
    public function store(Request $request)
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
            $role_id=	DB::table('roles')->insertGetId([			
                'rolename'         => $request->rolename,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                ]);
                foreach($request->page_id as $page_id){
                    DB::table('permissions')->insert([
                                'role_id'   	=>     $role_id,
                                'page_id'     =>     $page_id,
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
