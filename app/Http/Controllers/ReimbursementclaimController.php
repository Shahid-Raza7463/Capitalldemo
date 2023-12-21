<?php

namespace App\Http\Controllers;

use App\Models\Reimbursementclaim;
use App\Http\Controllers\Controller;
use App\Models\Teammember;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use DB;

class ReimbursementclaimController extends Controller
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
			    $reimbursementDatas = DB::table('reimbursementclaims')
   ->leftjoin('teammembers','teammembers.id','reimbursementclaims.Approver')
   ->leftjoin('roles','roles.id','teammembers.role_id')
   ->select('reimbursementclaims.*','teammembers.team_member','roles.rolename')->get();
       // dd($profileDatas);
        return view('backEnd.reimbursementclaim.index',compact('reimbursementDatas'));
		 }
        elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 17 || auth()->user()->role_id == 18){
        $reimbursementDatas = DB::table('reimbursementclaims')
   ->leftjoin('teammembers','teammembers.id','reimbursementclaims.Approver')
   ->leftjoin('roles','roles.id','teammembers.role_id')
   ->select('reimbursementclaims.*','teammembers.team_member','roles.rolename')->get();
       // dd($profileDatas);
        return view('backEnd.reimbursementclaim.index',compact('reimbursementDatas'));
            }
       else
	   {
		     $reimbursementDatas = DB::table('reimbursementclaims')
   ->leftjoin('teammembers','teammembers.id','reimbursementclaims.Approver')
   ->leftjoin('roles','roles.id','teammembers.role_id')->
   where('reimbursementclaims.Approver',auth()->user()->teammember_id)
   ->orwhere('reimbursementclaims.createdby',auth()->user()->teammember_id)
   ->select('reimbursementclaims.*','teammembers.team_member','roles.rolename')->get();
       // dd($reimbursementDatas);
        return view('backEnd.reimbursementclaim.index',compact('reimbursementDatas'));
	   }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//   abort(403, ' you have no permission to access this page ');
       $teammember = Teammember::where('role_id', '!=', 11)->with('role')->get();
       return view('backEnd.reimbursementclaim.create',compact('teammember'));
     //  return view('backEnd.reimbursementclaim.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // $request->validate([
        //     'companyname' => "required",
        // ]);

        try {
            $data=$request->except(['_token']);
          if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                    $destinationPath = 'backEnd/image/claim';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachment'] = $name;
               
            }
            $data['createdby'] = auth()->user()->teammember_id;
			   $data['Status'] = 0;
            $reimbursementclaim = Reimbursementclaim::Create($data);
            $reimbursementclaim->save();
            $id = $reimbursementclaim->id;
            $teammembermail = Teammember::where('id',$request->Approver)->pluck('emailid')->first();
            $createdby = Teammember::where('id',auth()->user()->teammember_id)->pluck('team_member')->first();
            $data = array(
                   'email' => $teammembermail ??'',
                   'name' => $createdby ??'',
                   'id' => $id ??''
           );
            Mail::send('emails.reimbursementclaimform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->subject('Kgs Reimbursement Claim Form Request');
// $msg->cc($data['teammembermail']);
             }); 
            $output = array('msg' => 'Create Successfully');
      return redirect('reimbursementclaim')->with('success', $output);
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
     * @param  \App\Models\Reimbursementclaim  $reimbursementclaim
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reimbursement = DB::table('reimbursementclaims')
        ->leftjoin('teammembers','teammembers.id','reimbursementclaims.Approver')
        ->leftjoin('roles','roles.id','teammembers.role_id')->
        where('reimbursementclaims.id',$id)
        ->select('reimbursementclaims.*','teammembers.team_member','roles.rolename')->first();
      //  dd($reimbursementDatas);
         return view('backEnd.reimbursementclaim.view', compact('id','reimbursement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reimbursementclaim  $reimbursementclaim
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $teammember=Teammember::latest()->with('role')->get();
        $reimbursementclaim = Reimbursementclaim::where('id', $id)->first();
     //   dd($reimbursementclaim);
        return view('backEnd.reimbursementclaim.edit', compact('id', 'reimbursementclaim','teammember'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reimbursementclaim  $reimbursementclaim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
          if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                    $destinationPath = 'backEnd/image/claim';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachment'] = $name;
               
            }
            $data['updatedby'] = auth()->user()->teammember_id;
            Reimbursementclaim::find($id)->update($data);
            $createdby = Reimbursementclaim::where('id',$id)->first();
          //  dd($createdby);
            $teammembermail = Teammember::where('id',$createdby->createdby)->first();
            $data = array(
                  'email' => $teammembermail->emailid ??'',
                   'status' => $createdby->Status ??'',
                   'name' => $teammembermail->team_member ??'',
                   'id' => $id ??''
           );
            Mail::send('emails.reimbursementclaimapprovelform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->subject('Kgs Reimbursement Claim Form ');
// $msg->cc($data['teammembermail']);
             }); 
            Mail::send('emails.reimbursementclaimaccountform', $data, function ($msg) use($data){
                $msg->to('tarunkumar@kgsomani.com');
                $msg->subject('Kgs Reimbursement Claim Form ');
// $msg->cc($data['teammembermail']);
             }); 
            $output = array('msg' => 'Update Successfully');
             return redirect('reimbursementclaim')->with('success', $output);
     
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
     * @param  \App\Models\Reimbursementclaim  $reimbursementclaim
     * @return \Illuminate\Http\Response
     */
	   public function accountupdate(Request $request)
    {
        try {
            $data=$request->except(['_token']);
            if($request->Status == 4){
            DB::table('reimbursementclaims')->where('id',$request->reimbursementid)->update([	
                'Status'         =>     $request->Status,
                'processingdate' => date('y-m-d'),  
                 ]);
                }
                else {
                    DB::table('reimbursementclaims')->where('id',$request->reimbursementid)->update([		
                        'Status'         =>     $request->Status,
                        'paiddate' => date('y-m-d')   
                         ]);
                }
            $output = array('msg' => 'Update Successfully');
             return redirect('reimbursementclaim')->with('success', $output);
     
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
    }
    public function destroy(Reimbursementclaim $reimbursementclaim)
    {
        //
    }
	 public function reimbursementclaimupdate(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $invoice = DB::table('reimbursementclaims')
              ->where('id',$request->id)->first();
                return response()->json($invoice);
             }
            }
    }
}
