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
		 
		    <li ><a class="btn btn-info" href="{{url('viewassignment/'.$id)}}">Back</a></li>
		
			  @if($assignmentfolderpermission->status == 1)
			  
			       <li style="margin-left: 13px;"><a class="btn btn-success" style="color:white;" data-toggle="modal" data-target="#exampleModal1">Add Folder</a></li>
@endif
        </ol>
    </nav>
	
   <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Assignment Folder</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    @component('backEnd.components.alert')

    @endcomponent

    <div class="row">
        @foreach($assignmentfolder as $assignmentfolderData)

        <div class="col-md-6 col-lg-3">
   @if($assignmentfolderpermission->status == 1)
            @if($assignmentfolderData->createdby == Auth::user()->teammember_id || Auth::user()->role_id == 13)
            <ul class="navbar-nav flex-row align-items-center ml-auto">
                <li class="nav-item dropdown user-menus">
                    <a class="foldertoggle" style=" color:white" href="#" data-toggle="dropdown">
                        <!--<img src="assets/dist/img/user2-160x160.png" alt="">-->
                        <i class="ti-more-alt"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left">
                        <a style="margin-left: 10px;color:#7a7a7a;" id="editCompany" data-toggle="modal"
                            data-id="{{ $assignmentfolderData->id }}" data-target="#modaldemo1" class="dropdown-item">Edit Name</a>
                       
                            @if(DB::table('assignmentfolderfiles')
                            ->where('assignmentfolderfiles.assignmentfolder_id',$assignmentfolderData->id)->where('status','1')->count() == 0)
                        <a style="margin-left: 10px;color:#7a7a7a;" onclick="return confirm('Are you sure you want to delete this folder?');" href="{{ url('assignmentfolderdelete', $assignmentfolderData->id)}}"
                             class="dropdown-item">Delete</a>
					@endif
                    </div>
                    <!--/.dropdown-menu -->
                </li>
            </ul>
@endif
@endif
            <a href="{{ url('assignmentfolderfiles', $assignmentfolderData->id)}}">

                <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center"
                    style="background: @if($loop->iteration % 2 == 0) #37A000; @else #06386A; @endif">
                    <div class="header-pretitle fs-11 font-weight-bold text-uppercase"
                        style="color: white;font-size: 11px!important;">
                        {{ strlen($assignmentfolderData->assignmentfoldersname) > 26 ? substr($assignmentfolderData->assignmentfoldersname,0,26) :$assignmentfolderData->assignmentfoldersname }}
                    </div>
                  
                    <div class="fs-32 text-monospace">{{  DB::table('assignmentfolderfiles')
                ->where('assignmentfolderfiles.assignmentfolder_id',$assignmentfolderData->id)->where('status','1')->count() }}</div>
                    <small>Data</small>

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
            <form id="detailsForm" method="post" action="{{ route('assignmentfolder.store')}}" enctype="multipart/form-data">
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
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Name:</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="assignmentfoldersname" type="text">
                        </div>
                        <input hidden class="form-control" name="assignmentgenerateid" value="{{$id ??''}}" type="text">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('assignmentfoldernameupdate') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $("#ids").val(response.id);
           $("#names").val(response.assignmentfoldersname);
           debugger;
            
        },
                error: function () {

                },
            });
        });
    });

</script>
<div class="modal fade bd-example-modal-sm" id="modaldemo1" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Update Folder Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('assignmentfolder_nameupdate')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input class="form-control" required placeholder="Update Folder Name"  name="name" id="names"
                        type="text">
                    <input class="form-control" hidden name="folderid" id="ids" type="text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> 
