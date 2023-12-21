<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use DB;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
//die;
		

		if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
        $attendanceDatas = DB::table('attendances')
        ->leftjoin('teammembers','teammembers.id','attendances.employee_name')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        //->where('teammembers.employment_status','CA Article')
			->where('teammembers.role_id',15)
        ->select('attendances.*','teammembers.team_member','teammembers.employment_status','roles.rolename','teammembers.joining_date')->paginate(150);
        $attendanceDatass = DB::table('attendances')
        ->leftjoin('teammembers','teammembers.id','attendances.employee_name')
        ->leftjoin('roles','roles.id','teammembers.role_id')
       // ->where('teammembers.employment_status','Employee')
			->whereNotIn('role_id', ['11', '12', '13','15','19','20'])
			->whereNotIn('employee_name', ['170', '169', '307','447','336'])
        ->select('attendances.*','teammembers.team_member','teammembers.employment_status','roles.rolename','teammembers.joining_date')->paginate(150);
			
			//dd($attendanceDatass);
        $attendanceDatasss = DB::table('attendances')
        ->leftjoin('teammembers','teammembers.id','attendances.employee_name')
        ->leftjoin('roles','roles.id','teammembers.role_id')
			->where('teammembers.role_id',19)
       // ->where('teammembers.employment_status','Intern')
        ->select('attendances.*','teammembers.team_member','teammembers.employment_status','roles.rolename','teammembers.joining_date')->paginate(150);
//dd($attendanceData);
        return view('backEnd.attendance.index',compact('attendanceDatas','attendanceDatass','attendanceDatasss'));
    }
		elseif(auth()->user()->teammember_id == 406) // access to skultala -- support staff attendance
        {
            $attendanceDatas = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                ->WhereIn('teammembers.id', ['558','418','645','549','318','660','647'])   //manual attendance - support staff
                ->select('attendances.*', 'teammembers.team_member','teammembers.joining_date', 'teammembers.employment_status', 'roles.rolename')->get();

                return view('backEnd.attendance.staff-index', compact('attendanceDatas'));

        }
    abort(403, ' you have no permission to access this page ');
    }
	public function attendances(Request $request )
    {
     //   dd($request);
    if(auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18){
        $attendanceDatas = DB::table('attendances')
        ->leftjoin('teammembers','teammembers.id','attendances.employee_name')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        //->where('teammembers.employment_status','CA Article')
			->where('teammembers.role_id',15)
        ->where('attendances.month',$request->month)
        ->select('attendances.*','teammembers.team_member','teammembers.employment_status','roles.rolename','teammembers.joining_date')->get();
	
        $attendanceDatass = DB::table('attendances')
        ->leftjoin('teammembers','teammembers.id','attendances.employee_name')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        //->where('teammembers.employment_status','Employee')
			->whereNotIn('role_id', ['11', '12', '13','15','19','20'])
			//->whereNotIn('employee_name', ['170', '169', '307','447','336'])
       
        ->where('attendances.month',$request->month)
			
		
		
        ->select('attendances.*','teammembers.team_member','teammembers.employment_status','roles.rolename','teammembers.joining_date')->get();
			
        $attendanceDatasss = DB::table('attendances')
        ->leftjoin('teammembers','teammembers.id','attendances.employee_name')
        ->leftjoin('roles','roles.id','teammembers.role_id')
       // ->where('teammembers.employment_status','Intern')
			->where('teammembers.role_id',19)
        ->where('attendances.month',$request->month)
        ->select('attendances.*','teammembers.team_member','teammembers.employment_status','roles.rolename','teammembers.joining_date')->get();
//dd($attendanceData);
        return view('backEnd.attendance.index',compact('attendanceDatas','attendanceDatass','attendanceDatasss'));
    }
		
elseif(auth()->user()->teammember_id == 406) // access to skultala -- support staff attendance
        {
            $attendanceDatas = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                ->WhereIn('teammembers.id', ['558','418','645','549','318','660','647'])   //manual attendance - support staff
                ->where('attendances.month', $request->month)
                ->select('attendances.*', 'teammembers.team_member','teammembers.joining_date', 'teammembers.employment_status', 'roles.rolename')->get();

                return view('backEnd.attendance.staff-index', compact('attendanceDatas'));

        }
    abort(403, ' you have no permission to access this page ');
    }
	
	public function update(Request $request)
    {
        // Retrieve the attendance data
        $attendanceId = $request->attendance_id;

        // Prepare an array of fields to update
        $fieldsToUpdate = [];
        $fields = ['sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'total_no_of_days', 'no_of_days_present', 'casual_leave', 'sick_leave', 'comp_off', 'birthday_religious', 'lwp', 'absent', 'totaldaystobepaid', 'comment'];

        foreach ($fields as $field) {
            $fieldsToUpdate[$field] = $request->input($field);
        }


        // Update the attendance data
        Attendance::where('id', $attendanceId)->update($fieldsToUpdate);

        // Redirect or perform other actions as needed
        return redirect()->back()->with('success', 'Attendance updated successfully');
    }
}
