<?php

namespace App\Http\Controllers;
use App\Models\Declarationform;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
class DeclarationformController extends Controller
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
        $declarationformData = DB::table('declarationforms')
        ->leftjoin('teammembers','teammembers.id','declarationforms.createdby')->
        select('declarationforms.*','teammembers.team_member')->get();
        return view('backEnd.declarationform.index', compact('declarationformData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partner = Teammember::where('role_id','=',13)->where('status','=',1)->with('title')->get();
        $authname = Teammember::where('id',auth()->user()->teammember_id)->first();
        return view('backEnd.declarationform.create', compact('partner','authname'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  dd($request);
        // $validatedData = $request->validate([
        //     'partner' => 'required',
        //     'subsidiaries' => 'required',
        // ]);
        $data=$request->except(['_token']);
        
        $univid=DB::table('declarationforms')->insertGetId([			
            'relative_name'   => $request->relative_name,
			'din'   => $request->din,
			'dinno'   => $request->dinno,
            'relation'         => $request->relation,
            'resident'         => $request->resident,
			'place'         => $request->place,
            'createdby'  => auth()->user()->teammember_id,
            'created_at'			    =>	   date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
            ]);

            $count=count($request->company_name);
            // dd($count);
             for($i=0;$i<$count;$i++){
                DB::table('declarationformdetails')->insert([
                    'declaration_id' => $univid, 
                    'company_name' => $request->company_name[$i],
                    'interest' => $request->interest[$i],
                    'shareholding'  => $request->shareholding[$i],
                    'date'         => $request->date[$i],
                    'created_at'			    =>	   date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                ]);
             } 

        $output = array('msg' => 'Create Successfully');
        return back()->with('success', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnnualIndependenceDeclaration  $annualIndependenceDeclaration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $declarationform = DB::table('declarationforms')
			->leftjoin('teammembers','teammembers.id','declarationforms.createdby')->
			  select('declarationforms.*','teammembers.team_member')
        ->where('declarationforms.id',$id)->first();

    return view('backEnd.declarationform.view', compact('declarationform'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnnualIndependenceDeclaration  $annualIndependenceDeclaration
     * @return \Illuminate\Http\Response
     */
    public function edit(AnnualIndependenceDeclaration $annualIndependenceDeclaration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnnualIndependenceDeclaration  $annualIndependenceDeclaration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnnualIndependenceDeclaration $annualIndependenceDeclaration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnnualIndependenceDeclaration  $annualIndependenceDeclaration
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnnualIndependenceDeclaration $annualIndependenceDeclaration)
    {
        //
    }
}
