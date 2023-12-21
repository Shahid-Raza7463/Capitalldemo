@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    @if(Auth::user()->role_id == 15 || Auth::user()->role_id == 14||Auth::user()->role_id == 18)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
       <!-- <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('assignmentevaluation/create')}}">Add Assignment Evaluation</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>-->
    </nav>
    @endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Assignment Evaluation List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<!-- count start -->
	
	<div class="body-content">
    <div class="row">

			<div class="col-md-6 col-lg-4">
		</div>
    <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center" style="height:90px;">
              <a href="{{url('assignmentevaluation')}}">
                <div style="color:white;" class="opacity-50 header-pretitle fs-18 font-weight-bold text-uppercase">Total</div>
                <div style="color:white;" class="fs-15 text-monospace">{{$countevaluated+$countpendingevaluated+$countnotsubmitted ??''}}</div>
               
               </a>
            </div>
        </div>
		
		<div class="col-md-6 col-lg-5">
		</div>
    
	
        <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center" style="height:90px;">
              <a href="{{url('assignmentevaluation/type/3')}}">
                <div style="color:white;" class="opacity-50 header-pretitle fs-18 font-weight-bold text-uppercase">Assigment Evaluation Created</div>
                <div style="color:white;" class="fs-15 text-monospace">{{$countnotsubmitted ??''}}</div>
               
               </a>
            </div>
        </div>
		  <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center" style="height:90px;">
              <a href="{{url('assignmentevaluation/type/4')}}">
                <div style="color:white;" class="opacity-50 header-pretitle fs-18 font-weight-bold text-uppercase">Not Submitted</div>
                <div style="color:white;" class="fs-15 text-monospace">{{$countinvoiced ??''}}</div>
               
               </a>
            </div>
        </div>
		
		 
        <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center" style="height:90px;">
                <a href="{{url('assignmentevaluation/type/0')}}">
                <div style="color:white;" class="opacity-50 header-pretitle fs-18 font-weight-bold text-uppercase">Pending for Evaluation</div>
                <div style="color:white;" class="fs-15 text-monospace">{{$countpendingevaluated ??''}}</div>
                
                </a>
            </div>
        </div>
       
      

		<div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 bg-info text-white rounded mb-3 p-3 shadow-sm text-center" style="height:90px;">
                    <a href="{{url('assignmentevaluation/type/1')}}">
                <div style="color:white;" class="opacity-50 header-pretitle fs-18 font-weight-bold text-uppercase">Evaluated</div>
                <div style="color:white;" class="fs-15 text-monospace">{{$countevaluated ??''}}</div>
               
                </a><a></a>
            </div>
        </div>
        
      
      

    </div>


