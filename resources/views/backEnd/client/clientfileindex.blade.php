@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('clientfile/create')}}">Add Client File</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Client File
                    List</small>
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
                            <th>Client Name</th>
                            <th>Document Name</th>
                            <th>Uploaded by</th>
                            <th>Document Type</th>
                            <th style="width: 189px;">File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientfileDatas as $clientfileData)
                        <tr>
                            <td>{{$clientfileData->client_name}}</td>
                            <td>{{$clientfileData->document_name}}</td>
                            <td>{{$clientfileData->team_member}}</td>
                            <td>@if($clientfileData->type==0)
                                <span>Permanent</span>
                                @else
                                <span>Temporary</span>
                                @endif
                            </td>
                            @if (pathinfo($clientfileData->filess, PATHINFO_EXTENSION) == 'png')
                            <td><a class="btn btn-success btn" target="blank"
                                    href="{{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}"><i
                                        class="fas fa-file" style="margin-right: 4px;"></i>Open</a> <a
                                    class="btn btn-success btn" target="blank"
                                    href="{{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}"><i
                                        class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                            @elseif(pathinfo($clientfileData->filess, PATHINFO_EXTENSION) == 'jpeg')
                            <td><a class="btn btn-success btn" target="blank"
                                    href="{{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}"><i
                                        class="fas fa-file" style="margin-right: 4px;"></i>Open </a> <a
                                    class="btn btn-success btn" target="blank"
                                    href="{{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}"><i
                                        class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                            @elseif(pathinfo($clientfileData->filess, PATHINFO_EXTENSION) == 'jpg')
                            <td><a class="btn btn-success btn" target="blank"
                                    href="{{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}"><i
                                        class="fas fa-file" style="margin-right: 4px;"></i>Open </a> <a
                                    class="btn btn-success btn" target="blank"
                                    href="{{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}"><i
                                        class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                            @else
                            <td><a class="btn btn-primary btn" target="blank"
                                    href="https://docs.google.com/gview?url={{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}"><i
                                        class="fas fa-file-excel" style="margin-right: 4px;"></i>Open</a> <a
                                    class="btn btn-success btn" target="blank"
                                    href="{{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}"><i
                                        class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                            @endif
                            <td><a href="{{url('/clientdocument/destroy/'.$clientfileData->id)}}"
                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a></td>
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
