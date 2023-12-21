<?php

namespace App\Http\Controllers;
use App\Models\Localconveyance;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teammember;
use App\Models\Client;
use DB;
class LocalconveyancesController extends Controller
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
        if(auth()->user()->teammember_id == 23){
        $localconveyanceData = DB::table('localconveyances')
   ->leftjoin('clients','clients.id','localconveyances.client_id')
   ->select('localconveyances.*','clients.client_name')->get();
       // dd($profileDatas);
     return view('backEnd.localconveyance.index',compact('localconveyanceData'));
            }
       elseif(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 12 or auth()->user()->role_id == 18){
        $localconveyanceData = DB::table('localconveyances')
   ->leftjoin('clients','clients.id','localconveyances.client_id')
   ->select('localconveyances.*','clients.client_name')->get();
       // dd($profileDatas);
        return view('backEnd.localconveyance.index',compact('localconveyanceData'));
            }
       else
	   {
        $localconveyanceData = DB::table('localconveyances')
        ->leftjoin('clients','clients.id','localconveyances.client_id')->
        where('localconveyances.createdby',auth()->user()->teammember_id)
        ->select('localconveyances.*','clients.client_name')->get();
       // dd($profileDatas);
        return view('backEnd.localconveyance.index',compact('localconveyanceData'));
	   }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $client = Client::select('id','client_name')->get();
      return view('backEnd.localconveyance.create',compact('client'));
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
            $data=$request->except(['_token','attachment']);
            $data['createdby'] = auth()->user()->teammember_id;
            $data['Status'] = 0;
           $localconveyance = Localconveyance::Create($data);
            $localconveyance->save();
            $id = $localconveyance->id;
			     $files = [];
            if($request->hasFile('attachment'))
            {
                
                foreach ($request->file('attachment') as $file) {

                    $destinationPath = 'backEnd/image/localconveyance';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                    $files[] = $name;
                    // $data['url'] = $name;
                 
                }
               
            }
            foreach($files as $filess )
            {
         
               $s = DB::table('localconveyanceattachments')->insert([
                    'localconveyance_id' => $id, 
                    'attachment' => $filess,
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);      
            }
            $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
            $data = array(
                'teammember' => $teammember->team_member ??'',
                'id' => $id ??''
        );
         Mail::send('emails.localconveyanceform', $data, function ($msg) use($data){
             $msg->to('vkverma@kgsomani.com');
             $msg->cc('priyankasharma@kgsomani.com');
             $msg->subject('New Local Conveyance Request');
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
     * @param  \App\Models\localconveyance  $localconveyance
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $localconveyance = DB::table('localconveyances')
        ->leftjoin('clients','clients.id','localconveyances.client_id')->
        where('localconveyances.id',$id)
        ->select('localconveyances.*','clients.client_name')->first();
        $localconveyancefile = DB::table('localconveyanceattachments')
       ->where('localconveyance_id',$id)->get();
        return view('backEnd.localconveyance.view',compact('localconveyance','localconveyancefile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\localconveyance  $localconveyance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::select('id','client_name')->get();
        $localconveyance = localconveyance::where('id', $id)->first();
       // dd($fullandfinal);
        return view('backEnd.localconveyance.edit', compact('id','localconveyance','client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\localconveyance  $localconveyance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token','attachment']);
            $data['updatedby'] = auth()->user()->teammember_id;
           
            Localconveyance::find($id)->update($data);
            $files = [];
            if($request->hasFile('attachment'))
            {
                
                foreach ($request->file('attachment') as $file) {

                    $destinationPath = 'backEnd/image/localconveyance';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                    $files[] = $name;
                    // $data['url'] = $name;
                 
                }
               
            }
            foreach($files as $filess )
            {
         
               $s = DB::table('localconveyanceattachments')->insert([
                    'localconveyance_id' => $id, 
                    'attachment' => $filess,
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);      
            }
            $createdby = Localconveyance::where('id',$id)->first();
            if($createdby->createdby == auth()->user()->teammember_id){
                DB::table('localconveyances')->where('id',$id)->update([	
                    'Status'         =>     0
                     ]);
                     $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
                     $data = array(
                         'teammember' => $teammember->team_member ??'',
                         'correction' => '',
                            'id' => $id ??''
                    );
                     Mail::send('emails.localconveyanceform', $data, function ($msg) use($data){
                        $msg->to('vkverma@kgsomani.com');
                        $msg->cc('priyankasharma@kgsomani.com');
                        $msg->subject('New Local Conveyance Request');
                     });  
            }
          if($request->Status == 1 || $request->Status == 2){
            $teammembermail = Teammember::where('id',$createdby->createdby)->first();
            $data = array(
                  'email' => $teammembermail->emailid ??'',
                   'status' => $createdby->Status ??'',
                   'name' => $teammembermail->team_member ??'',
                   'id' => $id ??''
           );
            Mail::send('emails.localconveyanceapprovelform', $data, function ($msg) use($data , $request){
                $msg->to($data['email']);
                if($request->Status == 1){
                    $msg->subject('Local Conveyance Request- Approved ');
                }
                if($request->Status == 2){
                    $msg->subject('Local Conveyance Request- Rejected');
                }

// $msg->cc($data['teammembermail']);
             });
             Mail::send('emails.localconveyanceaccountform', $data, function ($msg) use($data){
                $msg->to('tarunkumar@kgsomani.com');
                $msg->cc('priyankasharma@kgsomani.com');
                $msg->subject('Local Conveyance Request ');
// $msg->cc($data['teammembermail']);
             }); 
          }
          if($request->Status == 4){
            $teammembermail = Teammember::where('id',$createdby->createdby)->first();
            $data = array(
                  'email' => $teammembermail->emailid ??'',
                   'id' => $id ??''
           );
            Mail::send('emails.localconveyancecorrectionform', $data, function ($msg) use($data , $request){
                $msg->to($data['email']);
                $msg->subject('Local Conveyance Correction/Clarification');
                $msg->cc('priyankasharma@kgsomani.com');
// $msg->cc($data['teammembermail']);
             });
          }
            
            $output = array('msg' => 'Updated Successfully');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\localconveyance  $localconveyance
     * @return \Illuminate\Http\Response
     */
    public function destroy(localconveyance $localconveyance)
    {
        //
    }
	  public function assignmentFunction(Request $request)
    {
        if ($request->ajax()) {
            //  dd($request);
               if (isset($request->cid)) {
				    echo "<option value=''>Select Assignment</option>";
        foreach (DB::table('assignmentbudgetings')->join('assignments','assignments.id','assignmentbudgetings.assignment_id')
        ->where('client_id', $request->cid)->orderBy('assignmentgenerate_id')->get() as $sub) {
        echo "<option value='" . $sub->id . "'>" .$sub->assignment_name." (".$sub->assignmentgenerate_id .")". "</option>";
        
                   }
               }      
                   
           }
    
    }
}
