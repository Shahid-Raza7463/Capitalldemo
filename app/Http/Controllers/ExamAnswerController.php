<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Teammember;
use App\Models\StudentExam;
use App\Models\ExamAnswer;
use App\Models\Question;
use App\Models\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
class ExamAnswerController extends Controller
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
      $studentlist = DB::table('attempts')
      ->leftjoin('studentlogins','studentlogins.id','attempts.studentid')
     ->select('attempts.*','studentlogins.name')->get();
    //   dd($studentlist);
       return view('backEnd.examanswer.index',compact('studentlist'));
    }

    public function studentexamList(Request $request,$id="")
  {
  //  dd($id);
        $resultreview = ExamAnswer::where('student_id',$id)
        ->with(['questionss','answerss'])->get();
        $totalquestion = DB::table('questions')->count();
        $questionattempt = ExamAnswer::where('student_id',$id)->with(['questionss','answerss'])->count();
       
     return view('backEnd.examanswer.view',compact('resultreview','totalquestion','questionattempt'));
}
 
}
