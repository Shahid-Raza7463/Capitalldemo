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
  //! old code 21-12-23
  // public function assignment_report()
  // {
  //   if (auth()->user()->role_id == 11) {
  //     $assignmentmappingData =  DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //       ->select(
  //         'assignmentmappings.*',
  //         'assignmentbudgetings.duedate',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentbudgetings.status',
  //         'assignments.assignment_name',
  //         'clients.client_name'
  //       )->get();
  //     return view('backEnd.report.assignmentreport', compact('assignmentmappingData'));
  //   } elseif (auth()->user()->role_id == 13) {

  //     $assignmentmappingData =  DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select(
  //         'assignmentmappings.*',
  //         'assignmentbudgetings.duedate',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentbudgetings.status',
  //         'assignments.assignment_name',
  //         'clients.client_name'
  //       )->get();

  //     // dd($assignmentmappingData);
  //     return view('backEnd.report.assignmentreport', compact('assignmentmappingData'));
  //   }
  //   //     else {
  //   //           $clientid = $request->clientid;
  //   //      $assignmentmappingData=  DB::table('assignmentmappings')
  //   //      ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
  //   //      ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
  //   //      ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
  //   //   ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
  //   //   ->where('clients.id',$request->clientid)
  //   //   ->where('assignmentmappings.year',$request->year)
  //   //   ->where('assignmentteammappings.teammember_id',auth()->user()->teammember_id)
  //   //    ->select('assignmentmappings.*','assignmentbudgetings.duedate','assignmentbudgetings.assignmentname',
  //   //      'assignments.assignment_name','clients.client_name')->distinct()->get();
  //   //      return view('backEnd.assignmentmapping.yearwise',compact('assignmentmappingData','clientid'));
  //   //     }

  // }

  public function assignment_report()
  {
    if (auth()->user()->role_id == 11) {
      $assignmentmappingData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )->get();
      $assignmentmappingcloseData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )->get();
      // dd($assignmentmappingData);
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    } elseif (auth()->user()->role_id == 13) {

      $assignmentmappingDataleadpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )
        ->get();

      $assignmentmappingDataotherpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )
        ->get();

      $assignmentmappingData = $assignmentmappingDataotherpartner->merge($assignmentmappingDataleadpartner);

      //  dd($assignmentmappingData);
      $assignmentmappingDataleadpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )->get();

      $assignmentmappingDataotherpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )->get();

      $assignmentmappingcloseData = $assignmentmappingDataotherpartner->merge($assignmentmappingDataleadpartner);

      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    } else {
      $assignmentmappingData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        ->where('assignmentbudgetings.status', '1')
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )->get();

      // dd($assignmentmappingData);

      $assignmentmappingcloseData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name'
        )->get();

      // dd($assignmentmappingData);
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    }
  }
}
