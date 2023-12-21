@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('contract/create')}}">Add Contract and Subscription</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Contract and Subscription List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                             <th>KGS Entity</th>
                            <th> Nature of Item</th>
                             <th>Services</th> 
                            <th>Date of Contract</th>
                             <th>Expiry Date</th>
                            <th>Company Name</th>
                            <th>Amount</th>
                            <th>Contact Email</th>
                            <th>Approval</th>
                            <th>Status</th>
                            <th>Createdby</th>
                           

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contractDatas as $contractData)
                        <tr>
                       
                        <td><a href="{{url('view/contract/'.$contractData->id)}}"> {{ $contractData->name }}</td>
                          
                            <td> {{ $contractData->natureofitem }}</td>
                            <td> {{ $contractData->services }}</td>
                           <td> {{ date('F d,Y', strtotime($contractData->dateofcontact)) }}</td>
                            <td> {{ date('F d,Y', strtotime($contractData->expirydate)) }}</td>
                            <td> {{ $contractData->companyname }}</td>
                            <td> {{ $contractData->amount }}</td>
                            <td> {{ $contractData->contactemailid }}</td>
                            <td> {{ $contractData->team_member }}</td>
                            <td>@if($contractData->Status==0)
                                    <span class="badge badge-pill badge-warning">Open</span>
                                    @elseif($contractData->Status==1)
                                    <span class="badge badge-danger">Reject</span>
                                    @elseif($contractData->Status==2)
                                    <span class="badge badge-success">Approve</span>
                                    @endif
                                </td>
                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$contractData->createdby)->first()->team_member ?? ''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
