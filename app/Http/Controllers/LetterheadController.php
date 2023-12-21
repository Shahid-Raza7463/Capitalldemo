<?php

namespace App\Http\Controllers;

use App\Models\Letterhead;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LetterheadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $letterheadDatas = Letterhead::latest()->get();
        return view('backEnd.letterhead.index',compact('letterheadDatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.letterhead.create');
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
            'letterheadname' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
         
            $data['createdby'] = auth()->user()->teammember_id;
            Letterhead::Create($data);
     
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
     * @param  \App\Models\Letterhead  $letterhead
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $letterhead = Letterhead::where('id', $id)->first();
        return view('backEnd.letterhead.view',compact('letterhead'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Letterhead  $letterhead
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $letterhead = Letterhead::where('id', $id)->first();
        return view('backEnd.letterhead.edit',compact('letterhead'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Letterhead  $letterhead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
            Letterhead::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('letterhead')->with('success', $output);
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
     * @param  \App\Models\Letterhead  $letterhead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Letterhead $letterhead)
    {
        //
    }
}
