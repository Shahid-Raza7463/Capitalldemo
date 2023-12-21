<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Ifc;
use App\Models\Teammember;
use App\imports\Ifcimportanswer;
use App\imports\Ifcimport;
use App\Models\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Excel;
class IfcController extends Controller
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
	public function echart(Request $request,$id="")
    {
    	//dd($id);
    	//$fruit = Product::where('product_type','fruit')->get();
    	//$veg = Product::where('product_type','vegitable')->get();
    	//$grains = Product::where('product_type','grains')->get();
    	/*$fruit_count = 40;    	
    	$veg_count = 30;
    	$grains_count = 30;
    	return view('backEnd.ifc.chart',compact('fruit_count','veg_count','grains_count'));*/
        $data = DB::table('ifcs')
      //  ->where('whether_key','!=','-')
      //  ->orwhere('whether_key','!=',null)
       ->select(
        DB::raw('whether_key as whether_key'),
        DB::raw('count(*) as number'))
       ->groupBy('whether_key')
       ->where('ifcfolder_id',$id)
       ->get();
     $array[] = ['whether_key', 'Number'];
     foreach($data as $key => $value)
     {
      $array[++$key] = [$value->whether_key, $value->number];
     }

     $data2 = DB::table('ifcs')
     // ->where('whether_key','!=','-')
     //  ->orwhere('whether_key','!=',null)
      ->select(
       DB::raw('process_design_gap as process_design_gap'),
       DB::raw('count(*) as number'))
      ->groupBy('process_design_gap')
      ->where('ifcfolder_id',$id)
      ->get();
    $array1[] = ['process_design_gap', 'Number'];
  //  dd($array1);
    foreach($data2 as $key => $value)
    {
     $array1[++$key] = [$value->process_design_gap, $value->number];
    }

    $data3 = DB::table('ifcs')
    // ->where('whether_key','!=','-')
    //  ->orwhere('whether_key','!=',null)
     ->select(
      DB::raw('Result as Results'),
      DB::raw('count(*) as number'))
     ->groupBy('Results')
     ->where('ifcfolder_id',$id)
     ->get();
   $array3[] = ['Results', 'Number'];
 //  dd($array1);
   foreach($data3 as $key => $value)
   {
    $array3[++$key] = [$value->Results, $value->number];
   }

     return view('backEnd.ifc.chart')->with('whether_key', json_encode($array))->with('process_design_gap', json_encode($array1))
     ->with('Results', json_encode($array3));
    
    }

    public function ifcView($id)
    {
        $ifc = DB::table('ifcs')->where('id',$id)->first();

        return view('backEnd.ifc.view',compact('ifc','id'));

    }
    public function ifcdocument(Request $request)
{
  //  dd($request);
    if ($request->ajax()) {
        if (isset($request->id))
         {
        
             foreach ( DB::table('ifcdocuments')
            ->where('ifc_id',$request->id)->where('type',NULL)->get() as $sub) {
                $url = url('backEnd/image/ifcdocument/'.$sub->attachment);
             echo " <tr>
        <td>$sub->file_name </td>
        <td>
        <a href=$url>$sub->attachment</a> 
        </td>
        
    </tr>";
            }

        }
        }

} 
    public function ifcmanagement(Request $request)
{
    if ($request->ajax()) {
        if (isset($request->id)) {
           // dd($request->id);
            $invoice = DB::table('ifcs')->
          where('id',$request->id)->first();
           return response()->json($invoice);
         }
        }

} 
    
    public function index($id)
    {
     //   dd($id);
          $ifcDatas  = DB::table('ifcs')
          ->leftjoin('teammembers','teammembers.id','ifcs.assign_member')
          ->leftjoin('clientlogins as s','s.id','ifcs.responsible_person')
          ->where('ifcs.ifcfolder_id',$id)
          ->select('ifcs.*','teammembers.team_member','s.name  as responsibleperson')->get();
          $clientname  = DB::table('ifcfolders')
          ->leftjoin('clients','clients.id','ifcfolders.client_id')
          ->where('ifcfolders.id',$id)->first();
        // dd($clientname);
   $assignmember = DB::table('teammembers')->whereStatus('1')->select('teammembers.id','teammembers.team_member')->get();
   $responsibleperson = DB::table('clientlogins')->where('client_id',$clientname->client_id)->select('clientlogins.id','clientlogins.name')->get();
         return view('backEnd.ifc.index',compact('ifcDatas','id','assignmember','clientname','responsibleperson'));

  }
  public function ifcassignPerson(Request $request)
    
