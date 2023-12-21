<?php

namespace App\Http\Controllers;

use App\Models\Ilrfolder;
use App\Models\Clientlogin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use DB;
use Illuminate\Support\Facades\Hash;
class ClientuserloginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	  public function clientassign(Request $request)
    { 
        $request->validate([
            'client_id'    => 'required',
        ]);

        try {
            DB::table('clientassignlogins')->insert([
                'client_id'   	=>     $request->client_id,
                'clientlogin_id'     =>        $request->clientlogin_id,
                'createdby'     =>     auth()->user()->teammember_id,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
            $output = array('msg' => 'Client Assign Successfully');
            return back()->with('success', $output);
     
      
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
		public function staffpermission(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
                $ilrquestion = DB::table('clientlogins')->where('id',$request->id)->first();
            // dd($ilrquestion);
                return response()->json($ilrquestion);
             }
            }
    
    }
	 public function permissionStore(Request $request)
    { 
		// dd($request);
        $request->validate([
            'client_id'    => 'required',
        ]);

        try {
            DB::table('staffpermission')->insert([
                'client_id'   	=>     $request->client_id,
                'clientlogin_id'     =>        $request->clientlogin_id,
                'writes'     =>        $request->writes,
                'deletes'     =>        $request->deletes,
                'staffallocate'     =>        $request->staffallocate,
				  'checklistupload'     =>        $request->checklistupload,
                'clientlogin_id'     =>        $request->clientlogin_id,
                'createdby'     =>     auth()->user()->teammember_id,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
            $output = array('msg' => 'Permission Successfully');
            return back()->with('success', $output);
     
      
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
    public function changeclientloginStatus(Request $request)
    { 
      //  dd($request);
        $user = Clientlogin::find($request->user_id);
        $user->status = $request->status;
        $user->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
    public function passwordUpdate(Request $request, $id = '')
    {
        //dd($id);
          $request->validate([
              'email' => 'required',
              'password' =>'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
              'confirm_password' => 'required|same:password',
          ]);
  
          try {
              $date = date("Y-m-d") ;
      
              DB::table('clientlogins')->where('id',$id)->update([ 
                  'password'         =>  Hash::make($request->password) ,
                  'updated_at'         =>  $date
                  ]);
                  $output = array('msg' => 'Password Updated Successfully');
                  return back()->with('success', $output);
          } catch (Exception $e) {
              DB::rollBack();
              Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
              report($e);
              $output = array('msg' => $e->getMessage());
              return back()->withErrors($output)->withInput();
          }
      }
    public function resetPassword($id)
    {
       // dd($id);
        $clientlogin = DB::table('clientlogins')->where('id', $id)->first();
        return view('backEnd.clientlogin.resetpassword', compact('id', 'clientlogin'));
    }
	public function clientlogin(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
                $ilrquestion = DB::table('clientlogins')->where('id',$request->id)->first();
            // dd($ilrquestion);
                return response()->json($ilrquestion);
             }
            }
    
    }
    public function indexview($id)
    {
    //   dd($id);
        $clientloginDatas = DB::table('clientlogins')
        ->where('client_id',$id)->where('status','!=','3')->get();
		 $client = DB::table('clients')->get();
        return view('backEnd.clientlogin.index',compact('clientloginDatas','id','client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientCreate($id)
    {
        $clientlogin = Clientlogin::where('id',$id)->first();
		 $ilrfolder = Ilrfolder::with('ilr')->where('client_id',$id)->where('parent_id',null)->get();
        return view('backEnd.clientlogin.create',compact('clientlogin','id','ilrfolder'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 public function __construct()
    {
        $this->middleware('auth');
    }
    public function clientStore(Request $request)
    { 
        $request->validate([
            'email'    => 'required|email|unique:clientlogins',
            'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ]);

        try {
            $data=$request->except(['_token']);
           
            $data['createdby'] = auth()->user()->teammember_id;
            $data['updatedby'] = auth()->user()->teammember_id;
            $data['status'] = 1;
            $data['password']=  Hash::make($request->password);
                $clientloginid = Clientlogin::Create($data);
            $clientloginid->save();
            $id = $clientloginid->id;
            if($request->folderid != null){
                 DB::table('ilrfolderassigns')->insert([	
                     'ilrfolder_id'         =>     $request->folderid, 
                     'client_id'         =>     $request->client_id, 	
                     'clientlogin_id'         =>     $id, 	
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
     * @param  \App\Models\Clientlogin  $clientlogin
     * @return \Illuminate\Http\Response
     */
    public function show(Clientlogin $clientlogin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clientlogin  $clientlogin
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientlogin $clientlogin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientlogin  $clientlogin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clientlogin $clientlogin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientlogin  $clientlogin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clientlogin $clientlogin)
    {
        //
    }
}
