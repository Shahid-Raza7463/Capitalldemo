<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Connection;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
class ConnectionController extends Controller
{
    public function connectionUpdate(Request $request)
                {
                    $validator = Validator::make($request->all(), [
                        'connectionid' => 'required',
                    ]);
            
              
                    if ($validator->fails()) {
                        $response['msg'] = $validator->errors();
                        $response['status'] = 0;
                    
                        return  response()->json($response);
                    }
                        try {
                             DB::table('connections')->where('id', $request->connectionid)->update([	
                            'connectionname'         =>     $request->connectionname, 
                            'emailid'         =>     $request->emailid, 
                            'phoneno'         =>     $request->phoneno, 	
                            'connectedthrough'	            =>      $request->connectedthrough,
                          'connectedemail'         =>     $request->connectedemail,
                            'connectedphone'			=>	   $request->connectedphone,
                            'relationshipthrough'			=>	   $request->relationshipthrough,
                            'othercomments'			=>	   $request->othercomments,
                            'createdby'			=>	    $request->createdby,
                            'updated_at'              =>    date('y-m-d'),
                            ]);

                            $result =  DB::table('connections')->where('id', $request->connectionid)->first();
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
    public function insertConnection(Request $request)
    {
       
      $validator = Validator::make($request->all(), [
        'connectionname' => 'required',
        'emailid' => 'required',
        'phoneno' => 'required',
        
    ]);


    if ($validator->fails()) {
        $response['msg'] = $validator->errors();
        $response['status'] = 0;
    
        return  response()->json($response);
    }
        try {
           $id=DB::table('connections')->insertGetId([	
            'connectionname'         =>     $request->connectionname, 
            'emailid'         =>     $request->emailid, 
            'phoneno'         =>     $request->phoneno,
			    'linkedin'         =>     $request->linkedin, 
            'connectedthrough'	            =>      $request->connectedthrough,
          'connectedemail'         =>     $request->connectedemail,
            'connectedphone'			=>	   $request->connectedphone,
            'relationshipthrough'			=>	   $request->relationshipthrough,
            'othercomments'			=>	   $request->othercomments,
            'createdby'			=>	    $request->createdby,
            'created_at'			    =>	   date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
            ]);
		
			 if	(count($request->companyname) > 0){
         $count=count($request->companyname);
     //     dd($count);
          for($i=0;$i<$count;$i++){
         $result=    DB::table('connectioncompanies')->insert([
                 'connection_id'   	=>     $id,
                 'companyname'   	=>     $request->companyname[$i],
                 'designation'   	=>     $request->designation[$i],
                 'expertise'   	=>     $request->expertise[$i],
                 'createdby'  =>  $request->createdby,
                 'created_at'			    =>	   date('y-m-d'),
                 'updated_at'              =>    date('y-m-d'),
             ]);
          }
		}
                          if(is_null($result)){
                              return response()->json(["msg"=>"insert successfully","status" =>"true","code" =>"10001"]);
                          }
          else {
            return response()->json(["msg"=>"insert successfully","status" =>"true","code" =>"10001"]);
          }
         

           } catch (\Exception $e) {
               $response['status'] = "true";
               $response['msg'] = "insert successfully";
               $response['code'] = "10001";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
	  public function connectionDelete(Request $request)
          {
              $validator = Validator::make($request->all(), [
                  'connectionid' => 'required',
              ]);
      
        
              if ($validator->fails()) {
                  $response['msg'] = $validator->errors();
                  $response['status'] = 0;
              
                  return  response()->json($response);
              }
                  try {
                    $result =   DB::table('connections')->where('id',$request->connectionid)->delete();
					   $cid = DB::table('connectioncompanies')->where('connection_id',$request->connectionid)->first();
      //  dd($cid);
           if($cid != null){
              DB::table('connectioncompanies')->where('connection_id',$request->connectionid)->delete();
           }
                
                    if($result == 0){
                   
                      return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                                }
                else {
                  return response()->json(["msg"=>"data delete successfully","status" =>"true","code" =>"10001"]);
                }
               
      
                 } catch (\Exception $e) {
                     $response['result'] = "failed";
                     $response['msg'] = "Something went wrong ". $e->getMessage();
                     $response['code'] = "500";
                     Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
                 }
              
                 return response()->json($response);
              
                  
                }
    public function connectionList(Request $request)
    {
            try {
              $result = Connection::with('connectioncompany')->get();
  
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
