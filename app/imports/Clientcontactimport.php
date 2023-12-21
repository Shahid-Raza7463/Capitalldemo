<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Clientcontactimport implements ToModel, WithHeadingRow
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
$data['mentorid']=$row->mentorid;
//	$data['bankaccountnumber']=$row->bankaccountnumber;
//$data['beneficiary_name']=$row->beneficiary_name;
 
//	$data['clientstaff']=$row->clientstaff;
 //  $data['clientemail']=$row->clientemail;
//	$data['clientphone']=$row->clientphone;
 //  $data['clientdesignation']=$row->clientdesignation;
  //  $data['clientname']=$row->clientname;
//$data['id']=$row->id;
//$data['mobile_no']=$row->mobile_no;
//	$data['emergencycontactnumber']=$row->emergencycontactnumber;
//	$data['profilepic']=$row->profilepic;
	
	return $data;
     //   dd($data); die;
}


}
