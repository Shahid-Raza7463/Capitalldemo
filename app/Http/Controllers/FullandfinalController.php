<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Fullandfinal;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class FullandfinalController extends Controller
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

	  public function teammemberDetail(Request $request)
{
    if ($request->ajax()) {
        if (isset($request->category_id)) {
          $client = DB::table('teammembers')->where('id',$request->category_id)->first();
//dd($client);
            return response()->json($client);
         }
        }

}
	public function fullandfinalReminder($id)
    {
      //  dd($id);
        $fullandfinal = DB::table('fullandfinals')
        ->leftjoin('teammembers','teammembers.id','fullandfinals.Name')
        ->leftjoin('teammembers as reporting','reporting.id','fullandfinals.Reporting_Head')
        ->where('fullandfinals.id',$id)->select('fullandfinals.*','teammembers.team_member','reporting.emailid')->first();
       // dd($fullandfinal);
        if ($fullandfinal->Assignment_Data_Hanover != 0 ) {
            $data = array(
                'subject' => 'Reminder Handover Approval for '.' '.$fullandfinal->team_member ??'',
                'id' => $fullandfinal->id ??'',
                'name' => $fullandfinal->team_member ??'',
                'email' =>  $fullandfinal->emailid,
           );
            Mail::send('emails.reportingmail', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->subject($data['subject']);
                $msg->cc('priyankasharma@kgsomani.com');
             });
        }
        if($fullandfinal->Laptop_Hanover != 0 ) {
            $teammemberit = Teammember::where('role_id',16)->where('status',1)->pluck('emailid')->toArray();
            foreach ($teammemberit as $teammemberits ) {
   $data = array(
      'email' => $teammemberits ??'',
      'id' => $fullandfinal->id ??'',
      'name' => $fullandfinal->team_member ??'',
      'subject' => 'Reminder IT Clearance for '.' '.$fullandfinal->team_member ??'',

);

Mail::send('emails.reportingmailit', $data, function ($msg) use($data){
  $msg->to($data['email']);
  $msg->subject($data['subject']);
  $msg->cc('priyankasharma@kgsomani.com');
});
}  
        } if($fullandfinal->fnfstatus != 0) {
            $teammemberacc = Teammember::where('role_id',17)->where('status',1)->pluck('emailid')->toArray();
            foreach ($teammemberacc as $teammemberaccount ) {
   $data = array(
      'email' => $teammemberaccount ??'',
      'id' => $id ??'',
      'name' => $Name->team_member ??'',
      'subject' => 'Reminder Accounts Clearance for '.' '.$fullandfinal->team_member ??'',

);

Mail::send('emails.reportingmailaccount', $data, function ($msg) use($data){
  $msg->to($data['email']);
  $msg->subject($data['subject']);
  $msg->cc('priyankasharma@kgsomani.com');
});
} 
        }
 
         $output = array('msg' => 'Reminder Mail Send Successfully');
         return redirect('fullandfinal')->with('success', $output);
    }
    public function index()
    {
        //  dd($id);
		 if(auth()->user()->teammember_id == 550){
          $fullandfinalDatas  = DB::table('fullandfinals')
          ->leftjoin('teammembers','teammembers.id','fullandfinals.Name')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('fullandfinals.*','teammembers.team_member as Name','roles.rolename')->orderBy('id', 'desc')->get();
  // dd($fullandfinalDatas);
         return view('backEnd.fullandfinal.index',compact('fullandfinalDatas'));
      }
        elseif(auth()->user()->role_id == 17 || auth()->user()->role_id == 11 || auth()->user()->role_id == 18 || auth()->user()->role_id == 16){
          $fullandfinalDatas  = DB::table('fullandfinals')
          ->leftjoin('teammembers','teammembers.id','fullandfinals.Name')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('fullandfinals.*','teammembers.team_member as Name','roles.rolename')->orderBy('id', 'desc')->get();
  // dd($fullandfinalDatas);
         return view('backEnd.fullandfinal.index',compact('fullandfinalDatas'));
      }
      else {
          $fullandfinalDatas  =DB::table('fullandfinals')
          ->leftjoin('teammembers','teammembers.id','fullandfinals.Name')
      
         ->where('Reporting_Head',auth()->user()->teammember_id)
         ->select('fullandfinals.*','teammembers.team_member as Name')->orderBy('id', 'desc')->get();
          return view('backEnd.fullandfinal.index',compact('fullandfinalDatas'));
      }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		   if(auth()->user()->role_id == 18){
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->where('status',0)->get();
			     $reportinghead = Teammember::where('role_id','=',14)->orwhere('role_id','=',13)->with('title','role')->where('status',1)->get();
        return view('backEnd.fullandfinal.create',compact('teammember','reportinghead'));
			     }
        abort(403, ' you have no permission to access this page ');
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
             'Name' => "required|string",
           'Designation' => "required"
       ]);

         try {
             $data=$request->except(['_token']);
             $data['createdby'] = auth()->user()->teammember_id;
             $data['Final_Status_of_Full_and_Final'] = 2;
			    $data['fnfstatus'] = 1;
             $data['Laptop_Hanover'] = 1;
             $data['Assignment_Data_Hanover'] = 1;
           $full =  Fullandfinal::Create($data);
			   DB::table('teammembers')->where('id',$request->Name)->update([	
                'leavingdate'         =>     $request->Date_of_Leaving,
               
                 ]);
                 $full->save();
                 $id = $full->id;

                 $teammembermail = Teammember::where('id',$request->Reporting_Head)->pluck('emailid')->first();
                 $Name = Teammember::where('id',$request->Name)->first();
                 $data = array(
                      'email' => $teammembermail ??'',
                        'id' => $id ??'',
                        'name' => $Name->team_member ??'',
                        'subject' => 'Handover Approval for '.' '.$Name->team_member ??'',
                );
                 Mail::send('emails.reportingmail', $data, function ($msg) use($data){
                     $msg->to($data['email']);
                     $msg->subject($data['subject']);
                     $msg->cc('priyankasharma@kgsomani.com');
                  });

                  $teammemberacc = Teammember::where('role_id',17)->where('status',1)->pluck('emailid')->toArray();
                  foreach ($teammemberacc as $teammemberaccount ) {
         $data = array(
            'email' => $teammemberaccount ??'',
            'id' => $id ??'',
            'name' => $Name->team_member ??'',
            'subject' => 'Accounts Clearance for '.' '.$Name->team_member ??'',

     );
    
     Mail::send('emails.reportingmailaccount', $data, function ($msg) use($data){
        $msg->to($data['email']);
        $msg->subject($data['subject']);
        $msg->cc('priyankasharma@kgsomani.com');
     });
      } 
                  $teammemberit = Teammember::where('role_id',16)->where('status',1)->pluck('emailid')->toArray();
                  foreach ($teammemberit as $teammemberits ) {
         $data = array(
            'email' => $teammemberits ??'',
            'id' => $id ??'',
            'name' => $Name->team_member ??'',
            'subject' => 'IT Clearance for '.' '.$Name->team_member ??'',

     );
    
     Mail::send('emails.reportingmailit', $data, function ($msg) use($data){
        $msg->to($data['email']);
        $msg->subject($data['subject']);
        $msg->cc('priyankasharma@kgsomani.com');
     });
      } 
             $output = array('msg' => 'Create Successfully');
			 return redirect('fullandfinal')->with('success', $output);
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
     * @param  \App\Models\Fullandfinal  $fullandfinal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     //   dd($id);
        $fullandfinal = DB::table('fullandfinals')
              ->leftjoin('teammembers','teammembers.id','fullandfinals.Name')
              ->where('fullandfinals.id',$id)
             ->select('fullandfinals.*','teammembers.team_member as Name')->first();
         //    dd($fullandfinal);
              return view('backEnd.fullandfinal.view', compact('id','fullandfinal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fullandfinal  $fullandfinal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
        $fullandfinal = Fullandfinal::where('id', $id)->first();
  $employee = DB::table('fullandfinals')
        ->leftjoin('teammembers','teammembers.id','fullandfinals.Name')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('fullandfinals.id',$id)
       ->select('teammembers.team_member as Name','roles.rolename')->first();
		 $reportinghead = Teammember::where('role_id','=',14)->orwhere('role_id','=',13)->with('title','role')->where('status',1)->get();
        return view('backEnd.fullandfinal.edit', compact('id','fullandfinal','teammember','employee','reportinghead'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fullandfinal  $fullandfinal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      //  dd($request);
        // $request->validate([
        //     'Name' => "required",
        // ]);
        try {
            $travel = Fullandfinal::where('id', $id)->first();
if($travel->createdby == auth()->user()->teammember_id){
    $data=$request->except(['_token']);
    $data['updatedby'] = auth()->user()->teammember_id;
    Fullandfinal::find($id)->update($data);
}
if(auth()->user()->role_id == 17){
    DB::table('fullandfinals')->where('id', $id)->update([    
        'Final_Status_of_Full_and_Final'         => $request->Final_Status_of_Full_and_Final,
        'remark'         => $request->remark ??'',
        'updated_at'              =>    date('y-m-d'),
        ]);
}
            $output = array('msg' => 'Updated Successfully');
            return redirect('fullandfinal')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function updatestatus(Request $request, $id)
    {
      //  dd($request);
        // $request->validate([
        //     'Name' => "required",
        // ]);
        try {
            $travel = Fullandfinal::where('id', $id)->first();
    $data=$request->except(['_token']);
    $data['updatedby'] = auth()->user()->teammember_id;
    if ($travel->Reporting_Head == auth()->user()->teammember_id) {
        $data['approved_date'] = date('y-m-d');
    }
    Fullandfinal::find($id)->update($data);

if(auth()->user()->role_id == 17){
    DB::table('fullandfinals')->where('id', $id)->update([    
        'Final_Status_of_Full_and_Final'         => $request->Final_Status_of_Full_and_Final,
        'remark'         => $request->remark ??'',
        'updated_at'              =>    date('y-m-d'),
        ]);
}
            $output = array('msg' => 'Updated Successfully');
            return redirect('fullandfinal')->with('success', $output);
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
     * @param  \App\Models\Fullandfinal  $fullandfinal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fullandfinal $fullandfinal)
    {
        //
    }
}
