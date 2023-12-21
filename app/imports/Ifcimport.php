<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Ifcimport implements ToModel, WithHeadingRow
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
	$data['control_number']=$row->control_number;
	$data['sub_process']=$row->sub_process;
	$data['control_objective']=$row->control_objective;
	$data['identification_risk']=$row->identification_risk;

	return $data;
     //   dd($data); die;
}


}
