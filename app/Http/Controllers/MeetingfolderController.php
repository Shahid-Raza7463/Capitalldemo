<?php

namespace App\Http\Controllers;

use App\Models\Meetingfolder;
use Illuminate\Http\Request;
use DB;
class MeetingfolderController extends Controller
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
        $meetingfolder = Meetingfolder::where('createdby',533)
			->where('parent_id',null)->get();
        $meetingfolders = Meetingfolder::where('createdby',533)->get();
	}
		 elseif(auth()->user()->teammember_id == 33 || auth()->user()->teammember_id == 13 || auth()->user()->teammember_id == 157 || auth()->user()->teammember_id == 17 ){
        $meetingfolder = Meetingfolder::where('id',10)->get();
        $meetingfolders = Meetingfolder::where('id',10)->get();
	}
    elseif(auth()->user()->role_id == 11){
        $meetingfolder = Meetingfolder::where('parent_id',null)->get();
        $meetingfolders = Meetingfolder::latest()->get();
	}
		 elseif(auth()->user()->role_id == 14){
        $meetingfolder = Meetingfolder::where('id',9)->get();
        $meetingfolders = Meetingfolder::where('id',9)->get();
	}
		else{
		  $meetingfolder = Meetingfolder::where('parent_id',null)->where('createdby',auth()->user()->teammember_id)->get();
        $meetingfolders = Meetingfolder::where('createdby',auth()->user()->teammember_id)->get();
		}
		
        return view('backEnd.meetingfolder.index',compact('meetingfolder','meetingfolders'));
    }
    public function meetingfiles($id)
   
	{
      $subfolder = DB::table('meetingfolders')->where('parent_id',$id)->first();
    //  dd($subfolder);
  if ($subfolder== null) {
   $meetingfile = DB::table('meetingfiles')
   ->leftjoin('teammembers','teammembers.id','meetingfiles.createdby')
   ->where('meetingfolder_id',$id)
   ->select('meetingfiles.*','teammembers.team_member')->get();
     return view('backEnd.meetingfolder.subfolderindex',compact('meetingfile','id'));
     } else {
        $meetingfolders = Meetingfolder::latest()->get();
        $meetingfolder = Meetingfolder::where('parent_id',$id)->get();
     // dd($clientfolder);
        return view('backEnd.meetingfolder.subindex',compact('meetingfolder','id','meetingfolders'));
     }
  
 }
 public function meeting_filenameedit(Request $request)
 {
   //  dd($request);
     if ($request->ajax()) {
         if (isset($request->id)) {
            
             $outstationconveyances = DB::table('meetingfolders')
           ->select('meetingfolders.*')->
           where('meetingfolders.id',$request->id)->first();
         //  dd($outstationconveyances);
             return response()->json($outstationconveyances);
          }
         }
 
 }
 public function meeting_upload(Request $request)
    {
        $request->validate([
             'filename' => 'required',
        ]);

        try {
            $data=$request->except(['_token']);
            if($request->hasFile('filename'))
        {
                 $file=$request->file('filename');
      $name = time().$file->getClientOriginalName();
      $path = $file->storeAs('meetingfolder',$name,'s3');
           $data['filename'] = $name;
        }
           
           // dd($files); die;
               $s = DB::table('meetingfiles')->insert([
                    'filename' => $data['filename'], 
				   'description' =>  $request->description, 
                    'meetingfolder_id' =>  $request->meetingfolder_id, 
                    'createdby' =>  auth()->user()->teammember_id, 
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);  
           
            //dd($data);
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
    public function store(Request $request)
    
    { 
        $request->validate([
            'foldername' => "required"
        ]);

        try {
          $data=$request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;
         //   $data['color'] =   '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
             $ilrfolder = Meetingfolder::Create($data);
	
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
    public function meetingsubfolderstore(Request $request)
    
    { 
        $request->validate([
            'foldername' => "required"
        ]);

        try {
          $data=$request->except(['_token','parentid']);
            $data['createdby'] = auth()->user()->teammember_id;
            if ($request->parent_id ==  null) {
                $data['parent_id'] = $request->parentid;
            } else {
                $data['parent_id'] = $request->parent_id;
            }
            
         //   $data['color'] =   '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
             $ilrfolder = Meetingfolder::Create($data);
	
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
    public function meetingfolder_update(Request $request)
    
    { 
        $request->validate([
            'foldername' => "required"
        ]);

        try {
          $data=$request->except(['_token']);
          DB::table('meetingfolders')->where('id',$request->folderid)->update([	
            'foldername'         =>     $request->foldername,
            'updated_at' => date('Y-m-d H:i:s')       
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
    public function ifclist($id)
    {
      //  dd($id);
        $assign = DB::table('ifcs')->where('assign_member',auth()->user()->teammember_id)->first();
        $ifcfolder = DB::table('ifcs')
        ->leftjoin('clients','clients.id','ifcs.client_id')
        ->leftjoin('ifcfolders','ifcfolders.id','ifcs.ifcfolder_id')
        ->where('ifcs.assign_member',auth()->user()->teammember_id)
        ->where('ifcs.client_id',$id)->select('ifcfolders.id','foldername')->distinct('foldername')->get();
       // dd($ifcfolder);
         return view('backEnd.ifcfolder.index',compact('ifcfolder'));
    }
    public function staffindex()
    {
        $ifcfolder = DB::table('ifcs')
        ->leftjoin('clients','clients.id','ifcs.client_id')
        ->where('ifcs.assign_member',auth()->user()->teammember_id)
        ->select('clients.id','clients.client_name')->distinct('clients.client_name')
->        get('ifcs.id');
      //  dd($ifcfolder);
         return view('backEnd.ifcfolder.clientifcfolderindex',compact('ifcfolder'));
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
  /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ifcfolder  $ifcfolder
     * @return \Illuminate\Http\Response
     */
    public function show(Ifcfolder $ifcfolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ifcfolder  $ifcfolder
     * @return \Illuminate\Http\Response
     */
    public function edit(Ifcfolder $ifcfolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ifcfolder  $ifcfolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ifcfolder $ifcfolder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ifcfolder  $ifcfolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ifcfolder $ifcfolder)
    {
        //
    }
}
