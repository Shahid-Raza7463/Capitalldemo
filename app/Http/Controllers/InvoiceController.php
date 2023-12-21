<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Currency;
use App\Models\Client;
use App\Models\Companydetail ;
use App\Models\Teammember ;
use Carbon;
use App\Models\Statecode;
use DB;

use Illuminate\Support\Facades\Mail;
class InvoiceController extends Controller
{
	
    public function __construct()
    {
        $this->middleware('auth');
    }
	 public function search(Request $request)
    {
        $q = $request->q;
 if($q != ""){
 $invoiceData = DB::table('invoices')->leftjoin('clients','clients.id','invoices.client_id')
 ->leftjoin('teammembers','teammembers.id','invoices.partner')
 ->where ( 'invoices.total', 'LIKE', '%' . $q . '%' )->orWhere ( 'invoices.invoice_id', 'LIKE', '%' . $q . '%' )
  ->orWhere ( 'teammembers.team_member', 'LIKE', '%' . $q . '%' )
	  ->orWhere ( 'clients.client_name', 'LIKE', '%' . $q . '%' )
 ->select('invoices.*','clients.client_name','teammembers.team_member')->orderBy('id', 'desc')->paginate (10)->setPath ( '' );
 $pagination = $invoiceData->appends ( array (
    'q' =>  $request->q
  ) );
 // dd($pagination);
 if (count ( $invoiceData ) > 0)
  return view ( 'backEnd.invoice.index',compact('invoiceData'))->withQuery ( $q );
 }
  return view ( 'backEnd.invoice.index' )->withMessage ( 'No Details found. Try to search again !' );

    }
    public function invoiceView($id)
{
    $invoice =  DB::table('invoices')
    ->leftjoin('clients','clients.id','invoices.client_id')
		->leftjoin('currencies','currencies.id','invoices.currency')
    ->select('invoices.*','currencies.code','currencies.value','clients.client_name')->where('invoices.id', $id)->first();
    $companydetails =  DB::table('companydetails')->where('id',$invoice->companydetails_id)->first();
  $bank =  DB::table('banks')->where('id',$invoice->bank_id)->first();
    return view('backEnd.invoice.view', compact('invoice','companydetails','bank'));
}
	    public function downloadpdf($id)
{
    $invoice =  DB::table('invoices')
    ->leftjoin('clients','clients.id','invoices.client_id')
   ->leftjoin('currencies','currencies.id','invoices.currency')
    ->select('invoices.*','currencies.code','currencies.value','clients.client_name')->where('invoices.id', $id)->first();
    return view('backEnd.invoice.invoicepdf', compact('invoice'));

}
	 public function invoicereport()
     {
      //  dd($id);
		  if(auth()->user()->teammember_id == 161 || auth()->user()->teammember_id == 550){
        $invoiceData = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
       ->select('invoices.*','clients.client_name','teammembers.team_member')->orderBy('id', 'desc')->get();
        return view('backEnd.invoice.invoicereport',compact('invoiceData'));
    }
      elseif(auth()->user()->role_id == 17 || auth()->user()->role_id == 11 ){
        $invoiceData = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
       ->select('invoices.*','clients.client_name','teammembers.team_member')->orderBy('id', 'desc')->get();
        return view('backEnd.invoice.invoicereport',compact('invoiceData'));
    }
    else {
        $invoiceData = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
       ->where('createdby',auth()->user()->teammember_id)
			 ->orwhere('partner',auth()->user()->teammember_id)
       ->select('invoices.*','clients.client_name','teammembers.team_member')->orderBy('id', 'desc')->paginate(10);
        return view('backEnd.invoice.invoicereport',compact('invoiceData'));
    }
}
    public function index()
    {
        if(auth()->user()->teammember_id == 161 || auth()->user()->teammember_id == 74 || auth()->user()->teammember_id == 550){
        $invoiceData = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
			  ->leftjoin('assignments','assignments.id','invoices.assignment_id')
       ->select('invoices.*','clients.client_name','teammembers.team_member','assignments.assignment_name')->orderBy('id', 'desc')->get();
        return view('backEnd.invoice.index',compact('invoiceData'));
    }
		  elseif(auth()->user()->teammember_id == 99){
        $invoiceData = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
			->leftjoin('assignments','assignments.id','invoices.assignment_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
       ->select('invoices.*','clients.client_name','teammembers.team_member','assignments.assignment_name')->orderBy('id', 'desc')->get();
        return view('backEnd.invoice.index',compact('invoiceData'));
    }
    elseif(auth()->user()->role_id == 17 || auth()->user()->role_id == 11 ){
        $invoiceData = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
			  ->leftjoin('assignments','assignments.id','invoices.assignment_id')
       ->select('invoices.*','clients.client_name','teammembers.team_member','assignments.assignment_name')->orderBy('id', 'desc')->get();
        return view('backEnd.invoice.index',compact('invoiceData'));
    }
    else {
        $invoiceData = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
			  ->leftjoin('assignments','assignments.id','invoices.assignment_id')
       ->where('createdby',auth()->user()->teammember_id)
			 ->orwhere('partner',auth()->user()->teammember_id)
       ->select('invoices.*','clients.client_name','teammembers.team_member','assignments.assignment_name')->orderBy('id', 'desc')->get();
        return view('backEnd.invoice.index',compact('invoiceData'));
    }
}
    //client name
    public function create(Request $request)
    {
		 $statecode = Statecode::orderBy('statecode', 'asc')->get();  
        $teammember = Teammember::where('role_id','=',13)->where('status',1)->with('title')->get();
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
       // dd($client);
      }
      elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 17 )
      {
        $client = Client::latest()->get(); 
      }
        $company = Companydetail::latest()->get();  
		$bank = DB::table('banks')->latest()->get();
        $team = Teammember::latest()->get();  
		  if ($request->ajax()) {
            if (isset($request->category_id)) {
                foreach (Currency::where('export_id', $request->category_id)->get() as $sub) {
                    echo "<option value='" . $sub->id . "'>" . $sub->code . "</option>";
                }
            }
          
        }
       else{
            return view('backEnd.invoice.create',compact('bank','client','teammember','company','team','statecode'));
        }  
    } 
