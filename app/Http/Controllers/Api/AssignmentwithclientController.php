<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

class AssignmentwithclientController extends Controller
{
    public function findByClientId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
               ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {

                $assignments = DB::table('assignmentbudgetings')->where('client_id', $request->client_id)
                ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
                ->select('assignments.id','assignmentbudgetings.assignmentgenerate_id','assignments.assignment_name')
                ->orderBy('assignment_name')->get();

                $response['result'] = $assignments;
                $response['msg'] = "True";
                $response['code'] = "10001";
            
               

        
            }
         catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong ". $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }
     
        return response()->json($response);
     
    }

}
