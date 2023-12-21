<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal112">Responsible Person</a></li>
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal11">Assign Person</a></li>
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Excel</a></li>
             <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal123">Import Excel Answer</a></li>
			<li class="breadcrumb-item"><a target="blank" href="{{ url('echarts/ifc/'.$id)}}">Dashboard</a></li>
        </ol>
    </nav>
    @endif
    <div class="col-sm-7 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Ifc List</small>
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
                            <th>Control Number</th>
                            <th>Sub Process</th>
                            <th style="padding-right: 300px;">Control Objective</th>
                            <th style="padding-right: 300px;">Identification of Risk of Material Misstatement</th>
                            <th style="padding-right: 100px;">Assign Person</th>
                            <th style="padding-right: 100px;">Responsible Person</th>
                            <th style="padding-right: 300px;">As Is Control</th>
                            <th>Fraud Risk</th>
                            <th>Risk Rating</th>
                            <th>Whether Key Control</th>
                            <th>Automated/Manual</th>
                            <th>Preventive/Detective</th>
                            <th>Control Frequency</th>
                            <th>Concerned person & Dept.</th>
                            <th>Process Design Gap</th>
                            <th>Design Gap</th>
                            <th>Methodology</th>
                            <th>Documents</th>
                            <th>Result</th>
                            <th>Remarks</th>
                            <th>Recommendations</th>
                            <th>Management Comments</th>
                            <th>Management Documents</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ifcDatas as $ifcData)
                        <tr>
                               <td>
                               <a href="{{ url('ifc/view', $ifcData->id)}}">
                                    {{ $ifcData->control_number ??''}}
                                   </a>
                            </td>
                            <td> {{ $ifcData->sub_process ??''}}</td>
                            <td> {{ $ifcData->control_objective ??''}}</td>
                            <td> {{ $ifcData->identification_risk ??''}}</td>
                            <td>{{ $ifcData->team_member ??'' }} </td>
                            <td>{{ $ifcData->responsibleperson ??'' }} </td>
                            <td> {{ $ifcData->as_is_control ??''}}</td>
                            <td>{{ $ifcData->fraud_risk ??''}} </td>
                            <td>
								{{ $ifcData->risk_rating ??''}}
                            </td>
                            <td>
							{{ $ifcData->whether_key ??''}}</td>
                            <td>
								{{ $ifcData->automated_manual ??''}}
							</td>
                            <td> 
							{{ $ifcData->preventive_detective ??''}}
							</td>
                            <td> {{ $ifcData->control_frequency ??''}}</td>
                            <td> {{ $ifcData->concerned_person ??''}}</td>
                            <td> {{ $ifcData->process_design_gap ??''}}</td>
                            <td> {{ $ifcData->design_gap ??''}}</td>
                            <td> {{ $ifcData->Methodology ??''}}</td>
                            <td> 
                                @if($ifcData->status!=0)
                                 <a  class="btn btn-success"  id="edit" data-toggle="modal" data-id="{{ $ifcData->id }}"
                                data-target="#exampleModal12" style="color: white">View</a>
                                @endif
                            </td>
                            <td>  {{ $ifcData->Result ??''}}
                            </td>
                            <td> {{ $ifcData->Remarks ??''}}</td>
                            <td> {{ $ifcData->Recommendations ??''}}</td>
                            <td>
                                 {{ $ifcData->Management_Comments ??''}}</td>
                              
                                 <td> 
                                    @if($ifcData->status==1)
                                     <a  class="btn btn-success"  id="editss" data-toggle="modal" data-id="{{ $ifcData->id }}"
                                    data-target="#exampleModal122" style="color: white">View</a>
                                @endif
                            </td>
                                    
                            <td>@if($ifcData->status==0)
                                <span class="badge badge-pill badge-success">OPEN</span>
                                @elseif($ifcData->status==2)
                                <span class="badge badge-pill badge-info">SUBMIT</span>
                                @elseif($ifcData->status==1)
                                <span class="badge badge-pill badge-danger">CLOSED</span>
                                @endif
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
@endsection
<!-- Modal -->
<div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('ifcassign/person')}}" enctype="multipart/form-data">
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
                                    value="IFC of  {{ $clientname->client_name  }} | Assigned – RCM" type="text">
                            </div>

                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Message</label>
                                <textarea rows="4" name="description" class="centered form-control" id="editor"
                                    placeholder="Enter Description">
                    <p>You have been assigned the RCM for the IFC of {{ $clientname->client_name }}
                       please click <a href="{{url('ifcfolderS')}}" > here </a> </p>
                    
                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Memeber</label>
                                <select class="language form-control" name="member">
                                    <option value="">Please Select One</option>
                                    @foreach($assignmember as $ccmemberDatas)
                                    <option value="{{$ccmemberDatas->id}}">
                                        {{ $ccmemberDatas->team_member }}</option>

                                    @endforeach
                                </select>
                                <input hidden class="form-control" value="{{ $id }}" name="ifcfolder_id" type="text">
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
<div class="modal fade" id="exampleModal123" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('ifc/uploadanswer')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Import Excel Answer</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="file" type="file">
                            <input hidden class="form-control" value="{{ $id }}" name="ifcfolder_id" type="text">
                            <input hidden class="form-control"
                                value="{{ App\Models\Ifcfolder::select('client_id')->where('id',$id)->first()->client_id ??''}}"
                                name="client_id" type="text">
                        </div>

                    </div>

                    <div class="details-form-field form-group row">
                        <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                        <div class="col-sm-9">
                            <a href="{{ url('backEnd/ifcuploadanswers.xlsx')}}" class="btn btn-success btn">Download<i
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
<div class="modal fade" id="exampleModal122" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Document List</h5>
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
                    <div class="table-responsive">

                        <table class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                  
                                    <th>Attachment</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="out_idd">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('ifc/upload')}}" enctype="multipart/form-data">
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
                            <input hidden class="form-control" value="{{ $id }}" name="ifcfolder_id" type="text">
                            <input hidden class="form-control"
                                value="{{ App\Models\Ifcfolder::select('client_id')->where('id',$id)->first()->client_id ??''}}"
                                name="client_id" type="text">
                        </div>

                    </div>

                    <div class="details-form-field form-group row">
                        <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                        <div class="col-sm-9">
                            <a href="{{ url('backEnd/ifc.xlsx')}}" class="btn btn-success btn">Download<i
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
<div class="modal fade" id="exampleModal121" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('ifcmanagementupdate')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Update Comments</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Management Comment:</label>
                        <div class="col-sm-9">
                            <textarea type="text"  name="Management_Comments" placeholder="Enter Comments"
                            class="form-control" rows="5" value="" /></textarea>
                            <input hidden class="form-control" id="ifcid" name="ifc_id" type="text">
                          
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
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Document List</h5>
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
                    <div class="table-responsive">

                        <table class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody id="out_id">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#edit', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('ifcdocument') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $('#out_id').html(response);
          


            
        },
                error: function () {

                },
            });
        });
    });

