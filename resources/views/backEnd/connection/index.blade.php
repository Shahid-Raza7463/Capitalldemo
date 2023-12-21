
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('connection/create')}}">Add connection</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>connection List</small>
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
                           
                            <th>Connection Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Connected Through</th>
                            <th>Connected Email</th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($connectionDatas as $connectionData)
                        <tr>
                            <td><a href="{{url('view/connection', $connectionData->id)}}" >{{$connectionData->connectionname ??''}}</a></td>
                            <td>{{$connectionData->emailid ??'' }}</td>
                            <td>{{$connectionData->phoneno ??'' }}</td>
                            <td>{{$connectionData->connectedthrough ??'' }}</td>
                            <td>{{$connectionData->connectedemail ??'' }}</td>
                          
                            
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


