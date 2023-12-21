<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Candidateonboarding;
use App\Models\Employeeonboarding;
use App\Models\Teammember;
use App\Models\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ArticleonboardingController extends Controller
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
		
         $articlebordingDatas = DB::table('articleonboardings')->get();
        
         return view('backEnd.articleonboarding.index',compact('articlebordingDatas'));
    
	}
	   public function articleprevious(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id))
             {
            
                 foreach ( DB::table('articletrainingdetails')
                ->where('articleonboarding_id',$request->id)->get() as $sub) {
                 
                 echo " <tr>
            <td>$sub->previous_organization_form </td>
            <td>$sub->date_of_joining </td>
            <td>$sub->date_of_leaving </td>
            
        </tr>";
                }
    
            }
            }
    
    } 
   
}
