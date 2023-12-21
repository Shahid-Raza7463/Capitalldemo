<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Payrollimport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
public function model(array $row)
{
	 	$data['name_of_employee']=$row->name_of_employee;
		$data['entity']=$row->entity;
	$data['no_of_days_present']=$row->no_of_days_present;
	$data['partner_incharge']=$row->partner_incharge;
	$data['casual_leave']=$row->casual_leave;
	$data['sick_leave']=$row->sick_leave;
	$data['compensatory_off']=$row->compensatory_off;
	$data['bithday_leave']=$row->bithday_leave;
	$data['lwp']=$row->lwp;
 	$data['monthly_gross_salary']=$row->monthly_gross_salary;
 	$data['amount']=$row->amount;
	$data['advance']=$row->advance;
 	$data['tds']=$row->tds;
	$data['add_gst_input']=$row->add_gst_input;
 	$data['arrear']=$row->arrear;
	$data['bonus']=$row->bonus;
 	$data['total_amount_to_paid']=$row->total_amount_to_paid;
	$data['total_days_to_be_paid']=$row->total_days_to_be_paid;
	$data['pfyn']=$row->pfyn;
	$data['employee_contribution']=$row->employee_contribution;
	$data['employer_contribution']=$row->employer_contribution;
$data['remarks']=$row->remarks;
	
	return $data;
     //   dd($data); die;
}


}
