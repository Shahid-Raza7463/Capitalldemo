<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('clientspecificindependence/create')}}">Add Client
                    Specific Independence Declaration</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
                <a href="{{url('home')}}">
                    <h1 class="font-weight-bold" style="color:black;">Home</h1>
                </a>
                <small>Client Specific Independence Declaration List</small>
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
                <table id="exampleee" class="display nowrap">
                    <thead>
                        <tr>
                            <th style="display: none;">id</th>
                            <th>Name of Employee</th>
                            <th>Created Date</th>
                            <th>Partner</th>
                            <th>Year</th>
                            <th>Do you have a direct or indirect holding of more than 2% Capital of any client or its
                                subsidiaries/affiliates?</th>
                            <th>Do you have a financial interest of more than 2% in any major competitors, investors in
                                or affiliates of any client of the Firm?</th>
                            <th>Do you have any outside business relationship with any client of the Firm or an officer,
                                director or principal shareholder of any Clients of the Firm having the objective of
                                financial gain?</th>
                            <th>Do you owe any client any amount?</th>
                            <th>Do you have the authority to sign cheques for any client of the Firm</th>
                            <th>Are you connected with any client of the Firm as a promoter, underwriter or voting
                                trustee, director, partner, officer or in any capacity equivalent to a member of
                                management or an employee?</th>
                            <th>Do you serve as a director, Partner, trustee, officer, or employee of any client of the
                                Firm?</th>
                            <th>Has your spouse or children or relative is employed by any client of the Firm?</th>
                            <th>Are you connected with any client of the Firm in any other capacity directly or
                                indirectly which may compromise your independence?</th>
                            <th>Do you have any pending litigation with any client of the Firm</th>
                            <th>Are you relative of any client of the Firm</th>
                        </tr>
                    </thead>

                    <tbody>


                        @foreach($clientspecificindependencedeclaration as $clientspecificindependencedeclarationData)

                        <tr>
                            <td style="display: none;">{{$clientspecificindependencedeclarationData->id }}</td>
                            <td>
                                <a
                                    href="{{route('clientspecificindependence.show', $clientspecificindependencedeclarationData->id)}}">
                                    {{ $clientspecificindependencedeclarationData->team_member }}
                                </a>
                            </td>

                            <td>{{ date('F d,Y', strtotime($clientspecificindependencedeclarationData->created_at)) }}
                            </td>
                            <td>{{ $clientspecificindependencedeclarationData->partners }}</td>
                            <td>{{ $clientspecificindependencedeclarationData->year }}</td>
                            <td>@if($clientspecificindependencedeclarationData->subsidiaries == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->subsidiaries == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->financial == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->financial == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->outside == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->outside == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->client == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->client == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->authority == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->authority == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->underwriter == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->underwriter == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->trustee == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->trustee == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->spouse == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->spouse == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->compromise == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->compromise == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->litigation == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->litigation == 2)
                                <span>No</span>
                                @endif
                            </td>
                            <td>@if($clientspecificindependencedeclarationData->relative == 1)
                                <span>Yes</span>
                                @elseif($clientspecificindependencedeclarationData->relative == 2)
                                <span>No</span>
                                @endif
                            </td>


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
    $(document).ready(function () {
        $('#exampleee').DataTable({
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
