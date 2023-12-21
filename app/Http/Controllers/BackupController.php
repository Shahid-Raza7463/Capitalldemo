<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Artisan;
use File;
class BackupController extends Controller
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
        try {
if(auth()->user()->role_id == 11){
            $dirNames = array();   
            $files = File::allFiles(storage_path('/app/kgsomani')); 
    
            foreach( $files as $file ) {
    
                $dirNames[] =array( 'fileName' => $file->getRelativePathname(), 'fileUrl' => storage_path('/app/Laravel'.$file->getRelativePathname() ));
    
            }
    
           // dd($dirNames);
    
            return view('backEnd.backup.index', compact('dirNames'));
}
else{
    abort(403, 'You dont have permission to access this page.');
}
        } catch ( Exception $ex ) {
            Log::error( $ex->getMessage() );
        }
    }
    public function getFiles($file ) {

        $path = storage_path('/app/kgsomani/'.$file);
        return response()->download($path);
        
        
        }
    public function dbBackup () {
        
        $exitCode = Artisan::call('backup:run --only-db'); 
        
       // dd($exitCode);
    return  redirect('backup');
    
       
        // return what you want
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.backup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backEnd\backup  $backup
     * @return \Illuminate\Http\Response
     */
    public function show(backup $backup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backEnd\backup  $backup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\backEnd\backup  $backup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backEnd\backup  $backup
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
      
    }
}
