<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Teammember;
use Carbon\Carbon;
use DateTime;
use DB;
use Log;




class TimesheetController extends Controller
{
 
public function index(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'teammember_id' => 'required',
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($request->role_id == 11) {
            $timesheetDatas = DB::table('timesheets')
                ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
                ->leftJoin('clients', 'clients.id', '=', 'timesheetusers.client_id')
                ->leftJoin('assignments', 'assignments.id', '=', 'timesheetusers.assignment_id')
                ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.partner')
                ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheets.created_by')
                ->select(
                    'timesheets.id',
                    'timesheets.date',
                    'timesheets.month',
                    'createdby.team_member as createdby',
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.client_id) as client_id'),
                    DB::raw('GROUP_CONCAT(DISTINCT clients.client_name) as client_name'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.assignment_id) as assignment_id'),
                    DB::raw('GROUP_CONCAT(DISTINCT assignments.assignment_name) as assignment_name'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.partner) as partner'),
                    DB::raw('GROUP_CONCAT(DISTINCT teammembers.team_member) as team_member'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.workitem) as workitem'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.hour) as hour'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.totalhour) as totalhour'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.billable_status) as billable_status')
                )
                ->groupBy('timesheets.id', 'timesheets.date', 'timesheets.month', 'createdby.team_member')
                ->get();
        } else {
            $timesheetDatas = DB::table('timesheets')
                ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
                ->leftJoin('clients', 'clients.id', '=', 'timesheetusers.client_id')
                ->leftJoin('assignments', 'assignments.id', '=', 'timesheetusers.assignment_id')
                ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.partner')
                ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheets.created_by')
                ->where('timesheets.created_by', $request->teammember_id)
                ->select(
                    'timesheets.id',
                    'timesheets.date',
                    'timesheets.month',
                    'createdby.team_member as createdby',
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.client_id) as client_id'),
                    DB::raw('GROUP_CONCAT(DISTINCT clients.client_name) as client_name'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.assignment_id) as assignment_id'),
                    DB::raw('GROUP_CONCAT(DISTINCT assignments.assignment_name) as assignment_name'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.partner) as partner'),
                    DB::raw('GROUP_CONCAT(DISTINCT teammembers.team_member) as team_member'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.workitem) as workitem'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.hour) as hour'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.totalhour) as totalhour'),
                    DB::raw('GROUP_CONCAT(DISTINCT timesheetusers.billable_status) as billable_status')
                )
                ->groupBy('timesheets.id', 'timesheets.date', 'timesheets.month', 'createdby.team_member')
                ->get();
        }

        $timesheetDataArray = [];

        foreach ($timesheetDatas as $timesheetData) {
            $clientIds = explode(',', $timesheetData->client_id);
            $clientNames = explode(',', $timesheetData->client_name);
            $clients = array_combine($clientIds, $clientNames);
        
            // Remove client IDs from the array
            $clientsWithoutIds = [];
            foreach ($clients as $clientId => $clientName) {
                $clientsWithoutIds[] = $clientName;
            }
        
            $assignmentIds = explode(',', $timesheetData->assignment_id);
            $assignmentNames = explode(',', $timesheetData->assignment_name);
            $assignment = array_combine($assignmentIds, $assignmentNames);

            $assignmentWithoutIds = [];
            foreach ($assignment as $assignmentid => $assignmentName) {
                $assignmentWithoutIds[] = $assignmentName;
            }

            $partnerIds = explode(',', $timesheetData->partner);
            $partnerNames = explode(',', $timesheetData->team_member);
            $partner = array_combine($partnerIds, $partnerNames);

            $partnerWithoutIds = [];
            foreach ($partner as $partnerid => $partnerName) {
                $partnerWithoutIds[] = $partnerName;
            }

            $workitems = explode(',', $timesheetData->workitem);
            $hours = explode(',', $timesheetData->hour);
            $totalhours = explode(',', $timesheetData->totalhour);
            $billingStatuses = explode(',', $timesheetData->billable_status);
        
            $timesheetDataArray[] = [
                'id' => $timesheetData->id,
                'date' => $timesheetData->date,
                'month' => $timesheetData->month,
                'createdby' => $timesheetData->createdby,
                'client' => $clientsWithoutIds, // Use the modified client array here
                'assignment name' => $assignmentWithoutIds,
                'partner' => $partnerWithoutIds,
                'workitem' => $workitems,
                'hour' => $hours,
                'totalhour' => $totalhours,
                'billingstatus' => $billingStatuses,
            ];
        }
        if (empty($timesheetDataArray)) {
            return response()->json([
                'msg' => 'Data not found',
                'code' => '404',
                'status' => 'false',
            ]);
        } else {
            return response()->json([
                'data' => $timesheetDataArray,
                'msg' => 'Data retrieved successfully',
                'code' => '200',
                'status' => 'true',
            ]);
        }
    } catch (\Exception $e) {
        $response['result'] = 'failed';
        $response['msg'] = 'Something went wrong: ' . $e->getMessage();
        $response['code'] = '500';
        Log::info(json_encode(['Error in Member Transaction API-----', $e->getMessage()]));

        return $response;
    }
}

   /*public function store(Request $request)
    {
   //     dd($request);
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'assignment_id' => 'required',
            'partner' => 'required',
            'workitem' => 'required',
            'billable_status' => 'required',
            'hour' => 'required',
        ]);
    
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
    
            return $response;
        }
    
        try {
            $timesheet = DB::table('timesheets')->insertGetId([
                'month'   	=>    date('F', strtotime($request->input('date'))),
                'date' => date('Y-m-d', strtotime($request->input('date'))),
                 'created_by' => $request->input('createdby'),
                'created_at' => now(),
            ]);
    
            $count = count($request->input('assignment_id'));
    
            for ($i = 0; $i < $count; $i++) {
                $assignment = DB::table('assignmentmappings')
                    ->where('assignmentgenerate_id', $request->input('assignment_id')[$i])
                    ->first();
    
                $timesheetUser = DB::table('timesheetusers')->insert([
                    'date' => $request->input('date'),
                    'client_id' => $request->input('client_id')[$i],
                    'workitem' => $request->input('workitem')[$i],
                    'billable_status' => $request->input('billable_status')[$i],
                    'timesheetid' => $timesheet,
                    'hour' => $request->input('hour')[$i],
                    'totalhour' => $request->input('totalhour'),
                    'assignment_id' => $assignment->assignment_id,
                    'partner' => $request->input('partner')[$i],
                     'createdby' => $request->input('createdby'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            if (is_null($timesheetUser)) {
                $response['msg'] = 'Data not found';
                $response['code'] = '404';
                $response['status'] = 'false';
    
                return $response;
            } else {
                $response['msg'] = 'Insertion successful';
                $response['code'] = '10001';
                $response['status'] = 'true';
    
                return $response;
            }
        } catch (\Exception $e) {
            $response['result'] = 'failed';
            $response['msg'] = 'Something went wrong: ' . $e->getMessage();
            $response['code'] = '500';
            Log::info(json_encode(['Error in Member Transaction API-----', $e->getMessage()]));
    
            return $response;
        }
    }*/
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'client_id' => 'required',
        'assignment_id' => 'required',
        'partner' => 'required',
        'workitem' => 'required',
        'billable_status' => 'required',
        'hour' => 'required',
        'createdby' => 'required',
    ]);

    if ($validator->fails()) {
        $response['msg'] = $validator->errors();
        $response['status'] = 0;

        return $response;
    }
    try {
        $data = $request->except(['_token']);

        $leaves = DB::table('applyleaves')
            ->where('applyleaves.createdby', $request->createdby)
            ->where('status', '!=', 2)
            ->select('applyleaves.from', 'applyleaves.to')
            ->get();

        $leavess = [];
        foreach ($leaves as $leave) {
            $days = Carbon::parse($leave->from)->range(Carbon::parse($leave->to))->toArray();
            $leavess = array_merge($leavess, $days);
        }

        $currentday = Carbon::parse($request->date)->format('Y-m-d');

        if (in_array($currentday, $leavess)) {
            $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($currentday)) . ')');
            return response()->json($output, 400);
        }

        $mytime = Carbon::now();
        $currentdate = $mytime->toDateString();
		//dd($currentday);

        if ($currentday > $currentdate) {
		
			 $output = array('msg' => 'You Can Not Fill Timesheet For Future Date (' . date('d-m-Y', strtotime($currentday)) . ')');
            
			return response()->json($output, 400);
        }

        $timesheet = DB::table('timesheets')->insertGetId([
            'created_by' => $request->createdby,
            'month' => Carbon::parse($request->date)->format('F'),
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'created_at' => now(),
        ]);

        $count = count($request->assignment_id);

        for ($i = 0; $i < $count; $i++) {
            $assignment = DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

            DB::table('timesheetusers')->insert([
                'date' => $request->date,
                'client_id' => $request->client_id[$i],
                'workitem' => $request->workitem[$i],
                'billable_status' => $request->billable_status[$i],
                'timesheetid' => $timesheet,
                'date' => Carbon::parse($request->date)->format('d-m-Y'),
                'hour' => $request->hour[$i],
                'totalhour' => $request->totalhour,
                'assignment_id' => $assignment->assignment_id,
                'partner' => $request->partner[$i],
                'createdby' => $request->createdby,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Check if total hours exceed 24
        if ($request->totalhour > 24) {
            $output = array('msg' => 'Total hours cannot exceed 24 hours.');
            return response()->json($output, 400);
        }

        $hdatess = Carbon::parse($request->date)->format('Y-m-d');
        $day = Carbon::parse($hdatess)->format('d');
        $month = Carbon::parse($hdatess)->format('F');
        $currentDate = now();
        $currentMonth = $currentDate->format('F');

        $dates = [
            '26' => 'twentysix',
            '27' => 'twentyseven',
            '28' => 'twentyeight',
            '29' => 'twentynine',
            '30' => 'thirty',
            '31' => 'thirtyone',
            '01' => 'one',
            '02' => 'two',
            '03' => 'three',
            '04' => 'four',
            '05' => 'five',
            '06' => 'six',
            '07' => 'seven',
            '08' => 'eight',
            '09' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'ninghteen',
            '20' => 'twenty',
            '21' => 'twentyone',
            '22' => 'twentytwo',
            '23' => 'twentythree',
            '24' => 'twentyfour',
            '25' => 'twentyfive',
        ];

        if ($month != $currentMonth && $day > 25) {
            $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess)->addMonth();
            $month = $dateTime->format('F');
        } elseif ($month != $currentMonth && $day < 25) {
            $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess);
            $month = $dateTime->format('F');
        } elseif ($month == $currentMonth && $day > 25) {
            $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess)->addMonth();
            $month = $dateTime->format('F');
        }

        $column = $dates[$day];

        $attendances = DB::table('attendances')
            ->where('employee_name', $request->createdby)
            ->where('month', $month)
            ->first();

        if ($attendances == null) {
            $teammember = DB::table('teammembers')->where('id', $request->createdby)->first();

            DB::table('attendances')->insert([
                'employee_name' => $request->createdby,
                'month' => $month,
                'dateofjoining' => $teammember->joining_date,
            ]);
        }

        if ($attendances != null && property_exists($attendances, $column)) {
            $updatedtotalhour = $request->totalhour + $attendances->$column;
        } else {
            $updatedtotalhour = $request->totalhour;
        }

        DB::table('attendances')
            ->where('employee_name', $request->createdby)
            ->where('month', $month)
            ->update([$column => $updatedtotalhour]);

        $output = array('msg' => 'Create Successfully');
        return response()->json($output, 200);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return response()->json($output, 500);
    }
}

	
	
public function partner(Request $request)
{
    $validator = Validator::make($request->all(), [
        'client_id' => 'required',
        'assignmentgenerate_id' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors()], 400);
    }

    try {
        $client_id = $request->input('client_id');
        $assignment_id = $request->input('assignmentgenerate_id');

		$partners=DB::table('assignmentmappings')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $assignment_id)->select('teammembers.id','teammembers.team_member')->get();

        if ($partners->isEmpty()) {
            return response()->json(['message' => 'No partners found.'], 404);
        }

        return response()->json($partners);
    } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred.'], 500);
    }
}

}