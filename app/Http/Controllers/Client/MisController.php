<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Mis;
use App\Models\Misphoto;
use App\Models\Missubmit;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use DB;
use Image;
class MisController extends Controller
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
        $misLists = Mis::latest()->get();
        return view('client.mis.index',compact('misLists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.mis.create');
    }
  public function delete($id)
    { 
      //  dd($id);
        try {
               DB::table('mis')->where('id',$id)->update([	
                'status'         =>     4,
                 ]);
          
      $output = array('msg' => 'Deleted Successfully');
            return redirect('client/mis')->with('statuss', $output);
    
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewUpdate($id)
    {
     //   dd($id);
        $mis = Mis::with('misphoto','clientlogin')->where('sno',$id)->first();
      //  dd($mis);
        $misLists = Missubmit::with('misphoto','clientlogin','teammemberlogin')->where('missubmits.missno',$id)->get();
  //  dd($misLists);
        return view('client.mis.view',compact('misLists','mis','id'));
    }
	 public function imageModal(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $mis = Misphoto::where('id',$request->id)->first();
 
                return response()->json($mis);
             }
            }
    
    }
    public function misUpdate(Request $request)
    { 
        $request->validate([
            'status' => "required",
        ]);

        try {
           
           $misc = DB::table('missubmits')->where('missno',$request->missno)->orderBy('id', 'DESC')->first();
           $files = [];
           if($request->hasFile('clientattachment'))
           {
               foreach ($request->file('clientattachment') as $file) {
				   
                    $imageExtensions = ['jpg', 'jpeg', 'gif', 'png','svg', 'svgz','JPG','PNG'];

                    $extension = $file->getClientOriginalExtension();
                    
                    if(in_array($extension, $imageExtensions)){
                                        $destinationPath = 'backEnd/image/compressmis';
                                        $name = $file->getClientOriginalName();
                                        Image::make($file)->resize(300, 300)->save('backEnd/image/compressmis/' .$name);
                                 //       $files[] = $name;
                        
                                        }
				   
                   $destinationPath = 'backEnd/image/mis';
                   $name = $file->getClientOriginalName();
                  $s = $file->move($destinationPath, $name);
                        //  dd($s); die;
                   $files[] = $name;
                   // $data['url'] = $name;
                
               }
           }
           foreach($files as $filess )
           {
          // dd($files); die;
              $s = DB::table('misphotos')->insert([
                   'missubmit_id' => $misc->id, 
                   'clientattachment' => $filess,
                    'created_at' => date('Y-m-d H:i:s'), 
                   'updated_at' => date('Y-m-d H:i:s')            
               ]);      
           }
           
           DB::table('missubmits')->where('id',$misc->id)->update([	
                'status'         =>     $request->status,
                'remarks'         =>     $request->remarks,
                'clientloginid'         =>     auth()->user()->id
                 ]);
            DB::table('mis')->where('sno',$request->missno)->update([	
                'status'         =>     $request->status,
                 ]);
             if($request->status == 2)
            {
           $pictureno =   DB::table('mis')->where('sno',$misc->missno)->first();
				// dd($pictureno);
            $data = array(
                'pictureno' =>  $pictureno->pictureno,
                'remarks' =>  $request->remarks,
    
           );
          
            Mail::send('emails.photoresubmmit', $data, function ($msg) use($data){
                $msg->to('bnb@kgsadvisors.com');
               $msg->subject('Kgs MIS Photoshop');
            });
           }
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
    public function store(Request $request)
    { 
     //   dd($request);
        $request->validate([
            'attachment' => "required",
        ]);

        try {
            $data=$request->except(['_token','attachment']);
            $data['createdby'] = auth()->user()->id;
            $data['client_id'] = auth()->user()->client_id;
            $data['status'] = 0;
         //   $data['pictureno'] = mt_rand(100000000000, 999999999999);
			 $data['submitdate'] =   date('y-m-d');
           $mis = Mis::Create($data);
            $mis->save();
            $id = $mis->id;
            $files = [];
            if($request->hasFile('attachment'))
            {
                foreach ($request->file('attachment') as $file) {
					
					
                    $imageExtensions = ['jpg', 'jpeg', 'gif', 'png','svg', 'svgz','JPG','PNG'];

                    $extension = $file->getClientOriginalExtension();
                    
                    if(in_array($extension, $imageExtensions)){
                                        $destinationPath = 'backEnd/image/compressmis';
                                        $name = $file->getClientOriginalName();
                                        Image::make($file)->resize(300, 300)->save('backEnd/image/compressmis/' .$name);
                                 //       $files[] = $name;
                        
                                        }
					
                    $destinationPath = 'backEnd/image/mis';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                    $files[] = $name;
                    // $data['url'] = $name;
                 
                }
            }
            foreach($files as $filess )
            {
           // dd($files); die;
               $s = DB::table('misphotos')->insert([
                    'mis_id' => $id, 
                    'attachment' => $filess,
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);      
            }
            DB::table('mis')->where('id',$id)->update([	
                'sno'         =>     $id+100,
                 ]);
			  $data = array(
                    'pictureno' =>  $request->pictureno,
                    'instruction' =>  $request->instruction,
        
               );
              
                Mail::send('emails.photoassign', $data, function ($msg) use($data){
                    $msg->to('bnb@kgsadvisors.com');
                    $msg->subject('Kgs MIS Photoshop');
                 });
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mis  $mis
     * @return \Illuminate\Http\Response
     */
    public function show(Mis $mis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mis  $mis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mis = Mis::where('id',$id)->first();
        return view('client.mis.edit',compact('mis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mis  $mis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $request->validate([
            'sno' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
        if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                    $destinationPath = 'backEnd/image/mis';
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['attachment'] = $name;
               
            }
            $data['createdby'] = auth()->user()->id;
            $data['client_id'] = auth()->user()->client_id;
            $data['status'] = 0;
            Mis::find($id)->update($data);
			
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mis  $mis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mis $mis)
    {
        //
    }
}
