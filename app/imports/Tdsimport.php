<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Tdsimport implements ToModel, WithHeadingRow
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
	$data['emailid']=$row->emailid;
	$data['grosssalary']=$row->grosssalary;
	$data['tds']=$row->tds;
	$data['pf']=$row->pf;
	

	return $data;
     //   dd($data); die;
}


}
