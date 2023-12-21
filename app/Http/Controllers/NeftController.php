<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Neft;
use App\Models\Outstationconveyance ;
use App\Models\Teammember ;
use DB;
use Illuminate\Support\Facades\Mail;

class NeftController extends Controller
{	
    public function __construct()
    {
        $this->middleware('auth');
    }
	 public function neftdate(Request $request )
    {
       
        $date = str_replace('%',' ',$request->date);
     //   dd($date);
     if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
        $neftData = DB::table('nefts')
        ->leftjoin('teammembers','teammembers.id','nefts.teammember_id')
            ->where('nefts.paymenttype',0)
            ->where('nefts.created_at',$date)
            
       ->select('nefts.*','teammembers.team_member')->get();

       $neftDateunique = DB::table('nefts')
       ->where('nefts.paymenttype',0)->select('created_at')->distinct()->get();

        return view('backEnd.neft.neftindex',compact('neftData','neftDateunique'));
        }
    abort(403, ' you have no permission to access this page ');
    }
		 public function payrollarticleneftss(Request $request )
    {
   
        if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
            $neftData = DB::table('nefts')
            ->leftjoin('teammembers','teammembers.id','nefts.teammember_id')
				->where('nefts.employeestatus','!=','CA Article')
				    ->where('nefts.month',$request->month)
           ->select('nefts.*','teammembers.team_member','teammembers.verify')->get();
            return view('backEnd.neft.payrollneftindex',compact('neftData'));
            }
        
        abort(403, ' you have no permission to access this page ');
}
	 public function payrollarticleneft()
    {
   
        if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
            $neftData = DB::table('nefts')
            ->leftjoin('teammembers','teammembers.id','nefts.teammember_id')
				->where('nefts.month','=','May')
           ->select('nefts.*','teammembers.team_member','teammembers.verify')->get();
            return view('backEnd.neft.payrollneftindex',compact('neftData'));
            }
        
        abort(403, ' you have no permission to access this page ');
}
	  
	  public function payrollneftsalary(Request $request)
    {
  
         if(auth()->user()->teammember_id == 173 or auth()->user()->teammember_id == 160){
            $neftData = DB::table('nefts')
            ->leftjoin('teammembers','teammembers.id','nefts.teammember_id')
				->where('nefts.month',$request->month)
					->where('nefts.type','=','Salary')
           ->select('nefts.*','teammembers.team_member')->get();
            return view('backEnd.neft.payrollneftindex',compact('neftData'));
            }
        
        abort(403, ' you have no permission to access this page ');
}
	public function payrollneft()
    {
		if(auth()->user()->teammember_id == 173 or auth()->user()->teammember_id == 160){
            $neftData = DB::table('nefts')
            ->leftjoin('teammembers','teammembers.id','nefts.teammember_id')
					->where('nefts.type','=','Salary')
				->where('nefts.month','=','April')
           ->select('nefts.*','teammembers.team_member')->get();
            return view('backEnd.neft.payrollneftindex',compact('neftData'));
            }
        
        abort(403, ' you have no permission to access this page ');
}
    public function get_conveyacne(Request $request)
  
