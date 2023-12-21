<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Tender Offered By *</label>
            <input type="text" name="tenderofferedby" value="{{ $tender->tenderofferedby ?? ''}}" class="form-control"
                placeholder="Enter Tender Offered By">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Nature of Services *</label>
            <input type="text" name="services" value="{{ $tender->services ?? ''}}" class="form-control"
                placeholder="Enter Nature of Services">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Tender Published Date *</label>
            <input type="date" name="tenderpublishdate" value="{{ $tender->tenderpublishdate ?? ''}}"
                class="form-control" placeholder="Enter Due Date">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Prebid Date of Meeting*</label>
            <input type="date" name="prebidmeetingdate" value="{{ $tender->prebidmeetingdate ?? ''}}"
                class="form-control" placeholder="Enter End Date">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Organisation</label>
            <input type="text" name="organisation" value="{{ $tender->organisation ?? ''}}" class="form-control"
                placeholder="Enter Organisation">
        </div>
    </div>


    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Tender Type *</label>
            <select name="tendertype" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('client/*/edit')) >
                @if($tender->tendertype=='1')
                <option value="1">open</option>
                <option value="2">limited</option>

                @else
                <option value="2">limited</option>
                <option value="1">open</option>

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="2">limited</option>
                <option value="1">open</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Tender Nature *</label>
            <select name="nature" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('client/*/edit')) >
                @if($tender->nature=='1')
                <option value="1">Empanelment</option>
                <option value="2">Appointment</option>

                @else
                <option value="2">Appointment</option>
                <option value="1">Empanelment</option>

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="2">Appointment</option>
                <option value="1">Empanelment</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Organisation Website *</label>
            <input type="text" name="organisationwebsite" value="{{ $tender->organisationwebsite ?? ''}}"
                class="form-control" placeholder="Enter Organisation Website">
        </div>
    </div>
</div>
<div class="row row-sm">

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"> Tender Id</label>
            <input type="text" name="tenderid" value="{{ $tender->tenderid ?? ''}}" class=" form-control"
                placeholder="Enter Tender Id">
        </div>
    </div>



    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Tender Fees (in Rs.) </label>
            <input type="text" name="tenderfees" value="{{ $tender->tenderfees ?? ''}}" class="form-control"
                placeholder="Enter Tender Fees">
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"> Tender Submission Due Date.</label>
            <input type="date" name="tenderdate" value="{{ $tender->tenderdate ?? ''}}" class="form-control"
                placeholder="Enter Tender date">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Tender Document *</label>
            <input type="file" name="tenderdocument[]" multiple value="{{ $tender->tenderdocument ?? ''}}"
                class="form-control" placeholder="Enter Documents submited">
        </div>
    </div>
</div>
<div class="row row-sm">

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Tender Submission Required *</label>
            <select name="tenderhardcopy" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('client/*/edit')) >
                @if($tender->tenderhardcopy=='1')
                <option value="1">Hard Copy</option>
                <option value="2">Hard and Soft Copy</option>
                <option value="3">Soft Copy</option>

                @elseif($tender->tenderproposalsubmitted=='2')
                <option value="2">Hard and Soft</option>
                <option value="1">Hard Copy</option>
                <option value="3">Soft Copy</option>

                @else
                <option value="3">Soft Copy</option>
                <option value="2">Hard and Soft</option>
                <option value="1">Hard Copy</option>


                @endif
                @else

                <option value="">Please Select One</option>
                <option value="3">Soft Copy</option>
                <option value="2">Hard and Soft</option>
                <option value="1">Hard Copy</option>
                @endif
            </select>
        </div>
    </div>



    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">EMD (in Rs.) *</label>
            <input type="text" name="emd" value="{{ $tender->emd ?? ''}}" class="form-control"
                placeholder="Enter EMD (in Rs.)">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Tender Opening Date *</label>
            <input type="date" name="openingtenderdate" value="{{ $tender->openingtenderdate ?? ''}}"
                class="form-control" placeholder="Enter Nature">
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Period of Assignment *</label>
            <input type="text" name="daterange" value="{{ $tender->daterange ?? ''}}" class="form-control"
                placeholder="Enter Period of Assignment">
        </div>
    </div>

</div>


<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Details of Previous Auditors</label>
            <input type="text" name="previousauditors" value="{{ $tender->previousauditors ?? ''}}" class="form-control"
                placeholder="Enter Previous Auditors">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Details of Current Auditors, *</label>
            <input type="text" name="currentauditors" value="{{ $tender->currentauditors ?? ''}}" class="form-control"
                placeholder="Enter Current Auditors">
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Existing or Previous Relationships*</label>
            <input type="text" name="existing" value="{{ $tender->existing ?? ''}}" class="form-control"
                placeholder="Enter Existing or Previous Relationships">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Last Year Public domain fees *</label>
            <input type="text" name="lastyear" value="{{ $tender->lastyear ?? ''}}" class="form-control"
                placeholder="Enter Last Year Public domain fees ">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Board Members</label>
            <textarea rows="14" name="boardmembers" value="" class="centered form-control" id="editor"
                placeholder="Enter Board Members">{!! $tender->boardmembers ??'' !!}</textarea>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">CFO *</label>
            <textarea rows="14" name="cfo" value="" class="centered form-control" id="editor1"
                placeholder="Enter CFO">{!! $tender->cfo ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="row row-sm">


    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Linkedin link*</label>
            <input type="text" name="linkedinlink" value="{{ $tender->linkedinlink ?? ''}}" class="form-control"
                placeholder="Enter Linkedin link">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Stamp Paper Required *</label>

            <select name="stamppaperrequired" id="exampleFormControlSelect4" class="form-control">
                <!--placeholder-->
                @if(Request::is('client/*/edit')) >
                @if($tender->stamppaperrequired=='1')
                <option value="1">Yes</option>
                <option value="2">No</option>

                @else
                <option value="2">No</option>
                <option value="1">Yes</option>

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="2">No</option>
                <option value="1">Yes</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-3" id="designationnn" style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Amount*</label>
            <input type="text" name="amount" value="{{ $tender->amount ?? ''}}" class="form-control"
                placeholder="Enter Amount">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assign*</label>
            <select required class="language form-control" id="category" name="teammember_id"
                @if(Request::is('tender/view/*'))> <option value="">Please Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(($tender->teammember_id) ==
                    $teammemberData->id) selected
                    @endif>
                    {{ $teammemberData->title->title ??''}}. {{ $teammemberData->team_member }}
                </option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">{{ $teammemberData->team_member }}
                </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-500 mb-0"
                style=" text-decoration: underline;font-weight: 600!important;">Tender Contact Details </label>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Contact Person *</label>
            <input type="text" name="contactperson" value="{{ $tender->contactperson ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Email *</label>
            <input type="text" name="email" value="{{ $tender->email ?? ''}}" class="form-control"
                placeholder="Enter Services">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Phone No. *</label>
            <input type="text" name="phoneno" value="{{ $tender->phoneno ?? ''}}" class="form-control"
                placeholder="Enter Phone No.">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Address *</label>
            <input type="text" name="address" value="{{ $tender->address ?? ''}}" class="form-control"
                placeholder="Enter End Date">
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('tender') }}">
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
