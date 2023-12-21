<?php

namespace App\Http\Controllers;

use App\Models\Clientspecificindependencedeclaration;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
class ClientSpecificIndependenceController extends Controller
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

        if(auth()->user()->teammember_id == 533){
            $clientspecificindependencedeclaration = DB::table('annual_independence_declarations')
            ->leftjoin('teammembers','teammembers.id','annual_independence_declarations.createdby')
            ->leftjoin('teammembers as teammemberspartner','teammemberspartner.id','annual_independence_declarations.partner')
            ->where('type','2')
            ->select('annual_independence_declarations.*',
            'teammembers.team_member','teammemberspartner.team_member as partners')->get();
        }
        elseif(auth()->user()->role_id == 11){
            $clientspecificindependencedeclaration = DB::table('annual_independence_declarations')
            ->leftjoin('teammembers','teammembers.id','annual_independence_declarations.createdby')
            ->leftjoin('teammembers as teammemberspartner','teammemberspartner.id','annual_independence_declarations.partner')
            ->where('type','2')
            ->select('annual_independence_declarations.*',
            'teammembers.team_member','teammemberspartner.team_member as partners')->get();
        }
        else {
            $clientspecificindependencedeclaration = DB::table('annual_independence_declarations')
            ->leftjoin('teammembers','teammembers.id','annual_independence_declarations.createdby')
            ->leftjoin('teammembers as teammemberspartner','teammemberspartner.id','annual_independence_declarations.partner')
            ->where('type','2')
            ->where('annual_independence_declarations.createdby',auth()->user()->teammember_id)
           ->select('annual_independence_declarations.*',
            'teammembers.team_member','teammemberspartner.team_member as partners')->get();
        }
       
        return view('backEnd.clientspecificindependencedeclaration.index', compact('clientspecificindependencedeclaration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partner = Teammember::where('role_id','=',13)->where('status','=',1)->with('title')->get();
        return view('backEnd.clientspecificindependencedeclaration.create', compact('partner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'partner' => 'required',
            'subsidiaries' => 'required',
        ]);
        $data=$request->except(['_token']);
        $data['createdby']=auth()->user()->teammember_id;
        $data['type']= '2';
        $data = Clientspecificindependencedeclaration::Create($data);
        $output = array('msg' => 'Create Successfully');
        return back()->with('success', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clientspecificindependencedeclaration  $clientspecificindependencedeclaration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clientspecific = DB::table('annual_independence_declarations')
       
        ->leftjoin('teammembers as teammemberspartner','teammemberspartner.id','annual_independence_declarations.partner')
        ->leftjoin('teammembers','teammembers.id','annual_independence_declarations.createdby')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('annual_independence_declarations.id',$id)
       ->select('annual_independence_declarations.*',
        'teammembers.team_member','teammemberspartner.team_member as partners','roles.rolename')->first();
        return view('backEnd.clientspecificindependencedeclaration.view', compact('clientspecific'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clientspecificindependencedeclaration  $clientspecificindependencedeclaration
     * @return \Illuminate\Http\Response
     */
    public function edit(clientspecificindependencedeclaration $clientspecificindependencedeclaration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clientspecificindependencedeclaration  $clientspecificindependencedeclaration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clientspecificindependencedeclaration $clientspecificindependencedeclaration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clientspecificindependencedeclaration  $clientspecificindependencedeclaration
     * @return \Illuminate\Http\Response
     */
    public function destroy(clientspecificindependencedeclaration $clientspecificindependencedeclaration)
    {
        //
    }
}
