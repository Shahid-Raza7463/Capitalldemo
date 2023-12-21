<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Employeereferral;
use App\Models\Applyleave;
use App\Models\Leavetype;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class LeavetypeController extends Controller
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
       


        //  dd($id);
        if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
          $leavetypeDatas  = DB::table('leavetypes')
          ->leftjoin('teammembers','teammembers.id','leavetypes.createdby')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('leavetypes.*','teammembers.team_member','roles.rolename')->get();
  // dd($employeereferralDatas);
         return view('backEnd.leavetype.index',compact('leavetypeDatas'));
      }
      else {
          $leavetypeDatas  =DB::table('leavetypes')
          ->leftjoin('teammembers','teammembers.id','leavetypes.createdby')
      
         ->where('createdby',auth()->user()->teammember_id)
         ->select('leavetypes.*','teammembers.team_member')->orderBy('id', 'desc')->get();
          return view('backEnd.leavetype.index',compact('leavetypeDatas'));
      }
  }
//   public function index()
//     {
//         $year   = date("2022");//You can add custom year also like $year=1997 etc.
//         $dateSun =$this->getSunday($year.'-01-01', $year.'-12-31', 0);
          
//           $now = strtotime("01-01-2022");
//             $end_date = strtotime("31-12-2022");
//             $this->calculate($now, $end_date);
       
//           while (date("Y-m-d", $now) != date("Y-m-d", $end_date))
//           {
//               $day_index = date("w", $now);
//               $day_indexD = floor((date("d", $now) - 1)/ 7);
  
//               if ($day_index == 6 && ($day_indexD == 1 || $day_indexD == 3)) {
//                   $now1 = date("Y-m-d", $now);
//                   $sun1 = date("Y-m-d", $now);
//                  // print_r($now1);
//                  // echo "</br>";
                 
//               }
//               $now = strtotime(date("Y-m-d", $now) . "+1 day");
  
//             //  $sun=strtotime(date("Y-m-d", $now) . "+2 day");
//           }
         
//           //echo"<pre>";
//           //print_r($sundays);die;
//       }
//       function getSunday($startDt, $endDt, $weekNum)
//       {
//           $startDt = strtotime($startDt);
//           $endDt = strtotime($endDt);
//           $dateSun = array();
//           do
//           {
//               if(date("w", $startDt) != $weekNum)
//               {
//                   $startDt += (24 * 3600); // add 1 day
//               }
//           } while(date("w", $startDt) != $weekNum);
//           while($startDt <= $endDt)
//           {
//               $dateSun[] = date('d-m-Y', $startDt);
//               $startDt += (7 * 24 * 3600); // add 7 days
//           }
//           echo"<pre>";
//           print_r($dateSun);die;
//           return($dateSun);
//         }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teamrole = DB::table('roles')->where('id','!=','11')->where('id','!=','12')->get();
        $applyleave = Applyleave::latest()->get();
        $teammember = Teammember::latest()->get();
        $leavetypemonth = DB::table('leavetypemonth')->latest()->get();
        $leavetypedays = DB::table('leavetypedays')->latest()->get();
        $leavetypemonthly = DB::table('leavetypemonthly')->latest()->get();
        // dd($applyleave);
        return view('backEnd.leavetype.create',compact('teamrole','teammember','applyleave','leavetypemonth','leavetypedays','leavetypemonthly'));
 //return view('backEnd.applyleave.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

public function store(Request $request)
{
//     $request->validate([
//          'Name' => "required|string",
//        'Type' => "required",
//        'Unit' => "required"
//    ]);

     try {
         $data=$request->except(['_token']);
          $data['createdby'] = auth()->user()->teammember_id;
       $leavetype =  Leavetype::Create($data);
        $leavetype->save();
        $id = $leavetype->id;
        foreach ($request->role as $role ) 
        {
         DB::table('leaveroles')->insert([	
             'leavetype_id'         =>     $id, 
            'role'         =>     $role, 	
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $applyleave = Leavetype::where('id', $id)->first();
        // dd($fullandfinal);
         return view('backEnd.leavetype.view', compact('id','applyleave'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leavetype = Leavetype::where('id', $id)->first();
        $teammember = Teammember::select('id','team_member')->get();
        $leavetypemonth = DB::table('leavetypemonth')->latest()->get();
        $leavetypedays = DB::table('leavetypedays')->latest()->get();
        $leavetypemonthly = DB::table('leavetypemonthly')->latest()->get();
        $teamrole = DB::table('roles')->where('id','!=','11')->where('id','!=','12')->get();
        $leavetyperole = DB::table('leaveroles')
        ->where('leavetype_id',$id)->get();
      // dd($leavetyperole);
         return view('backEnd.leavetype.edit', compact('id','teamrole','leavetype','leavetyperole','teammember','leavetypemonth','leavetypedays','leavetypemonthly'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'Name' => "required",
        // ]);
        try {
             $data=$request->except(['_token']);
     $data['updatedby'] = auth()->user()->teammember_id;
     Leavetype::find($id)->update($data);
     $output = array('msg' => 'Updated Successfully');
            return redirect('leavetype')->with('success', $output);
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
     * @param  \App\Models\Employeereferral  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employeereferral $employeereferral)
    {
        //
    }
}
