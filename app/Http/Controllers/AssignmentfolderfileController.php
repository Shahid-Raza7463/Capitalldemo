<?php

namespace App\Http\Controllers;

use App\Models\Assignmentfolderfile;
use Illuminate\Http\Request;
use DB;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Storage;

class AssignmentfolderfileController extends Controller
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
    // zip download 
    public function zipfile(Request $request, $assignmentfolder_id)
    {
        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();
        //dd($fileName);

        $zipFileName = $generateid->assignmentfoldersname . '.zip';
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($fileName as $file) {
                // Replace storage_path with S3 access method
                // $filePath = storage_path('app/public/image/task/' . $file->filesname);
                $filePath = Storage::disk('s3')->get($generateid->assignmentgenerateid . '/' . $file->filesname);

                if ($filePath) {
                    $zip->addFromString($file->filesname, $filePath);
                } else {
                    return '<h1>File Not Found</h1>';
                }
            }

            $zip->close();
        }

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    public function index_list($id)
    {
        //	dd($id);
        $foldername = DB::table('assignmentfolders')->where('id', $id)->first();
        $financial =  DB::table('assignmentbudgetings')->leftjoin('financialstatementclassifications', 'financialstatementclassifications.assignment_id', 'assignmentbudgetings.assignment_id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $foldername->assignmentgenerateid)
            ->select('financialstatementclassifications.id', 'financialstatementclassifications.financial_name')
            ->get();
        $assignmentfolderfile = DB::table('assignmentfolderfiles')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentfolderfiles.createdby')
            ->where('assignmentfolderfiles.assignmentfolder_id', $id)
            ->where('assignmentfolderfiles.status', 1)
            ->select('assignmentfolderfiles.*', 'teammembers.team_member', 'teammembers.staffcode')->latest()->get();
        $assignmentbudgeting = DB::table('assignmentbudgetings')
            ->where('assignmentgenerate_id', $foldername->assignmentgenerateid)->first();

        return view('backEnd.assignmentfolderfile.index', compact('assignmentbudgeting', 'assignmentfolderfile', 'id', 'foldername', 'financial'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'particular' => 'required',
            'file' => 'required',
        ]);

        try {
            $data = $request->except(['_token']);
            $files = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $name = $file->getClientOriginalName();
                    //    $destinationPath = storage_path('app/backEnd/image/clientfile');
                    //   $name = $file->getClientOriginalName();
                    //  $s = $file->move($destinationPath, $name);
                    //  dd($s); die;
                    $path = $file->storeAs($request->assignmentgenerateid, $name, 's3');
                    $files[] = $name;
                }
            }
            foreach ($files as $filess) {
                // dd($files); die;
                $s = DB::table('assignmentfolderfiles')->insert([
                    'particular' => $request->particular,
                    'assignmentgenerateid' => $request->assignmentgenerateid,
                    'assignmentfolder_id' =>  $request->assignmentfolder_id,
                    'createdby' =>  auth()->user()->teammember_id,
                    'filesname' => $filess,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            //dd($data);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function show(Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function  destroy($id)
    {
        //  dd($id);
        try {
            DB::table('assignmentfolderfiles')->where('id', $id)->update([

                'status'   =>   0,

            ]);
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
}
