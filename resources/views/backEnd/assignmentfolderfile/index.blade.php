@extends('backEnd.layouts.layout') @section('backEnd_content')

    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">

                <li><a class="btn btn-info"
                        href="{{ url('assignmentfolders/' . $foldername->assignmentgenerateid) }}">Back</a>
                </li>
                @if (isset($assignmentfolderfile[0]->assignmentfolder_id))
                    <li style="margin-left: 13px;">
                        <a href="{{ route('zip', ['assignmentfolder_id' => $assignmentfolderfile[0]->assignmentfolder_id]) }}"
                            class="btn btn-secondary">Download File</a>
                    </li>
                @endif
                @if ($assignmentbudgeting->status == 1)
                    <li style="margin-left: 13px;"><a class="btn btn-primary" style="color:white;" data-toggle="modal"
                            data-target=".bd-example-modal-lg">Tag File</a></li>
                    <li style="margin-left: 13px;"><a class="btn btn-success" style="color:white;" data-toggle="modal"
                            data-target="#exampleModal1">Add File</a></li>
                @endif
            </ol>
        </nav>


        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-group-outline d-block mr-2"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Assignment File List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">
            <div class="card-header" style="background:#37a000;">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">

                            <span style="color:white;"> {{ $foldername->assignmentfoldersname ?? '' }}</span>

                        </h6>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div>
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            @if (is_array(session()->get('success')))
                                @foreach (session()->get('success') as $message)
                                    <p>{{ $message }}</p>
                                @endforeach
                            @else
                                <p>{{ session()->get('success') }}</p>
                            @endif
                        </div>
                    @endif
                    @if (session()->has('statuss'))
                        <div class="alert alert-danger">
                            @if (is_array(session()->get('statuss')))
                                @foreach (session()->get('statuss') as $message)
                                    <p>{{ $message }}</p>
                                @endforeach
                            @else
                                <p>{{ session()->get('success') }}</p>
                            @endif
                        </div>
                    @endif
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li style="color:red;">{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display table-bordered table-striped table-hover basic">
                        <thead>
                            <tr>
                                <th>Particular</th>
                                <th>File</th>
                                <th>Created By</th>
                                <th>Date</th>
                                @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                                    @if ($assignmentbudgeting->status == 1)
                                        <th>Action</th>
                                    @endif
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignmentfolderfile as $assignmentfolderData)
                                <tr>

                                    <td>{{ $assignmentfolderData->particular }}</td>
                                    <td><a target="blank"
                                            href="{{ Storage::disk('s3')->temporaryUrl($foldername->assignmentgenerateid . '/' . $assignmentfolderData->filesname, now()->addMinutes(8)) }}">
                                            {{ $assignmentfolderData->filesname ?? '' }}</a></td>
                                    <td>{{ $assignmentfolderData->team_member }} ( {{ $assignmentfolderData->staffcode }}
                                        )</td>
                                    <td>{{ date('F d,Y', strtotime($assignmentfolderData->created_at)) }}
                                        {{ date('h:i A', strtotime($assignmentfolderData->created_at)) }} </td>
                                    @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                                        @if ($assignmentbudgeting->status == 1)
                                            <td> <a href="{{ url('/bulkfile/delete/' . $assignmentfolderData->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                                    class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!--/.body content-->
    <!-- Modal -->
    <!--/.body content-->
    {{-- progress bar style --}}
    <style>
        .progress {
            position: relative;
            width: 100%;
            height: 20px;
            background-color: #f5f5f5
        }

        .bar {
            width: 0%;
            background-color: #007bff;
            height: 20px;
        }

        .percent {
            position: absolute;
            display: inline-block;
            /* top: 85%; */
            left: 50%;
            color: red;
        }
    </style>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('assignmentfiles/upload') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37a000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add File</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color: red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="details-form-field form-group row">
                            <label for="particular" class="col-sm-3 col-form-label font-weight-600">Particular:</label>
                            <div class="col-sm-9">
                                <input id="particular" class="form-control" name="particular" type="text">
                                <input type="hidden" class="form-control" name="assignmentfolder_id"
                                    value="{{ $id }}" type="text">
                                <input type="hidden" class="form-control" name="assignmentgenerateid"
                                    value="{{ $foldername->assignmentgenerateid }}" type="text">
                            </div>
                        </div>
                        <div class="details-form-field form-group row">
                            <label for="file" class="col-sm-3 col-form-label font-weight-600">File:</label>
                            <div class="col-sm-9">
                                <input id="file" class="form-control" name="file[]" multiple type="file">
                                <span>Maximum file upload: 50 at once</span>
                            </div>
                        </div>
                        {{-- <div class="details-form-field form-group row progress-container" style="display: none;">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">File Uplade:</label>
                            <div class="col-sm-9 d-flex justify-content-center align-items-center">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                        aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">File upload:</label>
                            <div class="col-sm-9 d-flex justify-content-center align-items-center">
                                <div class="progress">
                                    <div class="bar"></div>
                                    <div class="percent">0%</div>
                                </div>
                                <div id="status"></div>
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


    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Form Plugin CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script> --}}
    {{-- add file per click karne per ager dd karna hai to is script ko comment kar do --}}
    <script type="text/javascript">
        var bar = $('.bar');
        var percent = $('.percent');

        $('form').ajaxForm({
            beforeSend: function() {
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                console.log(percentComplete);
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
                console.log(percentVal);
            },
            complete: function(xhr) {
                var folderId = "{{ $foldername->id }}";
                window.location = "{{ url('assignmentfolderfiles') }}/" + folderId;
                // window.location = "{{ url('/') }}/test";
            }
        });
    </script>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white" class="modal-title font-weight-600" id="exampleModalLabel4">Tag File In
                        Checklist
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
                    <div>
                        <form method="post" action="{{ url('auditchecklistanswer/tag/store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row row-sm">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600"><b>Financial *</b></label>
                                        <select class="form-control " required name="financialstatemantclassfication_id"
                                            id="category">

                                            <option>Please Select One</option>
                                            @foreach ($financial as $financialData)
                                                <option value="{{ $financialData->id }}"
                                                    @if (!empty($store->financial) && $store->financial == $financialData->id) selected @endif>
                                                    {{ $financialData->financial_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600"><b>Sub Financial *</b></label>
                                        <select class="form-control" required id="subcategory_id" name="subclassfied_id">
                                            <option disabled style="display:block">Please Select One</option>
                                            @if (!empty($store->city))
                                                <option value="{{ $store->subcategory_id }}">
                                                    {{ App\Location::where('id', $store->city)->first()->cityname ?? '' }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600"><b>Step Name *</b></label>
                                        <select class="form-control" required id="step_id" name="steplist_id">
                                            <option disabled style="display:block">Please Select One</option>
                                            @if (!empty($store->city))
                                                <option value="{{ $store->subcategory_id }}">
                                                    {{ App\Location::where('id', $store->city)->first()->cityname ?? '' }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600"><b>Audit Procedure *</b></label>
                                        <select class="form-control" required id="audit_id" name="audit_id">
                                            <option disabled style="display:block">Please Select One</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600"><b>Tag File *</b></label>
                                        <select class="form-control" required name="tagfile">
                                            <option value="">Please Select One</option>
                                            @foreach ($assignmentfolderfile as $assignmentfolderData)
                                                <option value="{{ $assignmentfolderData->filesname }}">
                                                    {{ $assignmentfolderData->filesname }}</option>
                                            @endforeach

                                        </select>
                                        <input type="text" hidden name="assignment_id"
                                            value="{{ $foldername->assignmentgenerateid }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <br>
                                        <button style="margin-top: 9px;" type="submit" class="btn btn-success">
                                            Submit</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('#category').on('change', function() {
                var category_id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ url('tags/create') }}",
                    data: "category_id=" + category_id,
                    success: function(res) {

                        $('#subcategory_id').html(res);


                    },
                    error: function() {

                    },
                });
            });
            $('#subcategory_id').on('change', function() {
                var subcategory_id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ url('tags/create') }}",
                    data: "subcategory_id=" + subcategory_id,
                    success: function(res) {

                        $('#step_id').html(res);


                    },
                    error: function() {

                    },
                });
            });
            $('#step_id').on('change', function() {
                var step_id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ url('tags/create') }}",
                    data: "step_id=" + step_id,
                    success: function(res) {

                        $('#audit_id').html(res);


                    },
                    error: function() {

                    },
                });
            });

        });
    </script>
@endsection
