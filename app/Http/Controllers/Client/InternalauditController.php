<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Internalaudit;
use App\Models\Businessentity;
use Illuminate\Http\Request;

class InternalauditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()   
    {
        $this->middleware('auth:clientlogin');
    }
    public function index()
    {
        return view('client.internalaudit.index');
    }
    public function actionTracker()
    {
        $internalauditData = Internalaudit::orderBy('id', 'DESC')->get();
        return view('client.internalaudit.actiontracker',compact('internalauditData'));
    }
  public function actionItem()
    {
        $internalaudit = Internalaudit::get();
        $statuscount = Internalaudit::where('Status','Open - On Track')->orwhere('Status','Open - Extended')->get();
        $Overdue = $internalaudit->where('Status','Overdue');
       // dd(count($Overdue));
       $business = Businessentity::all();
        
        return view('client.internalaudit.actionitem',compact('business','internalaudit','statuscount','Overdue'));
    }
    public function actionItemChange($id,Request $request)
    {
        
        if ($request->type) {
            $business = Businessentity::find($id);
            $business[$request->type] = $request->value;
            $business->save();
            $data = Businessentity::all();
            return $data;
        }  

    }

    public function actionTrackerChange($id,Request $request)
    {
        if ($request->column) 
        {
            $internalaudit = Internalaudit::find($id);
            $internalaudit[$request->column] = $request->value;
            $internalaudit->save();
            return response()->json([
                'status' => 'success',
                'data' => 'The data has been updated successfully',
            ]); 

        } 

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Internalaudit  $internalaudit
     * @return \Illuminate\Http\Response
     */
    public function show(Internalaudit $internalaudit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Internalaudit  $internalaudit
     * @return \Illuminate\Http\Response
     */
    public function edit(Internalaudit $internalaudit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Internalaudit  $internalaudit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Internalaudit $internalaudit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Internalaudit  $internalaudit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Internalaudit $internalaudit)
    {
        //
    }
}
