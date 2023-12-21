@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
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
    <div class="row">
        @foreach($ifcfolder as $ifcfolderData)

        <div class="col-md-6 col-lg-3">

            <a href="{{ url('ifclist', $ifcfolderData->id)}}">

                <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center"
                    style="background: @if($loop->iteration % 2 == 0) #37A000; @else #06386A; @endif">
                    <div class="header-pretitle fs-11 font-weight-bold text-uppercase"
                        style="color: white;font-size: 11px!important;">
                        {{ strlen($ifcfolderData->client_name) > 26 ? substr($ifcfolderData->client_name,0,26) :$ifcfolderData->client_name }}
                    </div>
                    {{-- {{dd(count($ifcfolderData->clientfile))}} --}}

                    <div class="fs-32 text-monospace">{{  DB::table('ifcs')
                ->where('ifcs.assign_member',auth()->user()->teammember_id)
                ->where('ifcs.client_id',$ifcfolderData->id)->distinct('ifcs.ifcfolder_id')->count() }}</div>
                    <small>Subfolder</small>

                </div>
            </a>
        </div>
        @endforeach
    </div>

</div>
<!--/.body content-->
@endsection
