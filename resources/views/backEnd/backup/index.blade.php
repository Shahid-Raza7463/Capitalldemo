
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item">	<a href="{{url('dbbackup')}}" class="btn btn-primary" style="float: right;color:white;">Generate Backup</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-download mr-2"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Backup Database List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
    
        <div class="card-body">
            <div class="col-sm-12 buttons-w">
                <div class="row">
                @foreach( $dirNames as $dirName)
                <div class="col-lg-3 col-md-3 col-sm-4 align-center">
                <a href="{{url('download/'.$dirName['fileName'])}}" class="btn btn-light folder-wrap"  style="padding: 20px;" role="button">
                <div class="os-icon os-icon-file"></div>
                <br>
                {{ $dirName['fileName'] }}
                </a>
                </div>
            
                @endforeach
                </div>
                </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


