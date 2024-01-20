<?php

namespace App\Http\Controllers;

use App\Models\Teammember;
use App\Models\Title;
use Illuminate\Validation\Rules\Password;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Image;
use Hash;
use Illuminate\Support\Str;
use DB;
class TeammemberController extends Controller
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
	public function teamstatus(Request $request )
    {
     //   dd($request);
    if(auth()->user()->role_id == 11 or auth()->user()->role_id == 13 ){
       $teammemberDatas = Teammember::with('title','role')
				 ->where('status',$request->status)->get();
       // dd($teammemberDatas);
        return view('backEnd.teammember.index',compact('teammemberDatas'));
    }
    abort(403, ' you have no permission to access this page ');
    }
	public function relievingTeammember()
    {
        if(auth()->user()->role_id == 18 || auth()->user()->role_id == 16 || auth()->user()->role_id == 11){
            $teammemberactiveDatas = Teammember::with('title','role')
            ->where('role_id','!=',11)->where('status',0)->where('relievingstatus','!=',null)->orderBy('updated_at')->get();
           // dd($teammemberDatas);
            return view('backEnd.teammember.relievingindex',compact('teammemberactiveDatas'));
        }
    }
	public function resetPasswords($id)
    {
       // dd($id);
        $teammember = Teammember::where('id', $id)->first();
	  if(auth()->user()->role_id == 11){
            $traillog = DB::table('trail')
            ->leftjoin('teammembers','teammembers.id','trail.createdby')
            ->where('type','resetpassword')->
            select('trail.*','teammembers.team_member')->get();
         //   dd($traillog);
        }
        else{
            $traillog = DB::table('trail')
            ->leftjoin('teammembers','teammembers.id','trail.createdby')
            ->where('pagetitle',auth()->user()->email)
            ->where('type','resetpassword')->
            select('trail.*','teammembers.team_member')->get();
        }
        return view('backEnd.teammember.authresetpassword', compact('id', 'teammember','traillog'));
    }
	public function authpassword_Update(Request $request, $id = '')
    {
        // dd($id);
          $request->validate([
              'emailid' => 'required',
              'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
          ]);
  
          try {
              $date = date("Y-m-d") ;
              $teammemberid =  Teammember::where('id', $id)->select('id')->pluck('id')->first();
         //  dd($teammemberid);
          // $pass = Str::random(10).'@2023';
              DB::table('users')->where('teammember_id',$teammemberid)->update([ 
                  'password'         =>  Hash::make($request->password) ,
                  'updated_at'         =>  $date
                  ]);
			       DB::table('trail')->insert([
                    'createdby' => auth()->user()->teammember_id, 
                    'ip_address' => $request->ip(), 
                    'pagetitle' => $request->emailid, 
                    'type' => 'resetpassword', 
                    'description' => 'Created Password for'.' '.'( '.  $request->emailid. ' )', 
                    'created_at' => date('y-m-d H:i:s'),       
                    'updated_at' => date('y-m-d')       
                ]);
			  $team =  Teammember::where('id', $id)->select('team_member','emailid')->first();
                $data = array(
                    'teamname' =>  $team->team_member,
                     'email' => $team->emailid,
                     'password' => $request->password,
            );
           
             Mail::send('emails.newpassword', $data, function ($msg) use($data){
                 $msg->to($data['email']);
                 $msg->subject('VSA New Password');
              });
			  
                $output = array('msg' => 'Password Updated Successfully Please signin to continue');
                return redirect('/')->with('status', $output);
                
          } catch (Exception $e) {
              DB::rollBack();
              Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
              report($e);
              $output = array('msg' => $e->getMessage());
              return back()->withErrors($output)->withInput();
          }
      }
	 public function teamsupdate(Request $request)
    {
        $request->validate([
       //     'mobile_no' => "required|numeric",
       //     'pancardno' => "required|numeric",
            'leavingdate' => "required"
        ]);
        try {
            $data=$request->except(['_token','teamid']);
           $id = $request->teamid;
            $data['status'] = 0;
            Teammember::find($id)->update($data);
			 DB::table('users')->where('teammember_id',$id)->update([ 
                'status'         =>  '0' ,
                ]);
           $user=          Teammember::find($id);
              //  dd($user);
                $data = array(
                   'teammember' => $user->team_member ??'', 
                 //    'id' => $id ??''   
              );

             Mail::send('emails.relievingmemberMail', $data, function ($msg) use($data){
                $msg->to(['admin@kgsomani.com','amitgaur@kgsomani.com','it@kgsomani.com','accounts@kgsomani.com']);
                $msg->cc(['priyankasharma@kgsomani.com','hr@kgsomani.com','deepikajaiswal@kgsomani.com']);
                $msg->subject('Relieve Employee Details');
              });
            $output = array('msg' => 'Updated Successfully');
            return redirect('teammember')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
	  public function teamUpdate(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
              // dd($request->id);
                $invoice = Teammember::where('id',$request->id)->first();
                return response()->json($invoice);
             }
            }
    
    }
	public function changeteamStatus($id, $status, $teamid)
     {
      //   dd($status);
         try {
             if ($status == 1) {
             //   dd('hi');
                DB::table('teammembers')->where('id',$teamid)->update([	
                    'status'         =>  1,
                     ]);
                DB::table('users')->where('teammember_id',$teamid)->update([	
                    'status'         =>  1,
                     ]);
             } else {
           
                DB::table('teammembers')->where('id',$teamid)->update([	
                    'status'         =>  0,
                     ]);
                    //  $team =  DB::table('users')->where('teammember_id',$teamid)->first();
                    //  dd($id);
                DB::table('users')->where('teammember_id',$teamid)->update([	
                    'status'         =>  0,
                     ]);
                
 
             }
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
    public function index()
    {
	if(auth()->user()->role_id == 11){
		
			        $teammemberDatas = Teammember::with('title','role')
					     ->whereNotIn('id', [793,878])
     //   ->where('role_id','>',auth()->user()->role_id)
						->get();
       // dd($teammemberDatas);
        return view('backEnd.teammember.index',compact('teammemberDatas'));
		}
		   elseif(auth()->user()->role_id == 18 || auth()->user()->role_id == 16){
        $teammemberactiveDatas = Teammember::with('title','role')
        ->where('role_id','!=',11)->where('status',1)->orderBy('joining_date', 'desc')->get();
        $teammemberinactiveDatas = Teammember::with('title','role')
        ->where('role_id','!=',11)->where('status',0)->orderBy('joining_date', 'desc')->get();
        //dd($teammemberDatas);
        return view('backEnd.teammember.hrindex',compact('teammemberactiveDatas','teammemberinactiveDatas'));
    }
		else
		{
			  $teammemberDatas = Teammember::with('title','role')
        ->where('role_id','!=',11)->where('status',1)->get();
       // dd($teammemberDatas);
        return view('backEnd.teammember.allindex',compact('teammemberDatas'));
	
		}
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = Title::latest()->get();
        $teamrole = Role::where('id','!=','11')->get();
			$mentor=DB::table('teammembers')->join('roles','roles.id','teammembers.role_id')
        ->where('role_id','!=',null)->select('teammembers.*','roles.rolename')->get();
        return view('backEnd.teammember.create',compact('title','teamrole','mentor'));
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
              'team_member' => "required",
              'role_id' => "required",
           'emailid' => 'required|unique:teammembers',
          ]);

            try {
                $data=$request->except(['_token','qualification','document_file']);
                if($request->hasFile('profilepic'))
            {
                $avatar = $request->file('profilepic');
                $filename = time().rand(1,100).'.'.$avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
                $data['profilepic']=$filename;
            }
				 if($request->hasFile('appointment_letter'))
            {
                $avatar = $request->file('appointment_letter');
                $filename = time().rand(1,100).'.'.$avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/appointmentletter/' . $filename);
                $data['appointment_letter']=$filename;
            }
            if($request->hasFile('panupload'))
            {
                $file=$request->file('panupload');
                    $destinationPath = 'backEnd/image/teammember/panupload';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['panupload'] = $name;
               
            }
			  if($request->hasFile('aadharupload'))
            {
                $file=$request->file('aadharupload');
                    $destinationPath = 'backEnd/image/teammember/aadharupload';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['aadharupload'] = $name;
               
            }
            if($request->hasFile('addressupload'))
            {
                $file=$request->file('addressupload');
                    $destinationPath = 'backEnd/image/teammember/addressupload';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['addressupload'] = $name;
               
            }
				     if($request->role_id == 15)
            {
             $assign = Teammember::where('role_id',15)->latest()->get();
        // dd($assign); die;
           if($assign->isEmpty()){
                  $assignmentnumbers = '100001';
          }
        else
        {
            
   $assignmentnumb = Teammember::where('role_id',15)->latest()->first()->staffcodenumber;
                     if($assignmentnumb ==  null){
            $assignmentnumbers = '100001';
         }else {
						 $staff = $assignmentnumb + 1;
           $assignmentnumbers = 'S'.$staff;
						 $staffcode = $staff;
					//	 dd($assignmentnumbers);
         }
        }
            }
            if($request->role_id == 14)
            {
             $assign = Teammember::where('role_id',14)->latest()->get();
        // dd($assign); die;
           if($assign->isEmpty()){
                  $assignmentnumbers = '100001';
          }
        else
        {
            
   $assignmentnumb = Teammember::where('role_id',14)->latest()->first()->staffcodenumber;
                     if($assignmentnumb ==  null){
            $assignmentnumbers = '100001';
         }else {
        
						 	 $staff = $assignmentnumb + 1;
           $assignmentnumbers = 'M'.$staff;
						 	 $staffcode = $staff;
         }
        }
            }
            if($request->role_id == 13)
            {
             $assign = Teammember::where('role_id',13)->latest()->get();
        // dd($assign); die;
           if($assign->isEmpty()){
                  $assignmentnumbers = '100001';
          }
        else
        {
            
   $assignmentnumb = Teammember::where('role_id',13)->latest()->first()->staffcodenumber;
                     if($assignmentnumb ==  null){
            $assignmentnumbers = '100001';
         }else {
          $staff = $assignmentnumb + 1;
           $assignmentnumbers = 'P'.$staff;
						 	 $staffcode = $staff;
         }
        }
            }
              $data['staffcode']= $assignmentnumbers ??'';
				 $data['staffcodenumber']= $staffcode ??'';
             $data['status'] = 0;
				  $data['created_by']= auth()->user()->id;
                   $teammember = Teammember::Create($data);
            $teammember->save();
            $teammemberid = $teammember->id;

            if($request->document_file != null){
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
                            'teamember_id' => $teammemberid,
                            'qualification' => $qualifications[$i],
                            'document_file' => $documentFileName,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
         }
                   $actionName = class_basename($request->route()->getActionname());
                $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                    $id = auth()->user()->teammember_id;
                  DB::table('activitylogs')->insert([
                        'user_id' => $id, 
                        'ip_address' => $request->ip(), 
                        'activitytitle' => $pagename, 
                        'description' => 'New Team Member Added'.' '.'( '. $request->team_member. ' )', 
                        'created_at' => date('y-m-d'),       
                        'updated_at' => date('y-m-d')       
                    ]);
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
     * @param  \App\Models\teammember  $teammember
     * @return \Illuminate\Http\Response
     */
    public function show(teammember $teammember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\teammember  $teammember
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title=Title::latest()->get();
        $teamrole=Role::latest()->get();
        $teammember = Teammember::where('id', $id)->first();
		$mentor=DB::table('teammembers')->join('roles','roles.id','teammembers.role_id')
        ->where('role_id','!=',null)->select('teammembers.*','roles.rolename')->get();
		  $teamqualification = DB::table('teammember_document_files')->where('teamember_id',$id)->get();
        return view('backEnd.teammember.edit', compact('id', 'teammember','title','teamrole','mentor','teamqualification'));
    }
 public function resetPassword($id)
    {
       // dd($id);
        $teammember = Teammember::where('id', $id)->first();
	  if(auth()->user()->role_id == 11){
            $traillog = DB::table('trail')
            ->leftjoin('teammembers','teammembers.id','trail.createdby')
            ->where('type','resetpassword')->
            select('trail.*','teammembers.team_member')->get();
         //   dd($traillog);
        }
        else{
            $traillog = DB::table('trail')
            ->leftjoin('teammembers','teammembers.id','trail.createdby')
            ->where('pagetitle',auth()->user()->email)
            ->where('type','resetpassword')->
            select('trail.*','teammembers.team_member')->get();
        }
        return view('backEnd.teammember.resetpassword', compact('id', 'teammember','traillog'));
    }
       public function passwordUpdate(Request $request, $id = '')
    {
        // dd($id);
          $request->validate([
              'emailid' => 'required',
             
          ]);
  
          try {
              $date = date("Y-m-d") ;
              $teammemberid =  Teammember::where('id', $id)->select('id')->pluck('id')->first();
         //  dd($teammemberid);
           $pass = Str::random(10).'@2023';
              DB::table('users')->where('teammember_id',$teammemberid)->update([ 
                  'password'         =>  Hash::make($pass) ,
                  'updated_at'         =>  $date
                  ]);
			       DB::table('trail')->insert([
                    'createdby' => auth()->user()->teammember_id, 
                    'ip_address' => $request->ip(), 
                    'pagetitle' => $request->emailid, 
                    'type' => 'resetpassword', 
                    'description' => 'Created Password for'.' '.'( '.  $request->emailid. ' )', 
                    'created_at' => date('y-m-d H:i:s'),       
                    'updated_at' => date('y-m-d')       
                ]);

               

                    if(auth()->user()->role_id != 11){
                    return redirect('home')->with('alert','Password Updated Successfully!');
          
                }
                else {
                 //  dd('hi');
                    $teammember = Teammember::where('id',$teammemberid)->first();
                  //  dd($teammember);
                    $data = array(
                           'email' => $teammember->emailid ??'',
                           'name' => $teammember->team_member ??'',
                           'password' => $pass ??'',
                   );
                  // dd($request->teammember_id);
                    Mail::send('emails.teamresetlogin', $data, function ($msg) use($data){
                        $msg->to($data['email']);
                        $msg->subject('VSA LOGIN CREDENTIALS');
        // $msg->cc($data['teammembermail']);
                     });

                    $output = array('msg' => 'Updated Successfully');
                    return redirect('teammember')->with('success', $output);
                }
          } catch (Exception $e) {
              DB::rollBack();
              Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
              report($e);
              $output = array('msg' => $e->getMessage());
              return back()->withErrors($output)->withInput();
          }
      }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\teammember  $teammember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
       //     'mobile_no' => "required|numeric",
       //     'pancardno' => "required|numeric",
            'team_member' => "required"
        ]);
        try {
            $data=$request->except(['_token','qualification','document_file']);
			if($request->hasFile('cancelcheque'))
            {
                $file=$request->file('cancelcheque');
                    $destinationPath = 'backEnd/image/teammember/cancelcheque';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['cancelcheque'] = $name;
               
            }
            if($request->hasFile('profilepic'))
            {
                $avatar = $request->file('profilepic');
                $filename = time().rand(1,100).'.'.$avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
                $data['profilepic']=$filename;
            }
				  if($request->hasFile('appointment_letter'))
            {
                $file=$request->file('appointment_letter');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/teammember/appointmentletter/',$filename);
                $data['appointment_letter']=$filename;
            }
				  if($request->hasFile('nda'))
            {
                $file=$request->file('nda');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/teammember/nda/',$filename);
                $data['nda']=$filename;
            }
            if($request->hasFile('panupload'))
            {
                $file=$request->file('panupload');
                    $destinationPath = 'backEnd/image/teammember/panupload';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['panupload'] = $name;
               
            }
         if($request->hasFile('addressupload'))
            {
                $file=$request->file('addressupload');
                    $destinationPath = 'backEnd/image/teammember/addressupload';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['addressupload'] = $name;
               
            }
			  if($request->hasFile('aadharupload'))
            {
                $file=$request->file('aadharupload');
                    $destinationPath = 'backEnd/image/teammember/aadharupload';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['aadharupload'] = $name;
               
            }
            Teammember::find($id)->update($data);
			
			 if($request->document_file != null){
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
                            'teamember_id' => $id,
                            'qualification' => $qualifications[$i],
                            'document_file' => $documentFileName,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
         }
			
			 DB::table('users')->where('teammember_id',$id)->update([ 
                'role_id'         =>  $request->role_id ,
				 'email'         =>  $request->emailid ,
                ]);
              $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                $id = auth()->user()->teammember_id;
              DB::table('activitylogs')->insert([
                    'user_id' => $id, 
                    'ip_address' => $request->ip(), 
                    'activitytitle' => $pagename, 
                    'description' => ' Team Member Data Edit'.' '.'( '. $request->team_member. ' )', 
                    'created_at' => date('y-m-d'),       
                    'updated_at' => date('y-m-d')       
                ]);
            $output = array('msg' => 'Updated Successfully');
            return redirect('teammember')->with('success', $output);
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
     * @param  \App\Models\teammember  $teammember
     * @return \Illuminate\Http\Response
     */
    public function destroy(teammember $teammember)
    {
        //
    }
	
	 public function ourTeam()
    {
		 
	/*	 $data=DB::table('employeeonboardings')
			 ->join('teammembers','teammembers.personalemail','employeeonboardings.personal_email')
			 ->select('pancard','personal_email')
			 ->get();
		 foreach($data as $dat)
		 {
			$a=DB::table('teammembers')->where('personalemail',$dat->personal_email)->update(['panupload'=>$dat->pancard]);
			 
		 }
		 */
		 //dd($data);
            $teammemberactiveDatas = Teammember::with('title','role')
            ->where('role_id','!=',11)->where('status','!=',0)
           // ->where('relievingstatus','!=',null)
          // ->orderBy('leavingdate', 'desc')
         // ->orderByRaw("DATE_FORMAT('d-m-Y',leavingdate), ASC")
          ->get();
        // dd($teammemberactiveDatas);
            return view('backEnd.teammember.ourteam',compact('teammemberactiveDatas'));
        
    }
	  public function userpasswordotp(Request $request)
    {
      //  dd($request->id); die;
        if ($request->ajax()) {
            if (isset($request->id)) {
            //dd($assignment);
              $teammembers = DB::table('teammembers')
              ->where('id', $request->id)
              ->first();
              //dd($teammembers);
              $otp = sprintf("%06d", mt_rand(1,999999));
              DB::table('users')
              ->where('teammember_id',$teammembers->id)->update([	
                'otp'  => $otp,
                       ]);

       

              $data = array(
             
                'email' => $teammembers->emailid,
                'otp' => $otp,
                'name' => $teammembers->team_member,
        );
       
         Mail::send('emails.userpasswordotp', $data, function ($msg) use($data){
          $msg->to($data['email']);
          $msg->subject('VSA Password Reset Request');
          });

              return response()->json($teammembers);
               }
          }
        }
        public function userotpstore(Request $request )
        {
         $request->validate([
             'otp' => 'required'
         ]);
       
         try {
             $data = $request->except(['_token']);
    
            $otp = DB::table('users')
             ->where('otp',$request->otp)
             ->where('teammember_id',$request->userid)->first();
           //  dd($otp);
             if($otp)
             {
                return redirect('resetpasswords/'.$otp->teammember_id);
                $output = array('msg' => 'assignment closed successfully');
                 return back()->with('success', $output);
               
             }
             else{
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

}
