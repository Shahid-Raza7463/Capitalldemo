
@extends('backEnd.layouts.layout') @section('backEnd_content')<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    {{-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Bank Details</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav> --}}
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Client Contact List</small>
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
                            <th>House Type</th>
                            <th>Tenant Name</th>
                            <th>Tenant Adhar</th>
                            <th>Tenant Pan</th>
                            <th>Address of House Property</th>
                            <th>Rent Received </th>
                            <th>Rent Amount</th>
                            <th>Period of Vacancy</th>
                            <th>Municipal/House Tax paid</th>
                            <th>Payment of Interest on Housing Loan</th>
                            <th>Ownership Share</th>
                            <th>Any other details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrhouses as $ilrhouse)
                        <tr>
                            <td>{{$ilrhouse->house_type ??''}}</td>
                            <td>{{$ilrhouse->tenant_name }}</td>
                            <td>{{$ilrhouse->tenant_adhar }}</td>
                            <td>{{$ilrhouse->tenant_pan }}</td>
                            <td>{{$ilrhouse->address_of_house_property }}</td>
                            <td><a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->rent_received)}}">{{$ilrhouse->rent_received }}</a></td>
                            <td><a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->rent_received)}}">{{$ilrhouse->rent_amount }}</a></td>
                            <td>{{$ilrhouse->period_vacancy }}</td>
                            <td><a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->rent_received)}}">{{$ilrhouse->tax_paid }}</a></td>
                            <td><a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->rent_received)}}">{{$ilrhouse->payment }}</a></td>
                            <td>{{$ilrhouse->ownership }}</td>
                            <td><a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->rent_received)}}">{{$ilrhouse->anyotherdetails }}</a></td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
      
@endsection
                                   

