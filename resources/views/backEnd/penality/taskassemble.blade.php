<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        @if(auth()->user()->teammember_id == 157 || auth()->user()->role_id == 550 )   
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('penality/create')}}">Add Penalty</a></li>
       
        </ol>
        @endif
        @if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18 )   
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('penality/create')}}">Add Penalty</a></li>
           
        </ol>
        @endif
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Penalty
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
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true">My Penalty</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">Assigned Penalty</a>
                </li>

            </ul>

            <br>
            <hr>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive example">

                        <div class="table-responsive">
                            <table id="examplee" class="display nowrap">
                                <thead>
                                    <tr>
                                        <th style="display: none;">id</th>
                                        <th> Name</th>
										<th>Amount</th>
                                        <th>Assigned</th>
                                        <th>Assign By</th>
                                        {{-- <th>Support By</th> --}}
                                        <th>Created Date</th>
                                        {{-- <th>Due Date</th> --}}
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($taskDatas as $taskData)
                                    <tr>
                                        <td style="display: none;">{{$taskData->id }}</td>
                                        <td><a
                                                href="{{url('view/penality', $taskData->id)}}">{{$taskData->taskname ??''}}</a>
                                        </td>
											 <td>{{$taskData->amount ??'' }}</td>
                                        @php
                                        $taskassig = DB::table('taskassign')
                                        ->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
                                        ->leftjoin('roles','roles.id','teammembers.role_id')
                                        ->where('taskassign.task_id',$taskData->id)->select('teammembers.team_member','roles.rolename')->get();
                                        // dd($taskassig);
                                        @endphp
                                        @if($taskData->createdby == Auth::user()->teammember_id)
                                        <td> @foreach($taskassig as
                                            $taskassign)<span><a>{{$taskassign->team_member ??'' }} (
                                                    {{$taskassign->rolename}} )</a></span>,@endforeach</td>
                                        @else
                                        <td>@foreach($taskassig as $taskassign)<span>{{$taskassign->team_member ??'' }}
                                                ( {{$taskassign->rolename}} )</span> ,@endforeach</td>
                                        @endif

                                        <td>{{ App\Models\Teammember::select('team_member')->where('id',$taskData->createdby)->first()->team_member ?? '' }}
                                        </td>
                                        {{-- <td>{{ $taskData->supportteammember ??'' }}</td> --}}
                                        <td>{{ date('F d,Y', strtotime($taskData->created_at)) }}</td>
                                        {{-- <td>{{ date('F d,Y', strtotime($taskData->duedate)) }}</td> --}}

                                        <td>@if($taskData->status == 0)
                                            <span class="badge badge-pill badge-warning">open</span>
                                            @else
                                            <span class="badge badge-pill badge-success">close</span>


                                            @endif</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

                <br>
                <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">

                    <div class="table-responsive">
                        <table id="exampleee" class="display nowrap">
                            <thead>
                                <tr>
                                    <th style="display: none;">id</th>
                                    <th> Name</th>
									<th>Amount</th>
                                    <th>Assigned</th>
                                    <th>Assign By</th>
                                    {{-- <th>Support By</th> --}}
                                    <th>Created Date</th>
                                    {{-- <th>Due Date</th> --}}
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taskassignDatas as $taskData)
                                <tr>
                                    <td style="display: none;">{{$taskData->id }}</td>
                                    <td><a
                                            href="{{url('view/penality', $taskData->id)}}">{{$taskData->taskname ??''}}</a>
                                    </td>
										 <td>{{$taskData->amount ??'' }}</td>
                                    @php
                                    $taskassig = DB::table('taskassign')
                                    ->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
                                    ->leftjoin('roles','roles.id','teammembers.role_id')
                                    ->where('taskassign.task_id',$taskData->id)->select('teammembers.team_member','roles.rolename')->get();
                                    // dd($taskassig);
                                    @endphp
                                    @if($taskData->createdby == Auth::user()->teammember_id)
                                    <td> @foreach($taskassig as
                                        $taskassign)<span><a>{{$taskassign->team_member ??'' }} (
                                                {{$taskassign->rolename}} )</a></span>,@endforeach</td>
                                    @else
                                    <td>@foreach($taskassig as $taskassign)<span>{{$taskassign->team_member ??'' }}
                                            ( {{$taskassign->rolename}} )</span> ,@endforeach</td>
                                    @endif

                                    {{-- <td>{{ App\Models\Teammember::select('team_member')->where('id',$taskData->createdby)->first()->team_member ?? '' }}
                                    </td> --}}
                                    <td>{{ $taskData->supportteammember ??'' }}</td>
                                    <td>{{ date('F d,Y', strtotime($taskData->created_at)) }}</td>
                                    {{-- <td>{{ date('F d,Y', strtotime($taskData->duedate)) }}</td> --}}

                                    <td>@if($taskData->status == 0)
                                        <span class="badge badge-pill badge-warning">open</span>
                                        @else
                                        <span class="badge badge-pill badge-success">close</span>


                                        @endif</td>


                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div>
                </div>
            </div>

        </div>
        <!--/.body content-->
        @endsection
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#examplee').DataTable({
                    dom: 'Bfrtip',
                    "order": [
                        [0, "desc"]
                    ],

                    buttons: [

                        {
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, ':visible']
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
                                columns: [0, 1, 2, 5]
                            }
                        },
                        'colvis'
                    ]
                });
            });

        </script>
        <script>
            $(document).ready(function () {
                $('#exampleee').DataTable({
                    dom: 'Bfrtip',
                    "order": [
                        [0, "desc"]
                    ],

                    buttons: [

                        {
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, ':visible']
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
                                columns: [0, 1, 2, 5]
                            }
                        },
                        'colvis'
                    ]
                });
            });

        </script>
