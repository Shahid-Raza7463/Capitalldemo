<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Artisan;
use App\Models\StudentExam;
use App\Models\ExamAnswer;
use App\Models\Question;
use DB;
use Hash;
use Crypt;
use Auth;
class StudentExamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()   
    {
         $this->middleware('auth:studentlogin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	
   
   public function index()
    {
     
     $attemptData = DB::table('attempts')->where('studentid',Auth::user()->id)->first();
     //  dd($attemptData);
     if($attemptData->attempt == 0){
      $question = DB::table('questions')->inRandomOrder()->get();
      $examtime = DB::table('times')->first();
      return view('student.studentexam.index',compact('question','examtime'));
    
     }
     else{
       return view('student.studentexam.thanks',compact('attemptData'));
     }

  
    }
   
  
    public function store(Request $request)
    { 
      //  dd($request);
        // $request->validate([
        //     'question' => 'required',
        // ]);
       
        try {
            $data=$request->except(['_token']);

            $qcount=count($request->question);
            // dd($count);
            if($qcount > 0){
             for($i=0;$i<$qcount; $i++){
                 if(!empty($request->input('answer_'.($i+1)))){
           $attemptdata = DB::table('exam_answers')->insertGetId([ 
                  'student_id' => $request->studentid,
                    'question_id' => $request->question[$i],
                    'answer_id' => request()->input('answer_'.($i+1)),
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                ]);
             }            
            }
            }
            DB::table('attempts')->where('studentid',Auth::user()->id)->update([
           //  DB::table('attempts')->insert([
              'attempt' => '1',
              'updated_at' =>    date('y-m-d'),
         ]);
            $output = array('msg' => 'Thank-You');
            return redirect('students/thanks')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}

public function examEnd(Request $request)
  {
       
        return view('student.studentexam.thanks');
}

public function studentResult(Request $request,$id="")
  {
       
      $resultreview = ExamAnswer::where('student_id',Auth()->user()->id)
      ->with(['questionss','answerss'])->get();
      $totalquestion = DB::table('questions')->count();
      $questionattempt = ExamAnswer::where('student_id',Auth()->user()->id)->with(['questionss','answerss'])->count();
        
   //  dd($questionattempt);
      return view('student.studentexam.result',compact('resultreview','totalquestion','questionattempt'));
}
     
}
