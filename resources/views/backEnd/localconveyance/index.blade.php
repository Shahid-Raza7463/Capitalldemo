@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('localconveyance/create')}}">Add Local Conveyance</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Local Conveyance List</small>
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
               <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>DATE & ASSIGNMENT</th>
                            <th>place</th>
                            <th>Nature</th>
							 <th>Audit Period from Date</th>
                            <th>Audit Period to Date</th>
                            <th>Remarks</th>
                            <th>Visiting Period from Date</th>
                            <th>Visiting Period to Date</th>
                            <th>Leave Day</th>
                            <th>Total Days</th>
                            <th>Approved Conveyance</th>
                            <th>Total Value</th>
                            <th>Bill Paid</th>
                            <th>Client Bill</th>
                         
                            <th>Recoverable</th>
                            <th>Passed</th>
                            <th>Approved</th>
                            <th>Total Amount Payable</th>
                            <th>Client Invoice Number</th>
                            <th>Createdby</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($localconveyanceData  as $localconveyanceDatas)
                        <tr>
                        <td>  <a href="{{route('localconveyance.show', $localconveyanceDatas->id)}}">   {{ $localconveyanceDatas->client_name }}</a></td>
                        <td>{{$localconveyanceDatas->dateassignment }}</td>
                        <td>{{$localconveyanceDatas->place }}</td>
                        <td>{{$localconveyanceDatas->Nature }}</td>
                        <td>@if($localconveyanceDatas->Audit_from_date != null)
							{{ date('F d,Y', strtotime($localconveyanceDatas->Audit_from_date)) }}@else
							@endif</td> 
                        <td>@if($localconveyanceDatas->Audit_period_date != null){{ date('F d,Y', strtotime($localconveyanceDatas->Audit_period_date)) }}@else @endif</td>
                        <td>{{$localconveyanceDatas->Remarks }}</td>
                        <td>@if($localconveyanceDatas->Visiting_from_date != null){{ date('F d,Y', strtotime($localconveyanceDatas->Visiting_from_date)) }}@else @endif</td> 
                        <td>@if($localconveyanceDatas->Visiting_date != null){{ date('F d,Y', strtotime($localconveyanceDatas->Visiting_date)) }}@else @endif</td>
                        <td>{{$localconveyanceDatas->leave_day }}</td>
                        <td>{{$localconveyanceDatas->totaldays }}</td>
                        <td>{{$localconveyanceDatas->Approved_Conveyance }}</td>
                        <td>{{$localconveyanceDatas->Total_Value }}</td>
                        <td>{{$localconveyanceDatas->billpaid }}</td>
                        <td>{{$localconveyanceDatas->clientbill }}</td>
                        <td>{{$localconveyanceDatas->Recoverable }}</td>
                        <td>{{$localconveyanceDatas->Passed }}</td>
                        <td>{{$localconveyanceDatas->Approved }}</td>
                        <td>{{$localconveyanceDatas->Total_Amount_Payable }}</td>
                        <td>{{$localconveyanceDatas->Client_Invoice_Number }}</td>
                        <td>{{ App\Models\Teammember::select('team_member')->where('id',$localconveyanceDatas->createdby)->first()->team_member ?? ''}}</td>
                        <td>@if($localconveyanceDatas->Status==0)
                                    <span class="badge badge-info">Created</span>
                                    @elseif($localconveyanceDatas->Status==1)
                                    <span class="badge badge-success">Approved</span>
                                    @elseif($localconveyanceDatas->Status==2)
                                    <span class="badge badge-danger">Rejected</span>
                                    @elseif($localconveyanceDatas->Status==4)
                                    <span class="badge badge-secondary">Pending For Correction/Clarification</span>
                                    @else
                                    <span class="badge badge-warning">Submitted</span>
                                    @endif</td>
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
