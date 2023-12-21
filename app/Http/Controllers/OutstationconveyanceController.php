<?php

namespace App\Http\Controllers;
use App\Models\Teammember;
use App\Models\Outstationconveyance;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use DB;
class OutstationconveyanceController extends Controller
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
	  public function conveyacnelocal(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $outstationconveyances = DB::table('outstationconveyances')
              ->select('outstationconveyances.id')->
              where('outstationconveyances.id',$request->id)->first();
                return response()->json($outstationconveyances);
             }
            }
    
    } 
	 public function conveyacneoutstation(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $outstationconveyances = DB::table('outstationconveyances')
              ->select('outstationconveyances.id')->
              where('outstationconveyances.id',$request->id)->first();
                return response()->json($outstationconveyances);
             }
            }
    }
	    public function accountupdate(Request $request)
    {
        try {
            $data=$request->except(['_token']);
            if($request->Status == 5){
            DB::table('outstationconveyances')->where('id',$request->outstationconveyanceid)->update([	
                'Status'         =>     $request->Status,
				  'payment'         =>     $request->payment,
                'processingdate' => date('y-m-d'),  
                 ]);
				 DB::table('trail')->insert([
                    'createdby'   	=>     auth()->user()->teammember_id,
                    'type'   	=>     'Conveyance',
                    'pagetitle'   	=>     'Conveyance',
                   'description'=>  'Processing Payment By',
                    'ip_address'  => $request->ip(),
                    'pageid'  => $request->outstationconveyanceid,
                    'created_at'			    =>	   date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
                }
                else {
                    DB::table('outstationconveyances')->where('id',$request->outstationconveyanceid)->update([		
                        'Status'         =>     $request->Status,
						  'payment'         =>     $request->payment,
                        'paiddate' => date('y-m-d')   
                         ]);
					   DB::table('trail')->insert([
                            'createdby'   	=>     auth()->user()->teammember_id,
                            'type'   	=>     'Conveyance',
                            'pagetitle'   	=>     'Conveyance',
                           'description'=>  'Paid By',
                            'ip_address'  => $request->ip(),
                            'pageid'  => $request->outstationconveyanceid,
                            'created_at'			    =>	   date('Y-m-d H:i:s'),
                            'updated_at'              =>    date('Y-m-d H:i:s'),
                        ]);
                }
            $output = array('msg' => 'Update Successfully');
             return redirect('outstationconveyance')->with('success', $output);
     
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

        if(auth()->user()->teammember_id == 23 || auth()->user()->teammember_id == 99){
              $outstationData = DB::table('outstationconveyances')
            ->leftjoin('assignments','assignments.id','outstationconveyances.assignment_id')
            ->leftjoin('clients','clients.id','outstationconveyances.client_id')
            ->where('outstationconveyances.conveyance','Local Conveyance')->
          select('outstationconveyances.*','clients.client_name','assignments.assignment_name  as assignmentsname')->get();
           // dd($outstationData);
            $outstationDatas = DB::table('outstationconveyances')
            ->leftjoin('assignments','assignments.id','outstationconveyances.assignment_id')
            ->leftjoin('clients','clients.id','outstationconveyances.client_id')
            ->where('outstationconveyances.conveyance','Outstation Conveyance')
          ->select('outstationconveyances.*','clients.client_name','assignments.assignment_name  as assignmentsname')->get();
           // dd($profileDatas);
            return view('backEnd.outstationconveyance.index',compact('outstationData','outstationDatas'));
                }
           elseif(auth()->user()->role_id == 11 or auth()->user()->role_id == 12 or auth()->user()->role_id == 18 or auth()->user()->role_id == 17){
            $outstationData = DB::table('outstationconveyances')
            ->leftjoin('assignments','assignments.id','outstationconveyances.assignment_id')
            ->leftjoin('clients','clients.id','outstationconveyances.client_id')
            ->where('outstationconveyances.conveyance','Local Conveyance')->
          select('outstationconveyances.*','clients.client_name','assignments.assignment_name  as assignmentsname')->get();
           // dd($outstationData);
            $outstationDatas = DB::table('outstationconveyances')
            ->leftjoin('assignments','assignments.id','outstationconveyances.assignment_id')
            ->leftjoin('clients','clients.id','outstationconveyances.client_id')
            ->where('outstationconveyances.conveyance','Outstation Conveyance')
          ->select('outstationconveyances.*','clients.client_name','assignments.assignment_name  as assignmentsname')->get();
           // dd($profileDatas);
            return view('backEnd.outstationconveyance.index',compact('outstationData','outstationDatas'));
                }
           else
           {
            $outstationData = DB::table('outstationconveyances')
            ->leftjoin('assignments','assignments.id','outstationconveyances.assignment_id')
            ->leftjoin('clients','clients.id','outstationconveyances.client_id')->
            where('outstationconveyances.createdby',auth()->user()->teammember_id)
            ->where('outstationconveyances.conveyance','Local Conveyance')
            ->select('outstationconveyances.*','clients.client_name','assignments.assignment_name  as assignmentsname')->get();
           // dd($outstationData);
            $outstationDatas = DB::table('outstationconveyances')
            ->leftjoin('assignments','assignments.id','outstationconveyances.assignment_id')
            ->leftjoin('clients','clients.id','outstationconveyances.client_id')->
            where('outstationconveyances.createdby',auth()->user()->teammember_id)
            ->where('outstationconveyances.conveyance','Outstation Conveyance')
            ->select('outstationconveyances.*','clients.client_name','assignments.assignment_name  as assignmentsname')->get();
          //dd($profileDatas);
            return view('backEnd.outstationconveyance.index',compact('outstationData','outstationDatas'));
           }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
        $client = Client::select('id','client_name')->get();
        if ($request->ajax()) {
            //  dd($request);
            if (isset($request->cid)) {
                echo "<option value=''>Please Select One</option>";
                foreach (DB::table('travel')->where('client_id', $request->cid)->where('createdby',auth()->user()->teammember_id)
                ->where('adjustablestatus',0)->limit(1)->get() as $sub) {
                 //   dd($sub);
                echo "<option value='" . $sub->chooseconveyance . "'>" . $sub->chooseconveyance . "</option>";
                
                           }
                        
                       }      
                   
           } else {
      return view('backEnd.outstationconveyance.create',compact('client','teammember'));
    }
}
// ->where('createdby',auth()->user()->teammember_id)
//               ->where('Status',0)->first();
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  dd($request->conveyance);
        // $request->validate([
        //     'companyname' => "required",
        // ]);
        try {
            $data=$request->except(['_token','teammember_id','amount','attachment']);
            if($request->hasFile('Travelsupportingfile'))
            {
                     $file=$request->file('Travelsupportingfile');
                    $destinationPath =  'backEnd/image/outstationconveyance';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['Travelsupportingfile'] = $name;
            }
            if($request->hasFile('Food_Expensesfile'))
            {
                     $file=$request->file('Food_Expensesfile');
                    $destinationPath =  'backEnd/image/outstationconveyance';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['Food_Expensesfile'] = $name;
            }
            if($request->hasFile('Conveyance_file'))
            {
                     $file=$request->file('Conveyance_file');
                    $destinationPath =  'backEnd/image/outstationconveyance';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['Conveyance_file'] = $name;
            }
            if($request->hasFile('During_Journeyfile'))
            {
                     $file=$request->file('During_Journeyfile');
                    $destinationPath =  'backEnd/image/outstationconveyance';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['During_Journeyfile'] = $name;
            }
            if($request->hasFile('Miscellaneous_Expfile'))
            {
                     $file=$request->file('Miscellaneous_Expfile');
                    $destinationPath =  'backEnd/image/outstationconveyance';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['Miscellaneous_Expfile'] = $name;
            }
            if($request->hasFile('Travelfoodsupportingfile'))
            {
                     $file=$request->file('Travelfoodsupportingfile');
                    $destinationPath =  'backEnd/image/outstationconveyance';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['Travelfoodsupportingfile'] = $name;
            }
            if($request->hasFile('TravelMiscellaneoussupportingfile'))
            {
                     $file=$request->file('TravelMiscellaneoussupportingfile');
                    $destinationPath =  'backEnd/image/outstationconveyance';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['TravelMiscellaneoussupportingfile'] = $name;
            }
			if($request->assignmentgenerate_id == null){
                $data['conveyance'] = $request->chooseconveyance;
                $data['chooseconveyance'] = '';
                $data['localsreceivable_payable'] = null;
                $data['outstationnnreceivable_payable'] = null;

            }
            $data['createdby'] = auth()->user()->teammember_id;
            $data['Status'] = 0;
           $localconveyance = outstationconveyance::Create($data);
            $localconveyance->save();
            $id = $localconveyance->id;
			
				DB::table('trail')->insert([
                'createdby'   	=>     auth()->user()->teammember_id,
                'type'   	=>     'Conveyance',
                'pagetitle'   	=>     'Conveyance',
               'description'=>  'New Conveyance Request Raised By',
                'ip_address'  => $request->ip(),
                'pageid'  => $id,
                'created_at'			    =>	   date('Y-m-d H:i:s'),
                'updated_at'              =>    date('Y-m-d H:i:s'),
            ]);
			
            $files = [];
            if($request->hasFile('attachment'))
            {
                
                foreach ($request->file('attachment') as $file) {

                    $destinationPath = 'backEnd/image/outstationconveyance';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                    $files[] = $name;
                    // $data['url'] = $name;
                 
                }
               
            }
            foreach($files as $filess )
            {
         
               $s = DB::table('outstationconveyanceattachments')->insert([
                    'outstationconveyance_id' => $id, 
                    'attachment' => $filess,
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);      
            }
            if($request->teammember_id[0] != null){
                $count=count($request->teammember_id);
               // dd($count);
                for($i=0;$i<$count;$i++){
                   DB::table('outstationconveyancesemployee')->insert([
                       'outstationconveyances_id'   	=>     $id,
                       'teammember_id'   	=>     $request->teammember_id[$i],
                       'amount'   	=>     $request->amount[$i],
                       'created_by'  => auth()->user()->teammember_id,
                       'created_at'			    =>	   date('y-m-d'),
                       'updated_at'              =>    date('y-m-d'),
                   ]);
                }
                         }
            $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
            $data = array(
                'teammember' => $teammember->team_member ??'',
                'id' => $id ??''
        );
         Mail::send('emails.outstationconveyanceform', $data, function ($msg) use($data){
             $msg->to('vkverma@kgsomani.com');
             $msg->cc('priyankasharma@kgsomani.com');
             $msg->subject('New Conveyance Request');
          }); 
            $output = array('msg' => 'Create Successfully');
            return redirect('outstationconveyance')->with('success', $output);
      
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
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function  show($id)
    {
        $outstationconveyance = DB::table('outstationconveyances')
        ->leftjoin('clients','clients.id','outstationconveyances.client_id')
        ->leftjoin('assignments','assignments.id','outstationconveyances.assignment_id')->
        where('outstationconveyances.id',$id)
        ->select('outstationconveyances.*','clients.client_name','assignments.assignment_name')->first();
     
        $outstationconveyanceData = DB::table('outstationconveyancesemployee')
        ->leftjoin('teammembers','teammembers.id','outstationconveyancesemployee.teammember_id')->
        where('outstationconveyancesemployee.outstationconveyances_id',$id)
        ->select('outstationconveyancesemployee.*','teammembers.team_member')->get();
        $outstationconveyancefile = DB::table('outstationconveyanceattachments')
        ->where('outstationconveyance_id',$id)->get();
    
		$Conveyancelog = DB::table('trail')
      ->leftjoin('teammembers','teammembers.id','trail.createdby')
      ->where('pageid', $id)->where('type','Conveyance')->select('trail.*','teammembers.team_member')->get();
		
        return view('backEnd.outstationconveyance.view',compact('Conveyancelog','outstationconveyancefile','outstationconveyance','outstationconveyanceData'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::select('id','client_name')->get();
        $outstationconveyance = outstationconveyance::where('id', $id)->first();
      //  dd($outstationconveyance);
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
        $outstationconveyancesemployee = DB::table('outstationconveyancesemployee')
        ->leftjoin('teammembers','teammembers.id','outstationconveyancesemployee.teammember_id')
        ->where('outstationconveyancesemployee.outstationconveyances_id', $id)
        ->select('outstationconveyancesemployee.*','teammembers.team_member')->get();
        return view('backEnd.outstationconveyance.edit', compact('id','outstationconveyance','client','teammember','outstationconveyancesemployee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token','teammember_id','amount','attachment']);
            $data['updatedby'] = auth()->user()->teammember_id;
            Outstationconveyance::find($id)->update($data);
			   if ($request->Status == 1) {
           $upsatatus = 'Approved By';
           }
            elseif($request->Status == 2){
                $upsatatus = 'Rejected By';
           }
            elseif($request->Status == 2){
                $upsatatus = 'Rejected By';
           }
            elseif($request->Status == 4){
                $upsatatus = 'Ask for Correction/Clarification By';
           }
            else{
                $upsatatus = 'Edited By';
           }
           
            DB::table('trail')->insert([
                'createdby'   	=>     auth()->user()->teammember_id,
                'type'   	=>     'Conveyance',
                'pagetitle'   	=>     'Conveyance',
               'description'=>  $upsatatus,
                'ip_address'  => $request->ip(),
                'pageid'  => $id,
                'created_at'			    =>	   date('Y-m-d H:i:s'),
                'updated_at'              =>    date('Y-m-d H:i:s'),
            ]);
            $createdby = Outstationconveyance::where('id',$id)->first();
            $files = [];
            if($request->hasFile('attachment'))
            {
                
                foreach ($request->file('attachment') as $file) {

                    $destinationPath = 'backEnd/image/outstationconveyance';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                    $files[] = $name;
                    // $data['url'] = $name;
                 
                }
               
            }
            foreach($files as $filess )
            {
         
                $s = DB::table('outstationconveyanceattachments')->insert([
                    'outstationconveyance_id' => $id, 
                    'attachment' => $filess,
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);      
            }
            if($request->Status == 1)
            {
                $outstationconveyance = DB::table('outstationconveyances')->
                where('id',$id)->first();
				    DB::table('outstationconveyances')->where('id',$outstationconveyance->id)->update([	
                    'approveddate'         =>   date('Y-m-d H:i:s')   
                   ]);
                $advance = DB::table('travel')->
                where('assignmentgenerate_id',$outstationconveyance->assignmentgenerate_id)
                ->where('assignment_id',$outstationconveyance->assignment_id)
                ->where('client_id',$outstationconveyance->client_id)
                ->where('createdby',$outstationconveyance->createdby)->first();
             // dd($advance);
              if($advance != null && $advance->chooseconveyance == 'Outstation Conveyance')
              {
                $adjust = $outstationconveyance->Travelling_BILL - $outstationconveyance->AdvanceAmountgiven;
              //  dd($adjust);
              
                    DB::table('travel')->where('id',$advance->id)->update([	
                        'adjust'         =>     $adjust,
                        'adjustablestatus'         =>     1,
                       ]);
                       DB::table('outstationconveyances')->where('id',$outstationconveyance->id)->update([	
                        'assignmentgenerate_id'         =>     $advance->assignmentgenerate_id,
						     'adjustablestatus'         =>     1,
                       ]);
                }
              if($advance != null && $advance->chooseconveyance == 'Local Conveyance')
              {
                $adjust = $outstationconveyance->Total_Value - $outstationconveyance->AdvanceAmountgiven;
              // dd($adjust);
              
                    DB::table('travel')->where('id',$advance->id)->update([	
                        'adjust'         =>     $adjust,
                        'adjustablestatus'         =>     1,
                       ]);
                       DB::table('outstationconveyances')->where('id',$outstationconveyance->id)->update([	
                        'assignmentgenerate_id'         =>     $advance->assignmentgenerate_id,
						     'adjustablestatus'         =>     1,
                       ]);
                }
            }
          if($request->Status == 1 || $request->Status == 2){
            $teammembermail = Teammember::where('id',$createdby->createdby)->first();
            $data = array(
                  'email' => $teammembermail->emailid ??'',
                   'status' => $createdby->Status ??'',
				 'conveyance' => $createdby->conveyance ??'',
                   'name' => $teammembermail->team_member ??'',
                   'id' => $id ??''
           );
            Mail::send('emails.outstationconveyanceapprovelform', $data, function ($msg) use($data , $request){
                $msg->to($data['email']);
                if($request->Status == 1){
                    $msg->subject('Conveyance Request - Approved ');
                }
                if($request->Status == 2){
                    $msg->subject('onveyance Request- Rejected');
                }

// $msg->cc($data['teammembermail']);
             });
             Mail::send('emails.outstationconveyanceaccountform', $data, function ($msg) use($data){
                $msg->to('accounts@kgsomani.com');
                $msg->cc('priyankasharma@kgsomani.com');
                $msg->subject('Conveyance Request');
// $msg->cc($data['teammembermail']);
             }); 
          }
          if($createdby->createdby == auth()->user()->teammember_id){
            DB::table('outstationconveyances')->where('id',$id)->update([	
                'Status'         =>     0
                 ]);
                 $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
                 $data = array(
                     'teammember' => $teammember->team_member ??'',
                     'correction' => '',
                        'id' => $id ??''
                );
                Mail::send('emails.outstationconveyanceform', $data, function ($msg) use($data){
                    $msg->to('vkverma@kgsomani.com');
                    $msg->cc('priyankasharma@kgsomani.com');
                    $msg->subject('New Conveyance Request');
                 }); 
        }
          if($request->Status == 4){
            $teammembermail = Teammember::where('id',$createdby->createdby)->first();
            $data = array(
                  'email' => $teammembermail->emailid ??'',
                   'id' => $id ??'',
                   'conveyance' => $createdby->conveyance ??''
           );
            Mail::send('emails.outstationconveyancecorrectionform', $data, function ($msg) use($data , $request){
                $msg->to($data['email']);
                $msg->subject('Conveyance Correction/Clarification');
                $msg->cc('priyankasharma@kgsomani.com');
// $msg->cc($data['teammembermail']);
             });
          }
            $output = array('msg' => 'Updated Successfully');
            return redirect('outstationconveyance')->with('success', $output);
     
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
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outstationconveyance $outstationconveyance)
    {
        //
    }
    public function assignmentOutstation(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->cid)) {
              $client = DB::table('travel')->where('client_id',$request->cid)->where('createdby',auth()->user()->teammember_id)
              ->where('Status',0)->where('adjustablestatus',0)->first();
    //dd($client);
                return response()->json($client);
             }
            }
    
    }
    public function assignmentFunction(Request $request)
    {
        if ($request->ajax()) {
            //  dd($request);
               if (isset($request->cid)) {
                   $authid = DB::table('travel')->leftjoin('assignments','assignments.id','travel.assignment_id')
                   ->where('travel.createdby',auth()->user()->teammember_id)
                   ->where('travel.client_id', $request->cid)->where('travel.Status',0)->where('travel.adjustablestatus',0)->
                   take(1)->get();
                  // dd($authid);
                   if($authid->isNotEmpty())
                   {
                echo "<option value=''>Select Assignment</option>";
        foreach (DB::table('travel')->leftjoin('assignments','assignments.id','travel.assignment_id')
        ->where('travel.createdby',auth()->user()->teammember_id)
        ->where('travel.client_id', $request->cid)->where('travel.Status',0)->where('travel.adjustablestatus',0)->
        take(1)->get() as $sub) {
        echo "<option value='" . $sub->id . "'>" .$sub->assignment_name. "</option>";
        
                   }
               } 
               else
               {
                echo "<option value=''>Select Assignment</option>";
                foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
                ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
                ->orderBy('assignment_name')->get() as $sub) {
                echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
                
                           }
               }     
            }    
           }
    
    }
	public function conveynace_neft(Request $request)
    {
      //  dd($request);
          if($request->ids==null)
          {
              return redirect()->back() ->with('alert', 'Please tick one of the checkbox !');

          }
          else{
           // $req = explode(',', $request->ids);
            //dd($req);
            //  $roundoff= Outstationconveyance::whereIn('id',$request->ids)
            //  ->where('Status',1)
            //  ->sum('finalamount');
      //   dd($roundoff);
          $uniqueid = Outstationconveyance::whereIn('id',$request->ids)
          ->select('outstationconveyances.createdby')->distinct()->get();
        //  dd($uniqueid);

          foreach ($uniqueid as $value) {

           // dd($value->createdby);
            $userdetails = DB::table('teammembers')->where('id',$value->createdby)->first();
          
           //dd($userdetails);
            $teamconveyance = DB::table('outstationconveyances')->
            where('createdby',$userdetails->id)
            ->where('Status',1)
            ->sum('finalamount');
             //dd($teamconveyance);
            $conveyanceid = DB::table('outstationconveyances')->
            where('createdby',$userdetails->id)
            ->where('Status',1)
            ->get();

         //  dd($conveyanceid);
           if($teamconveyance > 0){
            $id=DB::table('nefts')->insertGetId([	
                'teammember_id'         =>     $value->createdby, 
               'name_as_per_bankaccount'         =>     $userdetails->nameasperbank, 
               'nameofbank'         =>     $userdetails->nameofbank, 	
               'bankaccountnumber'         =>     $userdetails->bankaccountnumber, 
               'ifsccode'         =>     $userdetails->ifsccode, 
               'paymenttype'         =>     0, 
               'status'         =>     0, 
               'totalconveyance'         =>     $teamconveyance, 
               'createdby'         =>     auth()->user()->teammember_id,
               'updatedby'         =>     auth()->user()->teammember_id,
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);
             foreach ($conveyanceid as $localconveyance) 
             {
              DB::table('neftconveyances')->insert([	
                  'neft_id'         =>     $id, 
                 'localconveyance_id'         =>     $localconveyance->id, 
                 'createdby'         =>     auth()->user()->teammember_id,
                 'created_at'			    =>	   date('Y-m-d H:i:s'),
                 'updated_at'              =>    date('Y-m-d H:i:s'),
                 ]); 

                 DB::table('outstationconveyances')->where('id',$localconveyance->id)->update([	
                    'Status'         =>     5,
                    'payment'         =>     'NEFT',
                    'processingdate' => date('Y-m-d H:i:s'),  
                     ]);
                     DB::table('trail')->insert([
                        'createdby'   	=>     auth()->user()->teammember_id,
                        'type'   	=>     'Conveyance',
                        'pagetitle'   	=>     'Conveyance',
                       'description'=>  'Processing Payment By',
                        'ip_address'  => $request->ip(),
                        'pageid'  => $localconveyance->id,
                        'created_at'			    =>	   date('Y-m-d H:i:s'),
                        'updated_at'              =>    date('Y-m-d H:i:s'),
                    ]);
             }
            } 
         else {
            $output = array('msg' => 'Submit Successfully');
           return redirect('neft')->with('status', $output);
         }
        }
           
          try {
          $output = array('msg' => 'Submit Successfully');
           return redirect('neft')->with('status', $output);
      } catch (Exception $e) {
          DB::rollBack();
          Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
          report($e);
          $output = array('msg' => $e->getMessage());
          return back()->withErrors($output)->withInput();
      }
  } 
} 
}
