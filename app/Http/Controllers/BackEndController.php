<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Tender;
use App\Models\Training;
use App\Models\Asset;
use App\Models\Page;
use App\Models\Assetticket;
use App\Models\Title;
use App\Models\Teammember;
use App\Models\Assignment;
use App\Models\Assignmentteammapping;
use App\Models\Assignmentmapping;
use App\Models\Notification;
use App\Models\Client;
use App\Models\Permission;
use DB;
use Carbon\Carbon;
use App\Models\Holiday;

class BackEndController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function deletequalification($id)
  {
    // dd($id);
    try {
      DB::table('teammember_document_files')->where([
        'id' => $id,

      ])->delete();

      $output = array('msg' => 'Deleted Successfully');
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
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function create()
  {
    $pages = DB::table('pages')->where('id', '!=', '3')->where('id', '!=', '9')->get();
    return view('backEnd.training.create', compact('pages'));
  }
  public function authotp(Request $request)
  {
    //  dd($request->id); die;
    if ($request->ajax()) {
      if (isset($request->id)) {
        //   dd($request->id);
        $authotp = DB::table('teammembers')
          ->select('teammembers.mobile_no')->where('teammembers.id', $request->id)->first();
        //	dd($authotp->mobile_no);
        $curl = curl_init();
        $authnumber = $authotp->mobile_no;
        $cdate = urlencode(date('F d,Y', strtotime(date('Y-m-d'))));
        $otpap = sprintf("%06d", mt_rand(1, 999999));

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://bhashsms.com/api/sendmsg.php?user=KGSomani&pass=123456&sender=CPTLIT&phone=" . $authnumber . "&text=" . $otpap . "%20is%20the%20Onetime%20password%20(OTP)%20for%20authentication%20of%20transaction%20at%20KGS%20" . $cdate . "%20CPTLIT&priority=ndnd&stype=normal", // your preferred url
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30000,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          //    CURLOPT_POSTFIELDS => json_encode($data2),
          CURLOPT_HTTPHEADER => array(
            // Set here requred headers
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
          ),

        ));  //  dd($se);
        $response = curl_exec($curl);
        DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->update([
          'otp' => $otpap,
        ]);
        return response()->json($outstationconveyances);
      }
    }
  }
  public function otpapstore(Request $request)
  {
    $request->validate([
      'otp' => 'required'
    ]);

    try {
      $data = $request->except(['_token']);

      $otp = $request->otp;

      $otpm = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->first();
      if ($otp == $otpm->otp) {

        DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->update([
          'status' => '1',
          'otpdate' => date('Y-m-d H:i:s')
        ]);
        $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

        $data = array(
          'teammember' => $teammember->team_member ?? '',
          //    'id' => $id ??''   
        );

        $a = Mail::send('emails.notificationappointmentletterMail', $data, function ($msg) use ($data) {
          $msg->to(['priyankasharma@kgsomani.com']);
          //  $msg->cc(['priyankasharma@kgsomani.com']);
          $msg->subject('Appointment Letter Verified || ' . $data['teammember']);
        });
        $output = array('msg' => 'otp match successfully and verified');
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
  public function appointmentletter()
  {
    $teammember = DB::table('staffappointmentletters')
      ->leftjoin('teammembers', 'teammembers.id', 'staffappointmentletters.teammember_id')
      ->where('teammember_id', auth()->user()->teammember_id)
      ->select('staffappointmentletters.*', 'teammembers.team_member', 'teammembers.permanentaddress', 'teammembers.communicationaddress')->first();
    // dd($teammember);
    return view('backEnd.appointmentletter', compact('teammember'));
  }
  public function trainingreminderMail()
  {

    $trainingid = Training::pluck('teammember_id')->toArray();

    $accountant = Teammember::whereNotIn('id', $trainingid)->where('id', '!=', '6')->where('id', '!=', '156')->pluck('emailid')->toArray();
    // dd($accountant);
    foreach ($accountant as $accountantmail) {
      $teammember = $accountantmail;
      $data = array();

      Mail::send('emails.trainingreminder', $data, function ($msg) use ($data, $teammember) {
        $msg->to($teammember);
        $msg->subject('kgs Training Reminder');
      });

      // die;
    }
    $output = array('msg' => 'Reminder Mail Send Successfully');
    return redirect('traininglist')->with('success', $output);
  }
  public function trainingMail(Request $request)
  {
    $module = Page::wherein('id', $request->module)->get();
    // dd($module);
    $teammember = DB::table('teammembers')->where('id', $request->id)->pluck('emailid')->first();
    $data = array(
      'module' =>  $module,
    );

    Mail::send('emails.trainingmail', $data, function ($msg) use ($data, $teammember) {
      $msg->to($teammember);
      $msg->subject('kgs Training Reminder');
    });
    $output = array('msg' => 'Reminder Mail Send Successfully');
    return redirect('traininglist')->with('success', $output);
  }
  public function training(Request $request)
  {
    // dd($request);
    try {
      $trainingid =  DB::table('trainings')->insertGetId([
        'teammember_id'         => auth()->user()->teammember_id,
        'created_at'          =>     date('y-m-d'),
        'updated_at'              =>    date('y-m-d'),
      ]);

      foreach ($request->page_id as $page_id) {
        //   dd($page_id);
        DB::table('traininglists')->insert([
          'training_id'     =>     $trainingid,
          'page_id'     =>     $page_id,
          'understood'     =>     1,
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);
      }
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
  public function traininglist()
  {
    if (auth()->user()->role_id == 17 || auth()->user()->role_id == 11) {
      $trainingDatas = DB::table('trainings')
        ->leftjoin('teammembers', 'teammembers.id', 'trainings.teammember_id')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('trainings.*', 'teammembers.team_member', 'roles.rolename')->where('teammember_id', '!=', '6')->get();
      return view('backEnd.training.index', compact('trainingDatas'));
    } else {
      $trainingDatas = DB::table('trainings')
        ->leftjoin('teammembers', 'teammembers.id', 'trainings.teammember_id')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('trainings.*', 'teammembers.team_member', 'roles.rolename')->where('teammember_id', auth()->user()->teammember_id)->get();
      return view('backEnd.training.index', compact('trainingDatas'));
    }
  }
  public function traininglistshow($id = '')
  {
    $pages = DB::table('pages')->where('id', '!=', '3')->where('id', '!=', '9')->get();
    $trainingDatas = DB::table('traininglists')->where('training_id', $id)->get();
    $training = DB::table('trainings')->where('id', $id)->first();
    return view('backEnd.training.edit', compact('trainingDatas', 'pages', 'training'));
  }


  public function index()
  {
    $mentor_id = DB::table('teammembers')
      ->join('users', 'users.teammember_id', 'teammembers.id')
      ->where('users.teammember_id', auth()->user()->teammember_id)
      ->pluck('mentor_id')
      ->first();

    $mentee_id = DB::table('teammembers')
      ->join('users', 'users.teammember_id', 'teammembers.id')
      ->where('teammembers.mentor_id', auth()->user()->teammember_id)
      //->pluck('teammembers.id')
      ->get();

    //dd($mentee_id);
    $mentor = null;
    $mentees = null;

    if ($mentor_id != null) {
      $mentor = DB::table('teammembers')->where('id', $mentor_id)->first();
    }

    if (count($mentee_id) != 0) {
      $mentees = $mentee_id;
    }

    // Set $mentees to null (if needed)
    if ($mentees == null) {
      $mentees = null;
    }

    $todayBirthdays = Teammember::whereNotNull('dateofbirth')
      ->where('status', '1')
      ->get()
      ->filter(function ($birthday) {
        $dateofbirth = Carbon::parse($birthday->dateofbirth);
        $currentDate = Carbon::now();

        // Compare the month and day without considering the current year
        return $dateofbirth->month == $currentDate->month && $dateofbirth->day == $currentDate->day;
      })
      ->sortBy('dateofbirth');

    $upcomingBirthdays = Teammember::where('status', '1')
      ->whereRaw('DATE_FORMAT(dateofbirth, "%m-%d") > DATE_FORMAT(NOW(), "%m-%d")')
      ->orderByRaw('DATE_FORMAT(dateofbirth, "%m-%d")')
      ->limit(7)
      ->get();



    $workAnniversaries = Teammember::whereNotNull('joining_date')
      ->where('status', '1')
      ->get()
      ->filter(function ($teammember) {
        $joiningDate = Carbon::parse($teammember->joining_date);
        $currentDate = Carbon::now();

        // Compare the month and day without considering the current year
        $isAnniversaryToday = $joiningDate->month == $currentDate->month && $joiningDate->day == $currentDate->day;

        // Exclude work anniversaries with a duration of 0 years
        $isNonZeroAnniversary = $joiningDate->diffInYears($currentDate) > 0;

        return $isAnniversaryToday && $isNonZeroAnniversary;
      })
      ->sortBy('joining_date')
      ->take(2);

    $upcomingHolidays = Holiday::where('startdate', '>', now()->format('Y-m-d'))
      ->where('status', 1)
      ->orderBy('startdate', 'asc')
      ->take(2)
      ->get();

    if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =  DB::table('notifications')
        ->join('teammembers', 'teammembers.id', 'notifications.created_by')
        ->select(
          'notifications.*',
          'teammembers.profilepic',
          'teammembers.team_member'
        )->orderBy('created_at', 'desc')->paginate('2');
      // dd($notificationDatas);
      $client = Client::count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->paginate(2);
      $assignment =  DB::table('assignmentbudgetings')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->select(
          'assignmentbudgetings.*',
          'clients.client_name',
          'assignments.assignment_name'
        )->orderBy('assignmentbudgetings.created_at', 'desc')->take(3)->get();
      $assignmentcount = Assignmentmapping::count();
      $notification = Notification::count();

      return view('backEnd.index', compact('mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } elseif (auth()->user()->role_id == 13) {
      // dd(auth()->user()->teammember_id);
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =    $notificationDatas = DB::table('notifications')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->Where('targettype', '3')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);
      //  dd($notificationDatas);
      $notification = Notification::count();
      $client = Client::count();
      $tender = Tender::where('teammember_id', auth()->user()->teammember_id)->count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')->where('assettickets.created_by', auth()->user()->teammember_id)
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();


      $assignment = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
        })

        ->select(
          'assignmentmappings.*',
          'clients.client_name',
          'assignmentbudgetings.assignmentname',
          'assignments.assignment_name',
          'assignmentbudgetings.assignmentgenerate_id'
        )
        // Filter open assignment hare status 1 means open assignment 
        ->where('assignmentbudgetings.status', 1)
        // Filter active assignment hare status 0 means active assignment. assrejected
        ->where('assignmentteammappings.status', 0)
        ->get();

      $assignmentcount = count($assignment);


      return view('backEnd.index', compact('tender', 'mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } elseif (auth()->user()->role_id == 16) {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =    $notificationDatas = DB::table('notifications')
        //    ->leftjoin('users','users.id','notifications.created_by')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->Where('targettype', '3')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);
      //  dd($notificationDatas);
      $notification = Notification::count();
      $client = Client::count();
      $tender = Tender::where('teammember_id', auth()->user()->teammember_id)->count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
      $assignment =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

        ->select(
          'assignmentbudgetings.client_id',
          'assignmentbudgetings.assignmentgenerate_id',
          'clients.client_name',
          'assignments.assignment_name'
        )
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)->distinct()->get();
      $assignmentcount = count($assignment);
      return view('backEnd.index', compact('tender', 'mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
      // dd(auth()->user()->teammember_id);
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =   DB::table('notifications')
        //  ->leftjoin('users','users.id','notifications.created_by')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->where('notifications.targettype', '1')
        ->select('notifications.*', 'teammembers.team_member', 'teammembers.profilepic')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);

      //  dd($notificationDatas);
      $notification = Notification::count();
      $client = Client::count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('users', 'users.id', 'assettickets.created_by')
        ->leftjoin('teammembers', 'teammembers.id', 'users.teammember_id')->where('assettickets.created_by', auth()->user()->teammember_id)
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();

      //  dd($notificationDatas);

      $assignment =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        // get assignment name only
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->select(
          'assignmentbudgetings.client_id',
          'clients.client_name',
          'assignmentbudgetings.assignmentgenerate_id',
          'assignments.assignment_name',
          'assignmentbudgetings.assignmentname'
        )
        // ->where('clients.status', 0)
        // Filter open assignment hare status 1 means open assignment 
        ->where('assignmentbudgetings.status', 1)
        // Filter active assignment hare status 0 means active assignment.  assrejected
        ->where('assignmentteammappings.status', 0)
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();
      // dd($assignment);
      $assignmentcount = count($assignment);
      // dd($assignmentcount);

      // manager
      return view('backEnd.index', compact('notification', 'mentor', 'mentees', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } else {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =   DB::table('notifications')
        //  ->leftjoin('users','users.id','notifications.created_by')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->where('notifications.targettype', '1')
        ->select('notifications.*', 'teammembers.team_member', 'teammembers.profilepic')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);

      //  dd($notificationDatas);
      $notification = Notification::count();
      $client = Client::count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('users', 'users.id', 'assettickets.created_by')
        ->leftjoin('teammembers', 'teammembers.id', 'users.teammember_id')->where('assettickets.created_by', auth()->user()->teammember_id)
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();

      $assignment =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->select(
          'assignmentbudgetings.client_id',
          'clients.client_name',
          'assignmentbudgetings.assignmentgenerate_id',
          'assignments.assignment_name',
          'assignmentbudgetings.assignmentname'
        )
        ->where('clients.status', 1)
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();

      $assignmentcount = count($assignment);
      // manager
      return view('backEnd.index', compact('notification', 'mentor', 'mentees', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    }
  }
  public function profileImage($id)
  {
    $userInfo = Teammember::where('id', $id)->first();
    return view('backEnd.profileimage', compact('userInfo'));
  }
  public function ticketIndex($id)
  {
    $ticket =  DB::table('assets')
      ->leftjoin('financerequests', 'financerequests.id', 'assets.financerequest_id')->where('assets.id', $id)->select(
        'assets.id',
        'financerequests.modal_name',
        'financerequests.sno',
        'financerequests.kgs',
        'financerequests.description'
      )->first();

    return view('backEnd.generateticket', compact('id', 'ticket'));
  }
  public function userProfile($id)
  {
    $userid = auth()->user()->id;
    $teammemberid = User::where('id', $userid)->pluck('teammember_id')->first();
    // dd($userid);
    $asset = Asset::where('teammember_id', $teammemberid)->first();
    $title = Title::latest()->get();
    $userInfo = Teammember::where('id', $teammemberid)->first();
    $assetticket = Assetticket::where('created_by', $userid)->get();
    $teamprofile = DB::table('teamprofiles')->where('teammember_id', auth()->user()->teammember_id)->first();
    $teamqualification = DB::table('teammember_document_files')->where('teamember_id', auth()->user()->teammember_id)->get();
    return view('backEnd.userprofile', compact('userInfo', 'title', 'asset', 'assetticket', 'teamprofile', 'teamqualification'));
  }
  public function update(Request $request)
  {

    //   $request->validate([
    //     'team_member' => "required",
    //   'mobile_no' => "required|numeric",

    // 'team_member' => "required"
    //  ]);
    try {
      $data = $request->except(['_token', 'document_file', 'qualification']);

      if ($request->hasFile('profilepic')) {
        $file = $request->file('profilepic');
        $destinationPath = 'backEnd/image/teammember/profilepic';
        $name = time() . $file->getClientOriginalName();
        $s = $file->move($destinationPath, $name);
        //  dd($s); die;
        $data['profilepic'] = $name;
      }
      if ($request->hasFile('cancelcheque')) {
        $file = $request->file('cancelcheque');
        $destinationPath = 'backEnd/image/teammember/cancelcheque';
        $name = time() . $file->getClientOriginalName();
        $s = $file->move($destinationPath, $name);
        //  dd($s); die;
        $data['cancelcheque'] = $name;
      }
      if ($request->hasFile('panupload')) {
        $file = $request->file('panupload');
        $destinationPath = 'backEnd/image/teammember/panupload';
        $name = time() . $file->getClientOriginalName();
        $s = $file->move($destinationPath, $name);
        //  dd($s); die;
        $data['panupload'] = $name;
      }
      if ($request->hasFile('aadharupload')) {
        $file = $request->file('aadharupload');
        $destinationPath = 'backEnd/image/teammember/aadharupload';
        $name = time() . $file->getClientOriginalName();
        $s = $file->move($destinationPath, $name);
        //  dd($s); die;
        $data['aadharupload'] = $name;
      }
      if ($request->hasFile('addressupload')) {
        $file = $request->file('addressupload');
        $destinationPath = 'backEnd/image/teammember/addressupload';
        $name = time() . $file->getClientOriginalName();
        $s = $file->move($destinationPath, $name);
        //  dd($s); die;
        $data['addressupload'] = $name;
      }
      $ids = auth()->user()->teammember_id;
      //   dd($ids);
      //       $teammemberid = User::where('id',$ids)->pluck('teammember_id')->first();
      //    //   dd($teammemberid);
      Teammember::find($ids)->update($data);


      // Clear previous qualifications and document files associated with the team member
      // DB::table('teammember_document_files')->where('teamember_id', $ids)->delete();
      if ($request->document_file != null) {
        $qualifications = $request->qualification;
        $documentFiles = $request->document_file;

        for ($i = 0; $i < count($qualifications); $i++) {
          // Process each qualification and document file entry
          $documentFile = $documentFiles[$i];
          if ($documentFile) {
            $documentFileName = $documentFile->getClientOriginalName();
            $documentFilePath = 'backEnd/image/teammember/document_file';
            $documentFile->move($documentFilePath, $documentFileName);

            DB::table('teammember_document_files')->insert([
              'teamember_id' => $ids,
              'qualification' => $qualifications[$i],
              'document_file' => $documentFileName,
              'created_at' => now(),
              'updated_at' => now(),
            ]);
          }
        }
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
  public function activityLog()
  {
    $activitylogDatas = DB::table('activitylogs')
      ->leftjoin('teammembers', 'teammembers.id', 'activitylogs.user_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->select('activitylogs.*', 'teammembers.team_member', 'roles.rolename')->get();

    return view('backEnd.activitylog.index', compact('activitylogDatas'));
  }
  public function userLog()
  {
    $userlogDatas = DB::table('userloginactiviteies')
      ->leftjoin('teammembers', 'teammembers.id', 'userloginactiviteies.teammember_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->select('userloginactiviteies.*', 'teammembers.team_member', 'roles.rolename')->latest()->get();

    return view('backEnd.userloginlog.index', compact('userlogDatas'));
  }
}
