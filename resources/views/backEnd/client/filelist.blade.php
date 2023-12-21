
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a
                data-toggle="modal" data-target="#exampleModal122" 
                    class="btn btn-info-soft btn-sm"><i class="fa fa-plus"></i></a></li>
         
        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Client Folder  List</small>
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
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>

                            <th>Name</th>
                            <th>Created by</th>
  <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filelist as $filelistData)
                        <tr>

                           @php
							$auth = Auth::user()->role_id;
							@endphp
                          <td><a
                            href="{{ Storage::disk('s3')->temporaryUrl('clientdocument/'.$filelistData->file, now()->addMinutes(3)) }}">
                            {{$filelistData->file ??''}}</a></td>
                             <td>@if($filelistData->name == null)
                                {{$filelistData->team_member ??''}}
                                @else
                                {{$filelistData->name ??''}}
                                @endif</td>
                            <td>{{ date('F d,Y', strtotime($filelistData->created_at)) }}</td>
                         @if(is_null($filelistData->rqstdelete))
                            <td></td>
                                    @else
                                    <td> <a href="{{url('/clientfolderlist/destroy/'.$filelistData->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger-soft btn-sm"><i
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
<!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="exampleModal122" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('admin/file')}}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add File</h5>
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
                             <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload File:</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="file[]" multiple type="file">
                            <input id="name" hidden class="form-control" name="clientid" type="text" value="{{$clientid->client_id ??''}}">
                            <input id="name" hidden class="form-control" name="clientfolder_id" type="text" value="{{$clientid->id ??''}}">
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
@endsection
                             

