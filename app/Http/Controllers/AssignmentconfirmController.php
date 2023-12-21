<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
class AssignmentconfirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function teamConfirm(Request $request)
    {
      //  dd($request);
        if($request->status == 1){
            $assignmentDatas = DB::table('assignmentteammappings')
            ->where('teammember_id',$request->teammemberid)->
            where('assignmentmapping_id',$request->assignmentmappingid)->update([ 
                'status'         => $request->status ,
                'updated_at'         =>   date("Y-m-d")
                ]);
           
            return view('backEnd.teamconfirm');
        }
        else {
            $assignmentDatas = DB::table('assignmentteammappings')
            ->where('teammember_id',$request->teammemberid)->
            where('assignmentmapping_id',$request->assignmentmappingid)->update([ 
                'status'         => $request->status ,
                'updated_at'         =>   date("Y-m-d")
                ]);
           
            return view('backEnd.teamreject');
        }
       
    }
    public function debtorconfirm(Request $request)
    {
     //   dd($request);
        if($request->status == 1){
            $assignmentDatas = DB::table('debtors')
            ->where('client_id',$request->clientid)->
            where('id',$request->debtorid)->update([ 
                'status'         => $request->status ,
                'updated_at'         =>   date("Y-m-d")
                ]);
           
            return view('backEnd.teamconfirm');
        }
        else {
            $assignmentDatas = DB::table('debtors')
            ->where('client_id',$request->clientid)->
            where('id',$request->debtorid)->update([ 
                'status'         => $request->status ,
                'updated_at'         =>   date("Y-m-d")
                ]);
           $status = DB::table('debtors')
           ->where('client_id',$request->clientid)->
           where('id',$request->debtorid)->pluck('type')->first();
           $debtorconfirm = DB::table('debtorconfirmations')
           ->where('client_id',$request->clientid)->
           where('debtor_id',$request->debtorid)->first();
			//dd($debtorconfirm);
           $clientid = $request->clientid;
           $debtorid = $request->debtorid;
            return view('backEnd.teamreject',compact('status','clientid','debtorid','debtorconfirm'));
        }
       
    }
    public function confirmationConfirm(Request $request)
    {
        $request->validate([
            'amount' => "required",
            'remark' => "required|string"
        ]);

        try {
            $debtorconfirm = DB::table('debtors')
            ->where('client_id',$request->clientid)->
            where('id',$request->debtorid)->first();

            if($request->hasFile('file'))
            {
                $file=$request->file('file');
                    $destinationPath =  storage_path('app/backEnd/image/confirmationfile');
                    $name = $file->getClientOriginalName();
                   $s = $file->move($destinationPath, $name);
                         $data['file'] = $name;
               
            }
            DB::table('debtorconfirmations')->insert([ 
                'debtor_id'         => $request->debtorid ,
                'client_id'         => $request->clientid ,
                'remark'         => $request->remark ,
                'amount'         => $request->amount ,
                'file'         =>  $data['file'] ??'' ,
                'name'         =>  $debtorconfirm->name,
                'created_at'         =>   date("Y-m-d"),
                'updated_at'         =>   date("Y-m-d")
                ]);
			
            $output = array('msg' => 'Submit Successfully');
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
