 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
@if(Auth::user()->role_id == 14 || Auth::user()->role_id == 18 || Auth::user()->role_id == 16 || Auth::user()->role_id == 17 || Auth::user()->teammember_id == 155)
<div class="content-header row align-items-center m-0">
     <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('trainingassetsments/create')}}">Add Training Assessment Form</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Training Assessment Form List</small>
            </div>
        </div>
    </div>
</div>
@endif
<!--/.Content Header (Page header)-->
<div class="body-content">

    <div class="card mb-4">
     @component('backEnd.components.alert')

        @endcomponent
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                           
                            <th>Reporting Partner</th>
                            <th>Name of Team Member</th>
                            <th>Topic For Technical Training</th>
                            <th>Topics for Soft Skills Training</th>
                            <th>Created by</th>
                            <th>Date</th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainingassetsmentData as $trainingassetsmentDatas)
                        <tr>
                            <td>{{$trainingassetsmentDatas->team_member ??''}}</td>
                            <td>{{$trainingassetsmentDatas->teamname ??'' }}</td>

                            <td>{{$trainingassetsmentDatas->trainingtype ??'' }}</td>
                            @php
                        $trainingassessmentsskills = DB::table('trainingassessmentsskills')
        ->leftjoin('softskillstraining','softskillstraining.id','trainingassessmentsskills.softskillstraining')
        ->leftjoin('trainingassessments','trainingassessments.id','trainingassessmentsskills.trainingassessmentsid')
        ->where('trainingassessmentsskills.trainingassessmentsid',$trainingassetsmentDatas->id)
							->where('softskillstraining.id','!=','8')->select(
            'softskillstraining.name as softname','trainingassessments.other')->get();
                  //  dd($taskassig);
                    @endphp
                            <td> @foreach($trainingassessmentsskills as $trainingassessmentsskill)
                                <span class="badge badge-pill badge-info"> {{$trainingassessmentsskill->softname ??'' }} </span> @endforeach @if($trainingassetsmentDatas->other != null) <span class="badge badge-pill badge-info"> {{$trainingassetsmentDatas->other ??'' }}  </span> @endif</td>
                         
                            <td>{{$trainingassetsmentDatas->createdby ??'' }}</td>
                            <td>{{ date('F d,Y', strtotime($trainingassetsmentDatas->created_at)) }}</td>
                            
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


