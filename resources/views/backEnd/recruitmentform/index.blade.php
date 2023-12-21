@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('recruitmentform/create')}}">Add RecruitmentForm</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Recruitment Form
                    List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                             <th>Category</th>
                             @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                             <th>Status</th>
							  <th>Type</th>
                             <th>Replacement of Employee</th>
                           
                             @endif
                            <th>Required Experience</th>
                             <th>Required for Client </th>
                            <th>Required for Assignment/Project </th> 
                            <th>Number of Vacancies</th>
                            <th>Timeline</th>
                             <th>Priority</th>
                            <th>Detailed Job Profile</th>
                            <th>Any Specific Skills Required</th>
                            <th>Name of Approving Authority</th>
                           <th>Created At</th>
                            <th>Createdby</th>
                           

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recruitmentformDatas as $recruitmentformDatas)
                        <tr>
                       
                        <td><a href="{{url('view/recruitmentform/'.$recruitmentformDatas->id)}}"> {{ $recruitmentformDatas->categoryname }}</td>
                            @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)  
                            <td>@if($recruitmentformDatas->status==0)
                                <span class="badge badge-pill badge-success">Open</span>
                                @elseif($recruitmentformDatas->status==1)
                                <span class="badge badge-danger">Close</span>
                                @elseif($recruitmentformDatas->status==2)
                                <span class="badge badge-warning">Hold</span>
                                @endif</td>
							 <td>{{$recruitmentformDatas->type ??''}}</td>
                                 <td>{{App\Models\Teammember::select('team_member')->where('id',$recruitmentformDatas->employee)
                                    ->pluck('team_member')->first()
                                     ??''}}</td>
                         
                                 @endif
							
                            <td> {{ $recruitmentformDatas->required_experience }}</td>
                        @php
                              $recruitmentclient  = DB::table('recruitmentformclients')
          ->leftjoin('clients','clients.id','recruitmentformclients.client_id')
          ->where('recruitmentformclients.recruitmentform_id',$recruitmentformDatas->id)
         ->select('clients.client_name')->get();
    
                        @endphp
                        <td> @foreach($recruitmentclient as $recruitmentclients)   <span style="font-size: 12px;" class="badge badge-info">
                             {{ $recruitmentclients->client_name }} </span>,
                        @endforeach</td>

                        <td> {{ $recruitmentformDatas->assignment_project }}</td>
                        <td> {{ $recruitmentformDatas->number_of_vacancies }}</td>
                        <td>{{ date('F d,Y', strtotime( $recruitmentformDatas->timeline )) }}</td>
                        <td> {{ $recruitmentformDatas->priority }}</td>
                        <td> {{ $recruitmentformDatas->detailed_Job_profile }}</td>
                        <td> {{ $recruitmentformDatas->specific_skills }}</td>  
                        <td>{{ App\Models\Teammember::select('team_member')->where('id',$recruitmentformDatas->teammember_id)->first()->team_member ?? ''}}</td> 
                        <td>{{ date('F d,Y', strtotime( $recruitmentformDatas->created_at )) }}</td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$recruitmentformDatas->createdby)->first()->team_member ?? ''}}
                            </td>
    
                      
                    
                       
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
