<?php

namespace App\Http\Controllers;

use App\Models\Timesheetrequest;
use App\Models\Teammember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimesheetrequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function timesheetupdatesubmit(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
                //   dd($request->id);
                $conversion = DB::table('timesheetusers')
                    ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                    ->where('timesheetusers.id', $request->id)
                    ->select('teammembers.team_member', 'timesheetusers.*')->first();
                //  dd($conversion);
                return response()->json($conversion);
            }
        }
    }
    public function timesheet_submit(Request $request)
    {
        //dd($request);
        try {
            $hours = $request->input('totalhour');
            if (!is_numeric($hours) || $hours > 12) {
                $output = array('msg' => 'The total hours cannot be greater than 12');
                return back()->with('success', $output);
            }

            DB::table('timesheetusers')->where('id', $request->timesheetid)->update([
                'client_id' => $request->client_id,
                'assignment_id' => $request->assignment_id,
                'workitem' => $request->workitem,
                'totalhour' => $request->totalhour,
                'partner' => $request->partner,
                'location' => $request->location,
                'updatedby'  => auth()->user()->teammember_id,
                'updated_at'              =>    date('y-m-d'),
            ]);

            $output = array('msg' => 'Save Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    //! old code before submitted timesheet patner in one place  
    // public function timesheetsubmission(Request $request)
    // {
    //     // $request->validate([
    //     //     'companyname' => "required",
    //     // ]);

    //     try {
    //         $usertimesheetfirstdate =  DB::table('timesheets')
    //             ->where('status', '0')
    //             ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
    //         // dd($usertimesheetfirstdate->date);
    //         $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);


    //         //------------------- Suhail's code start---------------------



    //         if ($usertimesheetfirstdate) {
    //             // Convert the retrieved date to a DateTime object
    //             $firstDate = new DateTime($usertimesheetfirstdate->date);

    //             // Find the day of the week for the first date (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
    //             $dayOfWeek = $firstDate->format('w');

    //             $daysToAdd = 0;
    //             if ($dayOfWeek !== '0') {
    //                 $daysToAdd = 7 - $dayOfWeek;
    //             } else {
    //                 $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
    //                 return back()->with('success', $output);
    //             }

    //             if ($dayOfWeek > 0) {
    //                 $daysToSubtract = $dayOfWeek - 1;
    //             } else {
    //                 $daysToSubtract = $dayOfWeek;
    //             }

    //             $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
    //             $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
    //         }



    //         $get_six_Data = DB::table('timesheets')
    //             ->where('status', '0')
    //             ->where('created_by', auth()->user()->teammember_id)
    //             ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
    //             ->orderBy('date', 'ASC')
    //             ->get();

    //         $lastdate = $get_six_Data->max('date');



    //         $retrievedDates = [];   //copy dates in retrievedDates array in datetime format

    //         foreach ($get_six_Data as $entry) {
    //             $date = new DateTime($entry->date);
    //             $retrievedDates[] = $date->format('Y-m-d');
    //         }



    //         $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday

    //         $firstDate = new DateTime($presentWeekMonday);
    //         $upcomingSundayDate = new DateTime($upcomingSunday);

    //         // Clone $firstDate so that it is not modified
    //         $currentDate = clone $firstDate;


    //         while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
    //             $expectedDates[] = $currentDate->format('Y-m-d');
    //             $currentDate->modify("+1 day");
    //         }

    //         // Check for missing dates
    //         $missingDates = array_diff($expectedDates, $retrievedDates);


    //         if (!empty($missingDates)) {
    //             $missingDatesString = implode(', ', $missingDates);

    //             $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
    //             return back()->with('success', $output);
    //         } else {   //"All dates present"    //------------------- Suhail's code end---------------------

    //             foreach ($get_six_Data as $getsixdata) {


    //                 // Convert the requested date to a Carbon instance
    //                 $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

    //                 if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {

    //                     $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

    //                     // Find the nearest next Saturday to the requested date
    //                     $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
    //                     //dd($nextSaturday);
    //                     // Format the dates in 'Y-m-d' format
    //                     $previousMondayFormatted = $getsixdata->date;
    //                     $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
    //                     $nextSaturdayFormatted = $lastdate;

    //                     $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));
    //                     $co = DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)
    //                         ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    //                         ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
    //                         ->groupBy('partner')
    //                         ->get();
    //                     foreach ($co as $codata) {
    //                         DB::table('timesheetreport')->insert([
    //                             'teamid'       =>     auth()->user()->teammember_id,
    //                             'week'       =>     $week,
    //                             'totaldays'       =>     $codata->row_count,
    //                             'totaltime' =>  $codata->total_hours,
    //                             'partnerid'  => $codata->partner,
    //                             'startdate'  => $previousMondayFormatted,
    //                             'enddate'  => $nextSaturdayFormatted,
    //                             // 'created_at'                =>       date('y-m-d'),
    //                             'created_at'                =>      date('y-m-d H:i:s'),
    //                         ]);
    //                     }

    //                     // dd($co);
    //                 }
    //                 // else {

    //                 //      // Find the nearest previous Monday to the requested date
    //                 // $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

    //                 // // Find the nearest next Saturday to the requested date
    //                 // $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
    //                 // //dd($nextSaturday);
    //                 // // Format the dates in 'Y-m-d' format
    //                 // $previousMondayFormatted = $previousMonday->format('Y-m-d');
    //                 // $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
    //                 // }




    //                 DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
    //                     'status'         =>     1,
    //                     'updated_at'              =>    date('y-m-d'),
    //                 ]);
    //                 DB::table('timesheets')->where('id', $getsixdata->id)->update([
    //                     'status'         =>     1,
    //                     'updated_at'              =>    date('y-m-d'),
    //                 ]);
    //             }
    //         }


    //         $output = array('msg' => 'Timesheet Submit Successfully');
    //         return back()->with('success', $output);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }
    //! zxzx submi 26-12-23
    public function timesheetsubmission(Request $request)
    {
        // dd($request);
        try {
            $usertimesheetfirstdate =  DB::table('timesheets')
                ->where('status', '0')
                ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
            $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

            if ($usertimesheetfirstdate) {
                $firstDate = new DateTime($usertimesheetfirstdate->date);
                $dayOfWeek = $firstDate->format('w');
                $daysToAdd = 0;

                if ($dayOfWeek !== '0') {
                    $daysToAdd = 7 - $dayOfWeek;
                } else {
                    $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                    return back()->with('success', $output);
                }

                if ($dayOfWeek > 0) {
                    $daysToSubtract = $dayOfWeek - 1;
                } else {
                    $daysToSubtract = $dayOfWeek;
                }

                $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

                $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
            }



            $get_six_Data = DB::table('timesheets')
                ->where('status', '0')
                ->where('created_by', auth()->user()->teammember_id)
                ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                ->orderBy('date', 'ASC')
                ->get();

            $lastdate = $get_six_Data->max('date');


            $retrievedDates = [];   //copy dates in retrievedDates array in datetime format

            foreach ($get_six_Data as $entry) {
                $date = new DateTime($entry->date);
                $retrievedDates[] = $date->format('Y-m-d');
            }

            $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday

            $firstDate = new DateTime($presentWeekMonday);

            $upcomingSundayDate = new DateTime($upcomingSunday);


            // Clone $firstDate so that it is not modified
            $currentDate = clone $firstDate;

            while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                $expectedDates[] = $currentDate->format('Y-m-d');


                $currentDate->modify("+1 day");
            }

            $missingDates = array_diff($expectedDates, $retrievedDates);

            if (!empty($missingDates)) {
                $missingDatesString = implode(', ', $missingDates);
                // "2023-11-13, 2023-11-14"

                $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                return back()->with('success', $output);
            } else {

                foreach ($get_six_Data as $getsixdata) {
                    // dd('hi', $getsixdata);

                    // Convert the requested date to a Carbon instance
                    $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);


                    if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {

                        $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

                        // Find the nearest next Saturday to the requested date
                        $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

                        // Format the dates in 'Y-m-d' format
                        $previousMondayFormatted = $getsixdata->date;
                        $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                        $nextSaturdayFormatted = $lastdate;


                        $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

                        //------------------- Shahid's code start---------------------
                        $co = DB::table('timesheetusers')
                            ->where('createdby', auth()->user()->teammember_id)
                            ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                            ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                            ->get();


                        // dd($co);
                        foreach ($co as $codata) {
                            DB::table('timesheetreport')->insert([
                                'teamid'       =>     auth()->user()->teammember_id,
                                'week'       =>     $week,
                                'totaldays'       =>     $codata->row_count,
                                'totaltime' =>  $codata->total_hours,
                                // 'partnerid'  => $codata->partner,
                                'startdate'  => $previousMondayFormatted,
                                'enddate'  => $nextSaturdayFormatted,
                                // 'created_at'                =>       date('y-m-d'),
                                'created_at'                =>      date('y-m-d H:i:s'),
                            ]);
                        }

                        // dd($co);
                    }



                    DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
                        'status'         =>     1,
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                    DB::table('timesheets')->where('id', $getsixdata->id)->update([
                        'status'         =>     1,
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                }
            }


            $output = array('msg' => 'Timesheet Submit Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }


    public function timesheetsubmit(Request $request)
    {
        //dd($request);
        try {
            if ($request->ids == null) {

                $output = array('msg' => 'Please tick one of the checkbox');
                return back()->with('success', $output);
            } else {

                foreach ($request->ids as $timsheetid) {

                    DB::table('timesheetusers')->where('id', $timsheetid)->update([
                        'status'         =>     1,
                        'updatedby'  => auth()->user()->teammember_id,
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                }

                $output = array('msg' => 'Submit Successfully');
                return back()->with('success', $output);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    public function index()
    {

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
            $timesheetrequestsDatas = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'createdby.team_member as createdbyauth'
                )->get();
            //  dd($timesheetrequestsDatas);
            return view('backEnd.timesheetrequest.index', compact('timesheetrequestsDatas'));
        } elseif (auth()->user()->role_id == 13) {
            $timesheetrequestsDatas = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.partner', auth()->user()->teammember_id)
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'createdby.team_member as createdbyauth'
                )->get();
            //  dd($timesheetrequestsDatas);
            return view('backEnd.timesheetrequest.index', compact('timesheetrequestsDatas'));
        } else {
            $timesheetrequestsDatas = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.createdby', auth()->user()->teammember_id)

                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'createdby.team_member as createdbyauth'
                )->get();

            return view('backEnd.timesheetrequest.index', compact('timesheetrequestsDatas'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Timesheetrequest  $timesheetrequest
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timesheetrequest = DB::table('timesheetrequests')
            ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
            ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
            ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
            ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
            ->where('timesheetrequests.id', $id)
            ->select(
                'timesheetrequests.*',
                'clients.client_name',
                'assignments.assignment_name',
                'teammembers.team_member',
                'createdby.team_member as createdbyauth'
            )->first();
        return view('backEnd.timesheetrequest.view', compact('id', 'timesheetrequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Timesheetrequest  $timesheetrequest
     * @return \Illuminate\Http\Response
     */
    public function edit(Timesheetrequest $timesheetrequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Timesheetrequest  $timesheetrequest
     * @return \Illuminate\Http\Response
     */
    //! old code 
    // public function update(Request $request, $id)
    // {
    //     dd($request);
    //     try {
    //         $data = $request->except(['_token']);
    //         if ($request->status == 1) {
    //             $currentdate = date('Y-m-d');
    //             $date = Carbon::createFromFormat('Y-m-d', $currentdate ?? '')->addDays(4);
    //             $holidaydate = $date->format('Y-m-d');
    //             $data['validate'] = $holidaydate;
    //         }

    //         Timesheetrequest::find($id)->update($data);
    //         $created = DB::table('timesheetrequests')->where('id', $id)->first();
    //         $teammembermail = Teammember::where('id', $created->createdby)->first();
    //         $data = array(
    //             'email' => $teammembermail->emailid ?? '',
    //             'status' => $created->status ?? '',
    //             'date' => $created->validate ?? '',
    //             'id' => $id ?? ''
    //         );
    //         Mail::send('emails.timesheetrequestapprovelform', $data, function ($msg) use ($data) {
    //             $msg->to($data['email']);
    //             $msg->subject('VSA Timesheet Approval');
    //         });
    //         $output = array('msg' => 'Update Successfully');
    //         return redirect('timesheetrequestlist')->with('success', $output);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }

    // ! curently working
    // Approved and reject timesheet request. timereq
    // public function update(Request $request, $id)
    // {
    //     // dd($request);
    //     try {
    //         $data = $request->except(['_token']);
    //         if ($request->status == 1) {
    //             $currentdate = date('Y-m-d');
    //             $date = Carbon::createFromFormat('Y-m-d', $currentdate ?? '')->addDays(4);
    //             $holidaydate = $date->format('Y-m-d');
    //             $data['validate'] = $holidaydate;
    //         }
    //         // Current Data that is click by admin
    //         $timesheetrequestdata = DB::table('timesheetrequests')
    //             ->where('id', $id)
    //             ->first();
    //         // Find latest timesheet Request
    //         $latestrequest = DB::table('timesheetrequests')
    //             ->where('createdby', $timesheetrequestdata->createdby)
    //             ->latest()->first();
    //         // check latest timesheet Request == Current Data that is click by admin
    //         if ($latestrequest->id == $timesheetrequestdata->id) {
    //             // approve timesheet request
    //             if ($latestrequest) {
    //                 DB::table('timesheetrequests')
    //                     ->where('id', $latestrequest->id)
    //                     ->update(['status' => 1]);
    //             }
    //         } else {
    //             $output = array('msg' => 'Please Approve Latest Timesheet Request');
    //             return redirect('timesheetrequestlist')->with('statuss', $output);
    //         }
    //         // Find all rest data after approving
    //         $allrestrequest =  DB::table('timesheetrequests')->where('createdby', $timesheetrequestdata->createdby)->where('status', 0)->get();
    //         // reject all reset timesheet request
    //         foreach ($allrestrequest as $allrestrequestdata) {
    //             DB::table('timesheetrequests')->where('createdby', $allrestrequestdata->createdby)->where('status', 0)->update([
    //                 'status'  => 2,
    //                 'remark'  => 'Duplicate Request',
    //             ]);
    //         }
    //         // timesheet request list rejected end 
    //         $created = DB::table('timesheetrequests')->where('id', $id)->first();
    //         $teammembermail = Teammember::where('id', $created->createdby)->first();
    //         $data = array(
    //             'email' => $teammembermail->emailid ?? '',
    //             'status' => $created->status ?? '',
    //             'date' => $created->validate ?? '',
    //             'id' => $id ?? ''
    //         );
    //         Mail::send('emails.timesheetrequestapprovelform', $data, function ($msg) use ($data) {
    //             $msg->to($data['email']);
    //             $msg->subject('VSA Timesheet Approval');
    //         });
    //         $output = array('msg' => 'Update Successfully');
    //         return redirect('timesheetrequestlist')->with('success', $output);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }
    // ! curently working
    public function update(Request $request, $id)
    {
        // dd($request);
        try {
            $data = $request->except(['_token']);
            if ($request->status == 1) {
                $currentdate = date('Y-m-d');
                $date = Carbon::createFromFormat('Y-m-d', $currentdate ?? '')->addDays(4);
                $holidaydate = $date->format('Y-m-d');
                $data['validate'] = $holidaydate;
            }

            // When approve btn click 
            if ($request->status == 1) {
                // Current Data that is click by admin
                $timesheetrequestdata = DB::table('timesheetrequests')
                    ->where('id', $id)
                    ->first();
                // Find latest timesheet Request
                $latestrequest = DB::table('timesheetrequests')
                    ->where('createdby', $timesheetrequestdata->createdby)
                    ->latest()->first();
                // check latest timesheet Request == Current Data that is click by admin
                if ($latestrequest->id == $timesheetrequestdata->id) {
                    // approve timesheet request
                    // dd($data);
                    if ($latestrequest) {
                        DB::table('timesheetrequests')
                            ->where('id', $latestrequest->id)
                            // ->update(['status' => 1]);
                            ->update($data);
                    }
                } else {
                    $output = array('msg' => 'Please Approve Latest Timesheet Request');
                    return redirect('timesheetrequestlist')->with('statuss', $output);
                }
                // Find all rest data after approving
                $allrestrequest =  DB::table('timesheetrequests')->where('createdby', $timesheetrequestdata->createdby)->where('status', 0)->get();
                // reject all reset timesheet request
                foreach ($allrestrequest as $allrestrequestdata) {
                    DB::table('timesheetrequests')->where('createdby', $allrestrequestdata->createdby)->where('status', 0)->update([
                        'status'  => 2,
                        'remark'  => 'Duplicate Request',
                    ]);
                }
            }
            // When Reject btn click 
            else {
                // dd($request->remark);
                // Current Data that is click by admin
                $timesheetrequestdata = DB::table('timesheetrequests')
                    ->where('id', $id)
                    ->first();
                // Find latest timesheet Request
                $latestrequest = DB::table('timesheetrequests')
                    ->where('createdby', $timesheetrequestdata->createdby)
                    ->latest()->first();
                // check latest timesheet Request == Current Data that is click by admin
                if ($latestrequest->id == $timesheetrequestdata->id) {
                    // approve timesheet request
                    if ($latestrequest) {
                        DB::table('timesheetrequests')
                            ->where('id', $latestrequest->id)
                            ->update([
                                'status' => 2,
                                'remark' => $request->remark,
                            ]);
                    }
                } else {
                    $output = array('msg' => 'Please Reject Latest Timesheet Request');
                    return redirect('timesheetrequestlist')->with('statuss', $output);
                }
                // Find all rest data after approving
                $allrestrequest =  DB::table('timesheetrequests')->where('createdby', $timesheetrequestdata->createdby)->where('status', 0)->get();
                // reject all reset timesheet request
                foreach ($allrestrequest as $allrestrequestdata) {
                    DB::table('timesheetrequests')->where('createdby', $allrestrequestdata->createdby)->where('status', 0)->update([
                        'status'  => 2,
                        'remark'  => 'Duplicate Request',
                    ]);
                }
            }

            // timesheet request list rejected end 
            $created = DB::table('timesheetrequests')->where('id', $id)->first();
            $teammembermail = Teammember::where('id', $created->createdby)->first();
            $data = array(
                'email' => $teammembermail->emailid ?? '',
                'status' => $created->status ?? '',
                'date' => $created->validate ?? '',
                'id' => $id ?? ''
            );
            Mail::send('emails.timesheetrequestapprovelform', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject('VSA Timesheet Approval');
            });
            $output = array('msg' => 'Update Successfully');
            return redirect('timesheetrequestlist')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Timesheetrequest  $timesheetrequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timesheetrequest $timesheetrequest)
    {
        //
    }
}
