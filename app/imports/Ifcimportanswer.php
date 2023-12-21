<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Ifcimportanswer implements ToModel, WithHeadingRow
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
	$data['identification_risk']=$row->identification_risk;
	$data['as_is_control']=$row->as_is_control;
	$data['fraud_risk']=$row->fraud_risk;
	$data['risk_rating']=$row->risk_rating;
	$data['whether_key']=$row->whether_key;
	$data['automated_manual']=$row->automated_manual;
	$data['preventive_detective']=$row->preventive_detective;
	$data['control_frequency']=$row->control_frequency;
	$data['concerned_person']=$row->concerned_person;
	$data['process_design_gap']=$row->process_design_gap;
	$data['design_gap']=$row->design_gap;
	$data['methodology']=$row->methodology;
	$data['result']=$row->result;
	$data['recommendations']=$row->recommendations;
	$data['remarks']=$row->remarks;
	$data['management_comments']=$row->management_comments;

	return $data;
     //   dd($data); die;
}


}
