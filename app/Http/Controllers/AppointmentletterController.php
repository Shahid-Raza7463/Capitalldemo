<?php

namespace App\Http\Controllers;
use App\Models\Teammember;
use App\Models\Appointmentletter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class AppointmentletterController extends Controller
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
		 if(auth()->user()->teammember_id == 343  || auth()->user()->teammember_id == 510){
            $appointmentletterDatas = DB::table('appointmentletters')
            ->leftjoin('teammembers','teammembers.id','appointmentletters.teammember_id')
            ->leftjoin('clients','clients.id','appointmentletters.client_id')
            ->leftjoin('assignments','assignments.id','appointmentletters.assignment_id')
            ->select('appointmentletters.*',
            'teammembers.team_member','clients.client_name','assignments.assignment_name')->get();
                 return view('backEnd.appointmentletter.index',compact('appointmentletterDatas'));
        }
		 elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 16){
         $appointmentletterDatas = DB::table('appointmentletters')
        ->leftjoin('teammembers','teammembers.id','appointmentletters.teammember_id')
        ->leftjoin('clients','clients.id','appointmentletters.client_id')
        ->leftjoin('assignments','assignments.id','appointmentletters.assignment_id')->select('appointmentletters.*',
        'teammembers.team_member','clients.client_name','assignments.assignment_name')->get();
             return view('backEnd.appointmentletter.index',compact('appointmentletterDatas'));
    }
		else
		{
			 $appointmentletterDatas = DB::table('appointmentletters')
        ->leftjoin('teammembers','teammembers.id','appointmentletters.teammember_id')
        ->leftjoin('clients','clients.id','appointmentletters.client_id')
        ->leftjoin('assignments','assignments.id','appointmentletters.assignment_id')
        ->where('appointmentletters.teammember_id',auth()->user()->teammember_id)
                 ->select('appointmentletters.*',
                 'teammembers.team_member','clients.client_name','assignments.assignment_name')->get();
             return view('backEnd.appointmentletter.index',compact('appointmentletterDatas'));
		}
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		  $teammember = Teammember::where('role_id','=',13)->with('title','role')->get();
        return view('backEnd.appointmentletter.create',compact('teammember'));
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
            'Name' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
           if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                    $destinationPath = 'backEnd/image/appointmentletter';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachment'] = $name;
               
            }
            $data['createdby'] = auth()->user()->teammember_id;
            appointmentletter::Create($data);
     
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
     * @param  \App\Models\Appointmentletter  $appointmentletter
     * @return \Illuminate\Http\Response
     */
    public function show(Appointmentletter $appointmentletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointmentletter  $appointmentletter
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$teammember = Teammember::where('role_id','=',13)->with('title','role')->get();
        $appointmentletter = Appointmentletter::where('id', $id)->first();
        return view('backEnd.appointmentletter.edit', compact('id','appointmentletter','teammember'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointmentletter  $appointmentletter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => "required",
        ]);
        try {
            $data=$request->except(['_token']);
            if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                    $destinationPath = 'backEnd/image/appointmentletter';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachment'] = $name;
               
            }
            $data['updatedby'] = auth()->user()->teammember_id;
            Appointmentletter::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('appointmentletter')->with('success', $output);
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
     * @param  \App\Models\Appointmentletter  $appointmentletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointmentletter $appointmentletter)
    {
        //
    }
}
