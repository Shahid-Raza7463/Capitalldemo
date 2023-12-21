<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Teammember;
use App\Models\Assignmentteammapping;
use App\Models\Criticalnote;
use Illuminate\Support\Facades\Mail;
use App\Models\Auditquestion;
use App\Models\Auditfile;
use App\Models\Checklistanswer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use DB;

class ChecklistanswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checklistAnswer_tag(Request $request)
    {
        // dd($request);
        //      $request->validate([
        //          'answer' => "required"
        //      ]);

        try {
            $data = $request->except(['_token']);
            $checklistanswer = Checklistanswer::where('audit_id', $request->audit_id)->where('steplist_id', $request->steplist_id)->where('subclassfied_id', $request->subclassfied_id)->where('financialstatemantclassfication_id', $request->financialstatemantclassfication_id)->where('assignment_id', $request->assignment_id)
                ->count();
            //   dd($checklistanswer);
            $statusname = Status::where('id', '1')->select('name')->pluck('name')->first();
            $auditname = Auditquestion::where('id', $request->audit_id)->select('auditprocedure')->pluck('auditprocedure')->first();
            $clientdname = DB::table('assignmentbudgetings')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')->where('assignmentbudgetings.assignmentgenerate_id', $request->assignment_id)
                ->select('clients.*')->first();
            if ($checklistanswer == 0) {


                // dd($files); die;
                $s = DB::table('auditfiles')->insert([
                    'refdocument' => $request->tagfile,
                    'assignmentgenerate_id' => $request->assignment_id,
                    'auditid' => $request->audit_id,
                    'createdby' => auth()->user()->teammember_id,
                    'created_at' => date('y-m-d'),
                    'updated_at' => date('y-m-d')
                ]);



                $checklistanswersid = DB::table('checklistanswers')->insertGetId([
                    'audit_id' => $request->audit_id,
                    'assignment_id' => $request->assignment_id,
                    'steplist_id' => $request->steplist_id,
                    'financialstatemantclassfication_id' => $request->financialstatemantclassfication_id,
                    'subclassfied_id' => $request->subclassfied_id,

                    'created_by' => auth()->user()->teammember_id,
                    'status' =>  '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);


                $id = auth()->user()->teammember_id;
                DB::table('audittrails')->insert([
                    'created_by' => $id,
                    'auditanswer_id' => $checklistanswersid,
                    'desc' => 'tagged file' . ' ( ' . $request->tagfile . ' ) ' . 'in this checklist',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $output = array('msg' => 'Tagged file Successfully');
                return back()->with('success', $output);
            } else {

                // dd($files); die;
                $s = DB::table('auditfiles')->insert([
                    'refdocument' => $request->tagfile,
                    'assignmentgenerate_id' => $request->assignment_id,
                    'auditid' => $request->audit_id,
                    'createdby' => auth()->user()->teammember_id,
                    'created_at' => date('y-m-d'),
                    'updated_at' => date('y-m-d')
                ]);
                DB::table('checklistanswers')->where('audit_id', $request->audit_id)->where('assignment_id', $request->assignment_id)->update([
                        'modify_by' => auth()->user()->teammember_id,
                        'audit_id' => $request->audit_id,
                        'assignment_id' => $request->assignment_id,
                        'steplist_id' => $request->steplist_id,
                        'financialstatemantclassfication_id' => $request->financialstatemantclassfication_id,
                        'subclassfied_id' => $request->subclassfied_id,

                        'created_by' => auth()->user()->teammember_id,
                        'status' =>  '1',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $ansid =  Checklistanswer::where('audit_id', $request->audit_id)->where('steplist_id', $request->steplist_id)->where('subclassfied_id', $request->subclassfied_id)->where('financialstatemantclassfication_id', $request->financialstatemantclassfication_id)->where('assignment_id', $request->assignment_id)
                    ->select('id')->pluck('id')->first();

                $id = auth()->user()->teammember_id;
                DB::table('audittrails')->insert([
                    'created_by' => $id,
                    'auditanswer_id' => $ansid,
                    'desc' => 'tagged file' . ' ( ' . $request->tagfile . ' ) ' . 'in this checklist',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                $output = array('msg' => 'tagged file Successfully');
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
    public function assignment_na(Request $request)
    {
        //dd($request);
        try {

            if ($request->ids == null) {
                return redirect()->back()->with('alert', 'Please tick one of the checkbox !');
            } else {
                $ch =  DB::table('auditquestions')
                    ->whereIn('id', $request->ids)
                    // ->where('steplist_id','=','80')
                    // ->where('subclassfied_id','=','81')
                    // ->where('financialstatemantclassfication_id','=','24')
                    ->get();


                //   dd($chs); die;
                if ($ch != null) {

                    foreach ($ch as $chvalue) {
                        $checklistanswers =   DB::table('checklistanswers')
                            ->where('audit_id', $chvalue->id)
                            ->where('steplist_id', $request->steplist_id)
                            ->where('subclassfied_id', $request->subclassfied_id)
                            ->where('financialstatemantclassfication_id', $request->financialid)
                            ->where('assignment_id', $request->assignment_id)
                            ->first();
                        //     dd($checklistanswers);
                        if ($checklistanswers ==  null) {
                            $ad = DB::table('checklistanswers')->insertGetid([
                                'steplist_id'         =>     $request->steplist_id,
                                'subclassfied_id'         =>     $request->subclassfied_id,
                                'assignment_id'         =>     $request->assignment_id,
                                'financialstatemantclassfication_id'         =>     $request->financialid,
                                'audit_id'         =>     $chvalue->id,
                                'status'         =>     $request->status,
                                'answer'         =>     'N/A',
                                'created_by' => auth()->user()->teammember_id,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

                            if (auth()->user()->role_id == 15) {
                                $status = "SUBMITTED";
                            } elseif (auth()->user()->role_id == 14) {
                                $status = "REVIEWED";
                            }
                            DB::table('audittrails')->insert([
                                'created_by' => auth()->user()->teammember_id,
                                'auditanswer_id' => $ad,
                                'desc' => $status . ' ' . 'this checklist',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                        } elseif ($checklistanswers !=  null) {

                            $checklistanswerss =   DB::table('checklistanswers')
                                ->where('audit_id', $chvalue->id)
                                ->where('steplist_id', $request->steplist_id)
                                ->where('subclassfied_id', $request->subclassfied_id)
                                ->where('financialstatemantclassfication_id', $request->financialid)
                                ->where('assignment_id', $request->assignment_id)
                                ->first();

                            //dd($checklistanswerss);
                            if (auth()->user()->role_id == 15) {
                                $status = "SUBMITTED";
                                DB::table('checklistanswers')
                                    ->where('audit_id', $chvalue->id)
                                    ->where('steplist_id', $request->steplist_id)
                                    ->where('subclassfied_id', $request->subclassfied_id)
                                    ->where('financialstatemantclassfication_id', $request->financialid)
                                    ->where('assignment_id', $request->assignment_id)->Update([
                                        'steplist_id'         =>     $request->steplist_id,
                                        'subclassfied_id'         =>     $request->subclassfied_id,
                                        'assignment_id'         =>     $request->assignment_id,
                                        'financialstatemantclassfication_id'         =>     $request->financialid,
                                        'audit_id'         =>     $chvalue->id,
                                        'status'         =>     $request->status,
                                        'answer'         =>     'N/A',
                                        'created_by' => auth()->user()->teammember_id,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s')
                                    ]);
                                DB::table('audittrails')->insert([
                                    'created_by' => auth()->user()->teammember_id,
                                    'auditanswer_id' => $checklistanswerss->id,
                                    'desc' => $status . ' ' . 'this checklist',
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            } elseif (auth()->user()->role_id == 14) {
                                $status = "REVIEWED";
                                DB::table('checklistanswers')
                                    ->where('audit_id', $chvalue->id)
                                    ->where('steplist_id', $request->steplist_id)
                                    ->where('subclassfied_id', $request->subclassfied_id)
                                    ->where('financialstatemantclassfication_id', $request->financialid)
                                    ->where('assignment_id', $request->assignment_id)->Update([
                                        'steplist_id'         =>     $request->steplist_id,
                                        'subclassfied_id'         =>     $request->subclassfied_id,
                                        'assignment_id'         =>     $request->assignment_id,
                                        'financialstatemantclassfication_id'         =>     $request->financialid,
                                        'audit_id'         =>     $chvalue->id,
                                        'status'         =>     $request->status,
                                        'created_by' => auth()->user()->teammember_id,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s')
                                    ]);
                                DB::table('audittrails')->insert([
                                    'created_by' => auth()->user()->teammember_id,
                                    'auditanswer_id' => $checklistanswerss->id,
                                    'desc' => $status . ' ' . 'this checklist',
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            }
                        }

                        //dd($ad);

                    }
                }
            }

            // $ch =  DB::table('checklistanswers')->where('steplist_id',$request->steplist_id)
            // ->where('subclassfied_id',$request->subclassfied_id)
            // ->where('financialstatemantclassfication_id',$request->financialid)
            // ->where('assignment_id',$request->assignment_id)->first();


            // else {
            //     DB::table('checklistanswers')->where('steplist_id',$request->steplist_id)
            //             ->where('subclassfied_id',$request->subclassfied_id)
            //             ->where('financialstatemantclassfication_id',$request->financialid)
            //             ->where('assignment_id',$request->assignment_id)->update([	
            //                 'status'         =>     null,
            //                 'created_by' => auth()->user()->teammember_id, 
            //                 'updated_at' => date('Y-m-d H:i:s')   
            //                  ]);
            // }


            //             $checklistanswersid =  DB::table('checklistanswers')->where('steplist_id',$request->steplist_id)
            //             ->where('subclassfied_id',$request->subclassfied_id)
            //             ->where('financialstatemantclassfication_id',$request->financialid)
            //             ->where('assignment_id',$request->assignment_id)->get();

            //         //  dd($checklistanswersid);

            //                foreach ($checklistanswersid as  $value) {
            // //dd($value);
            //                 DB::table('audittrails')->insert([
            //                     'created_by' => auth()->user()->teammember_id, 
            //                     'auditanswer_id' => $value->id, 
            //                       'desc' => 'Open this checklist', 
            //                     'created_at' => date('Y-m-d H:i:s'),       
            //                     'updated_at' => date('Y-m-d H:i:s')       
            //                 ]);

            //                }


            $output = array('msg' => 'Open Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function assignmentclosed(Request $request)
    {
        //dd($request);
        try {
            DB::table('checklistanswers')->where('steplist_id', $request->steplist_id)
                ->where('subclassfied_id', $request->subclassfied_id)
                ->where('financialstatemantclassfication_id', $request->financialid)
                ->where('assignment_id', $request->assignment_id)->update([
                    'status'         =>     '4',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            $checklistanswersid =  DB::table('checklistanswers')->where('steplist_id', $request->steplist_id)
                ->where('subclassfied_id', $request->subclassfied_id)
                ->where('financialstatemantclassfication_id', $request->financialid)
                ->where('assignment_id', $request->assignment_id)->get();

            //  dd($checklistanswersid);

            foreach ($checklistanswersid as  $value) {
                //dd($value);
                DB::table('audittrails')->insert([
                    'created_by' => auth()->user()->teammember_id,
                    'auditanswer_id' => $value->id,
                    'desc' => 'CLOSE this checklist',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            $output = array('msg' => 'Close Successfully');
            return back()->with('success', $output);
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
        //
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
    public function criticalNotesview(Request $request)
    {
        // dd($request); die;
        $auditchecklistAnswer =  DB::table('auditquestions')
            ->join('financialstatementclassifications', 'financialstatementclassifications.id', 'auditquestions.financialstatemantclassfication_id')
            ->join('subfinancialclassfications', 'subfinancialclassfications.id', 'auditquestions.subclassfied_id')
            ->join('steplists', 'steplists.id', 'auditquestions.steplist_id')
            ->where('auditquestions.id', $request->auditid)
            ->select(
                'auditquestions.*',
                'financialstatementclassifications.financial_name',
                'subfinancialclassfications.subclassficationname',
                'steplists.stepname'
            )
            ->first();
        // dd($auditchecklistAnswer);
        $assignmentgenerateid = $request->assignmentid;
        $criticalnotes = Criticalnote::where('assignmentgenerateid', $request->assignmentid)->where('auditquestionid', $request->auditid)->first();
        return view('backEnd.criticalnotes', compact('criticalnotes', 'auditchecklistAnswer', 'assignmentgenerateid'));
    }
    public function criticalNotes(Request $request)
    {
        //  dd($request);
        try {
            $data = $request->except(['_token']);
            $data['created_by'] = auth()->user()->teammember_id;
            Criticalnote::Create($data);

            $id = auth()->user()->teammember_id;
            DB::table('audittrails')->insert([
                'created_by' => $id,
                'auditanswer_id' => $request->auditquestionid,
                'desc' => 'created critical notes',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $output = array('msg' => 'Critical Notes Submit Successfully');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checklistAnswer(Request $request)
    {
        //  dd($request);
        $request->validate([
            'answer' => "required"
        ]);

        try {
            $data = $request->except(['_token']);
            $checklistanswer = Checklistanswer::where('audit_id', $request->audit_id)->where('steplist_id', $request->steplist_id)->where('subclassfied_id', $request->subclassfied_id)->where('financialstatemantclassfication_id', $request->financialstatemantclassfication_id)->where('assignment_id', $request->assignment_id)
                ->count();
            $statusname = Status::where('id', $request->status)->select('name')->pluck('name')->first();
            $auditname = Auditquestion::where('id', $request->audit_id)->select('auditprocedure')->pluck('auditprocedure')->first();
            $clientdname = DB::table('assignmentbudgetings')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')->where('assignmentbudgetings.assignmentgenerate_id', $request->assignment_id)
                ->select('clients.*')->first();
            if ($checklistanswer == 0) {


                $files = [];
                if ($request->hasFile('refdocument')) {
                    foreach ($request->file('refdocument') as $file) {
                        //  $destinationPath = 'backEnd/image/client/document';
                        //    $name = $file->getClientOriginalName();
                        //     $s = $file->move($destinationPath, $name);

                        //      $files[] = $name;
                        $name = time() . $file->getClientOriginalName();
                        $path = $file->storeAs($request->assignment_id, $name, 's3');
                        $files[] =   $name;
                    }
                }
                foreach ($files as $filess) {
                    // dd($files); die;
                    $s = DB::table('auditfiles')->insert([
                        'refdocument' => $filess,
                        'assignmentgenerate_id' => $request->assignment_id,
                        'auditid' => $request->audit_id,
                        'createdby' => auth()->user()->teammember_id,
                        'created_at' => date('y-m-d'),
                        'updated_at' => date('y-m-d')
                    ]);
                }


                $checklistanswersid = DB::table('checklistanswers')->insertGetId([
                    'audit_id' => $request->audit_id,
                    'assignment_id' => $request->assignment_id,
                    'steplist_id' => $request->steplist_id,
                    'financialstatemantclassfication_id' => $request->financialstatemantclassfication_id,
                    'subclassfied_id' => $request->subclassfied_id,
                    'answer' => $request->answer,
                    'checklist_note' => $request->checklist_note,
                    '_wysihtml5_mode' => $request->_wysihtml5_mode,
                    'created_by' => auth()->user()->teammember_id,
                    'status' =>  $request->status,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);


                $id = auth()->user()->teammember_id;
                DB::table('audittrails')->insert([
                    'created_by' => $id,
                    'auditanswer_id' => $checklistanswersid,
                    'desc' => $statusname . ' ' . 'this checklist',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $output = array('msg' => 'Create Successfully');
                return back()->with('success', $output);
            } else {
                $files = [];
                if ($request->hasFile('refdocument')) {
                    foreach ($request->file('refdocument') as $file) {
                        //  $destinationPath = 'backEnd/image/client/document';
                        //  $name = $file->getClientOriginalName();
                        // $s = $file->move($destinationPath, $name);

                        //  $files[] = $name;
                        $name = time() . $file->getClientOriginalName();
                        $path = $file->storeAs($request->assignment_id, $name, 's3');
                        $files[] =   $name;
                    }
                }
                foreach ($files as $filess) {
                    // dd($files); die;
                    $s = DB::table('auditfiles')->insert([
                        'refdocument' => $filess,
                        'assignmentgenerate_id' => $request->assignment_id,
                        'auditid' => $request->audit_id,
                        'createdby' => auth()->user()->teammember_id,
                        'created_at' => date('y-m-d'),
                        'updated_at' => date('y-m-d')
                    ]);
                }

                DB::table('checklistanswers')->where('audit_id', $request->audit_id)->where('assignment_id', $request->assignment_id)->update([
                        'audit_id' => $request->audit_id,
                        'steplist_id' => $request->steplist_id,
                        'financialstatemantclassfication_id' => $request->financialstatemantclassfication_id,
                        'subclassfied_id' => $request->subclassfied_id,
                        'answer' => $request->answer,
                        'checklist_note' => $request->checklist_note,
                        '_wysihtml5_mode' => $request->_wysihtml5_mode,
                        'modify_by' => auth()->user()->teammember_id,
                        'status' =>  $request->status,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $ansid =  Checklistanswer::where('audit_id', $request->audit_id)->where('steplist_id', $request->steplist_id)->where('subclassfied_id', $request->subclassfied_id)->where('financialstatemantclassfication_id', $request->financialstatemantclassfication_id)->where('assignment_id', $request->assignment_id)
                    ->select('id')->pluck('id')->first();

                $id = auth()->user()->teammember_id;
                DB::table('audittrails')->insert([
                    'created_by' => $id,
                    'auditanswer_id' => $ansid,
                    'desc' => $statusname . ' ' . 'this checklist',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                $output = array('msg' => 'Update Successfully');
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
     * @param  \App\Models\Checklistanswer  $checklistanswer
     * @return \Illuminate\Http\Response
     */
    public function assignmentList($id)
    {
        $teammember = Teammember::where('role_id', '=', 15)->orwhere('role_id', '=', 14)->with('title', 'role')->get();
        $assignmentList = DB::table('assignmentbudgetings')
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->leftjoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->where('assignmentbudgetings.assignmentgenerate_id', $id)
            ->select(
                'assignmentbudgetings.billingfrequency',
                'assignmentbudgetings.duedate',
                'assignmentbudgetings.billdate',
                'assignmentbudgetings.billlingamount',
                'assignmentbudgetings.finalreportdate',
                'assignmentbudgetings.draftreportdate',
                'assignmentbudgetings.moneyreceiveddate',
                'assignmentbudgetings.status',
                'assignmentmappings.*',
                'clients.client_name',
                'assignments.assignment_name',
                'assignmentteammappings.assignmentmapping_id'
            )->first();
        //dd($assignmentList);
        $teammemberDatas = DB::table('assignmentmappings')
            ->join('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->join('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
            ->where('assignmentmappings.assignmentgenerate_id', $id)
            ->select('teammembers.*', 'assignmentteammappings.type')
            ->get();
        //dd($teammemberDatas);
        $contactDatas = DB::table('assignmentbudgetings')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->join('clientcontacts', 'clientcontacts.client_id', 'clients.id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $id)
            ->select(
                'clientcontacts.*'
            )->get();
        $audittrail =  DB::table('checklistanswers')
            ->join('audittrails', 'audittrails.auditanswer_id', 'checklistanswers.audit_id')
            ->join('auditquestions', 'auditquestions.id', 'audittrails.auditanswer_id')
            ->join('teammembers', 'teammembers.id', 'audittrails.created_by')
            ->where('checklistanswers.assignment_id', $id)
            ->select(
                'teammembers.team_member',
                'auditquestions.auditprocedure',
                'audittrails.*'
            )->get();
        //dd($audittrail);
        $checklistfile = DB::table('auditfiles')
            ->join('auditquestions', 'auditquestions.id', 'auditfiles.auditid')
            ->join('teammembers', 'teammembers.id', 'auditfiles.createdby')
            ->join('roles', 'roles.id', 'teammembers.role_id')
            ->where('auditfiles.assignmentgenerate_id', $id)
            ->select(
                'auditfiles.*',
                'teammembers.team_member',
                'roles.rolename',
                'auditquestions.auditprocedure'
            )
            ->get();
        return view('backEnd.assignmentlist', compact('checklistfile', 'audittrail', 'teammember', 'assignmentList', 'teammemberDatas', 'contactDatas'));
    }
    public function teammappingUpdate(Request $request)
    {
        // dd($request);
        // $request->validate([
        //     'clientname' => 'required'
        // ]);

        try {
            $data = $request->except(['_token']);


            $previouscheck = DB::table('assignmentteammappings')
                ->where('assignmentmapping_id', $request->assignmentmapping_id)
                ->where('teammember_id', $request->teammember_id)
                ->first();
            if ($previouscheck != null) {
                $output = array('msg' => 'staff is already in team');
                return back()->with('success', $output);
            }

            Assignmentteammapping::Create($data);

            if ($previouscheck == null) {

                $assignmentmappingid = DB::table('assignmentmappings')->where('id', $request->assignmentmapping_id)->first();

                //dd($assignmentmappingid);

                $assignmentbudgetingid = DB::table('assignmentbudgetings')
                    ->where('assignmentgenerate_id', $assignmentmappingid->assignmentgenerate_id)->first();

                $clientname = DB::table('clients')->where('id', $assignmentbudgetingid->client_id)->select('client_name')->first();

                $assignmentnames = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $assignmentmappingid->assignmentgenerate_id)
                    ->select('assignmentname')->first();
                $teamemail = DB::table('teammembers')->where('id', $request->teammember_id)->select('emailid')->first();

                $data = array(
                    'assignmentid' =>  $assignmentmappingid->assignmentgenerate_id,
                    'clientname' =>  $clientname->client_name,
                    'assignmentname' =>  $assignmentnames->assignmentname,
                    'emailid' =>  $teamemail->emailid,


                );

                Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
                    $msg->to($data['emailid']);
                    $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
                });
            }

            $output = array('msg' => 'Team Add Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function show(Checklistanswer $checklistanswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checklistanswer  $checklistanswer
     * @return \Illuminate\Http\Response
     */
    public function edit(Checklistanswer $checklistanswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checklistanswer  $checklistanswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklistanswer $checklistanswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checklistanswer  $checklistanswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklistanswer $checklistanswer)
    {
        //
    }
}
