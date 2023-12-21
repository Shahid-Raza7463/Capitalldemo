<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			<li class="breadcrumb-item"><a href="{{url('/viewclient/'.$id)}}" >Back <i class="fa fa-reply"></i></a></li>
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal12">Add Folder</a></li>
			
          <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal11">Add Folder Assign</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>IRL Folder  List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
 <div class="card mb-4">

        <div class="card-body">
          <div>
                @if(session()->has('success'))
                <div class="alert alert-success">
                    @if(is_array(session()->get('success')))
                    @foreach (session()->get('success') as $message)
                    <p>{{ $message }}</p>
                    @endforeach
                    @else
                    <p>{{ session()->get('success') }}</p>
                    @endif
                </div>
                @endif
                @if(session()->has('statuss'))
                <div class="alert alert-danger">
                  @if(is_array(session()->get('statuss')))
                  @foreach (session()->get('statuss') as $message)
                      <p>{{ $message }}</p>
                  @endforeach
                  @else
                      <p>{{ session()->get('success') }}</p>
                  @endif
                </div>
            @endif
                <div>
                    <ul>
                        @foreach ($errors->all() as $e)
                        <li style="color:red;">{{$e}}</li>
                        @endforeach
                    </ul>
                </div></div> 
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>

                            <th>Name</th>
 <th>Assigned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrfolder as $ilrfolderData)
                        <tr>

                           
                          <td><a style="font-size: 16px;"
                                    href="{{ url('informationlist', $ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>{{$ilrfolderData->name }}</b></i></a></td>
     @php
                             $assign = DB::table('ilrfolderassigns')
                             ->leftjoin('clientlogins','clientlogins.id','ilrfolderassigns.clientlogin_id')->select('clientlogins.name')
                             ->where('ilrfolder_id',$ilrfolderData->id)->get();
                                        @endphp
                            <td> @foreach($assign as $assigns) <span class="badge badge-pill badge-success">{{ $assigns->name ??''}}</span> @endforeach</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   {{-- <div class="row">
        @foreach($ilrfolder as $ilrfolderData)
        <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <a  href="{{ url('informationlist', $ilrfolderData->id)}}">
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
                <div class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
                <div class="fs-32 text-monospace">{{ count($ilrfolderData->ilr) }}</div>
                <small>Question</small>
            </div>
            </a>
        </div>
        @endforeach
    </div> --}}
</div>
<!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/informationfolder/store')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #218838;">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Name</h5>
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

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="name" type="text">
                            <input id="name" hidden class="form-control" name="client_id" value="{{ $id }}" type="text">
                        </div>

                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Sub Folder of :</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="category" name="parent_id">
                                <option value="">No Subfolder</option>
                                @foreach($ilrsubfolder as $ilrfolderData)
                                <option value="{{$ilrfolderData->id}}">
                                    @if($ilrfolderData->parent_id == null)( Subfolder of)@endif    {{ $ilrfolderData->name }}</option>

                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Color :</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="color" type="color">

                        </div>

                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Assign(optional) :</label>
                        <div class="col-sm-9">
                            <select class="form-control basic-multiple" multiple="multiple" id="category"
                                name="assign[]" @if(Request::is('task/*/edit'))> <option disabled
                                style="display:block">Please Select One</option>

                                @foreach($teammember as $teammemberData)
                                <option value="{{$teammemberData->id}}" @if(($task->teammember_id) ==
                                    $teammemberData->id) selected
                                    @endif>
                                    {{ $teammemberData->title->title }}. {{ $teammemberData->team_member }}(
                                    {{ $teammemberData->role->rolename}} )</option>
                                @endforeach


                                @else
                                <option></option>
                                <option value="">Please Select One</option>
                                @foreach($irlassign as $teammemberData)
                                <option value="{{$teammemberData->id}}">
                                    {{ $teammemberData->name }}</option>

                                @endforeach
                                @endif
                            </select>
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
@endsection
  <!-- Modal -->
<div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('assign/folder')}}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header" style="background: #37A000">
                <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Assign Folder</h5>
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
                             <label for="name" class="col-sm-3 col-form-label font-weight-600">Assign:</label>
                        <div class="col-sm-9">
                            <select class="language form-control" id="exampleFormControlSelect1"  multiple="multiple"
                            name="assign[]" @if(Request::is('task/*/edit'))> <option disabled
                            style="display:block">Please Select One</option>

                            @foreach($teammember as $teammemberData)
                            <option value="{{$teammemberData->id}}" @if(($task->teammember_id) ==
                                $teammemberData->id) selected
                                @endif>
                                {{ $teammemberData->title->title }}. {{ $teammemberData->team_member }}(
                                {{ $teammemberData->role->rolename}} )</option>
                            @endforeach


                            @else
                            <option></option>
                            <option value="">Please Select One</option>
                            @foreach($irlassign as $teammemberData)
                            <option value="{{$teammemberData->id}}">
                                {{ $teammemberData->name }}</option>

                            @endforeach
                            @endif
                        </select>
                            <input id="id" hidden class="form-control" name="folderid" type="text">
                            <input id="name" hidden class="form-control" name="client_id" value="{{ $id }}" type="text">
                        </div>
                           
                    </div> 
                    <div class="details-form-field form-group row">
                             <label for="name" class="col-sm-3 col-form-label font-weight-600">Folder:</label>
                        <div class="col-sm-9">
                            <select class="language form-control" name="folderid">
                            <option value="">Please Select One</option>
                               @foreach($ilrfolders  as $ilrfolderData)
                            <option value="{{$ilrfolderData->id}}">
                                {{ $ilrfolderData->name }}</option>

                            @endforeach
                        </select>
                           
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

