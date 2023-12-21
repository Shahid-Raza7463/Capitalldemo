<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Mail;
use DB;

class AssignmentController extends Controller
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
  //! o;d code before assignment open otp
  // public function assignmentotp(Request $request)
  // {
  //   //  dd($request->id); die;
  //   if ($request->ajax()) {
  //     if (isset($request->id)) {
  //       $assignment = DB::table('assignmentmappings')
  //         ->where('assignmentgenerate_id', $request->id)
  //         ->first();

  //       //  dd($assignment);


  //       $teammember = DB::table('teammembers')
  //         ->where('id', $assignment->leadpartner)
  //         //   ->orWhere('id', $assignment->otherpartner)
  //         ->first();

  //       //dd($teammember);

  //       $teammembers = DB::table('teammembers')
  //         ->whereIn('id', [auth()->user()->teammember_id, $teammember->id])
  //         ->first();

  //       $otp = sprintf("%06d", mt_rand(1, 999999));

  //       DB::table('assignmentbudgetings')
  //         ->where('assignmentgenerate_id', $assignment->assignmentgenerate_id)->update([
  //           'otp'  => $otp,
  //         ]);

  //       $data = array(
  //         'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
  //         'email' => $teammembers->emailid,
  //         'otp' => $otp,
  //         'name' => $teammembers->team_member,
  //       );

  //       Mail::send('emails.assignmentclosed', $data, function ($msg) use ($data, $assignment) {
  //         $msg->to($data['email']);
  //         $msg->subject('Assignment Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
  //       });

  //       return response()->json($assignment);
  //     }
  //   }
  // }
  public function assignmentotp(Request $request)
  {
    //  dd($request->id); die;
    if ($request->ajax()) {
      if (isset($request->id)) {
        $assignment = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $request->id)
          ->first();

        $teammembers = DB::table('teammembers')
          ->where('id', auth()->user()->teammember_id)
          ->first();

        $otp = sprintf("%06d", mt_rand(1, 999999));

        DB::table('assignmentbudgetings')
          ->where('assignmentgenerate_id', $assignment->assignmentgenerate_id)->update([
            'otp'  => $otp,
          ]);

        $data = array(
          'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
          'email' => $teammembers->emailid,
          'otp' => $otp,
          'name' => $teammembers->team_member,
        );

        Mail::send('emails.assignmentclosed', $data, function ($msg) use ($data, $assignment) {
          $msg->to($data['email']);
          $msg->subject('Assignment Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
        });

        return response()->json($assignment);
      }
    }
  }


  public function assignmentotpstore(Request $request)
  {
    $request->validate([
      'otp' => 'required'
    ]);

    try {
      $data = $request->except(['_token']);

      $otp = DB::table('assignmentbudgetings')
        ->where('otp', $request->otp)
        ->where('assignmentgenerate_id', $request->assignmentgenerateid)->first();
      if ($otp) {

        DB::table('assignmentbudgetings')
          ->where('assignmentgenerate_id', $request->assignmentgenerateid)->update([
            'status' => '0',
            'closedby'  => auth()->user()->teammember_id,
            'otpverifydate' => date('Y-m-d H:i:s')
          ]);
        $output = array('msg' => 'assignment closed successfully');
        return back()->with('success', $output);
      } else {
        $output = array('msg' => 'otp did not match! Please enter valid otp');
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
  public function checklist_upload(Request $request)
  {
    // $request->validate([

    // ]);

    try {
      $data = $request->except(['_token']);
      DB::table('auditquestions')->insert([
        'assignmentgenerate_id'     =>     $request->assignmentgenerate_id,
        'steplist_id'     =>     $request->steplist,
        'subclassfied_id'     =>     $request->subclassfied,
        'financialstatemantclassfication_id' =>  $request->financialid,
        'auditprocedure'  => $request->checklist,
        'createdby'  => auth()->user()->teammember_id,
        'created_at'          =>   date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
      ]);
      $output = array('msg' => 'Question Add Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function assignmentprofitloss()
  {
    $invoiceData =  DB::table('invoices')
      ->leftjoin('clients', 'clients.id', 'invoices.client_id')
      ->leftjoin('teammembers', 'teammembers.id', 'invoices.partner')
      ->join('assignments', 'assignments.id', 'invoices.assignment_id')
      //	->where('invoices.assignment_id',44)
      ->select('invoices.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name')->orderBy('id', 'desc')->paginate('100');
    //dd($invoiceData);
    return view('backEnd.assignment.assignmentfinalreport', compact('invoiceData'));
  }
  public function assignment_profitloss($id)
  {
    //dd($id);
    $invoiceData = DB::table('assignmentbudgetings')
      ->select(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'invoices.partner')
      ->leftJoin('assignments', 'assignments.id', '=', 'invoices.assignment_id')
      ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')
      ->where('invoices.financialyear', '=', $id)
      ->groupBy(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      ->get();

    //	dd($invoiceData);
    $partner = DB::table('invoices')
      ->leftjoin('teammembers', 'teammembers.id', 'invoices.partner')
      ->select('teammembers.team_member', 'teammembers.id')
      ->where('invoices.financialyear', $id)->distinct('teammembers.team_member')->get();

    $assignments = DB::table('invoices')
      ->join('assignments', 'assignments.id', 'invoices.assignment_id')
      ->select('assignments.id', 'assignments.assignment_name')
      ->where('invoices.financialyear', $id)->distinct('assignments.assignment_name')->get();

    //dd($assignments);
    return view('backEnd.assignment.assignmentfinalreport', compact('invoiceData', 'partner', 'id', 'assignments'));
  }
  public function partnerpandl(Request $request)
  {
    //dd($id);
    $invoiceData =  DB::table('assignmentbudgetings')
      ->select(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'invoices.partner')
      ->leftJoin('assignments', 'assignments.id', '=', 'invoices.assignment_id')
      ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')

      ->where('invoices.financialyear', $request->fy)
      ->where('invoices.partner', $request->partners)
      ->groupBy(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      ->get();

    $partner = DB::table('invoices')
      ->leftjoin('teammembers', 'teammembers.id', 'invoices.partner')
      ->select('teammembers.team_member', 'teammembers.id')
      ->where('invoices.financialyear', $request->fy)->distinct('teammembers.team_member')->get();

    $assignments = DB::table('invoices')
      ->join('assignments', 'assignments.id', 'invoices.assignment_id')
      ->select('assignments.id', 'assignments.assignment_name')
      ->where('invoices.financialyear', $request->fy)
      ->distinct('assignments.assignment_name')->get();
    $id = $request->fy;
    return view('backEnd.assignment.assignmentfinalreport', compact('invoiceData', 'partner', 'id', 'assignments'));
  }
  public function assignmentpandl(Request $request)
  {
    //dd($id);
    $invoiceData =
      DB::table('assignmentbudgetings')
      ->select(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'invoices.partner')
      ->leftJoin('assignments', 'assignments.id', '=', 'invoices.assignment_id')
      ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')

      ->where('invoices.financialyear', $request->fy)
      ->where('invoices.assignment_id', $request->assignment_id)
      ->groupBy(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      ->get();


    $partner = DB::table('invoices')
      ->leftjoin('teammembers', 'teammembers.id', 'invoices.partner')
      ->select('teammembers.team_member', 'teammembers.id')
      ->where('invoices.financialyear', $request->fy)->distinct('teammembers.team_member')->get();

    $assignments = DB::table('invoices')
      ->join('assignments', 'assignments.id', 'invoices.assignment_id')
      ->select('assignments.id', 'assignments.assignment_name')
      ->where('invoices.financialyear', $request->fy)->distinct('assignments.assignment_name')->get();
    $id = $request->fy;
    return view('backEnd.assignment.assignmentfinalreport', compact('invoiceData', 'partner', 'id', 'assignments'));
  }

  public function assignment_costing($id)
  {
    $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
      ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
      ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
      ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
      ->where('assignmentbudgetings.assignmentgenerate_id', $id)
      ->select(
        'assignmentbudgetings.*',
        'assignmentmappings.*',
        'clients.client_name',
        'assignments.assignment_name'
      )->first();

    $invoicecosting = DB::table('invoices')->where('assignmentgenerate_id', $id)->get();
    $invoicecostingtotal = DB::table('invoices')->where('assignmentgenerate_id', $id)->sum('total');
    $assignmentbudgetings = DB::table('assignmentmappings')
      ->where('assignmentgenerate_id', $id)->first();

    //  dd($assignmentbudgetings);
    $costing = DB::table('timesheetusers')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->select('timesheetusers.createdby', DB::raw('SUM(totalhour) as total_hour'))
      ->where('timesheetusers.assignmentgenerate_id', $id)
      ->groupBy('timesheetusers.createdby')
      ->get();
    // dd($costing);
    //  DB::table('assignmentmappings')
    //       ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //     ->leftjoin('teammembers','teammembers.id', 'assignmentteammappings.teammember_id')
    //    ->leftjoin('timesheetusers','timesheetusers.createdby', 'teammembers.id')

    //  ->select('teammembers.team_member', DB::raw('SUM(timesheetusers.hour) as total_hours'))

    // ->groupBy('teammembers.team_member')
    //	    ->where('assignmentteammappings.assignmentmapping_id',$assignmentbudgetings->id)
    //   ->where('assignmentmappings.assignmentgenerate_id',$id)
    //  ->get();

    return view('backEnd.assignmentmapping.assignmentcosting', compact('invoicecosting', 'costing', 'invoicecostingtotal', 'assignmentbudgetingDatas', 'id'));
  }
  public function assignmentpartnerlist()
  {
    $assignmentmappingData =  DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
      ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
      ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
      ->select(
        'assignmentmappings.*',
        'assignmentbudgetings.duedate',
        'assignments.assignment_name',
        'clients.client_name'
      )->distinct()->get();
    return view('backEnd.assignmentmapping.yearwiseS', compact('assignmentmappingData'));
  }

  public function index()
  {
    $assignmentDatas = Assignment::latest()->get();
    return view('backEnd.assignment.index', compact('assignmentDatas'));
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
    $request->validate([
      'assignment_name' => "required"
    ]);

    try {
      $data = $request->except(['_token']);
      $data = Assignment::Create($data);
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
   * @param  \App\Models\Assignment  $assignment
   * @return \Illuminate\Http\Response
   */
  public function show(Assignment $assignment)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Assignment  $assignment
   * @return \Illuminate\Http\Response
   */
  public function edit(Assignment $assignment)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Assignment  $assignment
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Assignment $assignment)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Assignment  $assignment
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      Assignment::destroy($id);
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
}
