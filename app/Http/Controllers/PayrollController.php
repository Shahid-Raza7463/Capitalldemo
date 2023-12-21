<?php

namespace App\Http\Controllers;
use App\imports\Payrollarticleimport;
use App\imports\Payrollimport;
use App\Models\Payroll;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
use Excel;
class PayrollController extends Controller
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
	 public function payroll(Request $request )
    {
     //   dd($request);
    if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
        $payrollData = DB::table('payrolls')
        ->leftjoin('teammembers','teammembers.id','payrolls.name_of_employee')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('payrolls.month',$request->month)
        ->select('payrolls.*','teammembers.team_member','teammembers.verify','roles.rolename')->get();
//dd($payrollData);
        return view('backEnd.payroll.index',compact('payrollData'));
    }
    abort(403, ' you have no permission to access this page ');
    }
	public function payrollarticless(Request $request )
    {
     //   dd($request);
    if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
      
        $payrollData = DB::table('articlepayrolls')
        ->leftjoin('teammembers','teammembers.id','articlepayrolls.emailid')
			 ->leftjoin('roles','roles.id','teammembers.role_id')
             ->where('articlepayrolls.month',$request->month)
        ->select('articlepayrolls.*','teammembers.team_member','teammembers.verify','roles.rolename')->get();

        return view('backEnd.payroll.payrollarticleindex',compact('payrollData'));
    }
    abort(403, ' you have no permission to access this page ');
    }
	 public function payroll_index()
    {

        if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
        $payrollData = DB::table('articlepayrolls')
        ->leftjoin('teammembers','teammembers.id','articlepayrolls.emailid')
			 ->leftjoin('roles','roles.id','teammembers.role_id')
        ->select('articlepayrolls.*','teammembers.team_member','teammembers.verify','roles.rolename')->get();

        return view('backEnd.payroll.payrollarticleindex',compact('payrollData'));
    }
    abort(403, ' you have no permission to access this page ');
    }
    public function index()
    {
	
		//dd($pay);
   //     if(auth()->user()->teammember_id == 173 or auth()->user()->teammember_id == 160){
		if((auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18 or auth()->user()->teammember_id == 556) && auth()->user()->teammember_id != 639 ){
        $payrollData = DB::table('payrolls')
        ->leftjoin('teammembers','teammembers.id','payrolls.name_of_employee')
			 ->leftjoin('roles','roles.id','teammembers.role_id')
        ->select('payrolls.*','teammembers.team_member','teammembers.verify','roles.rolename')->get();

        return view('backEnd.payroll.index',compact('payrollData'));
    }
   abort(403, ' you have no permission to access this page ');
    }
	public function payrollarticle_upload(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Payrollarticleimport, $file);
            
            foreach ($dataa[0] as $key => $value) {
		//	dd($value);
             $teamid   = Teammember::where('emailid',$value['emailid'])->pluck('id')->first();
               // dd($teamid);
              if($teamid){
                DB::table('articlepayrolls')->where('emailid',$teamid)->where('month',$request->month)->update([	
                    'entity'         =>     $value['entity'],
                    'category'         =>     $value['category'],
                    'doj'         =>     $value['doj'],
                    'year'         =>     $value['year'],
                    'location'         =>     $value['location'],
                    'stipend'         =>     $value['stipend'],
                    'totalnoofdays'         =>     $value['totalnoofdays'],
                    'noofdayspresent'         =>     $value['noofdayspresent'],
                'leave'         =>     $value['leave'],
                    'co'         =>     $value['co'],
                    'birthdayleave'         =>     $value['birthdayleave'],
                    'totaldaystobepaid'         =>     $value['totaldaystobepaid'],
                    'totalstipend'         =>     $value['totalstipend'],
                    'arrear'         =>     $value['arrear'],
                    'amounttobepaid'         =>     $value['amounttobepaid'],
					 'updated_at' => date('y-m-d H:i:s')   
                     ]);
               }
		 
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
    public function attendance_upload(Request $request )
    {
     $request->validate([
         'file' => 'required'
     ]);
   
     try {
         $file=$request->file;
       
         $data = $request->except(['_token']);
         $dataa=Excel::toArray(new Payrollimport, $file);
         
         foreach ($dataa[0] as $key => $value) {
             
             $db['control_number']=$value['control_number'] ;
             $db['sub_process']=$value['sub_process'] ;
             $db['control_objective']=$value['control_objective'] ;
             $db['identification_risk']=$value['identification_risk'] ;
             $db['client_id']=$request->client_id ;
             $db['ifcfolder_id']=$request->ifcfolder_id ;
             $db['status']='0';
             $db['created_by']=auth()->user()->teammember_id;
  
          //   dd($db);
          Payroll::Create($db);
         
           
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function payroll_upload(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Payrollimport, $file);
            
            foreach ($dataa[0] as $key => $value) {
		//	dd($value);
             $teamid   = Teammember::where('emailid',$value['name_of_employee'])->pluck('id')->first();
               // dd($teamid);
              if($teamid){
                DB::table('payrolls')->where('name_of_employee',$teamid)->where('month','April')->update([
					'partner_incharge'         =>     $value['partner_incharge'],
					 'Proposed_Entity'         =>     $value['entity'],
					 'casual_leave'         =>     $value['casual_leave'],
                    'sick_leave'         =>     $value['sick_leave'],
                    'compensatory_off'         =>     $value['compensatory_off'],
                    'bithday_leave'         =>     $value['bithday_leave'],
                    'lwp'         =>     $value['lwp'],
					 'no_of_days_present'         =>     $value['no_of_days_present'],
					 'total_days_to_be_paid'         =>     $value['total_days_to_be_paid'],
					 'remarks'         =>     $value['remarks'],
                    'monthly_gross_salary'         =>     $value['monthly_gross_salary'],
                    'amount'         =>     $value['amount'],
                    'advance'         =>     $value['advance'],
                    'tds'         =>     $value['tds'],
                    'add_gst_input'         =>     $value['add_gst_input'],
                    'arrear'         =>     $value['arrear'],
                   'bonus'         =>     $value['bonus'],
                    'total_amount_to_paid'         =>     $value['total_amount_to_paid'],
					'pfyn'         =>     $value['pfyn'],
					'employee_contribution'         =>     $value['employee_contribution'],
					'employer_contribution'         =>     $value['employer_contribution'],
					   'updated_at'              =>    date('Y-m-d H:i:s'),
                     ]);
               }
		 
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        //
    }
    public function payroll_neft(Request $request)
     {
        // dd($request);
         try {
             $data=$request->except(['_token']);
             $pay = DB::table('payrolls')->get();
             foreach ($pay as $value) {
             $team =  DB::table('teammembers')->where('emailid',$value->name_of_employee)->first();
      
             DB::table('nefts')->insert([	
              'teammember_id'         =>     $team->teammember_id, 
             'name_as_per_bankaccount'         =>     $team->name_as_per_bankaccount, 
             'nameofbank'         =>     $team->nameofbank, 	
             'bankaccountnumber'         =>     $team->bankaccountnumber, 
             'ifsccode'         =>     $team->ifsccode, 
             'paymenttype'         =>     1, 
             'status'         =>     0, 
             'totalconveyance'         =>     $request->total_amount_to_paid, 
             'createdby'         =>     auth()->user()->teammember_id,
             'updatedby'         =>     auth()->user()->teammember_id,
             'created_at'			    =>	   date('Y-m-d H:i:s'),
             'updated_at'              =>    date('Y-m-d H:i:s'),
             ]);
      
             }
             $output = array('msg' => 'Update Successfully');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function payrollneftprocess(Request $request)
    {
     //   dd($request);
          if($request->ids==null)
          {
              return redirect()->back() ->with('alert', 'Please tick one of the checkbox !');

          }
          else{
          $uniqueid = Payroll::whereIn('id',$request->ids)
          ->where('neftstatus','')
          ->select('name_of_employee','total_amount_to_paid','id','Proposed_Entity','employment_status')->get();
 // dd($uniqueid);

          foreach ($uniqueid as $value) {

          //  dd($value->Proposed_Entity);
            $userdetails = DB::table('teammembers')->where('id',$value->name_of_employee)->first();
         // dd($userdetails);
    
           if($userdetails){
            $id=DB::table('nefts')->insert([	
                'teammember_id'         =>     $userdetails->id, 
               'name_as_per_bankaccount'         =>     $userdetails->nameasperbank, 
               'nameofbank'         =>     $userdetails->nameofbank, 	
				 'month'         =>     'April', 
               'bankaccountnumber'         =>     $userdetails->bankaccountnumber, 
               'ifsccode'         =>     $userdetails->ifsccode, 
               'paymenttype'         =>     1, 
				 'type'         =>     'Salary', 
               'status'         =>     0, 
               'entity'         =>     $value->Proposed_Entity, 
				 'employeestatus'         =>     $value->employment_status, 
               'totalconveyance'         =>     $value->total_amount_to_paid, 
               'createdby'         =>     auth()->user()->teammember_id,
               'updatedby'         =>     auth()->user()->teammember_id,
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);
               DB::table('payrolls')->where('id',$value->id)->update([	
                'neftstatus'         =>     1,  
                 ]);
            } 
         else {
            $output = array('msg' => 'Submit Successfully');
           return redirect('payrollneft')->with('status', $output);
         }
        }
           
          try {
          $output = array('msg' => 'Submit Successfully');
           return redirect('neft')->with('status', $output);
      } catch (Exception $e) {
          DB::rollBack();
          Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
          report($e);
          $output = array('msg' => $e->getMessage());
          return back()->withErrors($output)->withInput();
      }
  } 
}
	 public function payrollarticleneftprocess(Request $request)
    {
     //   dd($request);
          if($request->ids==null)
          {
              return redirect()->back() ->with('alert', 'Please tick one of the checkbox !');

          }
          else{
          $uniqueid = DB::table('articlepayrolls')->whereIn('id',$request->ids)
          ->where('neftstatus',null)
          ->select('emailid','amounttobepaid','id','category')->get();
 // dd($uniqueid);

          foreach ($uniqueid as $value) {

          //  dd($value->emailid);
            $userdetails = DB::table('teammembers')->where('id',$value->emailid)->first();
        //  dd($userdetails);
    
           if($userdetails){
            $id=DB::table('nefts')->insert([	
                'teammember_id'         =>     $userdetails->id, 
               'name_as_per_bankaccount'         =>     $userdetails->nameasperbank, 
               'nameofbank'         =>     $userdetails->nameofbank, 	
               'bankaccountnumber'         =>     $userdetails->bankaccountnumber, 
               'ifsccode'         =>     $userdetails->ifsccode, 
               'paymenttype'         =>     1, 
               'status'         =>     0, 
				  'month'         =>     'April',
               'employeestatus'         =>     $value->category, 
               'totalconveyance'         =>     $value->amounttobepaid, 
               'createdby'         =>     auth()->user()->teammember_id,
               'updatedby'         =>     auth()->user()->teammember_id,
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);
               DB::table('articlepayrolls')->where('id',$value->id)->update([	
                'neftstatus'         =>     1,  
                 ]);
            } 
         else {
            $output = array('msg' => 'Submit Successfully');
           return redirect('payrollarticleneft')->with('status', $output);
         }
        }
           
          try {
          $output = array('msg' => 'Submit Successfully');
           return redirect('payrollarticleneft')->with('status', $output);
      } catch (Exception $e) {
          DB::rollBack();
          Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
          report($e);
          $output = array('msg' => $e->getMessage());
          return back()->withErrors($output)->withInput();
      }
  } 
} 
}
