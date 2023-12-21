<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Ilrfolder;
use App\imports\Informationresourceimport;
use Illuminate\Support\Facades\Storage;
use App\Models\Ilrbank;
use App\Models\Ilrsalary;
use App\Models\Ilrhouse;
use App\Models\Ilraddinformation;
use Excel;
use App\Models\Informationresource;
use Illuminate\Http\Request;
use DB;
use Crypt;
class InformationController extends Controller
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
		  public function ilrallList()
    {
       $informationresourcesDatas = 
       DB::table('ilrfolders')
      // ->leftjoin('informationresources','informationresources.ilrfolder_id','ilrfolders.id')
      // ->leftjoin('ilranswers','ilranswers.informationresource_id','informationresources.id')
      ->where('ilrfolders.parent_id',null)
      -> where('ilrfolders.client_id',auth()->user()->client_id)->get();
     // dd($informationresourcesDatas);
        return view('client.information.ilrallindex',compact('informationresourcesDatas'));
    }
	  public function ilrList()
    {
       $ilrlist = DB::table('talents')->
      latest()->get();
        return view('client.information.talentlist',compact('ilrlist'));
    }
	public function informationFirst(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
                $ilrquestion = Informationresource::where('id',$request->id)->first();
              $ilranswers = DB::table('ilranswers')
			  ->leftjoin('teammembers','teammembers.id','ilranswers.updateby')
        ->leftjoin('clientlogins','clientlogins.id','ilranswers.clientlogin_id')
        ->where('ilranswers.informationresource_id',$request->id)->orderBy('created_at', 'desc')->select('ilranswers.*','teammembers.team_member','clientlogins.name')->get();
    //dd($information);
                return response()->json($ilrquestion);
             }
            }
    
    }
    public function informationFirstt(Request $request)
    {
        //  dd($request);
          if ($request->ajax()) {
              if (isset($request->id))
               {
                  foreach ( DB::table('ilranswers')
                  ->leftjoin('teammembers','teammembers.id','ilranswers.updateby')
            ->leftjoin('clientlogins','clientlogins.id','ilranswers.clientlogin_id')
            ->where('ilranswers.informationresource_id',$request->id)->orderBy('created_at', 'asc')->select('ilranswers.*','teammembers.team_member','clientlogins.name')->get() as $sub) {
               $date = date('h:i a F d,Y', strtotime($sub->updated_at));
               if($sub->team_member != null){
               $name= $sub->team_member; }
               else { $name =$sub->name; } 
              $url = Storage::disk('s3')->temporaryUrl('clientinfodocument/'.$sub->url, now()->addMinutes(30));
              $urldelete = url('client/informationquestion/destroy/'. $sub->id);
             $user=(auth()->user()->id == 16 || auth()->user()->id == 44 || auth()->user()->id == 36);
           if($user == true)
           {
            echo " <tr>
            <td><a href=$url download=$url>$sub->url</a> </td>
            <td>
            
              $sub->remark
            </td>
            <td>$name
            </td>
            <td>
            $date
            </td>
              <td>
              <a href=$urldelete >DELETE </a></td>
          
            
        </tr>";
           }
           else
           {
            echo " <tr>
            <td><a href=$url download=$url>$sub->url</a> </td>
            <td>
            
              $sub->remark
            </td>
            <td>$name
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
    
  
   
   
    public function ilrtStore(Request $request)
    { 
        $request->validate([
            'file' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
          
            if($request->hasFile('file'))
            {
                       $file=$request->file('file');
                 //   $destinationPath =  storage_path('app/backEnd/image/talentedgeilr');
                    $name = $file->getClientOriginalName();
                    $path = $file->storeAs('talentedgeilr',$name,'s3');
                         $data['file'] = $name;
            }

            DB::table('talents')->where('id',$request->ilrid)->update([	
                'client_id'         =>     auth()->user()->client_id, 
                'createdby'         =>     auth()->user()->id, 
                'remark'         =>     $request->remark ??'', 
                'file'         =>      $data['file'], 
                 'updated_at' => date('Y-m-d H:i:s')     
                 ]);
     
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', $output);
        
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
		 public function ilrDownload($id, Request $request)
 {
        $ilrid = Crypt::decrypt($id);  
       // dd($ilrid);  
        $ilrfolder =  DB::table('ilranswers')->where('id',$ilrid)->first();
        $filess = $ilrfolder->url;
        $ilrid = $ilrfolder->informationresource_id;
        $ilrdesc = 'file download by';
        $this->activityLog($request, $ilrid,$filess,  $ilrdesc); 
        return response()->download(storage_path('app/backEnd/image/document/'.$ilrfolder->url));
    }
   public function index()
    {
     $assigncheck = DB::table('ilrfolderassigns')->where('client_id',auth()->user()->client_id)
     ->where('clientlogin_id',auth()->user()->id)->first();
     if($assigncheck != null){
        $ilrfolder = DB::table('ilrfolderassigns')
        ->leftjoin('ilrfolders','ilrfolders.id','ilrfolderassigns.ilrfolder_id')->
        where('ilrfolderassigns.client_id',auth()->user()->client_id)->where('ilrfolderassigns.clientlogin_id',auth()->user()->id)
        ->select('ilrfolders.*')->get();
//dd($ilrfolder);
        return view('client.information.assignfolderlist',compact('ilrfolder'));
     }
     else {
        $ilrfolder = Ilrfolder::with('ilr','ilrsubfolder')->where('client_id',auth()->user()->client_id)->where('parent_id',null)->get();
        return view('client.information.folderlist',compact('ilrfolder'));
     }
      
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function indexlist($id)
{
        $subfolder = DB::table('ilrfolders')->where('parent_id',$id)->where('client_id',auth()->user()->client_id)->first();
    //   dd($subfolder->parent_id);
        if ($subfolder== null) {
             
      $ilrfolder = DB::table('ilrfolders')->where('client_id',auth()->user()->client_id)->where('id',$id)->first();
      $informationresourcesDatas = DB::table('informationresources')
      ->leftjoin('teammembers','teammembers.id','informationresources.uploadedby')->
      where('client_id',auth()->user()->client_id)->where('ilrfolder_id',$id)
      ->select('informationresources.*','teammembers.team_member')->get();
			
			    $ilrfolders = Ilrfolder::with('ilr')->where('client_id',auth()->user()->client_id)->get();
			
      return view('client.information.index',compact('informationresourcesDatas','ilrfolder','id','ilrfolders'));
        } else {
          //  dd($subfolder->parent_id);
            $ilrfolder = Ilrfolder::with('ilrsubfolder')->where('parent_id',$subfolder->parent_id)->where('client_id',auth()->user()->client_id)->orderBy('created_at','asc')->get();
    // dd($ilrfolder);
            return view('client.information.folderlist',compact('ilrfolder','id'));
        }
     
    }
	public function updateStatus(Request $request)
{ 
   // dd($request);
     $request->validate([
         'status' => "required",
     ]);
     try {
         $data=$request->except(['_token']);
        
        
          DB::table('informationresources')->where('id',$request->id)->update([	
                 'status'         =>     $request->status, 
               'updateby'         =>     auth()->user()->id, 
               'uploadedbyclient'         =>      auth()->user()->client_id, 
                  'updated_at' => date('y-m-d')     
                  ]);
         //dd($data);
         $output = array('msg' => 'Submit Successfully');
         return back()->with('success', $output);
     } catch (Exception $e) {
         DB::rollBack();
         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
         report($e);
         $output = array('msg' => $e->getMessage());
         return back()->withErrors($output)->withInput();
     }
 
}
	 public function informationstatusUpdate(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
                $ilrquestion = Informationresource::where('id',$request->id)->first();
              $ilranswers = DB::table('ilranswers')
			  ->leftjoin('teammembers','teammembers.id','ilranswers.updateby')
        ->leftjoin('clientlogins','clientlogins.id','ilranswers.clientlogin_id')
        ->where('ilranswers.informationresource_id',$request->id)->orderBy('created_at', 'desc')->select('ilranswers.*','teammembers.team_member','clientlogins.name')->get();
    //dd($information);
                return response()->json($ilrquestion);
             }
            }
    
    }
    public function informationCreate($id)
    {
		    $ilrlog = DB::table('ilrtrail')
        ->leftjoin('teammembers','teammembers.id','ilrtrail.createdby')
        ->leftjoin('clientlogins','clientlogins.id','ilrtrail.clientlogin_id')
        ->where('pageid', $id)->where('type','ILR')->orderBy('created_at', 'desc')->select('ilrtrail.*','teammembers.team_member','clientlogins.name')->get();
		 $ilranswers = DB::table('ilranswers')
			  ->leftjoin('teammembers','teammembers.id','ilranswers.updateby')
        ->leftjoin('clientlogins','clientlogins.id','ilranswers.clientlogin_id')
        ->where('informationresource_id',$id)->orderBy('created_at', 'desc')->select('ilranswers.*','teammembers.team_member','clientlogins.name')->get();
        $informationresources = Informationresource::where('id',$id)->first();
        return view('client.information.create',compact('informationresources','id','ilranswers','ilrlog'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function informationStore(Request $request)
   { 
        $request->validate([
            'remark' => "required",
        ]);
        try {
            $data=$request->except(['_token']);
            $files = [];
            if($request->hasFile('document'))
            {
                foreach ($request->file('document') as $file) {
					 $name = $file->getClientOriginalName();
                   //  $destinationPath = storage_path('app/backEnd/image/document');
                  //  $name = $file->getClientOriginalName();
                //   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $path = $file->storeAs('clientinfodocument',$name,'s3');
                    $files[] = $name;
                    // $data['url'] = $name;
                }
            }
			  else{
                DB::table('ilranswers')->insert([
                    'informationresource_id' => $request->id, 
                    'url' => '', 
                    'remark' =>  $request->remark, 
                    'clientlogin_id' =>  auth()->user()->id, 
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')               
                ]); 
                $ilrid = $request->id;
                $ilrdesc = $request->remark.' by';
                $this->activityLog($request, $ilrid,'',  $ilrdesc);  
            }
            foreach($files as $filess )
            {
           // dd($files); die;
               $s = DB::table('ilranswers')->insert([
                    'informationresource_id' => $request->id, 
                    'url' => $filess, 
                    'remark' =>  $request->remark, 
                    'clientlogin_id' =>  auth()->user()->id, 
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);  
              $ilrid = $request->id;
                $ilrdesc = 'file uploaded by';
                $this->activityLog($request, $ilrid,$filess,  $ilrdesc);      
            }
			 DB::table('informationresources')->where('id',$request->id)->update([	
                    'status'         =>     '1', 
				  'updateby'         =>     auth()->user()->id, 
				  'uploadedbyclient'         =>      auth()->user()->client_id, 
                     'updated_at' => date('y-m-d')     
                     ]);
            //dd($data);
            $output = array('msg' => 'Submit Successfully');
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
     * @param  \App\Models\Informationresource  $informationresource
     * @return \Illuminate\Http\Response
     */
    public function show(Informationresource $informationresource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Informationresource  $informationresource
     * @return \Illuminate\Http\Response
     */
    public function edit(Informationresource $informationresource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Informationresource  $informationresource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Informationresource $informationresource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Informationresource  $informationresource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Informationresource $informationresource)
    {
        //
    }
	public function activityLog($request, $ilrid,$filess,  $ilrdesc){
        $actionName = class_basename($request->route()->getActionname());
                $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                  DB::table('ilrtrail')->insert([
                        'clientlogin_id' => auth()->user()->id, 
                        'ip_address' => $request->ip(), 
                        'pagetitle' => $pagename, 
                        'pageid' => $ilrid, 
                        'type' => 'ILR', 
                        'description' =>  $filess.' '.'( '.  $ilrdesc. ' )', 
                        'created_at' => date('y-m-d H:i:s'),       
                        'updated_at' => date('y-m-d H:i:s')       
                    ]);
      }
	  public function ilrbank(Request $request)
    {
       $id = $request->informationresource_id;
       $folderid = DB::table('ilrfolders')
 ->where('id',$id)->first();
       $ilrbanks = DB::table('ilrbanks')
       ->where('informationresource_id',$id)->get();
        return view('client.information.ilrbank',compact('ilrbanks','id','folderid'));
    }
	  public function ilrhouse(Request $request)
    {
       $id = $request->informationresource_id;
      $folderid = DB::table('ilrfolders')
       ->where('id',$id)->first();
       $ilrhouses = DB::table('ilrhouses')
       ->where('informationresource_id',$id)->get();
        return view('client.information.ilrhouse',compact('id','ilrhouses','folderid'));
    }
	  public function ilraddinformation(Request $request)
    {
       $id = $request->informationresource_id;
		   $folderid = DB::table('ilrfolders')
       ->where('id',$id)->first();
       $info = DB::table('ilraddinformations')
       ->where('informationresource_id',$id)->first();
		    $ilraddinformationsecond = DB::table('ilraddinformationsecond')
       ->where('informationresource_id',$id)->get();
       $ilraddinformationfirst = DB::table('ilraddinformationfirst')
       ->where('informationresource_id',$id)->get();
       $ilraddinformationthird = DB::table('ilraddinformationthird')
       ->where('informationresource_id',$id)->get();
       return view('client.information.ilraddinformation',compact('id','info','folderid','ilraddinformationthird',
																  'ilraddinformationsecond','ilraddinformationfirst'));
    }
	  public function ilrsalary(Request $request)
    {
       $id = $request->informationresource_id;
      $folderid = DB::table('ilrfolders')
       ->where('id',$id)->first();
       $ilrsalarys = DB::table('ilrsalaries')
       ->where('informationresource_id',$id)->get();
        return view('client.information.ilrsalary',compact('id','ilrsalarys','folderid'));
    }
   public function ilrsalaryStore(Request $request)
    { 
        $request->validate([
            'nameoftheemployee' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
             if($request->hasFile('salaryincomefile'))
            {
                         $file=$request->file('salaryincomefile');
                         $name = $file->getClientOriginalName();
                         $path = $file->storeAs('itr/ilrsalary',$name,'s3');
                              $data['salaryincomefile'] = $name;
            }
            if($request->hasFile('anyotherdetailfile'))
            {
                         $file=$request->file('anyotherdetailfile');
                         $name = $file->getClientOriginalName();
                         $path = $file->storeAs('itr/anyotherdetail',$name,'s3');
                              $data['anyotherdetailfile'] = $name;
            }
            $data['clientlogin_id'] = auth()->user()->id;
            $data['client_id'] =auth()->user()->client_id;

            Ilrsalary::Create($data);
     
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
    public function ilraddStore(Request $request)
    { 
  //      $request->validate([
    //        'Have_you' => "required",
      //  ]);

        try {
            $data=$request->except(['_token']);
             $info = DB::table('ilraddinformations')
            ->where('informationresource_id',$request->informationresource_id)->first();
         //   dd($info);
if($info == null){
    $data['clientlogin_id'] = auth()->user()->id;
    $data['client_id'] =auth()->user()->client_id;

    Ilraddinformation::Create($data);
}
       else
       {
        $data=$request->except(['_token']);
        Ilraddinformation::find($info->id)->update($data);
       }
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', $output);
        
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
	
  public function ilrhouseStore(Request $request)
    { 
        $request->validate([
            'house_type' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
            if($request->hasFile('rent_receivedfile'))
            {
                $file=$request->file('rent_receivedfile');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrhouse',$name,'s3');
                     $data['rent_receivedfile'] = $name;
            }
            if($request->hasFile('rent_amountfile'))
            {
                $file=$request->file('rent_amountfile');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrhouse',$name,'s3');
                     $data['rent_amountfile'] = $name;
            }
            if($request->hasFile('tax_paidfile'))
            {
                $file=$request->file('tax_paidfile');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrhouse',$name,'s3');
                     $data['tax_paidfile'] = $name;
            }
            if($request->hasFile('paymentfile'))
            {
                         $file=$request->file('paymentfile');
                         $name = $file->getClientOriginalName();
                         $path = $file->storeAs('itr/ilrhouse',$name,'s3');
                              $data['paymentfile'] = $name;
            }
            if($request->hasFile('anyotherdetailsfile'))
            {
                $file=$request->file('anyotherdetailsfile');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrhouse',$name,'s3');
                     $data['anyotherdetailsfile'] = $name;
            }
            $data['clientlogin_id'] = auth()->user()->id;
            $data['client_id'] =auth()->user()->client_id;

            Ilrhouse::Create($data);
     
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
    public function ilrbankStore(Request $request)
    { 
        $request->validate([
            'bank_name' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
            if($request->hasFile('bankstatement'))
            {
                $file=$request->file('bankstatement');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrbank',$name,'s3');
                     $data['bankstatement'] = $name;
            }
            $data['clientlogin_id'] = auth()->user()->id;
            $data['client_id'] =auth()->user()->client_id;

            Ilrbank::Create($data);
     
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
	public function folderStore(Request $request)
    
{ 
    $request->validate([
        'name' => "required"
    ]);

    try {
      $data=$request->except(['_token']);
      $data['client_id'] = auth()->user()->client_id;
       Ilrfolder::Create($data);
      
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
	public function informationUpload(Request $request )
       {
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Informationresourceimport, $file);
            
            foreach ($dataa[0] as $key => $value) {
           //     $informationresource   = Informationresource::where('question',$value['question'])->pluck('question')->first();
         
           //    if($informationresource == null){
               
                $db['client_id']=auth()->user()->client_id;
                $db['ilrfolder_id']=$request->ilrfolder_id;
                $db['question']=$value['question'] ;
                $db['status']= 0;
                Informationresource::Create($db);
             //  }
              
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
    public function editrecords(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
                $ilrquestion = Informationresource::where('id',$request->id)->first();
           //  dd($ilrquestion);
                return response()->json($ilrquestion);
             }
            }
    
    }
    public function editQuestion(Request $request )
    {
     $request->validate([
         'question' => 'required'
     ]);
   
     try {
        DB::table('informationresources')->where('id',$request->id)->update([ 
            'question'         =>  $request->question 
            ]);
          
        $output = array('msg' => 'question update Successfully');
         return back()->with('success', $output);
     } catch (Exception $e) {
         DB::rollBack();
         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
         report($e);
         $output = array('msg' => $e->getMessage());
         return back()->withErrors($output)->withInput();
     }
 }
    public function answerDelete(Request $request,$id)
    {
 // dd($id);
     try {
        DB::table('ilranswers')->where('id',$id)->delete();
          
        $output = array('msg' => 'Delete Successfully');
         return back()->with('success', $output);
     } catch (Exception $e) {
         DB::rollBack();
         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
         report($e);
         $output = array('msg' => $e->getMessage());
         return back()->withErrors($output)->withInput();
     }
 }
    public function questionDelete(Request $request,$id)
    {
  // dd($id);
     try {
        DB::table('informationresources')->where('id',$request->id)->delete();
          
        $output = array('msg' => 'question delete Successfully');
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