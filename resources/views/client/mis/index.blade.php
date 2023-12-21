<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
@extends('client.layouts.layout') @section('client_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('client/mis/create')}}">Add MIS</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Mis List</small>
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
                 <table id="examplee" class="display">
                    <thead>
                        <tr>
                           
                            <th>Sno.</th>
                            <th>Picture No.</th>
                            <th>Submitted Date</th>
                            <th>Status</th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($misLists as $misList)
                        <tr>
                          <!--  <td><a href="{{route('mis.edit', $misList->id)}}"  >{{ $misList->sno ??''}}</a></td> -->
							 <td>{{ $misList->sno ??''}}</td>
							@if($misList->status != 4)
                            <td><a href="{{url('client/mis/details/'.$misList->sno)}}">{{$misList->pictureno ??''}}</a></td>
							@else
							<td>{{$misList->pictureno ??''}}</td>
@endif
                           
                            <td>{{ date('F d,Y', strtotime($misList->submitdate)) }}</td>
                          <td>@if($misList->status ==  0)
                            <span class="badge badge-pill badge-primary">Created</span>
                            @elseif($misList->status ==  2)
                            <span class="badge badge-pill badge-warning">Re Submitted</span>
                           
                            @elseif($misList->status ==  1)
                            <span class="badge badge-pill badge-info">Submitted</span>
                           @elseif($misList->status ==  4)
                            <span class="badge badge-pill badge-danger">Deleted</span>
                            @else
                            <span class="badge badge-pill badge-success">Approved</span>
                          @endif</td>
                      
                            
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>                               
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>    
<script>$(document).ready(function() {
    $('#examplee').DataTable( {
        "order": [[ 0, "desc" ]],
        
    
    } );
  
} );</script>    

