<?php

namespace App\Http\Controllers;
use App\Models\Teammember;
use App\Models\Articlefile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ArticlefileController extends Controller
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
	  public function zip($id)
    {
        $articlefiles = DB::table('articlefiles')->where('id',$id)->first();
         return response()->download(['backEnd/image/articlefiles/'.$articlefiles->document10th,'backEnd/image/articlefiles/'.$articlefiles->document12th]);
		  die;
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->document10th), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->document12th), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->bcomcertificate), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->agreement), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->additional), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->ipcccertificatetwo), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->noc), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->ipcccertificate), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->octrainingcertificate), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->itttrainingcertificate), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->residenceprooftwo), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->residenceproof), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->pancard), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->photograph), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->copyoftwo), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->copyof), null, [], null);
        return response()->download(('backEnd/image/articlefiles/'.$articlefiles->cptcertificate), null, [], null);
    }
    public function index()
    {
		if(auth()->user()->teammember_id == 434){
         $articlefilesDatas = DB::table('articlefiles')
        ->leftjoin('teammembers','teammembers.id','articlefiles.createdby')->select('articlefiles.*','teammembers.team_member')->get();
             return view('backEnd.articlefiles.index',compact('articlefilesDatas'));
    }
		elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 18){
         $articlefilesDatas = DB::table('articlefiles')
        ->leftjoin('teammembers','teammembers.id','articlefiles.createdby')->select('articlefiles.*','teammembers.team_member')->get();
             return view('backEnd.articlefiles.index',compact('articlefilesDatas'));
    }
		else
		{
			 $articlefilesDatas = DB::table('articlefiles')
        ->leftjoin('teammembers','teammembers.id','articlefiles.createdby')->
				 where('articlefiles.createdby',auth()->user()->teammember_id)->select('articlefiles.*','teammembers.team_member')->get();
             return view('backEnd.articlefiles.index',compact('articlefilesDatas'));
		}
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
        return view('backEnd.articlefiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // $request->validate([
        //     'Name' => "required",
        // ]);

        try {
            $data=$request->except(['_token']);
           if($request->hasFile('document10th'))
            {
                $file=$request->file('document10th');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['document10th'] = $name;
               
            }
           if($request->hasFile('document12th'))
            {
                $file=$request->file('document12th');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['document12th'] = $name;
               
            }
           if($request->hasFile('bcomcertificate'))
            {
                $file=$request->file('bcomcertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['bcomcertificate'] = $name;
               
            }
           if($request->hasFile('agreement'))
            {
                $file=$request->file('agreement');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['agreement'] = $name;
               
            }
           if($request->hasFile('additional'))
            {
                $file=$request->file('additional');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['additional'] = $name;
               
            }
           if($request->hasFile('ipcccertificatetwo'))
            {
                $file=$request->file('ipcccertificatetwo');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['ipcccertificatetwo'] = $name;
               
            }
           if($request->hasFile('noc'))
            {
                $file=$request->file('noc');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['noc'] = $name;
               
            }
           if($request->hasFile('ipcccertificate'))
            {
                $file=$request->file('ipcccertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['ipcccertificate'] = $name;
               
            }
           if($request->hasFile('octrainingcertificate'))
            {
                $file=$request->file('octrainingcertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['octrainingcertificate'] = $name;
               
            }
           if($request->hasFile('itttrainingcertificate'))
            {
                $file=$request->file('itttrainingcertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['itttrainingcertificate'] = $name;
               
            }
           if($request->hasFile('residenceproof'))
            {
                $file=$request->file('residenceproof');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['residenceproof'] = $name;
               
            }
           if($request->hasFile('residenceprooftwo'))
            {
                $file=$request->file('residenceprooftwo');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['residenceprooftwo'] = $name;
               
            }
           if($request->hasFile('pancard'))
            {
                $file=$request->file('pancard');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['pancard'] = $name;
               
            }
           if($request->hasFile('photograph'))
            {
                $file=$request->file('photograph');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['photograph'] = $name;
               
            }
			 if($request->hasFile('copyoftwo'))
            {
                $file=$request->file('copyoftwo');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['copyoftwo'] = $name;
               
            }
           if($request->hasFile('copyof'))
            {
                $file=$request->file('copyof');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['copyof'] = $name;
               
            }
           if($request->hasFile('cptcertificate'))
            {
                $file=$request->file('cptcertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['cptcertificate'] = $name;
               
            }
            $data['createdby'] = auth()->user()->teammember_id;
            Articlefile::Create($data);
     
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
     * @param  \App\Models\articlefiles  $articlefiles
     * @return \Illuminate\Http\Response
     */
    public function show(articlefiles $articlefiles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\articlefiles  $articlefiles
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
	  $articlefiles = Articlefile::where('id', $id)->first();
        return view('backEnd.articlefiles.edit', compact('id','articlefiles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\articlefiles  $articlefiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'Name' => "required",
        // ]);
        try {
            $data=$request->except(['_token']);
            if($request->hasFile('document10th'))
            {
                $file=$request->file('document10th');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['document10th'] = $name;
               
            }
           if($request->hasFile('document12th'))
            {
                $file=$request->file('document12th');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['document12th'] = $name;
               
            }
           if($request->hasFile('bcomcertificate'))
            {
                $file=$request->file('bcomcertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['bcomcertificate'] = $name;
               
            }
           if($request->hasFile('agreement'))
            {
                $file=$request->file('agreement');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['agreement'] = $name;
               
            }
           if($request->hasFile('additional'))
            {
                $file=$request->file('additional');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['additional'] = $name;
               
            }
           if($request->hasFile('ipcccertificatetwo'))
            {
                $file=$request->file('ipcccertificatetwo');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['ipcccertificatetwo'] = $name;
               
            }
           if($request->hasFile('noc'))
            {
                $file=$request->file('noc');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['noc'] = $name;
               
            }
           if($request->hasFile('ipcccertificate'))
            {
                $file=$request->file('ipcccertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['ipcccertificate'] = $name;
               
            }
           if($request->hasFile('octrainingcertificate'))
            {
                $file=$request->file('octrainingcertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['octrainingcertificate'] = $name;
               
            }
           if($request->hasFile('itttrainingcertificate'))
            {
                $file=$request->file('itttrainingcertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['itttrainingcertificate'] = $name;
               
            }
           if($request->hasFile('residenceproof'))
            {
                $file=$request->file('residenceproof');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['residenceproof'] = $name;
               
            }
           if($request->hasFile('residenceprooftwo'))
            {
                $file=$request->file('residenceprooftwo');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['residenceprooftwo'] = $name;
               
            }
           if($request->hasFile('pancard'))
            {
                $file=$request->file('pancard');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['pancard'] = $name;
               
            }
           if($request->hasFile('photograph'))
            {
                $file=$request->file('photograph');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['photograph'] = $name;
               
            }
			 if($request->hasFile('copyoftwo'))
            {
                $file=$request->file('copyoftwo');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['copyoftwo'] = $name;
               
            }
           if($request->hasFile('copyof'))
            {
                $file=$request->file('copyof');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['copyof'] = $name;
               
            }
           if($request->hasFile('cptcertificate'))
            {
                $file=$request->file('cptcertificate');
                    $destinationPath = 'backEnd/image/articlefiles';
                    $name = auth()->user()->teammember_id.$file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
                         $data['cptcertificate'] = $name;
               
            }
            $data['createdby'] = auth()->user()->teammember_id;
            Articlefile::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('articlefiles')->with('success', $output);
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
     * @param  \App\Models\articlefiles  $articlefiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(articlefiles $articlefiles)
    {
        //
    }
}
