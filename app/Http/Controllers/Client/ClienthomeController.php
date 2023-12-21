<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Artisan;
use App\Models\Mis;
use App\Models\Ilrfolder;
use App\Models\Clientfolder;
use DB;
use Hash;
use Crypt;
class ClienthomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()   
    {
        $this->middleware('auth:clientlogin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	 public function switchaccount($id)
    {
      
        DB::table('clientlogins')->where('id',auth()->user()->id)->update([ 
            'client_id'         =>  $id ,
            'updated_at'         =>  date("Y-m-d") 
            ]);
            return redirect('client/home');
    }
  public function resetPassword($id)
    {
        $id=  Crypt::decrypt($id); 
        $clientlogin = DB::table('clientlogins')->where('id', $id)->first();
        return view('client.clientfile.resetpassword', compact('id', 'clientlogin'));
    }
    public function passwordUpdate(Request $request, $id = '')
    {
       //  dd($id);
          $request->validate([
              'password' => 'required',
              'confirm_password' => 'required|same:password|min:8',
          ]);
  
          try {
              $date = date("Y-m-d") ;
          
              DB::table('clientlogins')->where('id',$id)->update([ 
                  'password'         =>  Hash::make($request->password) ,
                  'updated_at'         =>  $date
                  ]);
                  $output = array('msg' => 'Password Updated Successfully');
                  return redirect('client/home')->with('success', $output);
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
        $assigncheck = DB::table('ilrfolderassigns')->where('client_id',auth()->user()->client_id)
     ->where('clientlogin_id',auth()->user()->id)->first();
   if(auth()->user()->client_id == 72 && $assigncheck != null)
       {
        $ilrfolder = DB::table('ilrfolderassigns')
        ->leftjoin('ilrfolders','ilrfolders.id','ilrfolderassigns.ilrfolder_id')->
        where('ilrfolderassigns.client_id',auth()->user()->client_id)->where('ilrfolderassigns.clientlogin_id',auth()->user()->id)
        ->select('ilrfolders.*')->get();
//dd($ilrfolder);
        return view('client.information.assignfolderlist',compact('ilrfolder'));
       }
       elseif(auth()->user()->client_id == 72)
       {
        $ilrfolder = Ilrfolder::with('ilr','ilrsubfolder')->where('client_id',auth()->user()->client_id)->where('parent_id',null)->get();
		return view('client.information.folderlist',compact('ilrfolder'));
       }
	     elseif(auth()->user()->client_id == 95)
       {
       $misLists = Mis::latest()->get();
        return view('client.mis.index',compact('misLists'));
       }
       else{
        $clientfolder = DB::table('clientfolders')->where('client_id', auth()->user()->client_id)->get();
        return view('client.clientfile.clientindex',compact('clientfolder'));
       }
       
    }
        public function fileList()
    {
       $filelist = DB::table('clientfiles')
       ->join('teammembers','teammembers.id','clientfiles.createdby')
       ->where('client_id',auth()->user()->client_id)
       ->select('teammembers.team_member','clientfiles.*')->get();
        return view('client.clientfile.filelist',compact('filelist'));
    }
    public function folderList($id)
    {
		 $clientfolder = DB::table('clientfolders')->where('client_id',auth()->user()->client_id)->where('id',$id)->first();
        $clientfile = DB::table('clientfiles')->where('clientfolder_id',$id)->where('client_id', auth()->user()->client_id)->get();
        return view('client.clientfile.clientfolderlist',compact('clientfile','id','clientfolder'));
    }
    public function folderStore(Request $request)
    
    { 
        $request->validate([
            'name' => "required"
        ]);

        try {
            $data=$request->except(['_token']);
            $data['client_id'] = auth()->user()->client_id;
            $data['clientlogin_id'] = auth()->user()->id;
            Clientfolder::Create($data);
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
    public function clientFile()
    {
        $clientfile = DB::table('clientfiles')->latest()->get();
        return view('client.clientfile.clientindex',compact('clientfile'));
    }
    public function getFile($id)
    {
        
        $clientfile = DB::table('clientfiles')->where('id',$id)->pluck('file')->first();
        return response()->download(storage_path('app/backEnd/image/clientfile/'.$clientfile), null, [], null);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
             'file' => 'required',
        ]);

        try {
            $data=$request->except(['_token']);
            $files = [];
            if($request->hasFile('file'))
            {
                foreach ($request->file('file') as $file) {
					 $name = $file->getClientOriginalName();
                //    $destinationPath = storage_path('app/backEnd/image/clientfile');
                 //   $name = $file->getClientOriginalName();
                 //  $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
					  $path = $file->storeAs('clientdocument',$name,'s3');
                    $files[] = $name;
                 
                }
            }
            foreach($files as $filess )
            {
           // dd($files); die;
               $s = DB::table('clientfiles')->insert([
                    'name' => $request->name, 
                    'clientfolder_id' => $request->rid, 
                    'client_id' =>  auth()->user()->client_id, 
                    'clientlogin_id' =>  auth()->user()->id, 
                    'file' => $filess, 
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);  
            
            }
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
    public function scheduler () {
        
        $exitCode = Artisan::call('command:reminder'); 
        $exitCode = Artisan::call('command:taskreminder'); 
        
        
    return  redirect('/');
    
       //  dd($exitCode);
        // return what you want
    }
	public function folderListDelete ($id = '')
    {
        try {
            DB::table('clientfiles')->delete($id);
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
    public function folderListRequest ($id = '')
    {
      //  dd($id);
        try {
            DB::table('clientfiles')->where('id',$id)->update([	
                'rqstdelete'         =>     0, 
                 ]);
            $output = array('msg' => 'Your request has been sent to administrator');
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