{ 
//dd($request);
            try {
      
        $ifc =  DB::table('teammembers')->where('id',$request->member)->first();

            $data = array(
                'email' => $ifc->emailid ??'',
                  'name' => $ifc->team_member ??'',
                  'subject' => $request->subject,
                  'description' => $request->description
          );
           Mail::send('emails.ifcassign', $data, function ($msg) use($data,$request){
               $msg->to($data['email']);
               $msg->subject($data['subject']);
            
            }); 
    
            if($request->member != null){
                DB::table('ifcs')->where('ifcfolder_id',$request->ifcfolder_id)->update([ 
                    'assign_member'         =>  $request->member 
                    ]);
             
          
        }

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
	public function ifcUpload_answer(Request $request )
  {
   $request->validate([
       'file' => 'required'
   ]);
 
   try {
       $file=$request->file;
     
       $data = $request->except(['_token']);
       $dataa=Excel::toArray(new Ifcimportanswer, $file);
       
       foreach ($dataa[0] as $key => $value) {

        $identification_risk =  DB::table('ifcs')->where('identification_risk',$value['identification_risk'])->first();
           
        if ($identification_risk !=  null) {
            DB::table('ifcs')->where('id',$identification_risk->id)->update([	
               'as_is_control' => $value['as_is_control'],
	'fraud_risk' => $value['fraud_risk'] ,
	'risk_rating' => $value['risk_rating'],
	'whether_key' => $value['whether_key'],
	'automated_manual' => $value['automated_manual'],
	'preventive_detective'=> $value['preventive_detective'],
	'control_frequency' => $value['control_frequency'],
	'concerned_person' => $value['concerned_person'],
	'process_design_gap' => $value['process_design_gap'],
	'design_gap' => $value['design_gap'],
	'Methodology'=> $value['methodology'],
	'Result'=>$value['result'],
	'Recommendations'=> $value['recommendations'],
	'Remarks' => $value['remarks'],
	'Management_Comments' => $value['management_comments'],
	'status' => 2,
	'updated_at' => date('Y-m-d H:i:s'),
                 ]);
        }
       
         
}
      $output = array('msg' => 'Answer Excel file upload Successfully');
       return back()->with('success', $output);
   } catch (Exception $e) {
       DB::rollBack();
       Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
       report($e);
       $output = array('msg' => $e->getMessage());
       return back()->withErrors($output)->withInput();
   }
}
  public function ifcUpload(Request $request )
  {
   $request->validate([
       'file' => 'required'
   ]);
 
   try {
       $file=$request->file;
     
       $data = $request->except(['_token']);
       $dataa=Excel::toArray(new Ifcimport, $file);
       
       foreach ($dataa[0] as $key => $value) {
           
           $db['control_number']=$value['control_number'] ;
           $db['sub_process']=$value['sub_process'] ;
           $db['control_objective']=$value['control_objective'] ;
           $db['identification_risk']=$value['identification_risk'] ;
           $db['client_id']=$request->client_id ;
           $db['ifcfolder_id']=$request->ifcfolder_id ;
           $db['status']='0';
           $db['created_by']=auth()->user()->teammember_id;

        //   dd($db);
           Ifc::Create($db);
       
         
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
public function ifcmanagementupdate(Request $request)
{
  //  dd($request);
    try {
        DB::table('ifcs')->where('id',$request->ifc_id)->update([	
            'Management_Comments'         =>     $request->Management_Comments,
             ]);
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
public function ifcUpdate(Request $request, $id)
{
  //  dd($request);
    try {
        $data=$request->except(['_token','file','file_name']);
        $data['status']='2';
        Ifc::find($id)->update($data);
        $filess=array();
        if($files=$request->file('file'))
    {
        foreach($files as $file){
            $name=$file->getClientOriginalName();
            $file->move('backEnd/image/ifcdocument/',$name);
            $filess[]=$name;
           // dd($name);
        }

    }
        if($request->file_name[0] != null){
            $count=count($request->file_name);
         //   dd($count);
            for($i=0;$i<$count;$i++){
               DB::table('ifcdocuments')->insert([
                   'ifc_id'   	=>     $id,
                   'file_name'   	=>     $request->file_name[$i],
                  'attachment'=>  $filess[$i],
                  'created_at' => date('Y-m-d H:i:s'), 
                     'updated_at' => date('Y-m-d H:i:s')  
               ]);
            }
                     }
        $output = array('msg' => 'Updated Data Successfully');
        return back()->with('success', $output);
} catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}
public function ifcresposiblePerson(Request $request)
    
{ 
//dd($request);
            try {
       
        if($request->fyquarter[0] != null){
      
       //  dd($request->fyy);
            DB::table('ifcs')->wherein('id',$request->fyquarter)->update([ 
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
           Mail::send('emails.ifcclientassign', $data, function ($msg) use($data,$request){
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
public function ifcdocuments(Request $request)
{
  //  dd($request);
    if ($request->ajax()) {
        if (isset($request->id))
         {
        
             foreach ( DB::table('ifcdocuments')
            ->where('ifc_id',$request->id)->where('type',1)->get() as $sub) {
                $date = date('h:i a F d,Y', strtotime($sub->created_at));
                $url = url('backEnd/image/ifcdocument/'.$sub->attachment);
             echo " <tr>
     
        <td>
        <a href=$url >$sub->attachment</a> 
        </td>
        <td>
        $date
        </td>
        
    </tr>";
            }

        }
        }

} 
}
