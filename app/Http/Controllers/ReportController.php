<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function assignment_report()
  {
    if (auth()->user()->role_id == 11) {
      $assignmentmappingData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->select(
      'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )->get();
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData'));
    } elseif (auth()->user()->role_id == 13) {
      $assignmentmappingData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )->get();
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData'));
    }
    //     else {
    //           $clientid = $request->clientid;
    //      $assignmentmappingData=  DB::table('assignmentmappings')
    //      ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
    //      ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
    //      ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
    //   ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
    //   ->where('clients.id',$request->clientid)
    //   ->where('assignmentmappings.year',$request->year)
    //   ->where('assignmentteammappings.teammember_id',auth()->user()->teammember_id)
    //    ->select('assignmentmappings.*','assignmentbudgetings.duedate','assignmentbudgetings.assignmentname',
    //      'assignments.assignment_name','clients.client_name')->distinct()->get();
    //      return view('backEnd.assignmentmapping.yearwise',compact('assignmentmappingData','clientid'));
    //     }

  }
}
