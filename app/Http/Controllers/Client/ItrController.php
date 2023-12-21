<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Ilrbank;
use App\Models\Ilrsalary;
use App\Models\Ilraddinformationsecond;
use App\Models\Ilraddinformationthird;
use App\Models\Ilraddinformationfirst;
use App\Models\Ilrhouse;
use App\Models\Ilrfrombusiness;
use App\Models\Ilrfromcapitalgain;
use App\Models\Ilrfromsource;
use App\Models\Ilrdeduction;
use App\Models\Ilrpersonal;
use Illuminate\Http\Request;
use DB;
class ItrController extends Controller
{
    public function __construct()   
    {
        $this->middleware('auth:clientlogin');
    }
    public function ilrdeduction(Request $request)
    {
       $id = $request->informationresource_id;
		 $folderid = DB::table('ilrfolders')
       ->where('id',$id)->first();
       $personals = DB::table('ilrdeductions')
       ->where('informationresource_id',$id)->first();
       return view('client.information.ilrdeduction',compact('id','personals','folderid'));
    }
    public function ilrbp(Request $request)
    {
       $id = $request->informationresource_id;
		  $folderid = DB::table('ilrfolders')
       ->where('id',$id)->first();
       $personals = DB::table('ilrfrombusinesses')
       ->where('informationresource_id',$id)->first();
       return view('client.information.ilrbp',compact('id','personals','folderid'));
    }
	  public function ilraddinformationthirdStore(Request $request)
    {
        //dd($request);
        $request->validate([
             'Name_of_Partnership' => "required"
       ]);

         try {
             $data=$request->except(['_token']);
             $data['clientlogin_id'] = auth()->user()->id;

             $data['client_id'] =auth()->user()->client_id;
             Ilraddinformationthird::Create($data);
             $output = array('msg' => 'Create Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
     
 }
    public function ilraddinformationfirstStore(Request $request)
    {
        //dd($request);
        $request->validate([
             'nameofthecompany' => "required"
       ]);

         try {
             $data=$request->except(['_token']);
             $data['clientlogin_id'] = auth()->user()->id;

             $data['client_id'] =auth()->user()->client_id;
             Ilraddinformationfirst::Create($data);
             $output = array('msg' => 'Create Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
     
 }
	  public function ilraddinformationsecondStore(Request $request)
    {
        //dd($request);
        $request->validate([
           'Name_of_the' => "required"
       ]);

         try {
            $data=$request->except(['_token']);
             $data['clientlogin_id'] = auth()->user()->id;

             $data['client_id'] =auth()->user()->client_id;
             Ilraddinformationsecond::Create($data);
             $output = array('msg' => 'Create Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
     
 }
    public function ilrbpStore(Request $request)
    { 
      //  $request->validate([
        //    'nameofthebusiness' => "required",
      //  ]);

        try {
            $data=$request->except(['_token']);
           $info = DB::table('ilrfrombusinesses')
            ->where('informationresource_id',$request->informationresource_id)->first();
         //   dd($info);
if($info == null){
    $data['clientlogin_id'] = auth()->user()->id;
    $data['client_id'] =auth()->user()->client_id;
    if($request->hasFile('If_company_is_coveredfile'))
    {
            $file=$request->file('If_company_is_coveredfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['If_company_is_coveredfile'] = $name;
    }
    if($request->hasFile('If_company_is_not_coveredfile'))
    {
           $file=$request->file('If_company_is_not_coveredfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['If_company_is_not_coveredfile'] = $name;
    }
    if($request->hasFile('Books_of_accountsfile'))
    {
           $file=$request->file('Books_of_accountsfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['Books_of_accountsfile'] = $name;
    }
    if($request->hasFile('otherfile'))
    {
            $file=$request->file('otherfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['otherfile'] = $name;
    }
    Ilrfrombusiness::Create($data);
}
       else
       {
        $data=$request->except(['_token']);
        if($request->hasFile('If_company_is_coveredfile'))
        {
                  $file=$request->file('If_company_is_coveredfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['If_company_is_coveredfile'] = $name;
        }
        if($request->hasFile('If_company_is_not_coveredfile'))
        {
                   $file=$request->file('If_company_is_not_coveredfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['If_company_is_not_coveredfile'] = $name;
        }
        if($request->hasFile('Books_of_accountsfile'))
        {
                  $file=$request->file('Books_of_accountsfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['Books_of_accountsfile'] = $name;
        }
        if($request->hasFile('otherfile'))
        {
                 $file=$request->file('otherfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['otherfile'] = $name;
        }
        Ilrfrombusiness::find($info->id)->update($data);
       }    
     
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', $output);
        
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
  public function ilrbankEdit(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $ilrbank = DB::table('ilrbanks')
              ->where('id',$request->id)->first();
    
                return response()->json($ilrbank);
             }
            }
    
    }
	public function ilrbankUpdate(Request $request)
    {
      $request->validate([
            'bank_name' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
            if($request->hasFile('bankstatement'))
            {
                 	  $file=$request->file('bankstatement');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbank',$name,'s3');
           $data['bankstatement'] = $name;
            }
            $data['clientlogin_id'] = auth()->user()->id;
            $data['client_id'] =auth()->user()->client_id;

            Ilrbank::find($request->id)->update($data);
            $output = array('msg' => 'Update Successfully');
            return back()->with('success', $output);
        
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
	 public function ilrhouseEdit(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $ilrbank = DB::table('ilrhouses')
              ->where('id',$request->id)->first();
    
                return response()->json($ilrbank);
             }
            }
    
    }
	 public function ilrhouseUpdate(Request $request)
    {
      $request->validate([
            'house_type' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
            if($request->hasFile('rent_receivedfile'))
            {
					  $file=$request->file('rent_receivedfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrhouse',$name,'s3');
           $data['rent_receivedfile'] = $name;
            }
            if($request->hasFile('rent_amountfile'))
            {
     
				  $file=$request->file('rent_amountfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrhouse',$name,'s3');
           $data['rent_amountfile'] = $name;
            }
            if($request->hasFile('tax_paidfile'))
            {
				 $file=$request->file('tax_paidfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrhouse',$name,'s3');
           $data['tax_paidfile'] = $name;
				
            }
            if($request->hasFile('paymentfile'))
            {
                   	 $file=$request->file('paymentfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrhouse',$name,'s3');
           $data['paymentfile'] = $name;
            }
            if($request->hasFile('anyotherdetailsfile'))
            {
                   	 $file=$request->file('anyotherdetailsfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrhouse',$name,'s3');
           $data['anyotherdetailsfile'] = $name;
            }
            $data['clientlogin_id'] = auth()->user()->id;
            $data['client_id'] =auth()->user()->client_id;

            Ilrhouse::find($request->id)->update($data);
     
            $output = array('msg' => 'Update Successfully');
            return back()->with('success', $output);
        
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
public function income(Request $request)
{
   $id = $request->informationresource_id;
	 $folderid = DB::table('ilrfolders')
   ->where('id',$id)->first();
   $personal = DB::table('ilrfromcapitalgains')
   ->where('informationresource_id',$id)->get();
  // dd($personals);
   return view('client.information.incomefromcapitalgains',compact('id','personal','folderid'));
}
	 public function incomefromcapitalgainsEdit(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $ilrsalaries = DB::table('ilrfromcapitalgains')
              ->where('id',$request->id)->first();
    
                return response()->json($ilrsalaries);
             }
            }
    
    }
	public function incomefromcapitalgainsUpdate(Request $request)
    {
        //  dd($request->id);
      //  $request->validate([
// //         'assetsold' => "required",
      //   ]);

        try {
            $data=$request->except(['_token']);
          
    if($request->hasFile('purchasedeedfile'))
    {
         $file=$request->file('purchasedeedfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['purchasedeedfile'] = $name;
		
    }
    if($request->hasFile('costfile'))
    {
            $file=$request->file('costfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['costfile'] = $name;
    }
    if($request->hasFile('anyinvestmentfile'))
    {
              $file=$request->file('anyinvestmentfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['anyinvestmentfile'] = $name;
    }
    if($request->hasFile('mutualfundfile'))
    {
              $file=$request->file('mutualfundfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['mutualfundfile'] = $name;
    }
    if($request->hasFile('Purchasefile'))
    {
              $file=$request->file('Purchasefile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['Purchasefile'] = $name;
    }
    if($request->hasFile('capitalgainfile'))
    {
             $file=$request->file('capitalgainfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['capitalgainfile'] = $name;
    }
    if($request->hasFile('otherfile'))
    {
         $file=$request->file('otherfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['otherfile'] = $name;
    }
    if($request->hasFile('saledeedfile'))
    {
            $file=$request->file('saledeedfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['saledeedfile'] = $name;
    }
    $data['clientlogin_id'] = auth()->user()->id;

    $data['client_id'] =auth()->user()->client_id;

    Ilrfromcapitalgain::find($request->id)->update($data);
     
            $output = array('msg' => 'Update Successfully');
            return back()->with('success', $output);
        
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
	 public function ilrsalaryEdit(Request $request)
    {
      //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
               // dd($request->id);
                $ilrsalaries = DB::table('ilrsalaries')
              ->where('id',$request->id)->first();
    
                return response()->json($ilrsalaries);
             }
            }
    
    }
    public function ilrsalaryUpdate(Request $request)
    { 
        $request->validate([
            'nameoftheemployee' => "required",
        ]);

        try {
            $data=$request->except(['_token']);
             if($request->hasFile('salaryincomefile'))
            {
                  //    $file=$request->file('salaryincomefile');
                  //   $destinationPath = 'backEnd/image/ilrsalary';
                  //   $name = $file->getClientOriginalName();
                  //  $s = $file->move($destinationPath, $name);
                  //        $data['salaryincomefile'] = $name;
                  $file=$request->file('salaryincomefile');
                  $name = $file->getClientOriginalName();
                  $path = $file->storeAs('itr/ilrsalary',$name,'s3');
                $data['salaryincomefile'] = $name; 
            }
            if($request->hasFile('anyotherdetailfile'))
            {
                  //    $file=$request->file('anyotherdetailfile');
                  //   $destinationPath = 'backEnd/image/anyotherdetail';
                  //   $name = $file->getClientOriginalName();
                  //  $s = $file->move($destinationPath, $name);
                  //        $data['anyotherdetailfile'] = $name;
                  $file=$request->file('anyotherdetailfile');
                  $name = $file->getClientOriginalName();
                  $path = $file->storeAs('itr/anyotherdetail',$name,'s3');
                $data['anyotherdetailfile'] = $name; 
            }
            $data['clientlogin_id'] = auth()->user()->id;
            $data['client_id'] =auth()->user()->client_id;

            Ilrsalary::find($request->id)->update($data);
     
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', $output);
        
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    
}
public function incomefromcapitalgainsStore(Request $request)
{ 
//     $request->validate([
//         'assetsold' => "required",
//     ]);

    try {
        $data=$request->except(['_token']);
       $info = DB::table('ilrfromcapitalgains')
        ->where('informationresource_id',$request->informationresource_id)->first();
     //   dd($info);
$data['clientlogin_id'] = auth()->user()->id;
$data['client_id'] =auth()->user()->client_id;
if($request->hasFile('purchasedeedfile'))
{
      //    $file=$request->file('purchasedeedfile');
      //   $destinationPath = 'backEnd/image/ilrbp';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['purchasedeedfile'] = $name;
      $file=$request->file('purchasedeedfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['purchasedeedfile'] = $name; 
}
if($request->hasFile('costfile'))
{
      //    $file=$request->file('costfile');
      //   $destinationPath = 'backEnd/image/ilrbp';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['costfile'] = $name;
      $file=$request->file('costfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['costfile'] = $name;
}
if($request->hasFile('anyinvestmentfile'))
{
      //    $file=$request->file('anyinvestmentfile');
      //   $destinationPath = 'backEnd/image/ilrbp';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['anyinvestmentfile'] = $name;
      $file=$request->file('anyinvestmentfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['anyinvestmentfile'] = $name;
}
if($request->hasFile('mutualfundfile'))
{
      //    $file=$request->file('mutualfundfile');
      //   $destinationPath = 'backEnd/image/ilrbp';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['mutualfundfile'] = $name;
      $file=$request->file('mutualfundfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['mutualfundfile'] = $name;
}
if($request->hasFile('Purchasefile'))
{
      //    $file=$request->file('Purchasefile');
      //   $destinationPath = 'backEnd/image/ilrbp';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['Purchasefile'] = $name;
      $file=$request->file('Purchasefile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['Purchasefile'] = $name;
}
if($request->hasFile('capitalgainfile'))
{
      //    $file=$request->file('capitalgainfile');
      //   $destinationPath = 'backEnd/image/ilrbp';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['capitalgainfile'] = $name;
      $file=$request->file('capitalgainfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['capitalgainfile'] = $name;
}
if($request->hasFile('otherfile'))
{
      //    $file=$request->file('otherfile');
      //   $destinationPath = 'backEnd/image/ilrbp';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['otherfile'] = $name;
      $file=$request->file('otherfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['otherfile'] = $name;
}
if($request->hasFile('saledeedfile'))
{
      //    $file=$request->file('saledeedfile');
      //   $destinationPath = 'backEnd/image/ilrbp';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['saledeedfile'] = $name;
      $file=$request->file('saledeedfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['saledeedfile'] = $name;
}
Ilrfromcapitalgain::Create($data);  
 
        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', $output);
    
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }

}
public function incomefromsources(Request $request)
{
   $id = $request->informationresource_id;
	  $folderid = DB::table('ilrfolders')
   ->where('id',$id)->first();
   $personals = DB::table('ilrfromsources')
   ->where('informationresource_id',$id)->first();
   return view('client.information.incomefromsources',compact('id','personals','folderid'));
}
public function incomefromsourcesStore(Request $request)
{ 
//     $request->validate([
//         'interestfromsaving' => "required",
//     ]);

    try {
        $data=$request->except(['_token']);
       $info = DB::table('ilrfromsources')
        ->where('informationresource_id',$request->informationresource_id)->first();
     //   dd($info);
if($info == null){
$data['clientlogin_id'] = auth()->user()->id;
$data['client_id'] =auth()->user()->client_id;
if($request->hasFile('interestfromsavingfile'))
{
        $file=$request->file('interestfromsavingfile');
             $name = $file->getClientOriginalName();
             $path = $file->storeAs('itr/ilrbp',$name,'s3');
           $data['interestfromsavingfile'] = $name;
}
if($request->hasFile('interestfromfdrfile'))
{
  $file=$request->file('interestfromfdrfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrbp',$name,'s3');
$data['interestfromfdrfile'] = $name;
}
if($request->hasFile('otherfile'))
{
  $file=$request->file('otherfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrbp',$name,'s3');
$data['otherfile'] = $name;
}
if($request->hasFile('dividendfile'))
{
  $file=$request->file('dividendfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrbp',$name,'s3');
$data['dividendfile'] = $name;
}
if($request->hasFile('anyotherfile'))
{
  $file=$request->file('anyotherfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrbp',$name,'s3');
$data['anyotherfile'] = $name;
}
Ilrfromsource::Create($data);
}
   else
   {
    $data=$request->except(['_token']);
    if($request->hasFile('interestfromsavingfile'))
    {
      $file=$request->file('interestfromsavingfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['interestfromsavingfile'] = $name;
    }
    if($request->hasFile('interestfromfdrfile'))
    {
      $file=$request->file('interestfromfdrfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['interestfromfdrfile'] = $name;
    }
    if($request->hasFile('otherfile'))
    {
      $file=$request->file('otherfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['otherfile'] = $name;
    }
    if($request->hasFile('dividendfile'))
    {
      $file=$request->file('dividendfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['dividendfile'] = $name;
    }
    if($request->hasFile('anyotherfile'))
    {
      $file=$request->file('anyotherfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrbp',$name,'s3');
    $data['anyotherfile'] = $name;
    }
    Ilrfromsource::find($info->id)->update($data);
   }    
 
        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', $output);
    
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }

}
public function ilrpersonal(Request $request)
{
   $id = $request->informationresource_id;
	 $folderid = DB::table('ilrfolders')
 ->where('id',$id)->first();
   $personals = DB::table('ilrpersonals')
   ->where('informationresource_id',$id)->first();
   return view('client.information.ilrpersonalinformation',compact('id','personals','folderid'));
}
public function ilrperStore(Request $request)
{ 
   
  //  $request->validate([
    //    'name' => "required",
  //  ]);

    try {
        $data=$request->except(['_token']);
       $info = DB::table('ilrpersonals')
        ->where('informationresource_id',$request->informationresource_id)->first();
     //   dd($info);
if($info == null){
$data['clientlogin_id'] = auth()->user()->id;
$data['client_id'] =auth()->user()->client_id;
if($request->hasFile('panfile'))
{
        $file=$request->file('panfile');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrper',$name,'s3');
                     $data['panfile'] = $name;
}
if($request->hasFile('adharnofile'))
{
        $file=$request->file('adharnofile');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrper',$name,'s3');
                     $data['adharnofile'] = $name;
}
Ilrpersonal::Create($data);
}
   else
   {
    $data=$request->except(['_token']);
    if($request->hasFile('panfile'))
    {
             $file=$request->file('panfile');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrper',$name,'s3');
                     $data['panfile'] = $name;
    }
    if($request->hasFile('adharnofile'))
    {
            $file=$request->file('adharnofile');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrper',$name,'s3');
                     $data['adharnofile'] = $name;
    }
     Ilrpersonal::find($info->id)->update($data);
   }    
 
        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', $output);
    
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }

}
public function ilrdeductionStore(Request $request)
{ 
  //  $request->validate([
    //    'ppf' => "required",
  //  ]);

    try {
        $data=$request->except(['_token']);
       $info = DB::table('ilrdeductions')
        ->where('informationresource_id',$request->informationresource_id)->first();
     //   dd($info);
if($info == null){
$data['clientlogin_id'] = auth()->user()->id;
$data['client_id'] =auth()->user()->client_id;
if($request->hasFile('ppffile'))
{
       

             $file=$request->file('ppffile');
             //   $destinationPath =  storage_path('app/backEnd/image/talentedgeilr');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrdedu',$name,'s3');
                     $data['ppffile'] = $name;
}
if($request->hasFile('house_loanfile'))
{
      //    $file=$request->file('house_loanfile');
      //   $destinationPath = 'backEnd/image/ilrdedu';
      //   $name = $file->getClientOriginalName();
      //  $s = $file->move($destinationPath, $name);
      //        $data['house_loanfile'] = $name;
      $file=$request->file('house_loanfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['house_loanfile'] = $name;
}
if($request->hasFile('insurancefile'))
{
  $file=$request->file('insurancefile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrdedu',$name,'s3');
       $data['insurancefile'] = $name;
}
if($request->hasFile('mutual_fundfile'))
{
  $file=$request->file('mutual_fundfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrdedu',$name,'s3');
       $data['mutual_fundfile'] = $name;
}
if($request->hasFile('childrenfile'))
{
        
  $file=$request->file('childrenfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrdedu',$name,'s3');
       $data['childrenfile'] = $name;
}
if($request->hasFile('investmentfile'))
{
               
  $file=$request->file('investmentfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrdedu',$name,'s3');
       $data['investmentfile'] = $name;
}
if($request->hasFile('amountfile'))
{
  $file=$request->file('amountfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrdedu',$name,'s3');
       $data['amountfile'] = $name;
}
if($request->hasFile('Mediclaimfile'))
{
  $file=$request->file('Mediclaimfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrdedu',$name,'s3');
       $data['Mediclaimfile'] = $name;
}
if($request->hasFile('parentsfile'))
{
  $file=$request->file('parentsfile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrdedu',$name,'s3');
       $data['parentsfile'] = $name;
}
if($request->hasFile('eligiblefile'))
{
  $file=$request->file('eligiblefile');
  $name = $file->getClientOriginalName();
  $path = $file->storeAs('itr/ilrdedu',$name,'s3');
       $data['eligiblefile'] = $name;
}
Ilrdeduction::Create($data);
}
   else
   {
    $data=$request->except(['_token']);
    if($request->hasFile('ppffile'))
    {
             $file=$request->file('ppffile');
             //   $destinationPath =  storage_path('app/backEnd/image/talentedgeilr');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('itr/ilrdedu',$name,'s3');
                     $data['ppffile'] = $name;
    }
    if($request->hasFile('house_loanfile'))
    {
      $file=$request->file('house_loanfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['house_loanfile'] = $name;
    }
    if($request->hasFile('insurancefile'))
    {
      $file=$request->file('insurancefile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['insurancefile'] = $name;
    }
    if($request->hasFile('mutual_fundfile'))
    {
      $file=$request->file('mutual_fundfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['mutual_fundfile'] = $name;
    }
    if($request->hasFile('childrenfile'))
    {
      $file=$request->file('childrenfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['childrenfile'] = $name;
    }
    if($request->hasFile('investmentfile'))
    {
      $file=$request->file('investmentfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['investmentfile'] = $name;
    }
    if($request->hasFile('amountfile'))
    {
      $file=$request->file('amountfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['amountfile'] = $name;
    }
    if($request->hasFile('Mediclaimfile'))
    {
      $file=$request->file('Mediclaimfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['Mediclaimfile'] = $name;
    }
    if($request->hasFile('parentsfile'))
    {
      $file=$request->file('parentsfile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['parentsfile'] = $name;
    }
    if($request->hasFile('eligiblefile'))
    {
      $file=$request->file('eligiblefile');
      $name = $file->getClientOriginalName();
      $path = $file->storeAs('itr/ilrdedu',$name,'s3');
           $data['eligiblefile'] = $name;
    }
    Ilrdeduction::find($info->id)->update($data);
   }    
 
        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', $output);
    
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }

}
}