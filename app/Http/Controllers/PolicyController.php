<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Teammember;
use App\Models\Role;
use App\Models\Policy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class PolicyController extends Controller
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
        //  dd($id);
        if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
          $policyDatas  = DB::table('policies')
          ->leftjoin('policyfolders','policyfolders.id','policies.folder_id')
         ->select('policyfolders.*')->distinct()
        ->get();
  // dd($policyDatas);
         return view('backEnd.policy.index',compact('policyDatas'));
      }
      else {
          $policyDatas  =DB::table('policies')
          ->leftjoin('policyfolders','policyfolders.id','policies.folder_id')
          ->leftjoin('policiessharewith','policiessharewith.policy_id','policies.id')
        ->where('policiessharewith.sharewith','=',auth()->user()->role_id)
         ->select('policyfolders.*' )->distinct()
        ->get();
          // dd($policyDatas);
          return view('backEnd.policy.index',compact('policyDatas'));
      }
  }
  public function policy(Request $request)
    {
      // dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
             //   dd($request->id);
              $policies = DB::table('policies')
            ->where('id',$request->id)->first();
          //  dd($conversion);
                return response()->json($policies);
             }
            }
    
    }
  public function policyAcknowledge(Request $request)
    {
           $request->validate([
                'acknowledge' => "required"
          ]);

            try {
                DB::table('policyacknowledges')->insert([	
                    'acknowledge'         =>   $request->acknowledge, 
                    'policy_id'         =>   $request->policyid, 
                    'teammember_id'         =>     auth()->user()->teammember_id, 	
					'created_at' => date('y-m-d')   ,
                     'updated_at' => date('y-m-d')     
                     ]);
                $output = array('msg' => 'Update Successfully');
                return back()->with('success', $output);
            } catch (Exception $e) {
                DB::rollBack();
                Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                report($e);
                $output = array('msg' => $e->getMessage());
                return back()->withErrors($output)->withInput();
            }
        
    }
  public function policylist($id)
  {
    if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
    $policy  =DB::table('policies')
    ->where('policies.folder_id',$id)->get();
  //  dd($policy);
 
    return view('backEnd.policy.policyindex',compact('policy'));
    
    }
    else
    {
        $policy  =DB::table('policies')
   
    ->leftjoin('policiessharewith','policiessharewith.policy_id','policies.id')
    ->leftjoin('roles','roles.id','policiessharewith.sharewith')
    ->where('policies.folder_id',$id)
    ->where('policiessharewith.sharewith','=',auth()->user()->role_id)
    ->select('policies.*','roles.rolename')->get();
    return view('backEnd.policy.policyindexx',compact('policy')); 
    }
  }
 public function acknowledgelist($id)
 {
    // dd($id);
    $policy  =DB::table('policiessharewith')
    ->leftjoin('policies','policies.id','policiessharewith.policy_id')
    ->leftjoin('roles','roles.id','policiessharewith.sharewith')
    ->leftjoin('teammembers','teammembers.role_id','roles.id')
  
    ->where('policiessharewith.policy_id',$id)->select('policies.created_at as policydate','teammembers.team_member','teammembers.id as teammemberid','roles.rolename')->get();
  // dd($policy);
    return view('backEnd.policy.policyacknowledgelist',compact('policy','id')); 
 }
 public function show($id)
 {

    $policyid = DB::table('policies')->where('markasacknowledge',1)->get();

    foreach($policyid as $policyidd )
    {
       // dd($policyid);
       $policiessharewith= DB::table('policiessharewith')->where('policy_id',$policyidd->id)->get();
      
        foreach($policiessharewith as $policiesshare)
        {
            $emailid = DB::table('teammembers')
            ->where('role_id',$policiesshare->sharewith)->get();
           
            echo "<pre>";
            print_r($emailid);
            foreach($emailid as $emailid)
            {
               $email =  DB::table('teammembers')
               ->where('role_id',$policiesshare->sharewith)->get();
            }
        }

    }
    die;

   //  dd($policyid);      
$roleid = DB::table('policiessharewith')->wherein('policy_id',$policyid)->pluck('sharewith')->toArray();
dd($roleid);


   $accountant = DB::table('teammembers')
 ->leftjoin('policyacknowledges','policyacknowledges.teammember_id','teammembers.id')
   ->whereNotIn('teammembers.id',$trainingid)
  
   ->wherein('teammembers.role_id',$roleid)
   // ->whereIn('policyacknowledges.policy_id',$policyid)   
   ->pluck('emailid')->toArray();
 dd($accountant);
   foreach ($accountant as $accountantmail ) {
       $teammember = $accountantmail;
       $data = array(
        'id' => $roleid->folder_id ??''
       );
      
        Mail::send('emails.policyreminder', $data, function ($msg) use($data, $teammember){
            $msg->to($teammember);
            $msg->subject('kgs Policy Reminder');
         });
        
        // die;
       }
       $output = array('msg' => 'Reminder Mail Send Successfully');
       return back()->with('success', $output);
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::where('id','!=','11')->where('id','!=','12')->where('id','!=','18')->get();
       $folder = DB::table('policyfolders')->get();
        return view('backEnd.policy.create',compact('role','folder'));
 //return view('backEnd.applyleave.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request);
    //     $request->validate([
    //          'Name' => "required|string",
    //        'Contact' => "required"
    //    ]);

         try {
             $data=$request->except(['_token','foldername','teammember','sharewith']);
             $policyfolders = DB::table('policyfolders')->where('id', $request->folder_id)->first();
             if($request->hasFile('file'))
             {
                 $file=$request->file('file');
                     $destinationPath = 'backEnd/image/policy';
                     $name = $file->getClientOriginalName();
                    $s = $file->move($destinationPath, $name);
                          //  dd($s); die;
                          $data['file'] = $name;
                
             }
             if($policyfolders != null){
               
               $policyModel = Policy::Create($data);
                $policyModel->save();
                $id = $policyModel->id;
                foreach ($request->sharewith as $sharewith ) 
                {
                 DB::table('policiessharewith')->insert([	
                     'policy_id'         =>     $id, 
                    'sharewith'         =>     $sharewith, 	
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                    ]);  
                }
                $teammembers = Teammember::wherein('role_id',$request->sharewith)->pluck('emailid')->toArray();
            // dd($teammembers);
                foreach ($teammembers as $teammember ) {
       $data = array(
       'teammember' => $teammember??'',
       'id' => $policyfolders->id ??''

   );
   if($request->markasacknowledge == 1){
    Mail::send('emails.policyform', $data, function ($msg) use($data){
        
        $msg->to($data['teammember']);
        $msg->subject('kgs Policy');
     });
    }
    if($request->notify == 1){
        Mail::send('emails.policyyform', $data, function ($msg) use($data){
        
            $msg->to($data['teammember']);
            $msg->subject('kgs Policy');
         });   
    }
    }
        }
        else
        {
           $policyfolderid = DB::table('policyfolders')->insertGetId([
                'foldername'   	=>     $request->foldername,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]); 
            $data['folder_id']=$policyfolderid; 
            $policyModel = Policy::Create($data);
                $policyModel->save();
                $id = $policyModel->id;
                foreach ($request->sharewith as $sharewith ) 
                {
                 DB::table('policiessharewith')->insert([	
                     'policy_id'         =>     $id, 
                    'sharewith'         =>     $sharewith, 	
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                    ]);  
                }
            $teammembers = Teammember::wherein('role_id',$request->sharewith)->pluck('emailid')->toArray();
            foreach ($teammembers as $teammember ) {
   $data = array(
   'teammember' => $teammember??'',
   'id' => $policyfolderid ??''

);
if($request->markasacknowledge == 1){
    Mail::send('emails.policyform', $data, function ($msg) use($data){
        
        $msg->to($data['teammember']);
        $msg->subject('kgs Policy');
     });
    }
      if($request->notify == 1)
    {
        Mail::send('emails.policyyform', $data, function ($msg) use($data){
        
            $msg->to($data['teammember']);
            $msg->subject('kgs Policy');
         });   
    }
} 
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
     * @param  \App\Models\Policy  $employeereferral
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employeereferral  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employeereferral $employeereferral)
    {
        //
    }
}
