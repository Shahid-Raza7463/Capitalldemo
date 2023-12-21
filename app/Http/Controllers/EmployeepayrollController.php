<?php

namespace App\Http\Controllers;

use App\Mail\PayrollApprovedMail;
use Illuminate\Support\Facades\Session;

use App\Models\Payroll;
use App\Models\Teammember;
use Illuminate\Http\Request;

use App\imports\TeammembersSalaryImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataTableExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Swift_Attachment;


use DB;
class EmployeepayrollController extends Controller
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
	public function employee_payroll(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $outstationconveyances = DB::table('employeepayrolls')->
              where('id',$request->id)->first();
                return response()->json($outstationconveyances);
             }
            }
    
    } 
   public function employeepayroll_update(Request $request)
    {
        try {
          //  dd($request->id);
            $data=$request->except(['_token']);

            $total = $request->amount -$request->employee_contribution- $request->advance - $request->tds + $request->Arrear + $request->bonus;
           // dd($total);
            DB::table('employeepayrolls')->where('id',$request->id)->update([	
                'amount'  => $request->amount,
                'employee_contribution'=>$request->employee_contribution,
                'employer_contribution'=>$request->employer_contribution,
                'tds'  => $request->tds,
                'advance'  => $request->advance,
                'Arrear'  => $request->Arrear,
                'bonus'  => $request->bonus,
                'total_amount_to_paid'  => $total,
                'comment'=>$request->comment,
                 ]);
            $output = array('msg' => 'Updated Successfully');
            return back()->with('success', $output);
     
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
    }
    
    public function payrollData( Request $request ) {
        if ( $request->ajax() ) {

            $teammember = DB::table( 'teammembers' )
            ->join( 'attendances', 'attendances.employee_name', 'teammembers.id' )
            ->where( 'teammembers.id', $request->teammember_id )
            ->where( 'month', $request->month )->first();
            //dd( $teammember );
            return response()->json( $teammember );

        }

        abort( 403, ' you have no permission to access this page ' );
    }
	public function index()
    {

        if (
            auth()->user()->email == "priyankasharma@kgsomani.com" || auth()->user()->email == "vinita@kgsomani.com" ||
            auth()->user()->email == "accounts@kgsomani.com" || auth()->user()->email == "Sanjiv@kgsomani.com"
        ) {
            $employeepayrollDatas = DB::table('employeepayrolls')
                ->leftjoin('teammembers', 'teammembers.id', 'employeepayrolls.teammember_id')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                ->select('employeepayrolls.*', 'teammembers.team_member','teammembers.entity','teammembers.monthly_gross_salary', 					'roles.rolename','teammembers.pf_applicable')
                //->groupBy('employeepayrolls.level_one', 'employeepayrolls.level_two', 'employeepayrolls.level_three')
                ->get();
				//dd($employeepayrollDatas);
            // Retrieve the necessary data from the employeespayrolls table
            $levelOneCount = DB::table('employeepayrolls')->where('level_one', 1)->count();
            $levelTwoCount = DB::table('employeepayrolls')->where('level_two', 1)->count();
            $levelThreeCount = DB::table('employeepayrolls')->where('level_three', 1)->count();
            $totalRecords = DB::table('employeepayrolls')->count();

            // Calculate the percentages
            $levelOnePercentage = ($levelOneCount / $totalRecords) * 100;
            $levelTwoPercentage = ($levelTwoCount / $totalRecords) * 100;
            $levelThreePercentage = ($levelThreeCount / $totalRecords) * 100;

            // Determine the current step based on the conditions
            $currentStep = null;
            if ($levelOnePercentage > 5) {
                $currentStep = 1;
            } 
            if ($levelTwoPercentage > 5) {
                $currentStep = 2;
            } if($levelThreePercentage > 5) {
                $currentStep = 3;
            }
			$kgSomaniCount = DB::table('employeepayrolls')
                ->join('teammembers', 'teammembers.id', '=', 'employeepayrolls.teammember_id')
                ->where('teammembers.entity', 'K G Somani & Co LLP')
                ->where('employeepayrolls.level_three', 1)
                ->count();

            $kgsAdvisorsCount = DB::table('employeepayrolls')
                ->join('teammembers', 'teammembers.id', '=', 'employeepayrolls.teammember_id')
                ->where('teammembers.entity', 'KGS Advisors LLP')
                ->where('employeepayrolls.level_three', 1)
                ->count();

            $capitallIndiaCount = DB::table('employeepayrolls')
                ->join('teammembers', 'teammembers.id', '=', 'employeepayrolls.teammember_id')
                ->where('teammembers.entity', 'Capitall India Pvt. Ltd.')
                ->where('employeepayrolls.level_three', 1)
                ->count();

            $gvrikshCount = DB::table('employeepayrolls')
                ->join('teammembers', 'teammembers.id', '=', 'employeepayrolls.teammember_id')
                ->where('teammembers.entity', 'GVRIKSH')
                ->where('employeepayrolls.level_three', 1)
                ->count();

          $entitySums = DB::table('employeepayrolls')
    ->join('teammembers', 'teammembers.id', '=', 'employeepayrolls.teammember_id')
    ->where('employeepayrolls.level_three', '=', 1)
    ->groupBy('teammembers.entity')
   ->select('teammembers.entity', DB::raw('SUM(ROUND(employeepayrolls.total_amount_to_paid,0)) as totalAmount'))
	->get();
			
            $kgsSum = 0;
            $advisorsSum = 0;
            $capitallSum = 0;
            $gvrikshSum = 0;

            // Assign the sums to individual variables
            foreach ($entitySums as $entitySum) {
                switch ($entitySum->entity) {
                    case 'K G Somani & Co LLP':
                        $kgsSum = $entitySum->totalAmount;
                        break;
                    case 'KGS Advisors LLP':
                        $advisorsSum = $entitySum->totalAmount;
                        break;
                    case 'Capitall India Pvt. Ltd.':
                        $capitallSum = $entitySum->totalAmount;
                        break;
                    case 'GVRIKSH':
                        $gvrikshSum = $entitySum->totalAmount;
                        break;
                }
            }

            return view('backEnd.employeepayroll.payroll', compact('employeepayrollDatas', 'currentStep', 'kgSomaniCount', 'kgsAdvisorsCount', 'capitallIndiaCount', 'gvrikshCount','kgsSum','advisorsSum','capitallSum','gvrikshSum'));
        }
		abort( 403, ' you have no permission to access this page ' );
   
      //  return view('backEnd.employeepayroll.payroll', compact('employeepayrollDatas','currentStep'));
    }
	public function store(Request $request)
    {
       // dd($request);
        $payrollData = [
            'month' => $request->month,
            'teammember_id' => $request->teammember_ids,
            'no_of_day_present' => $request->dayspresent,
            'day_to_be_paid' => $request->total_days_to_be_paid,
            'amount' => $request->amount,
            'employee_contribution' => $request->employee_contri,
            'employer_contribution' => $request->employer_contri,
            'advance' => $request->advance,
            'tds' => $request->tds,
            'Arrear' => $request->arrear,
            'bonus' => $request->bonus,
            'total_amount_to_paid' => $request->total_amount,
            'remark' => $request->remark,
        ];
        DB::table('employeepayrolls')->insert($payrollData);
        Session::flash('success', 'Payroll data inserted successfully');

        return redirect()->back();
        
    
    }

	public function emloyeepayrollview($id)
 {
      $payroll = DB::table('employeepayrolls')->where('id',$id)->first();
    //  dd($payroll);
        $teammember = DB::table('teammembers')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('role_id','!=',11)->where('status',1)->orwhere('role_id','!=',12)
        ->where('teammembers.id','$payroll->teammember_id')
        ->select('teammembers.*','roles.rolename')->first();
      //  dd($teammember);
        return view('backEnd.employeepayroll.view',compact('payroll','teammember'));
  }
	
	 public function payrollApprove(Request $request)
    {
        // Get the selected payroll data IDs from the request
        $selectedPayrollDataIds = explode(",", $request->input('selectedPayrollDataIds'));
        //dd($selectedPayrollDataIds[0]);
        $month = DB::table('employeepayrolls')->where('id', $selectedPayrollDataIds[0])->pluck('month')->first();

        // Get the remarks from the request
        $remarks = $request->input('remarks');

        foreach ($selectedPayrollDataIds as $payrollDataId) {
            // Update the approval_status and remark fields in the employeepayrolls table
            $updateData = [];

            if (auth()->user()->email == "priyankasharma@kgsomani.com") {
                $updateData['level_one'] = 1;
                $payroll = DB::table('employeepayrolls')->find($payrollDataId);


                if ($payroll->level_two == 2) {
                    $updateData['level_two'] = 0;
                }
            } else if (auth()->user()->email == "accounts@kgsomani.com") {
                $updateData['level_two'] = 1;
                $payroll = DB::table('employeepayrolls')->find($payrollDataId);
                if ($payroll->level_three == 2) {
                    $updateData['level_three'] = 0;
                }
            } else if (auth()->user()->email == "Sanjiv@kgsomani.com" || auth()->user()->email == "vinita@kgsomani.com" ) {
                $updateData['level_three'] = 1;
				
				
            }
			



            $updateData['remark'] = $remarks; // Update the remark field with the provided remarks

            DB::table("employeepayrolls")
                ->where('id', $payrollDataId)
                ->update($updateData);
			 
        }
		 
        // Send email to the next level
        $nextLevelEmail = null;
        if (auth()->user()->email == "priyankasharma@kgsomani.com") {
            $nextLevelEmail =  "accounts@kgsomani.com";
        } else if (auth()->user()->email == "accounts@kgsomani.com") {
            $nextLevelEmail =  "Sanjiv@kgsomani.com";
        }
		
        $mailData = [
            'subject' => 'Payroll Approved',
            'body' => "The payroll sheet for the month $month has been sent for your approval",
        ];
       if ($nextLevelEmail) {
      	Mail::to($nextLevelEmail)
			->cc('priyankasharma@kgsomani.com')
			->send(new PayrollApprovedMail($mailData));
      }

        // Return a response or redirect as needed
        return redirect()->back()->with('success', 'Payroll data approved successfully.');
    }
    public function payrollClarification(Request $request)
    {

        // Get the selected payroll data IDs from the request
        $selectedPayrollDataIds = explode(",", $request->input('selectedPayrollDataIds'));
        $employeeNames = TeamMember::whereIn('id', function ($query) use ($selectedPayrollDataIds) {
            $query->select('teammember_id')
                ->from('employeepayrolls')
                ->whereIn('id', $selectedPayrollDataIds);
        })
            ->pluck('team_member')
            ->implode(', ');

        // Get the remarks from the request
        $remarks = $request->input('remarks');

        foreach ($selectedPayrollDataIds as $payrollDataId) {
            // Update the approval_status and remark fields in the employeepayrolls table
            $updateData = [];

            if (auth()->user()->email == "accounts@kgsomani.com") {
                $updateData['level_two'] = 2;
                $updateData['level_one'] = 0;
            } else if (auth()->user()->email == "Sanjiv@kgsomani.com") {
                $updateData['level_three'] = 2;
                $updateData['level_two'] = 0;
            }

            $updateData['remark'] = $remarks; // Update the remark field with the provided remarks

            DB::table("employeepayrolls")
                ->where('id', $payrollDataId)
                ->update($updateData);
        }


        // Send email to the next level
        $previousLevelEmail = null;
        if (auth()->user()->email == "accounts@kgsomani.com") {
            $previousLevelEmail =  "priyankasharma@kgsomani.com";
        } else if (auth()->user()->email == "Sanjiv@kgsomani.com") {
            $previousLevelEmail = "accounts@kgsomani.com";
        }

        $mailData = [
            'subject' => 'Clarification required in payroll',
            'body' => "I hope this email finds you well. This email is to seek clarification regarding certain employee payrolls that require attention before final processing. The following employees' payroll data needs clarification: $employeeNames",
        ];
        if ($previousLevelEmail) {
            Mail::to($previousLevelEmail)->send(new ClarificationRequiredMail($mailData));
        }

        // Return a response or redirect as needed
        return redirect()->back()->with('success', 'Payroll data sent for Clarification.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
   
	public function excelUploadForm()
    {
        return view('backEnd.employeepayroll.upload-excel-form');
    }

   public function excelUpload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        try {
            // Import the data from the Excel file
            $import = new TeammembersSalaryImport();
            $data = Excel::toArray($import, $file);

            // Update the teammembers table based on the email IDs
            foreach ($data[0] as $row) {
                $email = $row['email_id'];
                $grossSalary = $row['gross_salary'];
                if($row['gross_salary']>15000){
                    $salary_range = "Above 15k";
                }
                else
                {
                    $salary_range = "Below 15k";
                }
                $pf_applicable = $row['pf_applicable'];

                // Update the teammember record based on the email
                Teammember::where('emailid', $email)->update([
                    'monthly_gross_salary' => $grossSalary,
                    'pf_applicable' => $pf_applicable,
                    'salary_range' => $salary_range
                ]);
            }

            // Redirect back with success message
            return redirect()->back()->with('success', 'Data imported and updated successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the import process
            return redirect()->back()->with('error', 'Error occurred during import: ' . $e->getMessage());
        }
	   
   }
    }