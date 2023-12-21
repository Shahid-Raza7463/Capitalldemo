
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			 <li class="breadcrumb-item"><a href="{{ url('/informationlist/'.$clientid->parent_id) }}" >Back <i class="fa fa-reply"></i></a></li>
			  <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal12">Add Question</a></li> 
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Excel</a></li>
            <li class="breadcrumb-item active">+</li>
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
    
        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent   
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Question</th>
                          {{--  <th>Attachment</th>
                            <th>Uploadedby</th> --}}
                            <th>Date</th>
                            <th>Status</th>
                           {{--  <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($informationresourcesDatas as $informationData =>$informationresourcesData)
                        <tr>
                                                   <td><a data-toggle="modal"  id="editCompany" data-id="{{ $informationresourcesData->id }}" data-target="#exampleModal11">{{$informationData  + 1 }}</a></td>
                            <td><a href="{{url('/information/create/'.$informationresourcesData->id )}}" >{{$informationresourcesData->question }}</a></td>
                          {{--  <td><a target="blank"
                                href="{{ url('storage/app/backEnd/image/document/'. $informationresourcesData->document) }}">
                                {{$informationresourcesData->document??''}}</a></td> 
                               
                                <td>{{$informationresourcesData->team_member }}</td>--}}
                                   @if($informationresourcesData->updated_at != null) <td>{{ date('F d,Y', strtotime($informationresourcesData->updated_at)) }}</td>@else<td></td>@endif
                            <td>@if($informationresourcesData->status==0)
                                <span class="badge badge-pill badge-warning">pending</span>
                                @else
                                <span class="badge badge-pill badge-success">received</span>
                                @endif
                            </td>
							{{-- <td> <a d href="{{url('/ilr/delete/'.$informationresourcesData->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger-soft btn-sm"><i
                                class="far fa-trash-alt"></i></a></td> --}}
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
           <!-- Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('information/upload')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>
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
                                    <input hidden  value="{{ $clientid->client_id ??''}}" class="form-control" name="client_id" type="text">
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
        <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('ilr/question')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Records</h5>
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
                                    <input id="name" required class="form-control" name="question" type="text">
                                    <input hidden value="{{ $clientid->client_id ??''}}" class="form-control" name="client_id" type="text">
                                    <input hidden value="{{ $id ??''}}" class="form-control" name="ilrfolder_id" type="text">
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
        <div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('edit/question')}}"
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
                                    <input id="questions" required class="form-control" name="question" type="text">
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

                url: "{{ url('information/edit/question') }}",
                data: "id=" + id,

                success: function (response) {
                  
                    $("#questions").val(response.question);
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
                                   