</script>
<script>
    $(function () {
        $('body').on('click', '#editss', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('ifcdocuments') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $('#out_idd').html(response);
          


            
        },
                error: function () {

                },
            });
        });
    });

</script>
<script>
    $(function () {
        $('body').on('click', '#edits', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('ifcmanagement') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $('#ifcid').val(response.id);
          


            
        },
                error: function () {

                },
            });
        });
    });

</script>
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

<div class="modal fade" id="exampleModal112" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('ifcresposible/person')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Resposible Person
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
                                value="Regarding IFC of  {{ $clientname->client_name  }} | Assigned – {{ $clientname->foldername  }}"  type="text">
                            </div>

                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Select CC Mail</label>
                                <select class="language form-control" id="exampleFormControlSelect11"
                                    multiple="multiple" name="ccmail[]">
                                    @foreach($assignmember as $ccmemberDatas)
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
                                <textarea rows="4" name="description" class="centered form-control"  id="editors"
                                    placeholder="Enter Description">
                    <p> Please look into the queries/observations raised in IFC. Please provide comments and necessary supporting documents to close the same. 
                         please click <a href="https://www.kgskonnect.com" > here </a> </p>
                    
                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Control Number : </label>
                                <select class="language form-control" id="exampleFormControlSelect1" multiple="multiple"
                                    name="fyquarter[]">
                                    @foreach($ifcDatas as $ifcData)
                                    <option value="{{$ifcData->id}}">
                                        {{ $ifcData->control_number }} {{ $ifcData->sub_process }} {{ $ifcData->control_objective }} (
                                        {{ $ifcData->identification_risk ??''}} )</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Responsible Memeber</label>
                                <select class="language form-control" name="member">
                                    <option value="">Please Select One</option>
                                    @foreach($responsibleperson as $memberData)
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
<script>
    ClassicEditor
        .create(document.querySelector('#editors'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });

</script>