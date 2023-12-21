
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Folder</a></li>
        </ol>
    </nav>
    @endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>IFC Folder</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    @component('backEnd.components.alert')

    @endcomponent   
    @if(Auth::user()->role_id  != 15)
    <div class="row">
        @foreach($ifcfolder as $ifcfolderData)
                  
    <div class="col-md-6 col-lg-3">
      
        <a  href="{{ url('ifc', $ifcfolderData->id)}}">
          
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: @if($loop->iteration % 2 == 0) #37A000; @else #06386A; @endif">
                <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white;font-size: 11px!important;">
                    {{ strlen($ifcfolderData->foldername) > 26 ? substr($ifcfolderData->foldername,0,26) :$ifcfolderData->foldername }}</div>
                    {{-- {{dd(count($ifcfolderData->clientfile))}} --}}
               
                <div class="fs-32 text-monospace">{{  DB::table('ifcfolders')
                    ->leftjoin('ifcs','ifcs.ifcfolder_id','ifcfolders.id')
                    ->where('ifcs.ifcfolder_id',$ifcfolderData->id)->count() }}</div>
                <small>Data</small>
                
            </div>
            </a>
        </div>
        @endforeach
    </div>
@endif
@if(Auth::user()->role_id  == 15)
<div class="row">
    @foreach($ifcfolder as $ifcfolderData)
              
<div class="col-md-6 col-lg-3">
  
    <a  href="{{ url('ifc', $ifcfolderData->id)}}">
      
        <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: @if($loop->iteration % 2 == 0) #37A000; @else #06386A; @endif">
            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white;font-size: 11px!important;">
                {{ strlen($ifcfolderData->foldername) > 26 ? substr($ifcfolderData->foldername,0,26) :$ifcfolderData->foldername }}</div>
                {{-- {{dd(count($ifcfolderData->clientfile))}} --}}
           
            <div class="fs-32 text-monospace">{{  DB::table('ifcfolders')
                ->leftjoin('ifcs','ifcs.ifcfolder_id','ifcfolders.id')
                ->where('ifcs.assign_member',auth()->user()->teammember_id)
                ->where('ifcs.ifcfolder_id',$ifcfolderData->id)->count() }}</div>
            <small>Data</small>
            
        </div>
        </a>
    </div>
    @endforeach
</div>
@endif

</div>
<!--/.body content-->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                   <form id="detailsForm" method="post" action="{{ route('ifcfolder.store')}}" enctype="multipart/form-data">
                        @csrf
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Folder</h5>
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
                                     <label for="name" class="col-sm-3 col-form-label font-weight-600">Name:</label>
                                <div class="col-sm-9">
                                    <input id="name" class="form-control" name="foldername" type="text">
                                </div>
                                <input hidden class="form-control" name="client_id" value="{{$id ??''}}" type="text">
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
                                   

