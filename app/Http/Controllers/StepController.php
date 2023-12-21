<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Support\Facades\Mail;
use App\Models\Assignmentteammapping;
use App\Models\Assignmentmapping;
use App\Models\Auditquestion;
use App\Models\Subfinancialclassfication;
use App\Models\Financialstatementclassification;
use App\Models\Steplist;
use App\Models\Client;
use App\Models\Tab;
use App\Models\Assignmentbudgeting;
use App\Models\Checklistanswer;
use Illuminate\Http\Request;
use App\imports\Stepchecklistimport;
use Maatwebsite\Excel\HeadingRowImport;
use Excel;
use DB;
use Image;

class StepController extends Controller
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
    public function deleteassignmentChecklist($id = '')
    {
        try {
            DB::table('financialstatementclassifications')->where([

                'assignment_id'   =>   $id,

            ])->delete();
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
    public function auditchecklistAnswer(Request $request)
    {
        // dd($request);
        $auditchecklistAnswer =  DB::table('auditquestions')
            ->leftjoin('financialstatementclassifications', 'financialstatementclassifications.id', 'auditquestions.financialstatemantclassfication_id')
            ->leftjoin('subfinancialclassfications', 'subfinancialclassfications.id', 'auditquestions.subclassfied_id')
            ->leftjoin('steplists', 'steplists.id', 'auditquestions.steplist_id')
            ->where('auditquestions.id', $request->auditid)
            ->select(
                'auditquestions.*',
                'financialstatementclassifications.financial_name',
                'subfinancialclassfications.subclassficationname',
                'steplists.stepname'
            )
            ->first();
        //  dd($auditchecklistAnswer);
        $checklistanswer = DB::table('checklistanswers')
            ->where('audit_id', $request->auditid)
            ->where('assignment_id', $request->assignmentid)
            ->select(
                'checklistanswers.*'
            )
            ->first();
        //   dd($checklistanswer);

        $checklistfile = DB::table('auditfiles')
            ->join('teammembers', 'teammembers.id', 'auditfiles.createdby')
            ->join('roles', 'roles.id', 'teammembers.role_id')
            ->where('auditfiles.auditid', $request->auditid)
            ->where('auditfiles.assignmentgenerate_id', $request->assignmentid)
            ->select(
                'auditfiles.*',
                'teammembers.team_member',
                'roles.rolename'
            )
            ->get();
        // dd($checklistfile);
        $checklistanswerid = Checklistanswer::where('audit_id', $request->auditid)
            ->where('assignment_id', $request->assignmentid)->select('id')->pluck('id')->first();

        $checklistanswertrail = DB::table('audittrails')
            ->join('teammembers', 'teammembers.id', 'audittrails.created_by')

            ->where('audittrails.auditanswer_id', $checklistanswerid)
            ->select(
                'audittrails.*',
                'teammembers.team_member'
            )->orderBy('id', 'DESC')->get();
        // dd($checklistanswertrail);
        $assignmentgenerateid = $request->assignmentid;
        $authteamid = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->where('type', 2)->select('teammember_id')->pluck('teammember_id')->first();
        $authteamtl = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->where('type', 0)->select('teammember_id')->pluck('teammember_id')->first();
        // dd($authteamtl);
        $authpartnerid = DB::table('assignmentmappings')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignmentid)
            ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
            ->select('assignmentmappings.leadpartner')->pluck('assignmentmappings.leadpartner')->first();
        $financial =  DB::table('assignmentbudgetings')
            ->leftjoin('financialstatementclassifications', 'financialstatementclassifications.assignment_id', 'assignmentbudgetings.assignment_id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $request->assignmentid)
            ->select('financialstatementclassifications.id', 'financialstatementclassifications.financial_name')
            ->get();

        $assignmentbudgeting = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $assignmentgenerateid)->first();
        //dd($authpartnerid);
        return view('backEnd.auditchecklistanswer', compact('assignmentbudgeting', 'checklistfile', 'financial', 'authpartnerid', 'authteamtl', 'authteamid', 'checklistanswertrail', 'auditchecklistAnswer', 'checklistanswer', 'assignmentgenerateid'));
    }
    public function index()
    {
        $stepDatas = DB::table('assignments')
            ->leftjoin('financialstatementclassifications', 'financialstatementclassifications.assignment_id', 'assignments.id')
            ->leftjoin('auditquestions', 'auditquestions.financialstatemantclassfication_id', 'financialstatementclassifications.id')
            ->leftjoin('subfinancialclassfications', 'subfinancialclassfications.id', 'auditquestions.subclassfied_id')
            ->leftjoin('steplists', 'steplists.id', 'auditquestions.steplist_id')

            ->select(
                'assignments.assignment_name',
                'financialstatementclassifications.financial_name',
                'subfinancialclassfications.subclassficationname',
                'steplists.*',
                'auditquestions.auditprocedure'
            )
            ->get();
        //dd($stepDatas);
        return view('backEnd.step.index', compact('stepDatas'));
    }
    public function checkList($id)
    {
        //dd($id);
        $stepDatas = DB::table('assignments')
            ->leftjoin('financialstatementclassifications', 'financialstatementclassifications.assignment_id', 'assignments.id')
            ->leftjoin('auditquestions', 'auditquestions.financialstatemantclassfication_id', 'financialstatementclassifications.id')
            ->leftjoin('subfinancialclassfications', 'subfinancialclassfications.id', 'auditquestions.subclassfied_id')
            ->leftjoin('steplists', 'steplists.id', 'auditquestions.steplist_id')
            ->where('financialstatementclassifications.assignment_id', $id)
            ->where('auditquestions.assignmentgenerate_id', null)
            ->select(
                'assignments.assignment_name',
                'financialstatementclassifications.financial_name',
                'subfinancialclassfications.subclassficationname',
                'steplists.*',
                'auditquestions.auditprocedure'

            )
            ->get();
        //  dd($stepDatas);
        $assignmentname = Assignment::where('id', $id)->first();
        $dlt = Assignmentmapping::where('assignment_id', $id)->first();
        return view('backEnd.step.checklistindex', compact('stepDatas', 'assignmentname', 'dlt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //!  old code 
    // public function viewAssignment($id)
    // {
    //     // dd($id);
    //     //$id = str_replace('e6Qui4C3e4e2e2fEDq', '', $id);
    //     //  dd($string);
    //     $assignmentid = Assignmentmapping::where('assignmentgenerate_id', $id)->select('assignment_id')->pluck('assignment_id')->first();
    //     // dd($assignmentgenerateid); 
    //     $assignmentcheck =
    //         DB::table('financialstatementclassifications')
    //         ->where('assignmentgenerate_id', $id)
    //         ->get();

    //     if ($assignmentcheck->isEmpty()) {
    //         $assignmentcheckDatas =
    //             DB::table('financialstatementclassifications')
    //             ->where('assignment_id', $assignmentid)
    //             ->where('assignmentgenerate_id', null)
    //             ->get();
    //         //dd($assignmentcheckDatas);
    //     } else {
    //         $assignmentcheckDatas =
    //             DB::table('financialstatementclassifications')
    //             ->where('assignment_id', $assignmentid)
    //             ->where('assignmentgenerate_id', null)
    //             ->orwhere('assignmentgenerate_id',  $id)
    //             ->get();
    //     }

    //     //  dd($assignmentcheckDatas);

    //     // $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
    //     //     ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //     //     ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
    //     //     ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
    //     //     ->where('assignmentbudgetings.assignmentgenerate_id', $id)
    //     //     ->select(
    //     //         'assignmentbudgetings.*',
    //     //         'assignmentmappings.*',
    //     //         'clients.client_name',
    //     //         'assignments.assignment_name'
    //     //     )->first();
    //     // dd($assignmentbudgetingDatas);

    //     $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
    //         ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //         ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
    //         ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
    //         ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //         ->where('assignmentbudgetings.assignmentgenerate_id', $id)
    //         ->select(
    //             'assignmentbudgetings.*',
    //             'assignmentmappings.*',
    //             'clients.client_name',
    //             'assignmentteammappings.type',
    //             'assignments.assignment_name'
    //         )->first();
    //     // dd($assignmentbudgetingDatas);
    //     $teammemberDatas = DB::table('assignmentmappings')
    //         ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //         ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
    //         ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
    //         ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->where('assignmentmappings.assignmentgenerate_id', $id)
    //         ->select('teammembers.*', 'roles.rolename', 'assignmentteammappings.type', 'titles.title')->get();
    //     //dd($teammemberDatas);
    //     $contactDatas = DB::table('assignmentbudgetings')
    //         ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //         ->join('clientcontacts', 'clientcontacts.client_id', 'clients.id')
    //         ->where('assignmentbudgetings.assignmentgenerate_id', $id)
    //         ->select(
    //             'clientcontacts.*'
    //         )->get();
    //     $udinDatas = DB::table('assignmentbudgetingudins')
    //         ->join('teammembers', 'teammembers.id', 'assignmentbudgetingudins.created_by')
    //         ->join('roles', 'roles.id', 'teammembers.role_id')
    //         ->where('assignmentbudgetingudins.assignment_generate_id', $id)
    //         ->select('teammembers.*', 'assignmentbudgetingudins.udin', 'roles.rolename', 'assignmentbudgetingudins.partner', 'assignmentbudgetingudins.created_at as created')->get();
    //     // dd($contactDatas);

    //     $leadpartner = DB::table('assignmentmappings')
    //         ->join('teammembers as team', 'team.id', 'assignmentmappings.leadpartner')
    //         ->where('assignmentmappings.assignmentgenerate_id', $id)
    //         ->select('team.id', 'team.team_member')
    //         ->get();

    //     $otherpartner = DB::table('assignmentmappings')
    //         ->join('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
    //         ->where('assignmentmappings.assignmentgenerate_id', $id)
    //         ->select('team.id', 'team.team_member')
    //         ->get();

    //     $partner = $leadpartner->merge($otherpartner);

    //     return view('backEnd.viewassignment', compact('partner', 'udinDatas', 'contactDatas', 'teammemberDatas', 'assignmentcheckDatas', 'assignmentbudgetingDatas'));
    // }
    public function viewAssignment($id)
    {
        // dd($id);
        //$id = str_replace('e6Qui4C3e4e2e2fEDq', '', $id);
        //  dd($string);
        $assignmentid = Assignmentmapping::where('assignmentgenerate_id', $id)->select('assignment_id')->pluck('assignment_id')->first();
        // dd($assignmentgenerateid); 
        $assignmentcheck =
            DB::table('financialstatementclassifications')
            ->where('assignmentgenerate_id', $id)
            ->get();

        if ($assignmentcheck->isEmpty()) {
            $assignmentcheckDatas =
                DB::table('financialstatementclassifications')
                ->where('assignment_id', $assignmentid)
                ->where('assignmentgenerate_id', null)
                ->get();
            //dd($assignmentcheckDatas);
        } else {
            $assignmentcheckDatas =
                DB::table('financialstatementclassifications')
                ->where('assignment_id', $assignmentid)
                ->where('assignmentgenerate_id', null)
                ->orwhere('assignmentgenerate_id',  $id)
                ->get();
        }

        //  dd($assignmentcheckDatas);
        //! old code
        // $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
        //     ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
        //     ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        //     ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
        //     ->where('assignmentbudgetings.assignmentgenerate_id', $id)
        //     ->select(
        //         'assignmentbudgetings.*',
        //         'assignmentmappings.*',
        //         'clients.client_name',
        //         'assignments.assignment_name'
        //     )->first();
        // dd($assignmentbudgetingDatas);
        //! in this code , problem occure in open and close assignment
        // $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
        //     ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
        //     ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        //     ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
        //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        //     ->where('assignmentbudgetings.assignmentgenerate_id', $id)
        //     ->select(
        //         'assignmentbudgetings.*',
        //         'assignmentmappings.*',
        //         'clients.client_name',
        //         'assignmentteammappings.type',
        //         'assignments.assignment_name'
        //     )->first();
        //! in this code , problem solve in open and close assignment
        $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $id)
            ->select(
                'assignmentbudgetings.*', // status
                // 'assignmentmappings.*', // status
                'assignmentmappings.year',
                'assignmentmappings.periodend',
                'clients.client_name',
                'assignmentteammappings.type',
                'assignments.assignment_name'
            )->first();

        // dd($id);


        // assignmentteammappingsStatus select hare so that i can do active or inactive assignment assrejected
        $teammemberDatas = DB::table('assignmentmappings')
            ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
            ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
            ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
            ->where('assignmentmappings.assignmentgenerate_id', $id)
            ->select('teammembers.*', 'roles.rolename', 'assignmentteammappings.type', 'titles.title', 'assignmentteammappings.id As assignmentteammappingsId', 'assignmentteammappings.status as assignmentteammappingsStatus')->get();
        // dd($teammemberDatas);
        $contactDatas = DB::table('assignmentbudgetings')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->join('clientcontacts', 'clientcontacts.client_id', 'clients.id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $id)
            ->select(
                'clientcontacts.*'
            )->get();
        $udinDatas = DB::table('assignmentbudgetingudins')
            ->join('teammembers', 'teammembers.id', 'assignmentbudgetingudins.created_by')
            ->join('roles', 'roles.id', 'teammembers.role_id')
            ->where('assignmentbudgetingudins.assignment_generate_id', $id)
            ->select('teammembers.*', 'assignmentbudgetingudins.udin', 'roles.rolename', 'assignmentbudgetingudins.partner', 'assignmentbudgetingudins.created_at as created')->get();
        // dd($contactDatas);

        $leadpartner = DB::table('assignmentmappings')
            ->join('teammembers as team', 'team.id', 'assignmentmappings.leadpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $id)
            ->select('team.id', 'team.team_member')
            ->get();

        $otherpartner = DB::table('assignmentmappings')
            ->join('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $id)
            ->select('team.id', 'team.team_member')
            ->get();

        $partner = $leadpartner->merge($otherpartner);

        return view('backEnd.viewassignment', compact('partner', 'udinDatas', 'contactDatas', 'teammemberDatas', 'assignmentcheckDatas', 'assignmentbudgetingDatas'));
    }


    // Assignment Active and inactive functionality  assrejected
    public function  assignmentreject($id, $status, $teamid)
    {
        // dd($id);
        try {
            if ($status == 0) {
                DB::table('assignmentteammappings')->where('id', $id)->update([
                    'status'   => 0,
                ]);
            } else {
                //   Assignment inactive
                DB::table('assignmentteammappings')->where('id', $id)->update([
                    'status'   => 1,
                ]);

                //   Assignment inactive mail to user
                $assignmentmappingId = DB::table('assignmentteammappings')->where('id', $id)->select('assignmentmapping_id')->first();
                $assignmentgenerateId = DB::table('assignmentmappings')->where('id', $assignmentmappingId->assignmentmapping_id)->select('assignmentgenerate_id')->first();
                $assignmentname = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $assignmentgenerateId->assignmentgenerate_id)->select('assignmentname', 'client_id')->first();
                $clientname = DB::table('clients')->where('id', $assignmentname->client_id)->select('client_name')->first();
                $teammname = DB::table('teammembers')
                    ->where('teammembers.id', $teamid)
                    ->first();
                $data = array(
                    'assignmentgenerateId' =>  $assignmentgenerateId->assignmentgenerate_id,
                    'clientname' =>  $clientname->client_name,
                    'assignmentname' =>  $assignmentname->assignmentname,
                    'emailid' =>  $teammname->emailid,
                    'teammember_name' => $teammname->team_member,
                );

                Mail::send('emails.assignmentrejected', $data, function ($msg) use ($data) {
                    $msg->to([$data['emailid']]);
                    $msg->subject('Your Assignment rejected || ' . $data['assignmentname'] . ' / ' . $data['assignmentgenerateId']);
                });
                //   Assignment inactive mail to user end hare 
            }
            $output = array('msg' => 'Rejected Successfully');
            return back()->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function UdinStore(Request $request)
    {
        try {
            //$authId = auth()->user()->id;
            $udins = $request->input('udin');

            foreach ($udins as $udin) {
                DB::table('assignmentbudgetingudins')->insert([
                    'assignment_generate_id' => $request->assignment_generate_id,
                    'udin' => $udin,
                    'created_by' => auth()->user()->teammember_id,
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ]);
            }

            //    DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_generate_id)->update([
            //        'status' => $request->status,
            //   ]);

            $output = ['msg' => 'Submit Successfully'];
            return back()->with('success', $output);
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = ['msg' => $e->getMessage()];
            return back()->withErrors($output)->withInput();
        }
    }
    // udin delete 
    public function UdinDelete(string $id)
    {
        DB::table('assignmentbudgetingudins')->where('udin', $id)->delete();
        return back()->with('message', 'Your Data Successfully Deleted');
    }


    public function auditChecklist(Request $request)
    {
        //	dd('hi');
        $auditChecklistDatas = DB::table('assignmentbudgetings')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $request->assignmentid)
            ->select(
                'assignmentbudgetings.*',
                'assignmentmappings.periodend',
                'clients.client_name',
                'assignments.assignment_name'
            )->first();
        $stepname = Steplist::where('id', $request->steplist)->first();
        $financialname = Financialstatementclassification::where('id', $request->financialid)->first();
        $subclassficationname = Subfinancialclassfication::where('id', $request->subclassfied)->first();
        // dd($subclassficationname);
        $assignmentbudget = DB::table('assignmentbudgetings')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $request->assignmentid)
            ->select(
                'assignmentbudgetings.assignmentgenerate_id',
                'assignmentbudgetings.status',
                'clients.client_name'
            )
            ->first();
        // dd($assignmentbudget);
        //  $auditprocedure =DB::table('auditquestions')
        //   ->leftjoin('checklistanswers','checklistanswers.audit_id','auditquestions.id')
        //  ->leftjoin('teammembers','teammembers.id','checklistanswers.created_by')
        //   ->leftjoin('roles','roles.id','teammembers.role_id')
        //   ->where('auditquestions.steplist_id', $request->steplist)->
        //   where('auditquestions.subclassfied_id', $request->subclassfied)->
        //   where('checklistanswers.assignment_id', $request->assignmentid)->
        //  select('teammembers.team_member','auditquestions.*','roles.rolename'
        //  )->get();
        $auditprocedure = DB::table('auditquestions')
            //    ->leftjoin('checklistanswers','checklistanswers.audit_id','auditquestions.id')
            //->leftjoin('teammembers','teammembers.id','checklistanswers.created_by')
            //    ->leftjoin('roles','roles.id','teammembers.role_id')
            ->where('auditquestions.steplist_id', $request->steplist)->where('auditquestions.subclassfied_id', $request->subclassfied)->
            // orwhere('checklistanswers.assignment_id', $request->assignmentid)->
            select(
                'auditquestions.*'
            )->get();
        $countauditquestion = count($auditprocedure);
        $assignmentid = $request->assignmentid;

        $authteamtl = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->where('type', 0)->select('teammember_id')->pluck('teammember_id')->first();

        $authteamid = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->where('type', 2)->select('teammember_id')->pluck('teammember_id')->first();


        return view('backEnd.auditchecklist', compact('authteamtl', 'authteamid', 'countauditquestion', 'financialname', 'auditChecklistDatas', 'stepname', 'subclassficationname', 'auditprocedure', 'auditChecklistDatas', 'assignmentbudget', 'assignmentid'));
    }
    public function create(Request $request)

    {
        $financial = Financialstatementclassification::latest()->get();
        if ($request->ajax()) {
            if (isset($request->client_id)) {
                // dd($request->category_id);
                echo "<option>Please Select One</option>";
                foreach (Assignment::leftJoin('assignmentbudgetings', function ($join) {
                    $join->on('assignments.id', 'assignmentbudgetings.assignment_id');
                })->where('assignmentbudgetings.client_id', $request->client_id)->select('assignments.*', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentbudgetings.duedate')->get() as $sub) {

                    echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '(' . date('F d,Y', strtotime($sub->duedate)) . ')' . "</option>";
                }
            }
            if (isset($request->category_id)) {
                echo "<option>Please Select One</option>";
                foreach (Subfinancialclassfication::where('financialstatemantclassfication_id', $request->category_id)->get() as $sub) {

                    echo "<option value='" . $sub->id . "'>" . $sub->subclassficationname . "</option>";
                }
            }
            if (isset($request->subcategory_id)) {
                echo "<option>Please Select One</option>";
                foreach (Steplist::where('subclassfied_id', $request->subcategory_id)->get() as $sub) {

                    echo "<option value='" . $sub->id . "'>" . $sub->stepname . "</option>";
                }
            }
            if (isset($request->step_id)) {
                foreach (Auditquestion::where('steplist_id', $request->step_id)->get() as $sub) {

                    echo " <tr>
            <td>$sub->id </td>
            <td>
                $sub->auditprocedure 
            </td>
            
        </tr>";
                }
            }
        } else {
            // dd($category);
            $assignment = Assignment::latest()->get();

            $tab = Tab::latest()->get();
            $client = Client::latest()->get();
            return view('backEnd.step.create', compact('tab', 'client', 'assignment', 'financial'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checklistStore(Request $request)
    {
        //dd($request);
        $request->validate([
            'financialstatemantclassfication_id' => 'required',
            'subclassfied_id' => 'required',
            'steplist_id' => 'required'
        ]);

        try {
            $data = $request->except(['_token']);
            Auditquestion::Create($data);
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
            'file' => 'required',
            'assignment_id' => 'required|unique:financialstatementclassifications'
        ]);

        try {
            $file = $request->file;
            $authid = auth()->user()->id;
            $data = $request->except(['_token']);
            $dataa = Excel::toArray(new Stepchecklistimport, $file);

            foreach ($dataa[0] as $key => $value) {
                $financialid   = Financialstatementclassification::where('financial_name', $value['financialstatementclassifications'])
                    ->where('assignment_id', $request->assignment_id)->pluck('id')->first();

                if ($financialid == NULL) {
                    $db['financial_name'] = $value['financialstatementclassifications'];
                    $db['assignment_id'] = $request->assignment_id;
                    $data = Financialstatementclassification::Create($db);

                    $financialid   = Financialstatementclassification::where('financial_name', $value['financialstatementclassifications'])
                        ->where('assignment_id', $request->assignment_id)->pluck('id')->first();
                }
                $subfinancialid = Subfinancialclassfication::where('subclassficationname', $value['financialstatementsubclassifications'])
                    ->where('financialstatemantclassfication_id', $financialid)->pluck('id')->first();
                if ($subfinancialid == NULL) {
                    Subfinancialclassfication::insert([
                        'financialstatemantclassfication_id'         => $financialid,
                        'subclassficationname' => $value['financialstatementsubclassifications'],
                        'created_at' => date('y-m-d'),
                        'updated_at' => date('y-m-d')
                    ]);
                    $subfinancialid   = Subfinancialclassfication::where('subclassficationname', $value['financialstatementsubclassifications'])
                        ->where('financialstatemantclassfication_id', $financialid)->pluck('id')->first();
                }

                $stepid   = Steplist::where('stepname', $value['stepname'])->where('subclassfied_id', $subfinancialid)->pluck('id')->first();
                if ($stepid == NULL) {
                    Steplist::insert([
                        'subclassfied_id'         => $subfinancialid,
                        'stepname' => $value['stepname'],
                        'created_at' => date('y-m-d'),
                        'updated_at' => date('y-m-d')
                    ]);
                    $stepid   = Steplist::where('stepname', $value['stepname'])->where('subclassfied_id', $subfinancialid)->pluck('id')->first();
                }

                Auditquestion::insert([
                    'steplist_id'         => $stepid,
                    'financialstatemantclassfication_id'         => $financialid,
                    'subclassfied_id'         => $subfinancialid,
                    'auditprocedure' => $value['auditprocedure'],
                    'created_at' => date('y-m-d'),
                    'updated_at' => date('y-m-d')
                ]);
            }
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
    public function tag_create(Request $request)

    {
        if ($request->ajax()) {

            if (isset($request->category_id)) {
                echo "<option>Please Select One</option>";
                foreach (Subfinancialclassfication::where('financialstatemantclassfication_id', $request->category_id)->get() as $sub) {

                    echo "<option value='" . $sub->id . "'>" . $sub->subclassficationname . "</option>";
                }
            }
            if (isset($request->subcategory_id)) {

                echo "<option>Please Select One</option>";
                foreach (DB::table('auditquestions')
                    ->leftjoin('steplists', 'steplists.id', 'auditquestions.steplist_id')
                    ->where('auditquestions.subclassfied_id', $request->subcategory_id)
                    ->select('auditquestions.steplist_id', 'steplists.stepname')
                    ->distinct('steplists.stepname')->get() as $sub) {

                    echo "<option value='" . $sub->steplist_id . "'>" . $sub->stepname . "</option>";
                }
            }
            if (isset($request->step_id)) {
                echo "<option>Please Select One</option>";
                foreach (Auditquestion::where('steplist_id', $request->step_id)->get() as $sub) {

                    echo "<option value='" . $sub->id . "'>" . $sub->auditprocedure . "</option>";
                }
            }
        }
    }

    public function excelStore(Request $request)
    {

        $request->validate([
            'file' => 'required',
            //   'assignment_id' => 'required|unique:financialstatementclassifications'
        ]);

        try {
            $assignmentid = Assignmentbudgeting::where('assignmentgenerate_id', $request->assignment_id)->select('assignment_id')->pluck('assignment_id')->first();
            //  dd($assignmentid);
            $file = $request->file;
            $authid = auth()->user()->id;
            $data = $request->except(['_token']);
            $dataa = Excel::toArray(new Stepchecklistimport, $file);

            foreach ($dataa[0] as $key => $value) {
                $financialid   = Financialstatementclassification::where('financial_name', $value['financialstatementclassifications'])
                    ->where('assignment_id', $assignmentid)->where('assignmentgenerate_id', $request->assignment_id)->pluck('id')->first();

                if ($financialid == NULL) {
                    $db['financial_name'] = $value['financialstatementclassifications'];
                    $db['assignment_id'] = $assignmentid;
                    $db['assignmentgenerate_id'] = $request->assignment_id;
                    $data = Financialstatementclassification::Create($db);

                    $financialid   = Financialstatementclassification::where('financial_name', $value['financialstatementclassifications'])
                        ->where('assignment_id', $assignmentid)->where('assignmentgenerate_id', $request->assignment_id)->pluck('id')->first();
                }
                $subfinancialid = Subfinancialclassfication::where('subclassficationname', $value['financialstatementsubclassifications'])
                    ->where('financialstatemantclassfication_id', $financialid)->pluck('id')->first();
                if ($subfinancialid == NULL) {
                    Subfinancialclassfication::insert([
                        'financialstatemantclassfication_id'         => $financialid,
                        'assignmentgenerate_id'         =>  $request->assignment_id,
                        'subclassficationname' => $value['financialstatementsubclassifications'],
                        'created_at' => date('y-m-d'),
                        'updated_at' => date('y-m-d')
                    ]);
                    $subfinancialid   = Subfinancialclassfication::where('subclassficationname', $value['financialstatementsubclassifications'])
                        ->where('financialstatemantclassfication_id', $financialid)->pluck('id')->first();
                }

                $stepid   = Steplist::where('stepname', $value['stepname'])->where('subclassfied_id', $subfinancialid)->pluck('id')->first();
                if ($stepid == NULL) {
                    Steplist::insert([
                        'subclassfied_id'         => $subfinancialid,
                        'assignmentgenerate_id'         =>  $request->assignment_id,
                        'stepname' => $value['stepname'],
                        'created_at' => date('y-m-d'),
                        'updated_at' => date('y-m-d')
                    ]);
                    $stepid   = Steplist::where('stepname', $value['stepname'])->where('subclassfied_id', $subfinancialid)->pluck('id')->first();
                }

                Auditquestion::insert([
                    'steplist_id'         => $stepid,
                    'financialstatemantclassfication_id'         => $financialid,
                    'assignmentgenerate_id'         => $request->assignment_id,
                    'subclassfied_id'         => $subfinancialid,
                    'auditprocedure' => $value['auditprocedure'],
                    'created_at' => date('y-m-d'),
                    'updated_at' => date('y-m-d')
                ]);
            }
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
     * @param  \App\Models\step  $step
     * @return \Illuminate\Http\Response
     */
    public function show(step $step)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\step  $step
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = Title::latest()->get();
        $teamlevel = Teamlevel::latest()->get();
        $step = step::where('id', $id)->first();
        return view('backEnd.step.edit', compact('id', 'step', 'title', 'teamlevel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\step  $step
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'team_member' => "required",
            'mobile_no' => "required|numeric",
            'pancardno' => "required|numeric",
            'team_member' => "required"
        ]);
        try {
            $data = $request->except(['_token']);

            step::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('backEnd/step')->with('status', $output);
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
     * @param  \App\Models\step  $step
     * @return \Illuminate\Http\Response
     */
    public function assignmentclose($id)
    {
        //dd($id);
        try {
            //$authId = auth()->user()->id;


            DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $id)->update([
                'status' => $request->status,
            ]);

            $output = ['msg' => 'Assignment Close Successfully'];
            return back()->with('success', $output);
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = ['msg' => $e->getMessage()];
            return back()->withErrors($output)->withInput();
        }
    }
}
