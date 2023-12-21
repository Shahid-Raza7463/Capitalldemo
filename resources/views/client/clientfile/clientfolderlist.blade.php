
@extends('client.layouts.layout') @section('client_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add File</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-group-outline d-block mr-2"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Client File List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
    <div class="card-header" style="background:#37a000;">
          
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                   
                        <span style="color:white;"> {{ $clientfolder->name ??''}}</span>
                     
                    </h6>
                </div>

            </div>
        </div>
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
                            <th>Date</th>
							 <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientfile as $clientfileData)
                        <tr>
                            @php
                            $random = substr(md5(mt_rand()), 0, 10);
                       @endphp
                          <!--  <td><a
                                href="{{ url('client/clientfile/'.$clientfileData->id.'b'.$random) }}">
                                {{$clientfileData->file ??''}}</a></td> -->
                            <td><a
                                href="{{ Storage::disk('s3')->temporaryUrl('clientdocument/'.$clientfileData->file, now()->addMinutes(3)) }}">
                                {{$clientfileData->file ??''}}</a></td>
                        <td>{{ date('F d,Y', strtotime($clientfileData->created_at)) }}</td>
							    <td>
                            @php

$infotime = Carbon\Carbon::parse(date('Y-m-d H:i',strtotime($clientfileData->created_at ))); 
$currenttime = Carbon\Carbon::parse(date('Y-m-d H:i'));
$currenttmng = $currenttime->diffInMinutes($infotime);
                          @endphp
                         

                        @if($currenttmng > 360)
                        @if(is_null($clientfileData->rqstdelete))
                        
                                  <a  href="{{ url('/client/folderlist/requestdelete', $clientfileData->id)}}" class="btn btn-success">
                                Request for deletion</a>
                            @else
                       <a style="color: white;" class="btn btn-success">
                            Requested done</a>
                            @endif
                       
                        @else
                        <a data-toggle="tooltip"
                        title="only for delete within 6 hours"  href="{{url('/client/folderlist/destroy/'.$clientfileData->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger-soft btn-sm"><i
                            class="far fa-trash-alt"></i></a>
                        @endif
                         </td>
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
                    <form id="detailsForm" method="post" action="{{ url('client/clientfile/upload')}}"
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
                                     <label for="name" class="col-sm-3 col-form-label font-weight-600">Title:</label>
                                <div class="col-sm-9">
                                    <input id="name" class="form-control" name="name" type="text">
                                    <input hidden class="form-control" name="rid" value="{{$id}}" type="text">
                                </div>
                                   
                            </div> 
                            <div class="details-form-field form-group row">
                                     <label for="name" class="col-sm-3 col-form-label font-weight-600">File:</label>
                                <div class="col-sm-9">
                                    <input id="name" class="form-control" name="file[]" multiple type="file">
                                    <span>maximum file upload 50 at once</span>
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