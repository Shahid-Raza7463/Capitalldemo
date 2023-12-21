<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminitrController extends Controller
{
    public function __construct()   
    {
        $this->middleware('auth');
    }
    public function ilrpersonal(Request $request)
{
   $id = $request->informationresource_id;
   $personals = DB::table('ilrpersonals')
   ->where('informationresource_id',$id)->first();
   return view('backEnd.informationresources.ilrpersonalinformation',compact('id','personals'));
}
public function ilrbp(Request $request)
{
   $id = $request->informationresource_id;
   $personals = DB::table('ilrfrombusinesses')
   ->where('informationresource_id',$id)->first();
   return view('backEnd.informationresources.ilrbp',compact('id','personals'));
}
public function income(Request $request)
{
   // dd($request);
   $id = $request->informationresource_id;
   $personals = DB::table('ilrfromcapitalgains')
   ->where('informationresource_id',$id)->get();
  // dd($personals);
   return view('backEnd.informationresources.incomefromcapitalgains',compact('id','personals'));
}
public function incomefromsources(Request $request)
{
   $id = $request->informationresource_id;
   $personals = DB::table('ilrfromsources')
   ->where('informationresource_id',$id)->first();
   return view('backEnd.informationresources.incomefromsources',compact('id','personals'));
}
public function ilrdeduction(Request $request)
{
   $id = $request->informationresource_id;
   $personals = DB::table('ilrdeductions')
   ->where('informationresource_id',$id)->first();
   return view('backEnd.informationresources.ilrdeduction',compact('id','personals'));
}
}
