<?php
namespace App\Http\Controllers;
use App\imports\Informationresourceimport;
use App\Models\Informationresource;
use App\Models\Staffassign;
use Illuminate\Http\Request;
use App\Models\Ilrfolder;
use App\Models\Ilranswer;
use DB;
use Crypt;
use Excel;
class StaffassignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	 public function staffassignStore(Request $request)
    
    { 
                try {          
            if($request->assign[0] != null){
            foreach ($request->assign as $assign ) 
            {
             DB::table('staffassigns')->insert([	
                 'client_id'         =>     $request->client_id, 
                'staff_id'         => $assign,
                'createdby' => auth()->user()->teammember_id, 
                // 'createdby'         => $assigns,
                'created_at'			    =>	   date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
                ]);  
            }
        }
            $output = array('msg' => 'Assigned Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

	 public function index($id)
 {
       $clientsDatas  = DB::table('clients')->where('id',$id)->get();
        return view('backEnd.clientstaffassign.staffassignlist',compact('clientsDatas','id'));
    }
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function __construct()
    {
        $this->middleware('auth');
    }
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
     * @param  \App\Models\Informationresource  $informationresource
     * @return \Illuminate\Http\Response
     */
    public function show(Informationresource $informationresource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Informationresource  $informationresource
     * @return \Illuminate\Http\Response
     */

}
