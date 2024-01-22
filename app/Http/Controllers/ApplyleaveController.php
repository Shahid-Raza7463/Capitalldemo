<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\Employeereferral;
use App\Models\Applyleave;
use App\Models\Leavetype;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Role;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;

class ApplyleaveController extends Controller
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
  public function open_leave($id)
  {
    if (auth()->user()->role_id == 11) {

      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.status', '0')
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();
      // dd($applyleaveDatas);
      return view('backEnd.applyleave.adminopen', compact(
        'teamapplyleaveDatas'
      ));
    } else {
      $myapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->where('applyleaves.status', 0)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->latest()->get();
      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.approver', auth()->user()->teammember_id)
        ->where('applyleaves.status', 0)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();
      return view('backEnd.applyleave.openindex', compact(
        'myapplyleaveDatas',
        'teamapplyleaveDatas'
      ));
    }
  }
  public function teamApplication()
  {
    $birthday = DB::table('leavetypes')->where('year', '2023')->where('name', 'Birthday/Religious Festival')->first();
    $Casual = DB::table('leavetypes')->where('year', '2023')->where('name', 'Casual Leave')->first();
    $Sick = DB::table('leavetypes')->where('year', '2023')->where('name', 'Sick Leave')->first();

    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $Casual->startdate);
    $currentdate = date('Y-m-d');
    $diff_in_months = $to->diffInMonths($currentdate) + 1;
    $teammember = Teammember::with('role:id,rolename')->whereNotNull('joining_date')->get(); {
      $countSick = DB::table('leaveapprove')->where('year', '2023')->where('leavetype', $Sick->id)
        ->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');
      //  dd($countSick);
      $countCasual = DB::table('leaveapprove')->where('year', '2023')->where('leavetype', $Casual->id)
        ->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');
      $countbirthday = DB::table('leaveapprove')->where('year', '2023')->where('leavetype', $birthday->id)
        ->where('teammemberid', auth()->user()->teammember_id)->count();

      //dd($takeleavecount);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      //  dd($diff_in_months);

      $myapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')

        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();

      // dd($applyleaveDatas);
      return view('backEnd.applyleave.teamapplication', compact('teammember', 'totalcountCasual', 'myapplyleaveDatas', 'birthday', 'countbirthday', 'Casual', 'Sick', 'countSick', 'countCasual'));
    }
  }

  public function examleaverequest(Request $request, $id)
  {
    try {

      if ($request->status == 1) {
        $team = DB::table('leaverequest')
          ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
          ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
          ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
          ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
          ->where('leaverequest.id', $id)
          ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
          ->first();

        if ($team->name == 'Exam Leave') {

          $from = Carbon::createFromFormat('Y-m-d', $team->from);
          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
          // came during exam leave
          $camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);

          $removedays = $to->diffInDays($camefromexam) + 1;

          $nowtotalleave = $from->diffInDays($camefromexam);
          // it si only serching data from dtabase 
          $finddatafromleaverequest = $to->diffInDays($from) + 1;

          // Update date in to  column in applyleaves table 
          $updatedcamedate = $camefromexam->copy()->subDay()->format('Y-m-d');

          // dd($updatedcamedate);

          DB::table('applyleaves')
            ->where('from', $team->from)
            ->where('to', $team->to)
            ->where('createdby', $team->createdby)
            ->update([
              'to' => $updatedcamedate,
            ]);

          // DB::table('applyleaves')
          // ->where('id', $team->id)
          // ->update([
          //   'to' => $team->date,
          // ]);


          // for approved
          DB::table('leaverequest')
            ->where('id', $team->examrequestId)
            ->update([
              'status' => 1,
            ]);

          // update total leave after came during exam
          DB::table('leaveapprove')
            ->where('teammemberid', $team->createdby)
            ->where('totaldays', $finddatafromleaverequest)
            ->latest()
            ->update([
              'totaldays' => $nowtotalleave,
              'updated_at' => now(),
            ]);

          // get date
          $period = CarbonPeriod::create($team->date, $team->to);

          $datess = [];
          foreach ($period as $date) {
            $datess[] = $date->format('Y-m-d');

            $deletedIds = DB::table('timesheets')
              ->where('created_by', $team->createdby)
              ->whereIn('date', $datess)
              ->pluck('id');

            DB::table('timesheets')
              ->where('created_by', $team->createdby)
              ->whereIn('date', $datess)
              ->delete();

            $a = DB::table('timesheetusers')
              ->whereIn('timesheetid', $deletedIds)
              ->delete();
          }

          // dd($hdatess);
          $el_leave = $datess;
          $lstatus = null;

          foreach ($el_leave as $cl_leave) {
            $cl_leave_day = date('d', strtotime($cl_leave));
            $cl_leave_month = date('F', strtotime($cl_leave));

            if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
              $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
            }

            $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)->first();
            // September
            // dd($attendances);
            $column = '';
            switch ($cl_leave_day) {
              case '26':
                $column = 'twentysix';
                break;
              case '27':
                $column = 'twentyseven';
                break;
              case '28':
                $column = 'twentyeight';
                break;
              case '29':
                $column = 'twentynine';
                break;
              case '30':
                $column = 'thirty';
                break;
              case '31':
                $column = 'thirtyone';
                break;
              case '01':
                $column = 'one';
                break;
              case '02':
                $column = 'two';
                break;
              case '03':
                $column = 'three';
                break;
              case '04':
                $column = 'four';
                break;
              case '05':
                $column = 'five';
                break;
              case '06':
                $column = 'six';
                break;
              case '07':
                $column = 'seven';
                break;
              case '08':
                $column = 'eight';
                break;
              case '09':
                $column = 'nine';
                break;
              case '10':
                $column = 'ten';
                break;
              case '11':
                $column = 'eleven';
                break;
              case '12':
                $column = 'twelve';
                break;
              case '13':
                $column = 'thirteen';
                break;
              case '14':
                $column = 'fourteen';
                break;
              case '15':
                $column = 'fifteen';
                break;
              case '16':
                $column = 'sixteen';
                break;
              case '17':
                $column = 'seventeen';
                break;
              case '18':
                $column = 'eighteen';
                break;
              case '19':
                $column = 'ninghteen';
                break;
              case '20':
                $column = 'twenty';
                break;
              case '21':
                $column = 'twentyone';
                break;
              case '22':
                $column = 'twentytwo';
                break;
              case '23':
                $column = 'twentythree';
                break;
              case '24':
                $column = 'twentyfour';
                break;
              case '25':
                $column = 'twentyfive';
                break;
            }

            if (!empty($column)) {
              // store EL/A sexteen to 25 tak 
              DB::table('attendances')
                ->where('employee_name', $team->createdby)
                ->where('month', $cl_leave_month)
                ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
                ->whereRaw("{$column} != 'LWP'")
                ->update([
                  $column => $lstatus,
                ]);
            }
          }
        }
        // For approving mail
        $applyleaveteam = DB::table('leaverequest')
          ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
          ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
          ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
          ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
          ->where('leaverequest.id', $id)
          ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
          ->get();

        if ($applyleaveteam != null) {
          foreach ($applyleaveteam as $applyleaveteammail) {
            $data = array(
              'emailid' =>  $applyleaveteammail->emailid,
              'team_member' =>  $team->team_member,
              'from' =>  $team->from,
              'to' =>  $team->to,
            );

            Mail::send('emails.applyleaveteam', $data, function ($msg) use ($data) {
              $msg->to($data['emailid']);
              $msg->subject('VSA Leave Approved');
            });
          }
        }
        $data = array(
          'emailid' =>  $team->emailid,
          'id' =>  $id,
          'from' =>  $team->from,
          'to' =>  $team->to,
        );

        Mail::send('emails.duringexamleavestatus', $data, function ($msg) use ($data) {
          $msg->to($data['emailid']);
          $msg->subject('VSA Exam Leave request Approved');
        });
      }
      if ($request->status == 2) {
        $team = DB::table('leaverequest')
          ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
          ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
          ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
          ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
          ->where('leaverequest.id', $id)
          ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
          ->first();

        DB::table('leaverequest')
          ->where('id', $team->examrequestId)
          ->update([
            'status' => 2,
          ]);

        $data = array(
          'emailid' =>  $team->emailid,
          'id' =>  $id,
          'from' =>  $team->from,
          'to' =>  $team->to,
        );

        Mail::send('emails.duringexamleavereject', $data, function ($msg) use ($data) {
          $msg->to($data['emailid']);
          // $msg->cc('priyankasharma@kgsomani.com');
          $msg->subject('VSA Exam Leave Request Reject');
        });
      }

      $output = array('msg' => 'Updated Successfully');
      return redirect('examleaverequestlist')->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function examleaverequestlist()
  {
    if (auth()->user()->role_id == 11) {

      $timesheetrequestsDatas = DB::table('leaverequest')
        ->leftjoin('teammembers', 'teammembers.id', 'leaverequest.approver')
        ->leftjoin('teammembers as createdby', 'createdby.id', 'leaverequest.createdby')
        ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        // ->where('createdby.id', auth()->user()->teammember_id)
        ->select(
          'leaverequest.*',
          'teammembers.team_member',
          'applyleaves.leavetype',
          'leavetypes.name',
          'createdby.team_member as createdbyauth'
        )->get();

      return view('backEnd.applyleave.adminrevertleave', compact(
        'timesheetrequestsDatas',

      ));
    } else {

      $timesheetrequestsDatas = DB::table('leaverequest')
        ->leftjoin('teammembers', 'teammembers.id', 'leaverequest.approver')
        ->leftjoin('teammembers as createdby', 'createdby.id', 'leaverequest.createdby')
        ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->where('createdby.id', auth()->user()->teammember_id)
        ->select(
          'leaverequest.*',
          'teammembers.team_member',
          'applyleaves.leavetype',
          'leavetypes.name',
          'createdby.team_member as createdbyauth'
        )->get();
      $myteamtimesheetrequestsDatas = DB::table('leaverequest')
        ->leftjoin('teammembers', 'teammembers.id', 'leaverequest.approver')
        ->leftjoin('teammembers as createdby', 'createdby.id', 'leaverequest.createdby')
        ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->where('leaverequest.approver', auth()->user()->teammember_id)
        ->select(
          'leaverequest.*',
          'teammembers.team_member',
          'applyleaves.leavetype',
          'leavetypes.name',
          'createdby.team_member as createdbyauth'
        )->get();

      return view('backEnd.applyleave.examrequestlist', compact('timesheetrequestsDatas', 'myteamtimesheetrequestsDatas'));
    }
  }

  public function exampleleaveshow($id)
  {
    //dd($id);
    $applyleave = DB::table('leaverequest')
      ->leftjoin('teammembers', 'teammembers.id', 'leaverequest.approver')
      ->leftjoin('teammembers as createdby', 'createdby.id', 'leaverequest.createdby')
      ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
      ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
      ->where('leaverequest.id', $id)
      ->select(
        'leaverequest.*',
        'teammembers.team_member as approverName',
        'applyleaves.leavetype',
        'leavetypes.name',
        'createdby.team_member as createdbyauth'
      )->first();
    // dd($applyleave);
    $applyleaveteam = DB::table('leaveteams')
      ->leftjoin('teammembers', 'teammembers.id', 'leaveteams.teammember_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->where('leaveteams.leave_id', $id)
      ->select('teammembers.team_member', 'roles.rolename')->get();
    // dd($fullandfinal);
    return view('backEnd.applyleave.examleaveshow', compact('id', 'applyleave', 'applyleaveteam'));
  }


  public function teamapplicationStore(Request $request)
  {
    $currentdate = date('Y-m-d');
    $currentYear = date('Y');
    $financialYearStart = $currentYear . '-04-01';
    $financialYearEnd = ($currentYear + 1) . '-03-31';
    $teammember = Teammember::with('role:id,rolename')
      ->whereNotNull('joining_date')
      ->get();


    $casualteam = DB::table('teammembers')->where('id', $request->member)->first();

    $birthday = DB::table('leavetypes')
      ->where('year', $currentYear)->where('name', 'Birthday/Religious Festival')->first();
    $Casual = DB::table('leavetypes')->where('year', $currentYear)->where('name', 'Casual Leave')->first();
    $Sick = DB::table('leavetypes')->where('year', $currentYear)->where('name', 'Sick Leave')->first();

    if ($casualteam->joining_date < $Casual->startdate) {

      $to = \Carbon\Carbon::createFromFormat('Y-m-d', $Casual->startdate);
    } else {
      $to = \Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date);
    }




    $diff_in_months = $to->diffInMonths($currentdate) + 1;
    if (\Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->diffInDays($currentdate) < 90) {
      $diff_in_months = 0;
    }
    //dd($diff_in_months);
    $teamdate = \Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date);
    //   $currentdate = date('Y-m-d');
    $teammonthcount = $teamdate->diffInMonths($currentdate) + 1;
    if ($teamdate->diffInDays($currentdate) < 90) {
      $teammonthcount = 0;
    }

    $appliedSick = DB::table('applyleaves')
      ->where('status', '!=', '2')
      ->where('leavetype', $Sick->id)
      ->where('createdby', $request->member)
      ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
      ->get();

    $countSick = 0;
    $datess = [];
    $hdatess = [];
    foreach ($appliedSick as $sickLeave) {
      $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
      $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
      $period = CarbonPeriod::create($fromDate, $toDate);


      foreach ($period as $date) {
        $datess[] = $date->format('Y-m-d');
      }

      $getholidays = DB::table('holidays')->get();


      foreach ($getholidays as $date) {
        $hdatess[] = date('Y-m-d', strtotime($date->startdate));
      }
      $datess = array_unique($datess);
    }
    $countSick = count(array_diff($datess, $hdatess));


    $appliedCasual = DB::table('applyleaves')
      ->where('status', '!=', '2')
      ->where('leavetype', $Casual->id)
      ->where('createdby', $request->member)
      ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
      ->get();

    $countCasual = 0;
    $casualDates = [];
    foreach ($appliedCasual as $CasualLeave) {

      $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
      $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
      $period = CarbonPeriod::create($fromDate, $toDate);


      foreach ($period as $date) {
        $casualDates[] = $date->format('Y-m-d');
      }

      $getholidays = DB::table('holidays')->get();

      $hdatess = [];
      foreach ($getholidays as $date) {
        $hdatess[] = date('Y-m-d', strtotime($date->startdate));
      }
      $casualDates = array_unique($casualDates);
    }
    $countCasual = count(array_diff($casualDates, $hdatess));

    $appliedCasualafmnth = DB::table('applyleaves')
      ->where('status', '!=', '2')
      ->where('leavetype', $Casual->id)
      ->where('createdby', $request->member)
      ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
      ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addDays(90))
      ->get();

    $countCasualafmnth = 0;
    $CasualafmnthDates = [];
    foreach ($appliedCasualafmnth as $CasualafmnthLeave) {

      $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->from);
      $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->to);
      $period = CarbonPeriod::create($fromDate, $toDate);


      foreach ($period as $date) {
        $CasualafmnthDates[] = $date->format('Y-m-d');
      }

      $getholidays = DB::table('holidays')->get();

      $hdatess = [];
      foreach ($getholidays as $date) {
        $hdatess[] = date('Y-m-d', strtotime($date->startdate));
      }
      $CasualafmnthDates = array_unique($CasualafmnthDates);
    }
    $countCasualafmnth = count(array_diff($CasualafmnthDates, $hdatess));

    $appliedbirthday = DB::table('applyleaves')
      ->where('status', '!=', '2')
      ->where('leavetype', $birthday->id)
      ->where('createdby', $request->member)
      ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
      ->get();
    $countbirthday = 0;
    $birthdayDates = [];
    foreach ($appliedbirthday as $birthdayLeave) {

      $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->from);
      $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->to);
      $period = CarbonPeriod::create($fromDate, $toDate);


      foreach ($period as $date) {
        $birthdayDates[] = $date->format('Y-m-d');
      }

      $getholidays = DB::table('holidays')->get();

      $hdatess = [];
      foreach ($getholidays as $date) {
        $hdatess[] = date('Y-m-d', strtotime($date->startdate));
      }
      $birthdayDates = array_unique($birthdayDates);
    }
    $countbirthday = count(array_diff($birthdayDates, $hdatess));

    //dd($diff_in_months);
    $totalcountCasual = $Casual->noofdays * $diff_in_months;
    //  dd($diff_in_months);

    //  dd($countCasualafmnth);
    $leavetaken = DB::table('leaveapprove')
      ->where('year', '2023')->where('teammemberid', $request->member)->sum('totaldays');

    $teamapplyleaveDatas  = DB::table('applyleaves')
      ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
      ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->where('applyleaves.createdby', $request->member)
      ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();

    $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
    $attendance = DB::table('attendances')
      ->where('employee_name', $request->member)
      ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
      ->get();

    $clInAttendance = 0;
    $slInAttendance = 0;
    //dd($attendance);
    foreach ($attendance as $item) {
      foreach ($columns as $column) {
        if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
          $clInAttendance++;
        }
        if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
          $slInAttendance++;
        }
      }
    }

    $role_id = Teammember::find($request->member)->role_id;


    return view('backEnd.applyleave.teamapplication', compact('countCasualafmnth', 'leavetaken', 'teammonthcount', 'totalcountCasual', 'teamapplyleaveDatas', 'birthday', 'countbirthday', 'Casual', 'Sick', 'countSick', 'countCasual', 'clInAttendance', 'slInAttendance', 'teammember', 'role_id'));
  }


  public function leaverequeststore(Request $request)
  {
    // dd($request);
    $request->validate([
      'reason' => "required",
      'date' => "required",
      'applyleaveid' => "required",
      'createdby' => "required",
      'approver' => "required",
      // 'status' => "required",
    ]);

    DB::table('leaverequest')->insert([
      'applyleaveid' => $request->applyleaveid,
      'createdby' => $request->createdby,
      'approver' => $request->approver,
      // 'status' => $request->status,
      'reason' => $request->reason,
      'date' => date('Y-m-d', strtotime($request->date)),
      'created_at'          =>     date('Y-m-d H:i:s'),
      'updated_at'              =>    date('Y-m-d H:i:s'),
    ]);

    return redirect()->back()->with('message', 'Your Request Submitted');
  }

  public function index()
  {

    $currentdate = date('Y-m-d');
    $currentYear = date('Y');
    $financialYearStart = $currentYear . '-04-01';
    $financialYearEnd = ($currentYear + 1) . '-03-31';

    $casualteam = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

    $birthday = DB::table('leavetypes')
      ->where('year', $currentYear)->where('name', 'Birthday/Religious Festival')->first();
    $Casual = DB::table('leavetypes')->where('year', $currentYear)->where('name', 'Casual Leave')->first();
    $Sick = DB::table('leavetypes')->where('year', $currentYear)->where('name', 'Sick Leave')->first();
    //  dd($casualteam);
    if ($casualteam->joining_date < $Casual->startdate) {

      $to = \Carbon\Carbon::createFromFormat('Y-m-d', $Casual->startdate);
    } else {
      $to = \Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date);
    }




    $diff_in_months = $to->diffInMonths($currentdate) + 1;
    if (\Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->diffInDays($currentdate) < 90) {
      $diff_in_months = 0;
    }
    //dd($diff_in_months);
    $teamdate = \Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date);
    //   $currentdate = date('Y-m-d');
    $teammonthcount = $teamdate->diffInMonths($currentdate) + 1;
    if ($teamdate->diffInDays($currentdate) < 90) {
      $teammonthcount = 0;
    }

    if (auth()->user()->teammember_id == 434 || auth()->user()->teammember_id == 429) {
      $teammember = Teammember::with('role:id,rolename')
        ->whereNotNull('joining_date')
        ->get();




      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;

      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);

        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->where('startdate', '>=', $toDate)
          ->where('enddate', '<=', $toDate)->select('startdate')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }

        $countSick = array_diff($datess, $hdatess);
      }

      $countSick = DB::table('leaveapprove')
        ->where('year', $currentYear)->where('leavetype', $Sick->id)
        ->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');
      //  dd($countSick);
      $countCasual = DB::table('leaveapprove')
        ->where('year', $currentYear)->where('leavetype', $Casual->id)
        ->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');

      $countCasualafmnth = DB::table('leaveapprove')
        ->where('year', $currentYear)
        ->where('leavetype', $Casual->id)
        ->where('teammemberid', auth()->user()->teammember_id)
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addMonths(3))->sum('totaldays');

      $countbirthday = DB::table('leaveapprove')
        ->where('year', $currentYear)->where('leavetype', $birthday->id)
        ->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');

      //dd($countSick);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      // dd($totalcountCasual);
      //  dd($countCasualafmnth);
      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();
      // dd($applyleaveDatas);
      return view('backEnd.applyleave.teamapplication', compact(
        'teammember',
        'countCasualafmnth',
        'teammonthcount',
        'totalcountCasual',
        'teamapplyleaveDatas',
        'birthday',
        'countbirthday',
        'Casual',
        'Sick',
        'countSick',
        'countCasual'
      ));
    } elseif (auth()->user()->role_id == 11) {

      $teammember = Teammember::with('role:id,rolename')
        ->whereNotNull('joining_date')
        ->get();

      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;
      $datess = [];
      $hdatess = [];
      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();


        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $datess = array_unique($datess);
      }
      $countSick = count(array_diff($datess, $hdatess));


      $appliedCasual = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countCasual = 0;
      $casualDates = [];
      foreach ($appliedCasual as $CasualLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $casualDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $casualDates = array_unique($casualDates);
      }
      $countCasual = count(array_diff($casualDates, $hdatess));

      $appliedCasualafmnth = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addDays(90))
        ->get();

      $countCasualafmnth = 0;
      $CasualafmnthDates = [];
      foreach ($appliedCasualafmnth as $CasualafmnthLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $CasualafmnthDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $CasualafmnthDates = array_unique($CasualafmnthDates);
      }
      $countCasualafmnth = count(array_diff($CasualafmnthDates, $hdatess));





      $appliedbirthday = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $birthday->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();
      $countbirthday = 0;
      $birthdayDates = [];
      foreach ($appliedbirthday as $birthdayLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $birthdayDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $birthdayDates = array_unique($birthdayDates);
      }
      $countbirthday = count(array_diff($birthdayDates, $hdatess));

      //dd($diff_in_months);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      //  dd($diff_in_months);

      //  dd($countCasualafmnth);
      $leavetaken = DB::table('leaveapprove')
        ->where('year', '2023')->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');
      $myapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->latest()->get();
      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.approver', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();

      $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
      $attendance = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $clInAttendance = 0;
      $slInAttendance = 0;
      //dd($attendance);
      foreach ($attendance as $item) {
        foreach ($columns as $column) {
          if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
            $clInAttendance++;
          }
          if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
            $slInAttendance++;
          }
        }
      }
      $role_id = auth()->user()->teammember_id;
      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')

        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();
      // dd($applyleaveDatas);
      return view('backEnd.applyleave.teamapplication', compact(
        'teammember',
        'countCasualafmnth',
        'teammonthcount',
        'totalcountCasual',
        'teamapplyleaveDatas',
        'birthday',
        'countbirthday',
        'Casual',
        'Sick',
        'countSick',
        'countCasual',
        'role_id',
        'clInAttendance',
        'slInAttendance',

      ));
    } elseif (auth()->user()->role_id == 18) {

      $role_id = auth()->user()->teammember_id;

      $teammember = Teammember::with('role:id,rolename')
        ->whereNotNull('joining_date')
        ->get();

      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;
      $datess = [];
      $hdatess = [];
      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();


        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $datess = array_unique($datess);
      }
      $countSick = count(array_diff($datess, $hdatess));


      $appliedCasual = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countCasual = 0;
      $casualDates = [];
      foreach ($appliedCasual as $CasualLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $casualDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $casualDates = array_unique($casualDates);
      }
      $countCasual = count(array_diff($casualDates, $hdatess));

      $appliedCasualafmnth = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addDays(90))
        ->get();

      $countCasualafmnth = 0;
      $CasualafmnthDates = [];
      foreach ($appliedCasualafmnth as $CasualafmnthLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $CasualafmnthDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $CasualafmnthDates = array_unique($CasualafmnthDates);
      }
      $countCasualafmnth = count(array_diff($CasualafmnthDates, $hdatess));





      $appliedbirthday = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $birthday->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();
      $countbirthday = 0;
      $birthdayDates = [];
      foreach ($appliedbirthday as $birthdayLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $birthdayDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $birthdayDates = array_unique($birthdayDates);
      }
      $countbirthday = count(array_diff($birthdayDates, $hdatess));

      //dd($diff_in_months);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      //  dd($diff_in_months);

      //  dd($countCasualafmnth);
      $leavetaken = DB::table('leaveapprove')
        ->where('year', '2023')->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');

      $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
      $attendance = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $clInAttendance = 0;
      $slInAttendance = 0;
      //dd($attendance);
      foreach ($attendance as $item) {
        foreach ($columns as $column) {
          if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
            $clInAttendance++;
          }
          if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
            $slInAttendance++;
          }
        }
      }
      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->latest()->get();

      return view('backEnd.applyleave.teamapplication', compact(
        'teammember',
        'countCasualafmnth',
        'teammonthcount',
        'totalcountCasual',
        'teamapplyleaveDatas',
        'birthday',
        'countbirthday',
        'Casual',
        'Sick',
        'countSick',
        'countCasual',
        'role_id',
        'clInAttendance',
        'slInAttendance',
      ));
    } else {

      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;
      $datess = [];
      $hdatess = [];
      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();


        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $datess = array_unique($datess);
      }
      $countSick = count(array_diff($datess, $hdatess));


      $appliedCasual = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countCasual = 0;
      $casualDates = [];
      foreach ($appliedCasual as $CasualLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $casualDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $casualDates = array_unique($casualDates);
      }
      $countCasual = count(array_diff($casualDates, $hdatess));

      $appliedCasualafmnth = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addDays(90))
        ->get();

      $countCasualafmnth = 0;
      $CasualafmnthDates = [];
      foreach ($appliedCasualafmnth as $CasualafmnthLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $CasualafmnthDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $CasualafmnthDates = array_unique($CasualafmnthDates);
      }
      $countCasualafmnth = count(array_diff($CasualafmnthDates, $hdatess));





      $appliedbirthday = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $birthday->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();
      $countbirthday = 0;
      $birthdayDates = [];
      foreach ($appliedbirthday as $birthdayLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $birthdayDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $birthdayDates = array_unique($birthdayDates);
      }
      $countbirthday = count(array_diff($birthdayDates, $hdatess));

      //dd($diff_in_months);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      //  dd($diff_in_months);

      //  dd($countCasualafmnth);
      $leavetaken = DB::table('leaveapprove')
        ->where('year', '2023')->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');
      $myapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->latest()->get();
      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.approver', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();

      $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
      $attendance = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $clInAttendance = 0;
      $slInAttendance = 0;
      //dd($attendance);
      foreach ($attendance as $item) {
        foreach ($columns as $column) {
          if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
            $clInAttendance++;
          }
          if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
            $slInAttendance++;
          }
        }
      }


      // dd($applyleaveDatas);
      return view('backEnd.applyleave.index', compact('countCasualafmnth', 'leavetaken', 'teammonthcount', 'totalcountCasual', 'myapplyleaveDatas', 'teamapplyleaveDatas', 'birthday', 'countbirthday', 'Casual', 'Sick', 'countSick', 'countCasual', 'clInAttendance', 'slInAttendance'));
    }
  }


  public function filterDataAdmin(Request $request)
  {
    if (auth()->user()->role_id == 13) {
      // apply leave filter on patner 
      $teamname = $request->input('employee');
      $leavetype = $request->input('leave');
      // if ($startdate != null || $endtdate != null) {
      $startdate = $request->input('start');
      $startdate1 = date('Y-m-d H:i:s', strtotime($startdate));
      $endtdate = $request->input('end');
      $endtdate1 = date('Y-m-d H:i:s', strtotime($endtdate));
      // }
      $statusdata = $request->input('status');

      $query  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as approvername', 'approvername.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.approver', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');


      // According employee
      if ($teamname) {
        $query->where('applyleaves.createdby', $teamname);
      }
      // According leave type
      if ($leavetype) {
        $query->where('applyleaves.leavetype', $leavetype);
      }

      // According Status 
      if ($statusdata != null) {
        if ($statusdata == 0) {
          $query->where('applyleaves.status', 0);
        } elseif ($statusdata == 1) {
          $query->where('applyleaves.status', 1);
        } elseif ($statusdata == 2) {
          $query->where('applyleaves.status', 2);
        }
      }

      // According strat date and end date 
      if ($teamname == null && $leavetype == null && $statusdata == null) {
        $query->whereBetween('applyleaves.created_at', [$startdate1, $endtdate1]);
      }
      // According stratdate and enddate and employee
      if ($startdate != null && $endtdate != null && $teamname != null) {
        $query->whereBetween('applyleaves.created_at', [$startdate1, $endtdate1])
          ->where('applyleaves.createdby', $teamname);
      }

      // According employee and leave type
      if ($teamname && $leavetype) {
        $query->where(function ($q) use ($teamname, $leavetype) {
          $q->where('applyleaves.createdby', $teamname)
            ->where('applyleaves.leavetype', $leavetype);
        });
      }
      // According Status and teamname
      if ($statusdata != null && $teamname != null) {
        if ($statusdata == 0 && $teamname != null) {
          $query->where('applyleaves.status', 0)
            ->where('applyleaves.createdby', $teamname);
        } elseif ($statusdata == 1 && $teamname != null) {
          $query->where('applyleaves.status', 1)
            ->where('applyleaves.createdby', $teamname);
        } elseif ($statusdata == 2 && $teamname != null) {
          $query->where('applyleaves.status', 2)
            ->where('applyleaves.createdby', $teamname);
        }
      }

      // According Status and leave type 
      if ($statusdata != null && $leavetype != null) {
        if ($statusdata == 0 && $leavetype != null) {
          $query->where('applyleaves.status', 0)
            ->where('applyleaves.leavetype', $leavetype);
        } elseif ($statusdata == 1 && $leavetype != null) {
          $query->where('applyleaves.status', 1)
            ->where('applyleaves.leavetype', $leavetype);
        } elseif ($statusdata == 2 && $leavetype != null) {
          $query->where('applyleaves.status', 2)
            ->where('applyleaves.leavetype', $leavetype);
        }
      }
    } else {
      // apply leave filter on admin 
      $teamname = $request->input('employee');
      // dd($teamname);
      $leavetype = $request->input('leave');
      // if ($startdate != null || $endtdate != null) {
      $startdate = $request->input('start');
      $startdate1 = date('Y-m-d H:i:s', strtotime($startdate));
      $endtdate = $request->input('end');
      $endtdate1 = date('Y-m-d H:i:s', strtotime($endtdate));
      // }
      $statusdata = $request->input('status');

      $startperioddata = $request->input('startperiod');
      $endperioddata = $request->input('endperiod');

      $query  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as approvername', 'approvername.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');


      // According leave periode 
      if ($startperioddata && $endperioddata) {
        // $query->where('applyleaves.from', $startperioddata);
        // $query->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
        $query->where('applyleaves.from', '>=', $startperioddata)
          ->where('applyleaves.to', '<=', $endperioddata);
      }

      // According employee
      if ($teamname) {
        $query->where('applyleaves.createdby', $teamname);
      }
      // According leave type
      if ($leavetype) {
        $query->where('applyleaves.leavetype', $leavetype);
      }

      // According Status 
      if ($statusdata != null) {
        if ($statusdata == 0) {
          $query->where('applyleaves.status', 0);
        } elseif ($statusdata == 1) {
          $query->where('applyleaves.status', 1);
        } elseif ($statusdata == 2) {
          $query->where('applyleaves.status', 2);
        }
      }

      // According strat date and end date 
      if ($teamname == null && $leavetype == null && $statusdata == null && $startperioddata == null && $endperioddata == null) {
        $query->whereBetween('applyleaves.created_at', [$startdate1, $endtdate1]);
      }
      // According stratdate and enddate and employee
      if ($startdate != null && $endtdate != null && $teamname != null) {
        $query->whereBetween('applyleaves.created_at', [$startdate1, $endtdate1])
          ->where('applyleaves.createdby', $teamname);
      }

      // According employee and leave type
      if ($teamname && $leavetype) {
        $query->where(function ($q) use ($teamname, $leavetype) {
          $q->where('applyleaves.createdby', $teamname)
            ->where('applyleaves.leavetype', $leavetype);
        });
      }
      // According Status and teamname
      if ($statusdata != null && $teamname != null) {
        if ($statusdata == 0 && $teamname != null) {
          $query->where('applyleaves.status', 0)
            ->where('applyleaves.createdby', $teamname);
        } elseif ($statusdata == 1 && $teamname != null) {
          $query->where('applyleaves.status', 1)
            ->where('applyleaves.createdby', $teamname);
        } elseif ($statusdata == 2 && $teamname != null) {
          $query->where('applyleaves.status', 2)
            ->where('applyleaves.createdby', $teamname);
        }
      }

      // According Status and leave type 
      if ($statusdata != null && $leavetype != null) {
        if ($statusdata == 0 && $leavetype != null) {
          $query->where('applyleaves.status', 0)
            ->where('applyleaves.leavetype', $leavetype);
        } elseif ($statusdata == 1 && $leavetype != null) {
          $query->where('applyleaves.status', 1)
            ->where('applyleaves.leavetype', $leavetype);
        } elseif ($statusdata == 2 && $leavetype != null) {
          $query->where('applyleaves.status', 2)
            ->where('applyleaves.leavetype', $leavetype);
        }
      }
    }
    $filteredData = $query->get();

    return response()->json($filteredData);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // dd(auth()->user()->teammember_id);
    // $nextweektimesheet = DB::table('timesheetusers')
    //   ->where('createdby', auth()->user()->teammember_id)
    //   ->whereBetween('date', ['2024-01-01', '2024-01-18'])
    //   ->delete();

    // $nextweektimesheet = DB::table('timesheets')
    //   ->where('created_by', auth()->user()->teammember_id)
    //   ->whereBetween('date', ['2024-01-01', '2024-01-18'])
    //   ->delete();

    // dd('hi');
    $leavetype = DB::table('leavetypes')
      ->leftjoin('leaveroles', 'leaveroles.leavetype_id', 'leavetypes.id')
      ->where('leavetypes.year', '=', '2024')
      ->where('leaveroles.role', auth()->user()->role_id)
      ->whereIn('leavetypes.id', [9, 11])
      ->select('leavetypes.*')->get();
    //   dd($leavetype);
    if (auth()->user()->role_id == 13) {
      $teammember = Teammember::with('role:id,rolename')->whereNotNull('joining_date')->where('role_id', '13')->where('status', 1)->orwhere('role_id', '14')->orwhere('role_id', '20')->where('id', '!=', auth()->user()->teammember_id)->get();

      $approver = Teammember::with('role:id,rolename')->where('role_id', '11')->where('status', 1)->get();
    } elseif (auth()->user()->role_id == 14) {
      $teammember = Teammember::with('role:id,rolename')->whereNotNull('joining_date')->where('role_id', '13')->where('status', 1)->orwhere('role_id', '14')->orwhere('role_id', '20')->where('id', '!=', auth()->user()->teammember_id)->get();

      $approver = Teammember::with('role:id,rolename')->where('role_id', '13')->where('status', 1)->get();
    } else {
      $teammember = Teammember::with('role:id,rolename')->whereNotNull('joining_date')->where('role_id', '13')->where('status', 1)->orwhere('role_id', '14')->where('id', '!=', auth()->user()->teammember_id)
        ->orwhere('role_id', '17')->orwhere('role_id', '18')->orwhere('role_id', '20')
        ->orwhere('role_id', '16')->get();

      $approver = Teammember::with('role:id,rolename')->where('role_id', '13')->where('status', 1)->get();
    }
    return view('backEnd.applyleave.create', compact('teammember', 'leavetype', 'approver'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * 
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request)
  {
    //dd($request);
    $request->validate([
      'leavetype' => "required",
      'to' => "required",
      'from' => "required",
    ]);

    // timesheetcheck 

    $timesheetcheck = DB::table('timesheets')
      ->where('created_by', auth()->user()->teammember_id)
      ->select('date')
      ->get();
    if (count($timesheetcheck) != 0) {
      foreach ($timesheetcheck as $timesheetchecks) {
        $leaveDates = CarbonPeriod::create(
          date('Y-m-d', strtotime($request->from)),
          date('Y-m-d', strtotime($request->to))
        );

        foreach ($leaveDates as $leaveDate) {
          if ($leaveDate->format('Y-m-d') == $timesheetchecks->date) {
            $output = array('msg' => 'You Have already filled timesheet for the Day (' . date('d-m-Y', strtotime($leaveDate)) . ')');
            return back()->with('statuss', $output);
          }
        }
      }
    }
    //dd('hi');

    //duplicate leave check
    $leaves = DB::table('applyleaves')
      ->where('applyleaves.createdby', auth()->user()->teammember_id)
      ->where('status', '!=', 2)
      ->select('applyleaves.from', 'applyleaves.to')
      ->get();

    $leaveDates = [];
    foreach ($leaves as $leave) {
      $days = CarbonPeriod::create(
        date('Y-m-d', strtotime($leave->from)),
        date('Y-m-d', strtotime($leave->to))
      );

      foreach ($days as $day) {
        $leaveDates[] = $day->format('Y-m-d');
      }
    }

    $currentDay = date('Y-m-d', strtotime($request->from));
    $lastDay = date('Y-m-d', strtotime($request->to));

    if (count($leaves) != 0) {
      foreach ($leaveDates as $leaveDate) {
        if ($leaveDate >= $currentDay && $leaveDate <= $lastDay) {
          $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leaveDate)) . ')');
          return back()->with('statuss', $output);
        }
      }
    }

    $currentdate = date('Y-m-d');
    $currentYear = date('Y');
    $financialYearStart = $currentYear . '-04-01';
    $financialYearEnd = ($currentYear + 1) . '-03-31';

    $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();


    try {

      $currentDate = Carbon::now();
      $day = $currentDate->day;
      $currentYear = $currentDate->year;



      //birthday-festival leave 
      if ($request->leavetype == 8) {
        $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $request->from);
        $diff_in_days = $to->diffInDays($from) + 1;


        $financialYearStart = $currentYear . '-04-01';
        $financialYearEnd = ($currentYear + 1) . '-03-31';

        $count = DB::table('applyleaves')
          ->where('status', '!=', '2')
          ->where('leavetype', $request->leavetype)
          ->where('createdby', auth()->user()->teammember_id)
          ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
          ->first();


        $teammember = DB::table('teammembers')
          ->where('id', auth()->user()->teammember_id)
          ->first();

        $requestedDate = date('F d', strtotime($request->to));
        $birthdayDate = date('F d', strtotime($teammember->dateofbirth));

        if ($request->type == 0) {
          if ($request->to != $request->from) {

            $output = ['msg' => 'You can take only one day birthday leave'];
            return back()->with('success', $output);
          }
          if ($requestedDate != $birthdayDate) {

            $output = ['msg' => 'Your request for the birthday date is wrong'];
            return back()->with('success', $output);
          }
          if ($diff_in_days < 2 && $count != null) {
            $output = ['msg' => 'You have already taken a birthday leave'];
            return back()->with('success', $output);
          }
        } elseif ($request->type == 1) {
          if ($diff_in_days < 2) {
            if ($count != null) {
              $output = ['msg' => 'You have already taken a festival leave'];
              return back()->with('success', $output);
            }
          } else {
            $output = ['msg' => 'You can take only one day festival leave'];
            return back()->with('success', $output);
          }
        }


        $columnMappings = [
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

        $requestedDay = date('d', strtotime($request->to));
        $requestedDay = date('d', strtotime($request->to));
        $requestedMonth = $from->format('F');
        if (isset($columnMappings[$requestedDay])) {
          $columnName = $columnMappings[$requestedDay];
          if (in_array($requestedDay, ['26', '27', '28', '29', '30', '31'])) {
            $requestedMonth = $from->copy()->addMonth()->format('F');
          }
          DB::table('attendances')
            ->updateOrInsert(
              [
                'employee_name' => auth()->user()->teammember_id,
                'month' => $requestedMonth
              ],
              [
                $columnName => 'BL/C',
                'birthday_religious' => DB::raw('COALESCE(birthday_religious, 0) + 1'),
                'created_at' => now(),
                'updated_at' => now()
              ],
              [
                'created_at' => now()
              ]
            );
        }
      } elseif ($request->leavetype == 9) {



        $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $request->from);
        $requestdays = $to->diffInDays($from) + 1;



        $period = CarbonPeriod::create($request->from, $request->to);
        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');

          //  dd($date->format('Y-m-d'));
          $id = DB::table('timesheets')->insertGetId(
            [
              'created_by' => auth()->user()->teammember_id,
              'month'     =>     date('F', strtotime($date->format('Y-m-d'))),
              'date'     =>    $date->format('Y-m-d'),
              'created_at'          =>     date('Y-m-d H:i:s'),
            ]
          );
          $a = DB::table('timesheetusers')->insert([
            'date'     =>    $date->format('Y-m-d'),
            'client_id'     =>    134,
            'workitem'     =>     $request->reasonleave,
            'location'     =>     '',
            //   'billable_status'     =>     $request->billable_status[$i],
            'timesheetid'     =>     $id,
            'date'     =>    $date->format('Y-m-d'),
            'hour'     =>     8,
            'totalhour' =>      8,
            'assignment_id'     =>     215,
            'partner'     =>     887,
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);
        }


        $getholidays = DB::table('holidays')->where('startdate', '>=', $request->from)
          ->where('enddate', '<=', $request->to)->select('startdate')->get();



        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }


        $cl_leave = array_diff($datess, $hdatess);


        $cl_leave_total = count($cl_leave);

        $lstatus = "CL/C";

        if ($teammember->joining_date < $financialYearStart) {

          $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $financialYearStart);
        } else {

          $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $teammember->joining_date);
        }




        $diff_in_months = $startDate->diffInMonths($currentdate) + 1;


        $totalcountCasual = 1.5 * $diff_in_months;
        if (\Carbon\Carbon::parse($teammember->joining_date)->diffInDays($currentdate) <= 90) {
          $totalcountCasual = 0;
        }
        $teamdate = \Carbon\Carbon::createFromFormat('Y-m-d', $teammember->joining_date);
        $teammonthcount = $teamdate->diffInMonths($currentdate) + 1;


        $columnMappings = [
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

        foreach ($cl_leave as $requestedDate) {
          $day = date('d', strtotime($requestedDate));
          $requestedMonth = date('F', strtotime($requestedDate));


          if ($day >= 26 && $day <= 31) {
            $requestedDateTime = new DateTime($requestedDate);



            $requestedDateTime->modify('first day of next month');
            $requestedMonth = $requestedDateTime->format('F');
          }

          $appliedCasual = DB::table('applyleaves')
            ->where('status', '!=', '2')
            ->where('leavetype', $request->leavetype)
            ->where('createdby', auth()->user()->teammember_id)
            ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
            ->get();
          //dd($appliedCasual);


          $countCasual = 0;
          $casualDates = [];
          $holidaydates = [];
          foreach ($appliedCasual as $CasualLeave) {

            $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
            $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
            $period = CarbonPeriod::create($fromDate, $toDate);



            foreach ($period as $date) {
              $casualDates[] = $date->format('Y-m-d');

              //dd($date->format('Y-m-d'));


            }

            $getholidays = DB::table('holidays')->get();


            foreach ($getholidays as $date) {
              $holidaydates[] = date('Y-m-d', strtotime($date->startdate));
            }
            $casualDates = array_unique($casualDates);
          }

          //    die;

          $attendanceRecord = DB::table('attendances')
            ->where('employee_name', auth()->user()->teammember_id)
            ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
            ->get();
          $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
          $clInAttendance = 0;
          foreach ($attendanceRecord as $item) {
            foreach ($columns as $column) {
              if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
                $clInAttendance++;
              }
            }
          }

          if ($clInAttendance >= $totalcountCasual || $totalcountCasual - $clInAttendance == 0.5) {

            $lstatus = 'LWP';
          }

          $attendanceUpdateData = [];
          $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
            ->where('month', $requestedMonth)->first();

          if ($attendances == null) {
            if ($lstatus == 'CL/C') {
              $attendanceData = [
                'employee_name' => auth()->user()->teammember_id,
                'month' => $requestedMonth,
                'casual_leave' => 1,
                'created_at' => Carbon::now(),
              ];
            } else {
              $attendanceData = [
                'employee_name' => auth()->user()->teammember_id,
                'month' => $requestedMonth,
                'lwp' => 1,
                'created_at' => Carbon::now(),
              ];
            }


            DB::table('attendances')->insert($attendanceData);
          } else {
            if ($lstatus == 'CL/C') {
              DB::table('attendances')
                ->where('employee_name', auth()->user()->teammember_id)
                ->where('month', $requestedMonth)
                ->update(['casual_leave' => DB::raw('COALESCE(casual_leave, 0) + 1')]);
            } else {
              DB::table('attendances')
                ->where('employee_name', auth()->user()->teammember_id)
                ->where('month', $requestedMonth)
                ->update(['lwp' => DB::raw('COALESCE(lwp, 0) + 1')]);
            }
          }

          $column = $columnMappings[$day] ?? null;
          if ($column !== null) {
            $attendanceUpdateData[$column] = $lstatus;
          }


          //Update the attendance data for the current date
          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
            ->where('month', $requestedMonth)->update($attendanceUpdateData);
        }
      }
      // Casual leave end

      elseif ($request->leavetype == 10) {

        $sick = DB::table('leavetypes')->where('name', 'Sick Leave')->where('year', $currentYear)->first();

        //      $availableleave = $sick->noofdays - $takeleavecount ;
        //  dd($availableleave);
        $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $request->from);
        $requestdays = $to->diffInDays($from) + 1;





        $period = CarbonPeriod::create($request->from, $request->to);
        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }
        // dd($datess);
        // Convert the period to an array of dates
        // $dates = $period->toArray();

        $getholidays = DB::table('holidays')->where('startdate', '>=', $request->from)
          ->where('enddate', '<=', $request->to)->select('startdate')->get();

        if (count($getholidays) != 0) {
          foreach ($getholidays as $date) {
            $hdatess[] = date('Y-m-d', strtotime($date->startdate));
          }
        } else {
          $hdatess[] = 0;
        }
        //dd($hdatess);

        $sl_leave = array_diff($datess, $hdatess);
        $sl_leave_total = count(array_diff($datess, $hdatess));

        $lstatus = "SL/C";


        $columnMappings = [
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
        foreach ($sl_leave as $requestedDate) {


          $day = date('d', strtotime($requestedDate));
          $requestedMonth = date('F', strtotime($requestedDate));

          if ($day >= 26 && $day <= 31) {
            $requestedDateTime = new DateTime($requestedDate);
            $requestedDateTime->modify('first day of next month');
            $requestedMonth = $requestedDateTime->format('F');
          }

          $appliedSick = DB::table('applyleaves')
            ->where('status', '!=', '2')
            ->where('leavetype', $request->leavetype)
            ->where('createdby', auth()->user()->teammember_id)
            ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
            ->get();

          $countSick = 0;
          $sickDates = [];
          $holidaydates = [];
          foreach ($appliedSick as $sickLeave) {

            $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
            $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
            $period = CarbonPeriod::create($fromDate, $toDate);


            foreach ($period as $date) {
              $sickDates[] = $date->format('Y-m-d');
            }

            $getholidays = DB::table('holidays')->get();


            foreach ($getholidays as $date) {
              $holidaydates[] = date('Y-m-d', strtotime($date->startdate));
            }
            $sickDates = array_unique($sickDates);
          }


          $attendanceRecord = DB::table('attendances')
            ->where('employee_name', auth()->user()->teammember_id)
            ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
            ->get();
          $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
          $slInAttendance = 0;
          foreach ($attendanceRecord as $item) {
            foreach ($columns as $column) {
              if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
                $slInAttendance++;
              }
            }
          }

          if ($slInAttendance >= $sick->noofdays) {

            $lstatus = 'LWP';
          }

          $attendanceUpdateData = [];
          $attendances = DB::table('attendances')
            ->where('employee_name', auth()->user()->teammember_id)
            ->where('month', $requestedMonth)
            ->first();

          $attendanceData = [
            'employee_name' => auth()->user()->teammember_id,
            'month' => $requestedMonth,
            'created_at' => Carbon::now()
          ];

          if ($lstatus == 'SL/C') {
            $attendanceData['sick_leave'] = 1;
          } else {
            $attendanceData['lwp'] = 1;
          }

          if ($attendances == null) {
            DB::table('attendances')->insert($attendanceData);
          } else {
            if ($lstatus == 'SL/C') {
              DB::table('attendances')
                ->where('employee_name', auth()->user()->teammember_id)
                ->where('month', $requestedMonth)
                ->update(['sick_leave' => DB::raw('COALESCE(sick_leave, 0) + 1')]);
            } else {
              DB::table('attendances')
                ->where('employee_name', auth()->user()->teammember_id)
                ->where('month', $requestedMonth)
                ->update(['lwp' => DB::raw('COALESCE(lwp, 0) + 1')]);
            }
          }


          $column = $columnMappings[$day] ?? null;
          if ($column !== null) {
            $attendanceUpdateData[$column] = $lstatus;
          }

          //Update the attendance data for the current date
          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
            ->where('month', $requestedMonth)->update($attendanceUpdateData);
        }
      } elseif ($request->leavetype == 11) {
        $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $request->from);
        $requestdays = $to->diffInDays($from) + 1;





        $period = CarbonPeriod::create($request->from, $request->to);
        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }
        // dd($datess);
        // Convert the period to an array of dates
        // $dates = $period->toArray();

        $getholidays = DB::table('holidays')->where('startdate', '>=', $request->from)
          ->where('enddate', '<=', $request->to)->select('startdate')->get();
        if (count($getholidays) != 0) {
          foreach ($getholidays as $date) {
            $hdatess[] = date('Y-m-d', strtotime($date->startdate));
          }
        } else {
          $hdatess[] = 0;
        }


        $exam_leave = array_diff($datess, $hdatess);
        $exam_leave_total = count(array_diff($datess, $hdatess));

        $lstatus = "EL/C";




        $columnMappings = [
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

        foreach ($exam_leave as $exam_leave) {

          $day = date('d', strtotime($exam_leave));
          $requestedMonth = date('F', strtotime($exam_leave));

          if ($day >= 26 && $day <= 31) {
            $requestedDateTime = new DateTime($exam_leave);
            $requestedDateTime->modify('first day of next month');
            $requestedMonth = $requestedDateTime->format('F');
          }


          $attendanceUpdateData = [];
          $attendances = DB::table('attendances')
            ->where('employee_name', auth()->user()->teammember_id)
            ->where('month', $requestedMonth)
            ->first();

          $attendanceData = [
            'employee_name' => auth()->user()->teammember_id,
            'month' => $requestedMonth,
            'created_at' => Carbon::now()
          ];

          if ($lstatus == 'EL/C') {
            $attendanceData['exam_leave'] = 1;
          } else {
            $attendanceData['lwp'] = 1;
          }

          if ($attendances == null) {
            DB::table('attendances')->insert($attendanceData);
          } else {
            if ($lstatus == 'EL/C') {
              DB::table('attendances')
                ->where('employee_name', auth()->user()->teammember_id)
                ->where('month', $requestedMonth)
                ->update(['exam_leave' => DB::raw('COALESCE(sick_leave, 0) + 1')]);
            } else {
              DB::table('attendances')
                ->where('employee_name', auth()->user()->teammember_id)
                ->where('month', $requestedMonth)
                ->update(['lwp' => DB::raw('COALESCE(lwp, 0) + 1')]);
            }
          }


          $column = $columnMappings[$day] ?? null;
          if ($column !== null) {
            $attendanceUpdateData[$column] = $lstatus;
          }

          //Update the attendance data for the current date
          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
            ->where('month', $requestedMonth)->update($attendanceUpdateData);
        }
      }

      if ($request->hasFile('report')) {
        $file = $request->file('report');
        $destinationPath = 'backEnd/image/report';
        $name = $file->getClientOriginalName();
        $s = $file->move($destinationPath, $name);
        $data['salaryincomefile'] = $name;
        $data['report'] = $name;
      }
      $id = DB::table('applyleaves')->insertGetId([
        'leavetype'         =>     $request->leavetype,
        'approver'         =>     $request->approver,
        'from'         =>     $request->from,
        'type'         =>     $request->type,
        'examtype'         =>     $request->examtype,
        'otherexam'         =>     $request->otherexam,
        'to'         =>     $request->to,
        'report'         => $data['report'] ?? '',
        'status'         =>    0,
        'reasonleave'         =>     $request->reasonleave,
        'createdby'         =>     auth()->user()->teammember_id,
        'created_at'          =>    date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
      ]);
      if ($request->teammember_id != null) {
        foreach ($request->teammember_id as $teammember) {
          DB::table('leaveteams')->insert([
            'leave_id'         =>     $id,
            'teammember_id'         =>     $teammember,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>     date('Y-m-d H:i:s'),
          ]);
        }
      }
      $teammemberemail = Teammember::where('id', $request->approver)->first();
      //  dd($teammemberemail);
      $teammembername = Teammember::where('id', auth()->user()->teammember_id)->first();

      $data = array(
        'id' => $id,
        'leavetype'         =>     $request->leavetype,
        'from'         =>     $request->from,
        'to'         =>     $request->to,
        'teammembername'         =>    $teammembername->team_member,
        'teammemberemail' => $teammemberemail->emailid ?? '',
        'id' => $id ?? ''

      );

      Mail::send('emails.applyleaveform', $data, function ($msg) use ($data) {
        $msg->to($data['teammemberemail']);
        $msg->cc('itsupport_delhi@vsa.co.in');
        $msg->subject('VSA Apply Leave Request');
      });


      $output = array('msg' => 'Create Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Applyleave  $employeereferral
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //dd($id);
    $applyleave = DB::table('applyleaves')
      ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
      ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->where('applyleaves.id', $id)
      ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->first();

    $applyleaveteam = DB::table('leaveteams')
      ->leftjoin('teammembers', 'teammembers.id', 'leaveteams.teammember_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->where('leaveteams.leave_id', $id)
      ->select('teammembers.team_member', 'roles.rolename')->get();
    // dd($fullandfinal);
    return view('backEnd.applyleave.view', compact('id', 'applyleave', 'applyleaveteam'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Applyleave  $employeereferral
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //   $client = Client::select('id','client_name')->get();
    $applyleave = Applyleave::where('id', $id)->first();
    $leavetype = Leavetype::select('id', 'name')->get();
    //  $leavetype = Leavetype::latest()->get();
    $teammember = Teammember::select('id', 'team_member')->get();
    $teammember = Teammember::latest()->get();
    // dd($fullandfinal);
    return view('backEnd.applyleave.edit', compact('id', 'applyleave', 'teammember', 'leavetype'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Applyleave  $employeereferral
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {

    //dd($id);
    try {

      if ($request->status == 1) {
        $team = DB::table('applyleaves')
          ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
          ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
          ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
          ->where('applyleaves.id', $id)
          ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday')->first();

        if ($team->leavetype == '8' && $team->type == '1') {
          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
          $from = Carbon::createFromFormat('Y-m-d', $team->from);

          $period = date('Y-m-d', strtotime($team->to));
          $bl_leave_day = date('d', strtotime($period));
          $bl_leave_month = date('F', strtotime($period));

          if ($bl_leave_day >= 26 && $bl_leave_day <= 31) {
            $bl_leave_month = date('F', strtotime($period . ' +1 month'));
          }

          $requestdays = $to->diffInDays($from) + 1;

          $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
            ->where('enddate', '<=', $team->to)
            ->count();

          $totalrqstday = $requestdays - $holidaycount;

          DB::table('leaveapprove')->insert([
            'teammemberid'     =>     $team->createdby,
            'leavetype'     =>     $team->leavetype,
            'totaldays'     =>     $totalrqstday,
            'year'     =>     '2023',
            'created_at'          =>     date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
          ]);


          $lstatus = "BL/A";

          $attendances = DB::table('attendances')
            ->where('employee_name', $team->createdby)
            ->where('month', $bl_leave_month)->first();


          if ($attendances->birthday_religious == null) {
            $birthday = 0;
          } else {
            $birthday = $attendances->birthday_religious;
          }

          $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
            ->where('month', $bl_leave_month)->first();

          $column = '';
          switch ($bl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }

          if (!empty($column)) {

            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $bl_leave_month)
              ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              ->update([
                $column => $lstatus,
              ]);
          }
        } elseif ($team->leavetype == '8' && $team->type == '0') {
          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
          $from = Carbon::createFromFormat('Y-m-d', $team->from);

          $period = date('Y-m-d', strtotime($team->to));
          $bl_leave_day = date('d', strtotime($period));
          $bl_leave_month = date('F', strtotime($period));

          $requestdays = $to->diffInDays($from) + 1;

          $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
            ->where('enddate', '<=', $team->to)
            ->count();

          $totalrqstday = $requestdays - $holidaycount;

          DB::table('leaveapprove')->insert([
            'teammemberid'     =>     $team->createdby,
            'leavetype'     =>     $team->leavetype,
            'type'     =>     $team->type,
            'totaldays'     =>     $totalrqstday,
            'year'     =>     '2023',
            'created_at'          =>     date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
          ]);



          // dd($period);
          $lstatus = "BL/A";




          $attendances = DB::table('attendances')
            ->where('employee_name', $team->createdby)
            ->where('month', $bl_leave_month)->first();

          // dd($attendances);
          if ($attendances->birthday_religious == null) {
            $birthday = 0;
          } else {
            $birthday = $attendances->birthday_religious;
          }




          $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
            ->where('month', $bl_leave_month)->first();

          $column = '';
          switch ($bl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }

          if (!empty($column)) {

            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $bl_leave_month)
              ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              ->update([
                $column => $lstatus,
              ]);
          }
        }
        if ($team->name == 'Casual Leave') {
          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
          $from = Carbon::createFromFormat('Y-m-d', $team->from);

          $requestdays = $to->diffInDays($from) + 1;
          // dd($requestdays);
          $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
            ->where('enddate', '<=', $team->to)
            ->count();
          //   dd($holidaycount);
          $totalrqstday = $requestdays - $holidaycount;
          //    dd($totalrqstday); die;

          DB::table('leaveapprove')->insert([
            'teammemberid'     =>     $team->createdby,
            'leavetype'     =>     $team->leavetype,
            'totaldays'     =>     $totalrqstday,
            'year'     =>     '2023',
            'created_at'          =>     date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
          ]);



          $period = CarbonPeriod::create($team->from, $team->to);
          $datess = [];
          foreach ($period as $date) {
            $datess[] = $date->format('Y-m-d');
          }


          $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
            ->where('enddate', '<=', $team->to)->select('startdate')->get();

          if (count($getholidays) != 0) {
            foreach ($getholidays as $date) {
              $hdatess[] = date('Y-m-d', strtotime($date->startdate));
            }
          } else {
            $hdatess[] = 0;
          }
          $cl_leave = array_diff($datess, $hdatess);



          $lstatus = "CL/A";




          foreach ($cl_leave as $cl_leave) {


            $cl_leave_day = date('d', strtotime($cl_leave));
            $cl_leave_month = date('F', strtotime($cl_leave));

            if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
              $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
            }


            $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)->first();

            $column = '';
            switch ($cl_leave_day) {
              case '26':
                $column = 'twentysix';
                break;
              case '27':
                $column = 'twentyseven';
                break;
              case '28':
                $column = 'twentyeight';
                break;
              case '29':
                $column = 'twentynine';
                break;
              case '30':
                $column = 'thirty';
                break;
              case '31':
                $column = 'thirtyone';
                break;
              case '01':
                $column = 'one';
                break;
              case '02':
                $column = 'two';
                break;
              case '03':
                $column = 'three';
                break;
              case '04':
                $column = 'four';
                break;
              case '05':
                $column = 'five';
                break;
              case '06':
                $column = 'six';
                break;
              case '07':
                $column = 'seven';
                break;
              case '08':
                $column = 'eight';
                break;
              case '09':
                $column = 'nine';
                break;
              case '10':
                $column = 'ten';
                break;
              case '11':
                $column = 'eleven';
                break;
              case '12':
                $column = 'twelve';
                break;
              case '13':
                $column = 'thirteen';
                break;
              case '14':
                $column = 'fourteen';
                break;
              case '15':
                $column = 'fifteen';
                break;
              case '16':
                $column = 'sixteen';
                break;
              case '17':
                $column = 'seventeen';
                break;
              case '18':
                $column = 'eighteen';
                break;
              case '19':
                $column = 'ninghteen';
                break;
              case '20':
                $column = 'twenty';
                break;
              case '21':
                $column = 'twentyone';
                break;
              case '22':
                $column = 'twentytwo';
                break;
              case '23':
                $column = 'twentythree';
                break;
              case '24':
                $column = 'twentyfour';
                break;
              case '25':
                $column = 'twentyfive';
                break;
            }

            if (!empty($column)) {

              DB::table('attendances')
                ->where('employee_name', $team->createdby)
                ->where('month', $cl_leave_month)
                ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
                ->whereRaw("{$column} != 'LWP'")
                ->update([
                  $column => $lstatus,
                ]);
            }
          }
        }
        if ($team->name == 'Exam Leave') {
          //dd($id);
          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
          $from = Carbon::createFromFormat('Y-m-d', $team->from);
          // dd($to);
          $requestdays = $to->diffInDays($from) + 1;
          // dd($requestdays);
          $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
            ->where('enddate', '<=', $team->to)
            ->count();
          //   dd($holidaycount);
          $totalrqstday = $requestdays - $holidaycount;
          //    dd($totalrqstday); die;

          DB::table('leaveapprove')->insert([
            'teammemberid'     =>     $team->createdby,
            'leavetype'     =>     $team->leavetype,
            'totaldays'     =>     $totalrqstday,
            'year'     =>     '2023',
            'created_at'          =>     date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
          ]);

          $period = CarbonPeriod::create($team->from, $team->to);
          $datess = [];
          foreach ($period as $date) {
            $datess[] = $date->format('Y-m-d');
            //dd($id);
            $ids = DB::table('timesheets')->insertGetId(
              [
                'created_by' => $team->createdby,
                'month'     =>     date('F', strtotime($date->format('Y-m-d'))),
                'date'     =>    $date->format('Y-m-d'),
                'created_at'          =>     date('Y-m-d H:i:s'),
              ]
            );
            $a = DB::table('timesheetusers')->insert([
              'date'     =>    $date->format('Y-m-d'),
              'client_id'     =>    134,
              'workitem'     =>     $team->reasonleave,
              'location'     =>     '',
              //   'billable_status'     =>     $request->billable_status[$i],
              'timesheetid'     =>     $ids,
              'date'     =>    $date->format('Y-m-d'),
              'hour'     =>     8,
              'totalhour' =>      8,
              'assignment_id'     =>     214,
              'partner'     =>     887,
              'createdby' => $team->createdby,
              'created_at'          =>     date('Y-m-d H:i:s'),
              'updated_at'              =>    date('Y-m-d H:i:s'),
            ]);
          }


          $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
            ->where('enddate', '<=', $team->to)->select('startdate')->get();

          if (count($getholidays) != 0) {
            foreach ($getholidays as $date) {
              $hdatess[] = date('Y-m-d', strtotime($date->startdate));
            }
          } else {
            $hdatess[] = 0;
          }
          $el_leave = array_diff($datess, $hdatess);

          //  dd( $cl_leave );
          $exam_leave_total = count(array_diff($datess, $hdatess));

          $lstatus = "EL/A";




          foreach ($el_leave as $cl_leave) {


            $cl_leave_day = date('d', strtotime($cl_leave));
            $cl_leave_month = date('F', strtotime($cl_leave));

            if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
              $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
            }

            $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)->first();
            //  dd($value->created_by);


            $column = '';
            switch ($cl_leave_day) {
              case '26':
                $column = 'twentysix';
                break;
              case '27':
                $column = 'twentyseven';
                break;
              case '28':
                $column = 'twentyeight';
                break;
              case '29':
                $column = 'twentynine';
                break;
              case '30':
                $column = 'thirty';
                break;
              case '31':
                $column = 'thirtyone';
                break;
              case '01':
                $column = 'one';
                break;
              case '02':
                $column = 'two';
                break;
              case '03':
                $column = 'three';
                break;
              case '04':
                $column = 'four';
                break;
              case '05':
                $column = 'five';
                break;
              case '06':
                $column = 'six';
                break;
              case '07':
                $column = 'seven';
                break;
              case '08':
                $column = 'eight';
                break;
              case '09':
                $column = 'nine';
                break;
              case '10':
                $column = 'ten';
                break;
              case '11':
                $column = 'eleven';
                break;
              case '12':
                $column = 'twelve';
                break;
              case '13':
                $column = 'thirteen';
                break;
              case '14':
                $column = 'fourteen';
                break;
              case '15':
                $column = 'fifteen';
                break;
              case '16':
                $column = 'sixteen';
                break;
              case '17':
                $column = 'seventeen';
                break;
              case '18':
                $column = 'eighteen';
                break;
              case '19':
                $column = 'ninghteen';
                break;
              case '20':
                $column = 'twenty';
                break;
              case '21':
                $column = 'twentyone';
                break;
              case '22':
                $column = 'twentytwo';
                break;
              case '23':
                $column = 'twentythree';
                break;
              case '24':
                $column = 'twentyfour';
                break;
              case '25':
                $column = 'twentyfive';
                break;
            }

            if (!empty($column)) {

              DB::table('attendances')
                ->where('employee_name', $team->createdby)
                ->where('month', $cl_leave_month)
                ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
                ->whereRaw("{$column} != 'LWP'")
                ->update([
                  $column => $lstatus,
                ]);
            }
          }
        }
        if ($team->name == 'Sick Leave') {
          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
          $from = Carbon::createFromFormat('Y-m-d', $team->from);

          $requestdays = $to->diffInDays($from) + 1;
          // dd($requestdays);
          $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
            ->where('enddate', '<=', $team->to)
            ->count();
          // dd($holidaycount);
          $totalrqstday = $requestdays - $holidaycount;
          // dd($totalrqstday); die;

          DB::table('leaveapprove')->insert([
            'teammemberid'     =>     $team->createdby,
            'leavetype'     =>     $team->leavetype,
            'totaldays'     =>     $totalrqstday,
            'year'     =>     '2023',
            'created_at'          =>     date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
          ]);




          $period = CarbonPeriod::create($team->from, $team->to);
          $datess = [];
          foreach ($period as $date) {
            $datess[] = $date->format('Y-m-d');
          }


          $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
            ->where('enddate', '<=', $team->to)->select('startdate')->get();

          if (count($getholidays) != 0) {
            foreach ($getholidays as $date) {
              $hdatess[] = date('Y-m-d', strtotime($date->startdate));
            }
          } else {
            $hdatess[] = 0;
          }
          $sl_leave = array_diff($datess, $hdatess);

          //  dd( $cl_leave );
          $sl_leave_total = count(array_diff($datess, $hdatess));

          $lstatus = "SL/A";




          $noofdaysaspertimesheet = DB::table('timesheets')
            ->where('created_by', auth()->user()->teammember_id)
            ->where('date', '>=', '2023-04-26')
            ->where('date', '<=', '2023-05-25')
            ->select('timesheets.*')
            ->first();
          // dd($noofdaysaspertimesheet );

          foreach ($sl_leave as $cl_leave) {




            $cl_leave_day = date('d', strtotime($cl_leave));
            $cl_leave_month = date('F', strtotime($cl_leave));

            if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
              $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
            }


            $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)->first();

            $column = '';
            switch ($cl_leave_day) {
              case '26':
                $column = 'twentysix';
                break;
              case '27':
                $column = 'twentyseven';
                break;
              case '28':
                $column = 'twentyeight';
                break;
              case '29':
                $column = 'twentynine';
                break;
              case '30':
                $column = 'thirty';
                break;
              case '31':
                $column = 'thirtyone';
                break;
              case '01':
                $column = 'one';
                break;
              case '02':
                $column = 'two';
                break;
              case '03':
                $column = 'three';
                break;
              case '04':
                $column = 'four';
                break;
              case '05':
                $column = 'five';
                break;
              case '06':
                $column = 'six';
                break;
              case '07':
                $column = 'seven';
                break;
              case '08':
                $column = 'eight';
                break;
              case '09':
                $column = 'nine';
                break;
              case '10':
                $column = 'ten';
                break;
              case '11':
                $column = 'eleven';
                break;
              case '12':
                $column = 'twelve';
                break;
              case '13':
                $column = 'thirteen';
                break;
              case '14':
                $column = 'fourteen';
                break;
              case '15':
                $column = 'fifteen';
                break;
              case '16':
                $column = 'sixteen';
                break;
              case '17':
                $column = 'seventeen';
                break;
              case '18':
                $column = 'eighteen';
                break;
              case '19':
                $column = 'ninghteen';
                break;
              case '20':
                $column = 'twenty';
                break;
              case '21':
                $column = 'twentyone';
                break;
              case '22':
                $column = 'twentytwo';
                break;
              case '23':
                $column = 'twentythree';
                break;
              case '24':
                $column = 'twentyfour';
                break;
              case '25':
                $column = 'twentyfive';
                break;
            }

            if (!empty($column)) {

              DB::table('attendances')
                ->where('employee_name', $team->createdby)
                ->where('month', $cl_leave_month)
                ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
                ->whereRaw("{$column} != 'LWP'")
                ->update([
                  $column => $lstatus,
                ]);
            }
          }
        }
        // dd($id);
        $applyleaveteam = DB::table('leaveteams')
          ->leftjoin('teammembers', 'teammembers.id', 'leaveteams.teammember_id')
          ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
          ->where('leaveteams.leave_id', $id)
          ->select('teammembers.emailid')->get();
        //   dd($applyleaveteam);
        if ($applyleaveteam != null) {
          foreach ($applyleaveteam as $applyleaveteammail) {
            $data = array(
              'emailid' =>  $applyleaveteammail->emailid,
              'team_member' =>  $team->team_member,
              'from' =>  $team->from,
              'to' =>  $team->to,
            );

            Mail::send('emails.applyleaveteam', $data, function ($msg) use ($data) {
              $msg->to($data['emailid']);
              $msg->subject('VSA Leave Approved');
            });
          }
        }
        $data = array(
          'emailid' =>  $team->emailid,
          'id' =>  $id,
          'from' =>  $team->from,
          'to' =>  $team->to,
        );

        Mail::send('emails.applyleavestatus', $data, function ($msg) use ($data) {
          $msg->to($data['emailid']);
          // $msg->cc('priyankasharma@kgsomani.com');
          $msg->subject('VSA Leave Approved');
        });
      }
      if ($request->status == 2) {
        $team = DB::table('applyleaves')
          ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
          ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
          ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
          ->where('applyleaves.id', $id)
          ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->first();
        $data = array(
          'emailid' =>  $team->emailid,
          'id' =>  $id,
          'from' =>  $team->from,
          'to' =>  $team->to,
        );

        Mail::send('emails.applyleavereject', $data, function ($msg) use ($data) {
          $msg->to($data['emailid']);
          // $msg->cc('priyankasharma@kgsomani.com');
          $msg->subject('VSA Leave Reject');
        });



        $period = CarbonPeriod::create($team->from, $team->to);
        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');

          DB::table('timesheets')->where('date', $date->format('Y-m-d'))
            ->where('created_by', $team->createdby)->delete();
          DB::table('timesheetusers')->where('createdby', $team->createdby)
            ->where('date', $date->format('Y-m-d'))->delete();
        }


        $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
          ->where('enddate', '<=', $team->to)->select('startdate')->get();

        if (count($getholidays) != 0) {
          foreach ($getholidays as $date) {
            $hdatess[] = date('Y-m-d', strtotime($date->startdate));
          }
        } else {
          $hdatess[] = 0;
        }
        $leave = array_diff($datess, $hdatess);

        //  dd( $cl_leave );
        $leave_total = count(array_diff($datess, $hdatess));

        $lstatus = NULL;






        foreach ($leave as $cl_leave) {

          $cl_leave_day = date('d', strtotime($cl_leave));
          $cl_leave_month = date('F', strtotime($cl_leave));

          if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
            $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
          }


          $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
            ->where('month', $cl_leave_month)->first();

          $column = '';
          switch ($cl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }

          if (!empty($column)) {
            $columnValue = DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              ->value($column);

            if ($columnValue == "SL/C" || $columnValue == "SL/A") {
              DB::table('attendances')
                ->where('employee_name', $team->createdby)
                ->where('month', $cl_leave_month)
                ->decrement('sick_leave');
            }

            if ($columnValue == "EL/C" || $columnValue == "EL/A") {
              DB::table('attendances')
                ->where('employee_name', $team->createdby)
                ->where('month', $cl_leave_month)
                ->decrement('exam_leave');
            }
            if ($columnValue == "BL/C" || $columnValue == "BL/A") {
              DB::table('attendances')
                ->where('employee_name', $team->createdby)
                ->where('month', $cl_leave_month)
                ->decrement('birthday_religious');
            }
            if ($columnValue == "LWP") {
              DB::table('attendances')
                ->where('employee_name', $team->createdby)
                ->where('month', $cl_leave_month)
                ->decrement('LWP');
            }
            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              ->update([
                $column => $lstatus
              ]);
          }
        }
      }
      $data = $request->except(['_token', 'teammember_id']);
      $data['updatedby'] = auth()->user()->teammember_id;
      Applyleave::find($id)->update($data);
      $output = array('msg' => 'Updated Successfully');
      return redirect('applyleave')->with('success', $output);
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
   * @param  \App\Models\Employeereferral  $employeereferral
   * @return \Illuminate\Http\Response
   */
  public function destroy(Employeereferral $employeereferral)
  {
    //
  }
}
