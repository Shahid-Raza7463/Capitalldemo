<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Informationresource;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;

class ClientinformationController extends Controller
{
    public function information(Request $request)
 
    {
        $validator = Validator::make($request->all(), [
            'clientid' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {

                $result = DB::table('informationresources')
        ->leftjoin('teammembers','teammembers.id','informationresources.uploadedby')->
        where('informationresources.client_id',$request->clientid)->select('informationresources.*','teammembers.team_member')->get();
              
               foreach($result as $res)
                {
                  if($res->document == null)
                  {
                    $res->document = null; 
                  }
                  else {
                    $res->document = url('storage/app/backEnd/image/document/'.$res->document);
                  }
                  if($res->status == 0)
                  {
                    $res->status = "pending";
                  }
                  else {
                    $res->status = "received";
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
           public function informationUpdate(Request $request)
 
    {
        $validator = Validator::make($request->all(), [
            'informationresource_id' => 'required',
            'authid' => 'required',
            'document' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {

              $id = $request->informationresource_id;
              if($request->hasFile('document'))
              {
                  $file=$request->file('document');
                      $destinationPath =  storage_path('app/backEnd/image/document');
                      $name = $file->getClientOriginalName();
                     $s = $file->move($destinationPath, $name);
                           $data['document'] = $name;
                 
              }
              $data['uploadedby'] = $request->authid;
              $data['updateby'] =  $request->authid;
              $data['status'] = 1;
              $result =  Informationresource::find($id)->update($data);
              
              if(is_null($result)){
               
                  return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                            }
            else {
              return response()->json(["output" => "insert successfully","status" =>"true","code" =>"10001"]);
            }

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
    public function clientTrail(Request $request)
 
    {
        $validator = Validator::make($request->all(), [
            'informationresource_id' => 'required',
            'authid' => 'required',
            'authclientid' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {

              $result =  DB::table('clienttrails')
              ->join('clientlogins','clientlogins.id','clienttrails.createdby')
              
              ->where('clienttrails.informationresources_id',$request->informationresource_id)
              ->where('clienttrails.createdby',$request->authid)
              ->where('clienttrails.clientid',$request->authclientid)
              ->select('clienttrails.description','clienttrails.created_at','clienttrails.id', 'clientlogins.name' )->orderBy('id', 'DESC')->get();

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
