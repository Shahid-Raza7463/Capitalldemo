<?php

namespace App\Http\Controllers;


use App\Models\Teammember;
use App\Models\Timesheet;
use App\imports\Timesheetimport;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Assignment;
use App\Models\Assignmentmapping;
use App\Models\Job;
use App\Models\Timesheetusers;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use DB;
use Excel;
use DateTime;


class TimesheetController extends Controller
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
  public function full_list()
  {
    $time =  DB::table('timesheets')->get();
    foreach ($time as $value) {
      //    dd(date('F', strtotime($value->date)));
      DB::table('timesheets')->where('id', $value->id)->where('month', null)->update([
        'month'         =>     date('F', strtotime($value->date)),
      ]);
    }
    $time =  DB::table('timesheets')->where('month', 'November')
      ->orwhere('month', 'October')->get();
    // dd($time);
    foreach ($time as $value) {
      //  dd(date('Y-m-d', strtotime($value->date)));
      DB::table('timesheets')->where('id', $value->id)->update([
        'date'         =>     date('Y-m-d', strtotime($value->date)),
      ]);
    }
    $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
      ->where('teammembers.status', '1')->distinct()->get();
    //  dd($teammember);
    $month = DB::table('timesheets')
      ->select('timesheets.month')->distinct()->get();
    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    //dd($month);
    $timesheetData = DB::table('timesheets')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
    // dd($timesheetData);
    return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
  }
  //! old code 
  // // patner zxzx
  // public function allteamsubmitted()
  // {

  //   $get_date = DB::table('timesheetreport')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //     // ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //     ->latest()->get();

  //   dd($get_date);
  //   // adminfil
  //   return view('backEnd.timesheet.myteamindex', compact('get_date'));
  // }

  // !old code 20-12-23
  // public function allteamsubmitted()
  // {

  //   $get_date = DB::table('timesheetreport')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //     // ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //     ->latest()->get();

  //   // dd($get_date);
  //   // adminfil
  //   return view('backEnd.timesheet.myteamindex', compact('get_date'));
  // }
  // patner zxzx
  public function allteamsubmitted()
  {

    $get_datess = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      // ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->latest()->get();

    // maping double date ************
    $groupedData = $get_datess->groupBy(function ($item) {
      return $item->team_member . '|' . $item->week;
    })->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date'));
  }


  // public function timesheet_mylist()
  // {
  //   if (auth()->user()->role_id == 13) {
  //     // die;
  //     $client = Client::select('id', 'client_name')->get();
  //     $getauth =  DB::table('timesheetusers')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->where('status', '0')
  //       ->orderby('id', 'desc')->first();

  //     $dropdownYears = DB::table('timesheets')
  //       ->where('created_by', auth()->user()->teammember_id)
  //       ->select(DB::raw('YEAR(date) as year'))
  //       ->distinct()->orderBy('year', 'DESC')->pluck('year');
  //     $dropdownYears = DB::table('timesheets')
  //       ->where('created_by', auth()->user()->teammember_id)
  //       ->select(DB::raw('YEAR(date) as year'))
  //       ->distinct()->orderBy('year', 'DESC')->pluck('year');


  //     $dropdownMonths = DB::table('timesheets')
  //       ->where('created_by', auth()->user()->teammember_id)
  //       ->distinct()
  //       ->pluck('month');

  //     $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();

  //     $currentDate = now();


  //     $month = $currentDate->format('F');
  //     $year = $currentDate->format('Y');

  //     $time =  DB::table('timesheets')->get();
  //     foreach ($time as $value) {
  //       //dd(date('F', strtotime($value->date)));
  //       DB::table('timesheets')->where('id', $value->id)->update([
  //         'month'         =>     date('F', strtotime($value->date)),
  //       ]);
  //     }
  //     $teammember = DB::table('timesheets')
  //       ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
  //       ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //       ->where('timesheetusers.partner', auth()->user()->teammember_id)
  //       ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
  //     //  dd($teammember);
  //     $month = DB::table('timesheets')
  //       ->select('timesheets.month')->distinct()->get();

  //     $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
  //       ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
  //     $years = $result->pluck('year');

  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->where('timesheetusers.createdby', auth()->user()->teammember_id)
  //       ->where('timesheetusers.status', 0)
  //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
  //     // dd($timesheetData);

  //     // $timesheetData = DB::table('timesheetusers')
  //     //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     //   ->where('timesheetusers.createdby', auth()->user()->teammember_id)
  //     //   ->where('timesheetusers.status', 1)
  //     //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
  //     // // dd($timesheetData);
  //     $getauthh =  DB::table('timesheetusers')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->orderby('id', 'desc')->first();
  //     $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

  //     if ($getauthh  == null) {
  //       return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
  //     } else {
  //       // shahid
  //       return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
  //     }
  //   } else {

  //     $dropdownYears = DB::table('timesheets')
  //       ->where('created_by', auth()->user()->teammember_id)
  //       ->select(DB::raw('YEAR(date) as year'))
  //       ->distinct()->orderBy('year', 'DESC')->pluck('year');

  //     $dropdownMonths = DB::table('timesheets')
  //       ->where('created_by', auth()->user()->teammember_id)
  //       ->distinct()
  //       ->pluck('month');

  //     $currentDate = now();


  //     $month = $currentDate->format('F');
  //     $year = $currentDate->format('Y');

  //     $getauths =  DB::table('timesheetusers')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->where('status', '1')
  //       ->orderby('id', 'desc')->first();
  //     if ($getauths != null) {
  //       $getauth =  DB::table('timesheetusers')
  //         ->where('createdby', auth()->user()->teammember_id)
  //         ->where('status', '1')
  //         ->orderby('id', 'desc')->first();
  //       //dd($getauth);
  //     } else {

  //       $getauth =  DB::table('timesheetusers')
  //         ->where('createdby', auth()->user()->teammember_id)
  //         ->where('status', '0')
  //         ->orderby('id', 'desc')->first();
  //       //dd($getauth);
  //     }

  //     $getauthh =  DB::table('timesheetusers')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->orderby('id', 'desc')->first();


  //     $client = Client::select('id', 'client_name')->get();
  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->where('timesheetusers.createdby', auth()->user()->teammember_id)
  //       ->where('timesheetusers.status', 0)
  //       //   ->where('timesheets.month', $month)
  //       ->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
  //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->get();
  //     //  dd($timesheetData);
  //     $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();
  //     $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

  //     if ($getauthh  == null) {
  //       return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
  //     } else {
  //       return view('backEnd.timesheet.index', compact(
  //         'timesheetData',
  //         'getauth',
  //         'client',
  //         'partner',
  //         'timesheetrequest',
  //         'dropdownYears',
  //         'dropdownMonths',
  //         'month',
  //         'year',
  //       ));
  //     }
  //   }
  // }

  public function timesheet_mylist()
  {
    if (auth()->user()->role_id == 13) {
      // die;
      $client = Client::select('id', 'client_name')->get();
      $getauth =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '0')
        ->orderby('id', 'desc')->first();

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');
      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');


      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');

      $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();

      $currentDate = now();


      $month = $currentDate->format('F');
      $year = $currentDate->format('Y');

      //	  $time =  DB::table('timesheets')->get();
      // foreach ($time as $value) {
      //dd(date('F', strtotime($value->date)));
      //      DB::table('timesheets')->where('id',$value->id)->update([	
      //          'month'         =>     date('F', strtotime($value->date)),
      //           ]);
      // }
      $teammember = DB::table('timesheets')
        ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
      // dd($timesheetData);
      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
      }
    } else {

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');

      $currentDate = now();


      $month = $currentDate->format('F');
      $year = $currentDate->format('Y');

      $getauths =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '1')
        ->orderby('id', 'desc')->first();
      if ($getauths != null) {
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '0')
          ->orderby('id', 'desc')->first();
        //dd($getauth);
      } else {

        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '0')
          ->orderby('id', 'desc')->first();
        //dd($getauth);
      }

      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();


      $client = Client::select('id', 'client_name')->get();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        //   ->where('timesheets.month', $month)
        ->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->get();
      //  dd($timesheetData);
      $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        return view('backEnd.timesheet.index', compact(
          'timesheetData',
          'getauth',
          'client',
          'partner',
          'timesheetrequest',
          'dropdownYears',
          'dropdownMonths',
          'month',
          'year',
        ));
      }
    }
  }
  // !old code 20-12-23
  // public function timesheet_teamlist()
  // {
  //   if (auth()->user()->role_id == 13) {
  //     // get all partner
  //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
  //       ->orderBy('team_member', 'asc')->get();

  //     $get_date = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest()->get();
  //   } else {
  //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
  //       ->orderBy('team_member', 'asc')->get();
  //     $get_date = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest()->get();
  //   }

  //   dd($get_date);
  //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
  // }
  // public function timesheet_teamlist()
  // {
  //   if (auth()->user()->role_id == 13) {
  //     // get all partner
  //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
  //       ->orderBy('team_member', 'asc')->get();

  //     $get_date = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest()->get();
  //   } else {
  //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
  //       ->orderBy('team_member', 'asc')->get();
  //     $get_date = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest()->get();
  //   }

  //   // dd($get_date);
  //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
  // }
  // patner zxzx
  public function timesheet_teamlist()
  {
    if (auth()->user()->role_id == 13) {
      // get all partner
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();

      $get_datess = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
    } else {
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();
      $get_datess = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
    }

    // dd($get_datess);
    // maping week wise data 
    // $groupedData = $get_datess->groupBy('week')->map(function ($group) {
    //   $firstItem = $group->first();

    //   return (object)[
    //     'id' => $firstItem->id,
    //     'teamid' => $firstItem->teamid,
    //     'week' => $firstItem->week,
    //     'totaldays' => $group->sum('totaldays'),
    //     'totaltime' => $group->sum('totaltime'),
    //     'startdate' => $firstItem->startdate,
    //     'enddate' => $firstItem->enddate,
    //     'partnername' => $firstItem->partnername,
    //     'created_at' => $firstItem->created_at,
    //     'team_member' => $firstItem->team_member,
    //     'partnerid' => $firstItem->partnerid,
    //   ];
    // });

    // $get_date = collect($groupedData->values());



    $groupedData = $get_datess->groupBy(function ($item) {
      return $item->team_member . '|' . $item->week;
    })->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());


    return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
  }
  //! old code
  // public function partnersubmitted()
  // {
  //   // get all partner
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
  //     ->orderBy('team_member', 'asc')->get();
  //   // dd($partner);
  //   $get_date = DB::table('timesheetreport')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //     ->latest()->get();
  //   dd($get_date);
  //   // shahid
  //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
  // }
  //! old code 
  // patner zxzx
  // public function partnersubmitted()
  // {
  //   // dd(auth()->user());
  //   $get_date = DB::table('timesheetreport')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //     ->latest()->get();
  //   dd($get_date);

  //   return view('backEnd.timesheet.myteamindex', compact('get_date'));
  // }
  // patner zxzx
  public function partnersubmitted()
  {
    // 844
    // dd(auth()->user());
    $get_datess = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->latest()->get();
    // dd($get_date);


    // maping week wise data 
    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date'));
  }
  //! running code done 
  public function filterDataAdmin(Request $request)
  {
    if (auth()->user()->role_id == 13) {
      //shahidfil
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest();

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    } else {

      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest();

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    }
    $filteredData = $query->get();

    return response()->json($filteredData);
  }


  //! old code 
  // public function weeklylist(Request $request)
  // {
  //   if (auth()->user()->role_id == 13) {

  //     $date = DB::table('timesheetreport')->where('id', $request->id)->first();
  //     // dd($date);
  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->where('timesheetusers.createdby', $request->teamid)
  //       ->where('timesheetusers.partner', $request->partnerid)
  //       ->where('timesheetusers.status', 1)
  //       ->where('timesheetusers.date', '>=', $date->startdate)
  //       //->where('timesheetusers.date', $date->enddate)
  //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
  //     // dd($timesheetData);
  //   } else {
  //     $date = DB::table('timesheetreport')->where('id', $request->id)->first();
  //     // dd($date);
  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->where('timesheetusers.createdby', $request->teamid)
  //       ->where('timesheetusers.partner', $request->partnerid)
  //       ->where('timesheetusers.status', 1)
  //       ->where('timesheetusers.date', '>=', $date->startdate)
  //       ->where('timesheetusers.date', '<=', $date->enddate)
  //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
  //   }
  //   // dd($timesheetData);
  //   return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  // }

  // public function weeklylist(Request $request)
  // {
  //   dd($request);
  //   if (auth()->user()->role_id == 13) {

  //     $date = DB::table('timesheetreport')->where('id', $request->id)->first();
  //     // dd($date);
  //     // $timesheetData = DB::table('timesheetusers')
  //     //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     //   ->where('timesheetusers.createdby', $request->teamid)
  //     //   ->where('timesheetusers.partner', $request->partnerid)
  //     //   ->where('timesheetusers.status', 1)
  //     //   ->where('timesheetusers.date', '>=', $date->startdate)
  //     //   //->where('timesheetusers.date', $date->enddate)
  //     //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
  //     // // dd($timesheetData);
  //     // $timesheetData = DB::table('timesheetusers')
  //     //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     //   ->where('timesheetusers.createdby', $request->teamid)
  //     //   ->where('timesheetusers.partner', $request->partnerid)
  //     //   //   ->where('timesheetusers.status', 1)
  //     //   ->whereIn('timesheetusers.status', [1, 2, 3])
  //     //   ->where('timesheetusers.date', '>=', $date->startdate)
  //     //   //-      ->where('timesheetusers.date', '<=', $date->enddate)
  //     //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
  //     // // dd($timesheetData);

  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->where('timesheetusers.createdby', $request->teamid)
  //       ->where('timesheetusers.partner', $request->partnerid)
  //       // ->where('timesheetusers.status', 1)
  //       ->whereIn('timesheetusers.status', [1, 2, 3])
  //       ->where('timesheetusers.date', '>=', $date->startdate)
  //       ->where('timesheetusers.date', '<=', $date->enddate)
  //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
  //   } else {
  //     // edit timesheet
  //     // dd(auth()->user());
  //     $date = DB::table('timesheetreport')->where('id', $request->id)->first();
  //     // dd($date);
  //     // $timesheetData = DB::table('timesheetusers')
  //     //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     //   ->where('timesheetusers.createdby', $request->teamid)
  //     //   ->where('timesheetusers.partner', $request->partnerid)
  //     //   ->where('timesheetusers.status', 1)
  //     //   ->where('timesheetusers.date', '>=', $date->startdate)
  //     //   ->where('timesheetusers.date', '<=', $date->enddate)
  //     //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->where('timesheetusers.createdby', $request->teamid)
  //       ->where('timesheetusers.partner', $request->partnerid)
  //       // ->where('timesheetusers.status', 1)
  //       ->whereIn('timesheetusers.status', [1, 2, 3])
  //       ->where('timesheetusers.date', '>=', $date->startdate)
  //       ->where('timesheetusers.date', '<=', $date->enddate)
  //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
  //   }
  //   // dd($timesheetData);
  //   return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  // }

  // patner zxzx
  public function weeklylist(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {

      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      // dd($date);
      // $timesheetData = DB::table('timesheetusers')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      //   ->where('timesheetusers.createdby', $request->teamid)
      //   ->where('timesheetusers.partner', $request->partnerid)
      //   ->where('timesheetusers.status', 1)
      //   ->where('timesheetusers.date', '>=', $date->startdate)
      //   //->where('timesheetusers.date', $date->enddate)
      //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
      // // dd($timesheetData);
      // $timesheetData = DB::table('timesheetusers')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      //   ->where('timesheetusers.createdby', $request->teamid)
      //   ->where('timesheetusers.partner', $request->partnerid)
      //   //   ->where('timesheetusers.status', 1)
      //   ->whereIn('timesheetusers.status', [1, 2, 3])
      //   ->where('timesheetusers.date', '>=', $date->startdate)
      //   //-      ->where('timesheetusers.date', '<=', $date->enddate)
      //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
      // // dd($timesheetData);

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $request->teamid)
        // i have removed below line 
        // ->where('timesheetusers.partner', $request->partnerid)
        // ->where('timesheetusers.status', 1)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.date', '>=', $date->startdate)
        ->where('timesheetusers.date', '<=', $date->enddate)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    } else {
      // edit timesheet
      // dd(auth()->user());
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      // dd($date);
      // $timesheetData = DB::table('timesheetusers')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      //   ->where('timesheetusers.createdby', $request->teamid)
      //   ->where('timesheetusers.partner', $request->partnerid)
      //   ->where('timesheetusers.status', 1)
      //   ->where('timesheetusers.date', '>=', $date->startdate)
      //   ->where('timesheetusers.date', '<=', $date->enddate)
      //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $request->teamid)
        // i have removed below line 
        // ->where('timesheetusers.partner', $request->partnerid)
        // ->where('timesheetusers.status', 1)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.date', '>=', $date->startdate)
        ->where('timesheetusers.date', '<=', $date->enddate)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  }








  //* admin and partner is done 
  // public function rejectedlist(Request $request)
  // {
  //   // dd(auth()->user());
  //   if (auth()->user()->role_id == 13) {
  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->where('timesheetusers.createdby', auth()->user()->teammember_id)
  //       ->where('timesheetusers.status', 2)
  //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
  //     // dd($timesheetData);
  //   } else {

  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       // ->where('timesheetusers.createdby', $request->teamid)
  //       // ->where('timesheetusers.partner', $request->partnerid)
  //       ->where('timesheetusers.status', 2)
  //       // ->whereIn('timesheetusers.status', [1, 2])
  //       // ->where('timesheetusers.date', '>=', $date->startdate)
  //       // ->where('timesheetusers.date', '<=', $date->enddate)
  //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
  //   }
  //   // dd($timesheetData);
  //   return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
  // }


  //! running code done 
  // public function filterweeklylist(Request $request)
  // {

  //   if (auth()->user()->role_id == 13) {
  //     //shahidfil
  //     $clientname = $request->input('clientname');
  //     $assignmentname = $request->input('assignmentname');


  //     $query = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest();

  //     // teamname with othser field to  filter
  //     if ($clientname) {
  //       $query->where('timesheetreport.teamid', $clientname);
  //     }

  //     if ($clientname && $assignmentname) {
  //       $query->where(function ($q) use ($clientname, $assignmentname) {
  //         $q->where('timesheetreport.teamid', $clientname)
  //           ->where('timesheetreport.totaltime', $assignmentname);
  //       });
  //     }

  //     // patner or othse one data
  //     if ($assignmentname) {
  //       $query->where('timesheetreport.partnerid', $assignmentname);
  //     }
  //   } else {
  //     // admin dashboard
  //     $clientname = $request->input('clientname');
  //     $assignmentname = $request->input('assignmentname');

  //     $date = DB::table('timesheetreport')->where('id', $request->id)->first();

  //     $query = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->where('timesheetusers.createdby', $request->teamid)
  //       ->where('timesheetusers.partner', $request->partnerid)
  //       ->where('timesheetusers.status', 1)
  //       ->where('timesheetusers.date', '>=', $date->startdate)
  //       ->where('timesheetusers.date', '<=', $date->enddate)
  //       ->select('timesheetusers.*', 'teammembers.team_member');

  //     // teamname with othser field to  filter
  //     if ($clientname) {
  //       $query->where('timesheetreport.teamid', $clientname);
  //     }

  //     if ($clientname && $assignmentname) {
  //       $query->where(function ($q) use ($clientname, $assignmentname) {
  //         $q->where('timesheetreport.teamid', $clientname)
  //           ->where('timesheetreport.totaltime', $assignmentname);
  //       });
  //     }

  //     // patner or othse one data
  //     if ($assignmentname) {
  //       $query->where('timesheetreport.partnerid', $assignmentname);
  //     }

  //   }
  //   $filteredData = $query->get();

  //   return response()->json($filteredData);
  // }


  public function filterweeklylist(Request $request)
  {
    // admin dashboard
    $clientid = $request->input('clientname');
    $assignmentid = $request->input('assignmentname');

    $date = DB::table('timesheetreport')->where('id', $request->id)->first();

    $query = DB::table('timesheetusers')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers as partnername', 'partnername.id', 'timesheetusers.partner')
      ->where('timesheetusers.createdby', $request->teamid)
      ->where('timesheetusers.partner', $request->partnerid)
      ->where('timesheetusers.status', 1)
      ->where('timesheetusers.date', '>=', $date->startdate)
      ->where('timesheetusers.date', '<=', $date->enddate)
      ->select('timesheetusers.*', 'teammembers.team_member', 'clients.client_name', 'assignments.assignment_name', 'partnername.team_member as partnername_name');

    if ($clientid) {
      $query->where('timesheetusers.client_id',   $clientid);
    }

    if ($clientid && $assignmentid) {
      $query->where(function ($q) use ($clientid, $assignmentid) {
        $q->where('timesheetusers.client_id',   $clientid)
          ->where('assignments.id',   $assignmentid);
      });
    }

    if ($assignmentid) {
      $query->where('assignments.id',   $assignmentid);
    }

    $filteredData = $query->get();
    return response()->json($filteredData);
  }


  public function timesheet_submit(Request $request)
  {
    //dd($request);
    try {
      DB::table('timesheetusers')->where('id', $request->imsheetid)->update([
        'client_id' => $request->client_id,
        'assignment_id' => $request->assignment_id,
        'workitem' => $request->workitem,
        'totalhour' => $request->totalhour,
        'status'         =>     1,
        'updatedby'  => auth()->user()->teammember_id,
        'updated_at'              =>    date('y-m-d'),
      ]);

      $output = array('msg' => 'Submit Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function transformDate($value, $format = 'Y-m-d')
  {
    try {
      return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
      return \Carbon\Carbon::createFromFormat($format, $value);
    }
  }
  public function timesheetexcelStore(Request $request)
  {
    $request->validate([
      'file' => 'required'
    ]);

    try {
      $file = $request->file;
      //  dd($file);
      $data = $request->except(['_token']);
      $dataa = Excel::toArray(new Timesheetimport, $file);
      //dd($dataa);
      foreach ($dataa[0] as $key => $value) {


        $currentday =
          \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['date'])->format('Y-m-d');
        // $currentday= date('Y-m-d', strtotime($value['date']));
        // dd($currentday);

        $mytime = Carbon::now();

        $currentdate = $mytime->toDateString();
        $hour = $value['hour'];





        if ($currentday > $currentdate) {
          $output = array('msg' => 'You Can Not Fill Timesheet For Future Date (' . date('d-m-Y', strtotime($currentday)) . ')');
          return redirect('timesheet')->with('statuss', $output);
        } elseif ($hour > 24) {
          $output = array('msg' => 'The time entered exceeds the maximum of 24 hours !');
          return back()->with('statuss', $output);
        } else {

          $leaves = DB::table('applyleaves')
            ->where('applyleaves.createdby', auth()->user()->teammember_id)
            ->where('status', '!=', 2)
            //->orWhere('status',0)
            ->select('applyleaves.from', 'applyleaves.to')
            ->get();
          // dd($leaves);
          if (count($leaves) != 0) {
            foreach ($leaves as $leave) {
              //Convert each data from table to Y-m-d format to compare
              $days = CarbonPeriod::create(
                date('Y-m-d', strtotime($leave->from)),
                date('Y-m-d', strtotime($leave->to))
              );

              foreach ($days as $day) {
                $leavess[] = $day->format('Y-m-d');
                // dd($leavess);



              }
            }
            //dd($leavess);


            //  date('Y-m-d', strtotime($intval($value['date'])));
            // dd($currentday);
            if ($leavess != null) {
              //dd('if');
              foreach ($leavess as $leave) {

                if ($leave == $currentday) {
                  // dd('if');
                  // $ifcount=$ifcount+1;
                  $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
                  return redirect('timesheet')->with('statuss', $output);
                } else {
                  //  dd($currentday);
                }
              }
            }
          }
          $clients   = DB::table('clients')->where('client_name', $value['clientname'])->pluck('id')->first();
          //dd($clients);
          if ($clients == null) {
            //dd($clients);
            $output = array('msg' => 'Client Name (' . $value['clientname'] . ') Not Match Please Check!!');
            return back()->with('statuss', $output);
          } else {
            //dd($clients);
            $assignments = DB::table('assignments')->where('assignment_name', $value['assignmentname'])->pluck('id')->first();
            if ($assignments == null) {
              $output = array('msg' => 'Assigment Name (' . $value['assignmentname'] . ') Not Found Please Check!!');
              return back()->with('statuss', $output);
            }
            $partner = DB::table('teammembers')->where('team_member', $value['partner'])->pluck('id')->first();
            if ($partner == null) {
              $output = array('msg' => 'Partner Name (' . $value['partner'] . ') Not Match Please Check!!');
              return back()->with('statuss', $output);
            }
            if ($value['billablestatus'] != "Non Billable" && $value['billablestatus'] != "Billable") {
              $output = array('msg' => 'Billable status (' . $value['billablestatus'] . ') Not Match Please Check!!');
              return back()->with('statuss', $output);
            }
            $timesheet = DB::table('timesheets')->where('created_by', auth()->user()->teammember_id)
              ->where('date', $value['date'])->pluck('id')->first();

            if ($timesheet == null) {

              $id = DB::table('timesheets')->insertGetId(
                [
                  'created_by' => auth()->user()->teammember_id,
                  'date'     =>     $this->transformDate($value['date']),
                  'created_at'          =>     date('Y-m-d H:i:s'),
                ]
              );
              $timesheets = DB::table('timesheets')->where('id', $id)->first();
              DB::table('timesheets')->where('id', $timesheets->id)->update([
                'date'     =>    date('Y-m-d', strtotime($timesheets->date)),
                'month'     =>    date('F', strtotime($timesheets->date)),
              ]);
            }



            DB::table('timesheetusers')->insert([
              'date'     =>       $this->transformDate($value['date']),
              'client_id'     =>     $clients,
              'workitem'     =>     $value['workitem'],
              'billable_status'     =>      $value['billablestatus'],
              'timesheetid'     =>     $id,

              'hour'     =>     $value['hour'],
              'totalhour' =>      $value['hour'],
              'assignment_id'     =>     $assignments,
              'partner'     =>     $partner,
              'createdby' => auth()->user()->teammember_id,
              'created_at'          =>     date('Y-m-d H:i:s'),
              'updated_at'              =>    date('Y-m-d H:i:s'),
            ]);
            $totalhour = DB::table('timesheetusers')->select('date', DB::raw('COUNT(*) as `count`'))
              ->where('createdby', auth()->user()->teammember_id)
              ->groupBy('date')
              ->havingRaw('COUNT(*) > 1')

              ->get();
            foreach ($totalhour as $value) {
              $sum = DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)->where('date', $value->date)->sum('hour');

              DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)->where('date', $value->date)->update([
                'totalhour'         =>   $sum,
              ]);

              //attendance reflection'

              $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
                ->where('month', 'June')->first();
              //  dd($value->created_by);

              // dd($attendances);
              if ($attendances ==  null) {
                $a = DB::table('attendances')->insert([
                  'employee_name'         =>     auth()->user()->teammember_id,
                  'month'         =>    'June',
                  'created_at'          =>     date('Y-m-d H:i:s'),
                  //   'exam_leave'      =>$value->date_total,
                ]);
                // dd($a);
              }

              //   dd($noofdaysaspertimesheet);
              $hdatess = date('Y-m-d', strtotime($value->date));

              // dd($hdatess);
              if ($hdatess == '2023-05-26') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentysix'         =>     $sum,
                  ]);
              }

              if ($hdatess == '2023-05-27') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyseven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-28') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyeight'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-29') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentynine'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-30') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirty'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-31') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirtyone'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-01') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'one'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-02') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'two'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-03') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'three'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-04') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'four'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-05') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'five'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-06') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'six'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-07') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'seven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-08') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eight'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-09') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'nine'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-10') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'ten'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-11') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eleven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-12') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twelve'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-13') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-14') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'fourteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-15') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'fifteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-16') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'sixteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-17') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'seventeen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-18') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eighteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-19') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'ninghteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-20') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twenty'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-21') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyone'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-22') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentytwo'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-23') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentythree'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-24') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyfour'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-25') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyfive'         =>     $sum,
                  ]);
              }

              //end attendance




            }
          }
        }
      }
      //dd($dataa);
      $output = array('msg' => 'Excel file upload Successfully');
      return back()->with('success', $output);
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
    if (auth()->user()->role_id == 11) {
      //			  $time =  DB::table('timesheets')->get();
      //foreach ($time as $value) {
      //dd(date('F', strtotime($value->date)));
      //   DB::table('timesheets')->where('id',$value->id)->where('month',null)->update([	
      //     'month'         =>     date('F', strtotime($value->date)),
      //       ]);
      //}
      //			   $time =  DB::table('timesheets')->where('month','November')
      //     ->orwhere('month','October')->get();
      //dd($time);
      //foreach ($time as $value) {
      //dd(date('Y-m-d', strtotime($value->date)));
      //DB::table('timesheets')->where('id',$value->id)->update([	
      //  'date'         =>     date('Y-m-d', strtotime($value->date)),
      //  ]);
      //}
      // $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
      //   ->where('teammembers.status', '1')->distinct()->get();
      // //  dd($teammember);
      // $month = DB::table('timesheets')
      //   ->select('timesheets.month')->distinct()->get();
      // $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      //   ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      // $years = $result->pluck('year');

      // //dd($month);
      // $timesheetData = DB::table('timesheets')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
      // // dd($timesheetData);
      // return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
      return view('backEnd.timesheet.adminstatustime');
    } elseif (auth()->user()->role_id == 18) {

      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
        //   ->where('teammembers.status','1')
        ->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');

      //dd($month );

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
      // dd($timesheetData);
      return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
    } elseif (auth()->user()->role_id == 13) {
      //die;
      // dd(auth()->user()->teammember_id);
      // 			  $time =  DB::table('timesheets')->get();
      // foreach ($time as $value) {
      //     //dd(date('F', strtotime($value->date)));
      //     DB::table('timesheets')->where('id',$value->id)->update([	
      //         'month'         =>     date('F', strtotime($value->date)),
      //          ]);
      // }
      // $teammember = DB::table('timesheets')
      //   ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->where('timesheetusers.partner', auth()->user()->teammember_id)
      //   ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      // //  dd($teammember);
      // $month = DB::table('timesheets')
      //   ->select('timesheets.month')->distinct()->get();

      // $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      //   ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      // $years = $result->pluck('year');


      // $timesheetData = DB::table('timesheets')
      //   ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->where('timesheetusers.partner', auth()->user()->teammember_id)
      //   ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
      // // dd($timesheetData);
      // return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
      return view('backEnd.timesheet.statustime');
    } else {
      return view('backEnd.timesheet.staffworksheet');
    }
  }
  public function show(Request $request)
  {
    if ($request->method() === 'POST') {

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');


      $month = $request->month;
      $year = $request->year;


      $getauth =  DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();

      //   dd($getauth);
      $client = Client::select('id', 'client_name')->get();
      $timesheetData =  $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', auth()->user()->teammember_id)
        ->where('timesheets.month', $month)
        ->whereRaw('YEAR(timesheets.date) = ?', [$year])
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(100);
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauth  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        return view('backEnd.timesheet.index', compact(
          'timesheetData',
          'getauth',
          'client',
          'partner',
          'timesheetrequest',
          'dropdownYears',
          'dropdownMonths',
          'month',
          'year',
        ));
      }
    }

    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    if (auth()->user()->teammember_id == 23) {
      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('teammembers.role_id', '15')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();


      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    } elseif (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    } elseif (auth()->user()->role_id == 13) {
      $teammember = DB::table('timesheets')
        ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    }
    return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  //! old code 
  // public function create(Request $request)
  // {
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  //   $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  //   if (auth()->user()->role_id == 11) {
  //     $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
  //   } elseif (auth()->user()->role_id == 13) {
  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   } else {
  //     $client = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //   }
  //   $assignment = Assignment::select('id', 'assignment_name')->get();
  //   //   dd($assignment);
  //   if ($request->ajax()) {
  //     // dd(auth()->user());

  //     // if (auth()->user()->role_id == 13) {
  //     //   echo "<option>Select Assignment</option>";
  //     //   foreach (DB::table('assignmentbudgetings')
  //     //     ->where('client_id', $request->cid)
  //     //      ->distinct('assignments.id')
  //     //     ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //     //     ->select('assignmentbudgetings.assignmentgenerate_id', 'assignment_name', 'assignmentgenerate_id')
  //     //     ->get() as $sub) {
  //     //     echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //     //   }
  //     // } 




  //     if (isset($request->cid)) {
  //       if (auth()->user()->role_id == 13) {
  //         echo "<option>Select Assignment</option>";
  //         foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
  //           ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           ->orderBy('assignment_name')->get() as $sub) {
  //           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         }
  //       } else {
  //         echo "<option>Select Assignment</option>";
  //         foreach (DB::table('assignmentbudgetings')
  //           ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //           ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //           ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //           ->where('assignmentbudgetings.client_id', $request->cid)
  //           ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //           ->orderBy('assignment_name')->get() as $sub) {
  //           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         }
  //       }
  //     }
  //     if (isset($request->assignment)) {

  //       if (auth()->user()->role_id == 11) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } elseif (auth()->user()->role_id == 13) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('teammembers')
  //           ->where('id', auth()->user()->teammember_id)
  //           ->select('teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } else {
  //         //die;
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       }

  //       //        dd($request->assignment);

  //       //  dd($request->assignment);


  //     }
  //   } else {
  //     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
  //   }
  // }

  //! old code 1
  // public function create(Request $request)
  // {
  //   // dd($request);
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  //   $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  //   if (auth()->user()->role_id == 11) {
  //     $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
  //   } elseif (auth()->user()->role_id == 13) {
  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   } else {
  //     $client = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //   }
  //   $assignment = Assignment::select('id', 'assignment_name')->get();
  //   //   dd($assignment);
  //   // shahid assi
  //   if ($request->ajax()) {
  //     // dd(auth()->user()->id);
  //     if (isset($request->cid)) {
  //       if (auth()->user()->role_id == 13) {
  //         echo "<option>Select Assignment</option>";
  //         foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
  //           ->where('created_by', auth()->user()->id)
  //           ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           ->orderBy('assignment_name')->get() as $sub) {
  //           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         }
  //       } else {
  //         echo "<option>Select Assignment</option>";
  //         foreach (DB::table('assignmentbudgetings')
  //           ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //           ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //           ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //           ->where('assignmentbudgetings.client_id', $request->cid)
  //           ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //           ->orderBy('assignment_name')->get() as $sub) {
  //           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         }
  //       }
  //     }
  //     if (isset($request->assignment)) {

  //       if (auth()->user()->role_id == 11) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } elseif (auth()->user()->role_id == 13) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('teammembers')
  //           ->where('id', auth()->user()->teammember_id)
  //           ->select('teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } else {
  //         //die;
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       }
  //     }
  //   } else {
  //     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
  //   }
  // }

  //! old code 2
  // public function create(Request $request)
  // {
  //   // dd($request);
  //   // rejected timesheet details
  //   $timesheetedit = DB::table('timesheetusers')
  //     ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
  //     ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     ->where('timesheetusers.timesheetid', 105419)
  //     ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
  //     ->get();
  //   // 105890
  //   // dd($timesheetedit);
  //   // client of particular partner
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  //   $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  //   if (auth()->user()->role_id == 11) {
  //     $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
  //   } elseif (auth()->user()->role_id == 13) {
  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   } else {
  //     $client = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //   }
  //   $assignment = Assignment::select('id', 'assignment_name')->get();
  //   //   dd($assignment);
  //   // shahid assi
  //   if ($request->ajax()) {
  //     // dd(auth()->user()->id);
  //     if (isset($request->cid)) {
  //       if (auth()->user()->role_id == 13) {
  //         echo "<option>Select Assignment</option>";
  //         foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
  //           ->where('created_by', auth()->user()->id)
  //           ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           ->orderBy('assignment_name')->get() as $sub) {
  //           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         }
  //       } else {
  //         echo "<option>Select Assignment</option>";
  //         foreach (DB::table('assignmentbudgetings')
  //           ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //           ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //           ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //           ->where('assignmentbudgetings.client_id', $request->cid)
  //           ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //           ->orderBy('assignment_name')->get() as $sub) {
  //           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         }
  //       }
  //     }
  //     if (isset($request->assignment)) {

  //       if (auth()->user()->role_id == 11) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } elseif (auth()->user()->role_id == 13) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('teammembers')
  //           ->where('id', auth()->user()->teammember_id)
  //           ->select('teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } else {
  //         //die;
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       }
  //     }
  //   } else {
  //     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
  //   }
  // }
  //! old code 21-12-23
  // public function create(Request $request)
  // {
  //   // dd(auth()->user()->teammember_id);
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  //   $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  //   if (auth()->user()->role_id == 11) {
  //     $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
  //   } elseif (auth()->user()->role_id == 13) {
  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   } else {
  //     $client = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //   }
  //   $assignment = Assignment::select('id', 'assignment_name')->get();
  //   // dd($assignment);
  //   if ($request->ajax()) {
  //     // dd(auth()->user()->teammember_id);
  //     if (isset($request->cid)) {
  //       if (auth()->user()->role_id == 13) {
  //         echo "<option>Select Assignment</option>";

  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
  //             ->where('created_by', auth()->user()->id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         }
  //       }
  //       // assreject
  //       else {
  //         echo "<option>Select Assignment</option>";
  //         foreach (DB::table('assignmentbudgetings')
  //           ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //           ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //           ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //           ->where('assignmentbudgetings.client_id', $request->cid)
  //           ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //           //  ->where('assignmentteammappings.status', '!=', 0)
  //           // ->whereNull('assignmentteammappings.status')
  //           ->where(function ($query) {
  //             $query->whereNull('assignmentteammappings.status')
  //               ->orWhere('assignmentteammappings.status', '=', 1);
  //           })
  //           ->orderBy('assignment_name')->get() as $sub) {
  //           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         }
  //       }
  //     }

  //     if (isset($request->assignment)) {
  //       // dd($request->assignment);
  //       if (auth()->user()->role_id == 11) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } elseif (auth()->user()->role_id == 13) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('teammembers')
  //           ->where('id', auth()->user()->teammember_id)
  //           ->select('teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } else {
  //         //die;
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       }
  //     }
  //   } else {
  //     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
  //   }
  // }
  //! new code 21-12-23
  public function create(Request $request)
  {
    // dd(auth()->user()->teammember_id);
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
    $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
    if (auth()->user()->role_id == 11) {
      $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
    } elseif (auth()->user()->role_id == 13) {
      $clientss = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();
      // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);
    } else {
      // dd(auth()->user()->teammember_id);
      $clientss = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);
    }
    $assignment = Assignment::select('id', 'assignment_name')->get();
    // dd($assignment);
    if ($request->ajax()) {
      // dd(auth()->user()->teammember_id);
      if (isset($request->cid)) {
        if (auth()->user()->role_id == 13) {
          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
              ->where('created_by', auth()->user()->id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        }
        // assreject
        else {
          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
              ->where('created_by', auth()->user()->id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }

          // echo "<option>Select Assignment</option>";
          // foreach (DB::table('assignmentbudgetings')
          //   ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
          //   ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
          //   ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
          //   ->where('assignmentbudgetings.client_id', $request->cid)
          //   ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          //   //  ->where('assignmentteammappings.status', '!=', 0)
          //   // ->whereNull('assignmentteammappings.status')
          //   ->where(function ($query) {
          //     $query->whereNull('assignmentteammappings.status')
          //       ->orWhere('assignmentteammappings.status', '=', 1);
          //   })
          //   ->orderBy('assignment_name')->get() as $sub) {
          //   echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
          // }

          //* i have removed above line 21-12-23 ko so may be occure any problem in future regarding inactive / active teammember from assignment          
          //* basically i have fixed hare sahil gupta (staff) ko off holiday nahi aa raha tha timesheet create me  if any problem in future then run old code 21-12-23
          //* end hare 


        }
      }

      if (isset($request->assignment)) {
        // dd($request->assignment);
        if (auth()->user()->role_id == 11) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('teammembers')
            ->where('id', auth()->user()->teammember_id)
            ->select('teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } else {
          //die;
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        }
      }
    } else {
      return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
    }
  }

  //* timesheet edit fubctionality
  // public function timesheetEdit(Request $request, $id)
  // {

  //   $timesheetedit = DB::table('timesheetusers')
  //     ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
  //     ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     ->where('timesheetusers.timesheetid', $id)
  //     ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
  //     ->get();
  //   // 105890
  //   // dd($timesheetedit);
  //   // client of particular partner
  //   if (auth()->user()->role_id == 13) {
  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()
  //       ->get();
  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()
  //       ->get();

  //     $client = $clientss->merge($clients);
  //   } else {
  //     $client = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //   }


  //   // return view('backEnd.timesheet.correction', compact('timesheetedit', 'client', 'assignment'));
  //   return view('backEnd.timesheet.correction', compact('timesheetedit', 'client'));
  // }

  //* timesheet edit fubctionality
  public function timesheetEdit(Request $request, $id)
  {
    $timesheetedit = DB::table('timesheetusers')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      // ->where('timesheetusers.timesheetid', 105419)
      ->where('timesheetusers.timesheetid', $id)
      ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
      ->get();
    // 105890
    // dd($timesheetedit);
    // client of particular partner
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
    $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
    if (auth()->user()->role_id == 11) {
      $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
    } elseif (auth()->user()->role_id == 13) {
      $clientss = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);
    } else {
      $client = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();
    }
    $assignment = Assignment::select('id', 'assignment_name')->get();
    //   dd($assignment);
    // shahid assi
    if ($request->ajax()) {
      // dd(auth()->user()->id);
      if (isset($request->cid)) {
        if (auth()->user()->role_id == 13) {
          echo "<option>Select Assignment</option>";
          foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
            ->where('created_by', auth()->user()->id)
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        } else {
          echo "<option>Select Assignment</option>";
          foreach (DB::table('assignmentbudgetings')
            ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->where('assignmentbudgetings.client_id', $request->cid)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        }
      }
      if (isset($request->assignment)) {

        if (auth()->user()->role_id == 11) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('teammembers')
            ->where('id', auth()->user()->teammember_id)
            ->select('teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } else {
          //die;
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        }
      }
    } else {
      return view('backEnd.timesheet.correction', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
    }
  }

  //* timesheet edit fubctionality
  public function timesheeteditstore(Request $request)
  {
    // dd($request);
    if (!is_numeric($request->assignment_id)) {
      $assignment = Assignmentmapping::where('assignmentgenerate_id', $request->assignment_id)
        ->select('assignment_id')
        ->get()
        ->toArray();
      $assignment_id = $assignment[0]['assignment_id'];
    } else {
      $assignment_id = $request->assignment_id;
    }
    try {
      DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
        'status'   =>   3,
        'client_id'   =>  $request->client_id,
        // 'assignment_id'   =>  $request->assignment_id,
        'assignment_id'   =>   $assignment_id,
        'partner'   =>  $request->partner,
        'workitem'   =>   $request->workitem,
        'createdby'   =>   $request->createdby,
        'location'   =>   $request->location,
        'hour'   =>   $request->hour,
      ]);

      if ($request->status == 2) {
        DB::table('timesheetupdatelogs')->insert([
          'timesheetusers_id'   =>  $request->timesheetusersid,
          'status'   =>   3,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
      $output = array('msg' => 'Updated Successfully');
      // return back()->with('statuss', $output);
      return redirect()->to('rejectedlist')->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
    //$id=77;
    // $client = Client::select('id', 'client_name')->get();
    // $time = DB::table('timesheets')->where('id', $id)->first();
    // $date = $time->date;
    // $assignment = Assignment::select('id', 'assignment_name')->get();
    // $timesheet = DB::table('timesheetusers')
    //   ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
    //   ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
    //   ->where('timesheetusers.timesheetid', $id)
    //   ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name')
    //   ->get();
    // //   dd($timesheet);
    // $count = count($timesheet = DB::table('timesheetusers')->where('timesheetusers.date', $date)->get());
    // //  dd( $count);
    // // $totalhour=$timesheet->totalhour;

    // $rcount = 5 - $count;

    // return view('backEnd.timesheet.edit', compact('id', 'timesheet', 'client', 'assignment', 'date', 'rcount', 'count'));
  }

  public function rejectedlist(Request $request)
  {
    // dd($request);
    // dd(auth()->user());
    if (auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        // ->where('timesheetusers.status', 2)
        ->whereIn('timesheetusers.status', [2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
      // dd($timesheetData);
    } else if (auth()->user()->role_id == 11) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // ->where('timesheetusers.createdby', $request->teamid)
        // ->where('timesheetusers.partner', $request->partnerid)
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        // ->whereIn('timesheetusers.status', [1, 2])
        // ->where('timesheetusers.date', '>=', $date->startdate)
        // ->where('timesheetusers.date', '<=', $date->enddate)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    } else {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->whereIn('timesheetusers.status', [2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
      // dd($timesheetData);
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
  }
  // all rejected timesheet on patner for team
  public function rejectedlistteam(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // ->where('timesheetusers.status', 2)
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    }
    // return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
    return view('backEnd.timesheet.rejectedlistteam', compact('timesheetData'));
  }
  public function rejectedtimesheetlog(Request $request)
  {
    if (auth()->user()->role_id == 11) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    }
    // elseif (auth()->user()->role_id == 13) {
    //   $timesheetData = DB::table('timesheetusers')
    //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    //     ->whereIn('timesheetusers.status', [2, 3])
    //     ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
    //     ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    // }
    return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
  }

  public function  timesheetreject($id)
  {
    // dd($id);
    try {
      DB::table('timesheetusers')->where('id', $id)->update([

        'status'   => 2,
        'rejectedby'   =>   auth()->user()->teammember_id,

      ]);
      // timesheet rejected mail
      $data = DB::table('teammembers')
        ->leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
        ->where('timesheetusers.id', $id)
        ->first();
      $emailData = [
        'emailid' => $data->emailid,
        'teammember_name' => $data->team_member,
      ];

      Mail::send('emails.timesheetrejected', $emailData, function ($msg) use ($emailData) {
        $msg->to([$emailData['emailid']]);
        $msg->subject('Timesheet rejected');
      });
      // timesheet rejected mail end hare


      $output = array('msg' => 'Rejected Successfully');
      return back()->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function timesheetajax()
  {
    if ($request->ajax()) {
      //  dd($request);
      if (isset($request->cid)) {
        echo "<option>Select Assignment</option>";
        foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
          ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
          ->orderBy('assignment_name')->get() as $sub) {
          echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
        }
      }
    }
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  //! old code
  // public function store(Request $request)
  // {

  //   // dd(auth()->user()->teammember_id);

  //   try {

  //     $data = $request->except(['_token', 'teammember_id', 'amount']);

  //     //	if ($request->date < '11-09-2023') {
  //     //dd('hi');
  //     // $output = array('msg' => 'Please fill timesheet from 11/09/2023, Monday onwards');
  //     //  return back()->with('success', $output);
  //     //   }

  //     //die;
  //     //? dd(date('w', strtotime($request->date))); // 4
  //     if (date('w', strtotime($request->date)) == 0) {
  //       $previousSaturday = date('Y-m-d', strtotime('-1 day', strtotime($request->date)));
  //       $previousSaturdayFilled = DB::table('timesheetusers')
  //         ->where('createdby', auth()->user()->teammember_id)
  //         ->where('date', $previousSaturday)
  //         ->where('status', 1)
  //         ->first();
  //       // dd('hi1', $previousSaturdayFilled);
  //       if ($previousSaturdayFilled != null) {
  //         $output = array('msg' => 'You already submitted for this week');
  //         return back()->with('success', $output);
  //       }
  //     }

  //     $hours = $request->input('totalhour');
  //     if (!is_numeric($hours) || $hours > 12) {
  //       $output = array('msg' => 'The total hours cannot be greater than 12');
  //       return back()->with('success', $output);
  //     }


  //     $previouschck = DB::table('timesheetusers')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->where('date', date('Y-m-d', strtotime($request->date)))
  //       ->where('status', 1)
  //       ->first();

  //     dd('hi2', $previouschck);
  //     if ($previouschck != null) {
  //       //dd('hi');
  //       $output = array('msg' => 'You already submitted for this week');
  //       return back()->with('success', $output);
  //     }

  //     $previoussavechck = DB::table('timesheetusers')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->where('date', date('Y-m-d', strtotime($request->date)))
  //       ->where('status', 0)
  //       ->first();

  //     dd('hi3', $previoussavechck);
  //     if ($previoussavechck != null) {
  //       //dd('hi');
  //       $output = array('msg' => 'You already submitted for this date');
  //       return back()->with('success', $output);
  //     }



  //     $currentDate = Carbon::now()->format('d-m-Y');
  //     //dd($currentHour);
  //     // if ($currentDate == $request->date && Carbon::now()->hour < 18) {
  //     //   //dd('hi');
  //     //   $output = array('msg' => 'You can only fill today timesheet after 6:00 pm');
  //     //   return back()->with('success', $output);
  //     // }

  //     $leaves = DB::table('applyleaves')
  //       ->where('applyleaves.createdby', auth()->user()->teammember_id)
  //       ->where('status', '!=', 2)
  //       ->select('applyleaves.from', 'applyleaves.to')
  //       ->get();

  //     foreach ($leaves as $leave) {
  //       //Convert each data from table to Y-m-d format to compare
  //       $days = CarbonPeriod::create(
  //         date('Y-m-d', strtotime($leave->from)),
  //         date('Y-m-d', strtotime($leave->to))
  //       );

  //       foreach ($days as $day) {
  //         $leavess[] = $day->format('Y-m-d');
  //       }
  //     }
  //     $currentday = date('Y-m-d', strtotime($request->date));
  //     // $ifcount=0;
  //     //  $elsecount=0;

  //     if (count($leaves) != 0) {
  //       //dd('if');
  //       foreach ($leavess as $leave) {
  //         // echo"<pre>";
  //         //  print_r($leave);

  //         if ($leave == $currentday) {
  //           //dd('if');
  //           // $ifcount=$ifcount+1;
  //           $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
  //           return redirect('timesheet')->with('statuss', $output);
  //         }
  //       }
  //     }
  //     $id = DB::table('timesheets')->insertGetId(
  //       [
  //         'created_by' => auth()->user()->teammember_id,
  //         'month'     =>    date('F', strtotime($request->date)),
  //         'date'     =>    date('Y-m-d', strtotime($request->date)),
  //         'created_at'          =>     date('Y-m-d H:i:s'),
  //       ]
  //     );
  //     // dd('else');
  //     $count = count($request->assignment_id);
  //     // dd($count);
  //     for ($i = 0; $i < $count; $i++) {
  //       //dd($request->workitem[$i]);
  //       $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

  //       $a = DB::table('timesheetusers')->insert([
  //         'date'     =>     $request->date,
  //         'client_id'     =>     $request->client_id[$i],
  //         'workitem'     =>     $request->workitem[$i],
  //         'location'     =>     $request->location[$i],
  //         //   'billable_status'     =>     $request->billable_status[$i],
  //         'timesheetid'     =>     $id,
  //         'date'     =>     date('Y-m-d', strtotime($request->date)),
  //         'hour'     =>     $request->hour[$i],
  //         'totalhour' =>      $request->totalhour,
  //         'assignment_id'     =>     $assignment->assignment_id,
  //         'partner'     =>     $request->partner[$i],
  //         'createdby' => auth()->user()->teammember_id,
  //         'created_at'          =>     date('Y-m-d H:i:s'),
  //         'updated_at'              =>    date('Y-m-d H:i:s'),
  //       ]);
  //     }


  //     //Attendance code

  //     $hdatess = date('Y-m-d', strtotime($request->date));
  //     $day =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('d');      //
  //     $month =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('F');   //
  //     $currentDate = new DateTime();
  //     $currentMonth = $currentDate->format('F');
  //     //dd($month);
  //     //   if ($currentDate->format('j') > 25) {
  //     //     $currentDate->modify('-1 month');
  //     //     $currentMonth = $currentDate->format('F');
  //     // }



  //     $dates = [
  //       '26' => 'twentysix',
  //       '27' => 'twentyseven',
  //       '28' => 'twentyeight',
  //       '29' => 'twentynine',
  //       '30' => 'thirty',
  //       '31' => 'thirtyone',
  //       '01' => 'one',
  //       '02' => 'two',
  //       '03' => 'three',
  //       '04' => 'four',
  //       '05' => 'five',
  //       '06' => 'six',
  //       '07' => 'seven',
  //       '08' => 'eight',
  //       '09' => 'nine',
  //       '10' => 'ten',
  //       '11' => 'eleven',
  //       '12' => 'twelve',
  //       '13' => 'thirteen',
  //       '14' => 'fourteen',
  //       '15' => 'fifteen',
  //       '16' => 'sixteen',
  //       '17' => 'seventeen',
  //       '18' => 'eighteen',
  //       '19' => 'ninghteen',
  //       '20' => 'twenty',
  //       '21' => 'twentyone',
  //       '22' => 'twentytwo',
  //       '23' => 'twentythree',
  //       '24' => 'twentyfour',
  //       '25' => 'twentyfive',
  //     ];



  //     if ($month != $currentMonth && $day > 25) {
  //       $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
  //       $dateTime->modify('+1 month');
  //       $month = $dateTime->format('F');
  //     }
  //     if ($month != $currentMonth && $day < 25) {
  //       $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
  //       $month = $dateTime->format('F');
  //     }
  //     if ($month == $currentMonth && $day > 25) {

  //       $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
  //       $dateTime->modify('+1 month');
  //       $month = $dateTime->format('F');
  //     }

  //     //dd($month);


  //     $column = $dates[$day];

  //     $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
  //       ->where('month', $month)->first();

  //     if ($attendances ==  null) {
  //       $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

  //       $a = DB::table('attendances')->insert([
  //         'employee_name'         =>     auth()->user()->teammember_id,
  //         'month'         =>    $month,
  //         'dateofjoining' =>   $teammember->joining_date,
  //         'created_at'          =>     date('Y-m-d H:i:s'),
  //         //   'exam_leave'      =>$value->date_total,
  //       ]);
  //       //dd($a);
  //     }


  //     //   dd($noofdaysaspertimesheet);

  //     $updatedtotalhour = $request->totalhour;
  //     if ($attendances != null && property_exists($attendances, $column)) {
  //       if ($attendances->$column != "LWP") {
  //         $updatedtotalhour = $request->totalhour + $attendances->$column;
  //       }
  //     }
  //     DB::table('attendances')
  //       ->where('employee_name', auth()->user()->teammember_id)
  //       ->where('month', $month)
  //       ->update([$column => $updatedtotalhour]);


  //     //end attendance





  //     $output = array('msg' => 'Create Successfully');
  //     return redirect('timesheet')->with('success', $output);
  //   } catch (Exception $e) {
  //     DB::rollBack();
  //     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
  //     report($e);
  //     $output = array('msg' => $e->getMessage());
  //     return back()->withErrors($output)->withInput();
  //   }
  // }
  //! working on new joining teammember
  public function store(Request $request)
  {
    try {
      $Newteammeber = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->first();

      $Newteammeberjoining_date = DB::table('teammembers')
        ->where('id', auth()->user()->teammember_id)
        ->select('joining_date')
        ->first();
      $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));

      // if user not created any timesheet in that case ,it means new teammeber 
      if ($Newteammeber == null) {
        // Get previuse sunday from joining date
        $joining_timestamp = strtotime($joining_date);
        $day_of_week = date('w', $joining_timestamp);
        $days_to_subtract = $day_of_week;
        $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

        $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
        // Get all dates beetween two dates 
        $startDate = Carbon::parse($previous_sunday_date);
        $endDate = Carbon::parse($joining_date);
        $period = CarbonPeriod::create($startDate, $endDate);
        // store all date in $result vairable
        $result = [];
        foreach ($period as $key => $date) {
          if ($key !== 0 && $key !== count($period) - 1) {
            $result[] = $date->toDateString();
          }
        }
        // return $result;
        // dd('yes', $result);
        foreach ($result as $date) {
          // $a = DB::table('timesheetusers')->insert([
          //   'date'        => date('Y-m-d', strtotime($date)),
          //   'createdby'   => auth()->user()->teammember_id,
          //   'created_at'  => date('Y-m-d H:i:s'),
          //   'updated_at'  => date('Y-m-d H:i:s'),
          // ]);

          $id = DB::table('timesheets')->insertGetId(
            [
              'created_by' => auth()->user()->teammember_id,
              'month'     =>   date('F', strtotime($date)),
              'date'     =>    date('Y-m-d', strtotime($date)),
              'created_at'          =>     date('Y-m-d H:i:s'),
            ]
          );
          DB::table('timesheetusers')->insert([
            'date'     =>   date('Y-m-d', strtotime($date)),
            'client_id'     =>     29,
            'workitem'     =>     'NA',
            'location'     =>     'NA',
            //   'billable_status'     =>     $request->billable_status[$i],
            'timesheetid'     =>     $id,
            'date'     =>     date('Y-m-d', strtotime($date)),
            'hour'     =>     0,
            'totalhour' =>      0,
            'assignment_id'     =>     213,
            'partner'     =>     887,
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);
        }
      }


      $requestDate = Carbon::parse($request->date);
      $joiningDate = Carbon::parse($joining_date);

      if ($requestDate >= $joiningDate) {
        $data = $request->except(['_token', 'teammember_id', 'amount']);
        //	if ($request->date < '11-09-2023') {
        //dd('hi');
        // $output = array('msg' => 'Please fill timesheet from 11/09/2023, Monday onwards');
        //  return back()->with('success', $output);
        //   }

        //die;
        //? dd(date('w', strtotime($request->date))); // 4
        if (date('w', strtotime($request->date)) == 0) {
          $previousSaturday = date('Y-m-d', strtotime('-1 day', strtotime($request->date)));
          $previousSaturdayFilled = DB::table('timesheetusers')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('date', $previousSaturday)
            ->where('status', 1)
            ->first();
          // dd('hi1', $previousSaturdayFilled);
          if ($previousSaturdayFilled != null) {
            $output = array('msg' => 'You already submitted for this week');
            return back()->with('success', $output);
          }
        }

        // check hour
        $hours = $request->input('totalhour');
        if (!is_numeric($hours) || $hours > 12) {
          $output = array('msg' => 'The total hours cannot be greater than 12');
          return back()->with('success', $output);
        }
        // dd(auth()->user()->teammember_id);
        //? dd(date('Y-m-d', strtotime($request->date))); "2023-11-30"
        $previouschck = DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('date', date('Y-m-d', strtotime($request->date)))
          ->where('status', 1)
          ->first();

        if ($previouschck != null) {
          //dd('hi');
          $output = array('msg' => 'You already submitted for this week');
          return back()->with('success', $output);
        }

        $previoussavechck = DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('date', date('Y-m-d', strtotime($request->date)))
          ->where('status', 0)
          ->first();

        if ($previoussavechck != null) {
          //dd('hi');
          $output = array('msg' => 'You already submitted for this date');
          return back()->with('success', $output);
        }



        $currentDate = Carbon::now()->format('d-m-Y');
        //dd($currentHour);

        // if ($currentDate == $request->date && Carbon::now()->hour < 18) {
        //   //dd('hi');
        //   $output = array('msg' => 'You can only fill today timesheet after 6:00 pm');
        //   return back()->with('success', $output);
        // }

        $leaves = DB::table('applyleaves')
          ->where('applyleaves.createdby', auth()->user()->teammember_id)
          ->where('status', '!=', 2)
          ->select('applyleaves.from', 'applyleaves.to')
          ->get();
        // dd('hi 1', $leaves);
        foreach ($leaves as $leave) {
          //Convert each data from table to Y-m-d format to compare
          $days = CarbonPeriod::create(
            date('Y-m-d', strtotime($leave->from)),
            date('Y-m-d', strtotime($leave->to))
          );

          foreach ($days as $day) {
            $leavess[] = $day->format('Y-m-d');
          }
        }
        // $currentday = date('Y-m-d', strtotime($request->date));// "2023-11-30"
        $currentday = date('Y-m-d', strtotime($request->date));
        // dd('hi 2', $currentday);
        // $ifcount=0;
        //  $elsecount=0;

        if (count($leaves) != 0) {
          //dd('if');
          foreach ($leavess as $leave) {
            // echo"<pre>";
            //  print_r($leave);

            if ($leave == $currentday) {
              //dd('if');
              // $ifcount=$ifcount+1;
              $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
              return redirect('timesheet')->with('statuss', $output);
            }
          }
        }
        // insert data in timesheet from request and get id 
        $id = DB::table('timesheets')->insertGetId(
          [
            'created_by' => auth()->user()->teammember_id,
            'month'     =>    date('F', strtotime($request->date)),
            'date'     =>    date('Y-m-d', strtotime($request->date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
          ]
        );

        $count = count($request->assignment_id);
        // dd('hi 3', $count);
        for ($i = 0; $i < $count; $i++) {
          //dd($request->workitem[$i]);
          $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

          $a = DB::table('timesheetusers')->insert([
            'date'     =>     $request->date,
            'client_id'     =>     $request->client_id[$i],
            'workitem'     =>     $request->workitem[$i],
            'location'     =>     $request->location[$i],
            //   'billable_status'     =>     $request->billable_status[$i],
            'timesheetid'     =>     $id,
            'date'     =>     date('Y-m-d', strtotime($request->date)),
            'hour'     =>     $request->hour[$i],
            'totalhour' =>      $request->totalhour,
            'assignment_id'     =>     $assignment->assignment_id,
            'partner'     =>     $request->partner[$i],
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);
        }
      } else {
        // dd(auth()->user()->teammember_id);
        $output = array('msg' => 'You can not fill timesheet before :' . $joining_date);
        return redirect('timesheet')->with('success', $output);
      }







      //Attendance code

      $hdatess = date('Y-m-d', strtotime($request->date));
      $day =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('d');      //
      $month =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('F');   //
      $currentDate = new DateTime();
      $currentMonth = $currentDate->format('F');
      //dd($month);
      //   if ($currentDate->format('j') > 25) {
      //     $currentDate->modify('-1 month');
      //     $currentMonth = $currentDate->format('F');
      // }



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
        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $dateTime->modify('+1 month');
        $month = $dateTime->format('F');
      }
      if ($month != $currentMonth && $day < 25) {
        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $month = $dateTime->format('F');
      }
      if ($month == $currentMonth && $day > 25) {

        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $dateTime->modify('+1 month');
        $month = $dateTime->format('F');
      }

      //dd($month);


      $column = $dates[$day];

      $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
        ->where('month', $month)->first();

      if ($attendances ==  null) {
        $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

        $a = DB::table('attendances')->insert([
          'employee_name'         =>     auth()->user()->teammember_id,
          'month'         =>    $month,
          'dateofjoining' =>   $teammember->joining_date,
          'created_at'          =>     date('Y-m-d H:i:s'),
          //   'exam_leave'      =>$value->date_total,
        ]);
        //dd($a);
      }


      //   dd($noofdaysaspertimesheet);

      $updatedtotalhour = $request->totalhour;
      if ($attendances != null && property_exists($attendances, $column)) {
        if ($attendances->$column != "LWP") {
          $updatedtotalhour = $request->totalhour + $attendances->$column;
        }
      }
      DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->where('month', $month)
        ->update([$column => $updatedtotalhour]);


      //end attendance


      $output = array('msg' => 'Create Successfully');
      return redirect('timesheet')->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function timesheetUpload(Request $request)
  {
    $request->validate([
      'file' => 'required'
    ]);

    try {
      $file = $request->file;
      //  dd($file);
      $data = $request->except(['_token']);
      $dataa = Excel::toArray(new Timesheetimport, $file);
      //     dd($dataa);
      foreach ($dataa[0] as $key => $value) {
        //  $informationresource   = Informationresource::where('question',$value['question'])->pluck('question')->first();

        //    if($informationresource == null){
        $db['clientname'] = $request->clientname;
        $db['assignmentname'] = $request->assignmentname;
        $db['workitem'] = $request->workitem;
        //  $db['billable_status'] = $request->billable_status;
        $db['hour'] = $request->hour;
        //   dd($request->clientname);
        if ($request->clientname != NULL) {
          $client_id   = clients::where('client_name', $value['clientname'])->pluck('id')->first();
          //    dd($client_id);
          if ($assignmentname != NULL) {
            $assignment_id   = assignments::where('assignment_name', $value['assignmentname'])->pluck('id')->first();
          }
        }


        //  'createdby' => auth()->user()->teammember_id,
        //     Timesheet::Create($db);

        //       }

      }
      //dd($dataa);
      $output = array('msg' => 'Excel file upload Successfully');
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
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */

  public function edit($id)
  {
    //dd($date);
    //$id=77;
    $client = Client::select('id', 'client_name')->get();
    $time = DB::table('timesheets')->where('id', $id)->first();
    $date = $time->date;
    $assignment = Assignment::select('id', 'assignment_name')->get();
    $timesheet = DB::table('timesheetusers')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->where('timesheetusers.timesheetid', $id)
      ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name')
      ->get();
    //   dd($timesheet);
    $count = count($timesheet = DB::table('timesheetusers')->where('timesheetusers.date', $date)->get());
    //  dd( $count);
    // $totalhour=$timesheet->totalhour;

    $rcount = 5 - $count;

    return view('backEnd.timesheet.edit', compact('id', 'timesheet', 'client', 'assignment', 'date', 'rcount', 'count'));
  }
  public function view($id)
  {
    //  dd($id);
    $timesheet = timesheet::where('id', $id)->first();
    return view('backEnd.timesheet.view', compact('id', 'timesheet'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    try {
      $data = $request->except(['_token']);
      $count = count($request->assignment_id);
      // dd($count);
      $timesheet = DB::table('timesheets')->where('date', $request->date)->delete();

      for ($i = 0; $i < $count; $i++) {
        DB::table('timesheets')->insert([
          'client_id'     =>     $request->client_id[$i],
          'workitem'     =>     $request->workitem[$i],
          //    'billable_status'     =>     $request->billable_status[$i],
          'hour'     =>     $request->hour[$i],
          'assignment_id'     =>     $request->assignment_id[$i],
          'createdby' => auth()->user()->teammember_id,
          'updatedby' => auth()->user()->teammember_id,
          'date'      => $request->date,
          'totalhour' => $request->totalhour,
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);
      }

      $output = array('msg' => 'Updated Successfully');
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
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    // dd($id);
    try {
      $getid =  DB::table('timesheetusers')->where('id', $id)->first();
      // dd($getid);
      DB::table('timesheets')->where('id', $getid->timesheetid)->delete();
      DB::table('timesheetusers')->where('id', $id)->delete();
      $output = array('msg' => 'Deleted Successfully');
      return back()->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  //! old code before timesheet multiple request
  // public function timesheetrequestStore(Request $request)
  // {
  //   try {
  //     $data = $request->except(['_token']);
  //     // dd($data);

  //     $id = DB::table('timesheetrequests')->insertGetId([
  //       'partner'     =>     $request->partner,
  //       'reason'     =>     $request->reason,
  //       'status'     =>     0,
  //       'createdby' => auth()->user()->teammember_id,
  //       'created_at'          =>     date('Y-m-d H:i:s'),
  //       'updated_at'              =>    date('Y-m-d H:i:s'),
  //     ]);
  //     // dd($id); 74

  //     //     $travel = Assetprocurement::where('id', $id)->first();
  //     // timesheet request mail to admin
  //     $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
  //     $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

  //     $data = array(
  //       'teammember' => $name ?? '',
  //       'email' => $teammembermail ?? '',
  //       'id' => $id ?? '',
  //     );
  //     Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
  //       $msg->to($data['email']);
  //       $msg->subject('Timesheet Submission Request');
  //     });
  //     // timesheet request mail to admin
  //     $output = array('msg' => 'Request Successfully');
  //     return back()->with('success', $output);
  //   } catch (Exception $e) {
  //     DB::rollBack();
  //     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
  //     report($e);
  //     $output = array('msg' => $e->getMessage());
  //     return back()->withErrors($output)->withInput();
  //   }
  // }

  // // Store timesheet request. timereq
  // public function timesheetrequestStore(Request $request)
  // {
  //   try {
  //     $data = $request->except(['_token']);
  //     // dd($data);

  //     $latestrequest = DB::table('timesheetrequests')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->latest()
  //       ->select('created_at')
  //       ->first();
  //     // dd($latestrequest);
  //     $latestrequesthour = Carbon::parse($latestrequest->created_at);
  //     $currentDateTime = Carbon::now();
  //     // Check if the difference is more than 24 hours
  //     if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
  //       $id = DB::table('timesheetrequests')->insertGetId([
  //         'partner'     =>     $request->partner,
  //         'reason'     =>     $request->reason,
  //         'status'     =>     0,
  //         'createdby' => auth()->user()->teammember_id,
  //         'created_at'          =>     date('Y-m-d H:i:s'),
  //         'updated_at'              =>    date('Y-m-d H:i:s'),
  //       ]);

  //       // timesheet request mail to admin
  //       $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
  //       $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

  //       $data = array(
  //         'teammember' => $name ?? '',
  //         'email' => $teammembermail ?? '',
  //         'id' => $id ?? '',
  //       );
  //       Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
  //         $msg->to($data['email']);
  //         $msg->subject('Timesheet Submission Request');
  //       });
  //       // timesheet request mail to admin
  //       $output = array('msg' => 'Request Successfully');
  //       return back()->with('success', $output);
  //     } else {
  //       $output = array('msg' => 'You can submit new timesheet request after 24 hour');
  //       return back()->with('statuss', $output);
  //     }
  //   } catch (Exception $e) {
  //     DB::rollBack();
  //     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
  //     report($e);
  //     $output = array('msg' => $e->getMessage());
  //     return back()->withErrors($output)->withInput();
  //   }
  // }

  // Store timesheet request. timereq 2
  public function timesheetrequestStore(Request $request)
  {
    try {
      $data = $request->except(['_token']);
      // dd($data);

      $latestrequest = DB::table('timesheetrequests')
        ->where('createdby', auth()->user()->teammember_id)
        ->latest()
        ->select('created_at', 'status')
        ->first();
      // dd($latestrequest);

      if ($latestrequest != null && $latestrequest->status != 2) {
        $latestrequesthour = Carbon::parse($latestrequest->created_at);
        // dd($latestrequest->created_at);
        $currentDateTime = Carbon::now();
        // Check if the difference is more than 24 hours
        if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
          $id = DB::table('timesheetrequests')->insertGetId([
            'partner'     =>     $request->partner,
            'reason'     =>     $request->reason,
            'status'     =>     0,
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);

          // timesheet request mail to admin
          $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
          $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

          $data = array(
            'teammember' => $name ?? '',
            'email' => $teammembermail ?? '',
            'id' => $id ?? '',
          );
          Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
            $msg->to($data['email']);
            $msg->subject('Timesheet Submission Request');
          });
          // timesheet request mail to admin
          $output = array('msg' => 'Request Successfully');
          return back()->with('success', $output);
        } else {
          $output = array('msg' => 'You can submit new timesheet request after 24 hour from ' . date('h-m-s', strtotime($latestrequest->created_at)));
          return back()->with('statuss', $output);
        }
      } else {
        $id = DB::table('timesheetrequests')->insertGetId([
          'partner'     =>     $request->partner,
          'reason'     =>     $request->reason,
          'status'     =>     0,
          'createdby' => auth()->user()->teammember_id,
          'created_at'          =>     date('Y-m-d H:i:s'),
          'updated_at'              =>    date('Y-m-d H:i:s'),
        ]);

        // timesheet request mail to admin
        $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
        $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

        $data = array(
          'teammember' => $name ?? '',
          'email' => $teammembermail ?? '',
          'id' => $id ?? '',
        );
        Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
          $msg->to($data['email']);
          $msg->subject('Timesheet Submission Request');
        });
        // timesheet request mail to admin
        $output = array('msg' => 'Request Successfully');
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

  public function timesheetrequestlist()
  {
    $timesheetrequestlist = DB::table('timesheetrequests')
      ->leftjoin('timesheetusers', 'clients.client_id', 'timesheetrequests.id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
      ->leftjoin('teammembers as team', 'team.id', 'timesheetrequests.partner')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.createdby')
      ->where('timesheetrequests.createdby', auth()->user()->teammember_id)
      ->where('timesheetrequests.partner', auth()->user()->teammember_id)
      ->select('timesheetrequests.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
    // dd($timesheetData);

    return view('backEnd.timesheet.timesheetrequest', compact('timesheetrequestlist'));
  }


  //Report

  public function Reportsection(Request $request)
  {

    $employeename = Teammember::where('role_id', '!=', 11)->where('status', 1)->with('title', 'role')->get();
    $client = Client::select('id', 'client_name')->get();
    $assignment = Assignment::select('id', 'assignment_name')->get();
    $partner = Teammember::where('role_id', '=', 13)->where('status', 1)->with('title', 'role')->get();

    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    //dd($assignment);
    if ($request->ajax()) {
      //   dd($request);
      if (isset($request->cid)) {
        $clientdata = explode(",", $request->cid);
        echo "<option value=''>Select Assignment</option>";
        foreach (DB::table('timesheetusers')->whereIn('client_id', $clientdata)
          ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->orderBy('assignment_name')->distinct()->get(['assignments.id', 'assignments.assignment_name']) as $sub) {
          echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
        }
      }

      if (isset($request->clientid)) {
        $clientdata = explode(",", $request->clientid);
        echo "<option value=''>Select Employee</option>";
        foreach (DB::table('timesheetusers')->whereIn('client_id', $clientdata)
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->orderBy('team_member')->distinct()->get(['teammembers.id', 'teammembers.team_member']) as $sub) {
          echo "<option value='" . $sub->id . "'>" . $sub->team_member . "</option>";
        }
      }

      if (isset($request->ass_id)) {
        //dd($request->ass_id);;
        $ass_data = explode(",", $request->ass_id);
        //dd($ass_data);


        echo "<option value=''>Select Partner</option>";
        foreach (DB::table('teammembers')
          ->leftjoin('timesheetusers', 'timesheetusers.partner', 'teammembers.id')
          ->whereIn('timesheetusers.assignment_id', $ass_data)
          ->distinct()->get(['teammembers.id', 'teammembers.team_member']) as $subs) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
        //   die;
      }
    } else {
      return view('backEnd.timesheet.reportsection', compact('employeename', 'client', 'assignment', 'partner', 'years'));
    }
  }

  public function filtersection(Request $request)
  {
    //dd($request);
    if ($request->ajax()) {
      $clients = collect(is_array($request->clientid) ? $request->clientid : explode(',', $request->clientid))->filter();
      $employeeIds = collect(is_array($request->employeeid) ? $request->employeeid : explode(',', $request->employeeid))->filter();
      $assignmentIds = collect(is_array($request->assignmentid) ? $request->assignmentid : explode(',', $request->assignmentid))->filter();
      $partners = collect(is_array($request->partnerid) ? $request->partnerid : explode(',', $request->partnerid))->filter();
      //$dateRange = collect(is_array($request->daterange) ? $request->daterange : explode(' - ', $request->daterange))->filter();
      // $dateRange = collect(explode(' - ', $request->daterange))->filter();
      //[$startDate, $endDate] = $dateRange->map(fn ($date) => Carbon::parse($date));

      $date = explode(" - ", $request->daterange);
      // dd($date);
      $start = Carbon::parse($date[0]);
      $end = Carbon::parse($date[1]);

      $now = Carbon::now();
      $noww = Carbon::parse($now);
      //dd($start);
      if ($start == $end) {
        $daterange = null;
      } else {
        $daterange = 1;
      }
      /*
$financial_year = $request->yearly;


		
		
$quarter = $request->quarter; // Update with the desired quarter (q1, q2, q3, or q4)

$Qstart = '';
$Qend = '';
//dd($quarter);
if ($quarter == 'Q1') {
	
    $Qstart = $financial_year .'-05-01';
    $Qend = $financial_year .'-06-30';
} elseif ($quarter == 'Q2') {
	//dd('hi');
    $Qstart = $financial_year .'-07-01';
	//dd($Qstart);
    $Qend = $financial_year . '-09-30';
} elseif ($quarter == 'Q3') {
    $Qstart = $financial_year . '-10-01';
    $Qend = ($financial_year + 1) . '-01-01';
} elseif ($quarter == 'Q4') {
    $Qstart = ($financial_year + 1) . '-01-01';
    $Qend = $financial_year . '-03-31';
}
*/



      //	dd($Qstart);

      $query1 = $request->workitem;
      $query1 = str_replace(' ', '%', $query1);

      if ($request->month == 0) {
        $timesheetData = Timesheetusers::join('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
          ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->with(['client', 'assignment', 'createdBy', 'partner'])
          ->when($clients->isNotEmpty(), fn ($query) => $query->whereIn('client_id', $clients))
          ->when($employeeIds->isNotEmpty(), fn ($query) => $query->whereIn('timesheetusers.createdby', $employeeIds))
          ->when($assignmentIds->isNotEmpty(), fn ($query) => $query->whereIn('assignment_id', $assignmentIds))
          ->when($partners->isNotEmpty(), fn ($query) => $query->whereIn('partner', $partners))
          //  ->when($financial_year !='2025', fn ($query) => $query->whereYear('date', $financial_year))

          ->when($daterange == 1, function ($query) use ($start, $end) {
            $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
              ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
          })
          //		   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
          //  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
          //->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
          //   ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
          //  ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
          //	})

          ->when($request->billableid, fn ($query) => $query->where('billable_status', $request->billableid))
          ->when($request->month != 0, fn ($query) => $query->whereMonth('timesheetusers.date', $request->month))
          ->when($query1, fn ($query) => $query->where('workitem', 'like', "%$query1%"))
          ->where('teammembers.status', '!=', 0)
          ->select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as 				partnername')
          ->get();
      } else {
        $timesheetData = Timesheetusers::join('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
          ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->with(['client', 'assignment', 'createdBy', 'partner'])
          ->when($clients->isNotEmpty(), fn ($query) => $query->whereIn('client_id', $clients))
          ->when($employeeIds->isNotEmpty(), fn ($query) => $query->whereIn('timesheetusers.createdby', $employeeIds))
          ->when($assignmentIds->isNotEmpty(), fn ($query) => $query->whereIn('assignment_id', $assignmentIds))
          ->when($partners->isNotEmpty(), fn ($query) => $query->whereIn('partner', $partners))

          //		->when($request->yearly !=2025, fn ($query) => $query->whereYear('timesheetusers.date', $request->yearly))

          ->when($daterange == 1, function ($query) use ($start, $end) {
            $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
              ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
          })
          //			   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
          //	  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
          //     ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
          //    ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
          //    ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
          //	})

          // ->when($startDate && $endDate, fn ($query) => $query->whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate))
          ->when($request->billableid, fn ($query) => $query->where('billable_status', $request->billableid))
          ->when($request->month, fn ($query) => $query->whereMonth('timesheetusers.date', $request->month))
          ->when($query1, fn ($query) => $query->where('workitem', 'like', "%$query1%"))
          ->where('teammembers.status', '!=', 0)
          ->select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as partnername')
          ->get();
      }

      return response()->json($timesheetData);
    }
  }
}
