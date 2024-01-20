<?php

namespace App\Http\Controllers;

use App\Models\Travelfeedback;
use Illuminate\Http\Request;
use DB;
class TravelfeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function feedback(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $outstationconveyances = DB::table('travelforms')
              ->select('travelforms.id')->
              where('travelforms.id',$request->id)->first();
                return response()->json($outstationconveyances);
             }
            }
    
    } 
    public function index()
    {
        if( auth()->user()->role_id == 11){
            $travelfeedbacks  = DB::table('travelfeedbacks')
            ->leftjoin('travelforms','travelforms.id','travelfeedbacks.travelform_id')
            ->leftjoin('clients','clients.id','travelforms.client_id')
            ->leftjoin('assignments','assignments.id','travelforms.assignment')
            ->leftjoin('teammembers','teammembers.id','travelforms.partener')
            ->leftjoin('teammembers as teams','teams.id','travelforms.createdby')
            ->select('travelfeedbacks.*','teammembers.team_member','clients.client_name','assignments.assignment_name',
            'teams.team_member as createdby')->get();
            // dd($travelformDatas);
            }
            else{
                $travelfeedbacks  = DB::table('travelfeedbacks')
                ->leftjoin('travelforms','travelforms.id','travelfeedbacks.travelform_id')
                ->leftjoin('clients','clients.id','travelforms.client_id')
                ->leftjoin('assignments','assignments.id','travelforms.assignment')
                ->leftjoin('teammembers','teammembers.id','travelforms.partener')
                ->leftjoin('teammembers as teams','teams.id','travelforms.createdby')
               ->where('travelfeedbacks.createdby',auth()->user()->teammember_id)
                   ->select('travelfeedbacks.*','teammembers.team_member','clients.client_name','assignments.assignment_name',
                   'teams.team_member  as createdby')->get();
                  // dd($travelfeedbacks);
            }
           return view('backEnd.travelfeedback.index',compact('travelfeedbacks'));
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
   
             try  {
                 $data=$request->except(['_token']);
                 $data['createdby'] = auth()->user()->teammember_id;
                 $data = Travelfeedback::Create($data);
                 DB::table('travelforms')->where('id',$request->travelform_id)->update([	
                     'feedback'         =>     '1', 
                      ]);
              
                 $output = array('msg' => 'Submit Successfully');
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
     * @param  \App\Models\Travelfeedback  $travelfeedback
     * @return \Illuminate\Http\Response
     */
    public function show(Travelfeedback $travelfeedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Travelfeedback  $travelfeedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Travelfeedback $travelfeedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Travelfeedback  $travelfeedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Travelfeedback $travelfeedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Travelfeedback  $travelfeedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Travelfeedback $travelfeedback)
    {
        //
    }
}
