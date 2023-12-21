<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
class ProposalController extends Controller
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
      
    if(auth()->user()->role_id == 11){       
      $proposalDatas = DB::table('proposals')
      ->leftjoin('teammembers','teammembers.id','proposals.sendby')
    ->select('proposals.*','teammembers.team_member')->get();
    return view('backEnd.proposal.index',compact('proposalDatas')); 
     // dd($profileDatas);

       } else {
      
        $proposalDatas = DB::table('proposals')
        ->leftjoin('teammembers','teammembers.id','proposals.sendby')
        ->where('proposals.createdby',auth()->user()->teammember_id)
        ->orwhere('proposals.sendby',auth()->user()->teammember_id)
         ->select('proposals.*','teammembers.team_member')->get();
    
     return view('backEnd.proposal.index',compact('proposalDatas'));       
     }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        $teammember = Teammember::with('role:id,rolename')
        ->where('status','1')->orwhere('role_id','13')->orwhere('role_id','14')->get();   
        return view('backEnd.proposal.create',compact('teammember'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

 public function store(Request $request)
 {
//   dd($request);
       $request->validate([
            'sendby' => "required",
          'to' => "required",
      ]);

        try {
          
        $proposalid=DB::table('proposals')->insertGetId([	
            'sendby'         =>     $request->sendby, 
           'to'         =>     $request->to, 
			 'nameofservice'         =>     $request->nameofservice, 
           'status'         =>    0, 
           'createdby'         =>     auth()->user()->teammember_id, 	
           'created_at'			    =>	  date('Y-m-d H:i:s'),
           'updated_at'              =>    date('Y-m-d H:i:s'),
           ]);
           if($request->has('attachment'))
               {
               foreach ($request->attachment as $attachments ) 
               {
                    $attachment=$attachments;
                    $extension=$attachment->getClientOriginalExtension();
                    $filename=time().'.'.$extension;
                    $attachment->move('backEnd/image/proposal/',$filename);
                   $data['attachment']=$filename;
                  
                DB::table('proposaattachments')->insert([
                  'proposal_id' => $proposalid, 
                    'attachment' =>   $data['attachment'] ??'',
                    'created_at' =>	   date('Y-m-d'),
                    'updated_at' =>    date('y-m-d'),
                ]);

            }
             }
             $teammembers = Teammember::where('id',$request->sendby)->first();
           //  dd($teammembers);
          // $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
           $data = array(
               'teammember' => $teammembers->team_member ??'',
               'emailid' => $teammembers->emailid ??'',
               'id' => $proposalid ??'',
       );
        Mail::send('emails.proposalform', $data, function ($msg) use($data , $request){
            $msg->to($data['emailid']);
            $msg->subject('Proposal Request');
         });
            
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
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //dd($id);
        $proposal = DB::table('proposals')
        ->leftjoin('teammembers','teammembers.id','proposals.sendby')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('proposals.id',$id)
       ->select('proposals.*','teammembers.team_member','roles.rolename')->first();

         return view('backEnd.proposal.view', compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     //   $client = Client::select('id','client_name')->get();
        $applyleave = Applyleave::where('id', $id)->first();
        $leavetype = Leavetype::select('id','name')->get();
      //  $leavetype = Leavetype::latest()->get();
        $teammember = Teammember::select('id','team_member')->get();
        $teammember = Teammember::latest()->get();
        // dd($fullandfinal);
         return view('backEnd.applyleave.edit', compact('id','applyleave','teammember','leavetype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     // dd($request);
        // $request->validate([
        //     'Name' => "required",
        // ]);
        try {
    
          if ($request->status == 1) {
            DB::table('proposals')->where('id',$id)->update([	
              'status'         => 1,
             ]);
          }
          elseif ($request->status == 2) {
            DB::table('proposals')->where('id',$id)->update([	
              'status'         => 1,
              'remark'         => $request->remark,
             ]);
          }
         
          
  
     $output = array('msg' => 'Submit Successfully');
            return redirect('proposal')->with('success', $output);
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
     * @param  \App\Models\Employeereferral  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employeereferral $employeereferral)
    {
        //
    }
    
    public function proposalStatus(Request $request)
    {
    //   dd($request);
      try {

        DB::table('proposals')->where('id',$request->id)->update([	
          'status'        => 2,
          'remark'        =>$request->remark,
         ]);

        $output = array('msg' => 'Updated Successfully');
        return redirect('proposal')->with('success', $output);
      } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
    }
}
