<div class="row row-sm">

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Joining</label>
            <input type="date" name="date_of_joining" required class="form-control"
                value="{{ $assignmentevaluationData->date_of_joining ??''}}" />

        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Client’s Name</label>
            <select required class="language form-control" id="client" name="clients_name"
                @if(Request::is('assignmentevaluation/*/edit'))> <option disabled style="display:block">Select
                Client Name
                </option>

                @foreach($clientData as $clientDatas)
                <option value="{{$clientDatas->id}}"
                    {{$clientDatas->id== $assignmentevaluationData->clients_name??'' ?'selected="selected"' : ''}}>
                    {{$clientDatas->client_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Select client Name</option>
                @foreach($clientData as $clientDatas)
                <option value="{{$clientDatas->id}}">
                    {{ $clientDatas->client_name }}</option>

                @endforeach
                @endif
            </select>

        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Nature Of Assignment</label>

            <select required class="language form-control" name="nature_of_assignment" id="assignment">
                @if(!empty($assignmentevaluationData->nature_of_assignment))
                <option value="{{ $assignmentevaluationData->nature_of_assignment }}">
                {{ App\Models\Assignment::select('assignment_name')->where('id',$assignmentevaluationData->nature_of_assignment)->first()->assignment_name ?? ''}}   
              
                </option>

                @endif </select>
                
        </div>
    </div>
</div>
<div class="row row-sm">

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Choose Assignment Partner/Head</label>

            <select required class="language form-control" id="partner" name="assignment_partner">
                @if(!empty($assignmentevaluationData->assignment_partner))
                <option value="{{ $assignmentevaluationData->assignment_partner }}">
                    {{ App\Models\Teammember::select('team_member')->where('id',$assignmentevaluationData->assignment_partner)->first()->team_member??'' }}
                </option>

                @endif </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Start Date Of Assignment</label>
            <input type="date" required name="start_date_of_assignment" class="form-control"
                value="{{ $assignmentevaluationData->start_date_of_assignment ??''}}" />

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">End Date Of Assignment</label>
            <input type="date" required name="end_date_of_assignment" class="form-control"
                value="{{ $assignmentevaluationData->end_date_of_assignment ??''}}" />

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Total Assignment Hours (You Spent)</label>
            <input type="number" class="form-control" required name="total_assignment_hours" 
            value="{{ $assignmentevaluationData->total_assignment_hours ??''}}">

        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Is the entire Assignment data/record/file recorded and submitted on portal
                (KGS Capitall)</label>
            
            <select class="form-control key" required name="assignment_date_record" id="key">
                <!--placeholder-->
                @if(Request::is('assignmentevaluation/*/edit')) >
             @if($assignmentevaluationData->assignment_date_record=='Yes')
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                @else
                <option value="No">No</option>
                <option value="Yes">Yes</option>
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
               
                @endif
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Level Of Complexity </label>
           
            <select class="form-control key" required name="level_of_complexity" id="key">
                @if(Request::is('assignmentevaluation/*/edit')) >
             @if($assignmentevaluationData->level_of_complexity=='Medium')
            
                <option value="Medium">Medium</option>
                <option value="Difficult">Difficult</option>
                <option value="Easy">Easy</option>
                @elseif($assignmentevaluationData->assignment_date_record=='Difficult')
                <option value="Difficult">Difficult</option>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                @else
                <option value="Medium">Medium</option>
                <option value="Difficult">Difficult</option>
                <option value="Easy">Easy</option>
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="Medium">Medium</option>
                <option value="Difficult">Difficult</option>
                <option value="Easy">Easy</option>
               
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Any difficulties/challenges faced During Assignment?</label>
            <input type="text" required name="difficulties_assignment" class="form-control" value="{{ $assignmentevaluationData->difficulties_assignment ?? ''}}" />
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Any issues with any team member/team leader?</label>
            <input type="text" required name="issues_team" class="form-control" value="{{ $assignmentevaluationData->issues_team ?? ''}}" />
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Rate yourself overall performance on this assignment </label>
           
            <select class="form-control key" required name="rate_over_all_performance" id="key">
                @if(Request::is('assignmentevaluation/*/edit')) >
             @if($assignmentevaluationData->rate_over_all_performance=='1')
             <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                @elseif($assignmentevaluationData->rate_over_all_performance=='2')
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="1">1</option>
               
                @elseif($assignmentevaluationData->rate_over_all_performance=='3')
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                @elseif($assignmentevaluationData->rate_over_all_performance=='4')
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                @elseif($assignmentevaluationData->rate_over_all_performance=='5')
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                @elseif($assignmentevaluationData->rate_over_all_performance=='6')
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                @elseif($assignmentevaluationData->rate_over_all_performance=='7')
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                @elseif($assignmentevaluationData->rate_over_all_performance=='8')
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                @elseif($assignmentevaluationData->rate_over_all_performance=='9')
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                @else
                
                <option value="10">10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Have you submitted the Conveyance Request?</label>
          
            <select class="form-control key" required name="conveyance_request" id="key">
                @if(Request::is('assignmentevaluation/*/edit')) >
             @if($assignmentevaluationData->conveyance_request=='Yes')
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                <option value="Not Applicable">Not Applicable</option>
                @elseif($assignmentevaluationData->conveyance_request=='No')
                <option value="No">No</option>
                <option value="Yes">Yes</option>
                <option value="Not Applicable">Not Applicable</option>
                @else
                <option value="Not Applicable">Not Applicable</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                <option value="Not Applicable">Not Applicable</option>
               
                @endif
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Is file prepared as per the Documentation Policies & Standards?</label>
           
            <select class="form-control key" required name="document_policies" id="key">
                @if(Request::is('assignmentevaluation/*/edit')) >
             @if($assignmentevaluationData->document_policies=='Yes')
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                @else
                <option value="No">No</option>
                <option value="Yes">Yes</option>
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                
                @endif
            </select>
        </div>
    </div>

</div>

<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Is file handed over to Record keeper?</label>
           
            <select class="form-control key" required name="record_keeper" id="key">
                @if(Request::is('assignmentevaluation/*/edit')) >
             @if($assignmentevaluationData->record_keeper=='Yes')
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                @else
                <option value="No">No</option>
                <option value="Yes">Yes</option>
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Choose Record Keeper</label>
            <select required class="form-control basic-multiple" name="staff_record_keeper"
               
                @if(Request::is('assignmentevaluation/*/edit'))> <option disabled style="display:block">Select
                Client Name
                </option>

                @foreach($staffData as $staffDatas)
                <option value="{{$staffDatas->id}}"
                    {{$staffDatas->id== $assignmentevaluationData->staff_record_keeper??'' ?'selected="selected"' : ''}}>
                    {{$staffDatas->team_member }}</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($staffData as $staffDatas)
                <option value="{{$staffDatas->id}}">
                    {{ $staffDatas->team_member }} ( {{ $staffDatas->role->rolename}} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-5">
        <div class="form-group">
            <label class="font-weight-600">Name of the Team Leader who signed the file after Review</label>
            <select required class="form-control basic-multiple" name="team_leader_signed"
                @if(Request::is('assignmentevaluation/*/edit'))> <option disabled style="display:block">Select
                Client Name
                </option>

                @foreach($staffData as $staffDatas)
                <option value="{{$staffDatas->id}}"
                    {{$staffDatas->id== $assignmentevaluationData->team_leader_signed??'' ?'selected="selected"' : ''}}>
                    {{$staffDatas->team_member }} ( {{ $staffDatas->role->rolename}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($staffData as $staffDatas)
                <option value="{{$staffDatas->id}}">
                    {{ $staffDatas->team_member }} ( {{ $staffDatas->role->rolename}} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Choose the concerned Assignment Reporting Person</label>
            <select required class="form-control basic-multiple" name="assignment_report_manager"
            @if(Request::is('assignmentevaluation/*/edit'))> <option disabled style="display:block">Select
                Client Name
                </option>

                @foreach($staffData as $staffDatas)
                <option value="{{$staffDatas->id}}"
                    {{$staffDatas->id== $assignmentevaluationData->team_leader_signed??'' ?'selected="selected"' : ''}}>
                    {{$staffDatas->team_member }} ( {{ $staffDatas->role->rolename}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammemberpartner as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('assignmentevaluation') }}">
        back</a>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(function () {
        $('#client').on('change', function () {
            var cid = $(this).val();
            // alert(category_id);
            $.ajax({
                type: "get",
                url: "{{ url('assignmentevaluation/create') }}",
                data: "cid=" + cid,
                success: function (res) {
                    $('#assignment').html(res);
                },
                error: function () {},
            });
        });
        $('#assignment').on('change', function () {
            var assignment = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('assignmentevaluation/create') }}",
                data: "assignment=" + assignment,
                success: function (res) {

                    $('#partner').html(res);


                },
                error: function () {

                },
            });
        });
    });

</script>
