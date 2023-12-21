<?php

namespace App\Http\Controllers;
use App\Models\Clientfolder;
use App\Models\Client;
use App\Models\State;
use App\Models\Clientcontact;
use App\Models\Permission;
use App\Models\Clientdocument;
use App\Models\Teammember;
use Illuminate\Http\Request;
use App\imports\Clientcontactimport;
use Maatwebsite\Excel\HeadingRowImport;
use Excel;
use App\imports\Debtorimport;
use App\Models\Debtor;
use DB;
use Image;
use File;
use Illuminate\Support\Facades\Mail;
class ClientController extends Controller
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
	       public function client_list()
    {
        $client = Client::latest()->get();
            return view('backEnd.client.clientlist',compact('client' ));
    }
	 public function clientpan(Request $request)
  {
    $panNumber = $request->input('panNumber');

    // Check if PAN number is duplicate
    $duplicateClient = \DB::table('clients')->where('panno', $panNumber)->first();

    if ($duplicateClient) {
        return response()->json([
            'success' => false,
            'duplicateClientName' => $duplicateClient->client_name,
        ]);
    }

    return response()->json([
        'success' => true,
    ]);

  }
    public function changeStatus(Request $request)
    { 
      //  dd($request);
        $user = Client::find($request->user_id);
        $user->status = $request->status;
        $user->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
	
    public function addDocument($id) {
        
        return view('backEnd.client.addDocument', ['id' => $id]);
    }
	    public function storeDocument(Request $request)
     {
       
        $id = $request->client_id;
        $authid = auth()->user()->id;


        $filess = array();
        if ($files = $request->file('filess')) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $file->move('backEnd/image/client/document/', $name);
                $filess[] = $name;
                // dd($name);
            }
        }

        if ($request->document_name != null) {
            $count = count($request->document_name);
            // dd($count);
            for ($i = 0; $i < $count; $i++) {
                DB::table('clientdocuments')->insert([
                    'client_id'       =>     $id,
                    'type'       =>     $request->type[$i],
                    'document_name'       =>     $request->document_name[$i],
                    'filess' =>  $filess[$i],
                    'created_by'  => $authid,
                    'updated_by'  => $authid,
                    'created_at'                =>       date('Y-m-d H:i:s'),
                    'updated_at'              =>     date('Y-m-d H:i:s'),
                ]);
            }
        }

        $output = array('msg' => 'Document added Successfully');
          return back()->with('success', $output);
                
    }
     public function add(Request $request, $clientid)
    {
          $state = State::latest()->get();
          $client = Client::where('id', $clientid)->first();
          $clients = Client::latest()->get();
        return view('backEnd.client.create',compact('state','client','clients'));
    }
  public function index()
    {
	   if(auth()->user()->role_id == 13 )
{
    $clientDatas = Client::where('status',1)->select('client_name','id','client_code','panno')->get();
    //dd($clientDatas);
    return view('backEnd.client.folderwise',compact('clientDatas'));
}elseif(auth()->user()->role_id == 14)
{
    $clientDatas =      DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
             
                ->select('clients.*')
			     ->where('clients.status',1)
                ->where('assignmentteammappings.teammember_id',auth()->user()->teammember_id)->distinct()->get();
    //dd($clientDatas);
    return view('backEnd.client.folderwise',compact('clientDatas'));
}
	  elseif(auth()->user()->role_id == 15)
{
    $clientDatas =     DB::table('clients')
   ->leftjoin('staffassigns','staffassigns.client_id','clients.id')
		->where('clients.status',1)
  ->where('staffassigns.staff_id',auth()->user()->teammember_id)
   ->select('clients.*')->get();
    //dd($clientDatas);
    return view('backEnd.client.folderwise',compact('clientDatas'));
}else {
            $clientDatas = Client::where('status',1)->select('client_name','id','client_code','panno')->get();
          //  dd($clientDatas);
            return view('backEnd.client.folderwise',compact('clientDatas'));
        }
    }
       public function viewclientlist($client_name)
    {
    // dd($client_name);
    $clientDatas = DB::table('clients')
  ->where('clients.id',$client_name)
   ->select('clients.*')->get();
   $clientid =  DB::table('clients')
   ->where('clients.id',$client_name)
    ->pluck('id')->first();
  // dd($clientid);
    return view('backEnd.client.index',compact('clientDatas','clientid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function viewClient($id)
    {
      
        $clientList =  DB::table('clients')
        ->leftjoin('states','states.id','clients.c_state')
        ->where('clients.id', $id)->select('clients.*','states.statename')->first();
        $clientcontactList =  Clientcontact::where('client_id', $id)->get();
        $clientassignment =  DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
            ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
            ->where('assignmentbudgetings.client_id',$id)
            ->select('assignmentmappings.*','assignmentbudgetings.duedate',
            'assignments.assignment_name','clients.client_name')->distinct()->get();
        $clientfileDatas = DB::table('clientdocuments')
        ->leftjoin('users','users.id','clientdocuments.created_by')
        ->leftjoin('clients','clients.id','clientdocuments.client_id')
        ->leftjoin('teammembers','teammembers.id','users.teammember_id')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('clientdocuments.client_id',$id)
        ->select('clientdocuments.*','teammembers.team_member','roles.rolename','clients.client_name')->get();
        
		  if(auth()->user()->teammember_id == 214){
		 $clientfile  =  DB::table('clientfolders')
			 ->where('createdby','214')
          ->where('client_id',$id)->get();	  
		}
		  else  
		  {
			 $clientfile  =  DB::table('clientfolders')
          ->where('client_id',$id)->get(); 
		  }
           
          
             $clientlogin  =  DB::table('clientlogs')
            ->leftjoin('clientlogins','clientlogins.id','clientlogs.clientlogin_id')
            ->where('clientlogs.client_id',$id)
            ->select('clientlogs.*','clientlogins.name','clientlogins.email')->get();
            
        return view('backEnd.clientlist',compact('id','clientlogin','clientfile','clientcontactList','clientList','clientassignment','clientfileDatas'));   
    }
    public function create(Request $request)
    {
		if(auth()->user()->role_id == 11 || auth()->user()->role_id == 12 || auth()->user()->role_id == 13 || auth()->user()->role_id == 14 || auth()->user()->role_id == 18 || auth()->user()->role_id == 16){
          $state = State::latest()->get();
    $clients = Client::orderBy('client_name', 'ASC')->get();
        return view('backEnd.client.create',compact('state','clients'));
		}
		   abort(403, ' you have no permission to access this page ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
         $request->validate([
			      'panno' => "unique:clients",
        //     'client_name' => "required|max:300|alpha",
        //     'name' => "required|max:300|alpha_num",
        //      'mobileno' => "required|numeric|min:10",
        //      'emailid' => "required|email",
		// 	 'c_address' =>  "required|max:700",
		// 	 'kind_attention' =>  "required|max:200|alpha",
		// 	 'clientdesignation' =>  "required|max:200|alpha",
		// 	 'panno' =>  "required|numeric|min:15",
		// 	 'tanno' =>  "required|max:20|alpha_num",
		// 	 'gstno' =>  "required|max:20|alpha_num",
		// 	 'document_name.*' => "required|max:300|alpha",
		// 	 'c_address' =>  "required|max:200|alpha",
		// 	    'filess.*' => 'mimes:png,jpg,jpeg,csv,xlx,xls,pdf,zip,rar',
          ]);

        try {
            $authid = auth()->user()->id;
            $data=$request->except(['_token']);
			$assign = Client::latest()->get();
		     if($assign->isEmpty()){
				      $assignmentnumbers = '100001';
              }
			else
			{
				
       $assignmentnumb = Client::latest()->first()->client_code;
             //  dd($assignmentnumb);
                         if($assignmentnumb ==  null){
                $assignmentnumbers = '100001';
             }else {
               $assignmentnumbers = $assignmentnumb + 1;
             }
      //      dd($assignmentnumbers);
			}
            if(auth()->user()->role_id == 11 || auth()->user()->role_id == 12 || auth()->user()->role_id == 13){
            $filess=array();
            if($files=$request->file('filess'))
        {
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                $file->move('backEnd/image/client/document/',$name);
                $filess[]=$name;
               // dd($name);
            }
    
        }
        $data['status'] = 1;
				  $data['client_code'] = $assignmentnumbers;
            $clientModel = Client::Create($data);
            $clientModel->save();
            $id = $clientModel->id;
				  if($request->document_name != null){
         $count=count($request->document_name);
        // dd($count);
         for($i=0;$i<$count;$i++){
            DB::table('clientdocuments')->insert([
                'client_id'   	=>     $id,
                'type'   	=>     $request->type[$i],
                'document_name'   	=>     $request->document_name[$i],
               'filess'=>  $filess[$i],
                'created_by'  => $authid,
                'updated_by'  => $authid,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
         }
				  }
              
            
            DB::table('clients')->where('id',$id)->update([	
          //      'client_code'         =>     $id+1000,
                'createdbyadmin_id'  => $authid,
				  'parent_id'  => $request->parent_id,
                'updatedbyadmin_id'  => $authid,
                 ]);
				if($request->mobileno != null){
                    DB::table('clientcontacts')->insert([	
                'clientname'         =>     $request->name,
                'clientemail'  => $request->emailid,
                'clientphone'  => $request->mobileno,
                'clientdesignation'  => $request->clientdesignation,
                'client_id'   	=>     $id,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                 ]);
				}
                    $actionName = class_basename($request->route()->getActionname());
                $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                  DB::table('activitylogs')->insert([
                        'user_id' => auth()->user()->teammember_id, 
                        'ip_address' => $request->ip(), 
                        'activitytitle' => $pagename, 
                        'description' => 'New Client Added'.' '.'( '. $request->client_name. ' )', 
                        'created_at' => date('y-m-d'),       
                        'updated_at' => date('y-m-d')       
                    ]);
            $output = array('msg' => 'Create Successfully');
            return back()->with('success', $output);
                  }
                  else {
                    $filess=array();
                    if($files=$request->file('filess'))
                {
                    foreach($files as $file){
                        $name=$file->getClientOriginalName();
                        $file->move('backEnd/image/client/document/',$name);
                        $filess[]=$name;
                       // dd($name);
                    }
            
                }
                $data['status'] = 0;
                    $clientModel = Client::Create($data);
                    $clientModel->save();
                    $id = $clientModel->id;
					    if($request->document_name != null){
                 $count=count($request->document_name);
                // dd($count);
                 for($i=0;$i<$count;$i++){
                    DB::table('clientdocuments')->insert([
                        'client_id'   	=>     $id,
                        'type'   	=>     $request->type[$i],
                        'document_name'   	=>     $request->document_name[$i],
                       'filess'=>  $filess[$i],
                        'created_by'  => $authid,
                        'updated_by'  => $authid,
                        'created_at'			    =>	    date('Y-m-d H:i:s'),
                        'updated_at'              =>      date('Y-m-d H:i:s'),
                    ]);
                 }
                      
						} 
                    DB::table('clients')->where('id',$id)->update([	
                //        'client_code'         =>     $id+1000,
                        'createdbyadmin_id'  => $authid,
						  'parent_id'  => $request->parent_id,
                        'updatedbyadmin_id'  => $authid,
                         ]);
					   if($request->emailid != null){
                           DB::table('clientcontacts')->insert([	
                            'clientname'         =>     $request->name,
                            'clientemail'  => $request->emailid,
                            'clientphone'  => $request->mobileno,
                            'clientdesignation'  => $request->clientdesignation,
                            'client_id'   	=>     $id,
                            'created_at'			    =>	   date('y-m-d'),
                            'updated_at'              =>    date('y-m-d'),
                             ]);
					   }
                            $actionName = class_basename($request->route()->getActionname());
                        $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                          DB::table('activitylogs')->insert([
                                'user_id' =>  auth()->user()->teammember_id, 
                                'ip_address' => $request->ip(), 
                                'activitytitle' => $pagename, 
                                'description' => 'New Client Added'.' '.'( '. $request->client_name. ' )', 
                                'created_at' => date('y-m-d'),       
                                'updated_at' => date('y-m-d')       
                            ]);
					   if (auth()->user()->role_id != 11) {
                                $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
                                $data = array(
                                    'clientname' =>  $request->client_name,
                                    'authnames' =>  $authname->team_member,
                        
                               );
                              
                               Mail::send('emails.clientrequest', $data, function ($msg) use($data){
                                    $msg->to('sukhbahadur@kgsomani.com');
                                    $msg->cc('it@kgsomani.com');
                                    $msg->subject('kgs New Client Request');
                                
                                 });
                            }
                    $output = array('msg' => 'Create Successfully');
                    return back()->with('success', $output);
                          }
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		  $clientcheck = DB::table('assignmentbudgetings')->where('client_id',$id)->first();
		
          $state = State::latest()->get();
      //  dd($teammember);
      $clientdocument = DB::table('clientdocuments')
       ->leftjoin('users','users.id','clientdocuments.updated_by')
       ->leftjoin('teammembers','teammembers.id','users.teammember_id')
       ->where('clientdocuments.client_id',$id)
       ->select('clientdocuments.*','teammembers.team_member')->get();
      // dd($clientdocument);
        $client = Client::where('id', $id)->first();
     $clients = Client::orderBy('client_name', 'ASC')->get();
        return view('backEnd.client.edit', compact('state','id', 'client','clientdocument','clients','clientcheck'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
		//       'panno' => "unique:clients",
        //     'client_name' => "required|max:300|alpha",
        //     'name' => "required|max:300|alpha_num",
        //      'mobileno' => "required|numeric|min:10",
         //     'emailid' => "required|email",
		// 	 'c_address' =>  "required|max:700",
		// 	 'kind_attention' =>  "required|max:200|alpha",
		// 	 'clientdesignation' =>  "required|max:200|alpha",
		// 	 'panno' =>  "required|numeric|min:15",
		// 	 'tanno' =>  "required|max:20|alpha_num",
		// 	 'gstno' =>  "required|max:20|alpha_num",
		// 	 'document_name.*' => "required|max:300|alpha",
		// 	 'c_address' =>  "required|max:200|alpha",
		// 	    'filess.*' => 'mimes:png,jpg,jpeg,csv,xlx,xls,pdf,zip,rar',
          ]);
        try {
            $authid = auth()->user()->id;
            $data=$request->except(['_token']);
            $filess=array();
            if($files=$request->file('filess'))
        {
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                $file->move('backEnd/image/client/document/',$name);
                $filess[]=$name;
            }
    
        }
          Client::find($id)->update($data);
            if($request->document_name != null){
         $count=count($request->document_name);
      //   dd($count);
         for($i=0;$i<$count;$i++){
           
                DB::table('clientdocuments')->insert([
                    'client_id'   	=>     $id,
                    'type'   	=>     $request->type[$i],
                    'document_name'   	=>     $request->document_name[$i],
                    'filess'=>  $filess[$i] ??'',
                    'created_at'			    =>	     date('Y-m-d H:i:s'),
                    'updated_at'              =>      date('Y-m-d H:i:s'),
                ]);
             
      
         }
		}
            DB::table('clients')->where('id',$id)->update([	
            //    'client_code'         =>     $id+1000,
                'updatedbyadmin_id'  => $authid,
                 ]);
                 $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                $id = auth()->user()->teammember_id;
              DB::table('activitylogs')->insert([
                    'user_id' => $id, 
                    'ip_address' => $request->ip(), 
                    'activitytitle' => $pagename, 
                    'description' => ' Client Data Edit'.' '.'( '. $request->client_name. ' )', 
                    'created_at' => date('y-m-d'),       
                    'updated_at' => date('y-m-d')       
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroyClient($id = '')
    {
           try {
               Clientcontact::destroy($id);
               $output = array('msg' => 'Deleted Successfully');
               return back()->with('status', $output);
           } catch (Exception $e) {
               DB::rollBack();
               Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
               report($e);
               $output = array('msg' => $e->getMessage());
               return back()->withErrors($output)->withInput();
           }
       }
       public function destroyClientdocument($id = '',Request $request)
       {
            try {
              
                $clientdata =  DB::table('clientdocuments')
                ->leftjoin('clients','clients.id','clientdocuments.client_id')->
                where('clientdocuments.id', $id)
                ->select('clientdocuments.*','clients.client_name')->first();
              //  dd($clientdata);  die;
                $actionName = class_basename($request->route()->getActionname());
                $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                  DB::table('activitylogs')->insert([
                        'user_id' =>auth()->user()->teammember_id, 
                        'ip_address' => $request->ip(), 
                        'activitytitle' => $pagename, 
                        'description' => $clientdata->document_name.' '.'( '.$clientdata->client_name.' )'.' '.'deleted', 
                        'created_at' => date('y-m-d'),       
                        'updated_at' => date('y-m-d')       
                    ]);
                    Clientdocument::destroy($id);
                  $output = array('msg' => 'Deleted Successfully');
                  return back()->with('status', $output);
              } catch (Exception $e) {
                  DB::rollBack();
                  Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                  report($e);
                  $output = array('msg' => $e->getMessage());
                  return back()->withErrors($output)->withInput();
              }
          }
    public function editContact($id = '')
    {
        $client = Client::where('id', $id)->first();
        $contactDatas = Clientcontact::where('client_id', $id)->get();
     //   dd($priceDatas);
        return view('backEnd.client.addclientcontact', compact('id','client','contactDatas'));
    }
    public function contactUpdate(Request $request, $id = '')
    {
       // dd($request);
        $request->validate([
            'clientname' => 'required'
        ]);

        try {
           $data=$request->except(['_token']);
            Clientcontact::Create($data);
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
    public function assignmentContactUpdate(Request $request)
    {
       // dd($request);
        $request->validate([
            'clientname' => 'required'
        ]);

        try {
           $data=$request->except(['_token']);
            Clientcontact::Create($data);
             return back()->with('alert','Client contact Updated Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
     public function clientContact()
    {
	//    $attendances = DB::table('attendances')->where('month','February')->get();
    //  dd($attendances);
  //   foreach ($attendances as $ilrfoldersData) {
	//	$attendance =  DB::table('attendances')->where('month','March')->where('employee_name',$ilrfoldersData->employee_name)->first();
		//if($attendance == null){
//			 DB::table('attendances')->insert([
  //           'employee_name'   	=>    $ilrfoldersData->employee_name,
    //         'month' => 'March',
    //        'created_at'			    =>	   date('Y-m-d H:i:s'),
     //        'updated_at'              =>     date('Y-m-d H:i:s'),
      //   ]);
//		}
 //      }
  //      die;
        $clientContacts = Clientcontact::latest()->with('client')->get();
         return view('backEnd.client.clientindex',compact('clientContacts'));
    }
    public function clientCreate()
    {
        $client = Client::latest()->get();
         return view('backEnd.client.clientfileform',compact('client'));
    }
    public function clientFile()
    {
      //  $clientfileDatas = Clientdocument::latest()->with('client')->get();
        $clientfileDatas = DB::table('clientdocuments')
        ->leftjoin('users','users.id','clientdocuments.updated_by')
        ->leftjoin('clients','clients.id','clientdocuments.client_id')
        ->leftjoin('teammembers','teammembers.id','users.teammember_id')
        ->select('clientdocuments.*','teammembers.team_member','clients.client_name')->get();
      //  dd($clientfileDatas);
         return view('backEnd.client.clientfileindex',compact('clientfileDatas'));
    }
    public function clientfileStore(Request $request)
    {
        $request->validate([
            'document_name' => 'required',
            'filess' => 'required',
        ]);

            try {
              $authid =  auth()->user()->id;
                $data=$request->except(['_token']);
                if($request->hasFile('filess'))
                {
                   $file=$request->file('filess');
                    $extension=$file->getClientOriginalExtension();
                    $filename=time().'.'.$extension;
                    $file->move('backEnd/image/client/document/',$filename);
                    $data['filess']=$filename;
                }
                $data['created_by']=$authid;
                $data['updated_by']=$authid;
                 Clientdocument::Create($data);
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
	 public function transformDate($value, $format = 'Y-m-d')
{
    try {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return \Carbon\Carbon::createFromFormat($format, $value);
    }
}
    public function clientcontactUpload(Request $request )
    {
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Clientcontactimport, $file);
            
            foreach ($dataa[0] as $key => $value) {
			//	dd($value['id']);
 $emailid   = Teammember::where('emailid',$value['emailid'])->pluck('emailid')->first();
				 $mentorid   = Teammember::where('emailid',$value['mentorid'])->pluck('id')->first();
              //  dd($mentorid);
              if($emailid){
                DB::table('teammembers')->where('emailid',$value['emailid'])->update([	
                    'mentor_id'         =>     $mentorid,
                  //  'ifsccode'         =>     $value['ifsccode'],
                  //  'nameasperbank'         =>     $value['beneficiary_name'],
                     ]);
               }
			//	 DB::table('teammembers')->where('id',$value['id'])->update([	
              //  'profilepic'         =>     $value['profilepic'],
             //   'mobile_no'  => $value['mobile_no'],
              //  'emergencycontactnumber'  => $value['emergencycontactnumber'],
               //  ]);
              
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
     public function debtorExcel(Request $request )
    {
     //  dd($request);
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Debtorimport, $file);
         //   dd($dataa); die;
            foreach ($dataa[0] as $key => $value) {
              
             //   $debtorid   = Debtor::where('name',$value['name'])->pluck('name')->first();
             
            //    if($debtorid){
                $db['name']=$value['name'];
                $db['amount']=$value['amount'] ;
               
                 $db['date']=$value['date'] ;
                 $db['year']=$value['year'] ;
                 $db['address']=$value['address'];
                 $db['email']=$value['email'];
                 $db['client_id']=$request->clientid;
                 $db['type']=$request->type;
                 $db['created_by']=auth()->user()->teammember_id;
                 $debtor= Debtor::Create($db);
               //          $debtor->save();
        //          //echo "sdcns";die;
        //      $debtorid = $debtor->id;

        //     $data = array(
        //         'name' =>  $value['name'],
        //         'email' =>  $value['email'],
        //         'year' =>  $value['year'],
        //         'date' =>  $value['date'],
        //         'amount' =>  $value['amount'],
        //         'clientid' => $request->clientid,
        //         'debtorid' => $debtorid,
        //         'yes' => 1,
        //         'no' => 0
        //    );
        //     Mail::send('emails.debtorform', $data, function ($msg) use($data){
        //         $msg->to($data['email']);
        //         $msg->subject('Kgs Confirmation');
        //      });
        //    
            
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
    public function clientdocumentOpen($id)
    {
        $doc = Clientdocument::where('id',$id)->first();
        
        $file = $doc->filess;
      
        if (File::isFile($file))
        {
            $file = File::get($file);
          
            $response = Response::make($file, 200);
            $content_types = [
                'application/octet-stream', // txt etc
                'application/msword', // doc
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
                'application/vnd.ms-excel', // xls
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
                'application/pdf', // pdf
            ];
            // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
            $response->header('Content-Type', $content_types);

            return $response;
        }
    }
      public function debtorPdf($id)
    {
        $debtorpdf = Debtor::where('id',$id)->first();
         $debtorconfirmation = DB::table('debtorconfirmations')->where('debtor_id',$id)->get();
        return view('backEnd.debtorform',compact('debtorpdf','debtorconfirmation'));
    }
      public function adminFile(Request $request)
    {
        $request->validate([
             'file' => 'required',
        ]);

        try {
            $data=$request->except(['_token']);
            $files = [];
            if($request->hasFile('file'))
            {
                foreach ($request->file('file') as $file) {
                    //$destinationPath = storage_path('app/backEnd/image/clientfile');
                  //  $name = $file->getClientOriginalName();
                  // $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                      $name = $file->getClientOriginalName();
					 $path = $file->storeAs('clientdocument',$name,'s3');
					$files[] = $name;
                 
                }
            }
            foreach($files as $filess )
            {
           // dd($files); die;
               $s = DB::table('clientfiles')->insert([
                    'name' => $request->name, 
                    'createdby' =>auth()->user()->teammember_id,
				     'clientfolder_id' =>  $request->clientfolder_id, 
                    'client_id' =>  $request->clientid, 
                    'file' => $filess, 
                     'created_at' => date('y-m-d'), 
                    'updated_at' => date('y-m-d')            
                ]);  
            
            }
            //dd($data);
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
   public function folderList($id)
    {
        $filelist  = DB::table('clientfiles')
        ->leftjoin('clientlogins','clientlogins.id','clientfiles.clientlogin_id')
			    ->leftjoin('teammembers','teammembers.id','clientfiles.createdby')
        ->where('clientfiles.clientfolder_id',$id)
       ->select('clientfiles.*','clientlogins.name','teammembers.team_member')->get();
	    $clientid  = DB::table('clientfolders') ->where('id',$id)
        ->select('clientfolders.*')->first();
       // dd($filelist);
        return view('backEnd.client.filelist',compact('filelist','clientid'));
    }
    public function folderDestroy ($id = '')
    {
       // dd($id);
        try {
            DB::table('clientfiles')->delete($id);
            $output = array('msg' => 'Deleted Successfully');
            return back()->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
	    public function  clientfileDelete($id)
  {
   // dd($id);
    try {
       DB::table('clientdocuments')->where([

        'id'   =>   $id,

      ])->delete();
      $output = array('msg' => 'Deleted Successfully');
          return back()->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
	   public function  clientcontactDelete($id)
  {
    //  dd($id);
    try {
       DB::table('clientcontacts')->where([

        'id'   =>   $id,

      ])->delete();
      $output = array('msg' => 'Deleted Successfully');
          return back()->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
	  public function folderStore(Request $request)
    
    { 
      //  dd($request);
        $request->validate([
            'name' => "required|max:200"
        ]);

        try {
            $data=$request->except(['_token']);
            $data['client_id'] = $request->client_id;
            $data['createdby'] = auth()->user()->teammember_id;
            Clientfolder::Create($data);
            $output = array('msg' => 'folder Create Successfully');
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
