
@extends('client.layouts.layout') @section('client_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
    <div class="col-sm-12 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>IRL Folder  List</small>
            </div>
            @if(Auth::user()->id == 16 || Auth::user()->id == 44 || Auth::user()->id == 36)
            <div class="">
                <a data-toggle="modal" data-target="#exampleModal12" style="float: right;color:white;" class="btn btn-success ml-2">Add Subfolder</a>
            </div>
            @endif
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
			@elseif($ilrfolderData->name == 'Detail of Banks')
            <a   href="{{url('/client/ilrbank?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
               
                <div class="fs-32 text-monospace"><i class="fas fa-money-check"></i></div>
                <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
				
				
            </div>
            </a>
            @elseif($ilrfolderData->name == 'Income from House Property')
            <a   href="{{url('/client/ilrhouse?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
               
                <div class="fs-32 text-monospace"><i class="fas fa-home"></i></div>
                 <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
				
				
            </div>
            </a>
			 @elseif($ilrfolderData->name == 'Personal Information')
            <a   href="{{url('/client/ilrpersonal?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
               
                <div class="fs-32 text-monospace"><i class="fas fa-id-card"></i></div>
                <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
				
				
            </div>
            </a>
			  @elseif($ilrfolderData->name == 'Details of Deductions')
            <a   href="{{url('/client/ilrdeduction?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
              
                <div class="fs-32 text-monospace"><i class="fas fa-minus"></i></div>
                  <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
				
				
            </div>
            </a>
            @elseif($ilrfolderData->name == 'Income from Salary')
            <a   href="{{url('/client/ilrsalary?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
              
				
                <div class="fs-32 text-monospace"><i class="fas fa-rupee-sign"></i></div>
                <small></small>
				  <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
            </div>
            </a>
			 @elseif($ilrfolderData->name == 'Income from Other Sources')
            <a   href="{{url('/client/incomefromsources?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
             
                <div class="fs-32 text-monospace"><i class="fab fa-sourcetree"></i></div>
                  <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
				
				
            </div>
            </a>
            @elseif($ilrfolderData->name == 'Additional Information')
            <a  href="{{url('/client/ilraddinformation?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
               
                <div class="fs-32 text-monospace"><i class="fas fa-plus"></i></div>
                <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
				
				
            </div>
            </a>
			 @elseif($ilrfolderData->name == 'Income from Business & Profession')
            <a   href="{{url('/client/ilrbp?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
               
                <div class="fs-32 text-monospace"><i class="fas fa-business-time"></i></div>
                <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">Income from Business</div>
				
				
            </div>
            </a>
			
			 @elseif($ilrfolderData->name == 'Income from Capital Gains')
            <a   href="{{url('/client/incomefromcapitalgains?'.'informationresource_id='.$ilrfolderData->id)}}">
               
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
              
				
                <div class="fs-32 text-monospace"><i class="fas fa-arrow-up"></i></div>
                  <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
				
            </div>
            </a>
			@else
			 <a  href="{{ url('client/informationlist', $ilrfolderData->id)}}">
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
                <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white;font-size: 11px!important;">{{ strlen($ilrfolderData->name) > 26 ? substr($ilrfolderData->name,0,26) :$ilrfolderData->name }}</div>
				@if(count($ilrfolderData->ilr) > 0)
                <div class="fs-32 text-monospace">{{ count($ilrfolderData->ilr) }}</div>
                <small>IRL</small>
				@else
				<div class="fs-32 text-monospace">{{ count($ilrfolderData->ilrsubfolder) }}</div>
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
    
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('client/informationfolder/store')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #218838;">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Folder</h5>
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
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="name" type="text">
                            <input id="name" hidden class="form-control" name="parent_id" value="{{ $id ??''}}" type="text">
                        </div>

                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Color :</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="color" type="color">

                        </div>

                    </div>
                  

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
                         

@endsection
