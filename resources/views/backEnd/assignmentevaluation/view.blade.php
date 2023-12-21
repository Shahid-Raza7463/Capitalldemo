@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">

             @php
            $status=App\Models\Assignmentevaluation::where('id',$id)->first();
            //dd($status);
            @endphp

            @if($status->status ==4 && $status->createdby==auth()->user()->teammember_id)
        <li> <a class="btn btn-primary" href="{{route('assignmentevaluation.edit', $id)}}">Click Here to Complete Evaluation </a></li>&nbsp;
		@endif

			<li> <a class="btn btn-primary" href="{{ url('assignmentevaluation') }}">Back</a></li>


        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Assignment Evaluation Details</small></a>
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2); @if($assignmentevaluation->technical_knowledge != null)height:1000px; @endif">
                <div class="card-body">

                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Name : </b></td>

                                    <td> {{ App\Models\Teammember::select('team_member')
                                        ->where('id',$assignmentevaluation->createdby)->first()->team_member ?? ''}}</td>
                                    <td><b>Date of Joining : </b></td>
                                    <td>{{ date('F d,Y', strtotime($assignmentevaluation->date_of_joining)) }}</td>
                                </tr>

                                <tr>
                                    <td><b>Client’s Name: </b></td>
                                    @php
                                    $clientData = DB::table('assignmentevaluations')
                                    ->leftjoin('clients','clients.id','assignmentevaluations.clients_name')
                                    ->where('assignmentevaluations.id',$assignmentevaluation->id)
                                    ->select('assignmentevaluations.*','clients.client_name')->get();
                                    @endphp
                                    <td>@foreach($clientData as $clientData) {{ $clientData->client_name ??''}}
                                        @endforeach
                                    </td>
                                    <td><b>Nature Of Assignment : </b></td>
                                    @php
                                    $assignmentData = DB::table('assignmentevaluations')
                                    ->leftjoin('assignments','assignments.id','assignmentevaluations.nature_of_assignment')
                                    ->where('assignmentevaluations.id',$assignmentevaluation->id)
                                    ->select('assignmentevaluations.*','assignments.assignment_name')->get();
                                    @endphp
                                    <td>@foreach($assignmentData as $assignmentData)
                                        {{ $assignmentData->assignment_name ??''}}
                                        @endforeach
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>Choose Assignment Partner/Head : </b></td>
                                    @php
                                    $partnerteamData = DB::table('assignmentevaluations')
                                    ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
                                    ->where('assignmentevaluations.id',$assignmentevaluation->id)
                                    ->select('assignmentevaluations.*','teammembers.team_member')->get();
                                    @endphp
                                    <td>@foreach($partnerteamData as $partnerteamData)
                                        {{ $partnerteamData->team_member ??''}}
                                        @endforeach
                                    </td>
                                    <td><b>Start Date Of Assignment : </b></td>
                                    <td>{{ date('F d,Y', strtotime($assignmentevaluation->start_date_of_assignment)) }}
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>End Date Of Assignment : </b></td>
                                    <td>{{ date('F d,Y', strtotime($assignmentevaluation->end_date_of_assignment)) }}
                                    </td>
                                    <td><b>Total Assignment Hours (You Spent) : </b></td>
                                    <td>{{$assignmentevaluation->total_assignment_hours}}</td>

                                </tr>
                                <tr>
                                    <td><b>Is the entire Assignment data/record/file recorded and submitted on portal
                                            (KGS Capitall) : </b></td>
                                    <td>{{$assignmentevaluation->assignment_date_record}}</td>
                                    <td><b>Level Of Complexity : </b></td>
                                    <td>{{$assignmentevaluation->level_of_complexity}}</td>

                                </tr>
                                <tr>
                                    <td><b>Any difficulties/challenges faced During Assignment? : </b></td>
                                    <td>{{ $assignmentevaluation->difficulties_assignment ??''}}</td>
                                    <td><b>Any issues with any team member/team leader? : </b></td>
                                    <td>{{ $assignmentevaluation->issues_team ??''}}</td>

                                </tr>
                                <tr>
                                    <td><b>Rate yourself overall performance on this assignment : </b></td>
                                    <td>{{ $assignmentevaluation->rate_over_all_performance ??''}}</td>
                                    <td><b>Have you submitted the Conveyance Request? : </b></td>
                                    <td>{{ $assignmentevaluation->conveyance_request ??''}}</td>

                                </tr>
                                <tr>
                                    <td><b>Is file prepared as per the Documentation Policies & Standards? : </b></td>
                                    <td>{{ $assignmentevaluation->document_policies ??''}}</td>
                                    <td><b>Is file handed over to Record keeper? : </b></td>
                                    <td>{{ $assignmentevaluation->record_keeper ??''}}</td>

                                </tr>
                                <tr>
                                    <td><b>Choose Record Keeper : </b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')
                                ->where('id',$assignmentevaluation->staff_record_keeper)->first()->team_member ?? ''}}
                                    </td>
                                    <td><b>Name of the Team Leader who signed the file after Review : </b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')
                                ->where('id',$assignmentevaluation->team_leader_signed)->first()->team_member ?? ''}}
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>Choose the concerned Assignment Reporting Person : </b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')
                                ->where('id',$assignmentevaluation->assignment_report_manager)->first()->team_member ?? ''}}
                                    </td>
                                    @if(Auth::user()->role_id == 18 || Auth::user()->role_id == 11 || Auth::user()->teammember_id == $assignmentevaluation->assignment_report_manager)
                                    @if($assignmentevaluation->status == 1 )
                                    <td><b>Technical knowledge : </b></td>
                                    <td>{{ $assignmentevaluation->technical_knowledge ??''}}/10</td>
                                    @endif
                                    @endif
                                </tr>
                                @if(Auth::user()->role_id == 18 || Auth::user()->role_id == 11 || Auth::user()->teammember_id ==  $assignmentevaluation->assignment_report_manager || Auth::user()->teammember_id== $assignmentevaluation->createdby)
                                @if($assignmentevaluation->status == 1 )
                                <tr>
                                    <td><b>General Awareness : </b></td>
                                    <td>{{ $assignmentevaluation->general_awareness ??''}}/10</td>
                                    <td><b>Planning & Organizing : </b></td>
                                    <td>{{ $assignmentevaluation->planning_organizing ??''}}/10</td>
                                </tr>
                                <tr>
                                    <td><b>Job Management : </b></td>
                                    <td>{{ $assignmentevaluation->job_management ??''}}/10</td>
                                    <td><b>Written Communication : </b></td>
                                    <td>{{ $assignmentevaluation->written_communication ??''}}/10</td>
                                </tr>
                                <tr>
                                    <td><b>Verbal Communication : </b></td>
                                    <td>{{ $assignmentevaluation->verbal_communication ??''}}/10</td>
                                    <td><b>Teamwork : </b></td>
                                    <td>{{ $assignmentevaluation->teamwork ??''}}/10</td>
                                </tr>
                                <tr>
                                    <td><b>Motivation : </b></td>
                                    <td>{{ $assignmentevaluation->motivation ??''}}/10</td>
                                    <td><b>Maturity : </b></td>
                                    <td>{{ $assignmentevaluation->maturity ??''}}/10</td>
                                </tr>
                                <tr>
                                    <td><b>Time Consciousness : </b></td>
                                    <td>{{ $assignmentevaluation->time_consciousness ??''}}/10</td>
                                    <td><b>Problem Solving : </b></td>
                                    <td>{{ $assignmentevaluation->problem_solving ??''}}/10</td>
                                </tr>
                                <tr>
                                    <td><b>Documentation : </b></td>
                                    <td>{{ $assignmentevaluation->documentation ??''}}/10</td>
                                    <td><b>Quality of Work : </b></td>
                                    <td>{{ $assignmentevaluation->qualityofwork ??''}}/10</td>
                                </tr>
                                <tr>
                                    <td><b>Achievement of Tasks/Targets : </b></td>
                                    <td>{{ $assignmentevaluation->achievement_of_tasks_targets ??''}}/10</td>
                                    <td><b>Initiative Displayed : </b></td>
                                    <td>{{ $assignmentevaluation->initiative_displayed ??''}}/10</td>
                                </tr>
                                <tr>
                                    <td><b>Rate Over all Performance : </b></td>
                                    <td>{{ $assignmentevaluation->rate_over_all_performance_partner ??''}}/10</td>
                                    <td><b>Areas he/she Performed extremely well : </b></td>
                                    <td>{{ $assignmentevaluation->areas_performed_extremely ??''}}</td>
                                </tr>
                                <tr>
                                    <td><b>Areas he/she needs improvement : </b></td>
                                    <td>{{ $assignmentevaluation->areas_needs_improvement ??''}}</td>
                                    <td><b>Training Needs : </b></td>
                                    <td>{{ $assignmentevaluation->training_needs ??''}}</td>
                                </tr>
                                @endif
                                @endif
                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>


        </div>
        @if($assignmentevaluation->assignment_report_manager == Auth::user()->teammember_id)
        @if($assignmentevaluation->status == 0 )
        <div class="card-body">

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:800px;">
                <div class="card-body">
                    <form method="post" action="{{ route('assignmentevaluation.update', $assignmentevaluation->id)}}"
                        enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent
                      
                        <b style="font-weight: 800;font-size: 18px; ">Assessment of Team Head/Partner – Ratings ( 10
                            being the highest, 1 being the lowest)</b>
                       
                        <hr>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Technical knowledge</label>
                                    <select required class="form-control" name="technical_knowledge" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">General Awareness</label>
                                    <select class="form-control"  required name="general_awareness"  value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Planning & Organizing</label>
                                    <select class="form-control" required name="planning_organizing" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Job Management</label>
                                    <select class="form-control" required name="job_management" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Written Communication</label>
                                    <select class="form-control" required name="written_communication" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Verbal Communication</label>
                                    <select class="form-control key" required name="verbal_communication" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Teamwork</label>
                                    <select class="form-control key" required name="teamwork" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Motivation</label>
                                    <select class="form-control key" required name="motivation" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Maturity</label>
                                    <select class="form-control key" required name="maturity" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Time Consciousness</label>
                                    <select class="form-control key" required name="time_consciousness" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Problem Solving</label>
                                    <select class="form-control key" required name="problem_solving" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Documentation</label>
                                    <select class="form-control key" required name="documentation" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Quality of Work</label>
                                    <select class="form-control key" required name="qualityofwork" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Achievement of Tasks/Targets</label>
                                    <select class="form-control key" required name="achievement_of_tasks_targets" id="key"
                                        value="" id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Initiative Displayed</label>
                                    <select class="form-control key"required  name="initiative_displayed" id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Rate Over all Performance</label>
                                    <select  class="form-control key"
                                        name="rate_over_all_performance_partner" required id="key" value=""
                                        id="exampleFormControlSelect1">
										 <option value="">Please Select One</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Areas he/she Performed extremely well </label>
                                    <input type="text" required name="areas_performed_extremely" class="form-control"
                                        value="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Areas he/she needs improvement </label>
                                    <input type="text" required name="areas_needs_improvement" class="form-control"
                                        value="" />
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Training Needs </label>
                                    <input type="text" required name="training_needs" class="form-control" value="" />
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('assignmentevaluation') }}">
                                back</a>

                        </div>

                </div>
            </div>
            </form>

        </div>
        @endif
        @endif
    </div>

</div>



@endsection
