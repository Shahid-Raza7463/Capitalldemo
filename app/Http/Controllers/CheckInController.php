<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Checkin; 

class CheckInController extends Controller
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
       // dd(now()->toDateString());

        if(auth()->user()->role_id==18|| auth()->user()->role_id==11 ||auth()->user()->role_id==12)
        {
        $checkIn=DB::table('checkins')
        ->leftjoin('clients','clients.id','checkins.client_id')
        ->leftjoin('assignments','assignments.id','checkins.assignment_id')
        ->where('checkins.date', '=',now()->format('d-m-Y'))
  
       // ->where('client_name','!=',null)->where('client_name','!=','-')
        ->select('checkins.*','clients.client_name','assignments.assignment_name')
        ->orderBY('checkins.date','DESC')
        ->get();

     // dd(now()->format('d-m-Y'));
        }
        else{
            $checkIn=DB::table('checkins')
            ->leftjoin('clients','clients.id','checkins.client_id')
            ->leftjoin('assignments','assignments.id','checkins.assignment_id')
            ->where('checkins.date', '=',now()->format('d-m-Y'))
  
           // ->where('client_name','!=',null)->where('client_name','!=','-')
            ->where('teammember_id',auth()->user()->teammember_id)
            ->select('checkins.*','clients.client_name','assignments.assignment_name')
           
            ->orderBY('checkins.date','DESC')
           ->get();
              
        }

       // dd($checkIn);
        return view('backEnd.check-In.index',compact('checkIn'));
    }

    public function assignment(Request $request)
    {
        if($request->ajax())
        {
        //  dd($request);
     //    $clientdata=explode (",",$request->cid);
        
        if (isset($request->cid)) {
            echo "<option>Select Assignment</option>";
            foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
            ->leftjoin('assignments','assignments.id','assignmentbudgetings.assignment_id')
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . "</option>";
        
              }
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
        $client = DB::table('clients')
        ->where('client_name','!=',null)->where('client_name','!=','-')->latest()->get();
        return view('backEnd.check-In.create',compact('client'));

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
            'checkin_from' => "required|string",
        //  'description' => "required"
      ]);
//dd('hi');
        try {
            $data=$request->except(['_token']);


            $checkintoday=Checkin::where('teammember_id',auth()->user()->teammember_id)
           ->whereDate('created_at', Carbon::today())->first();

          //  dd($checkintoday);
          if($checkintoday==null)
            {
            $mytime = Carbon::now();
           // dd($mytime->toDateTimeString());

            $month=Carbon::now();

            $data['teammember_id']=auth()->user()->teammember_id;
            $data['month']=$month->month;
            $data['date']=date('d-m-Y');
            $data['time']=date('H:i:s');
            $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id',$request->assignment_id)->first();
            $data['assignment_id']=$assignment->assignment_id;
            //dd($data);
           Checkin::Create($data);

           $output = array('msg' => 'Checked In Successfully');
            return redirect()->to('check-In')->with('success', $output);
     
            }
            else
            {
                $output = array('msg' => 'You Have Already Checked In!!');
            return redirect()->to('check-In')->with('statuss', $output);
     

            }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        

    }
    public function show(Request $request)
    {
      //  dd($request);
        if(auth()->user()->role_id==18 || auth()->user()->role_id==11 )
        {
        $checkIn=DB::table('checkins')
        ->leftjoin('clients','clients.id','checkins.client_id')
        ->whereMonth('checkins.created_at',$request->month)
       // ->where('client_name','!=',null)->where('client_name','!=','-')
        ->select('checkins.*','clients.client_name')

        ->latest()
        ->get();
        }
        else{
            $checkIn=DB::table('checkins')
            ->leftjoin('clients','clients.id','checkins.client_id')
           // ->where('client_name','!=',null)->where('client_name','!=','-')
            ->select('checkins.*','clients.client_name')
            ->where('teammember_id',auth()->user()->teammember_id)
      		->whereMonth('checkins.created_at',$request->month)
            ->latest()
            ->get();
              
        }
        return view('backEnd.check-In.index',compact('checkIn'));
       }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd('hi');
        $client = DB::table('clients')
        ->where('client_name','!=',null)->where('client_name','!=','-')->latest()->get();

        $checkInData=DB::table('checkins')->where('teammember_id',$id)
        ->whereDate('created_at', Carbon::today())->first();

        if($checkInData==null)
        {
            $output = array('msg' => 'You Have Not Checked In !!');
            return redirect()->to('check-In')->with('statuss', $output);
     

        }
        else
        {
       //dd($checkInData);
        return view('backEnd.check-In.edit',compact('client','checkInData'));
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
           // $data=$request->except(['_token','_method']);


            $checkintoday=Checkin::where('teammember_id',auth()->user()->teammember_id)
           ->whereDate('created_at', Carbon::today())
           ->select('checkout_time')->pluck('checkout_time')->first();

          // dd($checkintoday);
          if($checkintoday==null)
            {
            $mytime = Carbon::now();
           // dd($mytime->toDateTimeString());

           // $data['checkout_time']=date('H:i:s');

            //dd($data);
           Checkin::where('teammember_id',auth()->user()->teammember_id)
           ->whereDate('created_at', Carbon::today())
            ->update(['checkout_time'=>date('H:i:s')]);

           $output = array('msg' => 'Check Out Successfully');
            return redirect()->to('check-In')->with('success', $output);
     
            }
            else
            {
                $output = array('msg' => 'You Have Already Checked Out!!');
            return redirect()->to('check-In')->with('statuss', $output);
     

            }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
