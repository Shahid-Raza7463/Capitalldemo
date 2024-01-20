<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        @if (auth()->user()->role_id == 18 || auth()->user()->role_id == 11)
            <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('notification/create') }}">Add Announcement</a></li>
                    <li class="breadcrumb-item active">+</li>
                </ol>
            </nav>
        @endif
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Announcement List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">


        <div class="card mb-4">
            <div class="card-header" style="background-color:#ff000029;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"> <i style="font-size: 20px;padding:10px;"
                                class="typcn typcn-bell"></i>Announcement</h6>
                    </div>

                </div>
            </div>
            {{--  <div class="notification-list">
                @foreach ($notificationDatas as $notificationData)
<div class="card-body">
                <div class="media new">
                    <div class="img-user online"><img src="{{ asset('backEnd/image/teammember/profilepic/'.$notificationData->profilepic) }}" alt="">
                    </div>
                    <div class="media-body">
                        <h6> {{ $notificationData->title}}</h6>
                        <span> <small class="text-muted"><a 
                            class="d-block fs-15 font-weight-600 text-sm mb-0"><span
                                style="color:#007bff;font-size: small;">created by <b style="color: black;">{{ $notificationData->team_member}}</b></span>
                          </a></small></span>
                    </div>
                    <div class="inbox-date ml-auto">
                        <div><small><i class="far fa-clock mr-1"></i>{{ date('F jS', strtotime($notificationData->created_at)) }},
                                {{ date('H:i A', strtotime($notificationData->created_at)) }}</small></div>
                    </div>
                </div>
            </div>
                @endforeach
           
        </div> --}}

        </div>

        <div class="card mb-4">

            <div class="card-body">
                <div class="table-responsive">
                  <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
							  <th style="display: none;">id</th>
                          <th>Title</th>
                                <th>Date</th>
                                @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                    <th>Target</th>
                                    <!--  <th>Delete</th>-->
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificationDatas as $notificationData)
                                <tr>
									   <td style="display: none;">{{$notificationData->id }}</td>
                                      <td>
                                        <a href="{{ url('/notification/' . $notificationData->id) }}"
                                            style="color: {{ $notificationData->readstatus == 1 ? 'Black' : 'red' }}">
                                            {{ $notificationData->title }}
                                        </a>
                                    </td>
                                    <td>{{ date('F d,Y', strtotime($notificationData->created_at)) }}</td>
                                    @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                        <td>
                                            @if ($notificationData->targettype == 1)
                                                <span>Individual</span>
                                            @elseif($notificationData->targettype == 2)
                                                <span>All Member</span>
                                            @else
                                                <span>Partner</span>
                                            @endif
                                        </td>
                                        <!--  <td>
                                         
                                                <form action="{{ route('notification.destroy', $notificationData->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button  onclick="return confirm('Are you sure you want to delete this item?');" class="btn ripple btn-danger text-white btn-icon"><i class="fa fa-trash"></i></button>
                                        </form>
                                            </td>-->
                                    @endif

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
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>    
<script>$(document).ready(function() {
    $('#examplee').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 0, "desc" ]],
        
        buttons: [
            
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            'colvis'      
    ]  
    } );
} );</script>                                

