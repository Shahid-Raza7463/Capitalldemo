<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class LeadController extends Controller
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
         if(auth()->user()->role_id == 17 || auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
          $leadDatas = DB::table('leads')
          ->leftjoin('clients','clients.id','leads.client_id')
          ->leftjoin('teammembers','teammembers.id','leads.createdby')
          ->select('leads.*','clients.client_name','teammembers.team_member')->get();
           return view('backEnd.lead.index',compact('leadDatas'));
        }
        else {
            $leadDatas  =DB::table('leads')
            ->leftjoin('clients','clients.id','leads.client_id')
            ->leftjoin('teammembers','teammembers.id','leads.createdby')
            ->where('leads.createdby',auth()->user()->teammember_id)
            ->select('leads.*','clients.client_name','teammembers.team_member')->get();
			//dd($leadDatas);
                 return view('backEnd.lead.index',compact('leadDatas'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = Client::latest()->get();
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
		 $concernpartner = Teammember::where('role_id',13)->where('status',1)->with('title','role')->get();
		//dd($concernpartner);
        return view('backEnd.lead.create',compact('client','teammember','concernpartner'));
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
        //     'serailno' => "required",
        // ]);

        try {
            $data=$request->except(['_token','file']);
            $data['createdby'] = auth()->user()->teammember_id;
          //  $data['status'] = 0 ;
            $data['updatedby'] = auth()->user()->teammember_id;
           $leadModel = Lead::Create($data);
            $leadModel->save();
            $id = $leadModel->id;
            $lead = DB::table('leads')
            ->leftjoin('clients','clients.id','leads.client_id')
            ->leftjoin('teammembers','teammembers.id','leads.createdby')
            ->where('leads.id', $id)
            ->select('leads.*','clients.client_name','teammembers.team_member')->first();
            $teammembermail = Teammember::where('id',$request->teammember_id)->pluck('emailid')->first();
           if($request->teammember_id){
            $data = array(
                   'email' => $teammembermail ??'',
                   'id' => $id ??'',
                   'lead' => $lead ??'',
           );
            Mail::send('emails.leadform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->subject('Kgs Lead Assign');
             });
            }
			  if($request->hasFile('file'))
            {
                foreach ($request->file('file') as $file) {
					 $name = $file->getClientOriginalName();
                //    $destinationPath = storage_path('app/backEnd/image/clientfile');
                 //   $name = $file->getClientOriginalName();
                 //  $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
					  $path = $file->storeAs('lead',$name,'s3');
                    $files[] = $name;
                 
                }
            }
            foreach($files as $filess )
            {
           // dd($files); die;
               $s = DB::table('leadfiles')->insert([
                    'leadid' => $id,  
                    'file' => $filess, 
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lead = DB::table('leads')
        ->leftjoin('clients','clients.id','leads.client_id')
        ->leftjoin('teammembers','teammembers.id','leads.createdby')
        ->where('leads.id', $id)
        ->select('leads.*','clients.client_name','teammembers.team_member')->first();
        $leadData =  DB::table('leadstatus')
        ->leftjoin('teammembers','teammembers.id','leadstatus.createdby')
       ->where('lead_id', $id)
        ->select('leadstatus.*','teammembers.team_member')->get();
         return view('backEnd.lead.view', compact('id','lead','leadData'));
    }
    public function leadreplyDone(Request $request)
    { 
      //   dd($request);
        
         try {
			    DB::table('leads')->where('id',$request->lead_id)->update([	
                'status'         =>    $request->status, 
                 'updated_at' => date('y-m-d')     
                 ]);
                 if($request->hasFile('attachment'))
{
         $file=$request->file('attachment');
        $destinationPath = 'backEnd/image/lead';
        $name = $file->getClientOriginalName();
       $s = $file->move($destinationPath, $name);
             $data['attachment'] = $name;
}
                 DB::table('leadstatus')->insert([	
                    'lead_id'         =>    $request->lead_id, 
                    'status'         =>    $request->status, 
                    'remark'         =>    $request->remark, 
                    'attachment'         =>    $data['attachment'] ??'', 
                    'createdby' => auth()->user()->teammember_id,
                     'updated_at' => date('Y-m-d H:i:s')     
                     ]);
                   $leads =  DB::table('leads')
                     ->leftjoin('clients','clients.id','leads.client_id')
                     ->leftjoin('teammembers','teammembers.id','leads.teammember_id')
                     ->where('leads.id', $request->lead_id)
                     ->select('leads.*','clients.client_name','teammembers.emailid')->first();
                     if($leads->teammember_id != null && auth()->user()->teammember_id != $leads->createdby){
                        $data = array(
                               'email' => $leads->emailid ??'',
                               'id' => $leads->id ??'',
                               'lead' => $leads,
                       );
                        Mail::send('emails.leadobserverform', $data, function ($msg) use($data){
                            $msg->to($data['email']);
                            $msg->subject('Kgs Lead Status Changed');
                         });
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
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
   public function edit($id)
    {
        $client = Client::latest()->get();
        $lead = Lead::where('id', $id)->first();
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
	    $concernpartner = Teammember::where('role_id',13)->where('status',1)->with('title','role')->get();
         return view('backEnd.lead.edit', compact('id','lead','client','teammember','concernpartner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'contactperson' => "required",
        ]);
        try {
            $data=$request->except(['_token','file']);
            $data['updatedby'] = auth()->user()->teammember_id;
            Lead::find($id)->update($data);
            $teammembermail = Teammember::where('id',$request->teammember_id)->pluck('emailid')->first();
            $data = array(
                   'email' => $teammembermail ??'',
                   'id' => $id ??'',
                   'EmployeeID' => $travel->Client_Name ??'',
           );
            Mail::send('emails.leadform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->subject('Kgs Lead Assign');
             }); 
            $output = array('msg' => 'Updated Successfully');
            return redirect('lead')->with('success', $output);
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
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
