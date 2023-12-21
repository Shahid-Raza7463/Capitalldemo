<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Outstanding;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon;
use DB;
class OutstandingController extends Controller
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
	public function echart_search(Request $request)
    {
      //  dd($request->partners);
        $teammember = Teammember::where('role_id','!=',11)->where('role_id','!=',12)->with('title','role')->get();
       // $total= DB::table('outstandings')->where('Partner',auth()->user()->teammember_id)->sum('AMT');
       
   
        $outstandingDatas  =  DB::table('outstandings')
        ->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        ->where('Partner',$request->partners)
            ->select('outstandings.*','teammembers.team_member')->get();

            $partner = DB::table('outstandings')
            ->leftjoin('teammembers','teammembers.id','outstandings.Partner')
         //   ->where('Partner',auth()->user()->teammember_id)
                ->select('teammembers.team_member','teammembers.id')->
                distinct('teammembers.team_member')->get();
    

   // dd($outstandingDatas);
   $greaterthan30=0;
   $lessthan30=0;
   $greaterthan180=0;
   $total=0;
   
    foreach($outstandingDatas as $outstandingData)
    {
    $current=Carbon\Carbon::now();    
    $formatted_dt1=Carbon\Carbon::parse($current);
      $pendingdays=$formatted_dt1->diffInDays($outstandingData->DATE);
        if($pendingdays>30 && $pendingdays<  181)
        {
       $gdays[]=$pendingdays;
      $greaterthan30=$greaterthan30+$outstandingData->AMT;

     
        }

        elseif($pendingdays > 18)
        {
       $gdays[]=$pendingdays;
      $greaterthan180=$greaterthan180+$outstandingData->AMT;

     
        }

      
        else
        {
            $ldays[]=$pendingdays;
            $lessthan30=$lessthan30+$outstandingData->AMT;

        }
       // echo"<pre>";
      //   print_r($pendingdays);

      
    }

    $outstandingdata=['More than 30 Days','Less than 30 Days','More than 180 Days'];
    $Number=[$greaterthan30,$lessthan30];
    
   // dd($data);
 
  $array[] = ['Oustanding','Amount'];
  $array[]=["More than 30 Days",$greaterthan30];
  $array[]=["Less than 30 Days",$lessthan30];
  $array[]=["More than 180 Days",$greaterthan180];

 


        $greater30=0;
        $greaterthan60=0;
        $greaterthan90=0;
        $urgent=0;
   
   foreach($outstandingDatas as $outstandingData)
   {
   $current=Carbon\Carbon::now();    
   $formatted_dt1=Carbon\Carbon::parse($current);
     $pendingdays=$formatted_dt1->diffInDays($outstandingData->DATE);
     $total=$total+$outstandingData->AMT;

       if($pendingdays < 60)
       {
      
       $greater30=$greater30+$outstandingData->AMT;

    
       }
       elseif($pendingdays > 60 && $pendingdays < 90 )
       {
      
       $greaterthan60=$greaterthan60+$outstandingData->AMT;

    
       }

       elseif($pendingdays > 90 && $pendingdays < 180 )
       {
      
       $greaterthan90=$greaterthan90+$outstandingData->AMT;

    
       }
       elseif($pendingdays > 180 )
       {
      
       $urgent=$urgent+$outstandingData->AMT;

    
       }
     
   }
  
       $label = ['30-60 days', '60-90 days', '90-180 days', 'Urgent and Extremly old', 'Grand Total'];
      
       $amounts = [$greater30, $greaterthan60, $greaterthan90, $urgent, $total];

       return view('backEnd.outstanding.outstandingechart',['labels' => $label, 'amounts' => $amounts,'partner' => $partner])
       ->with('outstandingdata', json_encode($array));
    }
	public function echartt()
    {

        $teammember = Teammember::where('role_id','!=',11)->where('role_id','!=',12)->with('title','role')->get();
       // $total= DB::table('outstandings')->where('Partner',auth()->user()->teammember_id)->sum('AMT');
       
    if(auth()->user()->role_id==11 || auth()->user()->role_id==12)
    {
        $outstandingDatas  =  DB::table('outstandings')
        ->leftjoin('teammembers','teammembers.id','outstandings.Partner')
     //   ->where('Partner',auth()->user()->teammember_id)
            ->select('outstandings.*','teammembers.team_member')->get();

 $partner = DB::table('outstandings')
           ->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        //   ->where('Partner',auth()->user()->teammember_id)
               ->select('teammembers.team_member','teammembers.id')->
               distinct('teammembers.team_member')->get();
		
    }
    else
    {
        $outstandingDatas  =  DB::table('outstandings')
        ->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        ->where('Partner',auth()->user()->teammember_id)
            ->select('outstandings.*','teammembers.team_member')->get();

		 $partner = DB::table('outstandings')
           ->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        //   ->where('Partner',auth()->user()->teammember_id)
               ->select('teammembers.team_member','teammembers.id')->
               distinct('teammembers.team_member')->get();
		
    }

   // dd($outstandingDatas);
   $greaterthan30=0;
   $lessthan30=0;
   $greaterthan180=0;
   $total=0;
   
    foreach($outstandingDatas as $outstandingData)
    {
    $current=Carbon\Carbon::now();    
    $formatted_dt1=Carbon\Carbon::parse($current);
      $pendingdays=$formatted_dt1->diffInDays($outstandingData->DATE);
        if($pendingdays>30 && $pendingdays<  181)
        {
       $gdays[]=$pendingdays;
      $greaterthan30=$greaterthan30+$outstandingData->AMT;

     
        }

        elseif($pendingdays > 18)
        {
       $gdays[]=$pendingdays;
      $greaterthan180=$greaterthan180+$outstandingData->AMT;

     
        }

      
        else
        {
            $ldays[]=$pendingdays;
            $lessthan30=$lessthan30+$outstandingData->AMT;

        }
       // echo"<pre>";
      //   print_r($pendingdays);

      
    }

    $outstandingdata=['More than 30 Days','Less than 30 Days','More than 180 Days'];
    $Number=[$greaterthan30,$lessthan30];
    
   // dd($data);
 
  $array[] = ['Oustanding','Amount'];
  $array[]=["More than 30 Days",$greaterthan30];
  $array[]=["Less than 30 Days",$lessthan30];
  $array[]=["More than 180 Days",$greaterthan180];

 


        $greater30=0;
        $greaterthan60=0;
        $greaterthan90=0;
        $urgent=0;
   
   foreach($outstandingDatas as $outstandingData)
   {
   $current=Carbon\Carbon::now();    
   $formatted_dt1=Carbon\Carbon::parse($current);
     $pendingdays=$formatted_dt1->diffInDays($outstandingData->DATE);
     $total=$total+$outstandingData->AMT;

       if($pendingdays < 60)
       {
      
       $greater30=$greater30+$outstandingData->AMT;

    
       }
       elseif($pendingdays > 60 && $pendingdays < 90 )
       {
      
       $greaterthan60=$greaterthan60+$outstandingData->AMT;

    
       }

       elseif($pendingdays > 90 && $pendingdays < 180 )
       {
      
       $greaterthan90=$greaterthan90+$outstandingData->AMT;

    
       }
       elseif($pendingdays > 180 )
       {
      
       $urgent=$urgent+$outstandingData->AMT;

    
       }
     
   }
  
       $label = ['30-60 days', '60-90 days', '90-180 days', 'Urgent and Extremly old', 'Grand Total'];
      
       $amounts = [$greater30, $greaterthan60, $greaterthan90, $urgent, $total];

       return view('backEnd.outstanding.outstandingechart',['labels' => $label, 'amounts' => $amounts,'partner' => $partner])->with('outstandingdata', json_encode($array));
    }
	 public function mailshow(Request $request)
{
  //  dd($request);
    if ($request->ajax()) {
        if (isset($request->id))
         {
             foreach ( DB::table('trail')
            ->leftjoin('outstandings','outstandings.id','trail.pageid')
            ->select('trail.*','outstandings.CLIENT_NAME as clientname')->
            where('trail.pageid',$request->id)->where('trail.type','Outstanding')->get() as $sub) {
          
             echo " <tr>
        <td>$sub->description </td>
        <td>
          $sub->created_at
        </td>
        
    </tr>";
            }  
        }
        }

} 
	  public function sendMail(Request $request)
{
  //  dd($request);
    if ($request->ajax()) {
        if (isset($request->id)) {
           // dd($request->id);
            $invoice = DB::table('outstandings')
          ->leftjoin('invoices','invoices.invoice_id','outstandings.BILL_NO')
          ->select('outstandings.CLIENT_NAME as clientname','outstandings.id as outstandingid','outstandings.DATE as date','invoices.contactemail','outstandings.AMT as amount')->
          where('outstandings.id',$request->id)->first();
$invoice->date = date('F d,Y', strtotime($invoice->date));

            return response()->json($invoice);
         }
        }

} 
    public function oustandingMail(Request $request)
    {
      //  dd($request);
        $request->validate([
             'subject' => "required",
           'email' => "required"
       ]);

         try {
      if($request->teammember_id) {
        $teammembermail = Teammember::wherein('id',$request->teammember_id)->pluck('emailid')->toArray();
        }
            $data = array(
             'subject' =>  $request->subject,
             'email' =>  $request->email,
             'description' =>  $request->description,
       'teammembermail' => $teammembermail ??'',
        );
       
         Mail::send('emails.outstandingmail', $data, function ($msg) use($data , $request){
             $msg->to($data['email']);
             $msg->subject($data['subject']);
			    if($request->teammember_id) {
                $msg->cc($data['teammembermail']);
            }
          });
			  $outstandingid = $request->outstandingid;
      //    dd($value);
            $outstanding = 'Outstanding Reminder Send ';
             $this->activityLog($request, $outstandingid, $outstanding);
             $output = array('msg' => 'Mail Send Successfully');
             return back()->with('success', $output);
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
		 if(auth()->user()->teammember_id == 161 || auth()->user()->teammember_id == 550){
			  $teammember = Teammember::where('role_id','!=',11)->where('role_id','!=',12)->with('title','role')->get();
            $total= DB::table('outstandings')->sum('AMT');
        $outstandingDatas  =  DB::table('outstandings')
->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        ->select('outstandings.*','teammembers.team_member')->get();
        return view('backEnd.outstanding.index', compact('outstandingDatas','total','teammember'));
    }
         elseif(auth()->user()->teammember_id == 99){
			  $teammember = Teammember::where('role_id','!=',11)->where('role_id','!=',12)->with('title','role')->get();
            $total= DB::table('outstandings')->sum('AMT');
        $outstandingDatas  =  DB::table('outstandings')
->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        ->select('outstandings.*','teammembers.team_member')->get();
        return view('backEnd.outstanding.index', compact('outstandingDatas','total','teammember'));
    }
    elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 17){
			  $teammember = Teammember::where('role_id','!=',11)->where('role_id','!=',12)->with('title','role')->get();
            $total= DB::table('outstandings')->sum('AMT');
        $outstandingDatas  =  DB::table('outstandings')
->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        ->select('outstandings.*','teammembers.team_member')->get();
        return view('backEnd.outstanding.index', compact('outstandingDatas','total','teammember'));
    }
    else {
        $total= DB::table('outstandings')->where('Partner',auth()->user()->teammember_id)->sum('AMT');
  $teammember = Teammember::where('role_id','!=',11)->where('role_id','!=',12)->with('title','role')->get();
        $outstandingDatas  =  DB::table('outstandings')
        ->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        ->where('Partner',auth()->user()->teammember_id)
                ->select('outstandings.*','teammembers.team_member')->get();
                return view('backEnd.outstanding.index', compact('outstandingDatas','total','teammember'));
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
	    public function activityLog($request, $outstandingid,$outstanding){
        $actionName = class_basename($request->route()->getActionname());
                $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                  DB::table('trail')->insert([
                        'createdby' => auth()->user()->teammember_id, 
                        'ip_address' => $request->ip(), 
                        'pagetitle' => $pagename, 
                        'pageid' => $outstandingid, 
                        'type' => 'Outstanding', 
                        'description' => $outstanding, 
                        'created_at' => date('y-m-d H:i:s'),       
                        'updated_at' => date('y-m-d H:i:s')       
                    ]);
      }
}
