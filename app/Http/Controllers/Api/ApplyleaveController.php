<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Applyleave;
use App\Models\Teammember;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
use Carbon;
class ApplyleaveController extends Controller
{
  
    public function leave_List(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teammemberid' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
              $role = Teammember::where('id', $request->teammemberid)->pluck('role_id')->first();
                if($role == 11 || $role == 18){
              $result = DB::table('applyleaves')
              ->leftjoin('leavetypes','leavetypes.id','applyleaves.leavetype')
              ->leftjoin('teammembers','teammembers.id','applyleaves.createdby')
              ->leftjoin('teammembers as approver','approver.id','applyleaves.approver')
            ->select('applyleaves.id','applyleaves.reasonleave','applyleaves.from','applyleaves.to'
            ,'applyleaves.created_at','applyleaves.status','applyleaves.updated_at as days','teammembers.team_member as employee',
            'approver.team_member as approver','approver.id as approverid'
            ,'leavetypes.name')->latest()->get();

            foreach($result as $res)
            {
            
                if($res->status==0)
                {
                  $res->status = "Created";
                }
                else if($res->status==1)
                {
                  $res->status = "Approved";
                }
                elseif($res->status==2){
                  $res->status = "Rejected"; 
                }
             
                $to = Carbon\Carbon::createFromFormat('Y-m-d',$res->to ??'');
                $from = Carbon\Carbon::createFromFormat('Y-m-d',$res->from);
                $diff_in_days = $to->diffInDays($from) + 1 ;
                $holidaycount = DB::table('holidays')->where('startdate','>=',$res->from)
                ->where('enddate', '<=',$res->to)
                    ->count();

                if($res->days!=null)
                {
                  $res->days = $diff_in_days  - $holidaycount;
               
                }
          }
                }
                else {
                  $result = DB::table('applyleaves')
                  ->leftjoin('leavetypes','leavetypes.id','applyleaves.leavetype')
                  ->leftjoin('teammembers','teammembers.id','applyleaves.createdby')
                  ->leftjoin('teammembers as approver','approver.id','applyleaves.approver')
					  
                  ->where('applyleaves.createdby',$request->teammemberid)
                  ->orwhere('applyleaves.approver',$request->teammemberid)
                ->select('applyleaves.id','applyleaves.reasonleave','applyleaves.from','applyleaves.to'
                ,'applyleaves.created_at','applyleaves.status','applyleaves.updated_at as days','teammembers.team_member as employee',
                'approver.team_member as approver','approver.id as approverid'
                ,'leavetypes.name')->latest()->get();
    
                foreach($result as $res)
                {
                
                    if($res->status==0)
                    {
                      $res->status = "Created";
                    }
                    else if($res->status==1)
                    {
                      $res->status = "Approved";
                    }
                    elseif($res->status==2){
                      $res->status = "Rejected"; 
                    }
                 
                    $to = Carbon\Carbon::createFromFormat('Y-m-d',$res->to ??'');
                    $from = Carbon\Carbon::createFromFormat('Y-m-d',$res->from);
                    $diff_in_days = $to->diffInDays($from) + 1 ;
                    $holidaycount = DB::table('holidays')->where('startdate','>=',$res->from)
                    ->where('enddate', '<=',$res->to)
                        ->count();
    
                    if($res->days!=null)
                    {
                      $res->days = $diff_in_days  - $holidaycount;
                   
                    }
              }
                }
              if($result->isEmpty()){
             
                return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                          }
          else {
            return response()->json(["output" => $result,"status" =>"true","code" =>"10001"]);
          }
         

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
     public function leave_approval(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'leaveid' => 'required',
            ]);
    
      
            if ($validator->fails()) {
                $response['msg'] = $validator->errors();
                $response['status'] = 0;
            
                return  response()->json($response);
            }
                try {
                  if($request->status == 1)
    {
        $team = DB::table('applyleaves')
        ->leftjoin('leavetypes','leavetypes.id','applyleaves.leavetype')
        ->leftjoin('teammembers','teammembers.id','applyleaves.createdby')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('applyleaves.id',$request->leaveid)
       ->select('applyleaves.*','teammembers.emailid','teammembers.team_member','roles.rolename','leavetypes.name','leavetypes.holiday')->first();
     //  dd($team);
      if($team->leavetype == '4' && $team->type == '1'){
        $to = Carbon::createFromFormat('Y-m-d',$team->to ??'');
        $from = Carbon::createFromFormat('Y-m-d',$team->from);
       
        $requestdays = $to->diffInDays($from) + 1;
    // dd($requestdays);
         $holidaycount = DB::table('holidays')->where('startdate','>=',$team->from)
         ->where('enddate', '<=',$team->to)
        ->count();
        // dd($holidaycount);
               $totalrqstday = $requestdays - $holidaycount;
               //   dd($totalrqstday); die;
         
           DB::table('leaveapprove')->insert([
              'teammemberid'   	=>     $team->createdby,
              'leavetype'   	=>     $team->leavetype,
              'totaldays'   	=>     $totalrqstday,
              'created_at'			    =>	   date('y-m-d'),
              'updated_at'              =>    date('y-m-d'),
          ]);
  }
      elseif($team->leavetype == '4' && $team->type == '0'){
        $to = Carbon\Carbon::createFromFormat('Y-m-d',$team->to ??'');
        $from = Carbon\Carbon::createFromFormat('Y-m-d',$team->from);
       
        $requestdays = $to->diffInDays($from) + 1;
   //  dd($requestdays);
         $holidaycount = DB::table('holidays')->where('startdate','>=',$team->from)
         ->where('enddate', '<=',$team->to)
        ->count();
        // dd($holidaycount);
               $totalrqstday = $requestdays - $holidaycount;
               //   dd($totalrqstday); die;
         
           DB::table('leaveapprove')->insert([
              'teammemberid'   	=>     $team->createdby,
              'leavetype'   	=>     $team->leavetype,
              'type'   	=>     $team->type,
              'totaldays'   	=>     $totalrqstday,
              'created_at'			    =>	   date('y-m-d'),
              'updated_at'              =>    date('y-m-d'),
          ]);
  }
        if($team->name == 'Casual Leave'){
          $to = Carbon\Carbon::createFromFormat('Y-m-d',$team->to ??'');
          $from = Carbon\Carbon::createFromFormat('Y-m-d',$team->from);
         
          $requestdays = $to->diffInDays($from) + 1;
      // dd($requestdays);
           $holidaycount = DB::table('holidays')->where('startdate','>=',$team->from)
           ->where('enddate', '<=',$team->to)
          ->count();
       //   dd($holidaycount);
                 $totalrqstday = $requestdays - $holidaycount;
                //    dd($totalrqstday); die;
           
             DB::table('leaveapprove')->insert([
                'teammemberid'   	=>     $team->createdby,
                'leavetype'   	=>     $team->leavetype,
                'totaldays'   	=>     $totalrqstday,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
    }
        if($team->name == 'Exam Leave'){
          $to = Carbon::createFromFormat('Y-m-d',$team->to ??'');
          $from = Carbon::createFromFormat('Y-m-d',$team->from);
         
          $requestdays = $to->diffInDays($from) + 1;
      // dd($requestdays);
           $holidaycount = DB::table('holidays')->where('startdate','>=',$team->from)
           ->where('enddate', '<=',$team->to)
          ->count();
       //   dd($holidaycount);
                 $totalrqstday = $requestdays - $holidaycount;
                //    dd($totalrqstday); die;
           
             DB::table('leaveapprove')->insert([
                'teammemberid'   	=>     $team->createdby,
                'leavetype'   	=>     $team->leavetype,
                'totaldays'   	=>     $totalrqstday,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
    }
    if($team->name == 'Sick Leave'){
      $to = Carbon::createFromFormat('Y-m-d',$team->to ??'');
      $from = Carbon::createFromFormat('Y-m-d',$team->from);
     
      $requestdays = $to->diffInDays($from) + 1;
  // dd($requestdays);
       $holidaycount = DB::table('holidays')->where('startdate','>=',$team->from)
       ->where('enddate', '<=',$team->to)
      ->count();
    // dd($holidaycount);
             $totalrqstday = $requestdays - $holidaycount;
             // dd($totalrqstday); die;
       
         DB::table('leaveapprove')->insert([
            'teammemberid'   	=>     $team->createdby,
            'leavetype'   	=>     $team->leavetype,
            'totaldays'   	=>     $totalrqstday,
            'created_at'			    =>	   date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
        ]);
}
        $applyleaveteam = DB::table('leaveteams')
        ->leftjoin('teammembers','teammembers.id','leaveteams.teammember_id')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('leaveteams.leave_id',$request->leaveid)
       ->select('teammembers.emailid')->get();
       if($applyleaveteam != null){
       foreach ($applyleaveteam as $applyleaveteammail ) {
$data = array(
'emailid' =>  $applyleaveteammail->emailid,
'team_member' =>  $team->team_member,
'from' =>  $team->from,
'to' =>  $team->to,
);

// Mail::send('emails.applyleaveteam', $data, function ($msg) use($data){
//     $msg->to($data['emailid']);
//     $msg->subject('kgs Leave Approved');
// });
}
       }
       $data = array(
        'emailid' =>  $team->emailid,
        'id' =>  $request->leaveid,
        'from' =>  $team->from,
        'to' =>  $team->to,
        );
        
        // Mail::send('emails.applyleavestatus', $data, function ($msg) use($data){
        //     $msg->to($data['emailid']);
        //     $msg->cc('priyankasharma@kgsomani.com');
        //     $msg->subject('kgs Leave Approved');
        // });
      
    }
    if($request->status == 2)
    {
        $team = DB::table('applyleaves')
        ->leftjoin('leavetypes','leavetypes.id','applyleaves.leavetype')
        ->leftjoin('teammembers','teammembers.id','applyleaves.createdby')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('applyleaves.id',$request->leaveid)
       ->select('applyleaves.*','teammembers.emailid','teammembers.team_member','roles.rolename','leavetypes.name')->first();
        $data = array(
            'emailid' =>  $team->emailid,
            'id' =>  $request->leaveid,
            'from' =>  $team->from,
            'to' =>  $team->to,
            );
            
            // Mail::send('emails.applyleavereject', $data, function ($msg) use($data){
            //     $msg->to($data['emailid']);
            //     $msg->cc('priyankasharma@kgsomani.com');
            //     $msg->subject('kgs Leave Reject');
            // });
    }
    $data=$request->except(['_token','teammember_id','leaveid']);
   // $data['updatedby'] = auth()->user()->teammember_id;
    $id = $request->leaveid;
   Applyleave::find($id)->update($data);

                    $result =  "data update done";
                    if(is_null($result)){
     
                      return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                                }
                else {
                  return response()->json(["output" => $result,"status" =>"true","code" =>"10001"]);
                }
    
               } catch (\Exception $e) {
                   $response['result'] = "failed";
                   $response['msg'] = "Something went wrong ". $e->getMessage();
                   $response['code'] = "500";
                   Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
               }
            
               return response()->json($response);
            
                
              }
}
