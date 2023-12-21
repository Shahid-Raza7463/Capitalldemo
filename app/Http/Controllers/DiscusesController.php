<?php

namespace App\Http\Controllers;
use App\Models\Teammember;
use App\Models\Courierinout;
use App\Imports\Discussimport;
use App\Models\Homecharteredaccountant1;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Excel;
class DiscusesController extends Controller
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
		 if(auth()->user()->role_id == 11){
      $discussDatas = DB::table('discuses')
      ->get();
      return view('backEnd.discuses.index',compact('discussDatas'));
		 }
        elseif(auth()->user()->role_id == 13 || auth()->user()->role_id == 14 || auth()->user()->role_id == 16 || auth()->user()->role_id == 17 || auth()->user()->role_id == 18 || auth()->user()->role_id == 20){
         /* $discussDatas = DB::table('discuses')
          ->leftjoin('discusesteammebers','discusesteammebers.discuss_id','discuses.id')
          ->where('discusesteammebers.teammember_id',auth()->user()->teammember_id)
		//	->orwhere('discuses.createdby',auth()->user()->teammember_id)
          ->select('discuses.*')
          ->get();*/
			$discussDatas = DB::table('discuses')
          ->leftJoin('discusesteammebers', 'discusesteammebers.discuss_id', '=', 'discuses.id')
          ->where('discusesteammebers.teammember_id', auth()->user()->teammember_id)
          ->orWhere('discuses.createdby', auth()->user()->teammember_id)
          ->select('discuses.*')
          ->distinct()
          ->get();
          
       //   dd($discussDatas);     
          return view('backEnd.discuses.index',compact('discussDatas'));
            }
       else
	   {
     //  dd('else');
      $discussDatas = DB::table('discuses')
      ->where('discuses.createdby',auth()->user()->teammember_id)
      ->get();
		    
      return view('backEnd.discuses.index',compact('discussDatas'));
	   }
    }// public function discussview()
    // {
    //       $discussDatas = DB::table('discuses')
    //        ->get();
  
    //    //   dd($discussDatas);
    //         return view('backEnd.discuses.index1',compact('discussDatas'));

    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $teammember = Teammember::where('role_id','!=',15)->orwhere('role_id','!=',19)
      ->with('title','role')->get();
      $assignment =DB::table('assignments')->get();
      $client =DB::table('clients')->get();
      return view('backEnd.discuses.create',compact('teammember','assignment','client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //   dd($request);
        $request->validate([
            'title' => "required",
            'teammember_ids' => "required",
            'relatedto' => "required",
            'description' => "required",
        ]);
        try {
            $data=$request->except(['_token']);
           
               $id = DB::table('discuses')->insertGetId([
                    'topic'   	=>$request->title,       
                    'description'   =>$request->description, 
                    'discuss_with'   =>$request->discuss_with,
                    'relatedto'   =>$request->relatedto,
                    'related_id'   =>$request->related_id,
                    'related_ids'   =>$request->related_ids,
                    'other'   =>$request->other,
                    'status'   =>$request->status,
                     'createdby'   	=>     auth()->user()->teammember_id,     
                     'created_at'			    =>	   date('Y-m-d H:i:s'),
                   
             ]);
          
             if($request->has('teammember_id'))
             {

             foreach ($request->teammember_id as $teammember ) 
             {
              DB::table('discusesteammebers')->insert([	
                'discuss_id'         =>     $id, 
                 'teammember_id'         =>     $teammember, 	
                 'created_at'			    =>	   date('Y-m-d H:i:s'),
                
                 ]);  
             }
          }
          if($request->has('teammember_ids'))
          {

          foreach ($request->teammember_ids as $teammembers ) 
          {
           DB::table('discusswithteams')->insert([	
             'discuss_id'         =>     $id, 
              'teammember_ids'         =>     $teammembers, 	
              'created_at'			    =>	   date('Y-m-d H:i:s'),
             
              ]);  
          }
       }
       $discuses = DB::table('discuses')->where('id',$id)->first();
    //  dd($discuses); 
            $output = array('msg' => 'Create Successfully');

            return redirect()->route('discuss.show',encrypt($discuses->id))->with('success', $output);
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
		 $IDs=decrypt($id);
      //  dd($id);
        $discuses = DB::table('discuses')->where('discuses.id',$IDs)->first();
        $teammember = DB::table('teammembers')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('role_id','!=',11)->where('status',1)->orwhere('role_id','!=',12)
        ->select('teammembers.*','roles.rolename')->get();
      //  dd($teammember);
        return view('backEnd.discuses.view',compact('discuses','teammember'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function discussupdate(Request $request)
    {
   
        try {
          $ids = DB::table('discusstopics')->insertGetId([
                'discuss_id' => $request->discuss_id, 
                 'discuss_topic' => $request->discuss_topic, 
                'createdby' =>  auth()->user()->teammember_id, 
                'updated_at' => date('Y-m-d H:i:s')               
            ]); 
			
			if($request->has('attachment'))
            {
            foreach ($request->attachment as $attachments ) 
            {
                 $attachment=$attachments;
                 $extension=$attachment->getClientOriginalExtension();
                 $filename=time().'.'.$extension;
                 $attachment->move('backEnd/image/discuss/',$filename);
                $data['attachment']=$filename;
               
             DB::table('discussattachements')->insert([
                 'discuss_id' => $request->discuss_id, 
                 'topic_id' => $ids, 
                 'attachment' =>   $data['attachment'] ??'',
                 'created_at' =>	   date('Y-m-d'),
                 'updated_at' =>    date('y-m-d'),
             ]);

         }
          }
			
			$discteamdata = DB::table('discusesteammebers')
        ->where('discuss_id', $request->discuss_id)
        ->get();
    
$teammembers = [];
$teammembername = '';
 $statusData = DB::table('discuses')
->where('id', $request->discuss_id)
->first();
//dd($statusData);
if ($statusData->status == 1 && !$discteamdata->isEmpty()) {
foreach ($discteamdata as $teammember) {
  $emailid = Teammember::where('id', $teammember->teammember_id)
                ->pluck('emailid')
                ->toArray();

  $createdbydata = Teammember::where('id', auth()->user()->teammember_id)
                ->pluck('team_member')
                ->first();
    $data = array(
        'discuss_id' => $request->discuss_id,
        'discuss_topic' => $request->discuss_topic,
        'createdby' => $createdbydata,
        );
                  
    Mail::send('emails.discussmail', $data, function ($msg) use ($data, $emailid) {
      $msg->to($emailid);
      $msg->subject('Notification - New Discussion Point Added');   
   });
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
    public function discussfilter(Request $request)
    {
      // dd($request->id);

      if ($request->ajax()) {
        if (isset($request->id)) {
         //   dd($request->id);
            $discusstopics = DB::table('discusstopics')
           
          ->where('id',$request->id)->first();
       //   dd($discusstopics);
            return response()->json($discusstopics);
         }
        }
               
       
    }
     public function discussStatus(Request $request)
    { 
      //  dd($request);
        DB::table('discuses')->where('id',$request->user_id)->update([	
            'status'         =>  $request->status,
             ]);
        return response()->json(['success'=>'Status change successfully.']);
    }
	
	public function discussDelete($id)
    {
      //  dd($id);
        try {
          $discuses = DB::table('discusstopics')->where('id',$id)->pluck('discuss_id')->first();
       
        DB::table('discusstopics')->where('id',$id)->delete();
			DB::table('discussattachements')->where('topic_id',$id)->delete();
       // dd($discuses);
        $output = array('msg' => 'Deleted Successfully');
       return redirect()->route('discuss.show',encrypt($discuses))->with('success', $output);
            // return redirect('discuss')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }        
}
public function Editupdate(Request $request)
    {
   //   dd($request);
        try {
            
            DB::table('discusstopics')->where('id',$request->id)->update([	
                'discuss_topic' => $request->description   
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
	public function participateUpdate(Request $request)
    {
    //  dd($request);
        try {
          DB::table('discusesteammebers')->where('discuss_id',$request->discuss_id)->delete();

            if($request->has('teammember_id'))
            {

            foreach ($request->teammember_id as $teammember ) 
            {
             DB::table('discusesteammebers')->insert([	
               'discuss_id'         =>     $request->discuss_id, 
                'teammember_id'         =>     $teammember, 	
                'created_at'			    =>	   date('Y-m-d H:i:s'),
               
                ]);  
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
    public function DiscussTeamUpdate(Request $request)
    {
    //  dd($request);
        try {
          DB::table('discusswithteams')->where('discuss_id',$request->discuss_id)->delete();
           
            if($request->has('teammember_id'))
            {

            foreach ($request->teammember_id as $teammember ) 
            {
             DB::table('discusswithteams')->insert([	
               'discuss_id'         =>     $request->discuss_id, 
                'teammember_ids'         =>     $teammember, 	
                'created_at'			    =>	   date('Y-m-d H:i:s'),
               
                ]);  
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
	 public function TopicUpdate(Request $request)
    {
     //   dd($request);
        try {
            
          DB::table('discuses')->where('id',$request->id)->update([	
              'topic' => $request->topic,

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
    public function DescriptionUpdate(Request $request)
    {
     //   dd($request);
        try {
            
          DB::table('discuses')->where('id',$request->id)->update([	
              'description' => $request->description,   
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
	    public function discussDeletes($id)
    {
      //  dd($id);
       try {

      //  $discuses = DB::table('discusstopics')->where('id',$id)->pluck('discuss_id')->first();
        DB::table('discuses')->where('id',$id)->delete();
        DB::table('discusstopics')->where('discuss_id',$id)->delete();
			DB::table('discussattachements')->where('discuss_id',$id)->delete();
      DB::table('discusswithteams')->where('discuss_id',$id)->delete();
      DB::table('discusesteammebers')->where('discuss_id',$id)->delete();
       // dd($discuses);
        $output = array('msg' => 'Deleted Successfully');
     //  return redirect()->route('discuss.show',encrypt($discuses))->with('success', $output);
         return redirect('discuss')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }        
}
public function ExcelStore(Request $request )
{
 // dd('hi');
 $request->validate([
     'file' => 'required'
 ]);

 try {
     $file=$request->file;
   
     $data = $request->except(['_token']);
     $dataa=Excel::toArray(new Discussimport, $file);
     
     foreach ($dataa[0] as $key => $value) {
 
         $db['discuss_topic']=$value['discuss_topic'] ;
        // $db['discuss_id']    = $request->discuss_id;
        //  $db['createdby']     = auth()->user()->teammember_id;
        //  $db['updated_at']      = date('Y-m-d H:i:s');  
                         
      //   dd($db);
      //   Student::Create($db);
         DB::table('discusstopics')->insert([
          'discuss_topic' => $db['discuss_topic'], 
          'discuss_id' => $request->discuss_id, 
          'createdby' =>  auth()->user()->teammember_id, 
          'updated_at' => date('Y-m-d H:i:s')  
          
      ]);   
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
	public function indexchart()
    {
     
      return view('backEnd.discuses.indexchart');
		}
}
