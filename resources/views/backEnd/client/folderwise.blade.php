
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
		@if(Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('client/create')}}">Add Client</a></li>
              <li class="breadcrumb-item"><a href="{{url('client-list')}}">Client list</a></li>
        </ol>
		@endif
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Client
                List</small>
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
                            
                            <th>Client Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientDatas as $clientData)
                        <tr>

                    <td> <a href="{{url('/viewclientlist/'.$clientData->id )}}"><i
                        class="far fa-folder"></i>  <b>{{$clientData->client_name}}</b> ( {{$clientData->client_code}} ) ( {{$clientData->panno}} ) </a></td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


