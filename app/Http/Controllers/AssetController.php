<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
class AssetController extends Controller
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
   $assetDatas = DB::table('assets')
   ->leftjoin('financerequests','financerequests.id','assets.financerequest_id')->
   where('assets.teammember_id',auth()->user()->teammember_id)
   ->select('assets.id','financerequests.modal_name','financerequests.id as financeid','financerequests.sno','financerequests.kgs'
   ,'financerequests.description','financerequests.assetstatus','financerequests.acknowledge')->orderBy('assetstatus','asc')->get();
   
        return view('backEnd.asset.index',compact('assetDatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function assetConfirm(Request $request)
    { 
      //  dd($request);
        $request->validate([
            'acknowledge' => "required"
        ]);

        try {
            DB::table('financerequests')->where('id',$request->assetid)->update([	
                'acknowledge'         =>     $request->acknowledge,
                 ]);
            $output = array('msg' => 'Confirm Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
    public function create()
    {
         $teammember = Teammember::where('role_id', '!=', 11)->where('role_id', '!=', 12)->with('role')->get();
        return view('backEnd.asset.create',compact('teammember'));
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
            Asset::Create($data);
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
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teammember=Teammember::latest()->get();
        $asset = Asset::where('id', $id)->first();
        return view('backEnd.asset.edit', compact('id', 'asset','teammember'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
            Asset::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('asset')->with('success', $output);
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
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        //
    }
}
