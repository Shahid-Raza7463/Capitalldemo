<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Artisan;
use App\Models\Ilrfolder;
use App\Models\Clientfolder;
use DB;
use Hash;
use Crypt;
use Auth;
class StudenthomeController extends Controller
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
    DB::table('studentlogins') ->where('id',Auth::user()->id)->update([	
          'status'         =>     0,
            ]);
    return view('student.index',compact('attemptData'));
  }
  else{
    return view('student.studentexam.thanks',compact('attemptData'));
  }
   
  }
    // dd($studentDatas);
  //     return view('student.index');
  //  }
       
    public function resetPassword($id)
    {
        $id=  Crypt::decrypt($id); 
        $studentlogin = DB::table('studentlogins')->where('id', $id)->first();
        return view('student.studentfile.resetpassword', compact('id', 'studentlogin'));
    }
    public function passwordUpdate(Request $request, $id = '')
    {
       //  dd($id);
          $request->validate([
              'password' => 'required',
              'confirm_password' => 'required|same:password|min:8',
          ]);
  
          try {
              $date = date("Y-m-d") ;
          
              DB::table('clientlogins')->where('id',$id)->update([ 
                  'password'         =>  Hash::make($request->password) ,
                  'updated_at'         =>  $date
                  ]);
                  $output = array('msg' => 'Password Updated Successfully');
                  return redirect('client/home')->with('success', $output);
          } catch (Exception $e) {
              DB::rollBack();
              Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
              report($e);
              $output = array('msg' => $e->getMessage());
              return back()->withErrors($output)->withInput();
          }
      }
     
}
