<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Mis;
use App\Models\Missubmit;
use Illuminate\Http\Request;
use DB;
use Image;
class AdminmisController extends Controller
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
	 public function delete($id)
    { 
      //  dd($id);
        try {
			$user = DB::table('mis')->where('id',$id)->first();
               DB::table('mis')->where('id',$id)->update([	
                'status'         =>     4,
                 ]);
          
      $output = array('msg' => 'Deleted Successfully');
            return redirect('viewmis/'.$user->client_id)->with('statuss', $output);
    
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
    public function viewMis($id)
    {
     //   dd($id);
        $misLists = Mis::where('client_id',$id)->get();
        return view('backEnd.mis.index',compact('misLists'));
    }
    public function viewUpdate($id)
    {
      //  dd($id);
        $mis =    $mis = Mis::with('misphoto','clientlogin')->where('sno',$id)->first();
      //  dd($mis);
        $misLists = Missubmit::with('misphoto','clientlogin','teammemberlogin')->where('missno',$id)->get();
       // dd($misLists);
        return view('backEnd.mis.create',compact('misLists','mis','id'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function misUpdate(Request $request)
    { 
      
        $request->validate([
            'remark' => "required",
        ]);

        try {
            $misc = DB::table('missubmits')->where('missno',$request->missno)->orderBy('id', 'DESC')->first();
           //dd($misc);
            if($misc == null){
                $x = 'A';
                   $x = $request->missno.$x;
               }
               else {
               $x = $misc->serailno;
               $x++;
           //  dd($x);
               }
           
            $data=$request->except(['_token','attachment']);

            $data['createdby'] = auth()->user()->teammember_id;
            $data['updatedby'] = auth()->user()->teammember_id;
            $data['submissiondate'] =   date('y-m-d');
               $data['serailno']    =    $x;
           $mis =  Missubmit::Create($data);
           $mis->save();
           $misid = $mis->id;
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
                    'missubmit_id' => $misid, 
                    'attachment' => $filess,
                     'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')            
                ]);      
            }
           DB::table('mis')->where('sno', $request->missno)->update([          
             	
            'status'         => 1,
            'updated_at'              =>    date('y-m-d'),
            ]);
            $pictureno =   DB::table('mis')->where('sno',$request->missno)->first();
         //   dd($pictureno);
        $data = array(
            'pictureno' =>  $pictureno->pictureno,
            'remark' =>  $request->remark,
            'clientid' =>  $pictureno->client_id,

       );
      
        Mail::send('emails.photosubmmit', $data, function ($msg) use($data){
            $msg->to('lisa@brickandbatten.com');
            $msg->subject('Kgs MIS Photoshop');
			$msg->cc('kristen@brickandbatten.com');
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
