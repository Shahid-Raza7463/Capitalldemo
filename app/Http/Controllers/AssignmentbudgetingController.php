<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignmentbudgeting;
use App\Models\Assignment;
use App\Models\Client;
use DB;

class AssignmentbudgetingController extends Controller
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
    public function list()
    {
        $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->leftjoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->select('clients.client_name', 'assignmentbudgetings.*', 'assignments.assignment_name', 'teammembers.team_member')->get();

        return view('backEnd.assignmentbudgeting.indexlist', compact('assignmentbudgetingDatas'));
    }
    public function index()
    {
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
            $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')->select('clients.client_name', 'assignmentbudgetings.*', 'assignments.assignment_name')->get();

            return view('backEnd.assignmentbudgeting.index', compact('assignmentbudgetingDatas'));
        } else {
            $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->Where('assignmentbudgetings.created_by', auth()->user()->id)->orWhere('clients.leadpartner', auth()->user()->teammember_id)->select('clients.client_name', 'assignmentbudgetings.*', 'assignments.assignment_name')->get();

            Assignmentbudgeting::where('created_by', auth()->user()->id)->get();
            return view('backEnd.assignmentbudgeting.index', compact('assignmentbudgetingDatas'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
            $assignment = Assignment::where('status', '1')->orderBy('assignment_name')->get();
            $client = Client::activeClient()->orderBy('client_name')->get();
            return view('backEnd.assignmentbudgeting.create', compact('assignment', 'client'));
        } else {
            $assignment = Assignment::where('status', '1')->orderBy('assignment_name')->get();
            $client = Client::activeClient()->orderBy('client_name')->orWhere('clients.leadpartner', auth()->user()->teammember_id)->orWhere('clients.createdbyadmin_id', auth()->user()->id)->orWhere('clients.updatedbyadmin_id', auth()->user()->id)->select('clients.*')->get();
            return view('backEnd.assignmentbudgeting.create', compact('assignment', 'client'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(auth()->user());
        $request->validate([
            'client_id' => "required",
            'assignment_id' => "required",

        ]);

        try {
            $data = $request->except(['_token']);
            $data['created_by'] = auth()->user()->id;
            $clientcode = DB::table('clients')->where('id', $request->client_id)->first();
            $assignmentgenerateid = strtoupper(substr($clientcode->client_name, 0, 3));

            $assign = Assignmentbudgeting::latest()->get();
            // dd($assign); die;
            if ($assign->isEmpty()) {
                $assignmentnumbers = '100001';
            } else {

                $assignmentnumb = Assignmentbudgeting::latest()->first()->assignmentnumber;
                if ($assignmentnumb ==  null) {
                    $assignmentnumbers = '100001';
                } else {
                    $assignmentnumbers = $assignmentnumb + 1;
                }
            }
            $assignmentgenerate = $assignmentgenerateid . $assignmentnumbers;
            //  dd($assignmentgenerate);
            $data['assignmentgenerate_id'] = $assignmentgenerate;
            $data['assignmentnumber'] = $assignmentnumbers;

            Assignmentbudgeting::Create($data);
            $assignmentname = Assignment::where('id', $request->assignment_id)->select('assignment_name')->pluck('assignment_name')->first();
            // dd($assignmentname);
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'description' => 'New Assignment Budgeting Added' . ' ' . '( ' . $assignmentname . ' )',
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
     * @param  \App\Models\Assignmentbudgeting  $assignmentbudgeting
     * @return \Illuminate\Http\Response
     */
    public function show(Assignmentbudgeting $assignmentbudgeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignmentbudgeting  $assignmentbudgeting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assignmentbudgeting = Assignmentbudgeting::where('id', $id)->first();
        // dd($assignmentmapping);
        return view('backEnd.assignmentbudgeting.edit', compact('id', 'assignmentbudgeting'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignmentbudgeting  $assignmentbudgeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->except(['_token']);
            Assignmentbudgeting::find($id)->update($data);
            $assignmentname =  DB::table('assignmentbudgetings')
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')->where('assignmentbudgetings.id', $id)->select('assignment_name')
                ->pluck('assignment_name')->first();
            // dd($assignmentname);
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'description' => ' Assignment Budgeting Edit' . ' ' . '( ' . $assignmentname . ' )',
                'created_at' => date('y-m-d'),
                'updated_at' => date('y-m-d')
            ]);
            $output = array('msg' => 'Updated Successfully');
            return redirect('assignmentbudgeting')->with('success', $output);
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
     * @param  \App\Models\Assignmentbudgeting  $assignmentbudgeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignmentbudgeting $assignmentbudgeting)
    {
        //
    }
}
