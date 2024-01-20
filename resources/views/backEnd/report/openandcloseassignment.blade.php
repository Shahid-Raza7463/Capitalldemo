<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    @if (Request::is('openandcloseassignment/0'))
                        <small>Open Assignment</small>
                    @else
                        <small>Close Assignment</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
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
                                <th>Assignment Id</th>
                                <th>Assignment</th>
                                <th>Client</th>

                                <th>Period Start</th>
                                <th>Period End</th>
                                <th>Deadline</th>
                                <th>Assigned Status</th>
                                <th>Assigned Partner</th>
                                <th>Other Partner</th>
                                <th>Team Leader </th>
                                <th>Teammember</th>
                                @if (auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                    <th>Edit</th>
                                @endif
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignmentmappingData as $assignmentmappingDatas)
                                <tr>
                                    <td style="display: none;">{{ $assignmentmappingDatas->id }}</td>
                                    <td> <a
                                            href="{{ url('/viewassignment/' . $assignmentmappingDatas->assignmentgenerate_id) }}">{{ $assignmentmappingDatas->assignmentgenerate_id }}</a>
                                    </td>
                                    <td>
                                        {{ $assignmentmappingDatas->assignment_name }} @if ($assignmentmappingDatas->assignmentname != null)
                                            ({{ $assignmentmappingDatas->assignmentname }})
                                        @endif
                                    </td>
                                    <td> {{ $assignmentmappingDatas->client_name }}</td>

                                    <td>
                                        @if ($assignmentmappingDatas->periodstart != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodstart)) }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($assignmentmappingDatas->periodend != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodend)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($assignmentmappingDatas->duedate != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->duedate)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($assignmentmappingDatas->status == 1)
                                            <span class="badge badge-primary">OPEN</span>
                                        @elseif($assignmentmappingDatas->status == 0)
                                            <span class="badge badge-danger">CLOSED</span>
                                        @elseif($assignmentmappingDatas->status == 2)
                                            <span class="badge badge-info">Rejected</span>
                                        @endif

                                    </td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingDatas->leadpartner)->first()->team_member ?? '' }}
                                    </td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingDatas->otherpartner)->first()->team_member ?? '' }}
                                    </td>
                                    <td>
                                        @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 0)->get() as $sub)
                                            {{ $sub->team_member }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 2)->get() as $sub)
                                            {{ $sub->team_member }} ,
                                        @endforeach
                                    </td>
                                    @if (auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                        <td>
                                            <a href="{{ url('/assignmentlist/' . $assignmentmappingDatas->assignmentgenerate_id) }}"
                                                class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                        </td>
                                    @endif
                                    {{-- <td>
                                     
                                        <a href="  {{ url('/assignment/reject/' . $assignmentmappingDatas->assignmentgenerate_id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this Assignment?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal">Reject</button>
                                        </a>
                        
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection


{{-- download functionality pdf, excell and cvv file --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
{{-- 
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
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
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
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
                    filename: 'Assignment Report List',
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'pdfHtml5',
                    filename: 'Assignment Report List',
                    // which column do you want to on pdf page
                    exportOptions: {
                        columns: [0, 1, 2, 4, 10]
                    },
                    // add date on pdf page
                    // customize: function(doc) {
                    //     var now = new Date();
                    //     var formattedDate = now.toLocaleString();
                    //     doc.content.splice(1, 0, {
                    //         text: 'Generated on: ' + formattedDate,
                    //         // alignment: 'center',
                    //         margin: [0, 0, 0, 10]

                    //     });
                    // }

                },
                // column visibility
                'colvis'
            ]
        });
    });
</script>
