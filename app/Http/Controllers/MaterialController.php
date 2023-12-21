<?php

namespace App\Http\Controllers;
use App\Models\Teammember;
use App\Models\Material;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class MaterialController extends Controller
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
            $materialDatas = DB::table('materials')
           ->leftjoin('teammembers','teammembers.id','materials.receiver')
           ->leftjoin('roles','roles.id','teammembers.role_id')
           ->where('type',0)
           ->select('materials.*','teammembers.team_member','roles.rolename')->get();

            $materialoutDatas = DB::table('materials')
            ->leftjoin('teammembers','teammembers.id','materials.approvedby')
            ->leftjoin('roles','roles.id','teammembers.role_id')
            ->where('type',1)
            ->select('materials.*','teammembers.team_member as team','roles.rolename')->get();
            }
        elseif(auth()->user()->role_id == 11 ){
            $materialDatas = DB::table('materials')
           ->leftjoin('teammembers','teammembers.id','materials.receiver')
           ->leftjoin('roles','roles.id','teammembers.role_id')
           ->where('type',0)
           ->select('materials.*','teammembers.team_member','roles.rolename')->get();

            $materialoutDatas = DB::table('materials')
            ->leftjoin('teammembers','teammembers.id','materials.approvedby')
            ->leftjoin('roles','roles.id','teammembers.role_id')
            ->where('type',1)
            ->select('materials.*','teammembers.team_member as team','roles.rolename')->get();
            }
            else
            {
                $materialDatas = DB::table('materials')
                ->leftjoin('teammembers','teammembers.id','materials.receiver')
                ->leftjoin('roles','roles.id','teammembers.role_id')
                ->where('type',0)
                ->where('createdby',auth()->user()->teammember_id)
                ->orwhere('receiver',auth()->user()->teammember_id)
                ->select('materials.*','teammembers.team_member','roles.rolename')->get();
     
                 $materialoutDatas = DB::table('materials')
                 ->leftjoin('teammembers','teammembers.id','materials.approvedby')
                 ->leftjoin('roles','roles.id','teammembers.role_id')
                 ->where('type',1)
                 ->where('createdby',auth()->user()->teammember_id)
                 ->orwhere('approvedby',auth()->user()->teammember_id)
                 ->select('materials.*','teammembers.team_member as team','roles.rolename')->get();
  }
            return view('backEnd.material.index',compact('materialDatas','materialoutDatas'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $teammember = Teammember::where('status','1')->where('role_id','=',13)->orwhere('role_id','=',14)
		  ->orwhere('role_id','=',16)
      ->with('title','role')->get();
      $partner = Teammember::where('status','1')->where('role_id','=',13)->orwhere('role_id','=',14)
		   ->orwhere('role_id','=',16)
      ->with('title','role')->get();
  //    dd($partner);
      return view('backEnd.material.create',compact('teammember','partner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    dd($request);
        // $request->validate([
        //     'type' => "required",
        // ]);
        try {
            $data=$request->except(['_token']);
            if ($request->type == 0) {
               $id =  DB::table('materials')->insertGetId([
                    'type'   	=>$request->type,       
                    'item_name'   =>$request->item_name, 
                    'date_time'   =>$request->date_time, 
                    'quantity'   =>$request->quantity, 
                    'sender_name'   =>$request->sender_name,
                    'item_value'   =>$request->item_value,
                    'receiver'     =>$request->receiver,
                    'status'=>  '0',
                     'createdby'   	=>  auth()->user()->teammember_id,     
                     'created_at'			    =>	   date('Y-m-d H:i:s'),
                     'updated_at'              =>    date('Y-m-d H:i:s'),
             ]);

             
             $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
             $approved = Teammember::where('id',$request->receiver)->first();
             $data = array(
                 'teammember' => $teammember->team_member ??'',
                 'emailid' => $approved->emailid ??'',
                 'id' => $id ??''
         );
          Mail::send('emails.materialformin', $data, function ($msg) use($data){
              $msg->to($data['emailid']);
               $msg->subject('New Material Inward');
           }); 

            }
            else{
                $id =  DB::table('materials')->insertGetId([
                    'type'   	=>$request->type,       
                    'item_name'   =>$request->item_name, 
                    'quantity'   =>$request->quantity, 
                    'date_time'   =>$request->date_time,
                    'price'   =>$request->price,
                    'item_detail'   =>$request->item_detail,
                    'approvedby'   =>$request->approved,
                    'item_type'   =>$request->item_type,
                    'expected_date'   =>$request->expected_date, 
                    'out_status'=>  '0',
                     'createdby'   	=>     auth()->user()->teammember_id,     
                     'created_at'			    =>	   date('Y-m-d H:i:s'),
                     'updated_at'              =>    date('Y-m-d H:i:s'),
             ]);

             $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
             $approved = Teammember::where('id',$request->approved)->first();
          //   dd($approved);
             $data = array(
                 'teammember' => $teammember->team_member ??'',
                 'emailids' => $approved->emailid ??'',
                 'id' => $id ??''
         );
          Mail::send('emails.materialform', $data, function ($msg) use($data){
              $msg->to($data['emailids']);
               $msg->subject('New Material Outward Request');
           }); 
           }  
             
            $output = array('msg' => 'Create Successfully');
            return redirect('material')->with('success', $output);
      
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
        $material = DB::table('materials')
        ->leftjoin('teammembers','teammembers.id','materials.receiver')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('materials.id',$id)
        ->select('materials.*','teammembers.team_member','roles.rolename')
        ->first();

        $materialoutData = DB::table('materials')
        ->leftjoin('teammembers','teammembers.id','materials.approvedby')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('materials.id',$id)
        ->select('materials.*','teammembers.team_member','roles.rolename')
        ->first();
     //	dd($materialoutData);
        return view('backEnd.material.view',compact('material','materialoutData'));
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
          
            $data['updatedby'] = auth()->user()->teammember_id;
            $data['out_status'] = $request->out_status;
            $data['reject_for_reaction'] = $request->reject_for_reaction;
            Material::find($id)->update($data);
			           
            $output = array('msg' => 'Updated Successfully');
            return redirect('material')->with('success', $output);
     
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
 
    public function receiverupdate(Request $request, $id)
    {
      //  dd($request);
        try {
            $data=$request->except(['_token']);
         
            $data['updatedby'] = auth()->user()->teammember_id;
            $data['status'] = $request->status;
            Material::find($id)->update($data);
			           
            $output = array('msg' => 'Updated Successfully');
            return redirect('material')->with('success', $output);
     
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    
}
