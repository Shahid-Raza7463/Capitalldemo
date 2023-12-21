<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Stepchecklistimport implements ToModel, WithHeadingRow
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
	$data['stepname']=$row->stepname;
	$data['financialstatementclassifications']=$row->financialstatementclassifications;
	$data['financialstatementsubclassifications']=$row->financialstatementsubclassifications;
	$data['auditprocedure']=$row->auditprocedure;

	return $data;
}


}
