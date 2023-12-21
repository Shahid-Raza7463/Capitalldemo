<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
use Excel;
class ProfileController extends Controller
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
            if(auth()->user()->role_id == 11 or auth()->user()->role_id == 12 or auth()->user()->role_id == 13){
        $profileDatas = DB::table('profiles')
   ->leftjoin('teammembers','teammembers.id','profiles.teammember_id')
   ->leftjoin('roles','roles.id','teammembers.role_id')
   ->select('profiles.*','teammembers.team_member','roles.rolename')->get();
       // dd($profileDatas);
        return view('backEnd.profile.index',compact('profileDatas'));
            }
       else
	   {
		     $profileDatas = DB::table('profiles')
   ->leftjoin('teammembers','teammembers.id','profiles.teammember_id')
   ->leftjoin('roles','roles.id','teammembers.role_id')->where('createdby',auth()->user()->teammember_id)
   ->select('profiles.*','teammembers.team_member','roles.rolename')->get();
       // dd($profileDatas);
        return view('backEnd.profile.index',compact('profileDatas'));
	   }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $teammember = Teammember::where('role_id', '!=', 11)->with('role')->get();
       return view('backEnd.profile.create',compact('teammember'));
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
            'companyname' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
            if(auth()->user()->role_id == 11 or auth()->user()->role_id == 12){
           if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                    $destinationPath = 'backEnd/image/profile';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachment'] = $name;
               
            }
            $data['createdby'] = auth()->user()->teammember_id;
            Profile::Create($data);
     
            $output = array('msg' => 'Create Successfully');
            return back()->with('success', $output);
        }
        else
        {
            if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                    $destinationPath = 'backEnd/image/profile';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachment'] = $name;
               
            }
            $data['createdby'] = auth()->user()->teammember_id;
            $data['teammember_id'] = auth()->user()->teammember_id;
            Profile::Create($data);
     
            $output = array('msg' => 'Create Successfully');
            return back()->with('success', $output);
        }
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
     * @param  \App\Models\finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show(finance $finance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $teammember=Teammember::latest()->with('role')->get();
        $finance = Financerequest::where('id', $id)->first();
        return view('backEnd.profile.edit', compact('id', 'finance','teammember'));
    }
    public function financeView($id)
    {
      //  dd($id);
        $finance = Financerequest::where('id', $id)->first();
       // dd($finance);
        return view('backEnd.profile.view', compact('id', 'finance'));
    }
    public function financeViewit($id)
    {
        $finance = Financerequest::where('id', $id)->first();
        $account = Teammember::where('role_id',17)->with('title')->get();
        return view('backEnd.profile.viewit', compact('id', 'finance','account'));
    }
    public function financeUpload(Request $request )
    {
        $request->validate([
            'file' => 'required'
        ]);
      
        try {
            $file=$request->file;
          
            $data = $request->except(['_token']);
            $dataa=Excel::toArray(new Financeimport, $file);
            
            foreach ($dataa[0] as $key => $value) {
                $financename=DB::table('financerequests')->where('name',$value['name'])->select('name')->pluck('name')->first();
             //   dd($value['clientname']);
             if($financename == NULL){
                $db['modal_name']=$value['modal_name'];
                $db['sno']=$value['sno'] ;
                 $db['company_name']=$value['company_name'] ;
                 $db['name']=$value['name'];
                 $db['kgs']=$value['kgs'];
                 $db['mac_address']=$value['mac_address'];
                 $data= Financerequest::Create($db);
               }
              
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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
             Financerequest::find($id)->update($data);
            $financerequest_id   = DB::table('assets')->where('teammember_id',$request->teammemberid)->pluck('financerequest_id')->first();
            if($financerequest_id == null)
            {  DB::table('assets')->insert([	
                'financerequest_id'         =>     $id,
                'teammember_id'  => $request->teammemberid,
                'item'  => $request->modal_name,
                'description'  => $request->kgs.$request->sno,
                'dateassign'  => date('y-m-d'),
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                 ]);
                }
          else{
            DB::table('assets')->where('financerequest_id',$id)->update([	
                'financerequest_id'         =>     $id,
                'teammember_id'  => $request->teammemberid,
                'item'  => $request->modal_name,
                'description'  => $request->kgs.$request->sno,
                'dateassign'  => date('y-m-d'),
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                 ]);
          }
            $output = array('msg' => 'Updated Successfully');
            return redirect('profile')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function accountUpdate(Request $request)
    {
        try {
            $data=$request->except(['_token']);
            Financerequest::find($request->id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('profile')->with('success', $output);
    } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function itUpdate(Request $request)
    {
        try {
            $data=$request->except(['_token']);
            Financerequest::find($request->id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('profile')->with('success', $output);
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
     * @param  \App\Models\finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance $finance)
    {
        //
    }
}
