<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\Candidateonboarding;
use App\Models\Employeeonboarding;
use App\Models\Teammember;
use App\Models\Articleonboarding;
use App\Models\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;

class CandidateboardingController extends Controller
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
  public function articleconvert(Request $request, $id)
  {
    //  dd($id);
    $articleonboarding = DB::table('articleonboardings')->where('id', $id)->first();
    //   dd($candidateonboarding);
    DB::table('employeeonboardings')->insert([
      //  'reportinghead' =>$articleonboarding->reportinghead ??'',
      'your_full_name' => $articleonboarding->name,
      'cro_nro_no'      => $articleonboarding->cro_nro_no,
      'role' => $articleonboarding->role,
      'department' => $articleonboarding->department ?? '',
      'dateofjoining' => $articleonboarding->doj,
      'personal_email' => $articleonboarding->emailid,
      'phoneno' => $articleonboarding->contactno,
      'dob' => $articleonboarding->dob,
      'documentbcom' => $articleonboarding->documentbcom,
      'documentbachelor' => $articleonboarding->documentbachelor,
      //'mothecontactno' =>$articleonboarding->mothecontactno,
      'mother_name' => $articleonboarding->mothersname,
      'currentaddress' => $articleonboarding->currentaddress,
      'permanentaddress' => $articleonboarding->permanentaddress,
      'designation' => $articleonboarding->designation,

      'father_name' => $articleonboarding->fathersname,
      //'fathercontactno' =>$articleonboarding->fathercontactno,
      //  'resume' =>$articleonboarding->resume,
      //   'nda' =>$articleonboarding->nda,
      'marksheet_xii' => $articleonboarding->document12th,
      'marksheet_x' => $articleonboarding->document10th,
      'bachelor_degree' => $articleonboarding->bachelorattached,
      'bcomcertificate' => $articleonboarding->bcomcertificate,
      //'master_degree' =>$articleonboarding->master_degree,
      /*'marksheet_ipcc' =>$articleonboarding->marksheet_ipcc,
      'ca_final' =>$articleonboarding->ca_final,
      'membership_certificate' =>$articleonboarding->membership_certificate,
      'addidation_qualification' =>$articleonboarding->addidation_qualification,
      'offerappointmentletter' =>$articleonboarding->offerappointmentletter,
      'payslipsone' =>$articleonboarding->payslipsone,
      'payslipstwo' =>$articleonboarding->payslipstwo,
      'payslipsthree' =>$articleonboarding->payslipsthree,
      'relieving_letter' =>$articleonboarding->relieving_letter,
      'residence_proofone' =>$articleonboarding->residence_proofone,*/
      'ipcccertificate' => $articleonboarding->ipcccertificate,
      'cptcertificate' => $articleonboarding->cptcertificate,
      'ipcccertificatetwo' => $articleonboarding->ipcccertificatetwo,
      'octrainingcertificate' => $articleonboarding->octrainingcertificate,
      'itttrainingcertificate' => $articleonboarding->itttrainingcertificate,
      'residenceproof' => $articleonboarding->residenceproof,
      'residenceprooftwo' => $articleonboarding->residenceprooftwo,
      'copyof' => $articleonboarding->copyof,
      'copyoftwo' => $articleonboarding->copyoftwo,
      'additional' => $articleonboarding->additional,
      'pancardno' => $articleonboarding->pancardno,
      'pancard' => $articleonboarding->pancard,
      'photograph' => $articleonboarding->photograph,
      'adharcardno' => $articleonboarding->aadharno,
      'aadharcard' => $articleonboarding->aadharcard,
      'bankholder_name' => $articleonboarding->accountholder,
      'bank_name' => $articleonboarding->accountname,
      'account_number' => $articleonboarding->accountnumber,
      'ifsc_code' => $articleonboarding->ifsccode,
      'branch' => $articleonboarding->branch,
      // 'emergency_name' =>$articleonboarding->emergency_name,
      // 'emergency_relation' =>$articleonboarding->emergency_relation,
      'emergency_contact_number' => $articleonboarding->emergencycontactnumber,
      //'emergency1_name' =>$articleonboarding->emergency1_name,
      //'emergency1_relation' =>$articleonboarding->emergency1_relation,
      'emergency1_number' => $articleonboarding->emergencycontactnumbertwo,
      'gender' => $articleonboarding->gender,
      'linkedin' => $articleonboarding->linkedin,
      'about' => $articleonboarding->about,
      'qualification' => $articleonboarding->qualification,

      'created_at' => date('y-m-d'),
      'updated_at' => date('y-m-d')
    ]);
    $converted_teammember_id = DB::table('teammembers')->insertGetId([
      'team_member' => $articleonboarding->name,
      'mobile_no'   => $articleonboarding->contactno,
      'employment_status' => $articleonboarding->designation ?? '',
      'personalemail' => $articleonboarding->emailid,
      'department'    => $articleonboarding->department ?? '',
      'fathername'  => $articleonboarding->fathersname ?? '',
      'dateofbirth' => $articleonboarding->dob,
      'panupload' => $articleonboarding->pancard,
      'pancardno' => $articleonboarding->pancardno,
      'adharcardnumber' => $articleonboarding->aadharno,
      'aadharupload' => $articleonboarding->aadharcard,
      'mothername' => $articleonboarding->mothersname,
      'mothernumber' => $articleonboarding->emergencycontactnumber,
      'fathernumber' => $articleonboarding->emergencycontactnumbertwo,
      'joining_date' => $articleonboarding->doj,
      'role_id'      => $articleonboarding->role,
      'profilepic' => $articleonboarding->photograph,
      'nameofbank' => $articleonboarding->accountname,
      'bankaccountnumber' => $articleonboarding->accountnumber,
      'ifsccode' => $articleonboarding->ifsccode,
      'role_id' => $articleonboarding->role,
      'designation' => $articleonboarding->designation,
      'communicationaddress' => $articleonboarding->currentaddress,
      'permanentaddress' => $articleonboarding->permanentaddress,
      'gender' => $articleonboarding->gender,
      'linkedin' => $articleonboarding->linkedin,
      'about' => $articleonboarding->about,
      'qualification' => $articleonboarding->qualification,
      'status' => '1',
      'created_at' => date('y-m-d'),
      'updated_at' => date('y-m-d')
    ]);
    $converted_teammember = Teammember::find($converted_teammember_id);

    $currentDate = now();
    $day = $currentDate->day;
    if (in_array($day, [26, 27, 28, 29, 30,31])) {
      $month = $currentDate->addMonth()->format('F');
    } else {
      $month = $currentDate->format('F');
      
    }

    Attendance::create([
      'employee_name' => $converted_teammember->id,
      'employee_status' => 1,
      'dateofjoining' => $converted_teammember->joining_date,
      'month' => $month,

    ]);

    DB::table('articleonboardings')->where('id', $articleonboarding->id)->update([
      'status' => '1',
      'updated_at' => date('y-m-d')
    ]);
    $teammember = Teammember::where('id', auth()->user()->teammember_id)->first();

    $data = array(
      'teammember' => $teammember->team_member ?? '',
      //    'id' => $id ??''   
    );

    Mail::send('emails.candidateonboarding', $data, function ($msg) use ($data) {
      $msg->to(['admin@kgsomani.com', 'amitgaur@kgsomani.com', 'it@kgsomani.com','kavitagarwal@kgsomani.com','hr@kgsomani.com']);
      $msg->cc(['priyankasharma@kgsomani.com', 'deepikajaiswal@kgsomani.com']);
      $msg->subject('Kgs New Joinee Details');
    });

    $output = array('msg' => 'Convert Successfully');
    //return back()->with('success', $output);
    return Redirect::to('/candidateboarding')->with('success', $output);
  }
  public function index(Request $request)
  {
    $candidateDatasManager  = DB::table('candidateonboardings')
      ->leftjoin('roles', 'roles.id', 'candidateonboardings.role')
      ->where('status', '0')
      //->where('candidateonboardings.role',14)
      ->select('candidateonboardings.*', 'roles.rolename')->orderBy('dateofjoining', 'desc')->get();

    // dd($candidateDatasManager);

    $candidateDatasArticle  = DB::table('articleonboardings')
      //->leftjoin('roles','roles.id','articleonboardings.role')
      ->where('status', null)
      //->where('candidateonboardings.role',15)
      // ->select('candidateonboardings.*','roles.rolename')
      ->orderBy('doj', 'desc')->get();

    $candidateDatasIntern  = DB::table('candidateonboardings')
      ->leftjoin('roles', 'roles.id', 'candidateonboardings.role')
      ->where('status', '0')
      ->where('candidateonboardings.role', 19)
      ->select('candidateonboardings.*', 'roles.rolename')->get();

    //  dd($candidateDatas);
    //return view('backEnd.candidateonboarding.indexold',compact('candidateDatas'));
    return view('backEnd.candidateonboarding.index', compact('candidateDatasManager', 'candidateDatasArticle', 'candidateDatasIntern'));
  }
  public function candidateconvert(Request $request, $id)
  {
    // dd($id);
    $candidateonboarding = Candidateonboarding::where('id', $id)->first();
    //   dd($candidateonboarding);
    DB::table('employeeonboardings')->insert([
      'reportinghead' => $candidateonboarding->reportinghead,
      'your_full_name' => $candidateonboarding->your_full_name,
      'role' => $candidateonboarding->role,
      'department' => $candidateonboarding->department,
      'dateofjoining' => $candidateonboarding->dateofjoining,
      'dob'           => $candidateonboarding->dateofbirth,
      'highestqualification' => $candidateonboarding->highestqualification,
      'membershipnumber' => $candidateonboarding->membershipnumber,
      'personal_email' => $candidateonboarding->personal_email,
      'phoneno' => $candidateonboarding->phoneno,
      'mothecontactno' => $candidateonboarding->mothecontactno,
      'mother_name' => $candidateonboarding->mother_name,
      'currentaddress' => $candidateonboarding->currentaddress,
      'permanentaddress' => $candidateonboarding->permanentaddress,
      'designation' => $candidateonboarding->designation,

      'father_name' => $candidateonboarding->father_name,
      'fathercontactno' => $candidateonboarding->fathercontactno,
      'resume' => $candidateonboarding->resume,
      'nda' => $candidateonboarding->nda,
      'marksheet_xii' => $candidateonboarding->marksheet_xii,
      'marksheet_x' => $candidateonboarding->marksheet_x,
      'bachelor_degree' => $candidateonboarding->bachelor_degree,
      'master_degree' => $candidateonboarding->master_degree,
      'marksheet_ipcc' => $candidateonboarding->marksheet_ipcc,
      'ca_final' => $candidateonboarding->ca_final,
      'membership_certificate' => $candidateonboarding->membership_certificate,
      'addidation_qualification' => $candidateonboarding->addidation_qualification,
      'offerappointmentletter' => $candidateonboarding->offerappointmentletter,
      'payslipsone' => $candidateonboarding->payslipsone,
      'payslipstwo' => $candidateonboarding->payslipstwo,
      'payslipsthree' => $candidateonboarding->payslipsthree,
      'relieving_letter' => $candidateonboarding->relieving_letter,
      'residence_proofone' => $candidateonboarding->residence_proofone,
      'pancardno' => $candidateonboarding->pancardno,
      'pancard' => $candidateonboarding->pancard,
      'photograph' => $candidateonboarding->photograph,
      'adharcardno' => $candidateonboarding->adharcardno,
      'bankholder_name' => $candidateonboarding->bankholder_name,
      'bank_name' => $candidateonboarding->bank_name,
      'account_number' => $candidateonboarding->account_number,
      'ifsc_code' => $candidateonboarding->ifsc_code,
      'branch' => $candidateonboarding->branch,
      'emergency_name' => $candidateonboarding->emergency_name,
      'emergency_relation' => $candidateonboarding->emergency_relation,
      'emergency_contact_number' => $candidateonboarding->emergency_contact_number,
      'emergency1_name' => $candidateonboarding->emergency1_name,
      'emergency1_relation' => $candidateonboarding->emergency1_relation,
      'emergency1_number' => $candidateonboarding->emergency1_number,
      'gender' => $candidateonboarding->gender,
      'linkedin' => $candidateonboarding->linkedin,
      'about' => $candidateonboarding->about,

      'created_at' => date('y-m-d'),
      'updated_at' => date('y-m-d')
    ]);

    $converted_teammember_id = DB::table('teammembers')->insertGetId([
      'team_member' => $candidateonboarding->your_full_name,
      'personalemail' => $candidateonboarding->personal_email,
      'employment_status' => $candidateonboarding->department,
      'mobile_no' => $candidateonboarding->phoneno,
      'department' => $candidateonboarding->department,
      'fathername' => $candidateonboarding->father_name,
      'dateofbirth' => $candidateonboarding->dateofbirth,
      'pancardno' => $candidateonboarding->pancardno,
      'emergencycontactnumber' => $candidateonboarding->emergency_contact_number,
      'profilepic' => $candidateonboarding->photograph,
      'adharcardnumber' => $candidateonboarding->adharcardno,
      'nameofbank' => $candidateonboarding->bank_name,
      'bankaccountnumber' => $candidateonboarding->account_number,
      'ifsccode' => $candidateonboarding->ifsc_code,
      'mothername' => $candidateonboarding->mother_name,
      'mothernumber' => $candidateonboarding->mothecontactno,
      'fathernumber' => $candidateonboarding->fathercontactno,
      'panupload' => $candidateonboarding->pancard,
      'aadharupload' => $candidateonboarding->aadharcard,
      'role_id' => $candidateonboarding->role,
      'designation' => $candidateonboarding->designation,
      'communicationaddress' => $candidateonboarding->currentaddress,
      'permanentaddress' => $candidateonboarding->permanentaddress,
      'joining_date' => $candidateonboarding->dateofjoining,
      'qualification' => $candidateonboarding->highestqualification,
      'gender' => $candidateonboarding->gender,
      'linkedin' => $candidateonboarding->linkedin,
      'about' => $candidateonboarding->about,

      'status' => '1',
      'created_at' => date('y-m-d'),
      'updated_at' => date('y-m-d')
    ]);

    $converted_teammember = Teammember::find($converted_teammember_id);

    $currentDate = now();
    $day = $currentDate->day;
    if (in_array($day, [26, 27, 28, 29, 30,31])) {
      $month = $currentDate->addMonth()->format('F');
    } else {
      $month = $currentDate->format('F');
      
    }

    Attendance::create([
      'employee_name' => $converted_teammember->id,
      'employee_status' => 1,
      'dateofjoining' => $converted_teammember->joining_date,
      'month' => $month,

    ]);


    DB::table('candidateonboardings')->where('id', $candidateonboarding->id)->update([
      'status' => '1',
      'updated_at' => date('y-m-d')
    ]);
    $teammember = Teammember::where('id', auth()->user()->teammember_id)->first();

    $data = array(
      'teammember' => $teammember->team_member ?? '',
      //    'id' => $id ??''   
    );

    Mail::send('emails.candidateonboarding', $data, function ($msg) use ($data) {
      $msg->to(['admin@kgsomani.com', 'amitgaur@kgsomani.com', 'it@kgsomani.com','hr@kgsomani.com','kavitagarwal@kgsomani.com']);
      $msg->cc(['priyankasharma@kgsomani.com', 'deepikajaiswal@kgsomani.com']);
      $msg->subject('Kgs New Joinee Details');
    });
    $output = array('msg' => 'Convert Successfully');
    return back()->with('success', $output);
  }

  public function candidatedetails(Request $request)
  {
    // dd($request);
    if ($request->ajax()) {
      if (isset($request->id)) {
        //   dd($request->id);
        $conversion = DB::table('candidateonboardings')
          ->where('id', $request->id)->first();
        //  dd($conversion);
        return response()->json($conversion);
      }
    }
  }
  public function candidateupdate(Request $request)
  {


    try {
      $data = $request->except(['_token', 'two_residence_proof', 'payslip']);
      if ($request->hasFile('resume')) {
        $file = $request->file('resume');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['resume'] = $name;
      }
      if ($request->hasFile('nda')) {
        $file = $request->file('nda');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['nda'] = $name;
      }
      if ($request->hasFile('marksheet_x')) {
        $file = $request->file('marksheet_x');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['marksheet_x'] = $name;
      }
      if ($request->hasFile('marksheet_xii')) {
        $file = $request->file('marksheet_xii');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['marksheet_xii'] = $name;
      }
      if ($request->hasFile('bachelor_degree')) {
        $file = $request->file('bachelor_degree');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['bachelor_degree'] = $name;
      }
      if ($request->hasFile('master_degree')) {
        $file = $request->file('master_degree');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['master_degree'] = $name;
      }
      if ($request->hasFile('marksheet_ipcc')) {
        $file = $request->file('marksheet_ipcc');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['marksheet_ipcc'] = $name;
      }
      if ($request->hasFile('ca_final')) {
        $file = $request->file('ca_final');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['ca_final'] = $name;
      }
      if ($request->hasFile('membership_certificate')) {
        $file = $request->file('membership_certificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['membership_certificate'] = $name;
      }
      if ($request->hasFile('addidation_qualification')) {
        $file = $request->file('addidation_qualification');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['addidation_qualification'] = $name;
      }
      if ($request->hasFile('relieving_letter')) {
        $file = $request->file('relieving_letter');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['relieving_letter'] = $name;
      }
      if ($request->hasFile('pancard')) {
        $file = $request->file('pancard');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['pancard'] = $name;
      }
      if ($request->hasFile('photograph')) {
        $file = $request->file('photograph');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['photograph'] = $name;
      }
      if ($request->hasFile('offerappointmentletter')) {
        $file = $request->file('offerappointmentletter');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['offerappointmentletter'] = $name;
      }
      if ($request->hasFile('payslipsone')) {
        $file = $request->file('payslipsone');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['payslipsone'] = $name;
      }
      if ($request->hasFile('payslipstwo')) {
        $file = $request->file('payslipstwo');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['payslipstwo'] = $name;
      }
      if ($request->hasFile('payslipsthree')) {
        $file = $request->file('payslipsthree');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['payslipsthree'] = $name;
      }
      if ($request->hasFile('residence_prooftwo')) {
        $file = $request->file('residence_prooftwo');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['residence_prooftwo'] = $name;
      }
      if ($request->hasFile('residence_proofone')) {
        $file = $request->file('residence_proofone');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['residence_proofone'] = $name;
      }
      $id = $request->id;
      Candidateonboarding::find($id)->update($data);
      $output = array('msg' => 'Update Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function articledetails(Request $request)
  {
    // dd($request);
    if ($request->ajax()) {
      if (isset($request->id)) {
        //   dd($request->id);
        $conversion = DB::table('articleonboardings')
          ->where('id', $request->id)->first();
        // dd($conversion);
        return response()->json($conversion);
      }
    }
  }

  public function articleupdate(Request $request, $id = "")
  {
    // dd($request);

    try {
      $data = $request->except(['_token', 'previous_organization_form', 'date_of_leaving', 'date_of_joining']);
      //  dd($data);
      if ($request->hasFile('document10th')) {
        $file = $request->file('document10th');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['document10th'] = $name;
      }
      if ($request->hasFile('document12th')) {
        $file = $request->file('document12th');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['document12th'] = $name;
      }
      if ($request->hasFile('bcomcertificate')) {
        $file = $request->file('bcomcertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['bcomcertificate'] = $name;
      }
      if ($request->hasFile('noc')) {
        $file = $request->file('noc');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['noc'] = $name;
      }
      if ($request->hasFile('cptcertificate')) {
        $file = $request->file('cptcertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['cptcertificate'] = $name;
      }
      if ($request->hasFile('ipcccertificate')) {
        $file = $request->file('ipcccertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['ipcccertificate'] = $name;
      }
      if ($request->hasFile('ipcccertificatetwo')) {
        $file = $request->file('ipcccertificatetwo');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['ipcccertificatetwo'] = $name;
      }
      if ($request->hasFile('octrainingcertificate')) {
        $file = $request->file('octrainingcertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['octrainingcertificate'] = $name;
      }
      if ($request->hasFile('itttrainingcertificate')) {
        $file = $request->file('itttrainingcertificate');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['itttrainingcertificate'] = $name;
      }
      if ($request->hasFile('residenceproof')) {
        $file = $request->file('residenceproof');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['residenceproof'] = $name;
      }
      if ($request->hasFile('residenceprooftwo')) {
        $file = $request->file('residenceprooftwo');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['residenceprooftwo'] = $name;
      }
      if ($request->hasFile('pancard')) {
        $file = $request->file('pancard');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['pancard'] = $name;
      }
      if ($request->hasFile('aadharcard')) {
        $file = $request->file('aadharcard');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['aadharcard'] = $name;
      }
      if ($request->hasFile('photograph')) {
        $file = $request->file('photograph');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['photograph'] = $name;
      }
      if ($request->hasFile('copyof')) {
        $file = $request->file('copyof');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['copyof'] = $name;
      }
      if ($request->hasFile('copyoftwo')) {
        $file = $request->file('copyoftwo');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['copyoftwo'] = $name;
      }
      if ($request->hasFile('additional')) {
        $file = $request->file('additional');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['additional'] = $name;
      }
      if ($request->hasFile('bachelorattached')) {
        $file = $request->file('bachelorattached');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('articleonboarding', $name, 's3');
        $data['bachelorattached'] = $name;
      }

      $id = $request->id;
      //  dd($id);
      Articleonboarding::find($id)->update($data);
      $output = array('msg' => 'Update Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function capitallarticle(Request $request)
  {
    if ($request->ajax()) {
      //  dd($request);
      if (isset($request->id)) {

        $id = DB::table('articleonboardings')->where('id', $request->id)->first();
        return response()->json($id);
      }
    }
  }


  public function capitallarticlepreview(Request $request)
  {
    // dd($request->article_id);
    $partner = Teammember::where('id', $request->partner)->pluck('team_member')->first();
    $partner_id = $request->partner;
    //dd($partner_id);
    $approval = $request->approvalstatus;
    $date_of_completion = $request->date_of_completion;
    $date_of_registration = $request->date_of_registration;
    $location = $request->location;
    $article = Articleonboarding::where('id', $request->articleid)->first();
    //dd($article);
    $previous = DB::table('articletrainingdetails')
      ->where('articleonboarding_id', $request->articleid)->get();

    return view('backEnd.candidateonboarding.preview', compact(
      'article',
      'previous',
      'partner',
      'approval',
      'date_of_completion',
      'date_of_registration',
      'location',
      'partner_id'
    ));
  }
}
