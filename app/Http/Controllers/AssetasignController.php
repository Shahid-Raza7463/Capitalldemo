<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Financerequest;
use App\Models\Teammember;
use Illuminate\Http\Request;
use App\imports\Financeimport;
use DB;
use Excel;
class AssetasignController extends Controller
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
      if(auth()->user()->role_id == 17){
       $financeDatas = Financerequest::latest()->with('teammember')->get();
        return view('backEnd.assetassign.index',compact('financeDatas'));
    }
    else {
        $financeDatas = Financerequest::latest()->with('teammember')->get();
       // dd($financeDatas);
        return view('backEnd.assetassign.index',compact('financeDatas'));
    }
    
    }
	 public function assetassigned_report()
    {
      
        $financeDatas = DB::table('financerequests')
        ->leftjoin('assetfinancetrail','assetfinancetrail.pageid','financerequests.id')
        ->where('assetfinancetrail.amount','!=', '')
        ->get();
     //   dd($financeDatas);
        return view('backEnd.assetassign.assetassignedreport',compact('financeDatas'));
    
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $teammember = Teammember::where('role_id', '!=', 11)->where('role_id', '!=', 12)->with('role')->get();
       return view('backEnd.assetassign.create',compact('teammember'));
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
            'modal_name' => "required",
            'company_name' => "required",
            'sno' => "required"
        ]);

        try {
            $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
            $data['updatedby'] = auth()->user()->teammember_id;
            $data['status'] = 0;
             $Financerequest= Financerequest::Create($data);
            $Financerequest->save();
            $id = $Financerequest->id;
            DB::table('assets')->insert([	
                'financerequest_id'         =>     $id,
                'teammember_id'  => $request->teammemberid,
                'item'  => $request->modal_name,
                'description'  => $request->kgs.$request->sno,
                'dateassign'  => date('y-m-d'),
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                 ]);
			  $teammember = DB::table('teammembers')->where('id',$request->teammemberid)->pluck('team_member')->first();
              $teammemberemail = DB::table('teammembers')->where('id',$request->teammemberid)->pluck('emailid')->first();
                 $assignid = $id;
                 //    dd($value);
                       $assignadded = 'Asset Asign to ';
                       $amount = '';
                       $problem = '';
                       $solution =  '';
                       $comment = '';
                       $team = '';
                       $for = '';
                       $type = 'Asset';
                       DB::table('assetfinancetrail')->insert([
                        'createdby' => auth()->user()->teammember_id, 
                        'ip_address' => $request->ip(), 
                        'amount' => $request->amount ??'', 
                        'problem' => $request->problem ??'', 
                        'comment' => $comment ??'', 
                        'solution' => $request->solution ??'', 
                        'pageid' => $assignid, 
                        'type' => $type, 
                        'description' => $assignadded.' '.  $teammember .' '. $for .' '. $team, 
                        'created_at' => date('y-m-d H:i:s'),       
                        'updated_at' => date('y-m-d')       
                    ]);
                        $data = array(
                            'email' => $teammemberemail ??'',
                            'id' => $id ??''
                    );
                     Mail::send('emails.assetassignform', $data, function ($msg) use($data){
                         $msg->to($data['email']);
                         $msg->subject('Kgs Asset Assign');
         // $msg->cc($data['teammembermail']);
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
     * @param  \App\Models\finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show(finance $finance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $teammember=Teammember::latest()->where('status',1)->with('role')->get();
        $finance = Financerequest::where('id', $id)->first();
        $assetlog = DB::table('assetfinancetrail')->where('pageid', $id)->where('type','Asset')->get();
        return view('backEnd.assetassign.edit', compact('id', 'finance','teammember','assetlog'));
    }
    public function financeView($id)
    {
      //  dd($id);
        $finance = Financerequest::where('id', $id)->first();
        $assetlog = DB::table('assetfinancetrail')->where('pageid', $id)->where('type','Finance')->get();
        return view('backEnd.assetassign.view', compact('id', 'finance','assetlog'));
    }
    public function financeViewit($id)
    {
        $finance = Financerequest::where('id', $id)->first();
       $account = Teammember::where('id',23)->with('title')->get();
        $assetlog = DB::table('assetfinancetrail')->where('pageid', $id)->where('type','Finance')->get();
        return view('backEnd.assetassign.viewit', compact('id', 'finance','account','assetlog'));
    }
    public function financeUpload(Request $request )
    {
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Financeimport, $file);
            
            foreach ($dataa[0] as $key => $value) {
                $financename=DB::table('financerequests')->where('sno',$value['sno'])->select('sno')->pluck('sno')->first();
             //   dd($value['clientname']);
             if($financename == NULL){
                $db['modal_name']=$value['modal_name'];
                $db['sno']=$value['sno'] ;
                 $db['company_name']=$value['company_name'] ;
                 $db['kgs']=$value['kgs'];
                 $db['mac_address']=$value['mac_address'];
                 $data= Financerequest::Create($db);
               }
              
 }
           $output = array('msg' => 'Excel file upload Successfully');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($id);
        try {
            $data=$request->except(['_token']);
             Financerequest::find($id)->update($data);
             $financerequest_id   = DB::table('assets')->where('financerequest_id',$id)->pluck('financerequest_id')->first();
   // dd($financerequest_id);
            if($financerequest_id != null)
            { 
                 DB::table('assets')->where('financerequest_id',$id)->update([	
                    'financerequest_id'         =>     $id,
                    'teammember_id'  => $request->teammemberid,
                    'item'  => $request->modal_name,
                    'assetstatus'  => $request->assetstatus,
                    'description'  => $request->kgs.$request->sno,
                    'dateassign'  => date('y-m-d'),
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                     ]);
                }
          else{
            DB::table('assets')->insert([	
                'financerequest_id'         =>     $id,
                'teammember_id'  => $request->teammemberid,
                'item'  => $request->modal_name,
                'assetstatus'  => $request->assetstatus,
                'description'  => $request->kgs.$request->sno,
                'dateassign'  => date('y-m-d'),
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                 ]);
          }
			   if($request->assetstatus == 2 && $financerequest_id != null){
            DB::table('assets')->where('financerequest_id',$id)->delete();
            DB::table('financerequests')->where('id',$id)->update([	
                'teammember_id'  => 0,
                'updated_at'              =>    date('y-m-d'),
                 ]);
            }
			  if($request->assetstatus == 0){
          $teammember = DB::table('teammembers')->where('id',$request->teammemberid)->pluck('team_member')->first();
          $teammemberemail = DB::table('teammembers')->where('id',$request->teammemberid)->pluck('emailid')->first();
				//  dd($request->teammemberid);
          $assignid = $id;
                $assignadded = 'Asset Asign to ';
                $amount = '';
                $problem = '';
                $solution =  '';
                $comment = '';
                $team = '';
                $type = 'Asset';
                $for = '';
                DB::table('assetfinancetrail')->insert([
                    'createdby' => auth()->user()->teammember_id, 
                    'ip_address' => $request->ip(), 
                    'amount' => $request->amount ??'', 
                    'problem' => $request->problem ??'', 
                    'comment' => $comment ??'', 
                    'solution' => $request->solution ??'', 
                    'pageid' => $assignid, 
                    'type' => $type, 
                    'description' => $assignadded.' '.  $teammember .' '. $for .' '. $team, 
                    'created_at' => date('y-m-d H:i:s'),       
                    'updated_at' => date('y-m-d')       
                ]);
                $data = array(
                    'email' => $teammemberemail ??'',
                    'id' => $id ??''
            );
             Mail::send('emails.assetassignform', $data, function ($msg) use($data){
                 $msg->to($data['email']);
                 $msg->subject('Kgs Asset Assign');
 // $msg->cc($data['teammembermail']);
              }); 
              DB::table('financerequests')->where('id',$id)->update([	
                'acknowledge'  => 0,
                'status'  => 0,
                'updated_at'              =>    date('y-m-d'),
                 ]);
          }
          if($request->assetstatus == 1){
            $teammember = DB::table('teammembers')->where('id',$request->teammemberid)->pluck('team_member')->first();
            $assignid = $id;
            $amount = '';
            $problem = '';
            $solution =  '';
            $comment = '';
            $team = '';
            $for = '';
            $type = Asset;
                  $assignadded = 'Asset Return from  ';
                  DB::table('assetfinancetrail')->insert([
                    'createdby' => auth()->user()->teammember_id, 
                    'ip_address' => $request->ip(), 
                    'amount' => $request->amount ??'', 
                    'problem' => $request->problem ??'', 
                    'comment' => $comment ??'', 
                    'solution' => $request->solution ??'', 
                    'pageid' => $assignid, 
                    'type' => $type, 
                    'description' => $assignadded.' '.  $teammember .' '. $for .' '. $team, 
                    'created_at' => date('y-m-d H:i:s'),       
                    'updated_at' => date('y-m-d')       
                ]);
          }
            $output = array('msg' => 'Updated Successfully');
            return redirect('assetassign')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function accountUpdate(Request $request)
    {
        try {
            $data=$request->except(['_token']);
            Financerequest::find($request->id)->update($data);
            $teams = DB::table('financerequests')
            ->leftjoin('teammembers','teammembers.id','financerequests.teammemberid')
            ->where('financerequests.id',$request->id)->
            select('teammembers.team_member')->first();

			$teammember =  $teammember = DB::table('teammembers')->where('id',auth()->user()->teammember_id)->pluck('team_member')->first();;
            $assignid = $request->id;
            $team = $teams->team_member;
            if($request->status == 1){
                  $assignadded = 'Asset Approve by';
            }
            if($request->status == 2){
                  $assignadded = 'Asset Reject by';
            }
            if($request->status == 0){
                  $assignadded = 'Asset Active by';
            }
            $amount = '';
$problem = '';
$solution =  '';
$comment = $request->comment;
$for = 'for';
$type = 'Finance';
DB::table('assetfinancetrail')->insert([
    'createdby' => auth()->user()->teammember_id, 
    'ip_address' => $request->ip(), 
    'amount' => $request->amount ??'', 
    'problem' => $request->problem ??'', 
    'comment' => $comment ??'', 
    'solution' => $request->solution ??'', 
    'pageid' => $assignid, 
    'type' => $type, 
    'description' => $assignadded.' '.  $teammember .' '. $for .' '. $team, 
    'created_at' => date('y-m-d H:i:s'),       
    'updated_at' => date('y-m-d')       
]);
$data = array(
    'teammember' => $teammember ??'',
    'team' => $team ??'',
    'assignadded' => $assignadded ??'',
    
);
Mail::send('emails.assetfinancerequestform', $data, function ($msg) use($data){
 $msg->to('it@kgsomani.com');
 $msg->subject('Kgs Asset Finance Status');
// $msg->cc($data['teammembermail']);
});
            $output = array('msg' => 'Updated Successfully');
            return redirect('assetassign')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function itUpdate(Request $request)
    {
      //  dd($request);
        try {
             $data=$request->except(['_token','vendor','refrence','bill']);
            $data['status'] = 3;
            Financerequest::find($request->id)->update($data);
			
            $teammember = DB::table('teammembers')->where('id',$request->teammember_id)->pluck('team_member')->first();
            $teammemberemailid = DB::table('teammembers')->where('id',$request->teammember_id)->pluck('emailid')->first();
            $teams = DB::table('financerequests')
            ->leftjoin('teammembers','teammembers.id','financerequests.teammemberid')
            ->where('financerequests.id',$request->id)->
            select('teammembers.team_member')->first();
if($request->hasFile('bill'))
            {
                    $file=$request->file('bill');
              $name = $file->getClientOriginalName();
              $path = $file->storeAs('assetbill',$name,'s3');
                   $data['bill'] = $name;
            }
            $assignid = $request->id;
                  $assignadded = 'Asset Request to ';
$team = $teams->team_member;
$amount = $request->amount;
$problem = $request->problem;
$solution = $request->solution;
$comment = '';
$for = 'for';
$type = 'Finance';
DB::table('assetfinancetrail')->insert([
    'createdby' => auth()->user()->teammember_id, 
    'ip_address' => $request->ip(), 
    'amount' => $request->amount ??'', 
    'problem' => $request->problem ??'', 
    'comment' => $comment ??'', 
    'solution' => $request->solution ??'', 
	 'vendor' => $request->vendor ??'', 
    'refrence' => $request->refrence ??'', 
    'bill' => $data['bill'] ??'', 
    'pageid' => $assignid, 
    'type' => $type, 
    'description' => $assignadded.' '.  $teammember .' '. $for .' '. $team, 
    'created_at' => date('y-m-d H:i:s'),       
    'updated_at' => date('y-m-d')       
]);
$data = array(
    'email' => $teammemberemailid ??'',
    'team' => $team ??''
);
Mail::send('emails.assetassignfinancerequestform', $data, function ($msg) use($data){
 $msg->to($data['email']);
 $msg->subject('Kgs Asset Finance Request');
// $msg->cc($data['teammembermail']);
});
            $output = array('msg' => 'Updated Successfully');
            return redirect('assetassign')->with('success', $output);
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
     * @param  \App\Models\finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function activityfinanceLog($request, $assignid, $teammember,$assignadded, $amount, $problem, $solution, $comment, $type ,$for, $team){
                DB::table('assetfinancetrail')->insert([
                        'createdby' => auth()->user()->teammember_id, 
                        'ip_address' => $request->ip(), 
                        'amount' => $request->amount ??'', 
                        'problem' => $request->problem ??'', 
                        'comment' => $comment ??'', 
                        'solution' => $request->solution ??'', 
                        'pageid' => $assignid, 
                        'type' => $type, 
                        'description' => $assignadded.' '.  $teammember .' '. $for .' '. $team, 
                        'created_at' => date('y-m-d H:i:s'),       
                        'updated_at' => date('y-m-d')       
                    ]);
      }
}
