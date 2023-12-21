
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
                            <th>Name of the Employer</th>
                            <th>TAN of employer</th>
                            <th>Any Other Details</th>
                            <th>Salary Income</th>
                            <th>Employer's Address </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrsalarys as $ilrsalary)
                        <tr>
                            <td>{{$ilrsalary->nameoftheemployee ??''}}</td>
                            <td>{{$ilrsalary->tanoftheemployee }}</td>
                            <td><a href="{{url('backEnd/image/anyotherdetail/'.$ilrsalary->anyotherdetail)}}">
                                {{$ilrsalary->anyotherdetail }}</a></td>
                            <td><a href="{{url('backEnd/image/ilrsalary/'.$ilrsalary->salaryincome)}}">
                                {{$ilrsalary->salaryincome }}</a></td>
                            <td>{{$ilrsalary->employeeaddress }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
@endsection
                                   

