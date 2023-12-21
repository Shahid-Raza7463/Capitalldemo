<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Assetprocurement;
use App\Models\Tender;
use App\Models\Teammember;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
use Carbon;
class AssetprocurementController extends Controller
{
  
    public function assetprocurement_List(Request $request)
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
                if($role == 11 || $role == 16 || $role == 17){
              $result =   $assetprocurementDatas  =DB::table('assetprocurements')
              ->leftjoin('teammembers','teammembers.id','assetprocurements.teammember_id')
              ->leftjoin('teammembers as employee','employee.id','assetprocurements.createdby')
             
                   ->select('assetprocurements.id','assetprocurements.created_at','teammembers.team_member as approver','assetprocurements.companyname','assetprocurements.teammember_id as approverid','assetprocurements.itemname',
                   'assetprocurements.startdate','assetprocurements.enddate','assetprocurements.placeofpurchase','assetprocurements.amount',
                   'assetprocurements.remark','assetprocurements.paymenttype','assetprocurements.Status','assetprocurements.bill',
                   'employee.team_member as employee')->latest()->get();

            foreach($result as $res)
            {
              if($res->bill == null)
                      {
                        
                        $res->bill = null; 
                      }
                      else {
                        $res->bill = url('backEnd/image/assetprocurements/'.$res->bill);
                      }
                if($res->Status==0)
                {
                  $res->Status = "Created";
                }
                else if($res->Status==1)
                {
                  $res->Status = "Approved";
                }
                elseif($res->Status==2){
                  $res->Status = "Rejected"; 
                }
             elseif($res->Status==3){
                  $res->Status = "Paid"; 
                }
           
                if($res->paymenttype==0)
                {
                  $res->paymenttype = "Reimbursement";
               
                }
                else{
                  $res->paymenttype = "Advance"; 
                }
          }
                }
                else {
                  $result =   $assetprocurementDatas  =DB::table('assetprocurements')
                  ->leftjoin('teammembers','teammembers.id','assetprocurements.teammember_id')
                  ->leftjoin('teammembers as employee','employee.id','assetprocurements.createdby')
                  ->where('assetprocurements.createdby',$request->teammemberid)
                  ->orwhere('assetprocurements.teammember_id',$request->teammemberid)
                       ->select('assetprocurements.id','assetprocurements.created_at','teammembers.team_member as approver','assetprocurements.companyname','assetprocurements.itemname',
                       'assetprocurements.startdate','assetprocurements.teammember_id as approverid','assetprocurements.enddate','assetprocurements.placeofpurchase','assetprocurements.amount',
                       'assetprocurements.remark','assetprocurements.paymenttype','assetprocurements.Status','assetprocurements.bill',
                       'employee.team_member as employee')->latest()->get();
    
                foreach($result as $res)
                {
                  if($res->bill == null)
                          {
                            
                            $res->bill = null; 
                          }
                          else {
                            $res->bill = url('backEnd/image/assetprocurements/'.$res->bill);
                          }
                    if($res->Status==0)
                    {
                      $res->Status = "Created";
                    }
                    else if($res->Status==1)
                    {
                      $res->Status = "Approved";
                    }
                    elseif($res->Status==2){
                      $res->Status = "Rejected"; 
                    }
                 
                   elseif($res->Status==3){
                  $res->Status = "Paid"; 
                }
                    if($res->paymenttype==0)
                    {
                      $res->paymenttype = "Reimbursement";
                   
                    }
                    else{
                      $res->paymenttype = "Advance"; 
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
     public function update_status(Request $request)
          {
              $validator = Validator::make($request->all(), [
                  'assetprocurementid' => 'required',
              ]);
      
        
              if ($validator->fails()) {
                  $response['msg'] = $validator->errors();
                  $response['status'] = 0;
              
                  return  response()->json($response);
              }
                  try {
                       DB::table('assetprocurements')->where('id', $request->assetprocurementid)->update([	
                      'Status'         =>     $request->status ??'', 
                      'remark'         =>     $request->remark ??'', 
                      ]);

                      $result =  "data update done";
                      if(is_null($result)){
       
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
	 public function assetprocurement_Insert(Request $request)
                {
                    $validator = Validator::make($request->all(), [
                        'companyname' => 'required',
                        'itemname' => 'required',
                        'startdate' => 'required',
                        'enddate' => 'required',
                        'placeofpurchase' => 'required',
                        'teammember_id' => 'required',
                        'amount' => 'required',
                        'paymenttype' => 'required',
                        'bill' => 'required',
                        'userteammemberid' => 'required',
                    ]);
            
              
                    if ($validator->fails()) {
                        $response['msg'] = $validator->errors();
                        $response['status'] = 0;
                    
                        return  response()->json($response);
                    }
                        try {
                          
                          $data=$request->except(['_token','userteammemberid']);
                                 if($request->hasFile('bill'))
                                 {
                                     $file=$request->file('bill');
                                         $destinationPath = 'backEnd/image/assetprocurements';
                                         $name = $file->getClientOriginalName();
                                        $s = $file->move($destinationPath, $name);
                                              //  dd($s); die;
                                              $data['bill'] = $name;
                                    
                                 }
                                 $data['createdby'] = $request->userteammemberid;
                                  $data['Status'] = 0;
                                 $assetprocurementModel = Assetprocurement::Create($data);
                         
                             
                        return response()->json(["msg"=>"insert successfully","status" =>"true","code" =>"10001"]);
                    
                     
            
                       } catch (\Exception $e) {
                           $response['result'] = "failed";
                           $response['msg'] = "Something went wrong ". $e->getMessage();
                           $response['code'] = "500";
                           Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
                       }
                    
                       return response()->json($response);
                    
                        
                      }
	 public function teammemberList(Request $request)
                      {
                        
                              try {
                                $result =  DB::table('teammembers')
                                ->leftjoin('roles','roles.id','teammembers.role_id')
                                ->where('teammembers.role_id','=',13)->orwhere('teammembers.role_id','=',14)
                                ->select('teammembers.team_member','roles.rolename',
                                'teammembers.id')->get();
                             
                                if(is_null($result)){
                               
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
