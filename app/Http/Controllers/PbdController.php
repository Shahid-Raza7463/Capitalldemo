<?php

namespace App\Http\Controllers;

use App\Models\Pbd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class PbdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  dd($id);
        if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
          $pbdDatas  = DB::table('pbds')
        ->orderBy('id', 'desc')->get();
          return view('backEnd.pbd.index',compact('pbdDatas'));
      }
      else {
          $pbdDatas  =DB::table('pbds')
         ->where('createdby',auth()->user()->teammember_id)
            ->orderBy('id', 'desc')->get();
          return view('backEnd.pbd.index',compact('pbdDatas'));
      }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.pbd.create');
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
            'Date_of_Successful_Call' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
            Pbd::Create($data);
           
         
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
     * @param  \App\Models\Pbd  $pbd
     * @return \Illuminate\Http\Response
     */
    public function show(Pbd $pbd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pbd  $pbd
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pbd = Pbd::where('id', $id)->first();
         return view('backEnd.pbd.edit', compact('id','pbd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pbd  $pbd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Date_of_Successful_Call' => "required",
        ]);
        try {
            $data=$request->except(['_token']);
            $data['updatedby'] = auth()->user()->teammember_id;
            Pbd::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('pbd')->with('success', $output);
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
     * @param  \App\Models\Pbd  $pbd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pbd $pbd)
    {
        //
    }
}
