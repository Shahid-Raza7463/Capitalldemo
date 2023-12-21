<?php

namespace App\Http\Controllers;

use App\Models\Conversion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ConversionController extends Controller
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
        if(auth()->user()->role_id == 17 || auth()->user()->role_id == 11 ){
        $conversionDatas = DB::table('conversions')->
        leftjoin('teammembers','teammembers.id','conversions.Partner')
        ->select('conversions.*','teammembers.team_member')->get();
        return view('backEnd.conversion.index',compact('conversionDatas'));
        }
        else{
            $conversionDatas = DB::table('conversions')->
            leftjoin('teammembers','teammembers.id','conversions.Partner')
            ->select('conversions.*','teammembers.team_member')->where('Partner',auth()->user()->teammember_id)->get();
            return view('backEnd.conversion.index',compact('conversionDatas'));
        }
    }
    public function conversion(Request $request)
    {
      // dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
             //   dd($request->id);
              $conversion = DB::table('conversions')
            ->where('id',$request->id)->first();
          //  dd($conversion);
                return response()->json($conversion);
             }
            }
    
    }
    public function conversionUpdate(Request $request)
    {
           $request->validate([
                'Mail_Sent_or_not' => "required"
          ]);

            try {
 if($request->hasFile('file'))
                {
                         $file=$request->file('file');
                        $destinationPath =  'backEnd/image/conversion';
                        $name = $file->getClientOriginalName();
                       $s = $file->move($destinationPath, $name);
                             $data['file'] = $name;
                }
                DB::table('conversions')->where('id',$request->conversionid)->update([	
                    'Acknowledged'         =>   $request->Acknowledged, 
					 'date'         =>   $request->date, 
					 'file'         =>      $data['file'] ??'', 
                    'Mail_Sent_or_not'         =>   $request->Mail_Sent_or_not, 
                     'updated_at' => date('y-m-d')     
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
     * @param  \App\Models\Conversion  $conversion
     * @return \Illuminate\Http\Response
     */
    public function show(Conversion $conversion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversion  $conversion
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversion $conversion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversion  $conversion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversion $conversion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversion  $conversion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversion $conversion)
    {
        //
    }
}
