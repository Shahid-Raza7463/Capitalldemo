<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PerformanceappraisalController extends Controller
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

        if(auth()->user()->role_id==18||auth()->user()->role_id==11||auth()->user()->role_id==12
        )
        {

        $appraisal = DB::table('invoices')
    ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'invoices.createdby')
    ->leftJoin('assignments', 'assignments.id', '=', 'invoices.assignment_id')
    ->where('invoices.financialyear', '22-23')
  //  ->where('invoices.assignmentgenerate_id', 980032957911)
    ->select('invoices.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'invoices.client_id as client_id', 'assignments.assignment_name', 'assignments.id as assignmentid')
    ->orderBy('invoices.id', 'desc')
    ->pluck('assignmentgenerate_id')
    ->unique();

			
    //dd(count($appraisal));
        }
        elseif(auth()->user()->role_id==13 ||auth()->user()->role_id==14 )
        {
        	
			 $appraisal = DB::table('invoices')
          ->leftjoin('clients','clients.id','invoices.client_id')
          ->leftjoin('teammembers','teammembers.id','invoices.createdby')
		//->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('assignments','assignments.id','invoices.assignment_id')
       //   ->leftjoin('assignmentevaluations','assignmentevaluations.assignmentgenerate_id','invoices.assignmentgenerate_id')
        ->where('invoices.financialyear', '22-23')
		//->where('teammembers.role_id','!=',13)
		//->where('invoices.client_id',38)
    ->where('teammembers.status','!=',0)
    ->where('invoices.createdby',auth()->user()->teammember_id)
    ->orwhere('invoices.partner',auth()->user()->teammember_id)
 
         ->select('invoices.*','clients.client_name','teammembers.team_member'
         ,'assignments.assignment_name','invoices.client_id as client_id','assignments.assignment_name'
         ,'assignments.id as assignmentid',)->orderBy('id', 'desc')        
				 ->distinct()
         ->get();


        }
       
        else
        {
			
			   $appraisal = DB::table('invoices')
          ->leftjoin('clients','clients.id','invoices.client_id')
          ->leftjoin('teammembers','teammembers.id','invoices.createdby')
		//->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('assignments','assignments.id','invoices.assignment_id')
       //   ->leftjoin('assignmentevaluations','assignmentevaluations.assignmentgenerate_id','invoices.assignmentgenerate_id')
          ->where('invoices.financialyear', '22-23')
		//->where('teammembers.role_id','!=',13)
		//->where('invoices.client_id',38)
    ->where('teammembers.status','!=',0)
    ->where('createdby',auth()->user()->teammember_id)
         ->select('invoices.*','clients.client_name','teammembers.team_member'
         ,'assignments.assignment_name','invoices.client_id as client_id','assignments.assignment_name'
         ,'assignments.id as assignmentid',)->orderBy('id', 'desc')    
				   ->distinct()
         ->get();

       
			
        }

        return view('backEnd.performanceappraisal.index',compact('appraisal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
