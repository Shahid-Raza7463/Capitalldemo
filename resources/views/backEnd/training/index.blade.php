
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	@if(Auth::user()->role_id == 11)
   <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            
            <li class="breadcrumb-item"><a onclick="return confirm('Are you sure you want to send reminder to all members ?');" 
                href="{{url('/training/reminderall/')}}"
                    class="btn btn-info-soft btn-sm">Reminder Mail <i class="far fa-envelope"></i></a></li>
         
        </ol>
    </nav>
	@else
	   <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            
            <li class="breadcrumb-item"><a  href="{{url('/training/create/')}}"
                    class="btn btn-info-soft btn-sm">Fill Training Form +</a></li>
         
        </ol>
    </nav>
	@endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Training Feedback List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
     @component('backEnd.components.alert')

        @endcomponent
        <div class="card-body">
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                           
                            <th> Teammember</th>
                          {{--  <th> Module</th> --}}
                            <th>Date</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainingDatas as $trainingData)
                        <tr>
                         
                            <td><a href="{{url('/training/list/'.$trainingData->id)}}">{{$trainingData->team_member ??''}} ( {{$trainingData->rolename ??''}} )</a></td>
                       {{--     <td> @foreach(DB::table('traininglists')
                                          ->leftjoin('pages','pages.id','traininglists.page_id')
                                       ->where('traininglists.training_id',$trainingData->id)->select('pages.pagename')->get()
                                        as $sub)
                           {{ $sub->pagename ??''}} , 
                            @endforeach</td> --}}
                            <td>{{ date('F d,Y', strtotime($trainingData->created_at)) }}</td>
                          
                      
                            
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


