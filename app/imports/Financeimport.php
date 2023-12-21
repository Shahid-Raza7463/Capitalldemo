<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Financeimport implements ToModel, WithHeadingRow
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
	$data['modal_name']=$row->modal_name;
	$data['sno']=$row->sno;
	$data['company_name']=$row->company_name;
    $data['kgs']=$row->kgs;
    $data['mac_address']=$row->mac_address;

	return $data;
       // dd($data); die;
}


}
