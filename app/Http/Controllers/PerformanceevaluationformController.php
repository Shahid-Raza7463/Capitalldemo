<?php

namespace App\Http\Controllers;
use App\Models\Performanceevaluationform;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
class PerformanceevaluationformController extends Controller
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
        $performanceevaluationformData =Performanceevaluationform::latest()->get();
        return view('backEnd.performanceevaluationform.index', compact('performanceevaluationformData'));
		}
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::where('role_id','!=',15)->orwhere('role_id','!=',19)
      ->with('title','role')->get();
        return view('backEnd.performanceevaluationform.create',compact('teammember'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request);
        // $validatedData = $request->validate([
        //     'partner' => 'required',
        //     'subsidiaries' => 'required',
        // ]);
        try {
            $data=$request->except(['_token','key_responsibility','outcome_achievement','self_rating','reporting_rating'
            ,'development','priority',
        ]);
           
       $data['createdby'] = auth()->user()->teammember_id;
            $Performanceevaluationforms = Performanceevaluationform::Create($data);
            $Performanceevaluationforms->save();
            $univid = $Performanceevaluationforms->id;
    
            if($request->development[0] != null){
              
                // dd($count);
                
                 $count=count($request->key_responsibility);
                 // dd($count);
                  for($i=0;$i<$count;$i++){
                     DB::table('perfomancesectionone')->insert([
                         'performance_eva_id' => $univid, 
                         'key_responsibility' => $request->key_responsibility[$i],
                         'self_rating' => $request->self_rating[$i],
                         'reporting_rating'  => $request->reporting_rating[$i],
                         'outcome_achievement'  => $request->outcome_achievement[$i],
                         'created_at'			    =>	   date('y-m-d'),
                         'updated_at'              =>    date('y-m-d'),
                     ]);
                  }

                  $count=count($request->development);

                  for($i=0;$i<$count;$i++){
                    DB::table('performancesectionthrees')->insert([
                        'performance_eva_id' =>$univid,
                        'development' => $request->development[$i],
                        'priority'  => $request->priority[$i],
                        'created_at'			    =>	   date('y-m-d'),
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                 }
                }   
             $output = array('msg' => 'Create Successfully');
             return redirect('performanceevaluationform')->with('success', $output);
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
     * @param  \App\Models\AnnualIndependenceDeclaration  $annualIndependenceDeclaration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $performanceevaluation = DB::table('performanceevaluationforms')
        ->where('id',$id)->first();

    return view('backEnd.performanceevaluationform.view', compact('performanceevaluation'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnnualIndependenceDeclaration  $annualIndependenceDeclaration
     * @return \Illuminate\Http\Response
     */
      public function edit($id="")
    {
       // dd('hi');
        $performanceevaluation = DB::table('performanceevaluationforms')
        ->where('id',$id)->first();
        $teammember = Teammember::where('role_id','!=',15)->orwhere('role_id','!=',19)
        ->with('title','role')->get();
  //  dd($teammember);
    return view('backEnd.performanceevaluationform.edit', compact('performanceevaluation','teammember'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnnualIndependenceDeclaration  $annualIndependenceDeclaration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      //  dd($id);
        // $request->validate([
        //     'contactperson' => "required",
        // ]);
        try {
            $data=$request->except(['_token','key_responsibility','outcome_achievement','self_rating','reporting_rating'
            ,'development','priority',
        ]);
            $data['updatedby'] = auth()->user()->teammember_id;
            $Performanceevaluationform = Performanceevaluationform::find($id);
            $Performanceevaluationform->update($data);
            $Performanceevaluationform->save();
            $univid = $Performanceevaluationform->id;

           
            if($request->development[0] != null){
                DB::table('perfomancesectionone')->where('performance_eva_id',$id)->delete();
                DB::table('performancesectionthrees')->where('performance_eva_id',$id)->delete();
                // dd($count);
                
                 $count=count($request->key_responsibility);
                 // dd($count);
                  for($i=0;$i<$count;$i++){
                     DB::table('perfomancesectionone')->insert([
                         'performance_eva_id' => $univid, 
                         'key_responsibility' => $request->key_responsibility[$i],
                         'self_rating' => $request->self_rating[$i],
                         'reporting_rating'  => $request->reporting_rating[$i],
                         'outcome_achievement'  => $request->outcome_achievement[$i],
                         'created_at'			    =>	   date('y-m-d'),
                         'updated_at'              =>    date('y-m-d'),
                     ]);
                  }

                  $count=count($request->development);

                  for($i=0;$i<$count;$i++){
                    DB::table('performancesectionthrees')->insert([
                        'performance_eva_id' =>$univid,
                        'development' => $request->development[$i],
                        'priority'  => $request->priority[$i],
                        'created_at'			    =>	   date('y-m-d'),
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                 }
                }   
            $output = array('msg' => 'Updated Successfully');
            return redirect('performanceevaluationform')->with('success', $output);
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
     * @param  \App\Models\AnnualIndependenceDeclaration  $annualIndependenceDeclaration
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnnualIndependenceDeclaration $annualIndependenceDeclaration)
    {
        //
    }
}
