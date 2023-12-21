<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Teammember;
use App\Models\Assetticket;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use App\Models\Replyticket;
use DB;
class TicketController extends Controller
{
    public function ticketReply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticketid' => 'required',
            'reply' => 'required',
            'createdby' => 'required'
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
                $data=$request->except(['_token']);
                if($request->hasFile('attachment'))
                {
                    $file=$request->file('attachment');
                    $extension=$file->getClientOriginalExtension();
                    $filename=time().'.'.$extension;
                    $file->move('backEnd/image/ticketreplyattachment',$filename);
                    $data['attachment']=$filename;
                }
                $data['createdby']=$request->createdby;
                $result =   Replyticket::Create($data);
				 DB::table('assettickets')->where('generateticket_id',$request->ticketid)->update([	
                'status'         =>    $request->status, 
                 'updated_at' => date('y-m-d')     
                 ]);
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
   
   	 public function ticketreplyList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticketid' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {

               $result = DB::table('replytickets')
               ->leftjoin('teammembers','teammembers.id','replytickets.createdby')->
				    where('replytickets.ticketid',$request->ticketid)->
               select('replytickets.*','teammembers.team_member')->get();
               foreach($result as $res)
               {
                 if($res->attachment == null)
                 {
                   
                   $res->attachment = null; 
                 }
                 else {
                   $res->attachment = url('backEnd/image/ticketreplyattachment/'.$res->attachment);
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
   
    public function insertTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'priority' => 'required',
            'message' => 'required',
          //  'attachment' => 'required'
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
                $data=$request->except(['_token']);
                if($request->hasFile('attachment'))
                {
                    $file=$request->file('attachment');
                    $extension=$file->getClientOriginalExtension();
                    $filename=time().'.'.$extension;
                    $file->move('backEnd/image/ticketattachment',$filename);
                    $data['attachment']=$filename;
                }
              
                $data['generateticket_id']=sprintf("%06d", mt_rand(1,99999999));
              $result =  Assetticket::Create($data);
           
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
    public function ticketList(Request $request)
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
                if($role == 11 || $role == 16){
                    $result =  DB::table('assettickets')
                    ->leftjoin('assets','assets.id','assettickets.asset_id')
                    ->leftjoin('teammembers','teammembers.id','assettickets.created_by')
                  
                    ->select('assettickets.*','assets.item','teammembers.team_member')->get();
                }
                else {
                    $result =  DB::table('assettickets')
                    ->leftjoin('assets','assets.id','assettickets.asset_id')
                    ->leftjoin('teammembers','teammembers.id','assettickets.created_by')
                    ->where('assettickets.created_by',$request->teammemberid)
                  
                    ->select('assettickets.*','assets.item','teammembers.team_member')->get();
                }
        //   dd($result);
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
