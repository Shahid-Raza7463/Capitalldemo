<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Client *</label>
            <select class="search_test" id="category" name="client_id"
                @if (Request::is('assignmentmapping/*/edit')) > <option disabled style="display:block">Please Select One
                </option>

                @foreach ($client as $clientData)
                <option value="{{ $clientData->id }}"
                    {{ $assignmentmapping->client->id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                    {{ $clientData->client_name }} </option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($client as $clientData)
                <option value="{{ $clientData->id }}">
                    {{ $clientData->client_name }} </option>

                @endforeach @endif
                </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assignment *</label>
            <select class="form-control" id="subcategory_id" name="assignment_id">
            </select>
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600"> Period Start</label>
            <input type="date" name="periodstart" id="startDate" value="{{ $assignmentmapping->periodstart ?? '' }}"
                class=" form-control" placeholder="Enter Period start">
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Period End</label>
            <input type="date" required name="periodend" id="endDate"
                value="{{ $assignmentmapping->periodend ?? '' }}" class=" form-control" placeholder="Enter Perio End">
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Is Role Over Assignment</label>
            <select class="form-control" id="exampleFormControlSelect1" name="roleassignment">
                <option value="1">No</option>
                <option value="2">Yes</option>

            </select>
        </div>
    </div>
</div>
<div class="row row-sm">

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Est Hours</label>
            <input type="text" required name="esthours" value="{{ $assignmentmapping->esthours ?? '' }}"
                class=" form-control" placeholder="Enter Est Hours">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Std Cost</label>
            <input type="text" required name="stdcost" value="{{ $assignmentmapping->stdcost ?? '' }}"
                class=" form-control" placeholder="Enter Std Cost">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Est Cost</label>
            <input type="text" required name="estcost" value="{{ $assignmentmapping->estcost ?? '' }}"
                class=" form-control" placeholder="Enter Est Cost">
        </div>
    </div>

</div>
<div class="row row-sm">

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Fees of The Asignment</label>
            <input type="number" required name="fees" value="{{ $assignmentmapping->fees ?? '' }}"
                class=" form-control" placeholder="Enter Fees of The Asignment">
        </div>
    </div>
    <!-- <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Location</label>
            <input type="text" required name="location" value="{{ $assignmentmapping->location ?? '' }}" class=" form-control"
                placeholder="Enter Location">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Fees (Excluding GST)
</label>
            <input type="text" required name="gstcost" value="{{ $assignmentmapping->gstcost ?? '' }}" class=" form-control"
                placeholder="Enter Gst Cost">
        </div>
    </div> -->

</div>
<!--<div class="row row-sm">
   
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">File Creation Date</label>
            <input type="date" name="filecreationdate" value="{{ $assignmentmapping->filecreationdate ?? '' }}" class=" form-control"
                placeholder="Enter File Creation Date">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Modified Date</label>
            <input type="date" name="modifieddate" value="{{ $assignmentmapping->modifieddate ?? '' }}" class=" form-control"
                placeholder="Enter Modified Date">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Audit Completion Date</label>
            <input type="date" name="auditcompletiondate" value="{{ $assignmentmapping->auditcompletiondate ?? '' }}" class=" form-control"
                placeholder="Enter Audit Completion Date">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"> Documentaion Date</label>
            <input type="date" name="documentationdate" value="{{ $assignmentmapping->documentationdate ?? '' }}" class=" form-control"
                placeholder="Enter Documentaion Date">
        </div>
    </div>
</div> -->
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Lead Partner *</label>
            <select class="language form-control" id="category" name="leadpartner"
                @if (Request::is('client/*/edit')) > <option disabled
            style="display:block">Please Select One</option>

            @foreach ($partner as $teammemberData)
            <option value="{{ $teammemberData->id }}"
            @if ($client->leadpartner == $teammemberData->id) selected @endif>
                {{ $teammemberData->team_member }}</option>
                @endforeach
            @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($partner as $teammemberData)
                    <option value="{{ $teammemberData->id }}">
                        {{ $teammemberData->team_member }} ( {{ $teammemberData->staffcode }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Other Partner </label>
            <select class="language form-control" name="otherpartner"
                @if (Request::is('client/*/edit')) > <option disabled
            style="display:block">Please Select One</option>

            @foreach ($partner as $teammemberData)
            <option value="{{ $teammemberData->id }}"
            @if ($client->leadpartner == $teammemberData->id) selected @endif>
                {{ $teammemberData->team_member }}</option>
                @endforeach
            @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($partner as $teammemberData)
                    <option value="{{ $teammemberData->id }}">
                        {{ $teammemberData->team_member }} ( {{ $teammemberData->staffcode }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="field_wrapper">
    <div class="row row-sm">
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Name *</label>
                <select class="language form-control" id="key" name="teammember_id[]">

                    <option value="0">Please Select One</option>
                    @foreach ($teammember as $teammemberData)
                        <option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
                            {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) (
                            {{ $teammemberData->staffcode }} )</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="font-weight-600">Type *</label>
                <select class="form-control key" id="key" name="type[]">

                    <option>Please Select One</option>
                    <option value="0">Team Leader</option>
                    <option value="2">Staff</option>
                </select>
            </div>
        </div>

        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_buttonn" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>


    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('assignmentmapping') }}">
        Back</a>

</div>

{{-- validation for date --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var startDateInput = $('#startDate');
        var endDateInput = $('#endDate');

        function compareDates() {
            var startDate = new Date(startDateInput.val());
            var endDate = new Date(endDateInput.val());

            if (startDate > endDate) {
                alert('End date should be greater than or equal to the Start date');
                endDateInput.val(''); // Clear the end date input
            }
        }

        startDateInput.on('input', compareDates);
        endDateInput.on('blur', compareDates);
    });
</script>

{{-- validation for year --}}
<script>
    $(document).ready(function() {
        $('#startDate').on('change', function() {
            var startclear = $('#startDate');
            var startDateInput1 = $('#startDate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearLength = startyear.toString().length;
            if (yearLength > 4) {
                alert('Enter four digits for the year');
                startclear.val('');
            }
        });
        $('#endDate').on('change', function() {
            var endclear = $('#endDate');
            var endDateInput1 = $('#endDate').val();
            var endtDate = new Date(endDateInput1);
            var endyear = endtDate.getFullYear();
            var endyearLength = endyear.toString().length;
            if (endyearLength > 4) {
                alert('Enter four digits for the year');
                endclear.val('');
            }
        });
    });
</script>
<script>
    const dateInput = document.querySelector('.dateInput'); // Select the element with the class 'dateInput'
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const formattedDate =
            `${selectedDate.getDate()}-${selectedDate.getMonth() + 1}-${selectedDate.getFullYear()}`;
        this.value = formattedDate;
    });
</script>
