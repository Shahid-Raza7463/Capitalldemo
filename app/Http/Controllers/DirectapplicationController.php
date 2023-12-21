<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Candidateonboarding;
use App\Models\Employeeonboarding;
use App\Models\Teammember;
use App\Models\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class DirectapplicationController extends Controller
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
    public function index()
    {
        
    
	}
    public function articleship()
    {
        if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
	   $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->with('role')->get();
        // dd($team);
     $articleship = DB::table('Home_articleship')
     ->leftjoin('teammembers','teammembers.id','Home_articleship.interviewerone')
     ->select('Home_articleship.*','teammembers.team_member')->get();   
    return view('backEnd.directapplication.articleship',compact('team','articleship'));
    
	}
}
    public function internship()
    {
        if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
	   $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->with('role')->get();
        // dd($team);
     $internship = DB::table('Home_internship')
     ->leftjoin('teammembers','teammembers.id','Home_internship.interviewerone')
     ->select('Home_internship.*','teammembers.team_member')->get();   
    return view('backEnd.directapplication.internship',compact('team','internship'));
    
	}
}
    public function otherapplications()
    {
        if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
	   $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->with('role')->get();
        // dd($team);
     $other = DB::table('Home_apply_for_others')
     ->leftjoin('teammembers','teammembers.id','Home_apply_for_others.interviewerone')
     ->select('Home_apply_for_others.*','teammembers.team_member')->get();   
    return view('backEnd.directapplication.other',compact('team','other'));
   }
	}
    
    public function caapplication()
    {
        
        if(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
            $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->orwhere('role_id','18')->with('role')->get();
           // dd($team);
           $caapplication = DB::table('Home_chartered_accountant')
           ->leftjoin('teammembers','teammembers.id','Home_chartered_accountant.interviewerone')->
           select('Home_chartered_accountant.*','teammembers.team_member')->get();
       return view('backEnd.directapplication.chartered',compact('team','caapplication'));
  
    }

	}
	  
    public function create()
    {
        $teammember = Teammember::where('role_id','!=',11)->where('status',1)->where('role_id','!=',15)
		->where('id','!=',310)->with('title','role')->get();

        return view('backEnd.directapplication.create',compact('teammember'));
    }
    public function store(Request $request)
    {
     //   dd($request);
        //   $request->validate([
        //        'taskname' => "required",
        //      'duedate' => "required"
        //  ]);

           try {
               $data=$request->except(['_token']);
               if($request->hasFile('resume'))
               {
                        $file=$request->file('resume');
                       $destinationPath =  'backEnd/documents/directapplications';
                       $name = time().$file->getClientOriginalName();
                      $s = $file->move($destinationPath, $name);
                            $data['resume'] = $name;
               }
             //  dd($data['jobprofile']);
        if ($request->type == 0) {
           DB::table('Home_articleship')->insert([	
              'applied_on'     =>     $request->applied_on, 
              'mrn_nro_cro_wro'  =>     $request->mrn_nro_cro_wro,
               'name'         =>     $request->name, 	
               'email'     =>     $request->email, 	
               'contact_no'   =>     $request->contact_no, 
               'age'   =>     $request->age, 
               'scheme'   =>     $request->scheme, 
               'jobprofile'   =>     $request->jobprofile, 
               'resume'   =>     $data['resume'], 
               'highest_qualification'   =>     $request->highest_qualification, 
               'other_certification_course'   =>     $request->other_certification_course, 
               'experience'   =>     $request->experience, 
               'reference'   =>     $request->reference, 
               'hrcomment'   =>     $request->hrcomment, 
            //    'interviewerone'   =>     $request->interviewerone, 
            //    'ratingone'   =>     $request->ratingone, 
            //    'feedbackone'   =>     $request->feedbackone, 
            //    'interviewertwo'   =>     $request->interviewertwo, 
            //    'ratingtwo'   =>     $request->ratingtwo, 
            //    'feedbacktwo'   =>     $request->feedbacktwo, 
               'type'        =>     '1', 
               'created_at'			    =>	   date('Y-m-d H:i:s'),
              'updated_at'              =>    date('Y-m-d H:i:s'),
              ]);
            }
            elseif($request->type == 1){
                DB::table('Home_internship')->insert([	
                    'applied_on'     =>     $request->applied_on, 
                    'mrn_nro_cro_wro'  =>     $request->mrn_nro_cro_wro,
                     'name'         =>     $request->name, 	
                     'email'     =>     $request->email, 	
                     'contact_no'   =>     $request->contact_no, 
                     'age'   =>     $request->age, 
                     'scheme'   =>     $request->scheme, 
                     'jobprofile'   =>     $request->jobprofile, 
                     'resume'   =>     $data['resume'], 
                     'highest_qualification'   =>     $request->highest_qualification, 
                     'other_certification_course'   =>     $request->other_certification_course, 
                     'work_experience'   =>     $request->experience, 
                     'reference'   =>     $request->reference, 
                     'hrcomment'   =>     $request->hrcomment, 
                     'type'        =>     '1', 
                   
                    ]);
              }
              elseif($request->type == 2){

                DB::table('Home_chartered_accountant')->insert([	 
                   'applied_on'     =>     $request->applied_on, 
                   'mrn_nro_cro_wro'  =>     $request->mrn_nro_cro_wro,
                    'name'         =>     $request->name, 	
                    'email'     =>     $request->email, 	
                    'contact_no'   =>     $request->contact_no, 
                    'age'   =>     $request->age, 
                    'scheme'   =>     $request->scheme, 
                    'jobprofile'   =>     $request->jobprofile, 
                    'resume'   =>     $data['resume'], 
                    'highest_qualification'   =>     $request->highest_qualification, 
                    'other_certification_course'   =>     $request->other_certification_course, 
                    'work_experience'   =>     $request->experience, 
                    'reference'   =>     $request->reference, 
                    'hrcomment'   =>     $request->hrcomment, 
                    // 'interviewerone'   =>     $request->interviewerone, 
                    // 'ratingone'   =>     $request->ratingone, 
                    // 'feedbackone'   =>     $request->feedbackone, 
                    // 'interviewertwo'   =>     $request->interviewertwo, 
                    // 'ratingtwo'   =>     $request->ratingtwo, 
                    // 'feedbacktwo'   =>     $request->feedbacktwo, 
                    // 'status'   =>     '0', 
                    'type'        =>     '1', 
                    'created_at'			    =>	   date('Y-m-d H:i:s'),
                   'updated_at'              =>    date('Y-m-d H:i:s'),
                   ]);
              }
              else{

                DB::table('Home_apply_for_others')->insert([	
                    'applied_on'     =>     $request->applied_on, 
                    'mrn_nro_cro_wro'  =>     $request->mrn_nro_cro_wro,
                     'name'         =>     $request->name, 	
                     'email'     =>     $request->email, 	
                     'contact_no'   =>     $request->contact_no, 
                     'age'   =>     $request->age, 
                     'scheme'   =>     $request->scheme, 
                     'jobprofile'   =>     $request->jobprofile, 
                     'resume'   =>     $data['resume'], 
                     'highest_qualification'   =>     $request->highest_qualification, 
                     'other_certification_course'   =>     $request->other_certification_course, 
                     'work_experience'   =>     $request->experience, 
                     'reference'   =>     $request->reference, 
                     'hrcomment'   =>     $request->hrcomment, 
                     'type'        =>     '1', 
                     'status'   =>     '0', 
                     'created_at'			    =>	   date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                    ]);
              }
   
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

//    public function show()
//    {

//    }
   public function articleshipDetails ($sno)
   {
     $articleship = DB::table('Home_articleship')->where('sno',$sno)->first();
     return view('backEnd.directapplication.articleshipview',compact('articleship'));
   }
     public function caDetails ($sno)
   {
     $ca = DB::table('Home_chartered_accountant')->where('sno',$sno)->first();
     return view('backEnd.directapplication.caview',compact('ca'));
   }
   public function internshipDetails ($sno)
  {
  $internship = DB::table('Home_internship')->where('sno',$sno)->first();
  return view('backEnd.directapplication.internshipview',compact('internship'));
 }
 public function otherdetails ($sno)
 {
 $other = DB::table('Home_apply_for_others')->where('sno',$sno)->first();
 return view('backEnd.directapplication.otherview',compact('other'));
}
   public function interviewintenshipResume(Request $request)
   {
     // dd($request);
       if ($request->ajax()) {
           if (isset($request->id)) {
            //   dd($request->id);
             $conversion = DB::table('Home_internship')
           ->where('sno',$request->id)->first();
         //  dd($conversion);
               return response()->json($conversion);
            }
           }
   
   }
   public function otherResume(Request $request)
   {
     // dd($request);
       if ($request->ajax()) {
           if (isset($request->id)) {
            //   dd($request->id);
             $conversion = DB::table('Home_apply_for_others')
           ->where('sno',$request->id)->first();
         //  dd($conversion);
               return response()->json($conversion);
            }
           }
   
   }

   public function internshipforwardResume(Request $request)
   { 
   //  dd($request);
       // $request->validate([
       //     'companyname' => "required",
       // ]);

       try {
        $Home_internship = DB::table('Home_internship')->where('sno',$request->sno)->pluck('resume')->first();
     //    dd($Home_articleship);
            if($request->interviewerone !=  null){
             DB::table('Home_internship')->where('sno',$request->sno)->update([	
               'interviewerone'         =>     $request->interviewerone ??'',
               'jobprofile'         =>     $request->jobprofile ??'',
                ]);
            $teammembermail = Teammember::where('id',$request->interviewerone)->first();
            }
            elseif($request->interviewertwo != null){
             DB::table('Home_internship')->where('sno',$request->sno)->update([	
               'interviewertwo'         =>     $request->interviewertwo ??'',
               'jobprofile'         =>     $request->jobprofile ??'',
                ]);
             $teammembermail = Teammember::where('id',$request->interviewertwo)->first();
            }
           if($request->hrcomment !=  null){
        DB::table('Home_internship')->where('sno',$request->sno)->update([	
        'hrcomment'         =>     $request->hrcomment ??'',
          ]);
         }
             if($request->interviewertwo != null || $request->interviewerone !=  null){
            $data = array(
                 'email' => $teammembermail->emailid ??'',
                   'sno' => $request->sno ??'',
                   'file' => 'backEnd/documents/directapplications/'.$Home_internship,
           );
            Mail::send('emails.internshipform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->cc('priyankasharma@kgsomani.com');
                $msg->subject('internship Resume');
                $msg->attach($data['file']);
             }); 
       }
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
public function otherforwardResume(Request $request)
   { 
   //  dd($request);
       // $request->validate([
       //     'companyname' => "required",
       // ]);

       try {
        $other = DB::table('Home_apply_for_others')->where('sno',$request->sno)->pluck('resume')->first();
     //    dd($Home_articleship);
            if($request->interviewerone !=  null){
             DB::table('Home_apply_for_others')->where('sno',$request->sno)->update([	
               'interviewerone'         =>     $request->interviewerone ??'',
               'jobprofile'         =>     $request->jobprofile ??'',
                ]);
            $teammembermail = Teammember::where('id',$request->interviewerone)->first();
            }
            elseif($request->interviewertwo != null){
             DB::table('Home_apply_for_others')->where('sno',$request->sno)->update([	
               'interviewertwo'         =>     $request->interviewertwo ??'',
               'jobprofile'         =>     $request->jobprofile ??'',
                ]);
             $teammembermail = Teammember::where('id',$request->interviewertwo)->first();
            }
           if($request->hrcomment !=  null){
        DB::table('Home_apply_for_others')->where('sno',$request->sno)->update([	
        'hrcomment'         =>     $request->hrcomment ??'',
          ]);
         }
             if($request->interviewertwo != null || $request->interviewerone !=  null){
            $data = array(
                 'email' => $teammembermail->emailid ??'',
                   'sno' => $request->sno ??'',
                   'file' => 'backEnd/documents/directapplications/'.$other,
           );
            Mail::send('emails.otherform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->cc('priyankasharma@kgsomani.com');
                $msg->subject('Other Resume');
                $msg->attach($data['file']);
             }); 
       }
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
public function internstatusUpdate (Request $request)
{
  // dd($request);
  //    $request->validate([
  //        'rating' => "required",
  //    ]);
     try {
       DB::table('Home_internship')->where('sno',$request->sno)->update([	
         'status'         =>     $request->status ??'',
          ]);
      $output = array('msg' => 'Status Update Successfully');
      return back()->with('success', $output);

  } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
  }
 }
 public function otherstatusUpdate (Request $request)
{
  // dd($request);
  //    $request->validate([
  //        'rating' => "required",
  //    ]);
     try {
       DB::table('Home_apply_for_others')->where('sno',$request->sno)->update([	
         'status'         =>     $request->status ??'',
          ]);
      $output = array('msg' => 'Status Update Successfully');
      return back()->with('success', $output);

  } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
  }
 }
 public function internRating (Request $request)
 {
  // dd($request->sno);
     $request->validate([
         'rating' => "required",
     ]);
     try {
      $one = DB::table('Home_internship')->where('sno',$request->sno)
      ->where('interviewerone',auth()->user()->teammember_id)->first();
     // dd($one);
     if($one != null){
       DB::table('Home_internship')->where('sno',$request->sno)->update([	
         'ratingone'         =>     $request->rating ??'',
         'feedbackone'         =>     $request->feedback ??'',
       
          ]);
     }
     else {
       DB::table('Home_internship')->where('sno',$request->sno)->update([	
         'ratingtwo'         =>     $request->rating ??'',
         'feedbacktwo'         =>     $request->feedback ??'',
          ]);
     }
      
       
      $output = array('msg' => 'Rating Update Successfully');
      return back()->with('success', $output);

  } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
  }
 }
 public function otherRating (Request $request)
 {
  // dd($request->sno);
     $request->validate([
         'rating' => "required",
     ]);
     try {
      $one = DB::table('Home_apply_for_others')->where('sno',$request->sno)
      ->where('interviewerone',auth()->user()->teammember_id)->first();
     // dd($one);
     if($one != null){
       DB::table('Home_apply_for_others')->where('sno',$request->sno)->update([	
         'ratingone'         =>     $request->rating ??'',
         'feedbackone'         =>     $request->feedback ??'',
       
          ]);
     }
     else {
       DB::table('Home_apply_for_others')->where('sno',$request->sno)->update([	
         'ratingtwo'         =>     $request->rating ??'',
         'feedbacktwo'         =>     $request->feedback ??'',
          ]);
     }
      
       
      $output = array('msg' => 'Rating Update Successfully');
      return back()->with('success', $output);

  } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
  }
 }
}
