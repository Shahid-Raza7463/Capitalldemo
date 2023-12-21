<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Payrollarticleimport implements ToModel, WithHeadingRow
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
	$data['entity']=$row->entity;
	$data['category']=$row->category;
	$data['doj']=$row->doj;
	$data['year']=$row->year;
	$data['location']=$row->location;
	$data['stipend']=$row->stipend;
	$data['totalnoofdays']=$row->totalnoofdays;
	$data['noofdayspresent']=$row->noofdayspresent;
	$data['leave']=$row->leave;
	$data['co']=$row->co;
	$data['birthdayleave']=$row->birthdayleave;
	$data['totaldaystobepaid']=$row->totaldaystobepaid;
	$data['totalstipend']=$row->totalstipend;
	$data['arrear']=$row->arrear;
	$data['amounttobepaid']=$row->amounttobepaid;

	return $data;
     //   dd($data); die;
}


}
