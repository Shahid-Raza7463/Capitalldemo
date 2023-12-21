<?php

namespace App\Http\Controllers;

use App\Models\Cyclingevent;
use Illuminate\Http\Request;
use DB;
class CyclingeventController extends Controller
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
        if(auth()->user()->role_id == 11){
            $cyclingeventsData = DB::table('cyclingevents')
            ->leftjoin('teammembers','teammembers.id','cyclingevents.createdby')
            ->select('cyclingevents.*','teammembers.team_member')->paginate(50);
          //  dd($jobData);
        
                }
           else
           {
              // dd(auth()->user()->id);
            $cyclingeventsData = DB::table('cyclingevents')
            ->leftjoin('teammembers','teammembers.id','cyclingevents.createdby')
            ->where('cyclingevents.createdby',auth()->user()->teammember_id)
            ->select('cyclingevents.*','teammembers.team_member')->get();
          //  dd($jobData);
         
           }
           return view('backEnd.cyclingevent.index',compact('cyclingeventsData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = DB::table('teammembers')->where('id',auth()->user()->teammember_id)->first();
      //  dd($teammember);
        return view('backEnd.cyclingevent.create',compact('teammember'));
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
            'email' => "required|unique:cyclingevents",
        ]);
        try {
            $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
            Cyclingevent::Create($data);
            $output = array('msg' => 'Register Successfully');
            return redirect('cyclingevent')->with('success', $output);
      
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
     * @param  \App\Models\Cyclingevent  $cyclingevent
     * @return \Illuminate\Http\Response
     */
    public function show(Cyclingevent $cyclingevent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cyclingevent  $cyclingevent
     * @return \Illuminate\Http\Response
     */
    public function edit(Cyclingevent $cyclingevent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cyclingevent  $cyclingevent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cyclingevent $cyclingevent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cyclingevent  $cyclingevent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cyclingevent $cyclingevent)
    {
        //
    }
}
