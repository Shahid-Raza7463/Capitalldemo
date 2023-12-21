<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use DB;
class BalanceController extends Controller
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
       
	//	$team = DB::table('teammembers_3_1')->get();
//		foreach ($team as $teams) {

  //DB::table('teammembers')->where('emailid',$teams->emailid)->update([	
 //   'category'         =>     $teams->category,
  //  'cost_hour'         =>     $teams->hour,
  //    ]);
//}
		
		
        if(auth()->user()->teammember_id == 157){
            $company  = DB::table('companydetails')->select('id','company_name')->get();
          $balanceDatas  = DB::table('balances')
          ->leftjoin('companydetails','companydetails.id','balances.companydetails_id')
          ->leftjoin('teammembers','teammembers.id','balances.createdby')
         ->select('balances.*','teammembers.team_member as Name','companydetails.company_name')->orderBy('id', 'desc')->get();
  // dd($balanceDatas);
         return view('backEnd.balance.index',compact('balanceDatas','company'));
      }
        elseif(auth()->user()->role_id == 17 || auth()->user()->role_id == 11 ){
            $company  = DB::table('companydetails')->select('id','company_name')->get();
          $balanceDatas  = DB::table('balances')
          ->leftjoin('companydetails','companydetails.id','balances.companydetails_id')
          ->leftjoin('teammembers','teammembers.id','balances.createdby')
         ->select('balances.*','teammembers.team_member as Name','companydetails.company_name')->orderBy('id', 'desc')->get();
  // dd($balanceDatas);
         return view('backEnd.balance.index',compact('balanceDatas','company'));
      }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // $request->validate([
        //     'assignment_name' => "required"
        // ]);

        try {
            $data=$request->except(['_token']);
            $data['createdby']=auth()->user()->teammember_id;
            $data = Balance::Create($data);
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
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function show(Balance $balance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function edit(Balance $balance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Balance $balance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Balance $balance)
    {
        //
    }
}
