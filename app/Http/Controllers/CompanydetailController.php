<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companydetail ;
use DB;
use Illuminate\Support\Facades\Auth;



class CompanydetailController extends Controller
{  
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
      
        return view('backEnd.companydetail.create');
    }
    //
    
    public function store (Request $request)
    {
        
        $data=$request->except(['_token']);
        if($request->hasFile('companylogo'))
        {
            $file=$request->file('companylogo');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('image/companylogo',$filename);
            $data['companylogo']=$filename;
        }
        $data['created_by']  = auth()->user()->teammember_id;
        Companydetail::Create($data);
        $output = array('msg' => 'detail record has been  inserted');
        return back()->with('success', $output);
    } 
    public function edit($id)
    {
        $company = Companydetail ::find($id);
        return view('backEnd.companydetail.edit',compact('company'));

    } 

    public function show()
    {
        //
        return view('backEnd.companydetail.edit');
    }

    public function viewinvoice($id)
    {
      //  dd($id);
        //$company = Companydetail::where('id', $id)->first();
        $company = DB::table('companydetails')
       
        ->leftjoin('teammembers','teammembers.id','companydetails.created_by')
     
        ->select('companydetails.*','teammembers.team_member')->where('companydetails.id', $id)->first();
        return view('backEnd.companydetail.view', compact('company'));
    }
    public function update(Request $request ,  $id)
    {
        $request->validate([
            
            'company_name' => 'required',     
        ]);
        $data=$request->except(['_token']);
        if($request->hasFile('companylogo'))
        {
            $file=$request->file('companylogo');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('image/companylogo',$filename);
            $data['companylogo']=$filename;
        }
        Companydetail::find($id)->update($data);

        return redirect()->route('companydetail.index')
            ->with('success', 'company detail updated successfully');
    }
   
public function index()
{
    $companyDatas = DB::table('companydetails')
       
    ->leftjoin('teammembers','teammembers.id','companydetails.created_by')
 
    ->select('companydetails.*','teammembers.team_member')->get();
    return view('backEnd.companydetail.index',compact('companyDatas'));
}

   
}

