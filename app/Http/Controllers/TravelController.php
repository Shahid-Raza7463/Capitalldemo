<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use App\Models\Teammember;
use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
class TravelController extends Controller
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
       if(auth()->user()->teammember_id == 23 || auth()->user()->teammember_id == 161){
		     $travelDatas  =DB::table('travel')
            ->leftjoin('teammembers','teammembers.id','travel.teammember_id')
            ->leftjoin('assignments','assignments.id','travel.assignment_id')
                 ->leftjoin('clients','clients.id','travel.client_id')
                 ->select('travel.*','teammembers.team_member','clients.client_name','assignments.assignment_name  as assignmentsname')->orderBy('id', 'desc')->get();
      return view('backEnd.travel.travelindex',compact('travelDatas'));
	   }
        elseif(auth()->user()->role_id == 17 || auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
            $travelDatas  =DB::table('travel')
            ->leftjoin('teammembers','teammembers.id','travel.teammember_id')
            ->leftjoin('assignments','assignments.id','travel.assignment_id')
                 ->leftjoin('clients','clients.id','travel.client_id')
                 ->select('travel.*','teammembers.team_member','clients.client_name','assignments.assignment_name  as assignmentsname')->orderBy('id', 'desc')->get();
      return view('backEnd.travel.travelindex',compact('travelDatas'));
      }
      else {
          $travelDatas  =DB::table('travel')
          ->leftjoin('teammembers','teammembers.id','travel.teammember_id')
          ->leftjoin('assignments','assignments.id','travel.assignment_id')
			   ->leftjoin('clients','clients.id','travel.client_id')
               ->where('createdby',auth()->user()->teammember_id)
               ->select('travel.*','teammembers.team_member','clients.client_name','assignments.assignment_name  as assignmentsname')->orderBy('id', 'desc')->get();
          $travelapprovedDatas  =DB::table('travel')
          ->leftjoin('teammembers','teammembers.id','travel.teammember_id')
          ->leftjoin('assignments','assignments.id','travel.assignment_id')
			   ->leftjoin('clients','clients.id','travel.client_id')
        ->where('teammember_id',auth()->user()->teammember_id)
               ->select('travel.*','teammembers.team_member','clients.client_name','assignments.assignment_name  as assignmentsname')->orderBy('id', 'desc')->get();
          return view('backEnd.travel.index',compact('travelDatas','travelapprovedDatas'));
      }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
		  $client =  DB::table('clients')->distinct()->get();
        $teammember = Teammember::where('role_id','=',13)->orwhere('role_id','=',14)->with('title','role')
        ->orwhere('id',auth()->user()->teammember_id)
        ->get();
        $authteammember = Teammember::where('role_id','!=',11)->with('title','role')->
        where('id',auth()->user()->teammember_id)->get();
        return view('backEnd.travel.create',compact('teammember','client','authteammember'));
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
            'client_id' => "required",
        ]);

        try {
            $data=$request->except(['_token','attachment']);
            $data['createdby'] = auth()->user()->teammember_id;
            $data['travelstatus'] = 0;
			     $data['adjustablestatus'] = 0;
			    $data['Status'] = 2;
            $travelModel =  Travel::Create($data);
            $travelModel->save();
            $id = $travelModel->id;
            $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
			     $files = [];
            if($request->hasFile('attachment'))
            {
                
                foreach ($request->file('attachment') as $file) {

                    $destinationPath = 'backEnd/image/travel';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                    $files[] = $name;
                    // $data['url'] = $name;
                 
                }
               
            }
            foreach($files as $filess )
            {
         
               $s = DB::table('travelattachments')->insert([
                    'travel_id' => $id, 
                    'attachment' => $filess,
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);      
            }
            $travel = Travel::where('id', $id)->first();
            $teammembermail = Teammember::where('id',$request->teammember_id)->pluck('emailid')->first();
            $teammemberccmail = Teammember::where('role_id',18)->pluck('emailid')->toArray();
            $data = array(
                'teammember' => $teammember->team_member ??'',
                   'teammembermail' => $teammemberccmail ??'',
                   'email' => $teammembermail ??'',
                   'id' => $id ??'',
                   'EmployeeID' => $travel->Client_Name ??'',
           );
            Mail::send('emails.travelform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->cc('hr@kgsomani.com');
                $msg->subject('Kgs Advance Claim Form Request');
             }); 
            $output = array('msg' => 'Create Successfully');
            return redirect('travel')->with('success', $output);
        
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
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
     public function show($id)
    {
        $travel = DB::table('travel')
        ->leftjoin('teammembers','teammembers.id','travel.teammember_id')
        ->leftjoin('assignments','assignments.id','travel.assignment_id')
			  ->leftjoin('clients','clients.id','travel.client_id')
       ->where('travel.id',$id)
             ->select('travel.*','teammembers.team_member','clients.client_name','assignments.assignment_name  as assignmentsname')->first();
         //    dd($travel);
         return view('backEnd.travel.view', compact('id','travel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teammember = Teammember::where('role_id','=',13)->orwhere('role_id','=',14)->with('title','role')
        ->orwhere('id',auth()->user()->teammember_id)
        ->get();
        $authteammember = Teammember::where('role_id','!=',11)->with('title','role')->
        where('id',auth()->user()->teammember_id)->get();
        $travel = Travel::with('travelattachment')->where('id', $id)->first();
		 $client = Client::latest()->get();
        return view('backEnd.travel.edit', compact('id','travel','teammember','client','authteammember'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // dd($request);
        // $request->validate([
        //     'teammember_id' => "required",
        // ]);
        try {
            $travel = Travel::where('id', $id)->first();
            $teammembermail = Teammember::where('id',$travel->createdby)->first();
            $teammembersmail = Teammember::where('id',$travel->teammember_id)->pluck('emailid')->first();
            $teammemberccmail = Teammember::where('role_id',18)->pluck('emailid')->toArray();
            $teammemberaccountant = Teammember::where('role_id',17)->pluck('emailid')->toArray();
           
    $data=$request->except(['_token']);
    $data['updatedby'] = auth()->user()->teammember_id;
    Travel::find($id)->update($data);

if(auth()->user()->role_id == 17){
    DB::table('travel')->where('id', $id)->update([          
        'Advance_Amount'         => $request->Advance_Amount,
        'Status'         => $request->Status,
        'comment'         => $request->comment,
        'updated_at'              =>    date('y-m-d'),
        ]);
//         $data = array(
//             'teammembermail' => $teammemberccmail ??'',
//             'email' => $teammembermail->emailid ??'',
//             'emails' => $teammembersmail ??'',
//     );
//      Mail::send('emails.travelform', $data, function ($msg) use($data){
//          $msg->to($data['email']);
//          $msg->subject('Kgs Travel Form ');
// $msg->cc($data['teammembermail']);
// $msg->bcc($data['emails']);
//       });
}
if($travel->teammember_id == auth()->user()->teammember_id){
    DB::table('travel')->where('id', $id)->update([          
        'travelstatus'         => $request->travelstatus,
        'remark'         => $request->remark,
        'updated_at'              =>    date('y-m-d'),
        ]);
 if($request->travelstatus == 1)
        {
            $data = array(
                'teammembermail' => $teammemberccmail ??'',
                'email' => $teammembermail->emailid ??'',
                'teammemberaccountant' => $teammemberaccountant ??'',
                'teammember' => $teammembermail->team_member ??'',
                'place' => $travel->Place_of_visit ??'',
                'id' => $travel->id ??'',
                   'EmployeeID' => $travel->Client_Name ??'',
        );
      //  dd($data['teammemberaccountant'],$data['teammembermail']);
         Mail::send('emails.travelapprovedform', $data, function ($msg) use($data, $travel){
             $msg->to(array_merge($data['teammembermail'],$data['teammemberaccountant']));
             $msg->subject('Kgs Advance Claim Approved');
    $msg->cc($data['email']);
    });
        }
 if($request->travelstatus == 2)
        {
            $data = array(
                'teammembermail' => $teammemberccmail ??'',
                'email' => $teammembermail->emailid ??'',
                'teammemberaccountant' => $teammemberaccountant ??'',
                'teammember' => $teammembermail->team_member ??'',
                'place' => $travel->Place_of_visit ??'',
                'id' => $travel->id ??'',
                'EmployeeID' => $travel->Client_Name ??'',

        );
         Mail::send('emails.travelrejectform', $data, function ($msg) use($data, $travel){
            $msg->to(array_merge($data['teammembermail'],$data['teammemberaccountant']));
             $msg->subject('Kgs Advance Claim Rejected');
    $msg->cc($data['email']);
    });
        }
      
}
          

            $output = array('msg' => 'Updated Successfully');
            return redirect('travel')->with('success', $output);
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
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Travel $travel)
    {
        //
    }
    public function transaction(Request $request)
 {
        if ($request->ajax()) {
            if (isset($request->cid)) {
                
                  $client = DB::table('travel')->orderBy('assignmentgenerate_id', 'DESC')
					  ->where('client_id',$request->cid)->first();
  // dd($client->assignmentgenerate_id);
                return response()->json($client);
             }
            }
    
    }
}