public function clientList(Request $request)
{
    if ($request->ajax()) {
        if (isset($request->category_id)) {
          $client = Client::where('id',$request->category_id)->first();
//dd($client);
            return response()->json($client);
         }
        }

}  
public function companyList(Request $request)
{
   if ($request->ajax()) {
        if (isset($request->category_id)) {
          $client =DB::table('invoicenumbers')
        ->where('companydetails_id',$request->category_id)
        ->where('financialyear',$request->selectedvalue)->orderBy('id', 'DESC')->first();
        //  dd($client);
          return response()->json($client);
         }
        }

}  
public function companyCode(Request $request)
{
    if ($request->ajax()) {
        if (isset($request->category_id)) {
          $client =DB::table('companydetails')
          ->where('id',$request->category_id)->first();
        //  dd($client);
          return response()->json($client);
         }
        }

} 
public function edit($id)
{
	  $statecode = Statecode::latest()->get(); 
    $teammember = Teammember::where('role_id','=',13)->with('title')->get();
    if(auth()->user()->teammember_id == 99 || auth()->user()->teammember_id == 74){
        $client = Client::latest()->get(); 
       // dd($client);
      }
   elseif(auth()->user()->role_id == 13 ){
        $client = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
        ->where('assignmentmappings.leadpartner',auth()->user()->teammember_id)
			  ->orwhere('assignmentmappings.otherpartner',auth()->user()->teammember_id)
        ->select('clients.client_name','clients.id')
        ->distinct()->get();
       // dd($client);
      }
      elseif(auth()->user()->role_id == 14 )
      {
        $client = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings','assignmentmappings.id','assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
        ->where('assignmentteammappings.teammember_id',auth()->user()->teammember_id)
        ->select('clients.client_name','clients.id')
        ->distinct()->get();
       // dd($client);
      }
      elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 17 || auth()->user()->role_id == 18)
      {
        $client = Client::latest()->get(); 
      }
    $company = Companydetail::latest()->get();  
  $invoice =  Invoice::with('teammember','teammember.role')->where('id', $id)->first();
	$bank = DB::table('banks')->latest()->get();
    $invoicelog = DB::table('trail')
    ->leftjoin('teammembers','teammembers.id','trail.createdby')
    ->where('pageid', $id)->where('type','Invoice')->select('trail.*','teammembers.team_member')->get();
    return view('backEnd.invoice.edit', compact('bank','statecode','id', 'invoice','client','teammember','company','invoicelog'));
}
public function update(Request $request, $id)
{
   // dd($request->partner);
  $companydetails_id =DB::table('invoices')
->where('id',$id)->pluck('companydetails_id')->first();
	//dd($companydetails_id);
    if($request->status == 2){
if($request->partner ==null){
  
      $output = array('msg' => 'Please select partner');
    return back()->with('statuss', $output);
}
    }
if($request->companydetails_id == 0  && $request->invoice_id == null){
    if($request->status == 2){
      $output = array('msg' => 'Please select company and partner');
    return back()->with('statuss', $output);
}
    }
      try {
          $data=$request->except(['_token']);
		       $data=$request->except('companycode');
          
		    if($request->status == 2){
                $data['updatedby'] = auth()->user()->teammember_id;
           $data['invoice_id'] = $request->companycode.'/'.$request->financialyear.'/'.$request->invoice_id;
          }
		  if($request->status == 0 || $request->status == 1 || $request->status == 3 || $request->status == 4){
            $data['invoice_id'] = NULL;
            $data['companydetails_id'] = NULL;
            }
            if(auth()->user()->role_id == 13)
            {
            $data['status'] = 4;

            }
		     if($request->hasFile('finalreport'))
            {
                $file=$request->file('finalreport');
                 //   $destinationPath = 'backEnd/image/invoice';
                    $name = $file->getClientOriginalName();
				   $path = $file->storeAs('invoice',$name,'s3');
                //   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['finalreport'] = $name;
               
            }
            if($request->hasFile('appointmentletter'))
            {
                $file=$request->file('appointmentletter');
                //    $destinationPath = 'backEnd/image/invoice';
                    $name = $file->getClientOriginalName();
				  $path = $file->storeAs('invoice',$name,'s3');
               //    $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['appointmentletter'] = $name;
               
            }
          Invoice::find($id)->update($data);
		 if(auth()->user()->role_id == 13 && $request->status == 4)
            {
                {
   
                    $accountant = DB::table('teammembers')->where('role_id',17)->select('emailid')->get();
                    foreach ($accountant as $accountantmail ) {
                        $clientid   = DB::table('invoices')->where('id',$id)->pluck('client_id')->first();
                        $clientname   = DB::table('clients')->where('id',$clientid)->pluck('client_name')->first();
                     //   dd($value);
                        $accountantemail = DB::table('teammembers')->where('emailid',$accountantmail->emailid)
                        ->pluck('emailid')->first();
                        //dd($certificateemail);
                      //  $juryname  = Jury::where('email',$jury)->pluck('name')->first();
                      
                        $data = array(
                            'subject' => "Kgs Inovice Request",
                            'clientname' =>   $clientname,
                            'email' =>   $accountantemail,
                            'invoiceid' =>  $id,
                       );
                         
                        Mail::send('emails.invoicemail', $data, function ($msg) use($data){
                            $msg->to($data['email']);
                            $msg->subject($data['subject']);
                         }); 
                        }
                    }
			    $clientname = DB::table('clients')->where('id',$request->client_id)->pluck('client_name')->first();
                  $invoiceid = $id;
              //    dd($value);
                    $invoiceadded = 'Invoice Approved By Partner ';
                     $this->activityLog($request, $invoiceid,  $clientname, $invoiceadded);
            }
		       if( $request->status == 2){
          DB::table('invoicenumbers')->insert([
              'companydetails_id'         =>     $request->companydetails_id,
              'invocieno'         =>     $request->invoice_id + 1,
			   'financialyear'  =>     $request->financialyear,
              'created_at' => date('y-m-d'),       
              'updated_at' => date('y-m-d')   
               ]);
				
			   }
               $createdby = DB::table('invoices')->where('id',$id)->pluck('createdby')->first();
                        if($request->status == 2){
                            
  
                $client_name   = DB::table('clients')->where('id',$request->client_id)->pluck('client_name')->first();
    
                DB::table('outstandings')->insert([
                    'DATE'         =>     $request->invoicedate,
                    'AMT'         =>     $request->total,
                    'Partner'         =>     $request->partner,
                    'CLIENT_NAME'         =>    $client_name,
                    'BILL_NO'         =>    $request->companycode.'/'.$request->financialyear.'/'.$request->invoice_id,
                    'created_at' => date('y-m-d'),       
                    'updated_at' => date('y-m-d')   
                     ]);
                  
                     $accountant = DB::table('teammembers')->where('id',$request->partner)->orwhere('id',$createdby)->get();
                     foreach ($accountant as $accountantmail ) {
        
                        $accountantemail = DB::table('teammembers')->where('emailid',$accountantmail->emailid)
                        ->pluck('emailid')->first();
                $data = array(
                    'subject' => "Kgs Invoice Approved",
                    'email' =>   $accountantemail,
                    'invoice_id' =>   $request->companycode.'/'.$request->financialyear.'/'.$request->invoice_id,
					 'id' =>   $id,
                    'client_name' =>   $client_name,
               );
                 
                Mail::send('emails.invoiceapprovedmail', $data, function ($msg) use($data){
                    $msg->to($data['email']);
                    $msg->subject($data['subject']);
                 }); 
                     }
							   $clientname = $client_name;
                    $invoiceid = $id;

                    $invoiceadded = 'Invoice Approved for '.''. $request->companycode.'/'.$request->financialyear.'/'.$request->invoice_id;
                     $this->activityLog($request, $invoiceid,  $clientname, $invoiceadded);
                    }
                     if($request->status == 1){
                        $accountantemail = DB::table('teammembers')->where('id',$createdby)
                        ->pluck('emailid')->first();
                        //dd($certificateemail);
                      //  $juryname  = Jury::where('email',$jury)->pluck('name')->first();
                      
                        $data = array(
                            'subject' => "Kgs Invoice Reject",
                            'email' =>   $accountantemail,
                            'remark' =>   $request->remark,
                       );
                         
                        Mail::send('emails.invoicerejectmail', $data, function ($msg) use($data){
                            $msg->to($data['email']);
                            $msg->subject($data['subject']);
                         }); 
						      $clientname = DB::table('clients')->where('id',$request->client_id)->pluck('client_name')->first();
                         $invoiceid = $id;
                         $invoiceadded = 'Invoice Reject';
                          $this->activityLog($request, $invoiceid,  $clientname, $invoiceadded);
                             }
		    if($request->status == 5){
                               // dd($request);
                               $this->invoicecancel($request, $id);
                                    }
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

    public function show()
    {
        return view('backEnd.invoice.view');
    }


 public function store(Request $request)
    { 
         $request->validate([
             'client_id' => "required",
		 	 'appointmentletter' => "required"
         ]);

        try {
            $assignments = DB::table('assignmentmappings')->where('assignmentgenerate_id',$request->assignment_id)->first();
         //  dd($request->assignmentgenerate_id);
            $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
            $data['updatedby'] = auth()->user()->teammember_id;
            $data['status'] = 0;
            $data['assignment_id'] = $assignments->assignment_id;
            $data['assignmentgenerate_id'] = $request->assignment_id;
            $data['approvel'] = 0;
		
            if(auth()->user()->role_id == 13)
            {
            $data['partner'] = auth()->user()->teammember_id;
            $data['status'] = 4;
            }
            elseif(auth()->user()->role_id == 14)
            {
            $data['partner'] = $request->partner;
            $data['status'] = 3;
            }
            else {
                $data['partner'] = $request->partner;
            }
			 if($request->hasFile('finalreport'))
            {
                $file=$request->file('finalreport');
                  //  $destinationPath = 'backEnd/image/invoice';
                    $name = $file->getClientOriginalName();
				   $path = $file->storeAs('invoice',$name,'s3');
                  // $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['finalreport'] = $name;
               
            }
            if($request->hasFile('appointmentletter'))
            {
                $file=$request->file('appointmentletter');
                //    $destinationPath = 'backEnd/image/invoice';
                    $name = $file->getClientOriginalName();
				  $path = $file->storeAs('invoice',$name,'s3');
                 //  $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['appointmentletter'] = $name;
               
            }
		   if($request->hasFile('annexure'))
            {
                $file=$request->file('annexure');
                //    $destinationPath = 'backEnd/image/invoice';
                    $name = $file->getClientOriginalName();
				  $path = $file->storeAs('invoice',$name,'s3');
                 //  $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['annexure'] = $name;
               
            }
			if($request->hasFile('pocketexpensefile'))
            {
                $file=$request->file('pocketexpensefile');
                //    $destinationPath = 'backEnd/image/invoice';
                    $name = $file->getClientOriginalName();
				  $path = $file->storeAs('invoice',$name,'s3');
                 //  $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['pocketexpensefile'] = $name;
               
            }
            $invoiceidd = Invoice::Create($data);
			
					//  if($invoiceidd!=null)
      //       {
      //            $AEid=DB::table('assignmentevaluations')
      //           ->where('assignmentgenerate_id',$request->assignment_id)->latest()->first();
				
      //           if($AEid->status==3)
      //           {
      //             $AE=DB::table('assignmentevaluations')
      //           ->where('assignmentgenerate_id',$request->assignment_id)->update([
      //               'status'=>4,
      //           ]);
                
      //           }
			// 	 else
			// 	 {
			// 	 }

      //       }
           
            $invoiceidd->save();
            $invoiceid = $invoiceidd->id;
			
				if($request->appointmentletter != null){
            DB::table('appointmentletters')->insert([
                'client_id'   	=>     $request->client_id,
                'teammember_id'   	=>     $request->partner,
                'assignment_id'   	=>     $assignments->assignment_id,
               'attachment'=>  $request->appointmentletter,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
        }
			
            $clientname   = DB::table('clients')->where('id',$request->client_id)->pluck('client_name')->first();
            $invoiceadded = 'New Invoice Request';
            $this->activityLog($request, $invoiceid,  $clientname, $invoiceadded);

			
            if(auth()->user()->role_id == 14)
            {
            $partner = DB::table('teammembers')->where('id',$request->partner)->first();
            $clientname   = DB::table('clients')->where('id',$request->client_id)->pluck('client_name')->first();
            $data = array(
                'subject' => "Kgs Inovice Request Approvel",
                'clientname' =>   $clientname,
                'email' =>   $partner->emailid,
                'invoiceid' =>  $invoiceid,
           );
           Mail::send('emails.invoiceapprovelmail', $data, function ($msg) use($data){
            $msg->to($data['email']);
            $msg->subject($data['subject']);
         }); 
            }
            if(auth()->user()->role_id == 13 || auth()->user()->role_id == 11 )
            {

            $accountant = DB::table('teammembers')->where('role_id',17)->select('emailid')->get();
            foreach ($accountant as $accountantmail ) {
                $clientname   = DB::table('clients')->where('id',$request->client_id)->pluck('client_name')->first();
                $accountantemail = DB::table('teammembers')->where('emailid',$accountantmail->emailid)
                ->pluck('emailid')->first();
                //dd($certificateemail);
              //  $juryname  = Jury::where('email',$jury)->pluck('name')->first();
              
                $data = array(
                    'subject' => "Kgs Inovice Request",
                    'clientname' =>   $clientname,
                    'email' =>   $accountantemail,
                    'invoiceid' =>  $invoiceid,
               );
                 
                Mail::send('emails.invoicemail', $data, function ($msg) use($data){
                    $msg->to($data['email']);
                    $msg->subject($data['subject']);
                 }); 
                }
            }

          $assignmentteammappingss =  DB::table('assignmentmappings')
            ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
            ->leftjoin('teammembers','teammembers.id','assignmentteammappings.teammember_id')
            ->where('assignmentmappings.assignmentgenerate_id',$request->assignment_id)
            ->select('teammembers.team_member','teammembers.emailid')->get();

            //   foreach ($assignmentteammappingss as $assignmentteammappingssteam) {

          //      $clients =   DB::table('clients')->where('id',$request->client_id)->first();
          //      $assignmentss =   DB::table('assignments')->where('id',$assignments->assignment_id)->first();
          //       $data = array(
          //           'subject' => "Assignment evaluation"." - " .$clients->client_name,
          //           'clientname' =>   $clients->client_name,
          //           'email' =>   $assignmentteammappingssteam->emailid,
          //           'assignmentss' =>   $assignmentss->assignment_name,
					// 'AEid'          =>$AEid->id,
          //      );
                 
          //       Mail::send('emails.assignmentevaluationforminvoice', $data, function ($msg) use($data){
          //           $msg->to($data['email']);
          //           $msg->subject($data['subject']);
          //        }); 

          //   }


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
	 public function activityLog($request, $invoiceid, $clientname,$invoiceadded){
        $actionName = class_basename($request->route()->getActionname());
                $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                  DB::table('trail')->insert([
                        'createdby' => auth()->user()->teammember_id, 
                        'ip_address' => $request->ip(), 
                        'pagetitle' => $pagename, 
                        'pageid' => $invoiceid, 
                        'type' => 'Invoice', 
                        'description' => $invoiceadded.' '.'( '.  $clientname. ' )', 
                        'created_at' => date('y-m-d H:i:s'),       
                        'updated_at' => date('y-m-d')       
                    ]);
      }
	 public function invoiceUpdate(Request $request, $id)
{
    if($request->status == 5){
     //   dd($request);
       $this->invoicecancel($request, $id);
       $clientname = DB::table('clients')->where('id',$request->client_id)->pluck('client_name')->first();
       $invoiceid = $id;
       $invoiceadded = 'Invoice Cancel After Approved';
        $this->activityLog($request, $invoiceid,  $clientname, $invoiceadded);
        $output = array('msg' => 'Updated Successfully');
        return back()->with('success', $output);
            }
            else
            {
                $this->invoiceupdateafterapproved($request, $id);
                $clientname = DB::table('clients')->where('id',$request->client_id)->pluck('client_name')->first();
                $invoiceid = $id;
                $invoiceadded = 'Invoice Edit After Approved';
                 $this->activityLog($request, $invoiceid,  $clientname, $invoiceadded);
                 $output = array('msg' => 'Updated Successfully');
                 return back()->with('success', $output);
            }
  
}
      public function invoiceupdateafterapproved($request, $id){
        $data=$request->except(['_token','invoice_id','client_id','invoicedate','status','companycode']);
        Invoice::find($id)->update($data);
        DB::table('outstandings')->where('BILL_NO',$request->invoice_id)->update([	
            'AMT'         =>     $request->total,
            'Partner'         =>     $request->partner,   
            'updated_at' => date('y-m-d')   
             ]);
      }
	   public function invoicecancel($request, $id){
     // dd($request);
        DB::table('invoices')->where('id',$id)->update([	
            'status'         =>     $request->status,
            'notes'         =>     $request->notes,   
            'pocketexpenseamount'         =>     0,   
            'nogst'         =>     1,   
            'sgst'         =>     0,   
            'cgst'         =>     0,   
            'igst'         =>     0,   
            'amount'         =>     0,   
            'total'         =>     0,   
            'updated_at' => date('y-m-d')   
             ]);
        DB::table('outstandings')->where('BILL_NO',$request->invoice_id)->update([	
            'AMT'         =>     0,
            'Partner'         =>     $request->partner,   
            'updated_at' => date('y-m-d')   
             ]);
      }
	        public function invoiceAssignment(Request $request)
    {
       
        if ($request->ajax()) {

            if (isset($request->category_id)) {
                if(auth()->user()->role_id == 13)
                {
                    echo "<option>Please Select One</option>";
                    foreach ( DB::table('assignmentmappings')
                    ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
                    ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
                    ->where('assignmentmappings.leadpartner',auth()->user()->teammember_id)
                    ->where('assignmentbudgetings.client_id',$request->category_id)->
                    select('assignments.*','assignmentbudgetings.assignmentgenerate_id','assignmentbudgetings.duedate')
                    ->get() as $sub) {
                 
                        echo "<option value='" . $sub->id . "'>" . $sub->assignment_name .'('. date('F d,Y', strtotime($sub->duedate)).')'. "</option>";
                    }
                }
                elseif(auth()->user()->role_id == 14)
                {
                echo "<option>Please Select One</option>";
                foreach (DB::table('assignmentteammappings')
                ->leftjoin('assignmentmappings','assignmentmappings.id','assignmentteammappings.assignmentmapping_id')
                ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
                ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
                ->where('assignmentteammappings.teammember_id',auth()->user()->teammember_id)->
                where('assignmentbudgetings.client_id',$request->category_id)->
                select('assignments.*','assignmentbudgetings.assignmentgenerate_id','assignmentbudgetings.duedate')
                ->get() as $sub) {

                    echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name .'('. date('F d,Y', strtotime($sub->duedate)).')'.'('. $sub->assignmentgenerate_id .')'. "</option>";
                }
            }
				   elseif(auth()->user()->role_id == 11)
            {
            echo "<option>Please Select One</option>";
            foreach (DB::table('assignmentbudgetings')
            ->leftjoin('assignmentmappings','assignmentmappings.assignmentgenerate_id','assignmentbudgetings.assignmentgenerate_id')
            ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
            ->where('assignmentbudgetings.client_id',$request->category_id)->
            select('assignments.*','assignmentbudgetings.assignmentgenerate_id','assignmentbudgetings.duedate')
            ->get() as $sub) {

                echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name .'('. date('F d,Y', strtotime($sub->duedate)).')'.'('. $sub->assignmentgenerate_id .')'. "</option>";
            }
        }
            }
        }
         
      
    }
	public function invoiceassignmentreport()
    {
        $invoiceData =  DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
			  ->join('assignments','assignments.id','invoices.assignment_id')
		//	->where('invoices.assignment_id',44)
       ->select('invoices.*','clients.client_name','teammembers.team_member','assignments.assignment_name')->orderBy('id', 'desc')->get();
    // dd($invoiceData);
        return view('backEnd.invoice.invoicefinalreport', compact('invoiceData'));
    }
	public function echartt()
    {

      if(auth()->user()->role_id==11)
        {
        $invoiceData =  DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
			  ->join('assignments','assignments.id','invoices.assignment_id')
			//->where('invoices.partner',auth()->user()->teammember_id)
       ->select('invoices.*','clients.client_name','teammembers.team_member','assignments.assignment_name')->orderBy('id', 'desc')->get();
      
		  $partner = DB::table('invoices')
       ->leftjoin('teammembers','teammembers.id','invoices.partner')
    //   ->where('Partner',auth()->user()->teammember_id)
           ->select('teammembers.team_member','teammembers.id')->
           distinct('teammembers.team_member')->get();
	  }
        else{
            $invoiceData =  DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
			  ->join('assignments','assignments.id','invoices.assignment_id')
			->where('invoices.partner',auth()->user()->teammember_id)
       ->select('invoices.*','clients.client_name','teammembers.team_member','assignments.assignment_name')->orderBy('id', 'desc')->get();
       
  $partner = DB::table('invoices')
       ->leftjoin('teammembers','teammembers.id','invoices.partner')
    //   ->where('Partner',auth()->user()->teammember_id)
           ->select('teammembers.team_member','teammembers.id')->
           distinct('teammembers.team_member')->get();
        }
   // dd($outstandingDatas);
   $upto3=0;
   $inweek=0;
   $in2week=0;
   $over2week=0;
		
		if(count($invoiceData)==0)
   {
    $label = null;
    $amounts =null;

   }
   
   else
   {
    foreach($invoiceData as $invoiceDatas)
    {
        $current=$invoiceDatas->invoicedate;    
        $formatted_dt1=Carbon\Carbon::parse($current);
							  $ifdate=$formatted_dt1->diffInDays($invoiceDatas->finalreportdate);
							
							                    //dd($ifdate);
       // echo"<pre>";
      //   print_r($pendingdays);

      
      if($invoiceDatas->finalreportdate != null)
      {
        if(date('Y', strtotime($invoiceDatas->invoicedate)) > date('Y', strtotime($invoiceDatas->finalreportdate)))
        $ifdate=$ifdate;
        elseif(date('Y', strtotime($invoiceDatas->invoicedate)) < date('Y', strtotime($invoiceDatas->finalreportdate)))
         $ifdate="-".$ifdate;
        elseif(date('m/d/Y', strtotime($invoiceDatas->invoicedate)) > date('m/d/Y', strtotime($invoiceDatas->finalreportdate)))
        $ifdate=$ifdate;
        else
        $ifdate="-".$ifdate;

                     

      if($ifdate >0 && $ifdate< 4)
      {
        $upto3=$upto3+1;
      }
      elseif($ifdate > 3 && $ifdate < 8)
      {
        $inweek=$inweek+1;
      }
      elseif($ifdate > 7 && $ifdate < 15)
      {
        $in2week=$in2week+1;
      }

      elseif($ifdate > 14 )
      {
        $over2week=$over2week+1;
      }


    
    }
    /*echo "<pre>";
    print_r($upto3);
    echo "<pre>";
    print_r($inweek);
    echo "<pre>";
    print_r($in2week);

    echo "<pre>";
    print_r($upto3);
    echo "<pre>";
    print_r($ifdate);
    echo "<pre>";
    echo"end";*/

    }
   }
  // die;

    $label = ['upto 3 days', 'in a week ', 'in 2 weeks', 'over 2 weeks'];
       
    $amounts = [$upto3, $inweek, $in2week, $over2week];

    $dupto3=0;
   $dinweek=0;
   $din2week=0;
   $dover2week=0;
		
		if(count($invoiceData)==0)
   {
    $label2 = null;
    $amounts2=null;

   }
   
		else
		{
   
    foreach($invoiceData as $invoiceDatas)
    {
        $duedateofrecovery=$invoiceDatas->duedateofrecovery;    
        $formatted_dt1=Carbon\Carbon::parse($duedateofrecovery);
		$duedateofrecoveryinvoice=$formatted_dt1->diffInDays($invoiceDatas->invoicedate);
        if($invoiceDatas->duedateofrecovery != null)
        {
           
        if($duedateofrecoveryinvoice >0 && $duedateofrecoveryinvoice< 4)
        {
          $dupto3=$dupto3+1;
        }
        elseif($duedateofrecoveryinvoice > 3 && $duedateofrecoveryinvoice < 8)
        {
          $dinweek=$dinweek+1;
        }
        elseif($duedateofrecoveryinvoice > 7 && $duedateofrecoveryinvoice < 15)
        {
          $din2week=$din2week+1;
        }
  
        elseif($duedateofrecoveryinvoice > 14 )
        {
          $dover2week=$dover2week+1;
        }
        $label2 = ['upto 3 days', 'in a week ', 'in 2 weeks', 'over 2 weeks'];
       
        $amounts2 = [$dupto3, $dinweek, $din2week, $dover2week];
        }
    
                            
    }
		}
    //dd($amounts2);

       return view('backEnd.invoice.barchart',['labels' => $label, 'amounts' => $amounts,'labels2' => $label2,'amounts2' => $amounts2,'partner' => $partner]);
    }
	 public function bar_chart(Request $request)
    {

     
            $invoiceData =  DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->leftjoin('teammembers','teammembers.id','invoices.partner')
			  ->join('assignments','assignments.id','invoices.assignment_id')
			->where('invoices.partner',$request->partners)
       ->select('invoices.*','clients.client_name','teammembers.team_member','assignments.assignment_name')->orderBy('id', 'desc')->get();
       
       $partner = DB::table('invoices')
       ->leftjoin('teammembers','teammembers.id','invoices.partner')
    //   ->where('Partner',auth()->user()->teammember_id)
           ->select('teammembers.team_member','teammembers.id')->
           distinct('teammembers.team_member')->get();

        
   // dd($outstandingDatas);
   $upto3=0;
   $inweek=0;
   $in2week=0;
   $over2week=0;
   
    foreach($invoiceData as $invoiceDatas)
    {
        $current=$invoiceDatas->invoicedate;    
        $formatted_dt1=Carbon\Carbon::parse($current);
							  $ifdate=$formatted_dt1->diffInDays($invoiceDatas->finalreportdate);
							
							                    //dd($ifdate);
       // echo"<pre>";
      //   print_r($pendingdays);

      
      if($invoiceDatas->finalreportdate != null)
      {
        if(date('Y', strtotime($invoiceDatas->invoicedate)) > date('Y', strtotime($invoiceDatas->finalreportdate)))
        $ifdate=$ifdate;
        elseif(date('Y', strtotime($invoiceDatas->invoicedate)) < date('Y', strtotime($invoiceDatas->finalreportdate)))
         $ifdate="-".$ifdate;
        elseif(date('m/d/Y', strtotime($invoiceDatas->invoicedate)) > date('m/d/Y', strtotime($invoiceDatas->finalreportdate)))
        $ifdate=$ifdate;
        else
        $ifdate="-".$ifdate;

                     

      if($ifdate >0 && $ifdate< 4)
      {
        $upto3=$upto3+1;
      }
      elseif($ifdate > 3 && $ifdate < 8)
      {
        $inweek=$inweek+1;
      }
      elseif($ifdate > 7 && $ifdate < 15)
      {
        $in2week=$in2week+1;
      }

      elseif($ifdate > 14 )
      {
        $over2week=$over2week+1;
      }


    
    }
    /*echo "<pre>";
    print_r($upto3);
    echo "<pre>";
    print_r($inweek);
    echo "<pre>";
    print_r($in2week);

    echo "<pre>";
    print_r($upto3);
    echo "<pre>";
    print_r($ifdate);
    echo "<pre>";
    echo"end";*/

    }
  // die;

    $label = ['upto 3 days', 'in a week ', 'in 2 weeks', 'over 2 weeks'];
       
    $amounts = [$upto3, $inweek, $in2week, $over2week];

    $dupto3=0;
   $dinweek=0;
   $din2week=0;
   $dover2week=0;
   
    foreach($invoiceData as $invoiceDatas)
    {
		//dd('hi');
        $duedateofrecovery=$invoiceDatas->duedateofrecovery;    
        $formatted_dt1=Carbon\Carbon::parse($duedateofrecovery);
		$duedateofrecoveryinvoice=$formatted_dt1->diffInDays($invoiceDatas->invoicedate);
		//dd($invoiceDatas->duedateofrecovery);
		if($invoiceDatas->duedateofrecovery==null)
		{
			$label2=null;
			$amounts2=null;
		}
		else
		{
        if($invoiceDatas->duedateofrecovery != null)
        {
           
        if($duedateofrecoveryinvoice >0 && $duedateofrecoveryinvoice< 4)
        {
          $dupto3=$dupto3+1;
        }
        elseif($duedateofrecoveryinvoice > 3 && $duedateofrecoveryinvoice < 8)
        {
          $dinweek=$dinweek+1;
        }
        elseif($duedateofrecoveryinvoice > 7 && $duedateofrecoveryinvoice < 15)
        {
          $din2week=$din2week+1;
        }
  
        elseif($duedateofrecoveryinvoice > 14 )
        {
          $dover2week=$dover2week+1;
        }
		//	dd('hi');
        $label2 = ['upto 3 days', 'in a week ', 'in 2 weeks', 'over 2 weeks'];
       
        $amounts2 = [$dupto3, $dinweek, $din2week, $dover2week];
        }
    
                            
    }
	}
    //dd($amounts2);

       return view('backEnd.invoice.barchart',['labels' => $label, 'amounts' => $amounts,'labels2' => $label2,'amounts2' => $amounts2,'partner' => $partner]);
    }
}
