<div class="field_wrapper">

    <div class="row row-sm">
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Client Name *</label>
                <select required class="language form-control" name="client_id[]" id="client"
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
                <label class="font-weight-600">Assignment Name *</label>
                <select class="form-control key" name="assignment_id[]" id="assignment">
                    @if (!empty($timesheet->assignment_id))
                        <option value="{{ $timesheet->assignment_id }}">
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif
                </select>
                <!-- <select class="form-control key" name="assignment_id[]" id="assignment">
             <option disabled style="display:block">Select
                Assignment
                </option>
                
            </select> -->

            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>
                <select required class="language form-control" id="partner" name="partner[]">
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item *</label>
                <input required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                    class="form-control key">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                    class="form-control key">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour *</label>
                <input required type="number" class="form-control" id="hour1" name="hour[]" min="0"
                    oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    value="0" step="1">

                <span style="font-size: 10px;margin-left: 10px;"></span>
            </div>
        </div>
        <!--<div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>-->
    </div>
    <div class="row row-sm">
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Client Name</label>
                <select class="language form-control" name="client_id[]" id="client1"
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
                <select class="form-control key" name="assignment_id[]" id="assignment1">
                    @if (!empty($timesheet->assignment_id))
                        <option value="{{ $timesheet->assignment_id }}">
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif
                </select>
                <!-- <select class="form-control key" name="assignment_id[]" id="assignment">
             <option disabled style="display:block">Select
                Assignment
                </option>
                
            </select> -->


            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>
                <select class="language form-control" id="partner1" name="partner[]">
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item</label>
                <input type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                    class="form-control key workItem1">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                    class="form-control key location1">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour</label>
                <input type="number" class="form-control hour1" id="hour2" min="0" name="hour[]"
                    oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    value="0" step="1">

            </div>
        </div>
        <!-- <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>-->
    </div>

    <div class="row row-sm">
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Client Name</label>
                <select class="language form-control" name="client_id[]" id="client2"
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
                <select class="form-control key" name="assignment_id[]" id="assignment2">
                    @if (!empty($timesheet->assignment_id))
                        <option value="{{ $timesheet->assignment_id }}">
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif
                </select>
                <!-- <select class="form-control key" name="assignment_id[]" id="assignment">
             <option disabled style="display:block">Select
                Assignment
                </option>
                
            </select> -->


            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>
                <select class="language form-control" id="partner2" name="partner[]">
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item</label>
                <input type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                    class="form-control key workItem2">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                    class="form-control key Location2">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour</label>
                <input type="number" class="form-control hour2" id="hour3" min="0" name="hour[]"
                    oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    value="0" step="1">

            </div>
        </div>
        <!-- <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>-->
    </div>
    <div class="row row-sm">
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Client Name</label>
                <select class="language form-control" name="client_id[]" id="client3"
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
                <select class="form-control key" name="assignment_id[]" id="assignment3">
                    @if (!empty($timesheet->assignment_id))
                        <option value="{{ $timesheet->assignment_id }}">
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif
                </select>
                <!-- <select class="form-control key" name="assignment_id[]" id="assignment">
             <option disabled style="display:block">Select
                Assignment
                </option>
                
            </select> -->



            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>
                <select class="language form-control" id="partner3" name="partner[]">
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item</label>
                <input type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                    class="form-control key workItem3">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                    class="form-control key Location3">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour</label>
                <input type="number" class="form-control hour3" id="hour4" min="0" name="hour[]"
                    oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    value="0" step="1">

            </div>
        </div>
        <!--  <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>-->
    </div>
    <div class="row row-sm">
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Client Name</label>
                <select class="language form-control" name="client_id[]" id="client4"
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
                <select class="form-control key" name="assignment_id[]" id="assignment4">
                    @if (!empty($timesheet->assignment_id))
                        <option value="{{ $timesheet->assignment_id }}">
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif
                </select>
                <!-- <select class="form-control key" name="assignment_id[]" id="assignment">
             <option disabled style="display:block">Select
                Assignment
                </option>
                
            </select> -->



            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>
                <select class="language form-control" id="partner4" name="partner[]">
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item</label>
                <input type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                    class="form-control key workItem4">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                    class="form-control key Location4">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour</label>
                <input type="number" class="form-control hour4" id="hour5" min="0" name="hour[]"
                    oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    value="0" step="1">

            </div>
        </div>
        <!-- <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>-->
    </div>
</div>
<hr>
<div class="form-group">
    <div class="col-10">
    </div>
    <div class="col-2" style="margin-left: 759px;">
        <div class="form-group">
            <label class="font-weight-600">Total Hour</label>
            <input type="text" class="time form-control" id="totalhours" name="totalhour"
                value="{{ $timesheet->hour ?? '' }}">
        </div>
    </div>

</div>
<div class="form-group">

    <button type="submit" class="btn btn-success" style="float:right"> Save</button>
    <a class="btn btn-secondary" href="{{ url('timesheet') }}">
        Back</a>

</div>

{{-- <script type="text/javascript">
   $(function () {
    $('#timepicker').datetimepicker({
        use24hours: true,
        format: 'HH:mm'
    });
});
 </script> --}}

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

    // Call the function for each input element
    // validateTimeInput('hour1', '24:00');
    // validateTimeInput('hour2', '24:00');
    // validateTimeInput('hour3', '24:00');
    // validateTimeInput('hour4', '24:00');
    // validateTimeInput('hour5', '24:00');
</script>
