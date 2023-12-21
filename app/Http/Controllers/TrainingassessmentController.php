<?php

namespace App\Http\Controllers;

use App\Models\Trainingassessment;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
class TrainingassessmentController extends Controller
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
       
        if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
            $softskillstraining = DB::table('softskillstraining')->latest()->get();
            $partner = Teammember::where('role_id','=',13)->with('title')->get();
            $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
        $trainingassetsmentData = DB::table('trainingassessments')
       ->leftjoin('teammembers','teammembers.id','trainingassessments.partner')
        ->leftjoin('teammembers as createdby','createdby.id','trainingassessments.createdby')
        ->leftjoin('teammembers as team','team.id','trainingassessments.teammemberid')
        ->select('trainingassessments.*'
          ,'teammembers.team_member','team.team_member as teamname','createdby.team_member as createdby')->get();
   //   dd($trainingassetsmentData);
      return view('backEnd.trainingassetsments.index',compact('trainingassetsmentData','teammember','partner','softskillstraining'));
  }
  else {
    $softskillstraining = DB::table('softskillstraining')->latest()->get();
    $partner = Teammember::where('role_id','=',13)->where('status',1)->with('title')->get();
    $teammember = Teammember::where('role_id','!=',11)->where('status',1)->with('title','role')->get();
      $trainingassetsmentData = DB::table('trainingassessments')  ->leftjoin('teammembers','teammembers.id','trainingassessments.partner')
        ->leftjoin('teammembers as createdby','createdby.id','trainingassessments.createdby')
        ->leftjoin('teammembers as team','team.id','trainingassessments.teammemberid')
      ->where('trainingassessments.partner',auth()->user()->teammember_id)
          ->orwhere('trainingassessments.createdby',auth()->user()->teammember_id) ->select('trainingassessments.*'
          ,'teammembers.team_member','team.team_member as teamname','createdby.team_member as createdby')->get();
  //  dd($trainingassetsmentData);
      return view('backEnd.trainingassetsments.index',compact('trainingassetsmentData','teammember','partner','softskillstraining'));
  }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $softskillstraining = DB::table('softskillstraining')->latest()->get();
        $partner = Teammember::where('role_id','=',13)->with('title')->get();
        $teammember = Teammember::where('role_id','!=',11)->with('title','role')->get();
        return view('backEnd.trainingassetsments.create',compact('teammember','partner','softskillstraining'));
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
             'partner' => "required",
           'teammemberid.*' => "required"
       ]);

         try {
            $id=DB::table('trainingassessments')->insertGetId([	
               'partner'         =>     $request->partner, 
               'teammemberid'         =>     $request->teammemberid, 
               'trainingtype'         =>     $request->trainingtype, 
               'other'         =>     $request->other, 
               'createdby'			=>	    auth()->user()->teammember_id,
               'created_at'			    =>	   date('y-m-d'),
               'updated_at'              =>    date('y-m-d'),
               ]);
               foreach ($request->softskillstraining as $softskillstrainings ) 
               {
                DB::table('trainingassessmentsskills')->insert([	
                    'trainingassessmentsid'         =>     $id, 
                   'softskillstraining'         =>     $softskillstrainings, 	
                   'created_at'			    =>	   date('y-m-d'),
                   'updated_at'              =>    date('y-m-d'),
                   ]);  
               }
          $output = array('msg' => 'Create Successfully');
                  return redirect('trainingassetsments')->with('success', $output);
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
     * @param  \App\Models\Trainingassessment  $trainingassessment
     * @return \Illuminate\Http\Response
     */
    public function show(Trainingassessment $trainingassessment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trainingassessment  $trainingassessment
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainingassessment $trainingassessment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trainingassessment  $trainingassessment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainingassessment $trainingassessment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trainingassessment  $trainingassessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainingassessment $trainingassessment)
    {
        //
    }
}
