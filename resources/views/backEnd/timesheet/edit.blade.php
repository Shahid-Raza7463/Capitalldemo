<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

    <div class="body-content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header" style="background:#37A000">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color:white" class="fs-17 font-weight-600 mb-0">Edit Time sheet</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ url('timesheet/updated/') }}" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            @component('backEnd.components.alert')
                            @endcomponent
                            <div class="field_wrapper">
                                <div class="row row-sm">
                                    <div class="col-3" style="margin-left: 35%">
                                        <div class="form-group">
                                            <label class="font-weight-600">Select Date</label>
                                            <input type="date" class="language form-control" name="date"
                                                id="txtDate" value="{{ $date ?? '' }}">

                                        </div>
                                    </div>
                                </div>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($timesheet as $item)
                                    @php
                                        $i = $i + 1;
                                    @endphp
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="font-weight-600">Client Name</label>
                                                <select class="language form-control" name="client_id[]"
                                                    id="client{{ $i }}"
                                                    @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
                                            Client
                                            </option>
                            
                                            @foreach ($client as $clientData)
                                            <option value="{{ $clientData->id }}"
                                                {{ $item->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                                {{ $clientData->client_name }}</option>
                                            @endforeach
                            
                            
                                            @else
                                            <option></option>
                                            <option value="">Select Client</option>
                                            @foreach ($client as $clientData)
                                            <option value="{{ $clientData->id }}"
                                                {{ $item->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                                {{ $clientData->client_name }}</option>
                                            @endforeach @endif
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600">Assignment Name</label>
                                                <select class="form-control key" name="assignment_id[]"
                                                    id="assignment{{ $i }}">
                                                    @if (!empty($item->assignment_id))
                                                        <option value="{{ $item->assignment_id }}">
                                                            {{ App\Models\Assignment::where('id', $item->assignment_id)->first()->assignment_name ?? '' }}
                                                        </option>
                                                    @endif
                                                </select>
                                                <!-- <select class="form-control key" name="assignment_id[]" id="assignment">
                                                                         <option disabled style="display:block">Select
                                                                            Assignment
                                                                            </option>
                                                                            
                                                                        </select> -->

                                                <!--<a href="{{ url('/assignment') }}">Add Assignment</a>-->
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600" style="width:100px;">Work Item</label>
                                                <input type="text" name="workitem[]" id="key"
                                                    value="{{ $item->workitem ?? '' }}" class="form-control key">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600">Billable Status</label>
                                                <select class="form-control key" name="billable_status[]">
                                                    @if (Request::is('timesheet/edit/*'))
                                                        >
                                                        @if ($item->billable_status == 'Billable')
                                                            <option value="Billable">Billable</option>
                                                            <option value="Non Billable">Non Billable</option>
                                                        @else
                                                            <option value="Non Billable">Non Billable</option>
                                                            <option value="Billable">Billable</option>
                                                        @endif
                                                    @else
                                                        <option value="Billable">Billable</option>
                                                        <option value="Non Billable">Non Billable</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600">Hour</label>
                                                <input type="text" class="txtCal form-control"
                                                    id="hour{{ $i }}" name="hour[]" onkeyup="sum()"
                                                    value="{{ $item->hour ?? '' }}">
                                            </div>
                                        </div>
                                        <!--<div class="col-1">
                                                                        <div class="form-group" style="margin-top: 36px;">
                                                                            <a href="javascript:void(0);" class="add_button" title="Add field"><img
                                                                                    src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                                                                        </div>
                                                                    </div>-->
                                    </div>
                                @endforeach


                                @php  $j=6;@endphp

                                @for ($i = 0; $i < $rcount; $i++)
                                    @php  $j= $j-1; @endphp
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="font-weight-600">Client Name</label>
                                                <select class="language form-control" name="client_id[]"
                                                    id="client{{ $j }}"
                                                    @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
                                        Client
                                        </option>
                        
                                        @foreach ($client as $clientData)
                                        <option value="{{ $clientData->id }}"
                                            {{ $timesheet->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                            {{ $clientData->client_name }}</option>
                                        @endforeach
                        
                        
                                        @else
                                        <option></option>
                                        <option value="">Select Client</option>
                                        @foreach ($client as $clientData)
                                        <option value="{{ $clientData->id }}">
                                            {{ $clientData->client_name }}</option>
                        
                                        @endforeach @endif
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600">Assignment Name</label>
                                                <select class="form-control key" name="assignment_id[]"
                                                    id="assignment{{ $j }}">
                                                    @if (!empty($timesheet->assignment_id))
                                                        <option value="{{ $timesheet->assignment_id }}">
                                                            {{ App\Models\Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                                                        </option>
                                                    @endif
                                                </select>
                                                <!-- <select class="form-control key" name="assignment_id[]" id="assignment">
                                                                     <option disabled style="display:block">Select
                                                                        Assignment
                                                                        </option>
                                                                        
                                                                    </select> -->

                                                <!-- <a href="{{ url('/assignment') }}">Add Assignment</a>-->
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600" style="width:100px;">Work Item</label>
                                                <input type="text" name="workitem[]" id="key" value=""
                                                    class="form-control key">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600">Billable Status</label>
                                                <select class="form-control key" name="billable_status[]">
                                                    @if (Request::is('timesheet/*/edit'))
                                                        >
                                                        @if ($timesheet->billable_status == 'Billable')
                                                            <option value="Billable">Billable</option>
                                                            <option value="Non Billable">Non Billable</option>
                                                        @else
                                                            <option value="Non Billable">Non Billable</option>
                                                            <option value="Billable">Billable</option>
                                                        @endif
                                                    @else
                                                        <option value="Billable">Billable</option>
                                                        <option value="Non Billable">Non Billable</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600">Hour</label>
                                                <input type="text" class="txtCal form-control"
                                                    id="hour{{ $j }}" name="hour[]" onkeyup="sum()"
                                                    value="0">
                                            </div>
                                        </div>
                                        <!--<div class="col-1">
                                                                    <div class="form-group" style="margin-top: 36px;">
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field"><img
                                                                                src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                                                                    </div>
                                                                </div>-->
                                    </div>
                                @endfor
                                <hr>
                                <div class="form-group">
                                    <div class="col-10">
                                    </div>
                                    <div class="col-2" style="margin-left: 759px;">
                                        <div class="form-group">
                                            <label class="font-weight-600">Total Hour</label>
                                            <input type="text" class="txtCal form-control" id="totalhours"
                                                name="totalhour"
                                                value="{{ App\Models\Timesheet::where('date', $date)->first()->totalhour ?? '' }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">

                                    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                    <a class="btn btn-secondary" href="{{ url('timesheet') }}">
                                        Back</a>

                                </div>
                        </form>
                        <hr class="my-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->

@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js') }}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $(function() {
        $('#client1').on('change', function() {
            var cid = $(this).val();
            // alert(category_id);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: "cid=" + cid,
                success: function(res) {
                    $('#assignment1').html(res);
                },
                error: function() {},
            });
        });
    });
</script>
<script>
    $(function() {
        $('#client2').on('change', function() {
            var cid = $(this).val();
            // alert(category_id);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: "cid=" + cid,
                success: function(res) {
                    $('#assignment2').html(res);
                },
                error: function() {},
            });
        });
    });
</script>
<script>
    $(function() {
        $('#client3').on('change', function() {
            var cid = $(this).val();
            // alert(category_id);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: "cid=" + cid,
                success: function(res) {
                    $('#assignment3').html(res);
                },
                error: function() {},
            });
        });
    });
