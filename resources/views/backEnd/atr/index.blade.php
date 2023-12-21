<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal11">Assign Person</a></li>
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Excel</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>ATR List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                 <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>FY</th>
                            <th>Quarter</th>
                            <th>Area</th>
                            <th style="padding-right: 356px;">Observations</th>
							 <th>Risk</th>
                            <th>Management Comments</th>
                            <th>Responsible Person</th>
                            <th>Due Date for Closure</th>
                            <th>Attachments</th>
                            <th>Auditors Final Comments</th>
                            <th>Status</th>
                            <th>Further remarks</th>
                            <th>Reminder Mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atrData as $atrDatas)
                        <tr>

                            <td><a target="blank" href="{{url('view/atr/'.$atrDatas->id)}}">{{ $atrDatas->fy }}</a></td>
                            <td> {{ $atrDatas->quarter }}</td>
                            <td> {{ $atrDatas->area }}</td>
                            <td> {{ $atrDatas->observations }}</td>
							 <td> {{ $atrDatas->risk }}</td>
                            <td> {{ $atrDatas->management_comments }}</td>
                            <td>
                                @if($atrDatas->responsible_person == null)
                                <a style="width: 126px;color:white;" class="btn btn-success" id="editCompany"
                                    data-toggle="modal" data-id="{{ $atrDatas->id }}" data-target="#exampleModal12">
                                    choose member</a>
                                @else
                                {{ $atrDatas->clientlogin->name }}
                                @endif
                            </td>
                            <td>@if($atrDatas->duedate_for_closure != null)
                                {{ date('F d,Y', strtotime($atrDatas->duedate_for_closure)) }}
                                @endif
                            </td>
                            <td>
                                @foreach ($atrDatas->atrfile as $atrfileDatas)
                                <a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('atr/'.$atrfileDatas->attachments, now()->addMinutes(3)) }}">
                                    <span class="badge badge-pill badge-success">
                                        {{ $atrfileDatas->attachments }}</span> </a>
                                @endforeach

                            </td>
                            <td> {{ $atrDatas->auditors_final_comments }}</td>
                            <td>@if($atrDatas->status==0)
                                <span class="badge badge-pill badge-success">OPEN</span>
                                @elseif($atrDatas->status==2)
                                <span class="badge badge-pill badge-info">SUBMITTED</span>
                                @else
                                <span class="badge badge-pill badge-danger">CLOSED</span>
                                @endif
                            </td>
                            <td> {{ $atrDatas->further_remarks }}</td>
                            <td style="text-align: center;"><span>
                                    @if($atrDatas->responsible_person != null && $atrDatas->status==0) <a
                                        onclick="return confirm('Are you sure to send reminder mail  for this item?');"
                                        href="{{url('atr/reminder/'.$atrDatas->id)}}" style="font-size:20px;"><i
                                            class="far fa-envelope" style="color:#37A000"></i></a>
                                    @endif</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('atr/upload')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="file" type="file">
                            <input class="form-control" hidden value="{{ $id ??''}}" name="clientid" type="text">
                        </div>

                    </div>

                    <div class="details-form-field form-group row">
                        <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                        <div class="col-sm-9">
                            <a href="{{ url('backEnd/atr.xlsx')}}" class="btn btn-success btn">Download<i
                                    class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>

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


<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/atr/assign')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Assign Person</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row row-sm">
                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                        <div class="col-sm-12">
                            <select class="form-control" name="responsible_person">

                                <option>Please Select One</option>
                                @foreach($member as $memberData)
                                <option value="{{$memberData->id}}">
                                    {{ $memberData->name }}</option>
                                @endforeach
                            </select>
                            <input hidden class="form-control" id="id" name="atrid" type="text">

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            //        debugger;
            var id = $(this).data('id');
            debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('atrassigned') }}",
                data: "id=" + id,
                success: function (response) {
                    debugger;
                    $("#id").val(response.id);
                    debugger;

                },
                error: function () {

                },
            });
        });
    });

</script>

@endsection
<div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('assign/person')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Assign Person
                    </h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Subject</label>
                                <input class="form-control" name="subject"
                                    value="Regarding ATR of  {{ App\Models\Client::select('client_name')->where('id',$id)->first()->client_name ?? ''  }}"
                                    type="text">
                            </div>

                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Select CC Mail</label>
                                <select class="language form-control" id="exampleFormControlSelect11"
                                    multiple="multiple" name="ccmail[]">
                                    @foreach($ccmember as $ccmemberDatas)
                                    <option value="{{$ccmemberDatas->id}}">
                                        {{ $ccmemberDatas->team_member }}</option>

                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Message</label>
                                <textarea rows="4" name="description" class="centered form-control"  id="editor"
                                    placeholder="Enter Description">
                    <p> Please look into the ATR points from previous reports. Please provide comments and necessary supporting documents to close the same.<br>
                       please click <a href="https://www.kgskonnect.com" > here </a> </p>
                    
                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">FY : </label>
                                <select class="language form-control" id="exampleFormControlSelect1" multiple="multiple"
                                    name="fyquarter[]">
                                    @foreach($atrData->where('responsible_person',null) as $atrDatas)
                                    <option value="{{$atrDatas->id}}">
                                        {{ $atrDatas->fy }} {{ $atrDatas->quarter }} {{ $atrDatas->area }} (
                                        {{ $atrDatas->observations ??''}} )</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Memeber</label>
                                <select class="language form-control" name="member">
                                    <option value="">Please Select One</option>
                                    @foreach($member as $memberData)
                                    <option value="{{$memberData->id}}">
                                        {{ $memberData->name }}</option>
                                    @endforeach
                                </select>

                            </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script><script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>
<script>
	ClassicEditor
		.create( document.querySelector( '#editor1' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>