<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Atrimport implements ToModel, WithHeadingRow
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
	$data['fy']=$row->fy;
	$data['quarter']=$row->quarter;
	$data['area']=$row->area;
	$data['observations']=$row->observations;
	$data['risk']=$row->risk;
//$data['management_comments']=$row->management_comments;
//	$data['status']=$row->status;
	
	return $data;
     //   dd($data); die;
}


}
