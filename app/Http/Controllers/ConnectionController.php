<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	
       
        $connectionDatas = Connection::latest()->get();
        return view('backEnd.connection.index',compact('connectionDatas'));
    }
    public function viewConnection($id)
    {
      //  dd($id);
        $connection = Connection::where('id', $id)->first();
        $connectioncompany = $connection->connectioncompany;
        //dd($connectioncompany);
        return view('backEnd.connection.view', compact('id', 'connection','connectioncompany'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.connection.create');
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
             'connectionname' => "required",
           'emailid' => "required"
       ]);

         try {
            $id=DB::table('connections')->insertGetId([	
               'connectionname'         =>     $request->connectionname, 
               'emailid'         =>     $request->emailid, 
               'phoneno'         =>     $request->phoneno, 	
               'connectedthrough'	            =>      $request->connectedthrough,
             'connectedemail'         =>     $request->connectedemail,
               'connectedphone'			=>	   $request->connectedphone,
               'relationshipthrough'			=>	   $request->relationshipthrough,
               'othercomments'			=>	   $request->othercomments,
               'createdby'			=>	    auth()->user()->teammember_id,
               'created_at'			    =>	   date('y-m-d'),
               'updated_at'              =>    date('y-m-d'),
               ]);
            $count=count($request->companyname);
        //     dd($count);
             for($i=0;$i<$count;$i++){
                DB::table('connectioncompanies')->insert([
                    'connection_id'   	=>     $id,
                    'companyname'   	=>     $request->companyname[$i],
                    'designation'   	=>     $request->designation[$i],
                    'expertise'   	=>     $request->expertise[$i],
                    'createdby'  =>  auth()->user()->teammember_id,
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
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function show(Connection $connection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $connection = Connection::where('id', $id)->first();
        $connectioncompanies =  DB::table('connectioncompanies')->where('connection_id', $id)->get();
        return view('backEnd.connection.edit', compact('id', 'connection','connectioncompanies'));
    }
    public function connectionDestroy($id = '')
    {
           try {
            DB::table('connectioncompanies')->delete($id);
               $output = array('msg' => 'Deleted Successfully');
               return back()->with('status', $output);
           } catch (Exception $e) {
               DB::rollBack();
               Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
               report($e);
               $output = array('msg' => $e->getMessage());
               return back()->withErrors($output)->withInput();
           }
       }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        try {
           DB::table('connections')->where('id', $id)->update([	
                'connectionname'         =>     $request->connectionname, 
                'emailid'         =>     $request->emailid, 
                'phoneno'         =>     $request->phoneno, 	
                'connectedthrough'	            =>      $request->connectedthrough,
              'connectedemail'         =>     $request->connectedemail,
                'connectedphone'			=>	   $request->connectedphone,
                'relationshipthrough'			=>	   $request->relationshipthrough,
                'othercomments'			=>	   $request->othercomments,
                'createdby'			=>	    auth()->user()->teammember_id,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                ]);
                if($request->companyname[0] != null){
             $count=count($request->companyname);
         //     dd($id);
              for($i=0;$i<$count;$i++){
              DB::table('connectioncompanies')->insert([
                    'connection_id'   	=>     $id,
                     'companyname'   	=>     $request->companyname[$i],
                     'designation'   	=>     $request->designation[$i],
                     'expertise'   	=>     $request->expertise[$i],
                     'createdby'  =>  auth()->user()->teammember_id,
                     'updated_at'              =>    date('y-m-d'),
                 ]);
               
              }
            }
             $output = array('msg' => 'Updated Successfully');
            return redirect('connection')->with('success', $output);
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
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
     public function destroy($id = '')
    {
       // dd($id);
        try {
            DB::table('connections')->delete($id);
			 $cid = DB::table('connectioncompanies')->where('connection_id', $id)->first();
      //  dd($cid);
           if($cid != null){
            DB::table('connectioncompanies')->where('connection_id', $id)->delete();
           }
          
            $output = array('msg' => 'Deleted Successfully');
            return back()->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}
