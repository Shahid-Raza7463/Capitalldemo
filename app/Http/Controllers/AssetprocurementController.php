<?php

namespace App\Http\Controllers;

use App\Models\Assetprocurement;
use App\Models\Teammember;
use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
class AssetprocurementController extends Controller
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
public function assetfetch_id(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $outstationconveyances = DB::table('assetprocurements')
              ->select('assetprocurements.id')->
              where('assetprocurements.id',$request->id)->first();
                return response()->json($outstationconveyances);
             }
            }
    
    } 
    public function assetupdate(Request $request)
    {
       // dd($request);
        try {
            $data=$request->except(['_token']);
            if($request->Status == 3){
        DB::table('assetprocurements')->where('id',$request->assetprocurementid)->update([	
                'Status'         =>     $request->Status,
                'payment'         =>     $request->payment,
                'processingdate' => date('Y-m-d H:i:s'),
                 ]);
          
                }
              
               
            $output = array('msg' => 'Update Successfully');
            return redirect('assetprocurement')->with('success', $output);
     
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
           if(auth()->user()->teammember_id == 161 || auth()->user()->teammember_id == 160){
			    $assetprocurementDatas  =DB::table('assetprocurements')
            ->leftjoin('teammembers','teammembers.id','assetprocurements.teammember_id')
           
                 ->select('assetprocurements.*','teammembers.team_member')->orderBy('id', 'desc')->get();
      return view('backEnd.assetprocurement.assetprocurementindex',compact('assetprocurementDatas'));
		   }
        elseif(auth()->user()->role_id == 17 || auth()->user()->role_id == 11 || auth()->user()->role_id == 16){
            $assetprocurementDatas  =DB::table('assetprocurements')
            ->leftjoin('teammembers','teammembers.id','assetprocurements.teammember_id')
           
                 ->select('assetprocurements.*','teammembers.team_member')->orderBy('id', 'desc')->get();
      return view('backEnd.assetprocurement.assetprocurementindex',compact('assetprocurementDatas'));
      }
      else {
          $assetprocurementDatas  =DB::table('assetprocurements')
          ->leftjoin('teammembers','teammembers.id','assetprocurements.teammember_id')
               ->where('createdby',auth()->user()->teammember_id)
               ->select('assetprocurements.*','teammembers.team_member')->orderBy('id', 'desc')->get();
    //  dd( $assetprocurementDatas);
               $assetprocurementapprovedDatas  =DB::table('assetprocurements')
          ->leftjoin('teammembers','teammembers.id','assetprocurements.teammember_id')
        ->where('teammember_id',auth()->user()->teammember_id)
               ->select('assetprocurements.*','teammembers.team_member')->orderBy('id', 'desc')->get();
         return view('backEnd.assetprocurement.index',compact('assetprocurementDatas','assetprocurementapprovedDatas'));
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
        return view('backEnd.assetprocurement.create',compact('teammember','client','authteammember'));
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
        //     'client_id' => "required",
        // ]);

        try {
            $data=$request->except(['_token','attachment']);
            $data['createdby'] = auth()->user()->teammember_id;
         $data['Status'] = 0;
          
                if($request->hasFile('bill'))
                {
                    $file=$request->file('bill');
                        $destinationPath = 'backEnd/image/assetprocurements';
                        $name = $file->getClientOriginalName();
                       $s = $file->move($destinationPath, $name);
                             //  dd($s); die;
                             $data['bill'] = $name;
                   
                }
            $assetprocurementModel =  Assetprocurement::Create($data);
            $assetprocurementModel->save();
            $id = $assetprocurementModel->id;
            $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
		
            $travel = Assetprocurement::where('id', $id)->first();
            $teammembermail = Teammember::where('id',$request->teammember_id)->pluck('emailid')->first();
            $data = array(
                'teammember' => $teammember->team_member ??'',
               
                   'email' => $teammembermail ??'',
                   'id' => $id ??'',
                   'EmployeeID' => $travel->Client_Name ??'',
           );
            Mail::send('emails.assetprocurementform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->subject('Kgs Asset Procurement Form Request');
             }); 
            $output = array('msg' => 'Create Successfully');
            return redirect('assetprocurement')->with('success', $output);
        
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
        $assetprocurements = DB::table('assetprocurements')
        ->leftjoin('teammembers','teammembers.id','assetprocurements.teammember_id')
       ->where('assetprocurements.id',$id)
             ->select('assetprocurements.*','teammembers.team_member')->first();
        //   dd($assetprocurements);
         return view('backEnd.assetprocurement.view', compact('id','assetprocurements'));
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
        return view('backEnd.assetprocurementsedit', compact('id','travel','teammember','client','authteammember'));
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
        try {
            $data=$request->except(['_token']);
            if($request->hasFile('bill'))
            {
                $file=$request->file('bill');
                    $destinationPath = 'backEnd/image/assetprocurements';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['bill'] = $name;
               
            }
            // $data['updatedby'] = auth()->user()->teammember_id;
            Assetprocurement::find($id)->update($data);
            $createdby = Assetprocurement::where('id',$id)->first();
          //  dd($createdby);
            $teammembermail = Teammember::where('id',$createdby->createdby)->first();
            $data = array(
                  'email' => $teammembermail->emailid ??'',
                   'status' => $createdby->Status ??'',
                   'name' => $teammembermail->team_member ??'',
                   'id' => $id ??''
           );
            Mail::send('emails.assetprocurementapprovelform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->subject('Kgs Assetprocurement Form ');
// $msg->cc($data['teammembermail']);
             }); 
            Mail::send('emails.assetprocurementaccountform', $data, function ($msg) use($data){
                $msg->to(['accounts@kgsomani.com','finance@kgsomani.com']);
                $msg->subject('Kgs Assetprocurement Form ');
// $msg->cc($data['teammembermail']);
             }); 
            $output = array('msg' => 'Update Successfully');
             return redirect('assetprocurement')->with('success', $output);
     
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
