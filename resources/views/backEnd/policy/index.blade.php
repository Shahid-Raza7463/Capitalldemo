@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	   @if(Auth::user()->role_id == 18)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('policy/create')}}">Add Policy</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
	@endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
   <div class="row">
        @foreach($policyDatas as $policy)
                  
    <div class="col-md-6 col-lg-3">
   
    <a  href="{{ url('policy/list', $policy->id)}}">
      
        <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: @if($loop->iteration % 2 == 0) #37A000; @else #06386A; @endif">
            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white;font-size: 11px!important;">
                {{ strlen($policy->foldername) > 26 ? substr($policy->foldername,0,26) :$policy->foldername }}</div>
                {{-- {{dd(count($clientfolderData->clientfile))}} --}}
         @php
$count = DB::table('policies')->where('id',$policy->id)->count();
         @endphp
        <div class="fs-32 text-monospace" style="color: white;">{{ $count
        }}</div>
        <small style="color: white;">Document</small>
    
       
        </div>
        </a>
    </div>
                  @endforeach
    </div>

</div>
<!--/.body content-->
@endsection
