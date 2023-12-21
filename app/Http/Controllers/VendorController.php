<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Vendor;
use App\Models\Teammember;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function vendorfetch_id(Request $request)
    {
        //  dd($request);
        if ($request->ajax()) {
            if (isset($request->id)) {
                // dd($request->id);
                $outstationconveyances = DB::table('vendorlist')
                    ->select('vendorlist.id')->where('vendorlist.id', $request->id)->first();
                return response()->json($outstationconveyances);
            }
        }
    }
    public function vendorupdate(Request $request)
    {
        // dd($request);
        try {
            $data = $request->except(['_token']);
            if ($request->status == 4) {
                DB::table('vendorlist')->where('id', $request->vendorid)->update([
                    'status'         =>     $request->status,
                    'payment'         =>     $request->payment,
                    'paymentdate'         =>     $request->paymentdate,
                    'paiddate' => date('Y-m-d H:i:s'),
                ]);
            }


            $output = array('msg' => 'Update Successfully');
            return redirect('vendorlist')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function index()
    {
        if (auth()->user()->teammember_id == 99) {
            $vendorlist = DB::table('vendors')
                ->leftjoin('vendorlist', 'vendorlist.vendor_id', 'vendors.id')
                ->leftjoin('teammembers as team', 'team.id', 'vendorlist.created_by')
                ->leftjoin('teammembers', 'teammembers.id', 'vendorlist.approver')
                // ->where('vendorlist.created_by',auth()->user()->id)
                ->select(
                    'vendorlist.*',
                    'vendors.vendorname',
                    'vendors.email',
                    'vendors.benficiaryname',
                    'vendors.bankname',
                    'vendors.ifsccode',
                    'vendors.accountnumber',
                    'vendors.gstno',
                    'vendors.type',
                    'vendors.phoneno',
                    'vendors.vendoraddress',
                    'team.team_member',
                    'teammembers.team_member as approver'
                )
                ->get();
            return view('backEnd.vendor.index', compact('vendorlist'));
        } elseif (auth()->user()->role_id == 17 || auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
            $vendorlist = DB::table('vendors')
                ->leftjoin('vendorlist', 'vendorlist.vendor_id', 'vendors.id')
                ->leftjoin('teammembers as team', 'team.id', 'vendorlist.created_by')
                ->leftjoin('teammembers', 'teammembers.id', 'vendorlist.approver')
                // ->where('vendorlist.created_by',auth()->user()->id)
                ->select(
                    'vendorlist.*',
                    'vendors.vendorname',
                    'vendors.email',
                    'vendors.benficiaryname',
                    'vendors.bankname',
                    'vendors.ifsccode',
                    'vendors.accountnumber',
                    'vendors.gstno',
                    'vendors.type',
                    'vendors.phoneno',
                    'vendors.vendoraddress',
                    'team.team_member',
                    'teammembers.team_member as approver'
                )
                ->get();
            return view('backEnd.vendor.index', compact('vendorlist'));
        } else {
            $vendorlist = DB::table('vendors')
                ->leftjoin('vendorlist', 'vendorlist.vendor_id', 'vendors.id')
                ->leftjoin('teammembers as team', 'team.id', 'vendorlist.created_by')
                ->leftjoin('teammembers', 'teammembers.id', 'vendorlist.approver')
                ->where('vendorlist.created_by', auth()->user()->teammember_id)
                ->orwhere('vendorlist.approver', auth()->user()->teammember_id)
                ->select(
                    'vendorlist.*',
                    'vendors.vendorname',
                    'vendors.email',
                    'vendors.benficiaryname',
                    'vendors.bankname',
                    'vendors.ifsccode',
                    'vendors.accountnumber',
                    'vendors.gstno',
                    'vendors.type',
                    'vendors.phoneno',
                    'vendors.vendoraddress',
                    'team.team_member',
                    'teammembers.team_member as approver'
                )
                ->get();
            return view('backEnd.vendor.index', compact('vendorlist'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendorList(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->category_id)) {
                $client = Vendor::where('id', $request->category_id)->first();
                //dd($client);
                return response()->json($client);
            }
        }
    }
    public function create()
    {

        $vendorlist = DB::table('vendors')->select('id', 'email', 'vendorname')->get();
        $teammember = Teammember::where('status', '=', 1)->where('role_id', '=', 13)->orwhere('role_id', '=', 14)->with('title', 'role')->get();
        //  dd($vendorlist);
        return view('backEnd.vendor.create', compact('vendorlist', 'teammember'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        //  $request->validate([
        //      'password' => "required"
        //  ]);

        try {
            $data = $request->except(['_token']);
            $vendor = DB::table('vendors')->where('id', $request->vendor_id)->first();
            //  dd($vendor);
            if ($request->hasFile('bill')) {
                $file = $request->file('bill');
                $destinationPath = 'backEnd/image/vendor';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['bill'] = $name;
            } else {
                $data['bill'] = null;
            }
            if ($request->hasFile('panfile')) {
                $file = $request->file('panfile');
                $destinationPath = 'backEnd/image/vendor';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['panfile'] = $name;
            } else {
                $data['panfile'] = null;
            }
            if ($request->hasFile('adharfile')) {
                $file = $request->file('adharfile');
                $destinationPath = 'backEnd/image/vendor';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['adharfile'] = $name;
            } else {
                $data['adharfile'] = null;
            }
            if ($request->type == 2) {
                $randomString = Str::random(7);
                $password =  Hash::make('KGS@' . $randomString);
                $passwords =  'KGS@' . $randomString;
                // dd($passwords);
            } else {
                $password =  null;
            }

            if ($vendor != null) {
                DB::table('vendors')->where('id', $vendor->id)->update([
                    'email'         =>     $request->email,
                    'phoneno'         =>     $request->phoneno,
                    'benficiaryname'         =>     $request->benficiaryname,
                    'bankname'         =>     $request->bankname,
                    'ifsccode'         =>     $request->ifsccode,
                    'accountnumber'         =>     $request->accountnumber,
                    'gstno'         =>     $request->gstno,
                    'pan'         =>     $request->pan,
                    'adhar'         =>     $request->adhar,
                    'type'         =>     $request->type,

                    'createdby'         =>     auth()->user()->teammember_id,
                    'type'         =>     $request->type,
                    'created_at'                =>        date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
                $vendor_id =   DB::table('vendorlist')->insertGetId([
                    'vendor_id'         =>     $vendor->id,
                    'created_by'  => auth()->user()->teammember_id,
                    'approver'  => $request->approver,
                    'amount'  => $request->amount,
                    'itemname'  => $request->itemname,
                    'bill'  => $data['bill'],
                    'status'  => 0,
                    'created_by'         =>     auth()->user()->teammember_id,
                    'created_at'                =>        date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
            } else {
                $id =   DB::table('vendors')->insertGetId([
                    'vendorname'         =>     $request->vendorname,
                    'email'         =>     $request->email,
                    'phoneno'         =>     $request->phoneno,
                    'benficiaryname'         =>     $request->benficiaryname,
                    'bankname'         =>     $request->bankname,
                    'ifsccode'         =>     $request->ifsccode,
                    'password'         =>     $password,
                    'accountnumber'         =>     $request->accountnumber,
                    'gstno'         =>     $request->gstno,
                    'pan'         =>     $request->pan,
                    'adhar'         =>     $request->adhar,
                    'panfile'  => $data['panfile'],
                    'adharfile'  => $data['adharfile'],
                    'type'         =>     $request->type,
                    'createdby'         =>     auth()->user()->teammember_id,
                    'type'         =>     $request->type,
                    'created_at'                =>        date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
                $vendor_id =  DB::table('vendorlist')->insertGetId([
                    'vendor_id'         =>     $id,
                    'created_by'  => auth()->user()->teammember_id,
                    'approver'  => $request->approver,
                    'itemname'  => $request->itemname,
                    'amount'  => $request->amount,
                    'bill'  => $data['bill'],
                    'status'  => 0,
                    'created_by'         =>     auth()->user()->teammember_id,
                    'created_at'                =>        date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
            }
            if ($request->linksend == 1 && $request->type == 1) {
                $data = array(
                    'vendorid' =>  $vendor_id,
                    'email' =>  $request->email,
                );

                Mail::send('emails.vendor', $data, function ($msg) use ($data) {
                    $msg->to($data['email']);
                    $msg->subject('KGS Vendor Form Request');
                });
            }
            if ($request->linksend == 2) {
                $vendorss =  DB::table('vendors')
                    ->leftjoin('vendorlist', 'vendorlist.vendor_id', 'vendors.id')
                    ->leftjoin('teammembers as team', 'team.id', 'vendorlist.created_by')
                    ->leftjoin('teammembers', 'teammembers.id', 'vendorlist.approver')
                    ->where('vendorlist.id', $vendor_id)
                    ->select(
                        'vendorlist.*',
                        'vendors.vendorname',
                        'vendors.email',
                        'vendors.benficiaryname',
                        'vendors.bankname',
                        'vendors.ifsccode',
                        'vendors.accountnumber',
                        'vendors.gstno',
                        'vendors.type',
                        'vendors.phoneno',
                        'vendors.vendoraddress',
                        'team.team_member',
                        'teammembers.team_member as approvers',
                        'teammembers.emailid as approversemail'
                    )
                    ->first();

                DB::table('vendorlist')->where('id', $vendorss->id)->update([
                    'status'         =>     0,
                ]);

                $data = array(
                    'name' => $vendorss->vendorname ?? '',
                    'email' => $vendorss->approversemail ?? '',
                    'id' => $vendorss->id ?? '',
                );
                Mail::send('emails.vendorformapproval', $data, function ($msg) use ($data) {
                    $msg->to($data['email']);
                    $msg->subject('Vendor Form Approval Request');
                });
            }
            if ($request->linksend == 1 && $request->type == 2 && $vendor->password != null) {
                $data = array(
                    'vendorid' =>  $vendor_id,
                    'email' =>  $request->email,
                    'password' =>  $passwords,
                );

                Mail::send('emails.vendorlogin', $data, function ($msg) use ($data) {
                    $msg->to($data['email']);
                    $msg->subject('KGS Vendor Form Request');
                });
            } elseif ($request->linksend == 1 && $request->type == 2 && $vendor->password == null) {
                $data = array(
                    'vendorid' =>  $vendor_id,
                    'email' =>  $request->email,
                );

                Mail::send('emails.vendor', $data, function ($msg) use ($data) {
                    $msg->to($data['email']);
                    $msg->subject('KGS Vendor Form Request');
                });
            }
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = DB::table('vendors')
            ->leftjoin('vendorlist', 'vendorlist.vendor_id', 'vendors.id')
            ->leftjoin('teammembers as team', 'team.id', 'vendorlist.created_by')
            ->leftjoin('teammembers', 'teammembers.id', 'vendorlist.approver')
            ->where('vendorlist.id', $id)
            ->select(
                'vendorlist.*',
                'vendors.vendorname',
                'vendors.email',
                'vendors.benficiaryname',
                'vendors.bankname',
                'vendors.ifsccode',
                'vendors.accountnumber',
                'vendors.gstno',
                'vendors.type',
                'vendors.phoneno',
                'vendors.vendoraddress',
                'team.team_member',
                'teammembers.team_member as approvers'
            )
            ->first();
        //   dd($vendorlist);
        return view('backEnd.vendor.view', compact('id', 'vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($id);
        try {
            $data = $request->except(['_token']);

            if ($request->status == 1) {
                $vendor = DB::table('vendorlist')
                    ->leftjoin('teammembers as team', 'team.id', 'vendorlist.created_by')
                    ->select('vendorlist.id', 'team.team_member', 'team.emailid')
                    ->where('vendorlist.id', $id)->first();
                //dd($vendor);
                DB::table('vendorlist')->where('id', $id)->update([
                    'status'         =>     1,
                    'approvedate' =>     date('Y-m-d H:i:s'),
                ]);
                $data = array(
                    'team_member' => $vendor->team_member ?? '',
                    'email' => $vendor->emailid ?? '',
                    'id' => $vendor->id ?? ''
                );
                Mail::send('emails.vendorapprovelform', $data, function ($msg) use ($data) {
                    $msg->to($data['email']);
                    $msg->subject(' Vendor Form ');
                    // $msg->cc($data['teammembermail']);
                });
                Mail::send('emails.vendoraccountform', $data, function ($msg) use ($data) {
                    $msg->to('accounts@kgsomani.com');
                    $msg->subject(' Vendor Form ');
                });
            }
            if ($request->status == 3) {

                DB::table('vendorlist')->where('id', $id)->update([
                    'status'         =>     3,
                    'remark'         =>     $request->remark,
                ]);
            }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
