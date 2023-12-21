@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			 @if($contractDatas->status=='0')
            <li class="breadcrumb-item"><a href="">Edit
            Contract and Subscription</a></li>
			    @endif
			<li> <a class="btn btn-primary" href="{{ url('contract') }}">Back</a></li>

        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Contract and Subscription Details</small></a>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
        @component('backEnd.components.alert')

        @endcomponent
        <div class="card-body">

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:420px;">
                <div class="card-body">
                  
                    <br><br>
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                            <tr>
                                    <td><b>KGS Entity : </b></td>
                                    @php
                                    $contractData = DB::table('contractand_subscriptions')
                                    ->leftjoin('kgsentitys','kgsentitys.id','contractand_subscriptions.kgsentity')
                  ->where('contractand_subscriptions.id',$contractDatas->id)
                  ->select('contractand_subscriptions.*','kgsentitys.name')->get();
                  
                         @endphp
                             <td>@foreach($contractData as $contractData) {{ $contractData->name ??''}}
                             @endforeach
                             </td>
                                    <td><b>Nature of Item : </b></td>
                                    <td>{{ $contractDatas->natureofitem }}</td>
                                </tr>
                            
                                <tr>
                                    <td><b>Services: </b></td>
                                    <td>{{ $contractDatas->services}}</td>
                                    <td><b>Date of Contact  : </b></td>
                                    <td>{{ date('F d,Y', strtotime($contractDatas->dateofcontact)) }}</td>

                                </tr>
                                <tr>
                                    <td><b>Expiry Date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($contractDatas->expirydate)) }}</td>
                                    <td><b>Renewal Due : </b></td>
                                    <td>{{$contractDatas->renewaldue}}</td>

                                </tr>
                                <tr>
                                    <td><b>Company Name : </b></td>
                                    <td>{{$contractDatas->companyname}}</td>
                                    <td><b>Amount : </b></td>
                                    <td>{{$contractDatas->amount}}</td>

                                </tr>
                                <tr>
                                    <td><b>Contact Email : </b></td>
                                    <td>{{$contractDatas->contactemailid}}</td>
                                    <td><b>Approval : </b></td>
                                    @php
                                    $contractData = DB::table('contractand_subscriptions')
                                    ->leftjoin('teammembers','teammembers.id','contractand_subscriptions.teammember_id')
                  ->where('contractand_subscriptions.id',$contractDatas->id)
                  ->select('contractand_subscriptions.*','teammembers.team_member')->get();
                  
                         @endphp
                             <td>@foreach($contractData as $contractData) {{ $contractData->team_member ??''}}
                             @endforeach
                             </td>
                        </tr>
                              <tr>
                                    @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                    <td><b>Status  : </b></td>
                                    <td>@if($contractDatas->Status==0)
                                    <span class="badge badge-pill badge-warning">Open</span>
                                    @elseif($contractDatas->Status==1)
                                    <span class="badge badge-danger">Reject</span>
                                    @elseif($contractDatas->Status==2)
                                    <span class="badge badge-success">Approve</span>
                                    @endif</td>
                                    @endif
                                    <td><b>Createdby : </b></td>
                                     <td>{{ App\Models\Teammember::select('team_member')->where('id',$contractDatas->createdby)->first()->team_member ?? ''}}</td>
                                </tr>    
                            <tr>
                                    @if(Request::is('view/*'))
                                    @if(Auth::user()->teammember_id == $contractDatas->teammember_id || Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                    @if($contractDatas->Status=='0')
                                    <td><b>Action :</b></td>
                                    <td>  
                                        <div class="row">
                                          
                                    <form method="post" action="{{ route('contract.update', $contractDatas->id)}}"  enctype="multipart/form-data">
                                        @method('PATCH') 
                                        @csrf   
                                    <button type="submit" class="btn btn-success" >Approve</button>
                                    <input type="text" hidden id="example-date-input" name="Status" value="2" class="form-control"
                                    placeholder="Enter Location">
                                    </form>
                                    <form method="post" action="{{ route('contract.update', $contractDatas->id)}}"  enctype="multipart/form-data">
                                        @method('PATCH') 
                                        @csrf 
                                    <button style="margin-left:11px;" type="submit" class="btn btn-danger" >Reject</button>
                                    <input hidden type="text" id="example-date-input" name="Status" value="1" class="form-control"
                                    placeholder="Enter Location">
                                </form>
                           
                                    </div>
                                    </td>
                                    @endif
                                    @endif
                                    @endif
                                </tr>
                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>


        </div>
    </div>

</div>
@endsection
