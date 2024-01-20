<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use DB;

class DataTableExport implements FromView, WithHeadings
{
    private $entityId;

    public function __construct($entityId)
    {
        $this->entityId = $entityId;
    }

    public function view(): View
    {
        $employeepayrollDatas = $this->getEmployeePayrollData();
        $data = $this->transformData($employeepayrollDatas);

        return view('backEnd.employeepayroll.datatable', [
            'data' => $data,
            'headers' => $this->getHeaders(),
        ]);
    }

    public function headings(): array
    {
        return $this->getHeaders();
    }

    private function getEmployeePayrollData()
    {
        $teammemberIds = DB::table('teammembers')
            ->where('entity', $this->entityId)
            ->pluck('id');
		//dd($teammemberIds);

        $payrollData = DB::table('employeepayrolls')
            ->whereIn('teammember_id', $teammemberIds)
            ->where('level_three',1)
			->where('send_to_bank',0)
            ->select(
                'id',
                'teammember_id',
                'month',
                'totaldays',
                'no_of_day_present',
                'sl',
                'cl',
                'co',
                'birthday',
                'day_to_be_paid',
                'amount',
                'employee_contribution',
                'employer_contribution',
                'advance',
                'tds',
                'Arrear',
                'bonus',
                'total_amount_to_paid'
            )
            ->get();

          // dd($payrollData);

           /*if ($payrollData->isEmpty()) {
            // Generate JavaScript code to display the alert message
            $alertScript = "<script>alert('Please approve the Sheet first.');</script>";
            
            // Output the JavaScript code
            echo $alertScript;
            
            // Use JavaScript to perform the redirection after the alert is displayed
            echo "<script>window.location.href = '/employeepayroll';</script>";
            
            // Stop further execution of PHP code
            exit();
        }
        else{
                    return $payrollData;
            }*/
		
		 return $payrollData;
          
    }

    private function transformData($employeepayrollDatas)
    {
        $data = [];
        $i = 0;

        foreach ($employeepayrollDatas as $employeepayrollData) {
            $employee = DB::table('teammembers')
                ->where('id', $employeepayrollData->teammember_id)
                ->first();
			
				if( $employee->entity=="Capitall India Pvt. Ltd.")
				{
				$trans_id="885326";
				$sender_acc_no="080063700004260";	
				}
				elseif( $employee->entity=="GVRIKSH")
				{
				$trans_id="909135";
				$sender_acc_no="921010008132083";	
				}
			
			elseif( $employee->entity=="K G Somani & Co LLP")
				{
				$trans_id="1129";
				$sender_acc_no="235305001680";	
				}
			elseif( $employee->entity=="KGS Advisors LLP")
				{
				$trans_id="252";
				$sender_acc_no="235305001722";	
				}
            
            $data[] = [
                'Sr. No.' => ++$i,
                'TRAN.ID'=>$trans_id,
                'Amount' =>number_format(round($employeepayrollData->total_amount_to_paid),0),
                'SENDER ACCOUNT TYPE' => '10',
                'SENDER ACCOUNT NO' => "'".$sender_acc_no, // Prefix with a single quotation mark
                'SENDER NAME' => $employee->entity,
                'SMS EML' => 'EML',
                'Detail' => 'accounts@kgsomani.com',
                'OoR7002 (SENDER NAME)' => $employee->entity,
                'IFSC_Code' => $employee->ifsccode,
                'BENEFICIARY ACCOUNT TYPE' => '11',
                'Bank_Account_Number' => "'" . $employee->bankaccountnumber, // Prefix with a single quotation mark
                'Beneficiary_Name' => $employee->team_member,
                'SENDER TO RECEIVER INFORMATION' => 'Salary',
            ];
        }

        return $data;
    }

    private function getHeaders()
    {
        return [
            'Sr. No.',
            'TRAN.ID',
            'Amount',
            'SENDER ACCOUNT TYPE',
            'SENDER ACCOUNT NO',
            'SENDER NAME',
            'SMS EML',
            'Detail',
            'OoR7002 (SENDER NAME)',
            'IFSC_Code',
            'BENEFICIARY ACCOUNT TYPE',
            'Bank_Account_Number',
            'Beneficiary_Name',
            'SENDER TO RECEIVER INFORMATION',
        ];
    }
}