</div>
<!-- count end-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                             <th>Employee Name</th>
                             <th style="display:none;">Submission Date</th>
                             <th style="display:none;"> Date Of Evaluation</th>
                             <th>Status</th>
                            <th style="display:none;">Date of Joining</th>
                             <th>Client’s name</th> 
                            <th>Assignment Name</th>
							<th>Assignment Generate Id</th>
                             <th style="display:none;">Assignment Partner/Head</th>
                            <th>Start Date Of Assignment</th>
                            <th>End Date Of Assignment</th>
                            <th style="display:none;">Total Assignment Hours (You Spent)</th>
                            <th style="display:none;">Submitted on portal (KGS Capitall)</th>
                            <th style="display:none;">Level Of Complexity</th>
                            <th  style="display:none;">Any difficulties/challenges faced During Assignment?</th>
                            <th style="display:none;">Any issues with any team member/team leader?</th>
                            <th style="display:none;">Rate your overall performance at this assignment</th>
                            <th style="display:none;">Is file prepared as per the Documentation Policies & Standards?</th>
                            <th style="display:none;">Is file handed over to Record keeper?</th>
                            <th style="display:none;"> Record Keeper</th>
                            <th style="display:none;">Name of the Team Leader who signed the file after Review</th>
                            <th style="display:none;">Choose the concerned Assignment Reporting Person</th>
							@if( Auth::user()->role_id != 15)
                            <th style="display:none;">Technical knowledge</th>
                            <th style="display:none;">General Awareness</th>
                            <th style="display:none;">Planning & Organizing</th>
                            <th style="display:none;">Job Management</th>
                            <th style="display:none;">Written Communication</th>
                            <th style="display:none;">Verbal Communication</th>
                            <th style="display:none;">Teamwork</th>
                            <th style="display:none;">Motivation</th>
                            <th style="display:none;">Maturity</th>
                            <th style="display:none;">Time Consciousness</th>
                            <th style="display:none;">Problem Solving</th>
                            <th style="display:none;">Documentation</th>
                            <th style="display:none;">Quality of Work</th>
                            <th style="display:none;">Achievement of Tasks/Targets</th>
                            <th style="display:none;">Initiative Displayed</th>
                            <th style="display:none;">Rate Over all Performance</th>
                            <th style="display:none;">Areas he/she Performed extremely well </th>
                            <th style="display:none;">Areas he/she needs improvement </th>
                            <th style="display:none;">Training Needs </th>
							@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignmentData as $assignmentDatas)
                        <tr>
                       
                        <td><a href="{{url('view/assignmentevaluation/'.$assignmentDatas->id)}}"> {{ App\Models\Teammember::select('team_member')
                            ->where('id',$assignmentDatas->createdby)->first()->team_member ?? ''}}</td>
                              <td style="display:none;"> {{ date('F d,Y', strtotime($assignmentDatas->created_at)) }}</td>
                              <td style="display:none;">@if($assignmentDatas->approveddate != null)
                                {{ date('F d,Y', strtotime($assignmentDatas->approveddate) )  }}@endif
                           </td>
                            <td >
                            @if($assignmentDatas->status == 0)
                            <span class="badge badge-pill badge-warning">Pending For Evaluation</span>
                            
                            @elseif($assignmentDatas->status == 1)
                            <span class="badge badge-pill badge-success">Evaluated</span>                           
                            

                            @elseif($assignmentDatas->status == 3)
                            <span class="badge badge-pill badge-info">Assignment Evaluation Created</span>                           
                          
                            @else
                           <span class="badge badge-pill badge-secondary">Not Submitted</span>
                        
                            @endif
                        </td>
                          <td style="display:none;"> {{ date('F d,Y', strtotime($assignmentDatas->date_of_joining)) }}</td>
                           <td> {{ $assignmentDatas->client_name }}</td>
                           <td> {{ $assignmentDatas->assignment_name }}</td>
							<td>{{$assignmentDatas->assignmentgenerate_id ??''}}</td>
                           <td style="display:none;"> {{ $assignmentDatas->team_member }}({{ $assignmentDatas->rolename }})</td>
                            <td > {{ date('F d,Y', strtotime($assignmentDatas->start_date_of_assignment)) }}</td>
                            <td> {{ date('F d,Y', strtotime($assignmentDatas->end_date_of_assignment)) }}</td>
                            <td style="display:none;"> {{ $assignmentDatas->total_assignment_hours }}</td>
                            <td style="display:none;"> {{ $assignmentDatas->assignment_date_record }}</td>
                            <td style="display:none;"> {{ $assignmentDatas->level_of_complexity }}</td>
                           
                            <td style="display:none;"> {{ $assignmentDatas->difficulties_assignment }}</td>
                            <td style="display:none;"> {{ $assignmentDatas->issues_team }}</td>
                            <td style="display:none;"> {{ $assignmentDatas->rate_over_all_performance }}</td>
                            <td style="display:none;"> {{ $assignmentDatas->document_policies }}</td>
                            <td style="display:none;"> {{ $assignmentDatas->record_keeper }}</td>
                            <td style="display:none;">{{ App\Models\Teammember::select('team_member')
                                ->where('id',$assignmentDatas->staff_record_keeper)->first()->team_member ?? ''}}</td>
                            <td style="display:none;">{{ App\Models\Teammember::select('team_member')
                                ->where('id',$assignmentDatas->team_leader_signed)->first()->team_member ?? ''}}</td>
                            <td style="display:none;">{{ App\Models\Teammember::select('team_member')
                                ->where('id',$assignmentDatas->assignment_report_manager)->first()->team_member ?? ''}}</td>
                            @if( Auth::user()->role_id != 15)
                                <td style="display:none;"> {{ $assignmentDatas->technical_knowledge }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->general_awareness }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->planning_organizing }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->job_management }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->written_communication }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->verbal_communication }}/10</td>
                                <td  style="display:none;"> {{ $assignmentDatas->teamwork }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->motivation }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->maturity }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->time_consciousness }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->problem_solving }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->documentation }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->qualityofwork }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->achievement_of_tasks_targets }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->initiative_displayed }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->rate_over_all_performance }}/10</td>
                                <td style="display:none;"> {{ $assignmentDatas->areas_performed_extremely }}</td>
                                <td style="display:none;"> {{ $assignmentDatas->areas_needs_improvement }}</td>
                                <td style="display:none;"> {{ $assignmentDatas->training_needs }}</td>
							@endif
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    function calcDiff(){
        var date1 = new Date($("2020/04/22").val());
        var date2 = new Date($("2020/04/20").val());
   alert(date1);
        var timedifference = date2.gettime() - date1.gettime();
        
        var millisecondsInOneSecond = 1000;
        var secondInOneHour = 3600;
        var hourInOneDay = 24;

        var daysDiff = timedifference/(millisecondsInOneSecond * secondInOneHour * hourInOneDay);
      //    alert(daysDiff);
    }
    </script> -->