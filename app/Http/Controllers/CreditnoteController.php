<?php

namespace App\Http\Controllers;

use App\Models\Creditnote;
use App\Models\Invoice;
use App\Models\Statecode;
use App\Models\Payment;
use App\Models\Companydetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class CreditnoteController extends Controller
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
        $creditnoteDatas = DB::table('creditnotes')
        ->leftjoin('clients','clients.id','creditnotes.client_id')
       ->select('creditnotes.*','clients.client_name')->orderBy('id', 'desc')->get();
        return view('backEnd.creditnote.index',compact('creditnoteDatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  create(Request $request)
    {
		 $statecode = Statecode::orderBy('statecode', 'asc')->get();  
      
        $client = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')->
        select('clients.id','clients.client_name')
        ->distinct('client_name')->get();
      //  dd($client);
        $company = Companydetail::latest()->get();
        if ($request->ajax()) {
            if (isset($request->category_id)) {
                echo "<option>Please Select One</option>";
                foreach (Invoice::where('client_id', $request->category_id)->get() as $sub) {

                    echo "<option value='" . $sub->invoice_id . "'>" . $sub->invoice_id . "</option>";
                }
            }
        } 
        else{
            return view('backEnd.creditnote.create',compact('client','company','statecode'));
        } 
       
        
    } 
    public function invoiceList(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->category_id)) {
              $client = Invoice::where('invoice_id',$request->category_id)->first();
              $amountcheck = Payment::where('invoiceid',$request->category_id)->sum('amountreceived');
              $amounttds= DB::table('payments')->where('invoiceid',$request->category_id)->sum('tds');
              $roundoff= DB::table('payments')->where('invoiceid',$request->category_id)->sum('roundoff');
            $tdscgst= DB::table('payments')->where('invoiceid',$request->category_id)->sum('tdscgst');
              $tdsigst= DB::table('payments')->where('invoiceid',$request->category_id)->sum('tdsigst');
              $tdssgst= DB::table('payments')->where('invoiceid',$request->category_id)->sum('tdssgst');
                $totalamountcheck =   $amountcheck +  $amounttds + $roundoff + $tdscgst + $tdsigst + $tdssgst;
   // dd($totalamountcheck);
                return response()->json([
                    'client' => $client,
                    'totalamountcheck' => $totalamountcheck,
                ]);
             }
            }
    
    }
    public function companyList(Request $request)
{
   if ($request->ajax()) {
        if (isset($request->category_id)) {
           // dd($request->category_id);
          $client =DB::table('creditnumbers')
         
        ->where('companydetails_id',$request->category_id)->orderBy('id', 'DESC')->first();
          //dd($client);
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
             'client_id' => "required",
           'clientaddress' => "required"
       ]);

         try {
             $data=$request->except(['_token','companycode','creditno']);
             $data['createdby'] = auth()->user()->teammember_id;
             $data['credit_note_number'] = $request->companycode.'/23-24/'.$request->creditno;
             Creditnote::Create($data);
             DB::table('creditnumbers')->insert([
                'companydetails_id'         =>     $request->companydetails_id,
                'creditno'         =>     $request->creditno + 1,
                'created_at' => date('y-m-d'),       
                'updated_at' => date('y-m-d')   
                 ]);
                 if($request->invoice_id != null){
                    DB::table('outstandings')->where([

                        'BILL_NO'   =>   $request->invoice_id,       
        
                        ])->delete();
                         DB::table('invoices')->where('invoice_id',$request->invoice_id)->update([	
                               'status'         =>     6,
                           ]);
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
     * @param  \App\Models\Creditnote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $creditnote =  DB::table('creditnotes')
        ->leftjoin('clients','clients.id','creditnotes.client_id')
        ->select('creditnotes.*','clients.client_name')->where('creditnotes.id', $id)->first();
        // dd($fullandfinal);
         return view('backEnd.creditnote.view', compact('id','creditnote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Creditnote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $statecode = Statecode::latest()->get(); 
          $client =  DB::table('invoices')
          ->leftjoin('clients','clients.id','invoices.client_id')->
          select('clients.id','clients.client_name')
          ->distinct('client_name')->get();
          $company = Companydetail::latest()->get();  
          $creditnote =  DB::table('creditnotes')->where('id', $id)->first();
          return view('backEnd.creditnote.edit', compact('statecode','id','client','company','creditnote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Creditnote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Creditnote $creditnote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Creditnote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Creditnote $creditnote)
    {
        //
    }
}
