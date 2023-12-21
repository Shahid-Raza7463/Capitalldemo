
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   <!-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('asset/create')}}">Add Asset</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>-->
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Asset
                List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
    @foreach($assetDatas as $assetData)
    <div class="col-md-3"></div>
    <div class="col-md-6" style="
    padding: 10px;
">
    <div class="card mb-4">
        <div class="card-body text-center">
            <div class="row justify-content-center">
                @if(empty($assetData->acknowledge))
                <div class="greet-user col-12 col-xl-10">
                   <center> <h5><b>You have a new laptop assign please confirm</b></h5></center>
                    <p class="text-muted">
                     <p><b> Model</b> : {{$assetData->modal_name }}</p>   
                    </p>
                    <p class="text-muted">
                        <p> <b>Sno.</b> : {{$assetData->sno }}</p>  
                    </p>
                  
                  
                    <p class="text-muted">
                        <p> <b>Acknowledge.</b> :   </p>  
                    
                    </p>
                    <form id="detailsForm" method="post" action="{{ url('/assetconfirm')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <p class="text-muted" >
                        <select name="acknowledge" id="exampleFormControlSelect1" class="">
                            <!--placeholder-->
                            @if(Request::is('asset')) >
                            @if($assetData->acknowledge=='0')
                            <option value="0">No</option>
                            <option value="1">Yes</option>
            
                            @else
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                            
            
                            @endif
                            @else
            
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                            @endif
                        </select>
                        <input hidden placeholder="Enter Subject" value="{{ $assetData->financeid }}"  class="form-control" name="assetid" type="text">
                    </p>
                    <button type="submit" class="btn btn-success">Confirm</button>
                    </a>
                    </form>
                </div>
                @else
                <div class="greet-user col-12 col-xl-10">
                   
                    <p class="text-muted">
                     <p><b> Model</b> : {{$assetData->modal_name }}</p>   
                    </p>
                    <p class="text-muted">
                        <p> <b>Sno.</b> : {{$assetData->sno }}</p>  
                    </p>
                  
                    <p class="text-muted">
                        <p> <b>Kgs.</b> : {{$assetData->kgs }}</p>  
                    </p>
                    <p class="text-muted">
                        <p> <b>Description.</b> : {{$assetData->description }}</p>  
                    </p>
                    <p class="text-muted">
                        <p> <b>Status.</b> :  @if($assetData->assetstatus == 0 )
                            <span class="badge badge-success">Assigned</span>

                            @else
                            <span class="badge badge-danger">Return</span>
                            @endif</p>  
                    </p>
                    <a href="{{url('/generateticket/'.$assetData->id)}}" class="btn btn-success">
                       Generate Ticket
                    </a>
                </div>
                @endif
            </div> 
        </div>
    </div>
    </div>
    <div class="col-md-3"></div>
    @endforeach
    </div>
</div><!--/.body content-->

@endsection


