@extends('backEnd.layouts.layout') @section('backEnd_content')

<style>
    a {
        cursor: pointer;
    }

    .user-menus {
        position: relative;
        position: absolute;
        right: 17px;
        top: 1px;

    }

</style>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Folder</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Partner Meeting Folder</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    @component('backEnd.components.alert')

    @endcomponent

    <div class="row">
        @foreach($meetingfolder as $meetingfolderData)

        <div class="col-md-6 col-lg-3">
            @if(Auth::user()->teammember_id == $meetingfolderData->createdby)
            <ul class="navbar-nav flex-row align-items-center ml-auto">
                <li class="nav-item dropdown user-menus">
                    <a class="foldertoggle" style=" color:white" href="#" data-toggle="dropdown">
                      
                        <i class="ti-more-alt"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left">
                     
                        <a style="margin-left: 10px;color:#7a7a7a;" id="editCompanys" data-toggle="modal"
                            data-id="{{ $meetingfolderData->id }}" data-target="#modalshare" class="dropdown-item">Edit</a>
                    </div>
                   
                </li>
            </ul> 
            @endif
            <a href="{{ url('meetingfiles', $meetingfolderData->id)}}">

                <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center"
                    style="background: @if($loop->iteration % 2 == 0) #37A000; @else #06386A; @endif">
                    <div class="header-pretitle fs-11 font-weight-bold text-uppercase"
                        style="color: white;font-size: 11px!important;">
                        {{ strlen($meetingfolderData->foldername) > 26 ? substr($meetingfolderData->foldername,0,26) :$meetingfolderData->foldername }}
                    </div>
                    {{-- {{dd(count($meetingfolderData->clientfile))}} --}}

                    @php
                    $meetingfiles = DB::table('meetingfiles')->where('meetingfolder_id',$meetingfolderData->id)
                    ->count();
                  //  dd($clientfiles);
                    $meetingsubfolder = DB::table('meetingfolders')->where('parent_id',$meetingfolderData->id)
                    ->count();
        
                @endphp
            @if($meetingfiles > 0)
            <div class="fs-32 text-monospace" style="color: white;">{{ $meetingfiles }}</div>
            <small style="color: white;">Document</small>
            @else
            <div class="fs-32 text-monospace" style="color: white;">{{ $meetingsubfolder }}</div>
            <small style="color: white;">Subfolders</small>
            @endif
                </div>
            </a>
        </div>
        @endforeach
    </div>

</div>
<!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('meetingsubfolderstore')}}"
                enctype="multipart/form-data">
                @csrf
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Folder</h5>
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
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Folder Name:</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="foldername" type="text">
                            <input hidden value="{{ $id }}" class="form-control" name="parentid" type="text">
                        </div>

                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Sub Folder of :</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="parent_id">
                                <option value="">No Subfolder</option>
                                @foreach($meetingfolders as $ilrfolderData)
                                <option value="{{$ilrfolderData->id}}">
                                    @if($ilrfolderData->parent_id == null)( Subfolder of)@endif
                                    {{ $ilrfolderData->foldername }}</option>

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
<div class="modal fade bd-example-modal-sm" id="modalshare" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" method="post" action="{{ url('meetingfolder/update')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                    

                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">File Name *</label>
                            <input type="text" id="foldername" name="foldername" class="form-control"
                                placeholder="Enter Folder Name">
                             
                        </div>
                    </div>
                   
                </div>
                           
                    <input hidden class="form-control" name="folderid" id="idss" type="text">
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
        $('body').on('click', '#editCompanys', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('meeting/filenameedit') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $("#idss").val(response.id);
           $("#foldername").val(response.foldername);
           debugger;
            
        },
                error: function () {

                },
            });
        });
    });

</script>
@endsection
