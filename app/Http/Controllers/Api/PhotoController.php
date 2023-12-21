<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\Assetregister;
use Image;
class PhotoController extends Controller
{
      public function pvformUpDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clientid' =>  'required',
			
        ]);

        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
               
				$result = DB::table("photos")->where('barcode', $request->clientid)->get();
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
