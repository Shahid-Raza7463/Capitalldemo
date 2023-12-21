<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">

        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item">
                    <div class="btn-group mb-2 mr-1">
                        <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Choose Year
                        </button>
                        <div class="dropdown-menu">
                            <a style="color: #37A000" class="dropdown-item"
                                href="{{ url('/holidays?' . 'year=' . '2023') }}">2023</a>
                            <a style="color: #37A000" class="dropdown-item"
                                href="{{ url('/holidays?' . 'year=' . '2022') }}">2022</a>


                        </div>
                    </div>
                </li>
                @if (Auth::user()->role_id == 18)
                    <li class="breadcrumb-item"><a href="{{ url('holiday/create') }}">Add Holidays</a></li>
                    <li class="breadcrumb-item active">+</li>
                @endif
            </ol>

        </nav>

        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Holidays
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
                    <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Name</th>
                                <th>Date</th>
                                @if (Auth::user()->role_id == 18)
                                    <th>Delete</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($holidayDatas as $holidayDatas)
                                <tr>
                                    <td style="display: none;">{{ $holidayDatas->id }}</td>
                                    <td>
                                        @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                            <a href="{{ route('holiday.edit', $holidayDatas->id) }}">
                                                {{ $holidayDatas->holidayname }}</a>
                                        @else
                                            {{ $holidayDatas->holidayname }}
                                        @endif
                                    </td>
                                    <td>{{ date('F d,Y', strtotime($holidayDatas->startdate)) }}</td>

                                    @if (Auth::user()->role_id == 18)
                                        <td> <a href="{{ url('holiday/delete', $holidayDatas->id) }}"
                                                class="btn btn-info-soft btn-sm"><i class="fa fa-trash"></i></a>
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
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 40,
            //    dom: 'Bfrtip',
            "order": [
                [3, "asc"]
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
