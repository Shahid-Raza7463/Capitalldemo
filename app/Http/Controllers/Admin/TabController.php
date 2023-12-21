<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tab;
use Illuminate\Http\Request;

class TabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tabDatas = Tab::latest()->get();
        return view('admin.tab.index',compact('tabDatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tab.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        { 
            $request->validate([
                'tabname' => "required",
                'tabcolor' => "required"
            ]);

            try {
                $data=$request->except(['_token']);
                $data = Tab::Create($data);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Tab  $tab
     * @return \Illuminate\Http\Response
     */
    public function show(Tab $tab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Tab  $tab
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tab = Tab::where('id', $id)->first();
        return view('admin.tab.edit', compact('id', 'tab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Tab  $tab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
            Tab::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('admin/tab')->with('status', $output);
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
     * @param  \App\Models\Admin\Tab  $tab
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        try {
            Tab::destroy($id);
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
