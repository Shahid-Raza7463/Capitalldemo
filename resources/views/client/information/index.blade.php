
@extends('client.layouts.layout') @section('client_content')
<style>
    a{
        cursor: pointer;
    }
</style>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url()->previous() }}" >Back <i class="fa fa-reply"></i></a></li>
            @if(Auth::user()->id == 16 || Auth::user()->id == 44 || Auth::user()->id == 36)
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Excel</a></li>
        @endif
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>ILR List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
     <div class="card-header" style="background:{{ $ilrfolder->color ??''}}">
          
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                   
                        <span style="color:white;">{{ $ilrfolder->name ??''}}</span>
                     
                    </h6>
                </div>

            </div>
        </div>
        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent   
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Question</th>
                           {{-- <th>Attachment</th>
                             <th>Uploadedby</th> --}}
                             <th>Modify Date</th>
                            <th>Status</th>
                            @if(Auth::user()->id == 16 || Auth::user()->id == 44 || Auth::user()->id == 36)
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($informationresourcesDatas as $information => $informationresourcesData)
                        <tr>
                            <td><a     @if(Auth::user()->id == 16 || Auth::user()->id == 44 || Auth::user()->id == 36) data-toggle="modal"  id="editCompany" data-id="{{ $informationresourcesData->id }}" data-target="#exampleModal11" @endif>{{$information  + 1 }}</a></td>
                        {{--    <td><a href="{{url('/client/information/create/'.$informationresourcesData->id )}}" >{{$informationresourcesData->question }}</a></td> --}}
							   <td>    <a data-toggle="modal" style="color: green" id="editCompany" data-id="{{ $informationresourcesData->id }}" data-target=".bd-example-modal-lg">{{$informationresourcesData->question ??''}}</a></td>
                          {{--  <td><a target="blank"
                                href="{{ url('storage/app/backEnd/image/document/'. $informationresourcesData->document) }}">
                                {{$informationresourcesData->document??''}}</a></td> 
                                   <td>{{$informationresourcesData->team_member ??''}}</td>--}}
                                    @if($informationresourcesData->updated_at != null) <td>
							{{ date('F d,Y', strtotime($informationresourcesData->updated_at)) }}</td>@else<td></td>@endif
                            <td> @if(Auth::user()->id == 16 || Auth::user()->id == 36)
								<a  data-toggle="modal" style="color: green" id="editStatus" data-id="{{ $informationresourcesData->id }}" data-target="#exampleModal2">
                                @if($informationresourcesData->status==0)
                                <span class="badge badge-pill badge-warning">pending</span>
                                @elseif($informationresourcesData->status==2)
                                <span class="badge badge-pill badge-info">partially received</span>
									  @elseif($informationresourcesData->status==3)
                                <span class="badge badge-pill badge-primary">partially uploaded</span>
									  @elseif($informationresourcesData->status==4)
                                <span class="badge badge-pill badge-secondary">uploaded</span>
									 @elseif($informationresourcesData->status==5)
                                <span class="badge badge-pill badge-danger">Not Applicable</span>
                                @else
                                <span class="badge badge-pill badge-success">received</span>
                                @endif </a>
								@else
								@if($informationresourcesData->status==0)
                                <span class="badge badge-pill badge-warning">pending</span>
                                @else
                                <span class="badge badge-pill badge-success">received</span>
                                @endif
								 @endif
                            </td>
                            @if(Auth::user()->id == 16 || Auth::user()->id == 44 || Auth::user()->id == 36)
                            <td> <a href="{{url('/client/informationq/destroy/'.$informationresourcesData->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger-soft btn-sm"><i
                                class="far fa-trash-alt"></i></a></td>
                                @endif
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Information Answer</h5>
           
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="post" action="{{ url('client/information/store')}}" enctype="multipart/form-data">
                        @csrf
          
                        @include('client.information.form')
                    </form>
                   
                    <hr class="my-4">
                   <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                             <th>Attachment</th>
                             <th>Remark</th>
							  <th>Uploaded by</th>
                             <th>Date</th>
                             @if(Auth::user()->id == 16 || Auth::user()->id == 44 || Auth::user()->id == 36)
                             <th>Action</th>
                             @endif
                                               
                            
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
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            var id = $(this).data('id');
    // debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('client/information/first') }}",
                data: "id=" + id,

                success: function (response) {
                    document.getElementById('ilrid').value = id;
                    $("#questions").val(response.question);
//                     debugger;
//                     var	rows = '';
//                     $.each( response.ilranswers, function( key, value ) {
//                         rows = rows + '<tr>';
//                         	rows = rows + '<td>'+value.url+'</td>';
//                         	rows = rows + '<td>'+value.url+'</td>';
//                         	rows = rows + '<td>'+value.url+'</td>';
//                         	rows = rows + '<td>'+value.url+'</td>';
//                         	rows = rows + '</tr>';
//   });
//   $("ilrans").html(rows);
//   debugger;
                  
                },
                error: function () {

                },
            });
        });

    });

</script>
<script>
    $(function () {
        $('body').on('click', '#editStatus', function (event) {
            var id = $(this).data('id');
    // debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('client/information/status') }}",
                data: "id=" + id,

                success: function (response) {
                    document.getElementById('infoid').value = id;
                    debugger;
                    $("#questions").val(response.question);
                },
                error: function () {

                },
            });
        });

    });

</script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('client/information/firstt') }}",
                data: "id=" + id,
                success : function(res){
           // alert(res);
            $('#out_id').html(res);

            
        },
                error: function () {

                },
            });
        });
    });

</script>   
 <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('client/information/updatestatus')}}" enctype="multipart/form-data">
                @csrf
            @csrf
            <div class="modal-header" style="background: #37A000">
                <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Update Status</h5>
                <div >
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
               
                    <div class="details-form-field form-group row">
                             <label for="name" class="col-sm-3 col-form-label font-weight-600">Status:</label>
                        <div class="col-sm-9">
                            <select name="status" id="exampleFormControlSelect1" class="form-control">
                              
                                <option value="">Please Select One</option>
                                <option value="0">Pending</option>
                                <option value="1">Received</option>
                                <option value="2">Partially Received</option>
								  <option value="3">Partially Uploaded</option>
								  <option value="4">Uploaded</option>
								  <option value="5">Not Applicable</option>
                            </select>
                            <input hidden id="infoid" class="form-control" name="id" type="text">
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
         <!-- Modal -->
         <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('client/information/upload')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>
                        <div >
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
                       
                            <div class="details-form-field form-group row">
                                     <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                                <div class="col-sm-9">
                                    <input id="name" class="form-control" name="file" type="file">
                                    <input hidden value="{{ $id ??''}}" class="form-control" name="ilrfolder_id" type="text">
                                </div>
                                   
                            </div> 
                        
                            <div class="details-form-field form-group row">
                            <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                            <div class="col-sm-9">
                                <a href="{{ url('backEnd/kgsilr.xlsx')}}" 
                                class="btn btn-success btn"  >Download<i class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>
                           
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
        

 <!-- Modal -->
 <div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('client/edit/question')}}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header" style="background: #37A000">
                <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Edit Records</h5>
                <div >
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
               
                    <div class="details-form-field form-group row">
                             <label for="name" class="col-sm-3 col-form-label font-weight-600">Records:</label>
                        <div class="col-sm-9">
                            <input id="questionss" required class="form-control" name="question" type="text">
                            <input hidden id="id" class="form-control" name="id" type="text">
                           
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('client/information/edit/question') }}",
                data: "id=" + id,

                success: function (response) {
                  
                    $("#questionss").val(response.question);
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
                                   

