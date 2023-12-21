<div class="row row-sm">
    <div class="col-5" id="Div1">
        <div class="form-group">
            <label class="font-weight-600">Client *</label>
            <select class="form-control" id="exampleFormControlSelect1" name="client_id"
                @if(Request::is('lead/*/edit'))>  <option value="">Please Select One</option>
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$lead->client_id== $clientData->id??'' ?'selected="selected"' : ''}}>
                    {{$clientData->client_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-5" id="Div2" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Client Name </label>
            <input type="text" name="client_names" value="{{ $lead->client_names ?? ''}}" class="form-control"
                placeholder="Enter Client Name">
        </div>
    </div>
    <div class="col-1">
        <div class="form-group" style="margin-top: 36px;">
            <a id="Button1" class="add_button" title="Add field" onclick="switchVisible();"><img
                    src="{{ url('backEnd/image/add-icon.png')}}" /></a>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Contact Person </label>
            <input type="text" name="contactperson" value="{{ $lead->contactperson ?? ''}}" class="form-control" placeholder="Enter Name">
        </div>
    </div>
    
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Contact Email *</label>
            <input type="text" required name="contactemail" value="{{ $lead->contactemail ?? ''}}" class="form-control"
                placeholder="Enter Email">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Contact Phone No *</label>
            <input type="text" required name="contactphone" value="{{ $lead->contactphone ?? ''}}" class="form-control"
                placeholder="Enter Phone No">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Designation</label>
            <input type="text" name="designation" value="{{ $lead->phone ?? ''}}" class="form-control"
                placeholder="Enter Designation">
        </div>
    </div>
   
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Select Observer </label>
            <select class="language form-control"  name="teammember_id" @if(Request::is('lead/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(($lead->teammember_id) == $teammemberData->id) selected
                    @endif> {{ $teammemberData->team_member }}
                </option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
	<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Commercials</label>
            <input type="number" name="commercials" value="{{ $lead->commercials ?? ''}}" class="form-control"
                placeholder="Enter Commercials">
        </div>
    </div>
	<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Last Meeting Date</label>
            <input type="date" name="lastmeetingdate" value="{{ $lead->lastmeetingdate ?? ''}}" class="form-control"
                placeholder="Enter Last Meeting Date">
        </div>
    </div>
<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Concern Partner </label>
            <select class="language form-control"  name="concernpartner" @if(Request::is('lead/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                @foreach($concernpartner as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(($lead->concernpartner) == $teammemberData->id) selected
                    @endif> {{ $teammemberData->team_member }}
                </option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($concernpartner as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Address</label>
                <textarea rows="3" name="address" value="" class="form-control" 
                placeholder="Enter Address">{!! $lead->address ??'' !!}</textarea>
        </div>
    </div>
       <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Service Type </label>
            <input type="text" name="servicetype" value="{{ $lead->servicetype ?? ''}}" class="form-control"
                placeholder="Enter Eg : GST Audit , ITR etc">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Documents </label>
            <input type="file" name="file[]" multiple class="form-control">
        </div>
    </div>
</div>
<div class="row row-sm">

 
   
    @if(Request::is('lead/*/edit'))
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Status*</label>
            <select name="status" id="lead" class="form-control">
                <!--placeholder-->
                @if(Request::is('lead/*/edit')) >
                @if($lead->status=='0')
                <option value="0">fresh</option>
                <option value="1">proposal sent</option>
                <option value="2">decline</option>
                <option value="3">followup</option>

                @elseif($lead->status=='1')
                <option value="1">proposal sent</option>
                <option value="2">decline</option>
                <option value="0">fresh</option>
                <option value="3">followup</option>

                @elseif($lead->status=='2')
                <option value="2">decline</option>
                <option value="1">proposal sent</option>
                <option value="0">fresh</option>
                <option value="3">followup</option>


                @else
                <option value="3">followup</option>
                <option value="2">decline</option>
                <option value="1">proposal sent</option>
                <option value="0">fresh</option>
              
                @endif
                @else
                <option value="1">proposal sent</option>
                <option value="2">decline</option>
                <option value="0">fresh</option>
                <option value="3">followup</option>
                @endif
            </select>
        </div>
    </div>
    @endif
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description </label>
            <textarea rows="14" name="description" value="" class="centered form-control" id="editor"
                placeholder="Enter Description">{!! $lead->description ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('lead') }}">
        Back</a>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

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
    function switchVisible() {
        if (document.getElementById('Div1')) {

            if (document.getElementById('Div1').style.display == 'none') {
                document.getElementById('Div1').style.display = 'block';
                document.getElementById('Div2').style.display = 'none';
            } else {
                document.getElementById('Div1').style.display = 'none';
                document.getElementById('Div2').style.display = 'block';
            }
        }
    }

</script>
