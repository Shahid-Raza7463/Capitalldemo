<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\Icard;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
class IcardController extends Controller
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
 
		if(auth()->user()->role_id == 11 || auth()->user()->role_id == 16){
            $teammember = Teammember::where('role_id','!=',11)->where('status','=',1)->with('title','role')
           ->get();
         $icardsDatas = DB::table('icards')
        ->leftjoin('teammembers','teammembers.id','icards.teammember_id')
        ->select('icards.*','teammembers.team_member','teammembers.profilepic')->get();
           
    }
		else
		{
            $teammember = Teammember::where('role_id','!=',13)->where('status','=',1)->with('title','role')
            ->get();
			 $icardsDatas = DB::table('icards')
        ->leftjoin('teammembers','teammembers.id','icards.createdby')->
				 where('icards.teammember_id',auth()->user()->teammember_id)->select('icards.*','teammembers.team_member','teammembers.profilepic')->first();
          
		}
        return view('backEnd.icards.index',compact('icardsDatas','teammember'));
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
    public function icardConfirm(Request $request)
    { 
      //  dd($request);
        $request->validate([
            'status' => "required"
        ]);

        try {
            DB::table('icards')->where('teammember_id',auth()->user()->teammember_id)->update([	
                'status'         =>     $request->status,
                 ]);
            $output = array('msg' => 'Confirm Successfully');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $request->validate([
         'teammember_id' => "required",
      ]);

        try {
            $data=$request->except(['_token','attachment']);
            $data['createdby'] = auth()->user()->teammember_id;
         $data['Status'] = 0;
            $icard =  Icard::Create($data);
            $icard->save();
            $id = $icard->id;
            $teammembermail = Teammember::where('id',$request->teammember_id)->pluck('emailid')->first();
            $data = array(
                 'email' => $teammembermail ??'',
                   'id' => $id ??'',
           );
            Mail::send('emails.icardform', $data, function ($msg) use($data){
                $msg->to($data['email']);
                $msg->subject('Icard Acknowledge Request');
             }); 
            $output = array('msg' => 'Create Successfully');
            return redirect('icards')->with('success', $output);
        
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
     * @param  \App\Models\Icard  $icard
     * @return \Illuminate\Http\Response
     */
    public function show(Icard $icard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Icard  $icard
     * @return \Illuminate\Http\Response
     */
    public function edit(Icard $icard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Icard  $icard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Icard $icard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Icard  $icard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Icard $icard)
    {
        //
    }
}
