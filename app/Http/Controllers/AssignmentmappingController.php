<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignmentmapping;
use App\Models\Assignmentbudgeting;
use App\Models\Assignmentteammapping;
use App\Models\Assignment;
use App\Models\Teammember;
use App\Models\Client;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AssignmentmappingController extends Controller
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
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12 || auth()->user()->role_id == 18) {
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                //  ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                // ->where('clients.status',1)
                ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')->distinct()->get();
            //   dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        } elseif (auth()->user()->role_id == 13) {
            //! old code

            // $authid = Client::where('leadpartner', auth()->user()->teammember_id)->select('leadpartner')->pluck('leadpartner')->first();
            // // dd($authid);
            // $assignmentmappingData = DB::table('assignmentmappings')
            //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            //     ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

            //     ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
            //     ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            //     ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
            //     ->where('assignmentbudgetings.status', 1)

            //     ->distinct()->get();

            //! new code 1
            // $assignmentmappingData = DB::table('assignmentmappings')
            //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            //     ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            //     ->where(function ($query) {
            //         $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            //             ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            //     })

            //     ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
            //     ->where('assignmentbudgetings.status', 1)
            //     ->distinct()->get();

            //! new code 2

            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->where(function ($query) {
                    $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                        ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
                })
                ->where('assignmentbudgetings.status', 1)
                ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
                ->distinct()->get();
            return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        } elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
            // $assignmentmappingData = DB::table('assignmentmappings')
            //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            //     ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

            //     ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
            //     ->where('clients.status', 1)
            //     ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();

            // i have changed hare  assrejected
            $assignmentmappingData =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
                // ->where('clients.status', 0)
                ->where('assignmentbudgetings.status', 1)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();
            // dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        }
        // else {
        //     $assignmentmappingData = DB::table('assignmentmappings')
        //         ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        //         ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        //         ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

        //         ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
        //         ->where('clients.status', 1)
        //         ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();

        //     return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        // }
        else {
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

                ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
                ->where('clients.status', 1)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();

            return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        }
    }

    public function clientassignmentList($id)
    {
        if (auth()->user()->teammember_id == 161 || auth()->user()->teammember_id == 99) {
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $id)
                ->select('assignmentmappings.year')->distinct()->get();
            // dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.assignmentlist', compact('assignmentmappingData', 'id'));
        } elseif (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $id)
                ->select('assignmentmappings.year')->distinct()->get();
            // dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.assignmentlist', compact('assignmentmappingData', 'id'));
        } elseif (auth()->user()->role_id == 13) {
            //  $authid =Client::where('leadpartner', auth()->user()->teammember_id)->select('leadpartner')->pluck('leadpartner')->first();
            //     dd($authid);
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                //  ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                ->select('assignmentmappings.year')
                ->where('clients.id', $id)
                ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                ->distinct()->get();
            // dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.assignmentlist', compact('assignmentmappingData', 'id'));
        } else {
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->select('assignmentmappings.year')
                ->where('clients.id', $id)->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();
            //  dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.assignmentlist', compact('assignmentmappingData', 'id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //! old code 
    // public function yearWise(Request $request)
    // {
    //     if (auth()->user()->role_id == 11) {
    //         $clientid = $request->clientid;
    //         $assignmentmappingData =  DB::table('assignmentmappings')
    //             ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //             ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //             ->where('clients.id', $request->clientid)
    //             ->where('assignmentmappings.year', $request->year)
    //             ->select(
    //                 'assignmentmappings.*',
    //                 'assignmentbudgetings.duedate',
    //                 'assignmentbudgetings.assignmentname',
    //                 'assignments.assignment_name',
    //                 'clients.client_name'
    //             )->distinct()->get();
    //         return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
    //     } elseif (auth()->user()->role_id == 13) {
    //         $clientid = $request->clientid;
    //         $assigned =  DB::table('assignmentmappings')
    //             ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //             ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //             ->where('clients.id', $request->clientid)
    //             ->where('assignmentmappings.year', $request->year)
    //             ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
    //             ->select(
    //                 'assignmentmappings.*',
    //                 'assignmentbudgetings.duedate',
    //                 'assignments.assignment_name',
    //                 'clients.client_name',
    //                 'assignmentbudgetings.assignmentname'
    //             )->distinct()->get();

    //         $otherassigned =  DB::table('assignmentmappings')
    //             ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //             ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //             ->where('clients.id', $request->clientid)
    //             ->where('assignmentmappings.year', $request->year)
    //             ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
    //             ->select(
    //                 'assignmentmappings.*',
    //                 'assignmentbudgetings.duedate',
    //                 'assignments.assignment_name',
    //                 'clients.client_name',
    //                 'assignmentbudgetings.assignmentname'
    //             )->distinct()->get();
    //         return view('backEnd.assignmentmapping.yearwisepartnerlist', compact('assigned', 'otherassigned', 'clientid'));
    //     } else {
    //         // assrejected
    //         $clientid = $request->clientid;
    //         $assignmentmappingData =  DB::table('assignmentmappings')
    //             ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //             ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //             ->where('clients.id', $request->clientid)
    //             ->where('assignmentmappings.year', $request->year)
    //             ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    //             ->where('assignmentteammappings.status', 1)
    //             ->select(
    //                 'assignmentmappings.*',
    //                 'assignmentbudgetings.duedate',
    //                 'assignmentbudgetings.assignmentname',
    //                 'assignments.assignment_name',
    //                 'clients.client_name'
    //             )->distinct()->get();
    //         // assrejected
    //         return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
    //     }
    // }


    // public function yearWise(Request $request)
    // {
    //     if (auth()->user()->role_id == 11) {
    //         $clientid = $request->clientid;
    //         $assignmentmappingData =  DB::table('assignmentmappings')
    //             ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //             ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //             ->where('clients.id', $request->clientid)
    //             ->where('assignmentmappings.year', $request->year)
    //             ->select(
    //                 'assignmentmappings.*',
    //                 'assignmentbudgetings.duedate',
    //                 'assignmentbudgetings.assignmentname',
    //                 'assignments.assignment_name',
    //                 'clients.client_name'
    //             )->distinct()->get();
    //         return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
    //     } elseif (auth()->user()->role_id == 13) {
    //         $clientid = $request->clientid;
    //         $assigned =  DB::table('assignmentmappings')
    //             ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //             ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //             ->where('clients.id', $request->clientid)
    //             ->where('assignmentmappings.year', $request->year)
    //             ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
    //             ->select(
    //                 'assignmentmappings.*',
    //                 'assignmentbudgetings.duedate',
    //                 'assignments.assignment_name',
    //                 'clients.client_name',
    //                 'assignmentbudgetings.assignmentname'
    //             )->distinct()->get();

    //         $otherassigned =  DB::table('assignmentmappings')
    //             ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //             ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //             ->where('clients.id', $request->clientid)
    //             ->where('assignmentmappings.year', $request->year)
    //             ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
    //             ->select(
    //                 'assignmentmappings.*',
    //                 'assignmentbudgetings.duedate',
    //                 'assignments.assignment_name',
    //                 'clients.client_name',
    //                 'assignmentbudgetings.assignmentname'
    //             )->distinct()->get();
    //         return view('backEnd.assignmentmapping.yearwisepartnerlist', compact('assigned', 'otherassigned', 'clientid'));
    //     } else {
    //         // assrejected
    //         $clientid = $request->clientid;
    //         $assignmentmappingData =  DB::table('assignmentmappings')
    //             ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //             ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //             ->where('clients.id', $request->clientid)
    //             ->where('assignmentmappings.year', $request->year)
    //             ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    //             // assignment block task 
    //             ->where('assignmentteammappings.status', 1)
    //             ->orWhereNull('assignmentteammappings.status')
    //             // ->whereIn('assignmentteammappings.status', ['null', 1])
    //             ->select(
    //                 'assignmentmappings.*',
    //                 'assignmentbudgetings.duedate',
    //                 'assignmentbudgetings.assignmentname',
    //                 'assignments.assignment_name',
    //                 'assignmentteammappings.status as assignmentteammappingsstatus',
    //                 'clients.client_name'
    //             )->distinct()->get();
    //         // assrejected
    //         // dd($assignmentmappingData);
    //         return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
    //     }
    // }

    public function yearWise(Request $request)
    {
        // DB::table('assignmentteammappings')
        //     ->update(['status' => 0]);

        if (auth()->user()->role_id == 11) {
            $clientid = $request->clientid;
            $assignmentmappingData =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $request->clientid)
                ->where('assignmentmappings.year', $request->year)
                ->select(
                    'assignmentmappings.*',
                    'assignmentbudgetings.duedate',
                    'assignmentbudgetings.assignmentname',
                    'assignments.assignment_name',
                    'clients.client_name'
                )->distinct()->get();
            return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
        } elseif (auth()->user()->role_id == 13) {
            $clientid = $request->clientid;
            $assigned =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $request->clientid)
                ->where('assignmentmappings.year', $request->year)
                ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->select(
                    'assignmentmappings.*',
                    'assignmentbudgetings.duedate',
                    'assignments.assignment_name',
                    'clients.client_name',
                    'assignmentbudgetings.assignmentname'
                )->distinct()->get();

            $otherassigned =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $request->clientid)
                ->where('assignmentmappings.year', $request->year)
                ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                ->select(
                    'assignmentmappings.*',
                    'assignmentbudgetings.duedate',
                    'assignments.assignment_name',
                    'clients.client_name',
                    'assignmentbudgetings.assignmentname'
                )->distinct()->get();
            return view('backEnd.assignmentmapping.yearwisepartnerlist', compact('assigned', 'otherassigned', 'clientid'));
        } else {

            $clientid = $request->clientid;
            $assignmentmappingData =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $request->clientid)
                ->where('assignmentmappings.year', $request->year)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                // status 0 is active  so that i can active or inactive assignment assrejected
                ->where('assignmentteammappings.status', 0)
                ->select(
                    'assignmentmappings.*',
                    'assignmentbudgetings.duedate',
                    'assignmentbudgetings.assignmentname',
                    'assignments.assignment_name',
                    'clients.client_name'
                )->distinct()->get();
            // assrejected
            return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
        }
    }


    //! old code 
    public function create(Request $request)
    {

        $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
            ->orderBy('team_member', 'asc')->get();
        $teammember = Teammember::where('status', '1')->whereIn('role_id', [14, 15])->with('title', 'role')
            ->orderBy('team_member', 'asc')->get();
        //dd($teammember);
        if ($request->ajax()) {

            // if (isset($request->category_id)) {
            //     // dd($request->category_id);
            //     echo "<option>Please Select One</option>";
            //     foreach (Assignment::leftJoin('assignmentbudgetings', function ($join) {
            //         $join->on('assignments.id', 'assignmentbudgetings.assignment_id');
            //     })->where('assignmentbudgetings.client_id', $request->category_id)
            //         ->select('assignments.*', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentbudgetings.duedate', 'assignmentbudgetings.assignmentname')->get() as $sub) {

            //         echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '( ' . $sub->assignmentgenerate_id . ' )' . '( ' . $sub->assignmentname . ' )' . "</option>";
            //     }
            //     // assignmentgenerate_id
            // }

            if (isset($request->category_id)) {
                echo "<option>Please Select One</option>";

                $assignments = Assignment::leftJoin('assignmentbudgetings', function ($join) {
                    $join->on('assignments.id', '=', 'assignmentbudgetings.assignment_id');
                })->leftJoin('assignmentmappings', function ($join) {
                    $join->on('assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id');
                })
                    ->where('assignmentbudgetings.client_id', $request->category_id)
                    // get data only that is not matches assignmentmappings.assignmentgenerate_id from assignmentbudgetings table
                    ->whereNull('assignmentmappings.assignmentgenerate_id')
                    ->select('assignments.*', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentbudgetings.duedate', 'assignmentbudgetings.assignmentname')
                    ->get();

                foreach ($assignments as $sub) {
                    echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '( ' . $sub->assignmentgenerate_id . ' )' . '( ' . $sub->assignmentname . ' )' . "</option>";
                }
            }
        } else {
            if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
                $client = Client::where('status', 1)->latest()->get();
                return view('backEnd.assignmentmapping.create', compact('client', 'teammember', 'partner'));
            } else {
                $client = DB::table('assignmentbudgetings')
                    ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    ->Where('assignmentbudgetings.created_by', auth()->user()->id)
                    ->select('clients.client_name', 'clients.id')
                    ->distinct()->get();

                //	DB::table('clients')->
                //  orWhere('clients.leadpartner',auth()->user()->teammember_id)->
                //  orWhere('clients.createdbyadmin_id',auth()->user()->id)->
                //	 orWhere('clients.updatedbyadmin_id',auth()->user()->id)->
                //   select('clients.client_name','clients.id')->get();

                return view('backEnd.assignmentmapping.create', compact('client', 'teammember', 'partner'));
            }
        }
    }


    public function store(Request $request)
    {
        // dd($request);
        // dd($request->teammember_id);
        $request->validate([
            'client_id' => "required",
            'assignment_id' => "required",
            'teammember_id.*' => "required",
            'type.*' => "required"
        ]);

        try {
            $previouschck = DB::table('assignmentmappings')
                ->where('assignmentgenerate_id', $request->assignment_id)
                ->first();

            // dd($previouschck);
            if ($previouschck != null) {
                //dd('hi');
                $output = array('msg' => 'You already created assignment for this.');
                return back()->with('success', $output);
            }

            $assignment_id = Assignmentbudgeting::where('assignmentgenerate_id', $request->assignment_id)->select('assignment_id')->pluck('assignment_id')->first();

            // Storage::disk('s3')->makeDirectory($request->assignment_id);
            $request->except(['_token']);
            //  dd($data); die();
            $id = DB::table('assignmentmappings')->insertGetId([

                'assignmentgenerate_id'         =>     $request->assignment_id,
                'periodstart'         =>     $request->periodstart,
                'periodend'         =>     $request->periodend,
                'year'         =>     Carbon::parse($request->periodend)->year,
                'roleassignment'                =>      $request->roleassignment,
                'assignment_id'         =>     $assignment_id,
                'esthours'            =>       $request->esthours,
                'leadpartner'            =>       $request->leadpartner,
                'otherpartner'            =>       $request->otherpartner,
                'stdcost'            =>       $request->stdcost,
                'estcost'            =>       $request->estcost,
                'filecreationdate'                =>       date('y-m-d'),
                'modifieddate'              =>    date('y-m-d'),
                'auditcompletiondate'                =>       date('y-m-d'),
                'documentationdate'              =>    date('y-m-d'),
                'created_at'                =>       date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
            // dd($id);
            if ($request->teammember_id != '0') {
                $count = count($request->teammember_id);
                // dd($count); die;
                for ($i = 0; $i < $count; $i++) {
                    DB::table('assignmentteammappings')->insert([
                        'assignmentmapping_id'       =>     $id,
                        'type'       =>     $request->type[$i],
                        'teammember_id'       =>     $request->teammember_id[$i],
                        // default status 0 so that i can active or inactive assignment assrejected
                        'status'       =>  0,
                        'created_at'                =>       date('y-m-d'),
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                }
                // dd($request->assignment_id);
                $clientname = DB::table('clients')->where('id', $request->client_id)->select('client_name')->first();
                $assignmentnames = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id)->select('assignmentname')->first();
                $teamemail = DB::table('teammembers')->wherein('id', $request->teammember_id)->select('emailid')->get();
                foreach ($teamemail as $teammember) {
                    $data = array(
                        'assignmentid' =>  $request->assignment_id,
                        'clientname' =>  $clientname->client_name,
                        'assignmentname' =>  $assignmentnames->assignmentname,
                        'emailid' =>  $teammember->emailid,


                    );

                    Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
                        $msg->to($data['emailid']);
                        $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
                    });
                }
            }
            $assignmentname = Assignment::where('id', $request->assignment_id)->select('assignment_name')->pluck('assignment_name')->first();
            // dd($assignmentname);
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'description' => 'New Assignment Mapping Added' . ' ' . '( ' . $assignmentname . ' )',
                'created_at' => date('y-m-d'),
                'updated_at' => date('y-m-d')
            ]);
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
     * @param  \App\Models\Assignmentmapping  $assignmentmapping
     * @return \Illuminate\Http\Response
     */
    public function assignmentmappingEdit($id)
    {
        $assignmentmapping = Assignmentmapping::where('id', $id)->first();
        // dd($assignmentmapping);
        return view('backEnd.assignmentmapping.edit', compact('id', 'assignmentmapping'));
    }

    public function show(Assignmentmapping $assignmentmapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignmentmapping  $assignmentmapping
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignmentmapping $assignmentmapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignmentmapping  $assignmentmapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->except(['_token']);
            Assignmentmapping::find($id)->update($data);
            $assignmentname =  DB::table('assignmentmappings')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')->where('assignmentmappings.id', $id)->select('assignment_name')
                ->pluck('assignment_name')->first();
            // dd($assignmentname);
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'description' => ' Assignment Mapping Edit' . ' ' . '( ' . $assignmentname . ' )',
                'created_at' => date('y-m-d'),
                'updated_at' => date('y-m-d')
            ]);
            $output = array('msg' => 'Updated Successfully');
            return redirect('assignmentmapping')->with('success', $output);
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
     * @param  \App\Models\Assignmentmapping  $assignmentmapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignmentmapping $assignmentmapping)
    {
        //
    }
}
