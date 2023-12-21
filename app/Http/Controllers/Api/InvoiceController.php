<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;

class InvoiceController extends Controller
{
    public function invoice_List(Request $request)
 
    {
        // $validator = Validator::make($request->all(), [
        //     'clientid' => 'required',
        // ]);

  
        // if ($validator->fails()) {
        //     $response['msg'] = $validator->errors();
        //     $response['status'] = 0;
        
        //     return  response()->json($response);
        // }
            try {

                $result = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('assignments','assignments.id','invoices.assignment_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
        ->where('invoices.status',2)
        ->select('invoices.*','clients.client_name','assignments.assignment_name','teammembers.team_member  as partner')->latest()->get();
              
               foreach($result as $res)
                {
                  if($res->igst !=null)
                  {
                    $res->totalgst = ($res->amount +  $res->pocketexpenseamount)*$res->igst/100; 
                  }
                  else {
                    $res->totalgst = ($res->amount +  $res->pocketexpenseamount)*$res->cgst/100 + ($res->amount +  $res->pocketexpenseamount)*$res->sgst/100;
                  }
             
           
                              
               
              }

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
