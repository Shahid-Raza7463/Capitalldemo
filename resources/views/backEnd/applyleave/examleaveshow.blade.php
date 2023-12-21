@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                @if ($applyleave->approver == Auth::user()->teammember_id || Auth::user()->teammember_id == $applyleave->createdby)
                    @if ($applyleave->status == '0')
                        <!--    <li class="btn btn-info ml-2"><a href="{{ route('applyleave.edit', $applyleave->id ?? '') }}"style="color:white;">Edit</a></li> -->
                    @endif
                @endif
                <li> <a class="btn btn-success ml-2" href="{{ url('applyleave') }}"> Back</a></li>
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
                    {{-- @php
                        dd($applyleave);
                    @endphp --}}
                    <div class="card-body">

                        <fieldset class="form-group">

                            <table class="table display table-bordered table-striped table-hover">

                                <tbody>

                                    <tr>
                                        <td><b>Leave : </b></td>
                                        <td>{{ $applyleave->name }}</td>
                                        <td><b>Raised By :</b></td>
                                        <td>{{ $applyleave->createdbyauth }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Approver : </b></td>
                                        <td>{{ $applyleave->approverName }} </td>
                                        <td><b>Reason for request : </b></td>
                                        <td>{{ $applyleave->reason }}</td>
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

                                        <td><b>Request Date : </b></td>
                                        <td>{{ date('F d,Y', strtotime($applyleave->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        @if (Request::is('examleaverequest/*'))
                                            @if (
                                                $applyleave->approver == Auth::user()->teammember_id ||
                                                    Auth::user()->teammember_id == 878 ||
                                                    Auth::user()->teammember_id == 447)
                                                @if ($applyleave->status == '0')
                                                    <td><b>Action :</b></td>
                                                    <td>
                                                        <div class="row">

                                                            <form method="post"
                                                                action="{{ route('examleaveapprove', $applyleave->id) }}"
                                                                enctype="multipart/form-data">
                                                                @method('PATCH')
                                                                @csrf
                                                                <button type="submit" class="btn btn-success">
                                                                    Approve</button>
                                                                <input type="text" hidden id="example-date-input"
                                                                    name="status" value="1" class="form-control"
                                                                    placeholder="Enter Location">
                                                            </form>
                                                            <form method="post"
                                                                action="{{ route('examleaveapprove', $applyleave->id) }}"
                                                                enctype="multipart/form-data">
                                                                @method('PATCH')
                                                                @csrf
                                                                <button style="margin-left:11px;" type="submit"
                                                                    class="btn btn-danger">
                                                                    Reject</button>
                                                                <input hidden type="text" id="example-date-input"
                                                                    name="status" value="2" class="form-control"
                                                                    placeholder="Enter Location">
                                                            </form>
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
