
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('pbd/create')}}">Add PBD</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>PBD List</small>
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
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                           
                            <th>Contact Name</th>
                            <th>Company </th>
                            <th>Designation </th>
                            <th>Date of Successful Call</th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pbdDatas as $pbdData)
                       
                        <td><a href="{{route('pbd.edit', $pbdData->id)}}"> {{ $pbdData->Contact_Name ??'' }}</a></td>
                        <td>{{ $pbdData->company ??'' }}</td>
                        <td>{{ $pbdData->Designation ??'' }}</td>
                            <td>{{ date('F d,Y', strtotime($pbdData->Date_of_Successful_Call)) }}</td>
                           
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


