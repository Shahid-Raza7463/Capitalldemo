@extends('backEnd.layouts.layout') @section('backEnd_content')
    <style>
        .table-bordered td,
        .table-bordered th {
            word-break: break-all;
        }
    </style>
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">

        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">

                <li class="breadcrumb-item"><a href="{{ url('timesheetrequestlist') }}">Back</a></li>
            </ol>
        </nav>

        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Timesheetrequest
                        Details</small>
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

                <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                    <div class="card-body">

                        <fieldset class="form-group">

                            <table class="table display table-bordered table-striped table-hover">

                                <tbody>
                                    <tr>
                                        <td><b>Approver : </b></td>
                                        <td>{{ $timesheetrequest->team_member ?? '' }}</td>
                                        <td><b>Reason : </b></td>
                                        <td>{{ $timesheetrequest->reason ?? ('' ?? '') }}
                                        </td>

                                    </tr>

                                    <tr>
                                        <td><b>Created date : </b></td>
                                        <td>{{ date('F d,Y', strtotime($timesheetrequest->created_at)) ?? '' }}
                                        </td>
                                        <td><b>Created By : </b></td>
                                        <td>{{ $timesheetrequest->createdbyauth ?? '' }}
                                        </td>
                                    <tr>
                                        <td><b>Reason For Reject</b></td>
                                        <td>{{ $timesheetrequest->remark ?? '' }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><b>status : </b></td>
                                        <td>
                                            @if ($timesheetrequest->status == 0)
                                                <span class="badge badge-pill badge-warning">Created</span>
                                            @elseif($timesheetrequest->status == 1)
                                                <span class="badge badge-pill badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-pill badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        @if ($timesheetrequest->partner == Auth::user()->teammember_id || Auth::user()->email == 'itsupport_delhi@vsa.co.in')
                                            @if ($timesheetrequest->status == '0')
                                                <td><b>Action :</b></td>
                                                <td>
                                                    <div class="row">

                                                        <form method="post"
                                                            action="{{ url('timesheetrequest/update', $timesheetrequest->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success"> Approve</button>
                                                            <input type="text" hidden id="example-date-input"
                                                                name="status" value="1" class="form-control"
                                                                placeholder="Enter Location">
                                                        </form>

                                                        <button style="margin-left:11px;height: 35px;" data-toggle="modal"
                                                            data-target="#exampleModal12" class="btn btn-danger">
                                                            Reject</button>
                                            @endif
                    </div>
                    </td>
                    @endif


                    </tr>


                    </tbody>

                    </table>


                    </fieldset>

                </div>

            </div>


        </div>
    </div>

    </div>
@endsection

<!-- Small modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Reason For
                    Rejection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('timesheetrequest/update', $timesheetrequest->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea rows="6" name="remark" class="form-control" placeholder=""></textarea>
                                <input hidden type="text" id="example-date-input" name="status" value="2"
                                    class="form-control" placeholder="Enter Location">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" style="float: right" class="btn btn-success">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