{
    if ($request->ajax()) {
           
            echo "<option value=''>Select Conveyance</option>";
    foreach (DB::table('outstationconveyances')
    ->where('outstationconveyances.createdby',$request->cid)
    ->where('outstationconveyances.Status',1)
    ->select('outstationconveyances.*')->get() as $sub)
    {
    echo "<option value='" . $sub->id . "'>" .$sub->uniqueid.' '.$sub->conveyance.' ( '.$sub->finalamount.' ) '. "</option>";
    
               
           }   
       }

}
public function neft_statusupdate(Request $request)
    {
       // dd($request);
        try {
            $data=$request->except(['_token']);
            if($request->status == 2){
//die;
               $nefts = DB::table('nefts')->where('id',$request->id)->first();
            DB::table('nefts')->where('id',$request->id)->update([	
                'status'         =>     $request->status,
                'paiddate' =>  date('Y-m-d H:i:s'),
                 ]);
                // die;
                 if($nefts->paymenttype == 0){
                    $neftconveyance = DB::table('neftconveyances')->where('neft_id',$request->id)->get();
                     foreach ($neftconveyance as $value) {
          //  dd($value->createdby);
           DB::table('outstationconveyances')->where('id',$value->localconveyance_id)->update([	
               'Status'         =>     6,
               'paiddate'         =>    date('Y-m-d H:i:s'),
                 ]);
                 DB::table('trail')->insert([
                    'createdby'   	=>     auth()->user()->teammember_id,
                    'type'   	=>     'Conveyance',
                    'pagetitle'   	=>     'Conveyance',
                   'description'=>  'Paid Payment By',
                    'ip_address'  => $request->ip(),
                    'pageid'  => $value->localconveyance_id,
                    'created_at'			    =>	   date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
        }
                 }
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
    public function neft_format()
    {
        if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
            $neftData = DB::table('nefts')
            ->leftjoin('teammembers','teammembers.id','nefts.teammember_id')
           ->select('nefts.*','teammembers.team_member')->get();
            return view('backEnd.neft.neftindex',compact('neftData'));
            }
            else {
                $neftData = DB::table('nefts')
                ->leftjoin('teammembers','teammembers.id','nefts.teammember_id')
                ->where('nefts.createdby',auth()->user()->teammember_id)
               ->select('nefts.*','teammembers.team_member')->get();
                return view('backEnd.neft.neftindex',compact('neftData'));
            } 
    }
    public function index()
    {
        // $time =  DB::table('articlefiles')->get();
        // foreach ($time as $value) {
        //    DB::table('teammembers')->where('id',$value->createdby)->where('bankaccountnumber',null)->update([	
        //        'nameasperbank'         =>     $value->accountholder,
        //        'nameofbank'         =>     $value->accountname,
        //        'bankaccountnumber'         =>     $value->accountnumber,
        //        'ifsccode'         =>     $value->ifsccode,
        //          ]);
        // }
        // die;
        if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
            $neftData = DB::table('nefts')
            ->leftjoin('teammembers','teammembers.id','nefts.teammember_id')
				->where('nefts.paymenttype',0)
				
           ->select('nefts.*','teammembers.team_member')->get();
			
			$neftDateunique = DB::table('nefts')
           ->where('nefts.paymenttype',0)->select('created_at')->distinct()->get();
			
            return view('backEnd.neft.neftindex',compact('neftData','neftDateunique'));
			
            }
           abort(403, ' you have no permission to access this page ');
}
public function neft_status(Request $request)
{
    if ($request->ajax()) {
        if (isset($request->id)) {
           // dd($request->id);
            $neftstatus = DB::table('nefts')
          ->select('nefts.id')->
          where('nefts.id',$request->id)->first();
            return response()->json($neftstatus);
         }
        }
}
    public function create(Request $request)
    {
        $teammember = Teammember::where('role_id','!=',11)->where('status',1)
                 ->where('role_id','!=',12)->where('role_id','!=',13)->with('title','role')->get();
        
     
    return view('backEnd.neft.create',compact('teammember'));
         
    } 
    public function teamList(Request $request)
    {
    
        if ($request->ajax()) {
            if (isset($request->employee_id)) {
              $teammember = Teammember::where('id',$request->employee_id)->first();
        //dd($teammember);
                return response()->json($teammember);
             }
    }
}  
    public function get_conveyancesnefttotal(Request $request)
    {
    
        if ($request->ajax()) {
            if (isset($request->employee_id)) {
               $req = explode(',', $request->employee_id);
               //dd($req);
                $roundoff= Outstationconveyance::whereIn('id',$req)
                ->sum('finalamount');
    // dd($roundoff);
                return response()->json($roundoff);
             }
    }
}  

    public function store(Request $request)
    { 
       // dd($request);
        $request->validate([
            'teammember_id' => "required",
			 
        ]);

        try {
           
             $id=DB::table('nefts')->insertGetId([	
                'teammember_id'         =>     $request->teammember_id, 
               'name_as_per_bankaccount'         =>     $request->name_as_per_bankaccount, 
               'nameofbank'         =>     $request->nameofbank, 	
               'bankaccountnumber'         =>     $request->bankaccountnumber, 
               'ifsccode'         =>     $request->ifsccode, 
               'paymenttype'         =>     $request->paymenttype, 
               'status'         =>     0, 
               'totalconveyance'         =>     $request->totalconveyance, 
               'createdby'         =>     auth()->user()->teammember_id,
               'updatedby'         =>     auth()->user()->teammember_id,
               'created_at'			    =>	   date('Y-m-d H:i:s'),
               'updated_at'              =>    date('Y-m-d H:i:s'),
               ]);
             foreach ($request->localconveyance_id as $localconveyance ) 
             {
              DB::table('neftconveyances')->insert([	
                  'neft_id'         =>     $id, 
                 'localconveyance_id'         =>     $localconveyance, 
                 'createdby'         =>     auth()->user()->teammember_id,
                 'created_at'			    =>	   date('Y-m-d H:i:s'),
                 'updated_at'              =>    date('Y-m-d H:i:s'),
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
public function edit($id)
{
 
    $teammember = Teammember::where('role_id','!=',11)->where('status',1)
    ->where('role_id','!=',12)->with('title','role')->get();
    $localconveyance = Localconveyance::where('status',1)
        ->where('localconveyances.createdby',auth()->user()->teammember_id)->get();
    $neft = Neft::where('id', $id)->first();
  //  dd($neft);
  
    return view('backEnd.neft.edit', compact('neft','teammember','localconveyance'));
}
public function update(Request $request, $id)
    {
        // $request->validate([
        //     'title' => "required",
        //     'duedate' => "required"
        // ]);
        try {
            $data=$request->except(['_token','localconveyance_id']);
          
            Neft::find($id)->update($data);
            foreach ($request->localconveyance_id as $teammember ) 
            {
             DB::table('neftconveyances')->insert([	
                 'neft_id'         =>     $id, 
                'localconveyance_id'         =>     $teammember, 	
                'updatedby'         =>     auth()->user()->teammember_id,
                'created_at'			    =>	   date('Y-m-d H:i:s'),
                'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);  
            }
        
            $output = array('msg' => 'Updated Successfully');
            return redirect('neft')->with('success', $output);
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
      //  dd($id);
        try {
            Neft::destroy($id);
            $output = array('msg' => 'Deleted Successfully');
            return redirect('neft')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

}
