<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Debtorimport implements ToModel, WithHeadingRow
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
	$data['name']=$row->name;
	$data['amount']=$row->amount;
	$data['year']=$row->year;
	$data['date']=$row->date;
	$data['address']=$row->address;
    $data['email']=$row->email;

	return $data;
       // dd($data); die;
}


}
