<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\imports\Atrimport;
use App\Models\Teammember;
use App\Models\Atr;
use App\Models\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Excel;
class AtrController extends Controller
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
    public function atrUpdate(Request $request )
    {
     // dd($request);
     $request->validate([
         'auditors_final_comments' => 'required'
     ]);
   
     try {
         $data = $request->except(['_token']);
         Atr::find($request->id)->update($data);
        $output = array('msg' => 'Update successfully');
         return back()->with('success', $output);
     } catch (Exception $e) {
         DB::rollBack();
         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
         report($e);
         $output = array('msg' => $e->getMessage());
         return back()->withErrors($output)->withInput();
     }
  }
  public function show($id)
    {
       // dd($id);
          $atrData =Atr::with('atrfile','clientlogin')
          ->where('client_id',$id)->get();
          $member = DB::table('clientlogins')->whereClient_id($id)->get();
          $ccmember = DB::table('teammembers')->whereStatus('1')->select('teammembers.id','teammembers.team_member')->get();
         // dd($ccmember);
         return view('backEnd.atr.index',compact('atrData','id','member','ccmember'));

  }
  public function atrAssign(Request $request )
  {
//    $request->validate([
//        'file' => 'required'
//    ]);
 
   try {
       $data = $request->except(['_token']);
       DB::table('atrs')->where('id',$request->atrid)->update([	
        'responsible_person'         =>     $request->responsible_person
         ]);
       $atr =   DB::table('atrs')
         ->leftjoin('clientlogins','clientlogins.id','atrs.responsible_person')
         ->leftjoin('clients','clients.id','atrs.client_id')
         ->select('atrs.*','clientlogins.name','clientlogins.email','clients.client_name')
         ->where('atrs.id', $request->atrid)->first();
         $data = array(
            'email' => $atr->email ??'',
              'name' => $atr->name ??'',
              'subject' =>  'Regarding ATR of'.' '. $atr->client_name
      );
       Mail::send('emails.atrassigns', $data, function ($msg) use($data){
           $msg->to($data['email']);
           $msg->subject($data['subject']);
        }); 
      $output = array('msg' => 'assign successfully');
       return back()->with('success', $output);
   } catch (Exception $e) {
       DB::rollBack();
       Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
       report($e);
       $output = array('msg' => $e->getMessage());
       return back()->withErrors($output)->withInput();
   }
}
public function assigned(Request $request)
{
  // dd($request);
    if ($request->ajax()) {
        if (isset($request->id)) {
         //   dd($request->id);
          $conversion = DB::table('atrs')
        ->where('id',$request->id)->first();
      //  dd($conversion);
            return response()->json($conversion);
         }
        }

}
  public function atrUpload(Request $request )
  {
   $request->validate([
       'file' => 'required'
   ]);
 
   try {
       $file=$request->file;
     
       $data = $request->except(['_token']);
       $dataa=Excel::toArray(new Atrimport, $file);
       
       foreach ($dataa[0] as $key => $value) {
           
           $db['fy']=$value['fy'] ;
           $db['quarter']=$value['quarter'] ;
           $db['area']=$value['area'] ;
           $db['observations']=$value['observations'] ;
		   $db['risk']=$value['risk'] ;
           $db['client_id']=$request->clientid ;
             $db['status']='0';
           $db['createdby']=auth()->user()->teammember_id;

        //   dd($db);
           Atr::Create($db);
       
         
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
public function view($id)
{

    $atr = Atr::with('clientlogin')
    ->where('atrs.id', $id)->first();
$atrfile = DB::table('atrfiles')->where('atrfiles.atrfiles_id',$id)->get();
    return view('backEnd.atr.view', compact('id','atr','atrfile'));
}
public function atrReminder($id)
{

    $atr =  DB::table('atrs')
    ->leftjoin('clientlogins','clientlogins.id','atrs.responsible_person')
    ->leftjoin('clients','clients.id','atrs.client_id')
    ->select('atrs.*','clientlogins.name','clientlogins.email','clients.client_name')
    ->where('atrs.id', $id)->first();
    $data = array(
        'email' => $atr->email ??'',
          'name' => $atr->name ??'',
          'subject' => 'REMINDER : Submission of ATR reply'.' '. $atr->client_name .' '. $atr->fy .' ' . $atr->quarter.' '. $atr->area
  );
   Mail::send('emails.atrreminder', $data, function ($msg) use($data){
       $msg->to($data['email']);
       $msg->subject($data['subject']);
    }); 
    $output = array('msg' => 'Reminder Send Successfully');
    return back()->with('success', $output);
}
public function assignPerson(Request $request)
    
{ 
//dd($request);
            try {
       
        if($request->fyquarter[0] != null){
      
       //  dd($request->fyy);
            DB::table('atrs')->wherein('id',$request->fyquarter)->update([ 
                'responsible_person'         =>  $request->member 
                ]);
             //   die;
      
    }
        $atr =  DB::table('clientlogins')->where('id',$request->member)->first();
//dd($atr);
        if($request->ccmail){
            $teammembermail = Teammember::wherein('id',$request->ccmail)->pluck('emailid')->toArray();
            }
            $data = array(
                'teammembermail' => $teammembermail ??'',
                'email' => $atr->email ??'',
                  'name' => $atr->name ??'',
                  'subject' => $request->subject,
                  'description' => $request->description
          );
           Mail::send('emails.atrassign', $data, function ($msg) use($data,$request){
               $msg->to($data['email']);
               $msg->subject($data['subject']);
               if($request->ccmail) {
                $msg->cc($data['teammembermail']);
            }
            }); 
   

        $output = array('msg' => 'Assigned Successfully');
        return back()->with('success', $output);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}
      
}
