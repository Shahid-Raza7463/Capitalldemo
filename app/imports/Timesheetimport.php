<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Timesheetimport implements ToModel, WithHeadingRow
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
	
	$data['clientname']=$row->clientname;
	$data['assignmentname']=$row->assignmentname;
	$data['partner']=$row->partner;
	$data['workitem']=$row->workitem;
	$data['billablestatus']=$row->billablestatus;
    $data['hour']=$row->hour;
    $data['date']=$row->date;
    
	return $data;
       // dd($data); die;
}


}
