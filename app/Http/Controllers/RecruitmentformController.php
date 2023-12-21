<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Client;
use App\Models\Recruitmentform;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class RecruitmentformController extends Controller
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
		  if(auth()->user()->teammember_id == 434 || auth()->user()->teammember_id == 429){
			   $recruitmentformDatas  = DB::table('recruitmentforms')
          ->leftjoin('teammembers','teammembers.id','recruitmentforms.createdby')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('recruitmentforms.*','teammembers.team_member','roles.rolename')->get();
  // dd($employeereferralDatas);
         return view('backEnd.recruitmentform.index',compact('recruitmentformDatas'));
		  }
        elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
          $recruitmentformDatas  = DB::table('recruitmentforms')
          ->leftjoin('teammembers','teammembers.id','recruitmentforms.createdby')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('recruitmentforms.*','teammembers.team_member','roles.rolename')->get();
  // dd($employeereferralDatas);
         return view('backEnd.recruitmentform.index',compact('recruitmentformDatas'));
      }
      else {
          $recruitmentformDatas  =DB::table('recruitmentforms')
          ->leftjoin('teammembers','teammembers.id','recruitmentforms.createdby')
      
         ->where('createdby',auth()->user()->teammember_id)
         ->orwhere('teammember_id',auth()->user()->teammember_id)
         ->select('recruitmentforms.*','teammembers.team_member')->orderBy('id', 'desc')->get();
          return view('backEnd.recruitmentform.index',compact('recruitmentformDatas'));
      }
  }
  public function view($id)
  {
     //  dd($id);
       $recruitmentform = Recruitmentform::where('id', $id)->first();
       $recruitmentclient  = DB::table('recruitmentformclients')
       ->leftjoin('clients','clients.id','recruitmentformclients.client_id')
       ->where('recruitmentformclients.recruitmentform_id',$id)
      ->select('clients.client_name')->get();
       return view('backEnd.recruitmentform.view', compact('id','recruitmentform','recruitmentclient'));
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::where('role_id','=',13)->orwhere('role_id','=',14)->with('title','role')->get();
    
            $client = Client::select('id','client_name')->get();
		 $emp=DB::table('teammembers')->join('roles','roles.id','teammembers.role_id')
            ->select('teammembers.id','team_member','roles.rolename')->where('role_id','!=',11)->get();
 
        return view('backEnd.recruitmentform.create',compact('teammember','client','emp'));

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
             'categoryname' => "required|string",
       ]);

         try {
             $data=$request->except(['_token','client_id']);
             $data['status'] = 0;
             $data['createdby'] = auth()->user()->teammember_id;
			 $data['type']=$request->type;
             $data['employee']=$request->employee;
             
             $Recruitmentform = Recruitmentform::Create($data);
             $Recruitmentform->save();
             $id = $Recruitmentform->id;
                   if($request->client_id[0] != null){
             foreach ($request->client_id as $client_name ) 
               {
                DB::table('recruitmentformclients')->insert([	
                    'recruitmentform_id'         =>     $id, 
                   'client_id'         =>     $client_name, 	
                   'created_at'			    =>	   date('y-m-d'),
                   'updated_at'              =>    date('y-m-d'),
                   ]);  
               }
            }

           $client = DB::table('clients')->wherein('id',$request->client_id)->get();
			   $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
            $data = array(
				     'authnames' =>  $authname->team_member,
                'categoryname' => $request->categoryname ??'',
                'client' => $client ??'',
                'id' => $id ??'',
                'required_experience' => $request->required_experience ??'',
                'assignment_project' => $request->assignment_project ??'',
                'number_of_vacancies' => $request->number_of_vacancies ??'',
                'timeline' => $request->timeline ??''
        );
         Mail::send('emails.recruitmentform', $data, function ($msg) use($data){
             $msg->to('priyankasharma@kgsomani.com');
             $msg->cc('anujsomani@kgsomani.com','kavitagarwal@kgsomani.com');
             $msg->subject('New Recruitment Form Request');
          }); 
             $output = array('msg' => 'Create Successfully');
             return redirect('recruitmentform')->with('success', $output);
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
        $holiday = Holiday::where('id', $id)->first();
        // dd($fullandfinal);
         return view('backEnd.holiday.view', compact('id','holiday'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Applyleave  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $holiday = Holiday::where('id', $id)->first();
        $teammember = Teammember::select('id','team_member')->get();
        $teammember = Teammember::latest()->get();
        // dd($fullandfinal);
         return view('backEnd.holiday.edit', compact('id','holiday','teammember'));
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
    // $data['updatedby'] = auth()->user()->teammember_id;
     Recruitmentform::find($id)->update($data);
     $output = array('msg' => 'Updated Successfully');
            return redirect('recruitmentform')->with('success', $output);
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
    public function destroy($id)
     {
      //  dd($id);
        try {
            Holiday::destroy($id);
            $output = array('msg' => 'Deleted Successfully');
            return redirect('holiday')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}
