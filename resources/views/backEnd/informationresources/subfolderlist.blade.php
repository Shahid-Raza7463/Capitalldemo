
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
     <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url()->previous() }}" >Back <i class="fa fa-reply"></i></a></li>
         
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>ILR Folder  List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
 <div class="card mb-4">
 <div class="card-header" style="background:#218838">
          
        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h6 class="fs-17 font-weight-600 mb-0">
               
                    <span style="color:white;">{{ $subfolders->name ??''}}</span>
                 
                </h6>
            </div>

        </div>
    </div>
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
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>

                            <th>Name</th>
  <th>Assign</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrfolder as $ilrfolderData)
                        <tr>

                           
                              <td>  @if($ilrfolderData->name == 'Detail of Banks')
                              <a style="font-size: 16px;"
                              href="{{url('/ilrbank?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Detail of Banks</b></i></a>
                            @elseif($ilrfolderData->name == 'Income from House Property')
                              <a style="font-size: 16px;"
                              href="{{url('/ilrhouse?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Income from House Property</b></i></a>
                            @elseif($ilrfolderData->name == 'Income from Salary')
                              <a style="font-size: 16px;"
                              href="{{url('/ilrsalary?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Income from Salary</b></i></a>
						  @elseif($ilrfolderData->name == 'Personal Information')
                                <a style="font-size: 16px;"
                                    href="{{url('/ilrpersonal?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Personal Information</b></i></a>
                            @elseif($ilrfolderData->name == 'Additional Information')
                              <a style="font-size: 16px;"
                              href="{{url('/ilraddinformation?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Additional Information</b></i></a>
								    @elseif($ilrfolderData->name == 'Income from Business & Profession')
                                <a style="font-size: 16px;"
                                    href="{{url('/ilrbp?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Income from Business & Profession</b></i></a>
                                @elseif($ilrfolderData->name == 'Income from Capital Gains')
                                <a style="font-size: 16px;"
                                    href="{{url('/incomefromcapitalgains?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Income from Capital Gains</b></i></a>
                                @elseif($ilrfolderData->name == 'Income from Other Sources')

                                <a style="font-size: 16px;"
                                    href="{{url('/incomefromsources?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Income from Other Sources</b></i></a>
                                @elseif($ilrfolderData->name == 'Details of Deductions')
                                <a style="font-size: 16px;"
                                    href="{{url('/ilrdeduction?'.'informationresource_id='.$ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>Details of Deductions</b></i></a>
                                        @else
                              <a style="font-size: 16px;"
                                    href="{{ url('informationlist', $ilrfolderData->id)}}"><i
                                        class="far fa-folder"> <b>{{$ilrfolderData->name }}</b></i></a>
                                        @endif
                          </td>
  @php
                          $assign = DB::table('ilrfolderassigns')
                          ->leftjoin('clientlogins','clientlogins.id','ilrfolderassigns.clientlogin_id')->select('clientlogins.name')
                          ->where('ilrfolder_id',$ilrfolderData->id)->get();
                                     @endphp
                         <td> @foreach($assign as $assigns) <span class="badge badge-pill badge-success">{{ $assigns->name ??''}}</span> @endforeach</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   {{-- <div class="row">
        @foreach($ilrfolder as $ilrfolderData)
        <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <a  href="{{ url('informationlist', $ilrfolderData->id)}}">
            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center" style="background: {{ $ilrfolderData->color }}">
                <div class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase" style="color: white">{{$ilrfolderData->name }}</div>
                <div class="fs-32 text-monospace">{{ count($ilrfolderData->ilr) }}</div>
                <small>Question</small>
            </div>
            </a>
        </div>
        @endforeach
    </div> --}}
</div>
<!--/.body content-->
@endsection
                             

