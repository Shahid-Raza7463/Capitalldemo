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
        </div>
        {{-- ! old code  --}}
        {{-- <div class="card mb-4">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display table-bordered table-striped table-hover basic">
                        <thead>
                            <tr>
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
                                    <td><a
                                            href="{{ url('/notification/' . $notificationData->id) }}">{{ $notificationData->title }}</a>
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
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}

        {{-- ! runnig code  --}}
        {{-- <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display table-bordered table-striped table-hover basic">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                    <th>Target</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificationDatas as $notificationData)
                                <tr>
                                    <td>
                                        <a href="{{ url('/notification/' . $notificationData->id) }}"
                                            style="color: {{ $notificationData->read_at != '' ? 'Black' : 'red' }}">
                                            {{ $notificationData->title }}
                                        </a>
                                    </td>
                                    <td>{{ date('F d, Y', strtotime($notificationData->created_at)) }}</td>
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
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
        {{-- @php
            dd($notificationDatas);
        @endphp --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    {{-- class="table display table-bordered table-striped table-hover basic" --}}
                    <table class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                    <th>Target</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificationDatas as $notificationData)
                                <tr>
                                    {{-- notification read or unread  --}}
                                    <td>
                                        <a href="{{ url('/notification/' . $notificationData->id) }}"
                                            style="color: {{ $notificationData->readstatus == 1 ? 'Black' : 'red' }}">
                                            {{ $notificationData->title }}
                                        </a>
                                    </td>
                                    <td>{{ date('F d, Y', strtotime($notificationData->created_at)) }}</td>
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
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
{{-- 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 30,
            dom: 'Bfrtip',
            "order": [
                [1, "asc"]
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
</script> --}}
