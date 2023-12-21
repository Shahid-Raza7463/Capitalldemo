<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Assignmentevaluation;
use App\Models\Teammember;
use App\Models\Assignment;
use App\Models\Carbon;
use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class AssignmentevaluationController extends Controller
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
    
  public function index(Request $request)
    {
	  
	     
     if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
          $assignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
			//  ->where('assignmentevaluations.status',1)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();
		  
		   $countevaluated=count(
         DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.status','1')
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());

         $countpendingevaluated=count(
          DB::table('assignmentevaluations')
           ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
           ->leftjoin('roles','roles.id','teammembers.role_id')
           ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
           ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
           ->where('assignmentevaluations.status','0')
          ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
          ->get());
         
            $countnotsubmitted=count(
            DB::table('assignmentevaluations')
                      ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
                      ->leftjoin('roles','roles.id','teammembers.role_id')
                      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
                      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
                      ->where('assignmentevaluations.status','3')
                      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
                      ->get());

		  $countinvoiced=count(
            DB::table('assignmentevaluations')
                      ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
                      ->leftjoin('roles','roles.id','teammembers.role_id')
                      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
                      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
                      ->where('assignmentevaluations.status','4')
                      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
                      ->get());
		  
		  
		  
                    
                    return view('backEnd.assignmentevaluation.index',compact('assignmentData','countevaluated'
                    ,'countpendingevaluated','countnotsubmitted','countinvoiced'));
          }
      elseif(auth()->user()->role_id == 15 || auth()->user()->role_id == 13){
        $assignmentData  = DB::table('assignmentevaluations')
        ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
        ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
        ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
        ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
       ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
       ->get();
		  
		  $countevaluated=count(
			   DB::table('assignmentevaluations')
        ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
        ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
        ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
		->where('assignmentevaluations.status',1)
        ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
       ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
       ->get());
		  $countpendingevaluated=count(
			   DB::table('assignmentevaluations')
        ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
        ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
        ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
		->where('assignmentevaluations.status',0)
        ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
       ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
       ->get());
		
		  $countnotsubmitted=count(
			   DB::table('assignmentevaluations')
        ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
        ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
        ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
		->where('assignmentevaluations.status',1)
        ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
       ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
       ->get());
		
		
       return view('backEnd.assignmentevaluation.index',compact('assignmentData','countevaluated'
                    ,'countpendingevaluated','countnotsubmitted'));
    }
     else {
        $myassignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();
		  
		  
		   $countevaluated=count(DB::table('assignmentevaluations')
       ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
       ->leftjoin('roles','roles.id','teammembers.role_id')
       ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
       ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
       ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
       ->where('assignmentevaluations.status',1)
      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
      ->get());
      $countpendingevaluated=count(DB::table('assignmentevaluations')
       ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
       ->leftjoin('roles','roles.id','teammembers.role_id')
       ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
       ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
       ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
       ->where('assignmentevaluations.status',0)
      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
      ->get());

      $countnotsubmitted=count(DB::table('assignmentevaluations')
      ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
      ->leftjoin('roles','roles.id','teammembers.role_id')
      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
      ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
      ->where('assignmentevaluations.status',3)
     ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
     ->get());

     $countinvoiced=count(DB::table('assignmentevaluations')
     ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
     ->leftjoin('roles','roles.id','teammembers.role_id')
     ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
     ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
     ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
     ->where('assignmentevaluations.status',4)
    ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
    ->get());

        $assignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();
		  
		   $countteamevaluated=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
									 ->where('assignmentevaluations.status',1)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
		  
		  $countteampendingforevaluation=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
											   ->where('assignmentevaluations.status',0)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
		  
		  $countteamnotsubmitted=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
									   ->where('assignmentevaluations.status',3)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
         $countteaminvoiced=count(DB::table('assignmentevaluations')
         ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
         ->leftjoin('roles','roles.id','teammembers.role_id')
         ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
         ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
         ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
                    ->where('assignmentevaluations.status',3)
        ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
        ->get());
    
		  
		//  dd($assignmentData);
         return view('backEnd.assignmentevaluation.staffindex',compact('assignmentData','countinvoiced','myassignmentData',
         'countevaluated','countnotsubmitted','countpendingevaluated','countteampendingforevaluation'
         ,'countteamnotsubmitted','countteamevaluated','countteaminvoiced'));
      }
        

  }
	 public function show(Request $request)
    {
	  
	      if($request->ajax())
      {
       // dd($request);
       $clientdata=explode (",",$request->cid);
      
      if (isset($request->cid)) {
          echo "<option>Select Assignment</option>";
 foreach (DB::table('assignmentbudgetings')->whereIn('client_id', $clientdata)
 ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
 ->orderBy('assignment_name')->get() as $sub) {
 echo "<option value='" . $sub->assignment_id . "'>" . $sub->assignment_name . "</option>";
 
            }
        }
    if (isset($request->assignment)) {
        //  dd($request->assignment);

        $assignmentdata=explode (",",$request->assignment);
     
          echo "<option>Select Partner</option>";
          foreach (DB::table('assignmentevaluations')
          ->leftJoin('teammembers', 'teammembers.id', 'assignmentevaluations.assignment_partner')
          ->whereIn('assignmentevaluations.nature_of_assignment', $assignmentdata)
          ->groupBy('teammembers.id')
          ->select('teammembers.id', 'teammembers.team_member')
          ->get() as $subs) {
              echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
      }
            
      }

      if (isset($request->ass_id)) {
        //  dd($request->assignment);

        $assignmentdata=explode (",",$request->ass_id);
     
          echo "<option value=''>Select Employee</option>";
          foreach (DB::table('assignmentevaluations')
       //   ->leftJoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
          ->leftJoin('teammembers', 'teammembers.id', 'assignmentevaluations.createdby')
          ->whereIn('assignmentevaluations.nature_of_assignment', $assignmentdata)
          ->groupBy('teammembers.id')
          ->select('teammembers.id', 'teammembers.team_member')
          ->get() as $subs) {
              echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
      }
            
      }
   
    
       // dd($request);
        

     
      }
  else
{
  /*$assignmentData  = DB::table('assignmentevaluations')
  ->leftJoin('teammembers as partner_tm', 'partner_tm.id', 'assignmentevaluations.assignment_partner')
  ->leftJoin('teammembers as creator_tm', 'creator_tm.id', 'assignmentevaluations.createdby')
  ->leftjoin('roles','roles.id','partner_tm.role_id')
  ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
  ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
 ->select('assignmentevaluations.*','roles.rolename','partner_tm.team_member as partner_team_member', 
 'creator_tm.team_member as creator_team_member','clients.client_name','assignments.assignment_name')
 ->get();*/
 
 //return response()->json($assignmentData);

  
  return view('backEnd.assignmentevaluation.indexnew');
  }


  }

	public function Filters(Request $request)
  {
  //dd($request);
  if($request->ajax())
  {
    if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
      $query  = DB::table('assignmentevaluations')
      ->leftJoin('teammembers as partner_tm', 'partner_tm.id', 'assignmentevaluations.assignment_partner')
      ->leftJoin('teammembers as creator_tm', 'creator_tm.id', 'assignmentevaluations.createdby')
      ->leftjoin('roles','roles.id','creator_tm.role_id')
      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
     ->select('assignmentevaluations.*','roles.rolename','partner_tm.team_member as partner_team_member', 
     'creator_tm.team_member as creator_team_member','clients.client_name','assignments.assignment_name');
     
    }
    elseif(auth()->user()->role_id == 15 || auth()->user()->role_id == 13){
      $query  = DB::table('assignmentevaluations')
      ->leftJoin('teammembers as partner_tm', 'partner_tm.id', 'assignmentevaluations.assignment_partner')
      ->leftJoin('teammembers as creator_tm', 'creator_tm.id', 'assignmentevaluations.createdby')
       ->leftjoin('roles','roles.id','creator_tm.role_id')
      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
      ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
      ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
     ->select('assignmentevaluations.*','roles.rolename',
     'partner_tm.team_member as partner_team_member','creator_tm.team_member as creator_team_member', 
'clients.client_name','assignments.assignment_name');
     //->get();
    }    
    else {
      $query  = DB::table('assignmentevaluations')
      ->leftJoin('teammembers as partner_tm', 'partner_tm.id', 'assignmentevaluations.assignment_partner')
      ->leftJoin('teammembers as creator_tm', 'creator_tm.id', 'assignmentevaluations.createdby')
      ->leftjoin('roles','roles.id','creator_tm.role_id')
        ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
        ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
        ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
       ->select('assignmentevaluations.*','roles.rolename',
        'partner_tm.team_member as partner_team_member','creator_tm.team_member as creator_team_member', 
       'clients.client_name','assignments.assignment_name');
      // ->get();
    } 
    if($request->has('clientid'))
    {
      $clientdata=explode (",",$request->clientid);
    }
    if($request->has('assignmentid'))
    {
      $assignmentid=explode (",",$request->assignmentid);
    }
    if($request->has('partnerid'))
    {
      $partnerid=explode (",",$request->partnerid);
    }
    if($request->has('employeeid'))
    {
      $employeeid=explode (",",$request->employeeid);
    }



    if(!empty($request->clientid))   
    {    
            
      $query->whereIn('assignmentevaluations.clients_name', $clientdata);

    }
    if(!empty($request->assignmentid))   
    {    
            
      $query->whereIn('assignmentevaluations.nature_of_assignment', $assignmentid);

    }
    if(!empty($request->partnerid))   
    {    
            
      $query->whereIn('assignmentevaluations.assignment_partner', $partnerid);

    }
   
    
    if (!empty($request->clientid) && !empty($request->assignmentid)) {
            
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid);

    }
    if (!empty($request->clientid) && !empty($request->partnerid)) {
            
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.assignment_partner',$partnerid);

    }
   
    if(!empty($request->partnerid)&& !empty($request->assignmentid))   
    {    
            
      $query->whereIn('assignmentevaluations.assignment_partner', $partnerid)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid);


    }
    if(!empty($request->partnerid)&& !empty($request->employeeid))   
    {    
            
      $query->whereIn('assignmentevaluations.assignment_partner', $partnerid)
      ->whereIn('assignmentevaluations.createdby',$employeeid);


    }
    if (!empty($request->clientid) && !empty($request->assignmentid)&& 
    !empty($request->partnerid) && !empty($request->employeeid)) {
      //  dd($request);    
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
     // ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid)
      ->whereIn('assignmentevaluations.createdby',$employeeid);

    }
    
   
    if (!empty($request->clientid) && !empty($request->assignmentid)&& !empty($request->partnerid)) {
      //  dd($request);    
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid)
      ->whereIn('assignmentevaluations.assignment_partner',$partnerid);

    }
    if (!empty($request->clientid) && !empty($request->assignmentid)&& !empty($request->employeeid)) {
            
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid)
      ->whereIn('assignmentevaluations.createdby',$employeeid);

    }
    if (!empty($request->clientid) && !empty($request->assignmentid)&& !empty($request->partnerid)
    && $request->status !=null ) {
      //  dd($request);    
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid)
      ->whereIn('assignmentevaluations.assignment_partner',$partnerid)
      ->where('assignmentevaluations.status',$request->status);

    }
    if (!empty($request->clientid) && !empty($request->assignmentid)&& !empty($request->employeeid)
    && $request->status !=null ) {
      //  dd($request);    
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid)
      ->whereIn('assignmentevaluations.createdby',$employeeid)
      ->where('assignmentevaluations.status',$request->status);

    }
    
    

    if (!empty($request->clientid) && !empty($request->assignmentid)&& !empty($request->partnerid)
    && !empty($request->employeeid)) {
            
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid)
      ->whereIn('assignmentevaluations.assignment_partner',$partnerid)
      ->whereIn('assignmentevaluations.createdby',$employeeid);

    }

    if (!empty($request->clientid) && !empty($request->assignmentid)&& !empty($request->partnerid)
    && !empty($request->employeeid) && $request->status!=null) {
            
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid)
      ->whereIn('assignmentevaluations.assignment_partner',$partnerid)
      ->whereIn('assignmentevaluations.createdby',$employeeid)
      ->where('assignmentevaluations.status','=',$request->status);

    }


   
    if (!empty($request->clientid) && !empty($request->assignmentid) && $request->status!=null) {
     
   
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->whereIn('assignmentevaluations.nature_of_assignment',$assignmentid)
      ->where('assignmentevaluations.status','=',$request->status);

    }
   
    if (!empty($request->clientid) && $request->status!=null) {
  
      $query->whereIn('assignmentevaluations.clients_name', $clientdata)
      ->where('assignmentevaluations.status','=',$request->status);

    }
    if ( $request->status!=null) {
  
      $query
      ->where('assignmentevaluations.status','=',$request->status);

    }
   
    if (!empty($request->partnerid) && $request->status!=null) {
  
      $query->whereIn('assignmentevaluations.assignment_partner', $partnerid)
      ->where('assignmentevaluations.status','=',$request->status);

    }
   
   
   
   // $assignmentData = $query->get();

   $assignmentData = $query->get();

  //    dd($assignmentData);
   // return DataTables::of($assignmentData)->make(true);

   return response()->json($assignmentData);

  }
 
  }
  
   public function view($id)
   {

       $assignmentevaluation = Assignmentevaluation::where('id', $id)->first();
     // dd($assignmentevaluation);
       return view('backEnd.assignmentevaluation.view', compact('id','assignmentevaluation'));
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
   
        $teammember = Teammember::where('role_id',13)->with('title','role')->where('status',1)->get();
        $staffData = Teammember::where('role_id','!=',11)->where('role_id','!=',12)->with('title','role')->where('status',1)->get();
      //  dd($staffData);
      if(auth()->user()->role_id == 15){
        $teammemberpartner = Teammember::where('role_id','=',13)->orwhere('role_id','=',14)->orwhere('role_id','=',18)->where('status',1)->with('title','role')->get();
      }
		elseif(auth()->user()->role_id==13)
		{
			 $teammemberpartner = Teammember::where('role_id','=',13)->orwhere('role_id','=',14)->where('status',1)->with('title','role')->get();
     
		}
      else {
        $teammemberpartner = Teammember::where('role_id','=',13)->orwhere('role_id','=',14)->where('status',1)->with('title','role')->get();
      }
        $clientData = DB::table('clients')->select('id','client_name')->get();
        $assignment = Assignment::select('id','assignment_name')->get();
      
        if ($request->ajax()) {
          //  dd($request);
             if (isset($request->cid)) {
               echo "<option>Select Assignment</option>";
      foreach (DB::table('assignmentbudgetings')
      ->leftjoin('invoices','invoices.assignmentgenerate_id','assignmentbudgetings.assignmentgenerate_id')
      ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
      ->where('invoices.client_id', $request->cid)
      ->where('invoices.year','=','2023')
      ->select('assignmentbudgetings.assignmentgenerate_id','assignments.assignment_name')
      ->orderBy('assignment_name')->get() as $sub) {
      echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name."(".$sub->assignmentgenerate_id.")".
 "</option>";
      
                 }
             }  
             if (isset($request->assignment)) {
              echo "<option>Select Partner</option>";
              foreach (DB::table('assignmentmappings')
              ->leftjoin('teammembers','teammembers.id','assignmentmappings.leadpartner')
              ->where('assignmentgenerate_id', $request->assignment)->select('teammembers.id','teammembers.team_member')->get() as $sub) {

                  echo "<option value='" . $sub->id . "'>" . $sub->team_member . "</option>";
              }
          }         
         }
         else{
        return view('backEnd.assignmentevaluation.create',compact('teammember','clientData','assignment','teammemberpartner','staffData'));
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
    //     $request->validate([
    //          'name' => "required",
            
    //    ]);

         try {
             $data=$request->except(['_token']);
           $assignment_id =  DB::table('assignmentbudgetings')->where('assignmentgenerate_id',$request->nature_of_assignment)->pluck('assignment_id')->first();
            $data['status'] = 0;
            $data['nature_of_assignment'] = $assignment_id;
			  $data['assignmentgenerate_id']=$request->nature_of_assignment;

            $data['createdby'] = auth()->user()->teammember_id;
             $assignmentevaluation = Assignmentevaluation::Create($data);
             $assignmentevaluation->save();
             $id = $assignmentevaluation->id;

           $clients =  DB::table('clients')->where('id',$request->clients_name)->pluck('client_name')->first();
           $team_member =   DB::table('teammembers')->where('id',$request->assignment_report_manager)->first();
           $createdby =   DB::table('teammembers')->where('id',auth()->user()->teammember_id)->first();
             $data = array(
              'email' => $team_member->emailid,
              'clients' => $clients,
                'name' => $createdby->team_member,
                'id' =>  $id,
        );
         Mail::send('emails.assignmentevaluationform', $data, function ($msg) use($data){
             $msg->to($data['email']);
             $msg->subject('New Assignment Evaluation Form Request');
          }); 
             $output = array('msg' => 'Create Successfully');
             return redirect('assignmentevaluation')->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
 }
 /*public function update(Request $request, $id)
    {
        // $request->validate([
        //     'Name' => "required",
        // ]);
     //   dd($request);
        try {
             $data=$request->except(['_token']);

             $approvedpartner = Assignmentevaluation::where('id',$id)->first();
             $team_member =   DB::table('teammembers')->where('id',$approvedpartner->assignment_report_manager)->first();
             $createdby =   DB::table('teammembers')->where('id',$approvedpartner->createdby)->first();
             
             if($approvedpartner->assignment_report_manager == auth()->user()->teammember_id){
              $data['status'] = 1;  
              $data['approveddate'] =  date('Y-m-d H:i:s');  
             }
             else
             {
              $data['status'] = 0;  
             }
       Assignmentevaluation::find($id)->update($data);
     
       if($approvedpartner->assignment_report_manager == auth()->user()->teammember_id){
       $data = array(
            'name' => $team_member->team_member,
            'createdby' => $createdby->team_member,
            'id' =>  $id,
    );
     Mail::send('emails.assignmentevaluationapprovedform', $data, function ($msg) use($data){
         $msg->to('priyankasharma@kgsomani.com');
         $msg->subject('Assignment Evaluation - Approved');
      }); 
       }
       $output = array('msg' => 'Updated Successfully');
            return redirect('assignmentevaluation')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
   */
	public function update(Request $request, $id)
    {
        // $request->validate([
        //     'Name' => "required",
        // ]);
    //    dd($request);
        try {
             $data=$request->except(['_token']);

             $approvedpartner = Assignmentevaluation::where('id',$id)->first();
             $team_member =   DB::table('teammembers')->where('id',$approvedpartner->assignment_report_manager)->first();
             $createdby =   DB::table('teammembers')->where('id',$approvedpartner->createdby)->first();
             
             if($approvedpartner->assignment_report_manager == auth()->user()->teammember_id){
              $data['status'] = 1;  
              $data['approveddate'] =  date('Y-m-d H:i:s');  
             }
             else
             {
              $data['status'] = 0;  
             }
       Assignmentevaluation::find($id)->update($data);
     
       if($approvedpartner->assignment_report_manager == auth()->user()->teammember_id){
       $data = array(
            'name' => $team_member->team_member,
            'createdby' => $createdby->team_member,
            'id' =>  $id,
    );
     Mail::send('emails.assignmentevaluationapprovedform', $data, function ($msg) use($data){
         $msg->to('priyankasharma@kgsomani.com');
         $msg->subject('Assignment Evaluation - Approved');
      }); 
       }
       $output = array('msg' => 'Updated Successfully');
            return redirect('assignmentevaluation')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function edit($id)
    {
  //  dd($id);
  $teammember = Teammember::where('role_id',13)->with('title','role')->where('status',1)->get();
  $staffData = Teammember::where('role_id','!=',11)->where('role_id','!=',12)->with('title','role')->where('status',1)->get();
  $clientData = DB::table('clients')->select('id','client_name')->get();   
  $teammemberpartner = Teammember::where('role_id','=',13)->orwhere('role_id','=',14)->orwhere('role_id','=',18)->where('status',1)->with('title','role')->get();   
  $assignmentevaluationData = Assignmentevaluation::where('id', $id)->first();
  //     dd($assignmentevaluationData);
      
        return view('backEnd.assignmentevaluation.edit', compact('assignmentevaluationData','teammember','staffData','clientData','teammemberpartner'));
    }

	 public function assignmentevaluationonType(Request $request,$type="")
    {
      //dd($type);
      if($type !=null)
      {
        if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
          $assignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.status',$type)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();

         $countevaluated=count(
         DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
         // ->where('assignmentevaluations.status',$type)
          ->where('assignmentevaluations.status','1')
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());

         $countpendingevaluated=count(
          DB::table('assignmentevaluations')
           ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
           ->leftjoin('roles','roles.id','teammembers.role_id')
           ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
           ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          // ->where('assignmentevaluations.status',$type)
           ->where('assignmentevaluations.status','0')
          ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
          ->get());
         
            $countnotsubmitted=count(
            DB::table('assignmentevaluations')
                      ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
                      ->leftjoin('roles','roles.id','teammembers.role_id')
                      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
                      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
                     // ->where('assignmentevaluations.status',$type)
                      ->where('assignmentevaluations.status','3')
                      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
                      ->get());
                    
                      $countinvoiced=count(
                        DB::table('assignmentevaluations')
                                  ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
                                  ->leftjoin('roles','roles.id','teammembers.role_id')
                                  ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
                                  ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
                                 // ->where('assignmentevaluations.status',$type)
                                  ->where('assignmentevaluations.status','4')
                                  ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
                                  ->get());
                      
                    return view('backEnd.assignmentevaluation.index',compact('assignmentData','countevaluated'
                    ,'countpendingevaluated','countnotsubmitted','countinvoiced'));
      }
    
      elseif(auth()->user()->role_id == 15 || auth()->user()->role_id == 13){
       // dd('hi');
        $assignmentData  = DB::table('assignmentevaluations')
        ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
        ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
        ->where('assignmentevaluations.status',$type)
        ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
        ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
       ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
       ->get();

       return view('backEnd.assignmentevaluation.index',compact('assignmentData'));
    }
     
      else {
        $myassignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
          ->where('assignmentevaluations.status',$type)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();
		  
		  
		   $countevaluated=count(DB::table('assignmentevaluations')
       ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
       ->leftjoin('roles','roles.id','teammembers.role_id')
       ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
       ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
       ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
       ->where('assignmentevaluations.status',1)
      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
      ->get());
      $countpendingevaluated=count(DB::table('assignmentevaluations')
       ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
       ->leftjoin('roles','roles.id','teammembers.role_id')
       ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
       ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
       ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
       ->where('assignmentevaluations.status',0)
      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
      ->get());

      $countnotsubmitted=count(DB::table('assignmentevaluations')
      ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
      ->leftjoin('roles','roles.id','teammembers.role_id')
      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
      ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
      ->where('assignmentevaluations.status',3)
     ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
     ->get());

     $countinvoiced=count(DB::table('assignmentevaluations')
     ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
     ->leftjoin('roles','roles.id','teammembers.role_id')
     ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
     ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
     ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
     ->where('assignmentevaluations.status',4)
    ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename',
    'clients.client_name','assignments.assignment_name')
    ->get());

        $assignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
          ->where('assignmentevaluations.status',$type)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();
		  
		   $countteamevaluated=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
									 ->where('assignmentevaluations.status',1)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
		  
		  $countteampendingforevaluation=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
											   ->where('assignmentevaluations.status',0)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
		  
		  $countteamnotsubmitted=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
									   ->where('assignmentevaluations.status',3)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
         $countteaminvoiced=count(DB::table('assignmentevaluations')
         ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
         ->leftjoin('roles','roles.id','teammembers.role_id')
         ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
         ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
         ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
                    ->where('assignmentevaluations.status',4)
        ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
        ->get());
   
		  
		//  dd($assignmentData);
         return view('backEnd.assignmentevaluation.staffindex',compact('assignmentData','myassignmentData',
         'countevaluated','countnotsubmitted','countpendingevaluated',
         'countteampendingforevaluation','countteamnotsubmitted','countteamevaluated','countinvoiced','countteaminvoiced'));
      

      }
    }
      else
      {
      if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
          $assignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();

         $countevaluated=count(
         DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.status','1')
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());

         $countpendingevaluated=count(
          DB::table('assignmentevaluations')
           ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
           ->leftjoin('roles','roles.id','teammembers.role_id')
           ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
           ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
           ->where('assignmentevaluations.status','0')
          ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
          ->get());
         
            $countnotsubmitted=count(
            DB::table('assignmentevaluations')
                      ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
                      ->leftjoin('roles','roles.id','teammembers.role_id')
                      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
                      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
                      ->where('assignmentevaluations.status','3')
                      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
                      ->get());
                    
                    return view('backEnd.assignmentevaluation.index',compact('assignmentData','countevaluated'
                    ,'countpendingevaluated','countnotsubmitted'));
      }
      elseif(auth()->user()->role_id == 15 || auth()->user()->role_id == 13){
       // dd('hi');
        $assignmentData  = DB::table('assignmentevaluations')
        ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
        ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
        ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
        ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
       ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
       ->get();

       $countevaluated=count(
        DB::table('assignmentevaluations')
        ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
        ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
        ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
        ->where('assignmentevaluations.status',1)
        ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
       ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
       ->get());

        $countpendingevaluated=count(
          DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
          ->where('assignmentevaluations.status',0)
          ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
  
           $countnotsubmitted=count(
            DB::table('assignmentevaluations')
            ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
            ->leftjoin('roles','roles.id','teammembers.role_id')
            ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
            ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
            ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
            ->where('assignmentevaluations.status',1)
            ->orwhere('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
           ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
           ->get());
    

       return view('backEnd.assignmentevaluation.index',compact('assignmentData','countevaluated','countpendingevaluated','countnotsubmitted'));
    }
     

      else {
        $myassignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();
		  
		  
		   $countevaluated=count(DB::table('assignmentevaluations')
       ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
       ->leftjoin('roles','roles.id','teammembers.role_id')
       ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
       ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
       ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
       ->where('assignmentevaluations.status',1)
      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
      ->get());
      $countpendingevaluated=count(DB::table('assignmentevaluations')
       ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
       ->leftjoin('roles','roles.id','teammembers.role_id')
       ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
       ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
       ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
       ->where('assignmentevaluations.status',0)
      ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
      ->get());

      $countnotsubmitted=count(DB::table('assignmentevaluations')
      ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
      ->leftjoin('roles','roles.id','teammembers.role_id')
      ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
      ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
      ->where('assignmentevaluations.createdby',auth()->user()->teammember_id)
      ->where('assignmentevaluations.status',3)
     ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
     ->get());

        $assignmentData  = DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get();
		  
		   $countteamevaluated=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
									 ->where('assignmentevaluations.status',1)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
		  
		  $countteampendingforevaluation=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
											   ->where('assignmentevaluations.status',0)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
		  
		  $countteamnotsubmitted=count(DB::table('assignmentevaluations')
          ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
          ->leftjoin('roles','roles.id','teammembers.role_id')
          ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
          ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
          ->where('assignmentevaluations.assignment_report_manager',auth()->user()->teammember_id)
									   ->where('assignmentevaluations.status',3)
         ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename','clients.client_name','assignments.assignment_name')
         ->get());
		  
		//  dd($assignmentData);
         return view('backEnd.assignmentevaluation.staffindex',compact('assignmentData','myassignmentData',
         'countevaluated','countnotsubmitted','countpendingevaluated','countteampendingforevaluation','countteamnotsubmitted','countteamevaluated'));
      }
        }
        

  }
	
	public function assignmentevaluationreport(Request $request)
  {
	//	dd('hi');
    $employeename = Teammember::where('role_id','!=',11)->with('title','role')->get();
    $client = Client::select('id','client_name')->get();
    $assignment = Assignment::select('id','assignment_name')->get();
    $partner= Teammember::where('role_id','=',13)->with('title','role')->get();
	
 $assignmentDa  = DB::table('assignmentevaluations')
  ->leftJoin('teammembers as partner_tm', 'partner_tm.id', 'assignmentevaluations.assignment_partner')
  ->leftJoin('teammembers as creator_tm', 'creator_tm.id', 'assignmentevaluations.createdby')
  ->leftjoin('roles','roles.id','creator_tm.role_id')
  ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
  ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
 ->select('assignmentevaluations.*','roles.rolename','partner_tm.team_member as partner_team_member', 
 'creator_tm.team_member as creator_team_member','clients.client_name','assignments.assignment_name')
 ->get();
 
 //return response()->json($assignmentData);

 // dd($assignmentData);
  return view('backEnd.assignmentevaluation.indexnew',compact('assignment',
'partner','employeename','assignmentDa'));

  }


	
    
}
