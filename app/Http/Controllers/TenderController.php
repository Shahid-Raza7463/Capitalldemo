<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
class TenderController extends Controller
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
     public function tenderexpireList()
    {  
    //    $tender = Tender::where('tenderdate', date('Y-m-d'))->first();
            $tenderDatas = 
             DB::table('tenders')
       ->leftjoin('teammembers','teammembers.id','tenders.teammember_id')
       ->where('tenders.status','!=','5')
       ->where('tenders.tenderdate','<=',date('Y-m-d'))
       ->select('tenders.id','tenders.status','tenders.contactperson','tenders.tenderofferedby'
       ,'tenders.tenderpublishdate','tenders.tenderdate','tenders.services','teammembers.team_member')->get();
       //   dd($tenderDatas);
             return view('backEnd.tender.tenderexpirelist',compact('tenderDatas'));
      
    }
     public function index()
    {  
        if(auth()->user()->teammember_id == 343 || auth()->user()->teammember_id == 99){
             $tenderDatas = Tender::latest()->get();
             return view('backEnd.tender.tenderfolder',compact('tenderDatas'));
         }
        elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 17){
             $tenderDatas = Tender::latest()->get();
             return view('backEnd.tender.tenderfolder',compact('tenderDatas'));
         }
         else {
            $tenderDatas = Tender::latest()->where('teammember_id', auth()->user()->teammember_id)
            ->orwhere('updatedby', auth()->user()->teammember_id)->with('teammember')->get();
            
        return view('backEnd.tender.tenderfolder',compact('tenderDatas'));
         }
    }
  public function List($id)
    {  

       
        if($id == 1){
        $tender = Tender::where('status', $id)->first();
        $tenderDatas = 
         DB::table('tenders')
   ->leftjoin('teammembers','teammembers.id','tenders.teammember_id')
   ->where('tenders.status',$id)->where('tenderdate','>=',date('Y-m-d'))
   ->select('tenders.id','tenders.status','tenders.contactperson','tenders.tenderofferedby'
   ,'tenders.tenderpublishdate','tenders.tenderdate','tenders.services','teammembers.team_member')->get();
      
         return view('backEnd.tender.index',compact('tenderDatas','tender','id'));
       }
     else {
        $tender = Tender::where('status', $id)->first();
        $tenderDatas = 
         DB::table('tenders')
   ->leftjoin('teammembers','teammembers.id','tenders.teammember_id')
   ->where('tenders.status',$id)
   ->select('tenders.id','tenders.status','tenders.contactperson','tenders.tenderofferedby'
   ,'tenders.tenderpublishdate','tenders.tenderdate','tenders.services','teammembers.team_member')->get();
      
         return view('backEnd.tender.index',compact('tenderDatas','tender','id'));
     }
      
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::where('role_id', 14)->
        orwhere('role_id', 13)->with('role')->get();
        return view('backEnd.tender.create',compact('teammember'));
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
            'tenderid' => 'required|unique:tenders',
         ]);

        try {
            $data=$request->except(['_token']);

          $tenderidd = DB::table('tenders')->insertGetId([
                'tenderofferedby' =>$request->tenderofferedby ??'', 
                'services' => $request->services ??'',  
                'tenderpublishdate' => $request->tenderpublishdate ??'',  
                'prebidmeetingdate' => $request->prebidmeetingdate ??'',  
                'organisation' => $request->organisation ??'',  
                'tendertype' => $request->tendertype ??'',  
                'nature' => $request->nature ??'',  
                'organisationwebsite' => $request->organisationwebsite ??'',  
                'createdby' => auth()->user()->teammember_id,
                'updatedby' => auth()->user()->teammember_id,
                'tenderid' =>  $request->tenderid ??'',  
                'teammember_id' =>  $request->teammember_id ??'',  
                'tenderfees' =>  $request->tenderfees ??'',  
                'tenderdate' =>  $request->tenderdate ??'',  
                'tenderhardcopy' =>  $request->tenderhardcopy ??'',  
                'stamppaperrequired' =>  $request->stamppaperrequired ??'',  
                'emd' =>  $request->emd ??'',  
                'openingtenderdate' =>  $request->openingtenderdate ??'',  
                'linkedinlink' =>  $request->linkedinlink ??'',  
                'daterange' =>  $request->daterange ??'',  
                'previousauditors' =>  $request->previousauditors ??'',  
                'currentauditors' =>  $request->currentauditors ??'',  
                'existing' =>  $request->existing ??'',  
                'lastyear' =>  $request->lastyear ??'',  
                'boardmembers' =>  $request->boardmembers ??'',  
                'cfo' =>  $request->cfo ??'',  
                'contactperson' =>  $request->contactperson ??'',  
                'email' =>  $request->email ??'',  
                'phoneno' =>  $request->phoneno ??'',  
                'address' =>  $request->address ??'',  
                'status' =>  '1',  
                'created_at' => date('Y-m-d H:i:s'),       
                'updated_at' => date('Y-m-d H:i:s')       
            ]);
         //  dd($tenderidd); die;
            $files = [];
          
            if($request->hasFile('tenderdocument'))
            {
               
                foreach ($request->file('tenderdocument') as $file) {
                    $destinationPath = 'backEnd/image/tender/';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                       //    dd($s); die;
                    $files[] = $name;
                 
                }
            }
            foreach($files as $filess )
    {
   // dd($files); die;
       $s = DB::table('tenderdocuments')->insert([
            'tenderdocument' => $filess, 
            'tender_id' => $tenderidd,
            'createdby' => auth()->user()->teammember_id,
             'created_at' => date('y-m-d'), 
            'updated_at' => date('y-m-d')            
        ]);  
    
    }
            $admin = Teammember::where('id',$request->teammember_id)->pluck('emailid')->first(); 
            // dd($partner);
            $data = array(
                'tenderofferedby' =>  $request->tenderofferedby,
             'services' =>  $request->services,
             'duedate' =>  $request->tenderdate,
             'partner' =>  $admin,
				 'tenderid' =>  $tenderidd 
        );
       
         Mail::send('emails.tenderverify', $data, function ($msg) use($data, $admin){
             $msg->to($admin);
             $msg->subject('kgs Tender Verify');
          });
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
              DB::table('activitylogs')->insert([
                    'user_id' => auth()->user()->teammember_id, 
                    'ip_address' => $request->ip(), 
                    'activitytitle' => $pagename, 
                    'description' => 'New Tender Added'.' '.'( '. $request->tenderofferedby. ' )', 
                    'created_at' => date('y-m-d'),       
                    'updated_at' => date('y-m-d')       
                ]);
			
			$tenderidd = $tenderidd;
            //    dd($value);
                  $tenderadded = 'Tender Created By ';
                   $this->activityLog($request, $tenderidd, $tenderadded);
			
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
     * @param  \App\Models\tender  $tender
     * @return \Illuminate\Http\Response
     */
	  public function tenderSubmitstore(Request $request)
    {
     //  dd($request);
        // $request->validate([
        //     'tendersubmitstatus' => "required"
        // ]);
        try {
            $data=$request->except(['_token']);
            if($request->hasFile('acknowledgementofsubmission'))
            {
                $file=$request->file('acknowledgementofsubmission');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/tender/',$filename);
                $data['acknowledgementofsubmission']=$filename;
            }
            else {
                $data['acknowledgementofsubmission']='';
            }
			  if($request->hasFile('documentsubmit'))
            {
                $file=$request->file('documentsubmit');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/tender/',$filename);
                $data['documentsubmit']=$filename;
            }
            else {
                $data['documentsubmit']='';
            }
           DB::table('tenders')->where('id',$request->rid)->update([	
                'status'         =>     '6', 
                 'result' => $request->result ??'',     
                 'tendersubmitstatus' => $request->tendersubmitstatus ??'',     
                 'remarkresult' => $request->remarkresult ??'',     
                 'acknowledgementofsubmission' => $data['acknowledgementofsubmission'] ??'',     
                 'documentsubmit' => $data['documentsubmit'] ??'',   
                 'refundstatus' => $request->refundstatus ??'',     
                 'detailofwinner' => $request->detailofwinner ??'', 
                 'lonecpmny' => $request->lonecpmny ??'', 
                 'loneamt' => $request->loneamt ??'', 
                 'ltwocpmny' => $request->ltwocpmny ??'', 
                 'ltwoamt' => $request->ltwoamt ??'', 
                 'lthreecpmny' => $request->lthreecpmny ??'', 
                 'lthreeamt' => $request->lthreeamt ??'', 
                 ]);
            //      $tender = Tender::where('id',$request->rid)->pluck('tenderofferedby')->first(); 
            //      $tendercreate = Tender::where('id',$request->rid)->pluck('createdby')->first(); 
            //      $staff = Teammember::where('id',$tendercreate)->pluck('emailid')->first(); 
            //      // dd($staff);
            //      $data = array(
            //       'companyname' =>  $tender,
            //       'partner' =>  $staff
      
            //  );
            
            //   Mail::send('emails.tendersubmit', $data, function ($msg) use($data, $staff){
            //       $msg->to($staff);
            //       $msg->subject('kgs Tender Submitted');
            //       $msg->bcc('records@kgsomani.com');
            //    });
			   $tenderidd = $request->rid;
            //    dd($value);
                  $tenderadded = 'Tender Submitted By ';
                   $this->activityLog($request, $tenderidd, $tenderadded);

             $output = array('msg' => 'Submit Successfully');
            return redirect('tender')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
	
    public function show(tender $tender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tender  $tender
     * @return \Illuminate\Http\Response
     */
    public function tenderssignedStore(Request $request)
    {
     //  dd($request);
        $request->validate([
            'emdstatus' => "required"
        ]);
        try {
            $data=$request->except(['_token']);
    
            DB::table('tenders')->where('id',$request->rid)->update([	
                'status'         =>     '4',  
                 'enrollmentofpayment' => $request->enrollmentofpayment ??'',     
                 'transactionid' => $request->transactionid ??'',     
                 'date' => $request->date ??'',     
                 'emdstatus' => $request->emdstatus ??'',     
                 'emdremarks' => $request->emdremarks ??'',     
                 'infavourof' => $request->infavourof ??'',     
                 'pairbank' => $request->pairbank ??'',     
                 'ddno' => $request->ddno ??'',     
                 'issuedate' => $request->issuedate ??'',     
                 'issuebank' => $request->issuebank ??'',     
                 'infavourofdd' => $request->infavourofdd ??'',     
                 'dateofexpiry' => $request->dateofexpiry ??'',     
                 'ddno' => $request->ddno ??'',     
                 ]);
                 $tender = Tender::where('id',$request->rid)->first(); 
                 $tendercreate = Tender::where('id',$request->rid)->pluck('createdby')->first(); 
                 $staff = Teammember::where('id',$tendercreate)->pluck('emailid')->first(); 
                 // dd($staff);
                 $data = array(
                    'tenderofferedby' =>  $tender->tenderofferedby,
             'services' =>  $tender->services,
             'duedate' =>  $tender->tenderdate,
       'tenderid' =>  $request->rid
             );
            
              Mail::send('emails.tendersubmit', $data, function ($msg) use($data, $staff){
                  $msg->to($staff);
                  $msg->subject('kgs Tender Submitted');
                 // $msg->bcc('Records@kgsomani.com');
               });
			   $tenderidd = $request->rid;
               //    dd($value);
                     $tenderadded = 'Tender Submitted By ';
                      $this->activityLog($request, $tenderidd, $tenderadded);
             $output = array('msg' => 'Submit Successfully');
            return redirect('tender')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function tendercreatedBystore(Request $request)
    {
     //  dd($request);
        // $request->validate([
        //     'tendersubmitstatus' => "required"
        // ]);
        try {
            $data=$request->except(['_token']);
            if($request->hasFile('endrefund'))
            {
                $file=$request->file('endrefund');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/tender/',$filename);
                $data['endrefund']=$filename;
            }
            else {
                $data['endrefund']='';
            }
                    if($request->hasFile('acknowledgementofsubmission'))
            {
                $file=$request->file('acknowledgementofsubmission');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/tender/',$filename);
                $data['acknowledgementofsubmission']=$filename;
            }
            else {
                $data['acknowledgementofsubmission']='';
            }
			  if($request->hasFile('documentsubmit'))
            {
                $file=$request->file('documentsubmit');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('backEnd/image/tender/',$filename);
                $data['documentsubmit']=$filename;
            }
            else {
                $data['documentsubmit']='';
            }
            DB::table('tenders')->where('id',$request->rid)->update([	
                'status'         =>     '5', 
                 'result' => $request->result ??'',     
                 'tendersubmitstatus' => $request->tendersubmitstatus ??'',     
                 'remarkresult' => $request->remarkresult ??'',     
                 'acknowledgementofsubmission' => $data['acknowledgementofsubmission'] ??'',     
                 'documentsubmit' => $data['documentsubmit'] ??'',     
                 'endrefund' => $data['endrefund'] ??'',     
                 'refundstatus' => $request->refundstatus ??'',     
                 'detailofwinner' => $request->detailofwinner ??'', 
                 'lonecpmny' => $request->lonecpmny ??'', 
                 'loneamt' => $request->loneamt ??'', 
                 'ltwocpmny' => $request->ltwocpmny ??'', 
                 'ltwoamt' => $request->ltwoamt ??'', 
                 'lthreecpmny' => $request->lthreecpmny ??'', 
                 'lthreeamt' => $request->lthreeamt ??'', 
                 ]);
            //      $tender = Tender::where('id',$request->rid)->pluck('tenderofferedby')->first(); 
            //      $tendercreate = Tender::where('id',$request->rid)->pluck('createdby')->first(); 
            //      $staff = Teammember::where('id',$tendercreate)->pluck('emailid')->first(); 
            //      // dd($staff);
            //      $data = array(
            //       'companyname' =>  $tender,
            //       'partner' =>  $staff
      
            //  );
            
            //   Mail::send('emails.tendersubmit', $data, function ($msg) use($data, $staff){
            //       $msg->to($staff);
            //       $msg->subject('kgs Tender Submitted');
            //       $msg->bcc('records@kgsomani.com');
            //    });
			   $tenderidd = $request->rid;
            //    dd($value);
                  $tenderadded = 'Tender Close By ';
                   $this->activityLog($request, $tenderidd, $tenderadded);

             $output = array('msg' => 'Submit Successfully');
            return redirect('tender')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function tenderAssigned(Request $request)
    {
     //   dd($request);
        $request->validate([
            'status' => "required"
        ]);
        try {
            $data=$request->except(['_token']);
           if($request->status == 3){
            DB::table('tenders')->where('id',$request->rid)->update([	
                'status'         =>     $request->status, 
                   
                 ]);
                   $tender = Tender::where('id',$request->rid)->first(); 
                 $staff = 'accounts@kgsomani.com'; 
                 // dd($staff);
                 $data = array(
                   'tenderofferedby' =>  $tender->tenderofferedby,
                    'services' =>  $tender->services,
                    'duedate' =>  $tender->tenderdate,
         'tenderid' =>  $request->rid
             );
            
              Mail::send('emails.tenderassign', $data, function ($msg) use($data, $staff){
                  $msg->to($staff);
                  $msg->subject('kgs Tender Approved');
               });
			       $tenderidd = $request->rid;
               //    dd($value);
                     $tenderadded = 'Tender Approved By ';
                      $this->activityLog($request, $tenderidd, $tenderadded);

             $output = array('msg' => 'Assign Successfully');
            return redirect('tender')->with('success', $output);
           }
           if($request->status == 2){
            DB::table('tenders')->where('id',$request->rid)->update([	
                'status'         =>     $request->status  ,  
                'remarks' => $request->remarks  
                 ]);
                 $tender = Tender::where('id',$request->rid)->first(); 
               //  dd($tender);
                 $tendercreate = Tender::where('id',$request->rid)->pluck('updatedby')->first(); 
                 $tenderemail = Teammember::where('id',$tendercreate)->pluck('emailid')->first(); 
                
                 $data = array(
                    'tenderofferedby' =>  $tender->tenderofferedby,
                    'services' =>  $tender->services,
                    'duedate' =>  $tender->tenderdate,
        'tenderid' =>  $request->rid
             );
            
              Mail::send('emails.tenderreject', $data, function ($msg) use($data, $tenderemail){
                  $msg->to($tenderemail);
                  $msg->subject('kgs Tender Reject');
               });
			   
			     $tenderidd = $request->rid;
               //    dd($value);
                     $tenderadded = 'Tender Reject By ';
                      $this->activityLog($request, $tenderidd, $tenderadded);

			   
             $output = array('msg' => 'Assign Successfully');
            return redirect('tender')->with('success', $output);
           }
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function edit($id)
    {
        $teammember=Teammember::latest()->get();
        $tender = Tender::where('id', $id)->first();
        return view('backEnd.tender.edit', compact('id', 'tender','teammember'));
    }
    public function tenderView($id)
    {
        $tender = Tender::where('id', $id)->first();
        $tenderDatas = DB::table('tenderdocuments')->where('tender_id', $id)->get();
        $teammember = Teammember::where('role_id', 14)->
        orwhere('role_id', 13)->with('role')->get();
		
		 $tenderlog = DB::table('trail')
        ->leftjoin('teammembers','teammembers.id','trail.createdby')
        ->where('pageid', $id)->where('type','tender')->select('trail.*','teammembers.team_member')->get();

        return view('backEnd.tender.view', compact('id', 'tender','teammember','tenderDatas','tenderlog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tender  $tender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
            $data['updatedby'] = auth()->user()->teammember_id;
            Tender::find($id)->update($data);
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
              DB::table('activitylogs')->insert([
                    'user_id' => auth()->user()->teammember_id, 
                    'ip_address' => $request->ip(), 
                    'activitytitle' => $pagename, 
                    'description' => 'New Tender Update'.' '.'( '. $request->tenderofferedby. ' )', 
                    'created_at' => date('y-m-d'),       
                    'updated_at' => date('y-m-d')       
                ]);
            $output = array('msg' => 'Updated Successfully');
            return redirect('tender')->with('success', $output);
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
     * @param  \App\Models\tender  $tender
     * @return \Illuminate\Http\Response
     */
    public function destroy(tender $tender)
    {
        //
    }
	 public function activityLog($request, $tenderidd,$tenderadded){
        $actionName = class_basename($request->route()->getActionname());
                $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                  DB::table('trail')->insert([
                        'createdby' => auth()->user()->teammember_id, 
                        'ip_address' => $request->ip(), 
                        'pagetitle' => $pagename, 
                        'pageid' => $tenderidd, 
                        'type' => 'Tender', 
                        'description' => $tenderadded, 
                        'created_at' => date('y-m-d H:i:s'),       
                        'updated_at' => date('y-m-d H:i:s')       
                    ]);
      }
}
