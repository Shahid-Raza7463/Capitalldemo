<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class PaymentController extends Controller
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
	 public function paymentSearch(Request $request)
    {
		// dd($request);
        // $ds = date('Y-m-d', strtotime(date('Y-m-d', strtotime($request->enddate . ' + 1 day' . ' + 1 day'))));
        // dd($ds );
        $paymentDatas  =  DB::table('payments')
        ->join('invoices','invoices.invoice_id','payments.invoiceid')
               ->leftjoin('clients','clients.id','invoices.client_id')
               ->where('payments.paymentdate', '>=',date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<',date('Y-m-d', strtotime($request->enddate . ' + 1 day')))
                ->select('payments.*','clients.client_name','invoices.total','invoices.invoicedate')->get();
             //   dd($paymentDatas);
             $amountcheck= DB::table('payments')->where('paymentdate', '>=',date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<',date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('amountreceived');
                $amounttds= DB::table('payments')->where('paymentdate', '>=',date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<',date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('tds');
                 $roundoff= DB::table('payments')->where('paymentdate', '>=',date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<',date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('roundoff');
                       $tdscgst= DB::table('payments')->where('paymentdate', '>=',date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<',date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('tdscgst'); 
                      $tdsigst= DB::table('payments')->where('paymentdate', '>=',date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<',date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('tdsigst');
                       $tdssgst= DB::table('payments')->where('paymentdate', '>=',date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<',date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('tdssgst');
                $totalreceived =$amountcheck +  $amounttds + $roundoff + $tdscgst + $tdsigst +
         $tdssgst;
                //$totalreceived = DB::table('payments')
        //     ->sum(\DB::raw('amountreceived + tds'));
                //dd($paymentDatas); die;
                return view('backEnd.payment.index', compact('paymentDatas','totalreceived'));
    }
	  public function paymentList($id)
    {
        $invoiceid=DB::table('payments')->where('id',$id)->pluck('invoiceid')->first();
        $paymentDatas  =  DB::table('payments')
->join('invoices','invoices.invoice_id','payments.invoiceid')
       ->leftjoin('clients','clients.id','invoices.client_id')
       ->where('payments.invoiceid',$invoiceid)
        ->select('payments.*','clients.client_name','invoices.total','invoices.invoicedate')->get();
     //   dd($payment);
		                $amountcheck= DB::table('payments')->where('invoiceid',$invoiceid)->sum('amountreceived');
                 $amounttds= DB::table('payments')->where('invoiceid',$invoiceid)->sum('tds');
		   $roundoff= DB::table('payments')->where('invoiceid',$invoiceid)->sum('roundoff');
		    $tdscgst= DB::table('payments')->where('invoiceid',$invoiceid)->sum('tdscgst');
		    $tdsigst= DB::table('payments')->where('invoiceid',$invoiceid)->sum('tdsigst');
		    $tdssgst= DB::table('payments')->where('invoiceid',$invoiceid)->sum('tdssgst');
		   $totalreceived =$amountcheck +  $amounttds + $roundoff + $tdscgst + $tdsigst +
 $tdssgst;
        return view('backEnd.payment.index', compact('paymentDatas','totalreceived'));
    }
    public function index()
    {
		  if(auth()->user()->role_id == 11 || auth()->user()->role_id == 17 || auth()->user()->teammember_id == 99 || auth()->user()->teammember_id == 161 || auth()->user()->teammember_id == 550){
        $paymentDatas  =  DB::table('payments')
->join('invoices','invoices.invoice_id','payments.invoiceid')
       ->leftjoin('clients','clients.id','invoices.client_id')
        ->select('payments.*','clients.client_name','invoices.total','invoices.invoicedate')->get();
     $amountcheck= DB::table('payments')->sum('amountreceived');
        $amounttds= DB::table('payments')->sum('tds');
		 $roundoff= DB::table('payments')->sum('roundoff');
			   $tdscgst= DB::table('payments')->sum('tdscgst'); 
			  $tdsigst= DB::table('payments')->sum('tdsigst');
			   $tdssgst= DB::table('payments')->sum('tdssgst');
        $totalreceived =$amountcheck +  $amounttds + $roundoff + $tdscgst + $tdsigst +
 $tdssgst;
		//$totalreceived = DB::table('payments')
//     ->sum(\DB::raw('amountreceived + tds'));
		//dd($paymentDatas); die;
        return view('backEnd.payment.index', compact('paymentDatas','totalreceived'));
			     }
        abort(403, ' you have no permission to access this page ');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentCreate($id)
    {
		 if(auth()->user()->role_id == 17){
        $invoice = Invoice::where('id',$id)->first();
        $paymentsid   = DB::table('payments')->where('invoiceid',$invoice->invoice_id)->pluck('id')->first();
       return view('backEnd.payment.create',compact('invoice','id','paymentsid'));
			   }
        abort(403, ' you have no permission to access this page ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 public function paymentsStore(Request $request,$id='')
    {
        try {
            $data=$request->except(['_token']);
            $invoice_id   = DB::table('invoices')->where('id',$id)->first();
           

            $paymentsid   = DB::table('payments')->where('invoiceid',$invoice_id->invoice_id)->pluck('id')->first();
        
            DB::table('payments')->insert([	
                'invoiceid'         =>    $invoice_id->invoice_id,
                'amountreceived'  => $request->amountreceived,
                'paymentmode'  => $request->paymentmode,
                'paymentdate'  => $request->paymentdate,
                'transaction_id'  => $request->transaction_id,
                'note'  => $request->note,
				 'tds'  => $request->tds,
				 'roundoff'  => $request->roundoff,
				 'tdscgst'  => $request->tdscgst,
				 'tdsigst'  => $request->tdsigst,
				 'tdssgst'  => $request->tdssgst,
                'createdby'  =>  auth()->user()->teammember_id,
                'updatedby'  =>  auth()->user()->teammember_id,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                 ]);
          
                 $amountcheck= DB::table('payments')->where('invoiceid',$invoice_id->invoice_id)->sum('amountreceived');
                 $amounttds= DB::table('payments')->where('invoiceid',$invoice_id->invoice_id)->sum('tds');
			   $roundoff= DB::table('payments')->where('invoiceid',$invoice_id->invoice_id)->sum('roundoff');
			 $tdscgst= DB::table('payments')->where('invoiceid',$invoice_id->invoice_id)->sum('tdscgst');
			   $tdsigst= DB::table('payments')->where('invoiceid',$invoice_id->invoice_id)->sum('tdsigst');
			   $tdssgst= DB::table('payments')->where('invoiceid',$invoice_id->invoice_id)->sum('tdssgst');
                 $totalamountcheck =   $amountcheck +  $amounttds + $roundoff + $tdscgst + $tdsigst + $tdssgst;
                 //   dd($amountcheck);  
                    if($totalamountcheck == null){
                                   $paymenttotal = $request->amountreceived + $request->tds + $request->roundoff + $request->tdscgst
                                   + $request->tdsigst + $request->tdssgst;          
              if($paymenttotal < $invoice_id->total)
                          {
                              DB::table('invoices')->where('id',$id)->update([	
                                  'paymentstatus'         =>     'Partially Received',  
                                   ]);
				     $leftamt =    $invoice_id->total -   $paymenttotal;
                              DB::table('outstandings')->where('BILL_NO',$invoice_id->invoice_id)->update([	
                                  'AMT'         =>    $leftamt,  
                                   ]);
                          }
                          elseif($paymenttotal == $invoice_id->total){
                              DB::table('invoices')->where('id',$id)->update([	
                                  'paymentstatus'         =>     'Received',  
                                   ]);  
							   DB::table('outstandings')->where('BILL_NO',$invoice_id->invoice_id)->delete();
                          }
						
                        //   elseif($request->amountreceived > $invoice_id->total) {
                        //       DB::table('invoices')->where('id',$id)->update([	
                        //           'paymentstatus'         =>     'Outstanding',  
                        //            ]);  
                        //   }
                      }
                      else {
                          if(  $totalamountcheck < $invoice_id->total){
                              DB::table('invoices')->where('id',$id)->update([	
                                  'paymentstatus'         =>     'Partially Received',  
                                   ]); 
							    $leftamt =    $invoice_id->total -   $totalamountcheck;
                                   DB::table('outstandings')->where('BILL_NO',$invoice_id->invoice_id)->update([	
                                       'AMT'         =>    $leftamt,  
                                        ]); 
                          }
                          else {
                              DB::table('invoices')->where('id',$id)->update([	
                                  'paymentstatus'         =>     'Received',  
                                   ]);  
							  DB::table('outstandings')->where('BILL_NO',$invoice_id->invoice_id)->delete(); 
                          }
                      }
        
        $output = array('msg' => 'payment insert done');
        return redirect('payment')->with('success', $output);
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
    public function edit($id)
    {
        $payments   = DB::table('payments')->where('id',$id)->first();
        $client   = DB::table('invoices')
        ->leftjoin('clients','clients.id','invoices.client_id')
        ->where('invoice_id',$payments->invoiceid)->first();

     //  dd($client->client_name);
    DB::table('outstandings')->insert([	
                'DATE'         =>    $payments->paymentdate,
          
                'BILL_NO'  =>  $payments->invoiceid,
                'CLIENT_NAME'  =>  $client->client_name,
                'AMT'  =>  $payments->amountreceived,
                'Partner'  =>  $client->partner,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                 ]);
                 DB::table('payments')->delete($id);
                 DB::table('invoices')->where('invoice_id',$payments->invoiceid)->update([	
                    'paymentstatus'         =>     null,  
                     ]);  
                     $output = array('msg' => 'payment update done');
                     return redirect('payment')->with('success', $output);
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
}
