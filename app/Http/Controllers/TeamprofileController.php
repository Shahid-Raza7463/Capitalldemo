<?php

namespace App\Http\Controllers;

use App\Models\Teamprofile;
use App\Models\Teammember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamprofileController extends Controller
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
        if(auth()->user()->role_id == 11 || auth()->user()->role_id == 16)
        {
            $teamprofile = Teamprofile::with('teammember.role')->get();
           // dd($teamprofile);
            return view('backEnd.teamprofile.index',compact('teamprofile'));
        }
        else {
            $teamprofile = Teamprofile::with('teammember.role')->where('createdby', auth()->user()->teammember_id)->get();
          //  dd($teamprofile);
            return view('backEnd.teamprofile.index',compact('teamprofile'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::where('role_id',13)->orwhere('role_id',14)->with('title','role')->get();
        return view('backEnd.teamprofile.create',compact('teammember'));
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
             'teammember_id' => "required"
       ]);

         try {
             $data=$request->except(['_token']);
           
          $data['status'] = 0;
          $data['createdby'] =  auth()->user()->teammember_id;
          Teamprofile::Create($data);
        //       $teammember = Teammember::where('id',$request->teammember_id)->pluck('emailid')->first(); 
        //     // dd($partner);
        //     $data = array(
        //      'taskname' =>  $request->taskname,
        //      'duedate' =>  $request->duedate,
        //      'description' =>  $request->description,
 
        // );
       
        //  Mail::send('emails.taskassign', $data, function ($msg) use($data, $teammember){
        //      $msg->to($teammember);
        //      $msg->subject('kgs Task Assign');
        //   });
    
        //   $user=User::select('fcm')->where('teammember_id',$request->teammember_id)->get();
        //   $this->sendGCMBulk($user, $request->taskname,'','', 'notification');

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
     * @param  \App\Models\Teamprofile  $teamprofile
     * @return \Illuminate\Http\Response
     */
    public function show(Teamprofile $teamprofile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teamprofile  $teamprofile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teammember = Teammember::where('role_id',13)->orwhere('role_id',14)->with('title','role')->get();
        $teamprofile = Teamprofile::where('id', $id)->first();
        return view('backEnd.teamprofile.edit', compact('id', 'teamprofile','teammember'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teamprofile  $teamprofile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teamprofile $teamprofile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teamprofile  $teamprofile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teamprofile $teamprofile)
    {
        //
    }
}
