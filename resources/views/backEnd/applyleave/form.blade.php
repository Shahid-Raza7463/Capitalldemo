<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Leave</label>
            <select required class="language form-control" id="leave" name="leavetype"
                @if (Request::is('applyleave/*/edit')) > <option disabled style="display:block">Please Select One</option>

                @foreach ($leavetype as $leavetypeData)
                <option value="{{ $leavetypeData->id }}"
                    {{ $applyleave->leavetype == $leavetypeData->id ?? '' ? 'selected="selected"' : '' }}>
                    {{ $leavetypeData->name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($leavetype as $leavetypeData)
                <option value="{{ $leavetypeData->id }}">
                    {{ $leavetypeData->name }}</option>

                @endforeach @endif
                </select>
        </div>
    </div>
    <div class="col-4" id="type" style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Select Type</label>
            <select name="type" id="leavetype" class="form-control">
                <!--placeholder-->
                @if (Request::is('applyleave/*/edit')) >
                    @if ($applyleave->type == 'Birthday')
                        <option value="0">Birthday</option>
                        <option value="1">Religious Festival</option>
                    @else
                        <option value="1">Religious Festival</option>
                        <option value="0">Birthday</option>


                    @endif
                @else
                    <option value="">Please Select One</option>
                    <option value="0">Birthday</option>
                    <option value="1">Religious Festival</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-4" id="examtype" style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Select Exam</label>
            <select name="examtype" id="selectexam" class="form-control">
                <!--placeholder-->
                @if (Request::is('applyleave/*/edit')) >
                    @if ($applyleave->type == 'Birthday')
                        <option value="0">Birthday</option>
                        <option value="1">Religious Festival</option>
                    @else
                        <option value="1">Religious Festival</option>
                        <option value="0">Birthday</option>


                    @endif
                @else
                    <option value="">Please Select One</option>
                    <option value="0">PCC</option>
                    <option value="1">CA Final</option>
                    <option value="2">B.Com</option>
                    <option value="3">Other</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-4" id="otherexamtype" style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Other Exam</label>
            <input type="text" name="otherexam" value="{{ $applyleave->from ?? '' }}" class="form-control"
                placeholder="">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">From *</label>
            <input type="date" id="startDate" name="from" value="{{ $applyleave->from ?? '' }}" required
                class="form-control" placeholder="" maxlength="10">
            {{-- <input type="date" id="startDate" name="from" value="{{ $applyleave->from ?? '' }}" required
                class="form-control" placeholder="" maxlength="10"> --}}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">To *</label>
            <input type="date" id="endDate" name="to" value="{{ $applyleave->to ?? '' }}" required
                class="form-control" placeholder="" maxlength="10">
        </div>
    </div>
    {{-- <script>
        const dateInput = document.getElementByClassName('dateInput');
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const formattedDate =
                `${selectedDate.getDate()}-${selectedDate.getMonth() + 1}-${selectedDate.getFullYear()}`;
            this.value = formattedDate;
        });
    </script>  --}}
    <div class="col-4" id="report" style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Medical Certificate/Doctor's Prescription *</label>
            <input type="file" name="report" value="{{ $applyleave->to ?? '' }}" class="form-control"
                placeholder="">
        </div>
    </div>
    <br>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Team Email ID (If Any)</label>
            <select class="form-control basic-multiple" multiple="multiple" id="category" name="teammember_id[]"
                @if (Request::is('applyleave/*/edit')) > @foreach ($teammember as $teammemberData) <option
                value="{{ $teammemberData->id }}" @if ($task->teammember_id == $teammemberData->id) selected @endif>
                {{ $teammemberData->title->title }}. {{ $teammemberData->team_member }}(
                {{ $teammemberData->role->rolename }} )</option>
                @endforeach
            @else
                <option></option>

                @foreach ($teammember as $teammemberData)
                    <option value="{{ $teammemberData->id }}">
                        {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ,
                        {{ $teammemberData->emailid }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Reason for leave *</label>
            <input type="text" required name="reasonleave" value="{{ $applyleave->reasonleave ?? '' }}"
                class="form-control" placeholder="Enter Reason for leave">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Choose Approver *</label>
            <select required class="language form-control" id="exampleFormControlSelect1" name="approver"
                @if (Request::is('applyleave/*/edit')) > <option disabled style="display:block">Please Select One</option>

                @foreach ($approver as $teammemberData)
                <option value="{{ $teammemberData->id }}"
                    {{ $applyleave->Approver == $teammemberData->id ?? '' ? 'selected="selected"' : '' }}>
                    {{ $teammemberData->team_member }}( {{ $teammemberData->role->rolename }} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($approver as $teammemberData)
                <option value="{{ $teammemberData->id }}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} , {{ $teammemberData->emailid }}  )</option>

                @endforeach @endif
                </select>
        </div>
    </div>
    @if (Request::is('applyleave/*/edit'))
        @if (23 == Auth::user()->teammember_id)
            <div class="col-4">
                <div class="form-group">
                    <label class="font-weight-600">status</label>
                    <select name="status" id="exampleFormControlSelect1" class="form-control">
                        <!--placeholder-->
                        @if (Request::is('applyleave/*/edit')) >
                            @if ($applyleaveDatas->status == '0')
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                                <option value="2">Rejected</option>
                            @elseif($applyleaveDatas->status == '1')
                                <option value="1">Approved</option>
                                <option value="0">Pending</option>
                                <option value="2">Rejected</option>
                            @elseif($applyleaveDatas->status == '2')
                                <option value="2">Rejected</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                            @endif
                        @else
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="2">Rejected</option>
                        @endif
                    </select>
                </div>
            </div>
        @endif
    @endif

</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('applyleave') }}">
        Back</a>

</div>
<script>
    $(document).ready(function() {
        $('.dropdown').select2();
    });
</script>
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
                endDateInput.val('');
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
            console.log(startyear);
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
{{-- <script>
    const dateInput = document.getElementByClassName('dateInput');
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const formattedDate =
            `${selectedDate.getDate()}-${selectedDate.getMonth() + 1}-${selectedDate.getFullYear()}`;
        this.value = formattedDate;
    });
</script> --}}
<script>
    const dateInput = document.querySelector('.dateInput'); // Select the element with the class 'dateInput'
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const formattedDate =
            `${selectedDate.getDate()}-${selectedDate.getMonth() + 1}-${selectedDate.getFullYear()}`;
        this.value = formattedDate;
    });
</script>
