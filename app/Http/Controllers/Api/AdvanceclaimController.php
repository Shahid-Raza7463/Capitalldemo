<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Teammember;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
use Carbon;
class AdvanceclaimController extends Controller
{
  
    public function List(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teammemberid' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
              $role = Teammember::where('id', $request->teammemberid)->pluck('role_id')->first();
                if($role == 11 || $role == 18 || $role == 17){
              $result =  $travelDatas  =DB::table('travel')
              ->leftjoin('teammembers','teammembers.id','travel.teammember_id')
              ->leftjoin('teammembers as teams','teams.id','travel.createdby')
              ->leftjoin('assignments','assignments.id','travel.assignment_id')
                   ->leftjoin('clients','clients.id','travel.client_id')
                   ->select('travel.id as advanceclaimid','travel.chooseconveyance','travel.travelstatus',
                   'travel.Nature_of_Assignment','travel.created_at','travel.Expected_date_of_departure as startdate','travel.Expected_date_of_arrival as enddate',
                   'travel.advanceamount as AdvanceAmountRequired','travel.Advance_Amount as AdvanceAmountGiven','travel.Status','travel.adjustablestatus',
                   'travel.adjust','travel.Place_of_visit','travel.Billable',
                   'travel.remark','travel.comment',
                   'teammembers.team_member as approver','teams.team_member as employee'
                   ,'clients.client_name','assignments.assignment_name  as assignmentsname')->latest()->get();

            foreach($result as $res)
            {
              $res->created_at =  date('F d,Y', strtotime($res->created_at));
              $res->startdate =  date('F d,Y', strtotime($res->startdate));
              $res->enddate =  date('F d,Y', strtotime($res->enddate));
                if($res->travelstatus==0)
                {
                  $res->travelstatus = "Created";
                }
                else if($res->travelstatus==1)
                {
                  $res->travelstatus = "Approved";
                }
                elseif($res->travelstatus==2){
                  $res->travelstatus = "Rejected"; 
                }
                if($res->Billable==0)
                {
                  $res->Billable = "Yes";
                }
                else if($res->Billable==1)
                {
                  $res->Billable = "No";
                }
              

                if($res->Status==0)
                {
                  $res->Status = "Paid";
                }
                else if($res->Status==1)
                {
                  $res->Status = "On Hold";
                }
                elseif($res->Status==2){
                  $res->Status = "Pending"; 
                }
                if($res->adjustablestatus==0)
                {
                  $res->adjustablestatus = "Not Adjusted Yet";
                }
                else if($res->adjustablestatus==1)
                {
                  $res->adjustablestatus = "Adjusted";
                }
                if($res->Nature_of_Assignment != null){
                  $res->Nature_of_Assignment = $res->Nature_of_Assignment;
                }elseif($res->Nature_of_Assignment == null){
                  $res->Nature_of_Assignment = $res->assignmentsname;
                }

          }
                }
                else {
                  $result =  $travelDatas  =DB::table('travel')
                  ->leftjoin('teammembers','teammembers.id','travel.teammember_id')
                  ->leftjoin('teammembers as teams','teams.id','travel.createdby')
                  ->leftjoin('assignments','assignments.id','travel.assignment_id')
                       ->leftjoin('clients','clients.id','travel.client_id')
                       ->where('travel.createdby',$request->teammemberid)
                       ->orwhere('travel.teammember_id',$request->teammemberid)
                       ->select('travel.id as advanceclaimid','travel.chooseconveyance','travel.travelstatus',
                       'travel.Nature_of_Assignment','travel.created_at','travel.Expected_date_of_departure as startdate','travel.Expected_date_of_arrival as enddate',
                       'travel.advanceamount as AdvanceAmountRequired','travel.Advance_Amount as AdvanceAmountGiven','travel.Status','travel.adjustablestatus',
                       'travel.adjust','travel.Place_of_visit','travel.Billable',
                       'travel.remark','travel.comment',
                       'teammembers.team_member as approver','teams.team_member as employee'
                       ,'clients.client_name','assignments.assignment_name  as assignmentsname')->latest()->get();
    
                foreach($result as $res)
                {
                  $res->created_at =  date('F d,Y', strtotime($res->created_at));
                  $res->startdate =  date('F d,Y', strtotime($res->startdate));
                  $res->enddate =  date('F d,Y', strtotime($res->enddate));
                    if($res->travelstatus==0)
                    {
                      $res->travelstatus = "Created";
                    }
                    else if($res->travelstatus==1)
                    {
                      $res->travelstatus = "Approved";
                    }
                    elseif($res->travelstatus==2){
                      $res->travelstatus = "Rejected"; 
                    }
                    if($res->Billable==0)
                    {
                      $res->Billable = "Yes";
                    }
                    else if($res->Billable==1)
                    {
                      $res->Billable = "No";
                    }
                  
    
                    if($res->Status==0)
                    {
                      $res->Status = "Paid";
                    }
                    else if($res->Status==1)
                    {
                      $res->Status = "On Hold";
                    }
                    elseif($res->Status==2){
                      $res->Status = "Pending"; 
                    }
                    if($res->adjustablestatus==0)
                    {
                      $res->adjustablestatus = "Not Adjusted Yet";
                    }
                    else if($res->adjustablestatus==1)
                    {
                      $res->adjustablestatus = "Adjusted";
                    }
                    if($res->Nature_of_Assignment != null){
                      $res->Nature_of_Assignment = $res->Nature_of_Assignment;
                    }elseif($res->Nature_of_Assignment == null){
                      $res->Nature_of_Assignment = $res->assignmentsname;
                    }
    
              }
                }
              if($result->isEmpty()){
             
                return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                          }
          else {
            return response()->json(["output" => $result,"status" =>"true","code" =>"10001"]);
          }
         

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
   
}
