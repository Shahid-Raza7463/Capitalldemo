<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">

        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                <div class="media-body">
                    <a href="{{ url('home') }}">
                        <h1 class="font-weight-bold" style="color:black;">Home</h1>
                    </a>
                    <small>Relieving Team List</small>
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
                <!-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                                aria-controls="pills-home" aria-selected="true">Active </a>
                        </li>

        @if (Auth::user()->role_id != 17)
    <li class="nav-item">
                            <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                                aria-controls="pills-user" aria-selected="false">InActive</a>
                        </li>
    @endif
                    </ul>
        -->
                <br>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive example">

                            <div class="table-responsive">
                                <table id="examplee" class="display nowrap">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">id</th>
                                            <th>Team Member Name</th>
                                            <th>Team Role</th>
                                            <th>Mobile No</th>
                                            <th>Official Email ID</th>

                                            <th>Team/Reporting Head</th>

                                            <th> Date of Joining</th>
                                            <th style="display:none;"></th>
                                            <th> Date of Leaving</th>


                                            <!--  <th>Deactivate</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teammemberactiveDatas as $teammemberData)
                                            <tr>
                                                <td style="display: none;">{{ $teammemberData->id }}</td>
                                                <td><a href="{{ route('teammember.edit', $teammemberData->id) }}">
                                                        {{ $teammemberData->team_member }}</a></td>
                                                <td>{{ $teammemberData->role->rolename ?? '' }}</td>
                                                <td>{{ $teammemberData->mobile_no ?? '' }}</td>
                                                <td>{{ $teammemberData->emailid ?? '' }}</td>
                                                <td></td>

                                                @if ($teammemberData->joining_date == null)
                                                    <td></td>
                                                @else
                                                    <td>{{ date('F d,Y', strtotime($teammemberData->joining_date)) }}</td>
                                                @endif
                                                <td style="display:none;">{{ $teammemberData->leavingdate ?? '' }}</td>
                                                @if ($teammemberData->leavingdate == null)
                                                    <td></td>
                                                @else
                                                    <td>{{ date('F d,Y', strtotime($teammemberData->leavingdate)) }}</td>
                                                @endif



                                                <!--   <td> <form action="{{ route('teammember.destroy', $teammemberData->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                      <a  onclick="return confirm('Are you sure you want to deactivate this item?');" class="btn btn-danger-soft btn-sm"><i
                                                    class="fa fa-user-times"></i></a>
                                                </form></td>-->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                    <br>
                    <div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--/.body content-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var user_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ url('/changeteamStatus') }}",
                    data: {
                        'status': status,
                        'user_id': user_id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
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
            dom: 'Bfrtip',
            "order": [
                [7, "desc"]
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
<!-- Modal -->
<div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editpayment" method="post" action="{{ url('/teamupdate') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Update Details
                    </h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li style="color:red;">{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Leaving Date:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="leavingdate" name="leavingdate" type="date">
                            <input class="form-control" hidden id="teamid" name="teamid" type="text">
                        </div>
                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Reason of
                            Leaving:</label>
                        <div class="col-sm-9">
                            <textarea rows="6" name="reasonofleaving" class=" form-control" placeholder="Enter Reason"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function() {
        $('body').on('click', '#editCompany', function(event) {
            //        debugger;

            var id = $(this).data('id');
            debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('teammemberupdatedetail') }}",
                data: "id=" + id,

                success: function(response) {
                    $("#teamid").val(response.id);
                    //  $("#leavingdate").val(response.leavingdate);
                    debugger;
                },
                error: function() {

                },
            });
        });
    });
</script>
