<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Travelform;
use App\Models\Teammember;
use App\Models\Client;
use App\Models\Assignment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TravelformController extends Controller
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
    public function update(Request $request, $id)
    {
      //  dd($id);
        // $request->validate([
        //     'teammember_id' => "required",
        // ]);
        try {
            $travelform = DB::table('travelforms')
           ->leftjoin('clients','clients.id','travelforms.client_id')
            ->where('travelforms.id',$id)->select('travelforms.*','clients.client_name')->first();
         //   dd($travelform); die;
            $teammembermail = Teammember::where('id',$travelform->createdby)->first();
          $data=$request->except(['_token']);
          $data['updatedby'] = auth()->user()->teammember_id;
          Travelform::find($id)->update($data);
    
    if($travelform->partener == auth()->user()->teammember_id){
   
      if($request->travelstatus == 1)
        {
            $data = array(
                'email' => $teammembermail->emailid ??'',
                'teammember' => $teammembermail->team_member ??'',
                'place' => $travelform->client_name ??'',
                'id' => $travelform->id ??'',
        );
       Mail::send('emails.travelformapproved', $data, function ($msg) use($data, $travelform){
             $msg->to($data['email']);
             $msg->subject('Kgs Travel Form Approved');
             $msg->cc('admin@kgsomani.com');
    });
        }
    if($request->travelstatus == 2)
        {
          $data = array(
            'email' => $teammembermail->emailid ??'',
            'teammember' => $teammembermail->team_member ??'',
            'place' => $travelform->client_name ??'',
            'id' => $travelform->id ??'',
    );
         Mail::send('emails.travelformreject', $data, function ($msg) use($data, $travelform){
          $msg->to($data['email']);
          $msg->subject('Kgs Travel Form Rejected');
          $msg->cc('admin@kgsomani.com');
       });
        }
      
     }
          
            $output = array('msg' => 'Updated Successfully');
            return redirect('travelform')->with('success', $output);
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
      if( auth()->user()->role_id == 11 || auth()->user()->teammember_id == 427){
      $travelformDatas  = DB::table('travelforms')
      ->leftjoin('teammembers','teammembers.id','travelforms.partener')
      ->leftjoin('teammembers as created','created.id','travelforms.createdby')
      ->leftjoin('roles as rolename','rolename.id','created.role_id')
      ->leftjoin('assignments','assignments.id','travelforms.assignment')
      ->leftjoin('clients','clients.id','travelforms.client_id')
      ->leftjoin('roles','roles.id','teammembers.role_id')
      ->select('travelforms.*','teammembers.team_member','created.team_member as createdname','rolename.rolename as createdrole','roles.rolename','clients.client_name','assignments.assignment_name')->get();
      // dd($travelformDatas);
      }
      else{
        $travelformDatas  = DB::table('travelforms')
        ->leftjoin('teammembers','teammembers.id','travelforms.partener')
        ->leftjoin('teammembers as created','created.id','travelforms.createdby')
        ->leftjoin('roles as rolename','rolename.id','created.role_id')
        ->leftjoin('assignments','assignments.id','travelforms.assignment')
        ->leftjoin('clients','clients.id','travelforms.client_id')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('createdby',auth()->user()->teammember_id)
			 ->orwhere('partener',auth()->user()->teammember_id)
       ->select('travelforms.*','teammembers.team_member','created.team_member as createdname','rolename.rolename as createdrole','roles.rolename','clients.client_name','assignments.assignment_name')->get();
     //dd($travelformDatas);
      }
     return view('backEnd.travelform.index',compact('travelformDatas'));
    
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $travelform = DB::table('travelforms')
        ->leftjoin('teammembers','teammembers.id','travelforms.partener')
        ->leftjoin('assignments','assignments.id','travelforms.assignment')
        ->leftjoin('clients','clients.id','travelforms.client_id')
         ->leftjoin('roles','roles.id','teammembers.role_id')
       ->where('travelforms.id',$id)
      ->select('travelforms.*','teammembers.team_member','clients.client_name','assignments.assignment_name','roles.rolename')->first();
        // dd($travelform);
         return view('backEnd.travelform.view', compact('id','travelform'));
    }
    public function create(Request $request)
    {
      $teammember = Teammember::where('role_id','!=',11)->get();
      $partener = Teammember::where('role_id','=',13)->with('title')->get();
		 $client = Client::latest()->get();
     // dd($teammember);
     if(auth()->user()->role_id == 13 ){
      $client = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
      ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
      ->where('assignmentmappings.leadpartner',auth()->user()->teammember_id)
      ->select('clients.client_name','clients.id')
      ->distinct()->get();
     // dd($client);
    }
    elseif(auth()->user()->role_id == 14)
    {
      $client = DB::table('assignmentteammappings')
      ->leftjoin('assignmentmappings','assignmentmappings.id','assignmentteammappings.assignmentmapping_id')
      ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
      ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
      ->where('assignmentteammappings.teammember_id',auth()->user()->teammember_id)
      ->select('clients.client_name','clients.id')
      ->distinct()->get();
    }
    elseif (auth()->user()->role_id == 11) {
      $client = Client::select('id','client_name')->get();
    }
     
   
      if ($request->ajax()) {
       if(auth()->user()->role_id == 14){
           if (isset($request->cid)) {
            echo "<option>Please Select One</option>";
            foreach (DB::table('assignmentteammappings')
            ->leftjoin('assignmentmappings','assignmentmappings.id','assignmentteammappings.assignmentmapping_id')
            ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
            ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
            ->where('assignmentteammappings.teammember_id',auth()->user()->teammember_id)->
            where('assignmentbudgetings.client_id',$request->cid)->
            select('assignments.*','assignmentbudgetings.assignmentgenerate_id','assignmentbudgetings.duedate')
            ->get() as $sub) {

                echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name .'('. date('F d,Y', strtotime($sub->duedate)).')'. "</option>";
            }
           } 
          }
          if(auth()->user()->role_id == 13){
            if (isset($request->cid)) {
         echo "<option>Please Select One</option>";
                    foreach ( DB::table('assignmentmappings')
                    ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
                    ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
                    ->where('assignmentmappings.leadpartner',auth()->user()->teammember_id)
                    ->where('assignmentbudgetings.client_id',$request->cid)->
                    select('assignments.*','assignmentbudgetings.assignmentgenerate_id','assignmentbudgetings.duedate')
                    ->get() as $sub) {
                 
                        echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name .'('. date('F d,Y', strtotime($sub->duedate)).')'. "</option>";
                    }
            } 
           }
           if (isset($request->sid)) {
            echo "<option>Select Partner</option>";
   foreach (DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->sid)
   ->leftjoin('teammembers','teammembers.id','assignmentmappings.leadpartner')
   ->orderBy('team_member')->get() as $sub) {
   echo "<option value='" . $sub->id . "'>" . $sub->team_member . "</option>";
   
              }
          }    
         
       } else {

      return view('backEnd.travelform.create',compact('client','partener','teammember'));
    }
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
  //   $request->validate([
  //        'companyname' => "required",
  //        'contactemailid' => "required",
  //  ]);

     try {
      $assignment = DB::table('assignmentmappings')->where('assignmentgenerate_id',$request->assignment)->first();
    //  dd($assignment);
         $data=$request->except(['_token','member_name']);
         $data['createdby'] = auth()->user()->teammember_id;
         if( auth()->user()->role_id == 13 ){
         $data['travelstatus'] = 1;
         }
         else {
          $data['travelstatus'] = 0;
         }
         $data['assignment'] = $assignment->assignment_id;
        $travelform =  Travelform::Create($data);
        $travelform->save();
        $id = $travelform->id;

        if($request->member_name[0] != null){
          $count=count($request->member_name);
         // dd($count);
          for($i=0;$i<$count;$i++){
             DB::table('travelformmembers')->insert([
                 'travelform_id'   	=>     $id,
                 'member_name'   	=>     $request->member_name[$i],
                 'created_at'			    =>	   date('y-m-d'),
                 'updated_at'              =>    date('y-m-d'),
             ]);
          }
      }
         $travelform = Travelform::where('id', $id)->first();
       //  dd($travelform);
         $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
         $teammembermail = Teammember::where('id',$request->partener)->pluck('emailid')->first();
       //  dd($teammembermail);
       if( auth()->user()->role_id == 14 ){
        $data = array(
          'teammember' => $teammember->team_member ??'',
             'email' => $teammembermail ??'',
             'id' => $id ??'',
            //  'EmployeeID' => $travelform->Client_Name ??'',
     );
      Mail::send('emails.travelrequestform', $data, function ($msg) use($data){
          $msg->to($data['email']);
          $msg->subject('New Travel Request Form');
       });
       }
       if( auth()->user()->role_id == 13 ){
        $travelform = DB::table('clients')
        ->where('id',$request->client_id)->select('clients.client_name')->first();
        $data = array(
          'teammember' => $teammember->team_member ??'',
             'email' => $teammembermail ??'',
             'id' => $id ??'',
             'place' => $travelform->client_name ??'',
     );
      Mail::send('emails.travelformapproved', $data, function ($msg) use($data){
          $msg->to('admin@kgsomani.com');
          $msg->subject(' Travel Request Form Approved');
       });
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
public function travelupdate(Request $request)
{

     try {
    //  dd($assignment);
         $data=$request->except(['_token','attachment']);
         DB::table('travelforms')->where('id',$request->id)->update([	
          'billedtoclient'         =>     $request->billedtoclient,
          'created_at'			    =>	   date('Y-m-d H:i:s'),
          'updated_at'              =>    date('Y-m-d H:i:s'),
           ]);
           $files = [];
           if($request->hasFile('file'))
           {
               foreach ($request->file('file') as $file) {
          $name = $file->getClientOriginalName();
                  $destinationPath = 'backEnd/image/travelform';
                  $name = $file->getClientOriginalName();
                 $s = $file->move($destinationPath, $name);
                        //  dd($s); die;
        //   $path = $file->storeAs('clientdocument',$name,'s3');
                   $files[] = $name;
                
               }
           }
           foreach($files as $filess )
           {
          // dd($files); die;
              $s = DB::table('travelformattachment')->insert([
                   'travelform_id' => $request->id, 
                   'file' => $filess, 
                    'created_at' => date('Y-m-d H:i:s'), 
                   'updated_at' => date('Y-m-d H:i:s')            
               ]);  
              }
         $output = array('msg' => 'Update Successfully');
         return redirect('travelform')->with('success', $output);
     } catch (Exception $e) {
         DB::rollBack();
         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
         report($e);
         $output = array('msg' => $e->getMessage());
         return back()->withErrors($output)->withInput();
     }
}

    
}
