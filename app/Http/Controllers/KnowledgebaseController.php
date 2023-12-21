<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Knowledgebase;

class KnowledgebaseController extends Controller
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
        $knowledgebaseDatas = Knowledgebase::latest()->get();
        return view('backEnd.knowledgebase.index',compact('knowledgebaseDatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.knowledgebase.create');
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
                'name' => "required"
            ]);

            try {
                $data=$request->except(['_token']);
                Knowledgebase::Create($data);
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
     * @param  \App\Models\backEnd\knowledgebase  $knowledgebase
     * @return \Illuminate\Http\Response
     */
    public function show(knowledgebase $knowledgebase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backEnd\knowledgebase  $knowledgebase
     * @return \Illuminate\Http\Response
     */
    public function knowledgebaseCreate($id)
    {
        return view('backEnd.article.create', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\backEnd\knowledgebase  $knowledgebase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
            knowledgebase::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('backEnd/knowledgebase')->with('status', $output);
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
     * @param  \App\Models\backEnd\knowledgebase  $knowledgebase
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        try {
            knowledgebase::destroy($id);
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
