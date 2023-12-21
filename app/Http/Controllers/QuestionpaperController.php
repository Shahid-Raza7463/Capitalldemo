<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questionpaper;
use App\Models\Teammember ;
use DB;
use Illuminate\Support\Facades\Mail;

class QuestionpaperController extends Controller
{	
    public function __construct()
    {
        $this->middleware('auth');
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
            return view('backEnd.neft.neftindex',compact('neftData'));
            }
           abort(403, ' you have no permission to access this page ');
}

    public function create(Request $request)
    {
 
     
    return view('backEnd.questionpaper.create');
         
    }

    public function store(Request $request)
    { 
     //   dd($request);
        // $request->validate([
        //     'question' => 'required',
        // ]);
       
        try {
            $data=$request->except(['_token']);
           
       $question_ids = DB::table('questions')->insertGetId([
        'question'  => $request->question,
            'created_at'			    =>	   date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
            ]);
   // dd($exam_ids);
            $count=count($request->answer);
            
             for($i=0;$i<$count;$i++){
                $is_correct_answer = 0;
                //dd($correctans);
                if($request->correctanswer == $request->answer[$i] ){
                    $is_correct_answer = 1;
                }
                DB::table('answers')->insert([
                    'question_id' => $question_ids, 
                    'answer' => $request->answer[$i],
                    'is_correct_answer' => $is_correct_answer,
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
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


}
