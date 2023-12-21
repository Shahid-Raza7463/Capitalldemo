<?php

namespace App\Http\Controllers;

use App\Models\Assignmentfolder;
use Illuminate\Http\Request;
use DB;
class AssignmentfolderController extends Controller
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
    public function indexlist($id)
    {
     //dd($id);
        $assignmentfolder = Assignmentfolder::where('assignmentgenerateid',$id)->get();
       // dd($assignmentfolder);
		    $assignmentfolderpermission = DB::table('assignmentbudgetings')->where('assignmentgenerate_id',$id)->first();
        return view('backEnd.assignmentfolder.index',compact('assignmentfolder','id','assignmentfolderpermission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'assignmentfoldersname' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
            Assignmentfolder::Create($data);
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
     * @param  \App\Models\Assignmentfolder  $assignmentfolder
     * @return \Illuminate\Http\Response
     */
    public function show(Assignmentfolder $assignmentfolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignmentfolder  $assignmentfolder
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignmentfolder $assignmentfolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignmentfolder  $assignmentfolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignmentfolder $assignmentfolder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignmentfolder  $assignmentfolder
     * @return \Illuminate\Http\Response
     */
 public function foldername_update(Request $request)
     {
        // dd($request->id);
         if ($request->ajax()) {
             if (isset($request->id)) {
                // dd($request->id);
                 $outstationconveyances = DB::table('assignmentfolders')->
               where('id',$request->id)->first();
                 return response()->json($outstationconveyances);
              }
             }
     
     }
     public function assignmentfolderupdate(Request $request)
    
     { 
                 try {
            
                     DB::table('assignmentfolders')->where('id',$request->folderid)->update([	
                         'assignmentfoldersname' => $request->name,
                          ]);
             $output = array('msg' => 'Update Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
     }
    public function assignmentfolderdelete($id)
    {
          // dd($id);
    try {
          DB::table('assignmentfolders')->where('id',$id)->delete();
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
