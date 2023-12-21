<?php

namespace App\Http\Controllers;
use App\Models\Replyticket;
use Illuminate\Support\Facades\Mail;
use App\Models\Assetticket;
use App\Models\Teammember;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
class AssetticketController extends Controller
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
	 public function createTicket()
    {
          $assetDatas = DB::table('assets')
   ->leftjoin('financerequests','financerequests.id','assets.financerequest_id')->
   where('assets.teammember_id',auth()->user()->teammember_id)
   ->select('assets.id','financerequests.modal_name','financerequests.id as financeid','financerequests.sno','financerequests.kgs'
   ,'financerequests.description','financerequests.assetstatus','financerequests.acknowledge')->orderBy('assetstatus','asc')->get();
       return view('backEnd.createticket',compact('assetDatas'));
    }
     public function index()
    {
		   if(auth()->user()->teammember_id == 173){
        $ticketDatas =  DB::table('assettickets')
        ->leftjoin('assets','assets.id','assettickets.asset_id')
              ->leftjoin('teammembers','teammembers.id','assettickets.created_by')
			 ->where('assettickets.type', '0')
        ->select('assettickets.*','assets.item','teammembers.team_member')->get();
      //  dd($ticketDatas);
        return view('backEnd.assetticket.index',compact('ticketDatas'));
    }
		   elseif(auth()->user()->role_id == 11){
        $ticketDatas =  DB::table('assettickets')
        ->leftjoin('assets','assets.id','assettickets.asset_id')
              ->leftjoin('teammembers','teammembers.id','assettickets.created_by')
		
        ->select('assettickets.*','assets.item','teammembers.team_member')->get();
      //  dd($ticketDatas);
        return view('backEnd.assetticket.index',compact('ticketDatas'));
    }
		    elseif(auth()->user()->role_id == 16){
        $ticketDatas =  DB::table('assettickets')
        ->leftjoin('assets','assets.id','assettickets.asset_id')
              ->leftjoin('teammembers','teammembers.id','assettickets.created_by')
			->where('assettickets.type', '0')
        ->select('assettickets.*','assets.item','teammembers.team_member')->get();
      //  dd($ticketDatas);
        return view('backEnd.assetticket.index',compact('ticketDatas'));
    }
		    elseif(auth()->user()->role_id == 17){
        $ticketDatas =  DB::table('assettickets')
        ->leftjoin('assets','assets.id','assettickets.asset_id')
              ->leftjoin('teammembers','teammembers.id','assettickets.created_by')
			->where('assettickets.type', '1')
        ->select('assettickets.*','assets.item','teammembers.team_member')->get();
      //  dd($ticketDatas);
        return view('backEnd.assetticket.index',compact('ticketDatas'));
    }
		 else
		 {
		   $ticketDatas =  DB::table('assettickets')
        ->leftjoin('assets','assets.id','assettickets.asset_id')
              ->leftjoin('teammembers','teammembers.id','assettickets.created_by')->
			   where('assettickets.created_by', auth()->user()->teammember_id)
        ->select('assettickets.*','assets.item','teammembers.team_member')->get();
      //  dd($ticketDatas);
        return view('backEnd.assetticket.index',compact('ticketDatas'));
		 }
	 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ticketStore(Request $request)
    { 
       // dd($request);
        $request->validate([
            'subject' => "required",
            'priority' => "required",
            'subject' => "required"
        ]);
        try {
            $authid =  auth()->user()->teammember_id;
            $data=$request->except(['_token']);
            if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/ticketattachment',$filename);
                $data['attachment']=$filename;
            }
            $data['created_by']=$authid;
            $data['generateticket_id']=sprintf("%06d", mt_rand(1,99999999));
             $assetticket = Assetticket::Create($data);
            $assetticket->save();
            $id = $assetticket->id;
			
			 $user=User::select('fcm')->where('role_id','16')->get();
             $this->sendGCMBulk($user, $request->subject,$request->message,'', 'notification');
			
			  $team = DB::table('teammembers')->where('id',auth()->user()->teammember_id)->first();
             if ($request->type == 1) {
                $data = array(
                    'name' => $team->team_member ??'',
                  'id' => $id,
              );
               Mail::send('emails.ticketmailform', $data, function ($msg) use($data){
                   $msg->to('accounts@kgsomani.com');
                   $msg->subject('New Accounts/Finance Ticket Query');
                });
             }
             elseif ($request->type == 0) {
                $data = array(
                    'name' => $team->team_member ??'',
                    'id' => $id,
              );
               Mail::send('emails.ticketmailform', $data, function ($msg) use($data){
                   $msg->to('it@kgsomani.com');
                   $msg->cc('amitgaur@kgsomani.com');
                   $msg->subject('New IT Ticket Query');
                });
             }
			
            $output = array('msg' => 'Created Successfully');
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
     * @param  \App\Models\Assetticket  $Assetticket
     * @return \Illuminate\Http\Response
     */
    public function show(Assetticket $Assetticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assetticket  $Assetticket
     * @return \Illuminate\Http\Response
     */
    public function ticketReply($id)
     {
        $ticketDatas =  DB::table('assettickets')
        ->leftjoin('teammembers','teammembers.id','assettickets.created_by')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('assettickets.id',$id)
        ->select('assettickets.*','teammembers.team_member','teammembers.id as teamid','roles.rolename')->first();
       // dd($ticketDatas);
       $ticketreply  = DB::table('replytickets')->leftjoin('teammembers','teammembers.id','replytickets.createdby')
       ->where('ticketid',$ticketDatas->generateticket_id)
       ->select('replytickets.*','teammembers.team_member')
       ->get();
      // dd($ticketreply);
        return view('backEnd.assetticket.edit',compact('id','ticketDatas','ticketreply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assetticket  $Assetticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assetticket  $Assetticket
     * @return \Illuminate\Http\Response
     */
	    public function ticketreplyDone(Request $request)
    { 
        // dd($request);
        
         try {
			    DB::table('assettickets')->where('generateticket_id',$request->ticketid)->update([	
                'status'         =>    $request->status, 
                 'updated_at' => date('y-m-d')     
                 ]);
             $data=$request->except(['_token']);
             if($request->hasFile('attachment'))
             {
                 $file=$request->file('attachment');
                 $extension=$file->getClientOriginalExtension();
                 $filename=time().'.'.$extension;
                 $file->move('backEnd/image/ticketreplyattachment',$filename);
                 $data['attachment']=$filename;
             }
             $data['createdby']=auth()->user()->teammember_id;
             Replyticket::Create($data);
			
			  $user=User::select('fcm')->where('teammember_id',$request->teamid)->get();
			 if($user->isNotEmpty())
			 {
				  $this->sendGCMBulk($user, $request->reply,'','', 'notification');
			 }
            
			 
             $output = array('msg' => 'Reply Successfully');
             return back()->with('success', $output);
     } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }    
 }
    public function destroy(Assetticket $Assetticket)
    {
        //
    }
}
