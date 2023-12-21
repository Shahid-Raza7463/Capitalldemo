<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Client;
use App\Models\ContractandSubscription;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ContractandSubscriptionController extends Controller
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
		  if(auth()->user()->teammember_id == 156 ){ 
          $contractDatas  = DB::table('contractand_subscriptions')
          ->leftjoin('kgsentitys','kgsentitys.id','contractand_subscriptions.kgsentity')
          ->leftjoin('teammembers','teammembers.id','contractand_subscriptions.teammember_id')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('contractand_subscriptions.*','teammembers.team_member','roles.rolename','kgsentitys.name')->get();
        }
        elseif(auth()->user()->role_id == 16 || auth()->user()->role_id == 11 ){ 
          $contractDatas  = DB::table('contractand_subscriptions')
          ->leftjoin('kgsentitys','kgsentitys.id','contractand_subscriptions.kgsentity')
          ->leftjoin('teammembers','teammembers.id','contractand_subscriptions.teammember_id')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('contractand_subscriptions.*','teammembers.team_member','roles.rolename','kgsentitys.name')->get();
        }
        else {
            $contractDatas  = DB::table('contractand_subscriptions')
            ->leftjoin('kgsentitys','kgsentitys.id','contractand_subscriptions.kgsentity')
            ->leftjoin('teammembers','teammembers.id','contractand_subscriptions.teammember_id')
            ->leftjoin('roles','roles.id','teammembers.role_id')
            ->where('createdby',auth()->user()->teammember_id)
			 ->orwhere('teammember_id',auth()->user()->teammember_id)
           ->select('contractand_subscriptions.*','teammembers.team_member','roles.rolename','kgsentitys.name')->get();
        }
         return view('backEnd.ContractandSubscription.index',compact('contractDatas'));
  
     
  }
  public function view($id)
  {

       $contractDatas = ContractandSubscription::where('id', $id)->first();

       return view('backEnd.ContractandSubscription.view', compact('id','contractDatas'));
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::where('role_id',13)->with('title','role')->get();
            $kgsentity = DB::table('kgsentitys')->select('id','name')->get();
        return view('backEnd.ContractandSubscription.create',compact('teammember','kgsentity'));

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
             'companyname' => "required",
             'contactemailid' => "required",
       ]);

         try {
             $data=$request->except(['_token']);
             $data['status'] = 0;
             $data['createdby'] = auth()->user()->teammember_id;
            $ContractandSubscription =  ContractandSubscription::Create($data);
             $ContractandSubscription->save();
             $ContractandSubscriptionid = $ContractandSubscription->id;
   
             
             $teammembers = DB::table('teammembers')->where('id',$request->teammember_id)->first();
              $data = array(
                 'subject' => "New Subscription Request",
                 'kgsentity' =>   $request->kgsentity,
                 'email' =>   $teammembers->emailid,
                 'ContractandSubscriptionid' =>  $ContractandSubscriptionid,
            );
      //      Mail::send('emails.contractandsubscription', $data, function ($msg) use($data){
        //     $msg->to($data['email']);
         //    $msg->subject($data['subject']);
         // });
          
             $output = array('msg' => 'Create Successfully');
             return redirect('contract')->with('success', $output);
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
        $contractDatas = ContractandSubscription::where('id', $id)->first();
        $teammember = Teammember::select('id','team_member')->get();
        $kgsentity = DB::table('kgsentitys')->select('id','name')->get();
        // dd($fullandfinal);
         return view('backEnd.ContractandSubscription.edit', compact('id','contractDatas','teammember','kgsentity'));
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'Name' => "required",
        // ]);
        try {
             $data=$request->except(['_token']);

       $data['updatedby'] = auth()->user()->teammember_id;
      
       ContractandSubscription::find($id)->update($data);
      
       $output = array('msg' => 'Updated Successfully');
            return redirect('contract')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    public function destroy($id)
     {
     
    }
}
