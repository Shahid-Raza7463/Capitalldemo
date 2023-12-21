<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Employeereferral;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class EmployeereferralController extends Controller
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
          $employeereferralDatas  = DB::table('employeereferrals')
          ->leftjoin('teammembers','teammembers.id','employeereferrals.createdby')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('employeereferrals.*','teammembers.team_member','roles.rolename')->get();
  // dd($employeereferralDatas);
         return view('backEnd.employeereferral.index',compact('employeereferralDatas'));
      }
        elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
          $employeereferralDatas  = DB::table('employeereferrals')
          ->leftjoin('teammembers','teammembers.id','employeereferrals.createdby')
          ->leftjoin('roles','roles.id','teammembers.role_id')
         ->select('employeereferrals.*','teammembers.team_member','roles.rolename')->get();
  // dd($employeereferralDatas);
         return view('backEnd.employeereferral.index',compact('employeereferralDatas'));
      }
      else {
          $employeereferralDatas  =DB::table('employeereferrals')
          ->leftjoin('teammembers','teammembers.id','employeereferrals.createdby')
      
         ->where('createdby',auth()->user()->teammember_id)
         ->select('employeereferrals.*','teammembers.team_member')->orderBy('id', 'desc')->get();
          return view('backEnd.employeereferral.index',compact('employeereferralDatas'));
      }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 return view('backEnd.employeereferral.create');
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
             'Name' => "required|string",
           'Contact' => "required"
       ]);

         try {
             $data=$request->except(['_token']);
			  if($request->hasFile('attachresume'))
            {
                $file=$request->file('attachresume');
                    $destinationPath = 'backEnd/image/employeereferralresume';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachresume'] = $name;
               
            }
             $data['createdby'] = auth()->user()->teammember_id;
           $employeereferral =  Employeereferral::Create($data);
            $employeereferral->save();
            $id = $employeereferral->id;
            $teammember = Teammember::where('id',auth()->user()->teammember_id)->first();
            $data = array(
                'teammember' => $teammember->team_member ??'',
                'id' => $id ??''
        );
         Mail::send('emails.employeereferralform', $data, function ($msg) use($data){
             $msg->to('priyankasharma@kgsomani.com');
             $msg->subject('Kgs Employee Referral Form ');
          }); 
             $output = array('msg' => 'Create Successfully');
			  return redirect('employeereferral')->with('success', $output);
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
     * @param  \App\Models\Employeereferral  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employeereferral = Employeereferral::where('id', $id)->first();
        // dd($fullandfinal);
         return view('backEnd.employeereferral.view', compact('id','employeereferral'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employeereferral  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employeereferral = Employeereferral::where('id', $id)->first();
        // dd($fullandfinal);
         return view('backEnd.employeereferral.edit', compact('id','employeereferral'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employeereferral  $employeereferral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => "required",
        ]);
        try {
             $data=$request->except(['_token']);
			  if($request->hasFile('attachresume'))
            {
                $file=$request->file('attachresume');
                    $destinationPath = 'backEnd/image/employeereferralresume';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachresume'] = $name;
               
            }
    $data['updatedby'] = auth()->user()->teammember_id;
    Employeereferral::find($id)->update($data);
     $output = array('msg' => 'Updated Successfully');
            return redirect('employeereferral')->with('success', $output);
			
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
