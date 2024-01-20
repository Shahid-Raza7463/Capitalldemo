<?php

namespace App\Http\Controllers;
use App\Models\Teammember;
use App\Models\Timesheet;
use App\imports\Timesheetimport;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Assignment;
use App\Models\Job;
use App\Models\Timesheetusers;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use DB;
use Excel;
class TimesheetController extends Controller
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
	   public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
	   public function timesheetexcelStore(Request $request )
    {
     $request->validate([
         'file' => 'required'
     ]);
   
     try {
         $file=$request->file;
      //  dd($file);
         $data = $request->except(['_token']);
        $dataa=Excel::toArray(new Timesheetimport, $file);
       //     dd($dataa);
        foreach ($dataa[0] as $key => $value) {
			
			
			 $currentday = 
        \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['date'])->format('Y-m-d');
      // $currentday= date('Y-m-d', strtotime($value['date']));
      // dd($currentday);
        
        $mytime = Carbon::now();

        $currentdate=$mytime->toDateString();
  		$hour = $value['hour'];

           

       

        if($currentday > $currentdate)
        {
          $output = array('msg' => 'You Can Not Fill Timesheet For Future Date ('. date('d-m-Y', strtotime($currentday)).')');
          return redirect('timesheet')->with('statuss', $output);

        }
			elseif($hour > 24)
			{
		$output = array('msg' => 'The time entered exceeds the maximum of 24 hours !');
        return back()->with('statuss', $output);

			}
        else
        {
        
			$leaves = DB::table('applyleaves')
              ->where('applyleaves.createdby',auth()->user()->teammember_id)
              ->where('status','!=',2)
              //->orWhere('status',0)
              ->select('applyleaves.from','applyleaves.to')
                ->get();
        // dd($leaves);
                if( count($leaves)!=0)
                {
          foreach($leaves as $leave){
              //Convert each data from table to Y-m-d format to compare
                $days = CarbonPeriod::create(
                  date('Y-m-d', strtotime($leave->from)),
                  date('Y-m-d', strtotime($leave->to)));
      
              foreach ($days as $day) {
                  $leavess[] = $day->format('Y-m-d');
                 // dd($leavess);
                 
                 
  
              }
             
          }
          //dd($leavess);
      

            //  date('Y-m-d', strtotime($intval($value['date'])));
         // dd($currentday);
          if($leavess!=null)
          {
              //dd('if');
          foreach($leavess as $leave)
          {
              
              if( $leave == $currentday )
              {
                 // dd('if');
                 // $ifcount=$ifcount+1;
                 $output = array('msg' => 'You Have Leave for the Day ('. date('d-m-Y', strtotime($leave)).')');
                  return redirect('timesheet')->with('statuss', $output);
              }
              else

              {
               //  dd($currentday);
              }
            }
        }  
      }
              $clients   = DB::table('clients')->where('client_name',$value['clientname'])->pluck('id')->first();
            if($clients ==null)
             {
				//dd($clients);
              $output = array('msg' => 'Client Name ('.$value['clientname'].') Not Match Please Check!!');
              return back()->with('statuss', $output);
             }
                else{
				//dd($clients);
            $assignments = DB::table('assignments')->where('assignment_name',$value['assignmentname'])->pluck('id')->first();
			if($assignments ==null)
            {
             $output = array('msg' => 'Assigment Name ('.$value['assignmentname'].') Not Found Please Check!!');
             return back()->with('statuss', $output);
            }
            $partner = DB::table('teammembers')->where('team_member',$value['partner'])->pluck('id')->first();
					 if($partner ==null)
            {
             $output = array('msg' => 'Partner Name ('.$value['partner'].') Not Match Please Check!!');
             return back()->with('statuss', $output);
            }
					  if($value['billablestatus']!= "Non Billable" && $value['billablestatus']!= "Billable" )
            {
              $output = array('msg' => 'Billable status ('.$value['billablestatus'].') Not Match Please Check!!');
             return back()->with('statuss', $output);
  
            }
            $timesheet = DB::table('timesheets') ->where('created_by',auth()->user()->teammember_id)
            ->where('date',$value['date'])->pluck('id')->first();

            if($timesheet == null){

                $id = DB::table('timesheets')->insertGetId(
                    [ 
                        'created_by' => auth()->user()->teammember_id,
                        'date'   	=>     $this->transformDate($value['date']),
                        'created_at'			    =>	   date('Y-m-d H:i:s'),
                        ]
                );
				    $timesheets = DB::table('timesheets')->where('id',$id)->first();
                   DB::table('timesheets')->where('id',$timesheets->id)->update([	
                    'date'   	=>    date('Y-m-d', strtotime($timesheets->date)),
                    'month'   	=>    date('F', strtotime($timesheets->date)),
                     ]);
            }


            
              DB::table('timesheetusers')->insert([
                    'date'   	=>       $this->transformDate($value['date']),
                    'client_id'   	=>     $clients ,
                    'workitem'   	=>     $value['workitem'],
                    'billable_status'   	=>      $value['billablestatus'],
                    'timesheetid'   	=>     $id,
                    
                    'hour'   	=>     $value['hour'],
                    'totalhour' =>      $value['hour'],
                    'assignment_id'   	=>     $assignments,
				   'partner'   	=>     $partner,
                    'createdby' => auth()->user()->teammember_id,
                    'created_at'			    =>	   date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
                $totalhour= DB::table('timesheetusers')->select('date', DB::raw('COUNT(*) as `count`'))
        ->where('createdby',auth()->user()->teammember_id)
         ->groupBy('date')
        ->havingRaw('COUNT(*) > 1')
   
        ->get();
        foreach ($totalhour as $value) {
            $sum = DB::table('timesheetusers')->where('createdby',auth()->user()->teammember_id)->where('date',$value->date)->sum('hour');
        
            DB::table('timesheetusers')->where('createdby',auth()->user()->teammember_id)->where('date',$value->date)->update([	
                'totalhour'         =>   $sum,
                ]);
			
			//attendance reflection'
			
			  $attendances = DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
                ->where('month','May')->first();
              //  dd($value->created_by);

             // dd($attendances);
                if($attendances ==  null){
                    $a=DB::table('attendances')->insert([	
                        'employee_name'         =>     auth()->user()->teammember_id,
                        'month'         =>    'May',
                     //   'exam_leave'      =>$value->date_total,
                    ]);
                   // dd($a);
                }
               
             //   dd($noofdaysaspertimesheet);
             $hdatess = date('Y-m-d',strtotime($value->date));
             
           // dd($hdatess);
        if ($hdatess == '2023-04-26') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentysix'         =>     $sum,
                    ]);
        }
        
        if ($hdatess == '2023-04-27') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentyseven'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-04-28') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentyeight'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-04-29') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentynine'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-04-30') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'thirty'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-04-31') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'thirtyone'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-01') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'one'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-02') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'two'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-03') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'three'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-04') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'four'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-05') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'five'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-06') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'six'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-07') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'seven'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-08') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'eight'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-09') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'nine'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-10') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'ten'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-11') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'eleven'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-12') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twelve'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-13') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'thirteen'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-14') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'fourteen'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-15') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'fifteen'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-16') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'sixteen'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-17') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'seventeen'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-18') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'eighteen'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-19') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'ninghteen'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-20') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twenty'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-21') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentyone'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-22') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentytwo'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-23') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentythree'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-24') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentyfour'         =>     $sum,
                    ]);
        }
        if ($hdatess == '2023-05-25') {
          DB::table('attendances')->where('employee_name',auth()->user()->teammember_id)
          
          ->where('month','May')->update([	
                  'twentyfive'         =>     $sum,
                    ]);
        }
            
          //end attendance
     
			
			
			
        }
               

            

           
            }
		}
   }
   //dd($dataa);
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
    public function index()
    {
		if(auth()->user()->teammember_id == 99 || auth()->user()->teammember_id == 169 || auth()->user()->teammember_id == 550 || auth()->user()->teammember_id == 161)
		{
           // dd(auth()->user()->teammember_id);
// 			  $time =  DB::table('timesheets')->get();
// foreach ($time as $value) {
//     //dd(date('F', strtotime($value->date)));
//     DB::table('timesheets')->where('id',$value->id)->update([	
//         'month'         =>     date('F', strtotime($value->date)),
//          ]);
// }
			   $teammember = DB::table('teammembers')->leftjoin('roles','roles.id','teammembers.role_id')
            ->select('teammembers.id','teammembers.team_member','roles.rolename')->distinct()->get();
          //  dd($teammember);
$month = DB::table('timesheets')
->select('timesheets.month')->distinct()->get();
		 $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
            ->distinct()->orderBy('year','DESC')->limit(5)->get();
            $years = $result->pluck('year');


             $timesheetData = DB::table('timesheets')
            ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
    ->select('timesheets.*','teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
    // dd($timesheetData);
         return view('backEnd.timesheet.hrindex',compact('timesheetData','teammember','month','years'));
		}
		
        elseif(auth()->user()->role_id == 11 ){
					//			  $time =  DB::table('timesheets')->get();
//foreach ($time as $value) {
    //dd(date('F', strtotime($value->date)));
//   DB::table('timesheets')->where('id',$value->id)->where('month',null)->update([	
  //     'month'         =>     date('F', strtotime($value->date)),
  //       ]);
//}
//			   $time =  DB::table('timesheets')->where('month','November')
  //     ->orwhere('month','October')->get();
		//dd($time);
//foreach ($time as $value) {
//dd(date('Y-m-d', strtotime($value->date)));
//DB::table('timesheets')->where('id',$value->id)->update([	
 //  'date'         =>     date('Y-m-d', strtotime($value->date)),
  //  ]);
//}
         $teammember = DB::table('teammembers')->leftjoin('roles','roles.id','teammembers.role_id')
            ->select('teammembers.id','teammembers.team_member','roles.rolename')
			 ->where('teammembers.status','1')->distinct()->get();
          //  dd($teammember);
$month = DB::table('timesheets')
->select('timesheets.month')->distinct()->get();
			 $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
            ->distinct()->orderBy('year','DESC')->limit(5)->get();
            $years = $result->pluck('year');

//dd($month);
            $timesheetData = DB::table('timesheets')
            ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
    ->select('timesheets.*','teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
    // dd($timesheetData);
          return view('backEnd.timesheet.hrindex',compact('timesheetData','teammember','month','years'));
                }
		elseif(auth()->user()->role_id == 18)
		{

			   $teammember = DB::table('teammembers')->leftjoin('roles','roles.id','teammembers.role_id')
            ->select('teammembers.id','teammembers.team_member','roles.rolename')
				//   ->where('teammembers.status','1')
				   ->distinct()->get();
          //  dd($teammember);
				$month = DB::table('timesheets')
				->select('timesheets.month')->distinct()->get();
			
			 $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
            ->distinct()->orderBy('year','DESC')->limit(5)->get();
            $years = $result->pluck('year');

			//dd($month );

             $timesheetData = DB::table('timesheets')
            ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
    ->select('timesheets.*','teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
   // dd($timesheetData);
          return view('backEnd.timesheet.hrindex',compact('timesheetData','teammember','month','years'));
		}
		elseif(auth()->user()->role_id == 13)
		{
           // dd(auth()->user()->teammember_id);
// 			  $time =  DB::table('timesheets')->get();
// foreach ($time as $value) {
//     //dd(date('F', strtotime($value->date)));
//     DB::table('timesheets')->where('id',$value->id)->update([	
//         'month'         =>     date('F', strtotime($value->date)),
//          ]);
// }
			   $teammember =DB::table('timesheets')
               ->leftjoin('timesheetusers','timesheetusers.timesheetid','timesheets.id')
               ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
               ->leftjoin('roles','roles.id','teammembers.role_id')
              ->where('timesheetusers.partner',auth()->user()->teammember_id)
            ->select('teammembers.id','teammembers.team_member','roles.rolename')->distinct()->get();
          //  dd($teammember);
$month = DB::table('timesheets')
->select('timesheets.month')->distinct()->get();
			
			 $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
            ->distinct()->orderBy('year','DESC')->limit(5)->get();
            $years = $result->pluck('year');


            $timesheetData = DB::table('timesheets')
            ->leftjoin('timesheetusers','timesheetusers.timesheetid','timesheets.id')
            ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
           ->where('timesheetusers.partner',auth()->user()->teammember_id)
    ->select('timesheets.*','teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
    // dd($timesheetData);
         return view('backEnd.timesheet.hrindex',compact('timesheetData','teammember','month','years'));
		}
           else
           {
			    $getauth =  DB::table('timesheets')
            ->where('created_by',auth()->user()->teammember_id)
            ->orderby('id', 'desc')->first();

         //   dd($getauth);
           $client = Client::select('id','client_name')->get();
            $timesheetData =  $timesheetData = DB::table('timesheets')
            ->leftjoin('teammembers','teammembers.id','timesheets.created_by')->where('timesheets.created_by',auth()->user()->teammember_id)
    ->select('timesheets.*','teammembers.team_member')->orderBy('id', 'DESC')->paginate(100);
			     $partner = Teammember::where('role_id','=',13)->where('status','=',1)->with('title')->get();
    $timesheetrequest = DB::table('timesheetrequests')->where('createdby',auth()->user()->teammember_id)->
    orderBy('id', 'DESC')->first();
          if ($getauth  == null) {
  return view('backEnd.timesheet.firstindex',compact('timesheetData','getauth','client','partner'));
}
else {
  return view('backEnd.timesheet.index',compact('timesheetData','getauth','client','partner','timesheetrequest'));
}
           }
    }
   public function show(Request $request)
    {
	    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
            ->distinct()->orderBy('year','DESC')->limit(5)->get();
            $years = $result->pluck('year');

	    if(auth()->user()->teammember_id == 23){
     $teammember = DB::table('teammembers')->leftjoin('roles','roles.id','teammembers.role_id')
		 ->where('teammembers.role_id','15')
            ->select('teammembers.id','teammembers.team_member','roles.rolename')->distinct()->get();
   //  dd($teammember);
$month = DB::table('timesheets')
->select('timesheets.month')->distinct()->get();
			

   $timesheetData = DB::table('timesheets')
   ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
   ->where('timesheets.created_by',$request->teammember)->where('timesheets.month',$request->month)
	 ->whereYear('timesheets.date', '=',$request->year)
   ->select('timesheets.*','teammembers.team_member')->get();
	 }
     elseif(auth()->user()->role_id == 11 ||auth()->user()->role_id == 18){
     $teammember = DB::table('teammembers')->leftjoin('roles','roles.id','teammembers.role_id')
            ->select('teammembers.id','teammembers.team_member','roles.rolename')->distinct()->get();
   //  dd($teammember);
$month = DB::table('timesheets')
->select('timesheets.month')->distinct()->get();

   $timesheetData = DB::table('timesheets')
   ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
   ->where('timesheets.created_by',$request->teammember)->where('timesheets.month',$request->month)
	   ->whereYear('timesheets.date', '=',$request->year)
   ->select('timesheets.*','teammembers.team_member')->get();
	 }
	    elseif (auth()->user()->role_id == 13) {
            $teammember =DB::table('timesheets')
            ->leftjoin('timesheetusers','timesheetusers.timesheetid','timesheets.id')
            ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
            ->leftjoin('roles','roles.id','teammembers.role_id')
           ->where('timesheetusers.partner',auth()->user()->teammember_id)
         ->select('teammembers.id','teammembers.team_member','roles.rolename')->distinct()->get();
   //  dd($teammember);
$month = DB::table('timesheets')
->select('timesheets.month')->distinct()->get();

   $timesheetData = DB::table('timesheets')
   ->leftjoin('teammembers','teammembers.id','timesheets.created_by')
   ->where('timesheets.created_by',$request->teammember)->where('timesheets.month',$request->month)
	   ->whereYear('timesheets.date', '=',$request->year)
   ->select('timesheets.*','teammembers.team_member')->get();
        }
        return view('backEnd.timesheet.hrindex',compact('timesheetData','teammember','month','years'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
	$partner = Teammember::where('role_id','=',13)->where('status','=',1)->with('title')->get();
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
        $client = Client::select('id','client_name')->orderBy('client_name', 'asc')->get();
        $assignment = Assignment::select('id','assignment_name')->get();
     //   dd($assignment);
        if ($request->ajax()) {
           //  dd($request);
              if (isset($request->cid)) {
                echo "<option>Select Assignment</option>";
       foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
       ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
       ->orderBy('assignment_name')->get() as $sub) {
       echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . "</option>";
       
                  }
              }
			    if (isset($request->assignment)) {
					
					
if($request->assignment=='329177531230')
					{
					
					echo "<option>Select Partner</option>";
       foreach (DB::table('teammembers')     
       ->leftjoin('roles','roles.id','teammembers.role_id')
      ->where('role_id',13)->get() as $subs) {
       echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
	
					}
}
					else{
              //  dd($request->assignment);
                echo "<option>Select Partner</option>";
       foreach (DB::table('assignmentmappings')
     
       ->leftjoin('teammembers','teammembers.id','assignmentmappings.leadpartner')
       ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)->get() as $subs) {
       echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
       
                  }
				}
              } 
          } else {
            return view('backEnd.timesheet.create',compact('client','teammember','assignment','partner'));
           }
      
    }
    public function timesheetajax()
    {
        if ($request->ajax()) {
            //  dd($request);
               if (isset($request->cid)) {
                echo "<option>Select Assignment</option>";
        foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
        ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
        ->orderBy('assignment_name')->get() as $sub) {
        echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
        
                   }
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

    try {


 

      $data = $request->except(['_token', 'teammember_id', 'amount']);



 

      $leaves = DB::table('applyleaves')

        ->where('applyleaves.createdby', auth()->user()->teammember_id)

        ->where('status', '!=', 2)

        ->select('applyleaves.from', 'applyleaves.to')

        ->get();


 

      foreach ($leaves as $leave) {

        //Convert each data from table to Y-m-d format to compare

        $days = CarbonPeriod::create(

          date('Y-m-d', strtotime($leave->from)),

          date('Y-m-d', strtotime($leave->to))

        );


 

        foreach ($days as $day) {

          $leavess[] = $day->format('Y-m-d');

        }

      }

      $currentday = date('Y-m-d', strtotime($request->date));

      // $ifcount=0;

      //  $elsecount=0;


 

      if (count($leaves) != 0) {

        //dd('if');

        foreach ($leavess as $leave) {

          // echo"<pre>";

          //  print_r($leave);


 

          if ($leave == $currentday) {

            //dd('if');

            // $ifcount=$ifcount+1;

            $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');

            return redirect('timesheet')->with('statuss', $output);

          }

        }

      }

      $id = DB::table('timesheets')->insertGetId(

        [

          'created_by' => auth()->user()->teammember_id,

          'month'     =>    date('F', strtotime($request->date)),

          'date'     =>    date('Y-m-d', strtotime($request->date)),

          'created_at'          =>     date('Y-m-d H:i:s'),

        ]

      );

      // dd('else');

      $count = count($request->assignment_id);

      // dd($count);

      for ($i = 0; $i < $count; $i++) {

        //dd($request->workitem[$i]);

        $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();


 

        $a = DB::table('timesheetusers')->insert([

          'date'     =>     $request->date,

          'client_id'     =>     $request->client_id[$i],

          'workitem'     =>     $request->workitem[$i],

          'billable_status'     =>     $request->billable_status[$i],

          'timesheetid'     =>     $id,

          'date'     =>     date('d-m-Y', strtotime($request->date)),

          'hour'     =>     $request->hour[$i],

          'totalhour' =>      $request->totalhour,

          'assignment_id'     =>     $assignment->assignment_id,

          'partner'     =>     $request->partner[$i],

          'createdby' => auth()->user()->teammember_id,

          'created_at'          =>     date('Y-m-d H:i:s'),

          'updated_at'              =>    date('Y-m-d H:i:s'),

        ]);

      }

        $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

          ->where('month', 'May')->first();

        //  dd($value->created_by);


 

        // dd($attendances);

        if ($attendances ==  null) {

          $a = DB::table('attendances')->insert([

            'employee_name'         =>     auth()->user()->teammember_id,

            'month'         =>    'May',

            //   'exam_leave'      =>$value->date_total,

          ]);

          // dd($a);

        }

       


 

        //   dd($noofdaysaspertimesheet);

        $hdatess = date('Y-m-d', strtotime($request->date));


 

        // dd($hdatess);
		$updatedtotalhour = $request->totalhour;

        if ($hdatess == '2023-04-26') {


 

          if($attendances->twentysix)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentysix;

          }


 

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentysix'         =>    $updatedtotalhour,

            ]);

        }


 

        if ($hdatess == '2023-04-27') {


 

          if($attendances->twentyseven)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentyseven;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentyseven'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-04-28') {

          if($attendances->twentyeight)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentyeight;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentyeight'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-04-29') {

          if($attendances->twentynine)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentynine;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentynine'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-04-30') {

          if($attendances->thirty)

          {

            $updatedtotalhour = $request->totalhour + $attendances->thirty;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'thirty'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-04-31') {

          if($attendances->thirtyone)

          {

            $updatedtotalhour = $request->totalhour + $attendances->thirtyone;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'thirtyone'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-01') {

          if($attendances->one)

          {

            $updatedtotalhour = $request->totalhour + $attendances->one;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'one'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-02') {

          if($attendances->two)

          {

            $updatedtotalhour = $request->totalhour + $attendances->two;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'two'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-03') {

          if($attendances->three)

          {

            $updatedtotalhour = $request->totalhour + $attendances->three;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'three'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-04') {

          if($attendances->four)

          {

            $updatedtotalhour = $request->totalhour + $attendances->four;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'four'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-05') {

          if($attendances->five)

          {

            $updatedtotalhour = $request->totalhour + $attendances->five;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'five'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-06') {

          if($attendances->six)

          {

            $updatedtotalhour = $request->totalhour + $attendances->six;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'six'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-07') {

          if($attendances->seven)

          {

            $updatedtotalhour = $request->totalhour + $attendances->seven;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'seven'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-08') {

          if($attendances->eight)

          {

            $updatedtotalhour = $request->totalhour + $attendances->eight;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'eight'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-09') {

          if($attendances->nine)

          {

            $updatedtotalhour = $request->totalhour + $attendances->nine;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'nine'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-10') {

          if($attendances->ten)

          {

            $updatedtotalhour = $request->totalhour + $attendances->ten;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'ten'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-11') {

          if($attendances->eleven)

          {

            $updatedtotalhour = $request->totalhour + $attendances->eleven;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'eleven'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-12') {

          if($attendances->twelve)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twelve;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twelve'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-13') {

         

          if($attendances->thirteen)

          {

            $updatedtotalhour = $request->totalhour + $attendances->thirteen;

            //dd($updatedtotalhour);

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'thirteen'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-14') {

          if($attendances->fourteen)

          {

            $updatedtotalhour = $request->totalhour + $attendances->fourteen;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'fourteen'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-15') {

          if($attendances->fifteen)

          {

            $updatedtotalhour = $request->totalhour + $attendances->fifteen;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'fifteen'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-16') {

          if($attendances->sixteen)

          {

            $updatedtotalhour = $request->totalhour + $attendances->sixteen;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'sixteen'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-17') {

          if($attendances->seventeen)

          {

            $updatedtotalhour = $request->totalhour + $attendances->seventeen;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'seventeen'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-18') {

          if($attendances->eighteen)

          {

            $updatedtotalhour = $request->totalhour + $attendances->eighteen;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'eighteen'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-19') {

          if($attendances->ninghteen)

          {

            $updatedtotalhour = $request->totalhour + $attendances->ninghteen;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'ninghteen'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-20') {

          if($attendances->twenty)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twenty;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twenty'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-21') {

          if($attendances->twentyone)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentyone;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentyone'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-22') {

          if($attendances->twentytwo)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentytwo;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentytwo'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-23') {

          if($attendances->twentythree)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentythree;
			  
          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentythree'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-24') {

          if($attendances->twentyfour)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentyfour;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentyfour'         =>    $updatedtotalhour,

            ]);

        }

        if ($hdatess == '2023-05-25') {

          if($attendances->twentyfive)

          {

            $updatedtotalhour = $request->totalhour + $attendances->twentyfive;

          }

          DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)


 

            ->where('month', 'May')->update([

              'twentyfive'         =>    $updatedtotalhour,

            ]);

        }


 

        //end attendance





 

     

      $output = array('msg' => 'Create Successfully');

      return redirect('timesheet')->with('success', $output);

    } catch (Exception $e) {

      DB::rollBack();

      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

      report($e);

      $output = array('msg' => $e->getMessage());

      return back()->withErrors($output)->withInput();

    }

  }


	public function timesheetUpload(Request $request )
    {
     $request->validate([
         'file' => 'required'
     ]);
   
     try {
         $file=$request->file;
      //  dd($file);
         $data = $request->except(['_token']);
        $dataa=Excel::toArray(new Timesheetimport, $file);
       //     dd($dataa);
        foreach ($dataa[0] as $key => $value) {
    //  $informationresource   = Informationresource::where('question',$value['question'])->pluck('question')->first();
      
        //    if($informationresource == null){
             $db['clientname']=$request->clientname;
             $db['assignmentname']=$request->assignmentname;
             $db['workitem']=$request->workitem ;
             $db['billable_status']=$request->billable_status ;
             $db['hour']=$request->hour;
          //   dd($request->clientname);
             if($request->clientname != NULL)  {
                $client_id   = clients::where('client_name',$value['clientname'])->pluck('id')->first();
            //    dd($client_id);
                if($assignmentname != NULL)  {
                $assignment_id   = assignments::where('assignment_name',$value['assignmentname'])->pluck('id')->first();
                }
             }
                 

     //  'createdby' => auth()->user()->teammember_id,
        //     Timesheet::Create($db);
           
     //       }
     
   }
   //dd($dataa);
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
     * Display the specified resource.
     *
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd($date);
        //$id=77;
        $client = Client::select('id','client_name')->get();
        $time = DB::table('timesheets')->where('id',$id)->first();
        $date = $time->date;
        $assignment = Assignment::select('id','assignment_name')->get();
        $timesheet = DB::table('timesheetusers')
        ->leftjoin('clients','clients.id','timesheetusers.client_id')
         ->leftjoin('assignments','assignments.id','timesheetusers.assignment_id')
         ->where('timesheetusers.timesheetid',$id)
         ->select('timesheetusers.*','clients.client_name','assignments.assignment_name')
         ->get();
     //   dd($timesheet);
         $count= count($timesheet = DB::table('timesheetusers')->where('timesheetusers.date', $date)->get());
      //  dd( $count);
         // $totalhour=$timesheet->totalhour;
       
        $rcount=5-$count;
       

     

        return view('backEnd.timesheet.edit', compact('id','timesheet','client','assignment','date','rcount','count'));

       
    }
    public function view($id)
    {
       //  dd($id);
         $timesheet = timesheet::where('id', $id)->first();
         return view('backEnd.timesheet.view', compact('id','timesheet'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);  
            $count=count($request->assignment_id);
            // dd($count);
            $timesheet = DB::table('timesheets')->where('date',$request->date)->delete();

             for($i=0;$i<$count;$i++){
                DB::table('timesheets')->insert([
                    'client_id'   	=>     $request->client_id[$i],
                    'workitem'   	=>     $request->workitem[$i],
                    'billable_status'   	=>     $request->billable_status[$i],
                    'hour'   	=>     $request->hour[$i],
                    'assignment_id'   	=>     $request->assignment_id[$i],
                    'createdby' => auth()->user()->teammember_id,
                    'updatedby' => auth()->user()->teammember_id,
                    'date'      =>$request->date,
                    'totalhour' =>$request->totalhour,
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                ]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outstationconveyance  $outstationconveyance
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
      //  dd($id);
        try {
            DB::table('timesheets')->where([

                'id'   =>   $id,       

                ])->delete();
            DB::table('timesheetusers')->where([

                'timesheetid'   =>   $id,       

                ])->delete();
            $output = array('msg' => 'Deleted Successfully');
            return redirect('timesheet')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
	 public function timesheetrequestStore(Request $request)
    {
      // dd($request);
        try {
            $data=$request->except(['_token']);  
      $assignment = DB::table('assignmentbudgetings')->where('assignmentgenerate_id',$request->assignment_id)->first();
      $id = DB::table('timesheetrequests')->insertGetId([
                    'client_id'   	=>     $request->client_id,
                    'assignment_id'   	=>     $assignment->assignment_id,
                    'partner'   	=>     $request->partner,
                    'reason'   	=>     $request->reason,
                    'status'   	=>     0,
                    'createdby' => auth()->user()->teammember_id,
                    'created_at'			    =>	   date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
                
           //     $travel = Assetprocurement::where('id', $id)->first();
                $teammembermail = Teammember::where('id',$request->partner)->pluck('emailid')->first();
                $client_name = Client::where('id',$request->client_id)->pluck('client_name')->first();
//dd($client_name);
				$name= Teammember::where('id',auth()->user()->teammember_id)->pluck('team_member')->first();

                $data = array(
                    'teammember' =>$name ??'',
                   
                       'email' => $teammembermail ??'',
                       'id' => $id ??'',
                       'client_id' => $client_name ??'',
               );
			//dd($data);
                Mail::send('emails.timesheetrequestform', $data, function ($msg) use($data){
                    $msg->to(['email']);
                    $msg->cc('priyankasharma@kgsomani.com');
                    $msg->subject('Timesheet Submission Request');
                 }); 
            $output = array('msg' => 'Request Successfully');
            return back()->with('success', $output);
     
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
    }
    
    public function timesheetrequestlist()
    {
        $timesheetrequestlist = DB::table('timesheetrequests')
        ->leftjoin('timesheetusers','clients.client_id','timesheetrequests.id')
        ->leftjoin('assignments','assignments.id','timesheetrequests.assignment_id')
        ->leftjoin('teammembers as team','team.id','timesheetrequests.partner')
        ->leftjoin('teammembers','teammembers.id','timesheetrequests.createdby')
       ->where('timesheetrequests.createdby',auth()->user()->teammember_id)
       ->where('timesheetrequests.partner',auth()->user()->teammember_id)
->select('timesheetrequests.*','teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
// dd($timesheetData);

     return view('backEnd.timesheet.timesheetrequest',compact('timesheetrequestlist'));
    }
	
	
//Report
	
	 public function Reportsection(Request $request)
    {
    
     $employeename = Teammember::where('role_id','!=',11)->where('status',1)->with('title','role')->get();
    $client = Client::select('id','client_name')->get();
    $assignment = Assignment::select('id','assignment_name')->get();
    $partner= Teammember::where('role_id','=',13)->where('status',1)->with('title','role')->get();
		 
		  $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
            ->distinct()->orderBy('year','DESC')->limit(5)->get();
            $years = $result->pluck('year');

		 //dd($assignment);
    	if ($request->ajax()) {
            //   dd($request);
                if (isset($request->cid)) {
                    $clientdata=explode (",",$request->cid);
                  echo "<option value=''>Select Assignment</option>";
         foreach (DB::table('timesheetusers')->whereIn('client_id', $clientdata)
         ->leftjoin('assignments','assignments.id','timesheetusers.assignment_id')
         ->orderBy('assignment_name')->distinct()->get(['assignments.id','assignments.assignment_name']) as $sub) {
         echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
         
                    }
                }

                if (isset($request->clientid)) {
                    $clientdata=explode (",",$request->clientid);
                  echo "<option value=''>Select Employee</option>";
         foreach (DB::table('timesheetusers')->whereIn('client_id', $clientdata)
         ->leftjoin('teammembers','teammembers.id','timesheetusers.createdby')
         ->orderBy('team_member')->distinct()->get(['teammembers.id','teammembers.team_member']) as $sub) {
         echo "<option value='" . $sub->id . "'>" . $sub->team_member . "</option>";
         
                    }
                }
             
                  if (isset($request->ass_id)) {
                 //dd($request->ass_id);;
                 $ass_data=explode (",",$request->ass_id);
                 //dd($ass_data);

            
                  echo "<option value=''>Select Partner</option>";
         foreach (DB::table('teammembers')       
         ->leftjoin('timesheetusers','timesheetusers.partner','teammembers.id')
         ->whereIn('timesheetusers.assignment_id', $ass_data)
         ->distinct()->get(['teammembers.id','teammembers.team_member']) as $subs) {
         echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
         
         
                    }
                 //   die;
                }
     
       } else {
          return view('backEnd.timesheet.reportsection',compact('employeename','client','assignment','partner','years'));
   }
}
	
public function filtersection(Request $request)
{
    //dd($request);
    if ($request->ajax()) {
      $clients = collect(is_array($request->clientid) ? $request->clientid : explode(',', $request->clientid))->filter();
$employeeIds = collect(is_array($request->employeeid) ? $request->employeeid : explode(',', $request->employeeid))->filter();
$assignmentIds = collect(is_array($request->assignmentid) ? $request->assignmentid : explode(',', $request->assignmentid))->filter();
$partners = collect(is_array($request->partnerid) ? $request->partnerid : explode(',', $request->partnerid))->filter();
//$dateRange = collect(is_array($request->daterange) ? $request->daterange : explode(' - ', $request->daterange))->filter();
// $dateRange = collect(explode(' - ', $request->daterange))->filter();
	//[$startDate, $endDate] = $dateRange->map(fn ($date) => Carbon::parse($date));
		
		 $date=explode (" - ",$request->daterange);
  // dd($date);
   $start = Carbon::parse($date[0]);
   $end = Carbon::parse($date[1]);

   $now=Carbon::now();
    $noww=Carbon::parse($now);
   //dd($start);
   if($start==$end)
   {
    $daterange=null;
   }
   else
   {
    $daterange=1;

   }
		/*
$financial_year = $request->yearly;


		
		
$quarter = $request->quarter; // Update with the desired quarter (q1, q2, q3, or q4)

$Qstart = '';
$Qend = '';
//dd($quarter);
if ($quarter == 'Q1') {
	
    $Qstart = $financial_year .'-04-01';
    $Qend = $financial_year .'-06-30';
} elseif ($quarter == 'Q2') {
	//dd('hi');
    $Qstart = $financial_year .'-07-01';
	//dd($Qstart);
    $Qend = $financial_year . '-09-30';
} elseif ($quarter == 'Q3') {
    $Qstart = $financial_year . '-10-01';
    $Qend = ($financial_year + 1) . '-01-01';
} elseif ($quarter == 'Q4') {
    $Qstart = ($financial_year + 1) . '-01-01';
    $Qend = $financial_year . '-03-31';
}
*/


		
	//	dd($Qstart);
  
      $query1 = $request->workitem;
      $query1 = str_replace(' ', '%', $query1);
  
		if($request->month == 0)
		{
      $timesheetData = Timesheetusers::join('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
          ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->with(['client', 'assignment', 'createdBy', 'partner'])
          ->when($clients->isNotEmpty(), fn ($query) => $query->whereIn('client_id', $clients))
          ->when($employeeIds->isNotEmpty(), fn ($query) => $query->whereIn('timesheetusers.createdby', $employeeIds))
          ->when($assignmentIds->isNotEmpty(), fn ($query) => $query->whereIn('assignment_id', $assignmentIds))
          ->when($partners->isNotEmpty(), fn ($query) => $query->whereIn('partner', $partners))
		//  ->when($financial_year !='2025', fn ($query) => $query->whereYear('date', $financial_year))
        
          ->when($daterange==1, function ($query) use ($start, $end) {
  		  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
          ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
          ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
          ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
			})
		//		   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
  		//  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
		//->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
       //   ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
        //  ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
		//	})

		->when($request->billableid, fn ($query) => $query->where('billable_status', $request->billableid))
          ->when($request->month != 0, fn ($query) => $query->whereMonth('timesheetusers.date', $request->month))
          ->when($query1, fn ($query) => $query->where('workitem', 'like', "%$query1%"))
		  ->where('teammembers.status','!=',0)
          ->select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as 				partnername')
          ->get();
		}
		else
		{
			$timesheetData = Timesheetusers::join('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
          ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->with(['client', 'assignment', 'createdBy', 'partner'])
          ->when($clients->isNotEmpty(), fn ($query) => $query->whereIn('client_id', $clients))
          ->when($employeeIds->isNotEmpty(), fn ($query) => $query->whereIn('timesheetusers.createdby', $employeeIds))
          ->when($assignmentIds->isNotEmpty(), fn ($query) => $query->whereIn('assignment_id', $assignmentIds))
          ->when($partners->isNotEmpty(), fn ($query) => $query->whereIn('partner', $partners))
				
		//		->when($request->yearly !=2025, fn ($query) => $query->whereYear('timesheetusers.date', $request->yearly))
        
          ->when($daterange==1, function ($query) use ($start, $end) {
  		  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
          ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
          ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
          ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
			})
	//			   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
  	//	  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
     //     ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
      //    ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
      //    ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
		//	})

         // ->when($startDate && $endDate, fn ($query) => $query->whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate))
          ->when($request->billableid, fn ($query) => $query->where('billable_status', $request->billableid))
          ->when($request->month , fn ($query) => $query->whereMonth('timesheetusers.date', $request->month))
          ->when($query1, fn ($query) => $query->where('workitem', 'like', "%$query1%"))
				->where('teammembers.status','!=',0)
          ->select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as partnername')
          ->get();
	
		}
  
      return response()->json(['data'=>$timesheetData]);
  }
      
  }


}
