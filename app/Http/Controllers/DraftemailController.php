<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\Draftemail;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;

class DraftemailController extends Controller
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
        if (auth()->user()->teammember_id == 434) {
            $teammember = Teammember::where('role_id', 13)->orwhere('role_id', 14)->with('title', 'role')->get();
            $draftemail = DB::table('draftemails')
                ->leftjoin('roles', 'roles.id', 'draftemails.role_id')
                ->leftjoin('departments', 'departments.id', 'draftemails.department_id')
                ->leftjoin('teammembers', 'teammembers.id', 'draftemails.reportinghead', 'teammembers.team_member')->select('draftemails.*', 'roles.rolename', 'departments.name as departmentname')
                ->get();
            $roles = DB::table('roles')->where('id', '!=', '11')->where('id', '!=', '12')
                ->get();
            $department = DB::table('departments')->get();
            //    dd($department);
            return view('backEnd.draftemail.index', compact('draftemail', 'roles', 'department', 'teammember'));
        } elseif (auth()->user()->role_id == 11 || auth()->user()->role_id == 18 || auth()->user()->teammember_id == 155) {
            $teammember = Teammember::where('role_id', 13)->orwhere('role_id', 14)->with('title', 'role')->get();
            $draftemail = DB::table('draftemails')
                ->leftjoin('roles', 'roles.id', 'draftemails.role_id')
                ->leftjoin('departments', 'departments.id', 'draftemails.department_id')
                ->leftjoin('teammembers', 'teammembers.id', 'draftemails.reportinghead')
                ->select('draftemails.*', 'roles.rolename', 'departments.name as departmentname', 'teammembers.team_member')
                ->get();
            $roles = DB::table('roles')->where('id', '!=', '11')->where('id', '!=', '12')
                ->get();
            $department = DB::table('departments')->get();
            //    dd($department);
            return view('backEnd.draftemail.index', compact('draftemail', 'roles', 'department', 'teammember'));
        }
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
        $request->validate([
            'name' => "required",
            'email' => "required",
        ]);

         //dd($request);

        // these are 4 entities which is coming from request
        $entity1 = 'K G Somani Co & LLP';
        $entity2 = 'CapiTall India Pvt. Ltd.';
        $entity3 = 'KGS Advisors LLP';
        $entity4 = 'Womennovator';

        try {
            $data = $request->except(['_token', 'description', 'entity']);
            $data['createdby'] = auth()->user()->teammember_id;
            $icard =  Draftemail::Create($data);


            //replacing the onboarding form link in description based on role_id and entity
            if ($request->role_id == 15) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/articleonboardingform"];
                $description = str_replace($healthy, $yummy, $des);
            } elseif ($request->role_id == 19 &&  $request->entity == $entity1) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/candidateonboardingform/intern/kgs"];
                $description = str_replace($healthy, $yummy, $des);
            } elseif ($request->role_id == 19 &&  $request->entity == $entity2) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/candidateonboardingform/intern/capitall"];
                $description = str_replace($healthy, $yummy, $des);
            } elseif ($request->role_id == 19 &&  $request->entity == $entity3) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/candidateonboardingform/intern/kgs-advisors"];
                $description = str_replace($healthy, $yummy, $des);
            } elseif ($request->role_id == 19 &&  $request->entity == $entity4) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/candidateonboardingform/intern/womennovator"];
                $description = str_replace($healthy, $yummy, $des);
            } elseif ($request->role_id != 15 && $request->entity == $entity1) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/candidateonboardingform/kgs"];
                $description = str_replace($healthy, $yummy, $des);
            } elseif ($request->role_id != 15 && $request->entity == $entity2) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/candidateonboardingform/capitall"];
                $description = str_replace($healthy, $yummy, $des);
            } elseif ($request->role_id != 15 && $request->entity == $entity3) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/candidateonboardingform/kgs-advisors"];
                $description = str_replace($healthy, $yummy, $des);
            } elseif ($request->role_id != 15 && $request->entity == $entity4) {
                $des = $request->description;
                $healthy = ["/candidateonboardingform"];
                $yummy   = ["/candidateonboardingform/womennovator"];
                $description = str_replace($healthy, $yummy, $des);
            }
            else{
                
            }
            

            $data = array(
                'email' => $request->email,
                'name' => $request->name,
                'description' => $description,
            );

            Mail::send('emails.draftemailform', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject('Onboarding Documents');
            });

            $output = array('msg' => 'Create Successfully');
            return redirect('draftemail')->with('success', $output);
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
     * @param  \App\Models\Draftemail  $draftemail
     * @return \Illuminate\Http\Response
     */
    public function show(Draftemail $draftemail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Draftemail  $draftemail
     * @return \Illuminate\Http\Response
     */
    public function edit(Draftemail $draftemail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Draftemail  $draftemail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Draftemail $draftemail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Draftemail  $draftemail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Draftemail $draftemail)
    {
        //
    }
}