</script>
<script>
    $(function() {
        $('#client4').on('change', function() {
            var cid = $(this).val();
            // alert(category_id);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: "cid=" + cid,
                success: function(res) {
                    $('#assignment4').html(res);
                },
                error: function() {},
            });
        });
    });
</script>
<script>
    $(function() {
        $('#client5').on('change', function() {
            var cid = $(this).val();
            // alert(category_id);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: "cid=" + cid,
                success: function(res) {
                    $('#assignment5').html(res);
                },
                error: function() {},
            });
        });
    });
</script>
<script type="text/javascript">
    function sum() {
        // alert();
        var hour1 = document.getElementById('hour1').value;
        //alert(hour1);
        var hour2 = document.getElementById('hour2').value;
        // alert(hour2);
        var hour3 = document.getElementById('hour3').value;
        // alert(hour3);
        //  var hour4 =0;
        //   var hour5 =0;
        var hour4 = document.getElementById('hour4').value;
        var hour5 = document.getElementById('hour5').value;
        //  alert(hour2);
        var result = parseFloat(hour1) + parseFloat(hour2) + parseFloat(hour3) + parseFloat(hour4) + parseFloat(hour5);
        //alert(result);
        if (!isNaN(result)) {
            document.getElementById('totalhours').value = result;
        }
    }
</script>
<script>
    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();

        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        $('#txtDate').attr('max', maxDate);
    });
</script>
