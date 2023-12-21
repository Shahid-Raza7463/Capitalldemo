
@extends('client.layouts.layout') @section('client_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>IRL Folder  List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->

<div class="body-content">
    {{-- <div class="card mb-4">

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
                <table class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>

                            <th>Name</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrfolder as $ilrfolderData)
                        <tr>

                           
                          <td><a style="font-size: 16px;"
                                    href="{{ url('informationlist', $ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>{{$ilrfolderData->name }}</b></i></a></td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    <div class="row">
        @foreach($ilrfolder as $ilrfolderData)
        <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
			   @if($ilrfolderData->name == 'University Agreement')
            <a  href="{{ url('client/ilrlist')}}">
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
                <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
				
                <div class="fs-32 text-monospace">{{ count(DB::table('talents')->latest()->get()) }}</div>
                <small>List of Agreements</small>
				
            </div>
            </a>
			@else
			 <a  href="{{ url('client/informationlist', $ilrfolderData->id)}}">
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
                <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white;font-size: 11px!important;">{{ strlen($ilrfolderData->name) > 26 ? substr($ilrfolderData->name,0,26) :$ilrfolderData->name }}</div>
			@php
          $ilr = DB::table('informationresources')->where('ilrfolder_id',$ilrfolderData->id)
     ->where('client_id',auth()->user()->client_id)->get();

          $ilrsubfolder = DB::table('ilrfolders')->where('parent_id',$ilrfolderData->id)
     ->where('client_id',auth()->user()->client_id)->get();
            @endphp
                @if(count($ilr) > 0)
                <div class="fs-32 text-monospace">{{ count($ilr) }}</div>
                <small>IRL</small>
				@else
				<div class="fs-32 text-monospace">{{ count($ilrsubfolder) }}</div>
                <small>Subfolders</small>
				@endif
            </div>
            </a>
			@endif
        </div>
        @endforeach
    </div>
</div>
<!--/.body content-->
@endsection
                             

