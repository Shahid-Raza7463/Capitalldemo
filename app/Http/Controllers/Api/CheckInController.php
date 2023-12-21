<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Log;
use App\Models\Checkin;
use Carbon\Carbon;


class CheckInController extends Controller
{
    //

  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'teammember_id' => 'required',
        'checkin_from' => 'required',
        //'date' => 'required',
        //'time' => 'required',
        // 'month'=> 'required',
    ]);

    if ($validator->fails()) {
        $response['msg'] = $validator->errors();
        $response['status'] = 0;

        return  response()->json($response);
    }

    try {
        $checkintoday = Checkin::where('teammember_id', $request->input('teammember_id'))
            ->where('date', $request->input('date'))
            ->first();
		$currentDate = Carbon::now()->format('d-m-Y');
		$currentTime = Carbon::now()->format('H:i:s');

	
        if (!$checkintoday) {
            $checkin = new Checkin();
            $checkin->teammember_id = $request->input('teammember_id');
            $checkin->checkin_from = $request->input('checkin_from');
            $checkin->month = $request->input('month');
            $checkin->typeval = $request->input('typeval');
            $checkin->client_id = $request->input('client_id');
            $checkin->assignment_id = $request->input('assignment_id');
            $checkin->place = $request->input('place');
            $checkin->date =$currentDate;
            $checkin->time = $currentTime;
			$checkin->latitude = $request->input('latitude');
			$checkin->longitude = $request->input('longitude');
            $checkin->checkout_time = $request->input('checkout_time');
            $checkin->save();
            return response()->json(["output" => "insert successfully", "status" => "true", "code" => "10001"]);
        } else {
            $response['result'] = "failed";
            $response['msg'] = "You have already checked in!";
            $response['code'] = "10002";
        }
    } catch (\Exception $e) {
        $response['result'] = "failed";
        $response['msg'] = "Something went wrong " . $e->getMessage();
        $response['code'] = "500";
        Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
    }

    return response()->json($response);
}

	 public function clientlist()
    {
		   try {
			   
			
       $client = DB::table('clients')
    
    
    ->latest()
    ->select('id', 'client_name','gstno')
    ->get();
			   
			   
		  $response['result'] = $client;
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
	
	 public function clientlisttask()
    {
		   try {
			   
			
         $result['client']= DB::table('clients')->latest()
   
    ->orderBy('client_name', 'ASC')
    ->select('id', 'client_name','gstno')
    ->get();

            $result['dataroomclient']= DB::table('clientlogins')
            ->join('clients','clients.id','clientlogins.client_id')
            ->select('clients.client_name','clients.id')
            ->distinct('clients.client_name')
                ->orderBy('client_name', 'asc')->get();
			   
			   
		  $response['result'] = $result;
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
	
	  public function checkInList(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'role_id' => 'required',
          'teammember_id'=>'required',
               ]);
    
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
            return  response()->json($response);
        }
    
        try {
            if($request->has('role_id'))
            {
                if($request->role_id==18 OR $request->role_id==11 )
                {
              $checkIn = DB::table('checkins')
            ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
				  ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
            ->whereDate('checkins.created_at', '=', now()->toDateString())
            ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
            ->orderBy('checkins.date', 'DESC')
            ->get();

					
			
					
                }
				//dd(now()->toDateString());
				 elseif ($request->role_id == 13 && $request->teammember_id != null) {
                    $checkIn = DB::table('checkins')
						 ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                      ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
						->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
						   ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
						 ->where('assignmentmappings.leadpartner', $request->teammember_id)
						 ->whereDate('checkins.created_at', '=', now()->toDateString())
                        ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                        ->orderBy('checkins.date', 'DESC')
                        ->get();
                   // dd($checkIn);
                }
               
                else
                {
					$checkIn= 	DB::table('checkins')
						  ->leftjoin('clients', 'clients.id', '=', 'checkins.client_id')
						  ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
						
                      
						->leftjoin('teammembers','teammembers.id','checkins.teammember_id')
                        ->where('teammember_id', $request->teammember_id)
                        ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name','teammembers.team_member')
                        ->orderBy('checkins.created_at', 'DESC')
                        ->get();
                }
                }

                
            
            else
            {
                $checkIn=DB::table('checkins')
                ->leftjoin('clients','clients.id','checkins.client_id')
               ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
						
                      
                ->where('teammember_id',$request->teammember_id)
                ->select('checkins.*','clients.client_name','assignments.assignment_name')
                ->orderBy('checkins.created_at','DESC')
                ->get();
            }
            $response['result'] = $checkIn;
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
