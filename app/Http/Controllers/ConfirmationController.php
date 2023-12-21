<?php

namespace App\Http\Controllers;

use App\Models\Debtor;
use App\Models\Teammember;
use App\Models\Client;
use App\Models\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
class ConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexview($id)
    {
        $teammember = Teammember::where('role_id','=',15)->orwhere('role_id','=',14)->orwhere('role_id','=',13)->with('title','role')->get();
        $clientList =  Client::where('id', $id)->first();
        $clientdebit =  Debtor::where('client_id', $id)->where('type',1)->get();
       // dd($clientdebit);
        $clientcredit  =  Debtor::with('debtorconfirm')->where('client_id', $id)->where('type',2)->get();
        $clientbank =  Debtor::where('client_id', $id)->where('type',3)->get();
        $debtortemplate =  Template::where('type', '1')->first();
       
        return view('backEnd.confirmation.index',compact('debtortemplate','clientList','clientdebit','teammember','clientcredit','clientbank','id'));
    }
  public function view($id)
    {
       $debtorconfirmation = DB::table('debtorconfirmations')->where('debtor_id',$id)->get();
        return view('backEnd.confirmation.view',compact('debtorconfirmation'));
    }
   public function template(Request $request){
    if ($request->ajax()) {
        if (isset($request->template_id)) {
            $client = DB::table('templates')->where('type',$request->template_id)->first();

              return response()->json($client);
           }      
        
    }
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mail(Request $request )
    {
        
    //    if($request->description){
    //     $print =DB::table('templates')->where('description', 'LIKE', '%' . '$name' . '%' )->first();
    //     dd('hi');
    //    }
    //    dd($request);
        // $request->validate([
        //     'file' => 'required'
        // ]);
      
        try {
            $data = $request->except(['_token']);
          
               $debtor = DB::table('debtors')->where('client_id',$request->clientid)->where('type',$request->type)->where('mailstatus',0)->get();
			  //  dd($debtor);
                    foreach ($debtor as $debtors ) {
						if($request->teammember_id){
                        $teammembermail = Teammember::wherein('id',$request->teammember_id)->pluck('emailid')->toArray();
						}
                       // $description = str_replace('$name', $debtors->name, $request->description); 
                      //  $description = str_replace('44247', $debtors->amount, $request->description);
                      $des = $request->description; 
                        $healthy = ["[name]", "[amount]","[year]","[date]","[address]"];
                        $yummy   = ["$debtors->name", "$debtors->amount","$debtors->year","$debtors->date","$debtors->address"];
                        $description = str_replace($healthy, $yummy, $des);
                         //dd($description);
                        $data = array(
                            'subject' => $request->subject,
                     //       'fromemail' =>  $request->fromemail,
                            'name' =>  $debtors->name,
                            'email' =>  $debtors->email,
                            'year' =>  $debtors->year,
                            'date' =>  $debtors->date,
                            'amount' =>  $debtors->amount,
                            'clientid' => $debtors->client_id,
                            'debtorid' => $debtors->id,
                            'description' => $description,
							   'teammembermail' => $teammembermail ??'',
                            'yes' => 1,
                            'no' => 0
                       );
                         
                       Mail::send('emails.debtorform', $data, function ($msg) use($data, $request ){
                            $msg->to($data['email']);
                         //  $msg->from('arihant@kgsomani.com', 'Kgskonnect');
                           // $msg->cc($teammembermail);
                            $msg->subject($data['subject']);
						   
						   	if($request->teammember_id) {
        $msg->cc($data['teammembermail']);
    }
                         }); 
						  DB::table('debtors')
                         ->where('client_id',$debtors->client_id)->
                         where('id',$debtors->id)->update([ 
                             'mailstatus'         => 1,
                             'updated_at'         =>   date("Y-m-d H:i:s")
                             ]);
                        }
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = Template::where('id',$id)->first();
        return view('backEnd.template.edit', compact('id', 'template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => "required|string",
            'description' => "required",
        ]);
        try {
            $data=$request->except(['_token']);
            Template::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('template')->with('success', $output);
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
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
    }
}
