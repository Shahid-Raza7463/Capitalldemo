<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Validator;
use DB;

class AssetticketController extends Controller
{
    //
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'priority' => 'required',
            'message' => 'required',
            'asset_id' => 'required',
            'created_by' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
              $result =  DB::table('assettickets')->insert([
                    'subject'   	=>     $request->subject,
                    'priority'   	=>     $request->priority,
                    'message'   	=>     $request->message,
                    'asset_id'   	=>     $request->assetid,
                    'type'   	=>     $request->type,
				  'created_by'   	=>     $request->createdby,
                    'generateticket_id'  => sprintf("%06d", mt_rand(1,99999999)),
                    'status'   	=>     0,
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                ]);
            //    $teammember = Teammember::where('id',$request->teammemberid)->pluck('emailid')->first(); 
              //   dd($teammember);
             //   $data = array(
               //  'taskname' =>  $request->taskname,
             //    'duedate' =>  $request->duedate,
               //  'description' =>  $request->description,
     
        //    );
           
          //   Mail::send('emails.taskassign', $data, function ($msg) use($data, $teammember){
            //     $msg->to($teammember);
              //   $msg->subject('kgs Task Assign');
            //  });
                          if(is_null($result)){
                              return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                          }
          else {
            return response()->json(["msg"=>"insert successfully","status" =>"true","code" =>"10001"]);
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
