{{-- library  --}}
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">


@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="body-content">
        {{-- @php
            dd($timesheetedit[0]);
        @endphp --}}
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header" style="background:#37A000">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color:white" class="fs-17 font-weight-600 mb-0">Update Time sheet</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ url('/timesheetupdate/submit') }}" enctype="multipart/form-data"
                            id="detailsForm" style="margin-bottom: 0px;">

                            @csrf
                            @component('backEnd.components.alert')
                            @endcomponent
                            <div class="row row-sm">
                                <div class="col-6">
                                    @php
                                        // dd($timesheetedit[0]->assignment_id);
                                    @endphp
                                    <div class="form-group">
                                        <label class="font-weight-600">Client Name *</label>
                                        <select required class="language form-control" name="client_id" id="client"
                                            @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
                                                Client
                                                </option>
                            
                                                @foreach ($client as $clientData)
                                                <option value="{{ $clientData->id }}">
                                                    {{ $clientData->client_name }}</option>
                                                @endforeach
                                                
                            
                                                @else
                                                <option></option>
                                                <option value="">Select Client</option>
                                                @foreach ($client as $clientData)
                                                <option value="{{ $clientData->id }}"{{ $timesheetedit[0]->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                                    {{ $clientData->client_name }}</option>
                            
                                                @endforeach @endif
                                            </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Assignment Name *</label>

                                        <select class="form-control key" name="assignment_id" id="assignment">
                                   
                                            @if (!empty($timesheetedit[0]->assignment_id))
                                                @php
                                                    $assignment = app('App\Models\Assignment')
                                                        ->where('id', $timesheetedit[0]->assignment_id)
                                                        ->first();
                                                @endphp
                                                @if ($assignment)
                                            
                                                    <option value="{{ $assignment->id }}">
                                                        {{ $assignment->assignment_name }}
                                                    </option>
                                                @endif
                                            @endif
                                            @if (!empty($timesheet->assignment_id))
                                                <option value="{{ $assignment->id }}"
                                                    {{ $timesheetedit[0]->assignment_id == $assignment->id ? 'selected' : '' }}>
                                                    {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                                                </option>
                                            @endif
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Partner *</label>

                                        <select class="language form-control" id="partner" name="partner">
                                            @if (!empty($timesheetedit[0]->partner))
                                                @php
                                                    $assignment = app('App\Models\Teammember')
                                                        ->where('id', $timesheetedit[0]->partner)
                                                        ->first();
                                                @endphp
                                                @if ($assignment)
                                                    <option value="{{ $timesheetedit[0]->partner }}">
                                                        {{ $assignment->team_member }}
                                                    </option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Employee Name</label>
                                    <input required type="text" name="teammember" class="form-control"
                                        value="{{ $timesheetedit[0]->team_member }}" placeholder="Enter Employee Name"
                                        readonly>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600" style="width:100px;">Location *</label>
                                        <input required type="text" name="location" id="location"
                                            value="{{ $timesheetedit[0]->location }}" class="form-control"
                                            placeholder="Enter Location">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600" style="width:100px;">Work Item *</label>
                                        <input required type="text" name="workitem"
                                            value="{{ $timesheetedit[0]->workitem }}" class="form-control"
                                            placeholder="Enter Name">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="status" value="{{ $timesheetedit[0]->status }}"
                                            class="form-control" placeholder="Enter Location">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="timesheetusersid" value="{{ $timesheetedit[0]->id }}"
                                            class="form-control" placeholder="Enter Location">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="createdby" value="{{ $timesheetedit[0]->createdby }}"
                                            class="form-control" placeholder="Enter Location">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Hour *</label>
                                        <input required type="text" name="hour" id="hour"
                                            value="{{ $timesheetedit[0]->hour }}" class="form-control"
                                            placeholder="Enter Location">

                                        <span style="font-size: 10px;margin-left: 10px;"></span>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right">Submit</button>
                                <a class="btn btn-secondary" href="{{ url('timesheet') }}">
                                    Back</a>
                            </div>

                      



                            <script>
                                function calculateTotal() {
                                    var hour1 = parseInt(document.getElementById("hour1").value) || 0;
                                    var hour2 = parseInt(document.getElementById("hour2").value) || 0;
                                    var hour3 = parseInt(document.getElementById("hour3").value) || 0;
                                    var hour4 = parseInt(document.getElementById("hour4").value) || 0;
                                    var hour5 = parseInt(document.getElementById("hour5").value) || 0;

                                    var totalSum = hour1 + hour2 + hour3 + hour4 + hour5;

                                    document.getElementById("totalhours").value = totalSum;
                                }


                                function validateTimeInput(inputId, maxTime) {
                                    const timeInput = document.getElementById(inputId);

                                    timeInput.addEventListener('input', function() {
                                        const inputTime = this.value;

                                        if (inputTime > maxTime) {
                                            this.setCustomValidity('The time entered exceeds the maximum of 24 hours');
                                        } else {
                                            this.setCustomValidity('');
                                        }
                                    });
                                }

                       
                            </script>
                            {{-- 2222222222222222222222 --}}

                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    var maxField = 10; //Input fields increment limitation
                                    var addButton = $('.add_button'); //Add button selector
                                    var wrapper = $('.field_wrapper'); //Input field wrapper
                                    var x = 1;

                                    var fieldHTML =
                                        '<div class="row row-sm "><div class="col-3"><div class="form-group"><label class="font-weight-600">Client Name</label><select class="language form-control" name="client_id[]" id="client' +
                                        x +
                                        '" ><option>Select Client</option>@foreach ($client as $clientData)<option value="{{ $clientData->id }}" @if (!empty($store->financial) && $store->financial == $clientData->id) selected @endif>{{ $clientData->client_name }}</option>@endforeach</select></div></div><div class="col-2"><div class="form-group"><label class="font-weight-600">Assignment Name</label><select class="form-control key" name="assignment_id[]" id="assignment' +
                                        x +
                                        '"><option disabled style="display:block">Select Assignment</option></select></div></div><div class="col-2"><div class="form-group"><label class="font-weight-600" style="width:100px;">Work Item </label><input type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ??
                                            '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ' }}" class="form-control key"></div></div><div class="col-2"> <div class="form-group"> <label class="font-weight-600"> Billable Status </label><select class="form-control key" name="billable_status[]" id="key" value="" > <option value="Billable">Billable</option> <option value="Non Billable">Non Billable</option> </select> </div> </div><div class="col-2"><div class="form-group"><label class="font-weight-600">Hour </label><input type="text" class="form-control key" name="hour[]" id="endTime" value="{{ $timesheet->hour ??
                                            '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ' }}"></div></div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            backEnd / image / remove - icon.png ') }}"/></a></div></div>'; //New input field html 
                                    //Initial field counter is 1

                                    //Once add button is clicked
                                    $(addButton).click(function() {
                                        //Check maximum number of input fields
                                        if (x < maxField) {
                                            x++; //Increment field counter
                                            $(wrapper).append(fieldHTML); //Add field html
                                        }
                                    });

                                    //Once remove button is clicked
                                    $(wrapper).on('click', '.remove_button', function(e) {
                                        e.preventDefault();
                                        $(this).parent('div').remove(); //Remove field html
                                        x--; //Decrement field counter
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                function sum() {

                                    var hour1 = document.getElementById('hour1').value;
                                    // alert(hour1);
                                    var hour2 = document.getElementById('hour2').value;
                                    var hour3 = document.getElementById('hour3').value;
                                    var hour4 = document.getElementById('hour4').value;
                                    var hour5 = document.getElementById('hour5').value;
                                    //  alert(hour2);
                                    var result = parseFloat(hour1) + parseFloat(hour2) + parseFloat(hour3) + parseFloat(hour4) + parseFloat(
                                        hour5);
                                    //alert(result);
                                    if (!isNaN(result)) {
                                        document.getElementById('totalhours').value = result;
                                    }
                                }
                            </script>

                            {{-- select box validation for timesheet create --}}
                            <script>
                                $(function() {
                                    // select client 1
                                    $('#detailsForm').on('submit', function(e) {
                                        var clientvalue = $('#client').val();
                                        var assmentvalue = $('#assignment').val();
                                        var partnervalue = $('#partner').val();

                                        if (clientvalue != "" || clientvalue != "Select Client") {
                                            if (assmentvalue == "Select Assignment" || assmentvalue == "") {
                                                alert("Please select a assignment");
                                                e.preventDefault();
                                                $('#assignment1').focus();
                                            } else if (partnervalue == "Select Partner" || partnervalue == "") {
                                                alert("Please select a partner");
                                                e.preventDefault();
                                                $('#partner1').focus();
                                            }
                                        }
                                    });

                                });
                            </script>

                            <script>
                                $(function() {
                                    $('#client').on('change', function() {
                                        var cid = $(this).val();
                                        //   alert(cid);
                                        $.ajax({
                                            type: "get",
                                            url: "{{ url('timesheet/create') }}",
                                            data: "cid=" + cid,
                                            success: function(res) {
                                                $('#assignment').html(res);
                                            },
                                            error: function() {},
                                        });
                                    });
                                    $('#assignment').on('change', function() {
                                        var assignment = $(this).val();
                                        // alert(category_id);
                                        $.ajax({
                                            type: "get",
                                            url: "{{ url('timesheet/create') }}",
                                            data: "assignment=" + assignment,
                                            success: function(res) {
                                                $('#partner').html(res);
                                            },
                                            error: function() {},
                                        });
                                    });
                                });
                            </script>
                            {{-- validation on hour --}}
                            <script>
                                $(function() {
                                    $('#hour').on('change', function(e) {
                                        var hourvalue = $('#hour').val();
                                        if (hourvalue > 12) {
                                            alert('Hour cannot fill greater than 12.');
                                        }
                                    });
                                });
                            </script>



                            <script>
                                $(function() {
                                    $('input[name="daterange"]').daterangepicker({
                                        opens: 'left'
                                    }, function(start, end, label) {
                                        console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end
                                            .format('DD-MM-YYYY'));
                                    });
                                });
                            </script>


                            <!--Page Active Scripts(used by this page)-->
                            <script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js') }}"></script>
                            <!--Page Scripts(used by all page)-->
                            <script src="{{ url('backEnd/dist/js/sidebar.js') }}"></script>

                        </form>
                        <hr class="my-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
@endsection
