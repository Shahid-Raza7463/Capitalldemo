<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\imports\Atrimport;
use App\Models\Teammember;
use App\Models\Atr;
use App\Models\Carbon;
use Illuminate\Http\Request;
use DB;
use Excel;
class ClientAtrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()   
    {
        $this->middleware('auth:clientlogin');
    }
  public function atrView($id)
    {
      $atr =  $atr = Atr::with('clientlogin')
      ->where('id', $id)->first();
  $atrfile = DB::table('atrfiles')->where('atrfiles.atrfiles_id',$id)->get();
    
      // dd($atr);
        return view('client.atr.view', compact('id','atr','atrfile'));

  }
  public function index()
    {
       // dd($id);
          $atrData =Atr::with('atrfile','clientlogin')
          ->where('atrs.client_id',auth()->user()->client_id)
          ->where('atrs.responsible_person',auth()->user()->id)->get();
     //   dd($atrData);
         return view('client.atr.index',compact('atrData'));

  }
  public function atrUpdate(Request $request )
  {
   // dd($request);
   $request->validate([
       'management_comments' => 'required',
       'duedate_for_closure' => 'required',
   ]);
 
   try {
       $data = $request->except(['_token']);
       if($request->hasFile('attachments'))
       $data['status'] = 2;
       Atr::find($request->id)->update($data);
      
       $files = [];
       if($request->hasFile('attachments'))
       {
           foreach ($request->file('attachments') as $file) {
      $name = $file->getClientOriginalName();
           //    $destinationPath = storage_path('app/backEnd/image/clientfile');
            //   $name = $file->getClientOriginalName();
            //  $s = $file->move($destinationPath, $name);
                    //  dd($s); die;
       $path = $file->storeAs('atr',$name,'s3');
               $files[] = $name;
            
           }
       }
       foreach($files as $filess )
       {
      // dd($files); die;
          $s = DB::table('atrfiles')->insert([
               'atrfiles_id' => $request->id,
               'attachments' => $filess, 
                'created_at' => date('Y-m-d H:i:s'), 
               'updated_at' => date('Y-m-d H:i:s')            
           ]);  
       
       }
       $atr =  DB::table('atrs')
       ->leftjoin('teammembers','teammembers.id','atrs.createdby')
       ->leftjoin('clients','clients.id','atrs.client_id')
       ->select('atrs.*','teammembers.emailid','clients.client_name')
       ->where('atrs.id', $request->id)->first();
      //    dd($atr);
       $data = array(
        'email' => $atr->emailid ??'',
          'id' => $atr->id ??'',
          'subject' => 'Submission of ATR reply'.' '. $atr->client_name .' '. $atr->fy .' '. $atr->quarter.' '. $atr->area
  );
   Mail::send('emails.atrsubmit', $data, function ($msg) use($data){
       $msg->to($data['email']);
       $msg->subject($data['subject']);
    }); 
      $output = array('msg' => 'Update successfully');
       return redirect('client/atrlist')->with('success', $output);
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
           $db['client_id']=$request->clientid ;
           $db['status']='0';

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

    $atr = Atr::where('id', $id)->first();
  // dd($atr);
    return view('backEnd.atr.view', compact('id','atr'));
}
      
}
