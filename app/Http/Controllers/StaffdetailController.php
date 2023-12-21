<?php

namespace App\Http\Controllers;

use App\Models\Staffdetail;
use Illuminate\Http\Request;
use DB;
class StaffdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 || auth()->user()->role_id == 16 || auth()->user()->role_id == 17){
        $staffdetailDatas = DB::table('staffdetails')
      
        ->leftjoin('teammembers','teammembers.id','staffdetails.teammember_id')
        ->select('staffdetails.*','teammembers.team_member')->get();
     //   dd($staffdetailDatas);
        return view('backEnd.staffdetail.index',compact('staffdetailDatas'));
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
        $teammember = DB::table('teammembers')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('teammembers.status',1)
      ->select('roles.rolename','teammembers.team_member','teammembers.id')->get();
            return view('backEnd.staffdetail.create',compact('teammember'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
             'type' => "required",
           'teammember_id' => "required"
       ]);

         try {

         DB::table('staffdetails')->insertGetId([	
             'teammember_id'         =>     $request->teammember_id, 
            'type'         =>     $request->type, 
            'membership_no'         =>     $request->membership_no,
            'qualification'         =>     $request->qualification,
            'experience'         =>     $request->experience,
            'date_of_association'         =>     $request->date_of_association, 	
            'dateofjoining'         =>     $request->dateofjoining,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Format  $format
     * @return \Illuminate\Http\Response
     */
    public function show(Format $format)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Format  $format
     * @return \Illuminate\Http\Response
     */
    public function edit(Format $format)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Format  $format
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Format $format)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Format  $format
     * @return \Illuminate\Http\Response
     */
    public function destroy(Format $format)
    {
        //
    }
}
