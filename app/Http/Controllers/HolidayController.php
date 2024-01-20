<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Employeereferral;
use App\Models\Applyleave;
use App\Models\Leavetype;
use App\Models\Holiday;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class HolidayController extends Controller
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
	public function holidays(Request $request )
    {
      $holidayDatas  =DB::table('holidays')
       
          ->where('status',1)
			  ->where('year',$request->year)
          ->select('holidays.*')->orderBy('startdate', 'asc')->get();
 // dd($holidayDatas);
         return view('backEnd.holiday.index',compact('holidayDatas'));
   }
    public function index()
    {
	
        if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
          $holidayDatas  =   $holidayDatas  =DB::table('holidays')
       
          ->where('status',1)
			  ->where('year',2024)
          ->select('holidays.*')->orderBy('startdate', 'asc')->get();
   //dd($holidayDatas);
         return view('backEnd.holiday.index',compact('holidayDatas'));
      }
      else {
          $holidayDatas  =DB::table('holidays')
       
         ->where('status',1)
			  ->where('year',2024)
         ->select('holidays.*')->orderBy('startdate', 'asc')->get();
          return view('backEnd.holiday.index',compact('holidayDatas'));
      }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::latest()->get();
        return view('backEnd.holiday.create',compact('teammember'));
 //return view('backEnd.applyleave.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //     $request->validate([
    //          'Name' => "required|string",
    //        'Contact' => "required"
    //    ]);

         try {
             $data=$request->except(['_token']);
             if($request->has('teammember_id'))
             {
                 $data['teammember_id']=implode(', ', $request->teammember_id) ;    
             }
              $data['createdby'] = auth()->user()->teammember_id;
           $applyleave =  Holiday::Create($data);
            $applyleave->save();
            $id = $applyleave->id;
            $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
            $data = array(
                'teammember' => $teammember->team_member ??'',
                'id' => $id ??''
        );
        //  Mail::send('emails.employeereferralform', $data, function ($msg) use($data){
        //      $msg->to('hr@kgsomani.com');
        //      $msg->subject('Kgs Employee Referral Form ');
        //   }); 
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
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $holiday = Holiday::where('id', $id)->first();
        // dd($fullandfinal);
         return view('backEnd.holiday.view', compact('id','holiday'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $holiday = Holiday::where('id', $id)->first();
        $teammember = Teammember::select('id','team_member')->get();
        $teammember = Teammember::latest()->get();
        // dd($fullandfinal);
         return view('backEnd.holiday.edit', compact('id','holiday','teammember'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'Name' => "required",
        // ]);
        try {
             $data=$request->except(['_token']);
     $data['updatedby'] = auth()->user()->teammember_id;
     Holiday::find($id)->update($data);
     $output = array('msg' => 'Updated Successfully');
            return redirect('holiday')->with('success', $output);
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
     * @param  \App\Models\Employeereferral  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
     {
      //  dd($id);
        try {
            Holiday::destroy($id);
            $output = array('msg' => 'Deleted Successfully');
            return redirect('holiday')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}
