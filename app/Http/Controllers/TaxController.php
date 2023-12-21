<?php

namespace App\Http\Controllers;

use App\imports\Tdsimport;
use App\Models\Tax;
use Illuminate\Http\Request;
use DB;
use Excel;
class TaxController extends Controller
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
	 public function tax_upload(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Tdsimport, $file);
            
            foreach ($dataa[0] as $key => $value) {
		//	dd($value);
           
                DB::table('teammembers')->where('emailid',$value['emailid'])->update([	
                    'taxtds'         =>     $value['tds'],
                    'taxgrosssalary'         =>     $value['grosssalary'],
                    'taxpf'         =>     $value['pf'],
					 'updated_at' => date('y-m-d H:i:s')   
                     ]);
		 
 }
           $output = array('msg' => 'Excel file upload Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function index()
    {
       if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18 || auth()->user()->role_id == 17){
		$taxData = DB::table('taxes')
        ->leftjoin('teammembers','teammembers.id','taxes.createdby')
        ->select('taxes.*','teammembers.team_member')->latest()->get();
  // dd($taxData);
   
    }
		else{
		   	$taxData = DB::table('taxes')
        ->leftjoin('teammembers','teammembers.id','taxes.createdby')
				->where('taxes.createdby',auth()->user()->teammember_id)
        ->select('taxes.*','teammembers.team_member')->latest()->get();
	   }
		 return view('backEnd.tax.index',compact('taxData'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$team =  DB::table('teammembers')->where('id',auth()->user()->teammember_id)->first();
        return view('backEnd.tax.create',compact('team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
         // $validatedData = $request->validate([
         //     'partner' => 'required',
         //     'subsidiaries' => 'required',
         // ]);
         try {
             $data=$request->except(['_token','section','description','deductionamount','filess'
         ]);
         if($request->hasFile('advanceetaxattachment'))
         {
                  $file=$request->file('advanceetaxattachment');
                 $destinationPath =  'backEnd/image/tax';
                 $name = time().$file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                      $data['advanceetaxattachment'] = $name;
         }
         if($request->hasFile('otherattachment'))
         {
                  $file=$request->file('otherattachment');
                 $destinationPath =  'backEnd/image/tax';
                 $name = time().$file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                      $data['otherattachment'] = $name;
         }
        $data['createdby'] = auth()->user()->teammember_id;
             $tax = Tax::Create($data);
             $tax->save();
             $univid = $tax->id;
             $filess=array();
             if($files=$request->file('filess'))
         {
             foreach($files as $file){
                 $name=time().$file->getClientOriginalName();
                 $file->move('backEnd/image/tax/',$name);
                 $filess[]=$name;
                // dd($name);
             }
     
         }

             if($request->section[0] != null){
               
                 // dd($count);
                 
                  $count=count($request->section);
                  // dd($count);
                   for($i=0;$i<$count;$i++){
                      DB::table('taxsection')->insert([
                          'taxid' => $univid, 
                          'section' => $request->section[$i],
                          'description' => $request->description[$i],
                          'deductionamount'  => $request->deductionamount[$i],
                       //  'filess'=>  $filess[$i],
                          'created_at'			    =>	   date('y-m-d'),
                          'updated_at'              =>    date('y-m-d'),
                      ]);
                       }
                 }   
              $output = array('msg' => 'Create Successfully');
              return redirect('tax')->with('success', $output);
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
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tax = DB::table('taxes')
        ->leftjoin('teammembers','teammembers.id','taxes.createdby')
        ->where('taxes.id',$id)
        ->select('taxes.*','teammembers.team_member')->first();
  // dd($taxData);
    return view('backEnd.tax.view',compact('tax'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        //
    }
}
