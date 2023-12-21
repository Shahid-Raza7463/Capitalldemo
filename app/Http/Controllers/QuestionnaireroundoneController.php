<?php

namespace App\Http\Controllers;

use App\Models\Questionnaireroundone;
use Illuminate\Http\Request;
use DB;
class QuestionnaireroundoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['showquestionnaireForm', 'store']);
    }
    public function index()
    {
         
            
            $questionnaireformDatas = DB::table('questionnaireroundones')->
        latest()->get();
          //dd($taskDatas);
          return view('backEnd.questionnaireform.index',compact('questionnaireformDatas'));
      } 
    public function showquestionnaireForm()
    {
        return view('questionnaireform');
    }
    public function store(Request $request)
    { 
       $request->validate([
           'services' => "required",
           'handled' => "required",
           'experience' => "required",
           'systems' => "required",
           'leadings' => "required",
       ]);

       try {
          
           $data=$request->except(['_token']);
		  if($request->hasFile('file'))
             {
                 $file=$request->file('file');
                     $destinationPath = 'backEnd/image/questionnaireform';
                     $name = $file->getClientOriginalName();
                    $s = $file->move($destinationPath, $name);
                          //  dd($s); die;
                          $data['file'] = $name;
                
             }
           Questionnaireroundone::Create($data);
         // dd($data);
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
   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Questionnaireroundone  $questionnaireroundone
     * @return \Illuminate\Http\Response
     */
    public function show(Questionnaireroundone $questionnaireroundone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Questionnaireroundone  $questionnaireroundone
     * @return \Illuminate\Http\Response
     */
    public function edit(Questionnaireroundone $questionnaireroundone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Questionnaireroundone  $questionnaireroundone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Questionnaireroundone $questionnaireroundone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Questionnaireroundone  $questionnaireroundone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Questionnaireroundone $questionnaireroundone)
    {
        //
    }
}
