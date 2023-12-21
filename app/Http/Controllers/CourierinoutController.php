<?php

namespace App\Http\Controllers;
use App\Models\Teammember;
use App\Models\Courierinout;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class CourierinoutController extends Controller
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
            if(auth()->user()->teammember_id == 427 ){
                $courierDatas = DB::table('courierinouts')->where('type',0)
               ->leftjoin('teammembers','teammembers.id','courierinouts.assignedto')
               ->leftjoin('roles','roles.id','teammembers.role_id')
               ->select('courierinouts.*','teammembers.team_member','roles.rolename')->get();
                $courierreceiverDatas = DB::table('courierinouts')->where('type',1)
                ->leftjoin('teammembers','teammembers.id','courierinouts.handover_to')
                ->leftjoin('roles','roles.id','teammembers.role_id')
                ->select('courierinouts.*','teammembers.team_member','roles.rolename')->get();
           //   dd($courierreceiverDatas);
                return view('backEnd.courierinout.index',compact('courierDatas','courierreceiverDatas'));
            }
        elseif(auth()->user()->role_id == 11 ){
            $courierDatas = DB::table('courierinouts')->where('type',0)
           ->leftjoin('teammembers','teammembers.id','courierinouts.assignedto')
           ->leftjoin('roles','roles.id','teammembers.role_id')
           ->select('courierinouts.*','teammembers.team_member','roles.rolename')->get();
            $courierreceiverDatas = DB::table('courierinouts')->where('type',1)
            ->leftjoin('teammembers','teammembers.id','courierinouts.handover_to')
            ->leftjoin('roles','roles.id','teammembers.role_id')
            ->select('courierinouts.*','teammembers.team_member','roles.rolename')->get();
       //   dd($courierreceiverDatas);
            return view('backEnd.courierinout.index',compact('courierDatas','courierreceiverDatas'));
        }
		   elseif(auth()->user()->role_id == 13 ){
			    $courierDatas = DB::table('courierinouts')->where('type',0)
            ->leftjoin('teammembers','teammembers.id','courierinouts.assignedto')
            ->leftjoin('roles','roles.id','teammembers.role_id')
            ->where('assignedto',auth()->user()->teammember_id)
            ->select('courierinouts.*','teammembers.team_member','roles.rolename')->get();

             $courierreceiverDatas = DB::table('courierinouts')->where('type',1)
             ->leftjoin('teammembers','teammembers.id','courierinouts.handover_to')
             ->leftjoin('roles','roles.id','teammembers.role_id')
            ->where('handover_to',auth()->user()->teammember_id)
             ->select('courierinouts.*','teammembers.team_member','roles.rolename')->get();
        //   dd($courierreceiverDatas);
             return view('backEnd.courierinout.index',compact('courierDatas','courierreceiverDatas'));
		   }
        else
        {
            $courierDatas = DB::table('courierinouts')->where('type',0)
            ->leftjoin('teammembers','teammembers.id','courierinouts.assignedto')
            ->leftjoin('roles','roles.id','teammembers.role_id')
            ->orwhere('createdby',auth()->user()->teammember_id)
            ->orwhere('assignedto',auth()->user()->teammember_id)
            ->select('courierinouts.*','teammembers.team_member','roles.rolename')->get();

             $courierreceiverDatas = DB::table('courierinouts')->where('type',1)
             ->leftjoin('teammembers','teammembers.id','courierinouts.handover_to')
             ->leftjoin('roles','roles.id','teammembers.role_id')
             ->orwhere('createdby',auth()->user()->teammember_id)
             ->orwhere('handover_to',auth()->user()->teammember_id)
             ->select('courierinouts.*','teammembers.team_member','roles.rolename')->get();
        //   dd($courierreceiverDatas);
             return view('backEnd.courierinout.index',compact('courierDatas','courierreceiverDatas'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $teammember = Teammember::
      where('status','=',1)
      ->with('title','role')->get();
      return view('backEnd.courierinout.create',compact('teammember'));
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
        // $request->validate([
        //     'companyname' => "required",
        // ]);
        try {
            $data=$request->except(['_token']);
			if($request->hasFile('attachment'))
            {
                     $file=$request->file('attachment');
                    $destinationPath =  'backEnd/image/courier';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['attachment'] = $name;
				  $courierfile = url('/backEnd/image/courier/'.$data['attachment']);
            }
            else {
                $data['attachment']='';
				  $courierfile = '';
            }
            if ($request->type == 0) {
              $id =  DB::table('courierinouts')->insertGetId([
                    'type'   	=>$request->type,       
                    'courier_item_name'   =>$request->courier_item_name, 
                    'assignedto'   =>$request->assignedto, 
                    'address'   =>$request->address, 
                    'priority'   =>$request->priority, 
                    'tracking'   =>$request->tracking, 
				    'attachment'         =>      $data['attachment'], 
                    'status'=>  '0',
                     'createdby'   	=>     auth()->user()->teammember_id,     
                     'created_at'			    =>	   date('Y-m-d H:i:s'),
                     'updated_at'              =>    date('Y-m-d H:i:s'),
             ]);
             $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
             $approved = Teammember::where('id',$request->assignedto)->first();
             $data = array(
                 'teammember' => $teammember->team_member ??'',
                 'emailid' => $approved->emailid ??'',
                 'id' => $id ??'',
				  'courier_item_name' => $request->courier_item_name ??'',
         );
          Mail::send('emails.courierform', $data, function ($msg) use($data, $courierfile){
              $msg->to($data['emailid']);
               $msg->subject('New Courier Outward');
			   if($courierfile != null)
               {
               $msg->attach($courierfile);
               }
           }); 
            }
            else{
               $id =  DB::table('courierinouts')->insertGetId([
                    'type'   	=>$request->type,       
                    'courier_item_name'   =>$request->courier_item_name, 
                    'date_time'   =>$request->date_time, 
                    'handover_to'   =>$request->handover_to, 
                    'in_status'   => 0, 
				     'attachment'         =>      $data['attachment'], 
                     'createdby'   	=>     auth()->user()->teammember_id,     
                     'created_at'			    =>	   date('Y-m-d H:i:s'),
                     'updated_at'              =>    date('Y-m-d H:i:s'),
             ]);
             $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
             $approved = Teammember::where('id',$request->handover_to)->first();
             $data = array(
                 'teammember' => $teammember->team_member ??'',
                 'emailid' => $approved->emailid ??'',
                 'id' => $id ??'',
				   'courier_item_name' => $request->courier_item_name ??'',
         );
          Mail::send('emails.courierform', $data, function ($msg) use($data, $courierfile){
              $msg->to($data['emailid']);
               $msg->subject('New Courier Inward');
			     if($courierfile != null)
               {
               $msg->attach($courierfile);
               }
           });
           }  
             
            $output = array('msg' => 'Create Successfully');
            return redirect('courierinout')->with('success', $output);
      
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
    public function show($id)
    {
        $courierinout = DB::table('courierinouts')
        ->leftjoin('teammembers','teammembers.id','courierinouts.assignedto')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('courierinouts.id',$id)
        ->select('courierinouts.*','teammembers.team_member','roles.rolename')
        ->first();

        $courierinoutData = DB::table('courierinouts')
        ->leftjoin('teammembers','teammembers.id','courierinouts.handover_to')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('courierinouts.id',$id)
        ->select('courierinouts.*','teammembers.team_member','roles.rolename')
        ->first();
     //	dd($courierinoutData);
        return view('backEnd.courierinout.view',compact('courierinout','courierinoutData'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
   
    public function senderupdate(Request $request, $id)
    {
      //  dd($request);
        try {
            $data=$request->except(['_token']);
            if($request->hasFile('tracking_image'))
            {
                     $file=$request->file('tracking_image');
                    $destinationPath =  'backEnd/image/courier';
                    $name = time().$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['tracking_image'] = $name;
            }
            $data['updatedby'] = auth()->user()->teammember_id;
            $data['status'] = 1;
            Courierinout::find($id)->update($data);
			           
          
            $output = array('msg' => 'Updated Successfully');
            return redirect('courierinout')->with('success', $output);
     
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
    public function sender(Request $request, $id)
    {
      //  dd($request);
        try {
            $data=$request->except(['_token']);
           
            $data['updatedby'] = auth()->user()->teammember_id;
            Courierinout::find($id)->update($data);
         
            $output = array('msg' => 'Updated Successfully');
            return redirect('courierinout')->with('success', $output);
     
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function receiverupdate(Request $request, $id)
    {
      //  dd($request);
        try {
            $data=$request->except(['_token']);
         
            $data['updatedby'] = auth()->user()->teammember_id;
            Courierinout::find($id)->update($data);
			           
          
            $output = array('msg' => 'Updated Successfully');
            return redirect('courierinout')->with('success', $output);
     
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    
}
