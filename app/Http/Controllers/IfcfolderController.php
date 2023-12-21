<?php

namespace App\Http\Controllers;

use App\Models\Ifcfolder;
use Illuminate\Http\Request;
use DB;
class IfcfolderController extends Controller
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
    public function index($id)
    {
    // dd($id);
        $ifcfolder = Ifcfolder::with('ifc')->where('client_id',$id)->get();
       // dd($ifcfolder);
        return view('backEnd.ifcfolder.index',compact('ifcfolder','id'));
    }
    public function ifclist($id)
    {
      //  dd($id);
        $assign = DB::table('ifcs')->where('assign_member',auth()->user()->teammember_id)->first();
        $ifcfolder = DB::table('ifcs')
        ->leftjoin('clients','clients.id','ifcs.client_id')
        ->leftjoin('ifcfolders','ifcfolders.id','ifcs.ifcfolder_id')
        ->where('ifcs.assign_member',auth()->user()->teammember_id)
        ->where('ifcs.client_id',$id)->select('ifcfolders.id','foldername')->distinct('foldername')->get();
       // dd($ifcfolder);
         return view('backEnd.ifcfolder.index',compact('ifcfolder'));
    }
    public function staffindex()
    {
        $ifcfolder = DB::table('ifcs')
        ->leftjoin('clients','clients.id','ifcs.client_id')
        ->where('ifcs.assign_member',auth()->user()->teammember_id)
        ->select('clients.id','clients.client_name')->distinct('clients.client_name')
->        get('ifcs.id');
      //  dd($ifcfolder);
         return view('backEnd.ifcfolder.clientifcfolderindex',compact('ifcfolder'));
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
            'foldername' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
       Ifcfolder::Create($data);
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
     * @param  \App\Models\Ifcfolder  $ifcfolder
     * @return \Illuminate\Http\Response
     */
    public function show(Ifcfolder $ifcfolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ifcfolder  $ifcfolder
     * @return \Illuminate\Http\Response
     */
    public function edit(Ifcfolder $ifcfolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ifcfolder  $ifcfolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ifcfolder $ifcfolder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ifcfolder  $ifcfolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ifcfolder $ifcfolder)
    {
        //
    }
}
