@extends('backEnd.layouts.layout') @section('backEnd_content')

    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                @if ($applyleave->approver == Auth::user()->teammember_id || Auth::user()->teammember_id == $applyleave->createdby)
                    @if ($applyleave->status == '0')
                        <!--    <li class="btn btn-info ml-2"><a href="{{ route('applyleave.edit', $applyleave->id ?? '') }}"
                                                                                                                                                                                                                                                                                                                style="color:white;">Edit
                                                                                                                                                                                                                                                                                                            </a></li> -->
                    @endif
                @endif
                <li> <a class="btn btn-success ml-2" href="{{ url('applyleave') }}">
                        Back</a></li>

            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Apply Leave</small>
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
                <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:710px;">

                    <div class="card-body">

                        <fieldset class="form-group">

                            <table class="table display table-bordered table-striped table-hover">

                                <tbody>

                                    <tr>
                                        <td><b>Leave : </b></td>
                                        <td>{{ $applyleave->name }}</td>
                                        <td><b>Raised By :</b></td>
                                        <td>{{ $applyleave->team_member }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>From Date : </b></td>
                                        <td>{{ date('F d,Y', strtotime($applyleave->from)) }}</td>
                                        <td><b>To Date :</b></td>
                                        <td>{{ date('F d,Y', strtotime($applyleave->to)) }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Approver : </b></td>
                                        <td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleave->approver)->first()->team_member ?? '' }}
                                        </td>
                                        <td><b>Reason for leave : </b></td>
                                        <td>{{ $applyleave->reasonleave }}</td>
                                    </tr>

                                    <tr>


                                        <td><b>Status : </b></td>
                                        <td>
                                            @if ($applyleave->status == 0)
                                                <span class="badge badge-info">Created</span>
                                            @elseif($applyleave->status == 1)
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td><b>Team Email ID : </b></td>
                                        <td>
                                            @foreach ($applyleaveteam as $applyleaveteams)
                                                <span
                                                    class="badge badge-primary">{{ $applyleaveteams->team_member ?? '' }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @if ($applyleave->leavetype == 6)
                                        <tr>


                                            <td><b>Report : </b></td>

                                            <td>
                                                @if ($applyleave->report != null)
                                                    <a target="blank"
                                                        href="{{ url('/backEnd/image/report/' . $applyleave->report) }}">{{ $applyleave->report ?? '' }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>

                                        @if (Request::is('applyleave/*'))
                                            @if (
                                                $applyleave->approver == Auth::user()->teammember_id ||
                                                    Auth::user()->teammember_id == 878 ||
                                                    Auth::user()->teammember_id == 447)
                                                @if ($applyleave->status == '0')
                                                    <td><b>Action :</b></td>
                                                    <td>
                                                        <div class="row">

                                                            <form method="post"
                                                                action="{{ route('applyleave.update', $applyleave->id) }}"
                                                                enctype="multipart/form-data">
                                                                @method('PATCH')
                                                                @csrf
                                                                <button type="submit" class="btn btn-success">
                                                                    Approve</button>
                                                                <input type="text" hidden id="example-date-input"
                                                                    name="status" value="1" class="form-control"
                                                                    placeholder="Enter Location">
                                                            </form>
                                                            <button style="margin-left:11px;height: 35px;"
                                                                data-toggle="modal" data-target="#exampleModal12"
                                                                class="btn btn-danger">
                                                                Reject</button>
                                                        </div>
                                                    </td>
                                                @endif
                                            @endif
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


    <script>
        function myFunction() {
            document.getElementById("panel").style.display = "block";
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{ url('backEnd/ckeditor/ckeditor.js') }}"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>

@endsection

<!-- model box / pop up box  -->
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
            <form method="post" action="{{ url('applyleave/update', $applyleave->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea rows="6" name="remark" class="form-control" placeholder=""></textarea>
                                <input hidden type="text" id="example-date-input" name="status" value="2"
                                    class="form-control" placeholder="Enter Reason">
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
