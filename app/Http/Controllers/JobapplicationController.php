<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\ContractandSubscription;
use App\Models\Teammember;
use App\Models\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class JobapplicationController extends Controller
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
    public function interviewResume(Request $request)
    {
      // dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
             //   dd($request->id);
              $conversion = DB::table('Home_articleship')
            ->where('sno',$request->id)->first();
          //  dd($conversion);
                return response()->json($conversion);
             }
            }
    
    }
    public function interviewcaResume(Request $request)
    {
      // dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
             //   dd($request->id);
              $conversion = DB::table('Home_chartered_accountant')
            ->where('sno',$request->id)->first();
          //  dd($conversion);
                return response()->json($conversion);
             }
            }
    
    }
	
    public function forwardResume(Request $request)
    { 
    //  dd($request);
        // $request->validate([
        //     'companyname' => "required",
        // ]);

        try {
         $Home_articleship = DB::table('Home_articleship')->where('sno',$request->sno)->pluck('resume')->first();
          //dd($Home_articleship);
             if($request->interviewerone !=  null){
              DB::table('Home_articleship')->where('sno',$request->sno)->update([	
                'interviewerone'         =>     $request->interviewerone ??'',
                'jobprofile'         =>     $request->jobprofile ??'',
                 ]);
             $teammembermail = Teammember::where('id',$request->interviewerone)->first();
             }
             elseif($request->interviewertwo != null){
              DB::table('Home_articleship')->where('sno',$request->sno)->update([	
                'interviewertwo'         =>     $request->interviewertwo ??'',
                'jobprofile'         =>     $request->jobprofile ??'',
                 ]);
              $teammembermail = Teammember::where('id',$request->interviewertwo)->first();
             }
			if($request->hrcomment !=  null){
         DB::table('Home_articleship')->where('sno',$request->sno)->update([	
         'hrcomment'         =>     $request->hrcomment ??'',
           ]);
          }
			  if($request->interviewertwo != null || $request->interviewerone !=  null){
            $type=DB::table('Home_chartered_accountant')->where('sno',$request->sno)->pluck('type')->first();
				// dd($type);
				 if($type!=NULL)
				 {
					 			 
				 $data = array(
					  'email' => $teammembermail->emailid ??'',
						'sno' => $request->sno ??'',
						'file' => 'backEnd/documents/directapplications/'.$Home_articleship,
				);

				 }
				 else
				 {
					 
				 $data = array(
					  'email' => $teammembermail->emailid ??'',
						'sno' => $request->sno ??'',
						'file' => 'https://kgsomani.com/media/'.$Home_articleship,
				);
			 }
				  Mail::send('emails.interviewerform', $data, function ($msg) use($data){
                 $msg->to($data['email']);
                 $msg->cc('priyankasharma@kgsomani.com');
                 $msg->subject('Article Resume');
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
public function caforwardResume(Request $request)
{ 
//  dd($request);
    // $request->validate([
    //     'companyname' => "required",
    // ]);

    try {
     $Home_articleship = DB::table('Home_chartered_accountant')->where('sno',$request->sno)->pluck('resume')->first();
      //dd($Home_articleship);
         if($request->interviewerone !=  null){
          DB::table('Home_chartered_accountant')->where('sno',$request->sno)->update([	
            'interviewerone'         =>     $request->interviewerone ??'',
            'jobprofile'         =>     $request->jobprofile ??'',
             ]);
         $teammembermail = Teammember::where('id',$request->interviewerone)->first();
         }
         elseif($request->interviewertwo != null){
          DB::table('Home_chartered_accountant')->where('sno',$request->sno)->update([	
            'interviewertwo'         =>     $request->interviewertwo ??'',
            'jobprofile'         =>     $request->jobprofile ??'',
             ]);
          $teammembermail = Teammember::where('id',$request->interviewertwo)->first();
         }
		if($request->hrcomment !=  null){
         DB::table('Home_chartered_accountant')->where('sno',$request->sno)->update([	
         'hrcomment'         =>     $request->hrcomment ??'',
           ]);
          }
		     if($request->interviewertwo != null || $request->interviewerone !=  null){
				 
				 $type=DB::table('Home_chartered_accountant')->where('sno',$request->sno)->pluck('type')->first();
				// dd($type);
				 if($type!=NULL)
				 {
					 			 
				 $data = array(
					  'email' => $teammembermail->emailid ??'',
						'sno' => $request->sno ??'',
						'file' => 'backEnd/documents/directapplications/'.$Home_articleship,
				);

				 }
				 else
				 {
					 
				 $data = array(
					  'email' => $teammembermail->emailid ??'',
						'sno' => $request->sno ??'',
						'file' => 'https://kgsomani.com/media/'.$Home_articleship,
				);
			 }
         Mail::send('emails.cainterviewerform', $data, function ($msg) use($data){
             $msg->to($data['email']);
             $msg->cc('priyankasharma@kgsomani.com');
             $msg->subject('Ca Resume');
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
	   public function castatusUpdate (Request $request)
    {
      // dd($request);
      //    $request->validate([
      //        'rating' => "required",
      //    ]);
         try {
           DB::table('Home_chartered_accountant')->where('sno',$request->sno)->update([	
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
    public function articlestatusUpdate (Request $request)
    {
      // dd($request);
      //    $request->validate([
      //        'rating' => "required",
      //    ]);
         try {
           DB::table('Home_articleship')->where('sno',$request->sno)->update([	
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
	 public function caRating (Request $request)
    {
     // dd($request->sno);
        $request->validate([
            'rating' => "required",
        ]);
        try {
         $one = DB::table('Home_chartered_accountant')->where('sno',$request->sno)
         ->where('interviewerone',auth()->user()->teammember_id)->first();
        // dd($one);
        if($one != null){
          DB::table('Home_chartered_accountant')->where('sno',$request->sno)->update([	
            'ratingone'         =>     $request->rating ??'',
            'feedbackone'         =>     $request->feedback ??'',
          
             ]);
        }
        else {
          DB::table('Home_chartered_accountant')->where('sno',$request->sno)->update([	
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
    public function articleRating (Request $request)
    {
     // dd($request->sno);
        $request->validate([
            'rating' => "required",
        ]);
        try {
         $one = DB::table('Home_articleship')->where('sno',$request->sno)
         ->where('interviewerone',auth()->user()->teammember_id)->first();
        // dd($one);
        if($one != null){
          DB::table('Home_articleship')->where('sno',$request->sno)->update([	
            'ratingone'         =>     $request->rating ??'',
            'feedbackone'         =>     $request->feedback ??'',
          
             ]);
        }
        else {
          DB::table('Home_articleship')->where('sno',$request->sno)->update([	
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
    public function articleshipDetails ($sno)
    {
      $articleship = DB::table('Home_articleship')->where('sno',$sno)->first();
      return view('backEnd.jobapplication.articleshipview',compact('articleship'));
    }
      public function caDetails ($sno)
    {
      $ca = DB::table('Home_chartered_accountant')->where('sno',$sno)->first();
      return view('backEnd.jobapplication.caview',compact('ca'));
    }
    public function articleship (Request $request)
    {
		 if(auth()->user()->teammember_id == 434 ||  auth()->user()->teammember_id == 429){
      $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->with('role')->get();
     // dd($team);
  $articleship = DB::table('Home_articleship')
  ->leftjoin('teammembers','teammembers.id','Home_articleship.interviewerone')->
  select('Home_articleship.*','teammembers.team_member')->get();
    return view('backEnd.jobapplication.articleship',compact('articleship','team'));
      }
      elseif(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
      $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->with('role')->get();
     // dd($team);
  $articleship = DB::table('Home_articleship')
  ->leftjoin('teammembers','teammembers.id','Home_articleship.interviewerone')->
  select('Home_articleship.*','teammembers.team_member')->get();
    return view('backEnd.jobapplication.articleship',compact('articleship','team'));
      }
      else
      {
        $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->with('role')->get();
        // dd($team);
     $articleship = DB::table('Home_articleship')->where('interviewerone',auth()->user()->teammember_id)
     ->orwhere('interviewertwo',auth()->user()->teammember_id)->get();
       return view('backEnd.jobapplication.articleship',compact('articleship','team'));
      }
    
  }
  public function internship(Request $request)
    {
        
   $internship = DB::connection('mysql2')->table('Home_internship')->get();
         return view('backEnd.jobapplication.internship',compact('internship'));

  }
  public function caapplication(Request $request)
    {
         
      $caapplicationdistinct = DB::table('Home_chartered_accountant')
         ->select('Home_chartered_accountant.jobprofile')->distinct()->get();
	  
        if(auth()->user()->teammember_id == 434 || auth()->user()->teammember_id == 429){
			 $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->orwhere('role_id','18')->with('role')->get();
         // dd($team);
         $caapplication = DB::table('Home_chartered_accountant')
         ->leftjoin('teammembers','teammembers.id','Home_chartered_accountant.interviewerone')->
         select('Home_chartered_accountant.*','teammembers.team_member')->get();
                return view('backEnd.jobapplication.caapplication',compact('caapplication','team','caapplicationdistinct'));
		}
         elseif(auth()->user()->role_id == 18 || auth()->user()->role_id == 11 ){
          $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->orwhere('role_id','18')->with('role')->get();
         // dd($team);
         $caapplication = DB::table('Home_chartered_accountant')
         ->leftjoin('teammembers','teammembers.id','Home_chartered_accountant.interviewerone')->
         select('Home_chartered_accountant.*','teammembers.team_member')->get();
                return view('backEnd.jobapplication.caapplication',compact('caapplication','team','caapplicationdistinct'));
          }
          else
          {
            $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->with('role')->get();
            // dd($team);
         $caapplication = DB::table('Home_chartered_accountant')->where('interviewerone',auth()->user()->teammember_id)
         ->orwhere('interviewertwo',auth()->user()->teammember_id)->get();
           return view('backEnd.jobapplication.caapplication',compact('caapplication','team','caapplicationdistinct'));
          }
  }
  public function other(Request $request)
  {
       
 $others = DB::connection('mysql2')->table('Home_apply_for_others')->get();
       return view('backEnd.jobapplication.other',compact('others'));

}
	public function caapplicationsearch(Request $request )
    {
      // dd($request);
      $caapplicationdistinct = DB::table('Home_chartered_accountant')
         ->select('Home_chartered_accountant.jobprofile')->distinct()->get();

         $team = Teammember::where('status',1)->where('role_id','13')->orwhere('role_id','14')->orwhere('role_id','18')->with('role')->get();
         // dd($team);
         $caapplication = DB::table('Home_chartered_accountant')
         ->where('jobprofile',$request->search)
         ->get();
//dd($caapplicationdistinct);
                return view('backEnd.jobapplication.caapplication',compact('caapplication','team','caapplicationdistinct'));
      
    }

        
}
