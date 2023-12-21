@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">

        <li> <a class="btn btn-secondary ml-2" href="{{ url('performanceevaluationform') }}">Back</a></li>
            <li> <a class="btn btn-success ml-2" href="{{route('performanceevaluationform.edit', $performanceevaluation->id)}}">Edit</a></li>
        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Audit Acceptance Checklist Details</small></a>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4><strong class="fs-30 font-weight-600 mb-0"
                                    style="color:rgb(0,31,95); line-height:10px;">K G SOMANI & CO. LLP</strong></h4>
                            <small style="color:rgb(0,31,95); font-size:12px;">
                                Formerly K G Somani & Co
                            </small><br><br>
                            <h4 style="color:green;" class="fs-24 font-weight-600 mb-0">PERFORMANCE EVALUATION FORM</h4>
                            <strong>
                                <h4 style="color:black;" class="fs-16 font-weight-600 mb-0">REVIEW PERIOD – April 2022
                                    to March 2023</h4>
                            </strong>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row row-sm ">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <fieldset class="form-group">
                                    <tbody>
                                        <tr>
                                            <td><b>Name</b></td>
                                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$performanceevaluation->teammember_ids)->first()->team_member ?? ''}}
                                            </td>
                                            <td><b>TEAM MANAGER/PARTNER</b></td>
                                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$performanceevaluation->partner_id)->first()->team_member ?? ''}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>DATE OF JOINING</b></td>
                                            <td>{{ date('F d,Y', strtotime($performanceevaluation->date_of_joining ??'')) }}
                                            </td>
                                            <td><b>DESIGNATION</b></td>
                                            <td>{{ $performanceevaluation->designation ??''}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>DEPARTMENT</b></td>
                                            <td>{{$performanceevaluation->department ??''}}</td>
                                            <td><b>DATE OF REVIEW</b></td>
                                                <td>{{ date('F d,Y', strtotime($performanceevaluation->date_of_review)) }}</td>
                                            </td>
                                        </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row row-sm ">
                        <div class="col-12"><br>
                            <h4 style="color:green;" class="fs-16 font-weight-600 mb-0">MEASUREMENT RATING CRITERIA</h4>
                            <h4 style="color:green; text-align:center;" class="fs-16 font-weight-600 mb-0">RATINGS
                                SCALES</h4>
                            <table class="table table-bordered">
                                <fieldset class="form-group">
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center;"><b>Rating Level</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>1 = Below Standards</b><br><br><br>
                                                Performance is below standards. Employee does not fully achieve assigned
                                                goals. Work assignments are not consistent in meeting quality standards
                                                or deadlines. Employee requires close supervision and does not
                                                consistently demonstrate the ability to perform job functions at
                                                expected level of proficiency.
                                            </td>
                                            <td><b>2 = Requires Improvement</b><br><br><br>

                                                Performance of some job requirements is unacceptable and does not
                                                achieve results expected by the department. Incidents of problem work
                                                performance are not typical in the class of work performed and
                                                improvement is required.

                                            </td>
                                            <td><b>3 = Meets Expectations</b><br><br><br>
                                                Satisfactorily performs assigned activities and achieves expected
                                                outcomes. Work assignments typically are completed and meet all quality
                                                standards. Employee works under general supervision, with demonstrated.
                                                understanding of all job functions and expected standards.
                                            </td>
                                            <td>
                                                <b>4 = Exceeds Requirements</b><br><br><br>
                                                Performance of job requirements exceeds established expectations or
                                                requirements for quality, quantity, and timeliness; and while
                                                performance at this level can still be improved, and employee at this
                                                level exceeds the performance expected of a fully capable employee in
                                                most aspects of job performance.

                                            </td>
                                            <td>
                                                <b>5 = Superior</b><br><br><br>
                                                Performance of job requirements noticeably exceed established
                                                expectations and standards for quality, quantity and timeliness:
                                                outcomes are well above fully competent performance; performs more than
                                                asked explores improved methods of accomplishing tasks, and small room
                                                for improvement.

                                            </td>
                                        </tr>

                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm ">
                        <div class="col-12"><br>
                            <table class="table table-bordered">
                                <fieldset class="form-group">
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center;"><b>Section I - Key Responsibility
                                                    Areas</b></td>

                                        </tr>
                                    </tbody>
                            </table>
                            <h4 style="color:green;" class="fs-16 font-weight-600 mb-0">
                                List down the Key responsibility Areas and the outcome or achievements linked with those
                                KRAs. Employees to mention the Key Responsibilities, outcome/achievements linked with
                                those KRAs and give self-rating.
                                (Important Note - </h4><span>Be specific and use numbers only while mentioning the
                                outcomes for your Business Development/Marketing Targets etc. Take note of your
                                achievements throughout the year)
                            </span>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm ">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tr style="background: #37A000;color:#F4F4F5;">
                                    <th>Sr.No</th>
                                    <th>KEY RESPONSIBILITY</th>
                                    <th>OUTCOME/ACHIEVEMENT</th>
                                    <th>SELF RATING </th>
                                    <th>REPORTING MANAGER/PARTNER’S RATING </th>
                                </tr>
                                <tbody>
                                    @php
                                    $performanceData = DB::table('perfomancesectionone')
                                    ->where('performance_eva_id',$performanceevaluation->id)->get();
                                    $performancecount = DB::table('perfomancesectionone')
                                ->where('performance_eva_id',$performanceevaluation->id)->count();
                                    // dd($performanceData);
                                    $i=1;
                                    $sum=0;
                                    @endphp
                                    @foreach($performanceData as $performanceDatas)
                                    @php
                                       $sum=$sum+$performanceDatas->reporting_rating ;
                                    @endphp
                                    <tr>
                                        <td>
                                            <small>{{$i++}}</small>
                                        </td>
                                        <td>{{$performanceDatas->key_responsibility ??''}}</td>
                                        <td>{{$performanceDatas->outcome_achievement ??''}}</td>
                                        <td>{{$performanceDatas->self_rating ??''}}</td>
                                        <td>{{$performanceDatas->reporting_rating ??''}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    @php
						//dd($performancecount);
						if($performancecount==0)
						{
                    $ratingsedata = 0;
						}
						else
						{
						$ratingsedata=($sum/$performancecount);
						}
						
                  //  dd($ratingsedata);
                    @endphp
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <h4 class="fs-16 font-weight-600 mb-0">
                                    (FOR REPORTING PARTNERS) - Section I = Total Rating : &nbsp;
                                    {{round($ratingsedata) ??''}}&nbsp;
                                    <small>(Add “Final Ratings” for each responsibility, then divide by total number of
                                        Key Responsibilities)
                                    </small>
                                </h4>
                            </div>
                        </div>
                    </div>
						
						<br>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Employee’s Comments on KRAs/achievements (If
                                    any):</label>
                                <textarea type="text" readonly name="employee_kra_achievement"
                                    placeholder="Enter Employee’s Comments on KRAs/achievements (If any):" value=""
                                    class="form-control">{{$performanceevaluation->employee_kra_achievement ??''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Supervisor’s Comments on KRAs/ achievements (If
                                    any):</label>
                                <textarea type="text" readonly name="supervisor_kra_achievement"
                                    placeholder="Enter Supervisor’s Comments on KRAs/ achievements (If any):" value=""
                                    class="form-control">{{$performanceevaluation->supervisor_kra_achievement ??''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm ">
                        <div class="col-12"><br>
                            <table class="table table-bordered">
                                <fieldset class="form-group">
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center;"><b>SECTION II - PERFORMANCE
                                                    FACTORS</b></td>

                                        </tr>
                                    </tbody>
                            </table>
                            <h4 class="fs-16 font-weight-600 mb-0">
                                The following factors are important indicators of the skills and abilities an employee
                                brings to the performance of his or her duties. In addition to evaluating key
                                responsibilities and performance objectives, these performance factors help to assess
                                total performance
                                <br><br>
                                Self-rating may be given by the employees, The supervisor rates the degree – <br>
                                1. Below Standards/Expectations<br>
                                2 Requires Improvement <br>
                                3 Meets Expectations <br>
                                4. Exceeds Expectations <br>
                                5. Superior
                            </h4>

                        </div>
                    </div>
                    <br>
                    <div class="row row-sm ">
                        <div class="col-12"><br>
                            <table class="table table-bordered">
                                <fieldset class="form-group">
                                    <tbody>
                                        <tr>
                                            <td><b>Performance Factors</b></td>
                                            <td><b>Applies</b></td>
                                            <td><b>Not Applicable</b></td>
                                            <td><b>Self -Rating</b></td>
                                            <td><b>Supervisor Rating</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    PROFICIENCY IN CURRENT ROLE:</b><br><br>
                                                <span>
                                                    • Demonstrates knowledge of position and/or team role.<br>
                                                    • Understands how position and responsibilities fit within the
                                                    &nbsp;&nbsp;&nbsp;organization and contribute to department results.
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="proficiency_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->proficiency_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="proficiency_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->proficiency_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="proficiency_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->proficiency_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="proficiency_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->proficiency_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    QUALITY OF WORK:</b><br><br>
                                                <span>• Maintains standards consistently. Is consistent in achieving
                                                    accuracy.<br>
                                                    • neatness, thoroughness, overall effectiveness and attentiveness to
                                                    detail.

                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="quality_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->quality_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="quality_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->quality_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="quality_self_rating"
                                                    placeholder="Enter Self Rating"
                                                    value="{{$performanceevaluation->quality_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="quality_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->quality_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    QUANTITY OF WORK:</b><br><br>
                                                <span>
                                                    • Produces expected volume of work in a timely manner.
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="quantity_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->quantity_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="quantity_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->quantity_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="quantity_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->quantity_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="quantity_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->quantity_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    PLANNING AND ORGANIZATION OF WORK:</b><br><br>
                                                <span>
                                                    • Establishes priorities. Anticipates and prepares for changing
                                                    workload or working conditions.<br>
                                                    • Coordinates and uses available resources to get work done to
                                                    assure important deadlines are met.
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="planning_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->planning_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="planning_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->planning_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="planning_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->planning_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="planning_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->planning_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    INITIATIVE:</b><br><br>
                                                <span>
                                                    • Shows ability to work independently in context of the job.<br>
                                                    • Demonstrates willingness to assume additional responsibility.<br>
                                                    • Suggests ways to enhance work processes or operations.
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="initiative_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->initiative_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="initiative_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->initiative_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="initiative_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->initiative_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="initiative_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->initiative_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    INTERPERSONAL RELATIONS:</b><br><br>
                                                <span>
                                                    • Maintains positive working relationships.<br>
                                                    • Is flexible and willing to cooperate with others.<br>
                                                    • Demonstrates ability to listen and understand.

                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="interpersonal_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->interpersonal_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="interpersonal_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->interpersonal_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="interpersonal_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->interpersonal_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="interpersonal_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->interpersonal_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    VERBAL & LISTENING SKILLS:</b><br><br>
                                                <span>
                                                    • Expresses self well verbally, using language appropriate for the
                                                    intended audience.<br>
                                                    • Listens actively and acknowledges understanding.

                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="verbal_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->verbal_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="verbal_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->verbal_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="verbal_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->verbal_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="verbal_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->verbal_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    WRITING SKILLS:</b><br><br>
                                                <span>
                                                    • Presents ideas clearly in written format, using appropriate
                                                    language, grammar and style.
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="writing_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->writing_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="writing_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->writing_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="writing_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->writing_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="writing_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->writing_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    TEAM PARTICIPATION:</b><br><br>
                                                <span>
                                                    • Proactively builds partnerships and seeks involvement with other
                                                    constituencies/employees & Works cooperatively and effectively with
                                                    team members.<br>
                                                    • Demonstrates clear understanding of team goals and contributes to
                                                    their achievement.
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="team_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->team_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="team_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->team_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="team_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->team_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="team_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->team_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    DISCRETION AND CONFIDENTIALITY</b><br><br>
                                                <span>
                                                    • Demonstrates ability to maintain sensitive information in
                                                    confidence, sharing only with appropriate contacts.
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="discretion_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->discretion_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="discretion_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->discretion_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="discretion_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->discretion_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="discretion_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->discretion_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    PEOPLE MANAGEMENT/TEAM MANAGEMENT</b><br><br>

                                            </td>
                                            <td><input type="text" readonly name="people_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->people_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="people_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->people_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="people_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->people_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="people_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->people_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    LEVEL OF EFFORTS</b><br><br>
                                                <span>
                                                    • Is self-motivated and maintains effort despite obstacles and
                                                    setback
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="level_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->level_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="level_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->level_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="level_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->level_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="level_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->level_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    COMMITMENT TO SERVICE</b><br><br>
                                            </td>
                                            <td><input type="text" readonly name="commitment_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->commitment_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="commitment_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->commitment_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="commitment_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->commitment_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="commitment_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->commitment_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>PUNCTUALITY AND ATTENDANCE:</b><br><br>
                                                <span>
                                                    • Arrives and is ready to begin working at scheduled time.<br>
                                                    • Maintains acceptable record of attendance.
                                                </span>
                                            </td>
                                            <td><input type="text" readonly name="punctuality_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->punctuality_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="punctuality_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->punctuality_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="punctuality_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->punctuality_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="punctuality_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->punctuality_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TECHNICAL SKILLS</b><br><br>
                                            </td>
                                            <td><input type="text" readonly name="technical_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->technical_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="technical_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->technical_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="technical_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->technical_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="technical_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->technical_supervison_rating ??''}}"
                                                    class="form-control"></td>

                                        </tr>
@php
$propdata = get_object_vars($performanceevaluation);
$count = 0;
foreach ($propdata as $propdatas => $value) {
    if ($value !== null) {
        $count++;
    }
}
@endphp
@php
$propdata = ['proficiency_supervison_rating', 'quality_supervison_rating', 'quantity_supervison_rating', 'planning_supervison_rating',
          'initiative_supervison_rating', 'interpersonal_supervison_rating', 'verbal_supervison_rating', 'writing_supervison_rating',
          'team_supervison_rating', 'discretion_supervison_rating', 'people_supervison_rating', 'level_supervison_rating',
          'commitment_supervison_rating', 'punctuality_supervison_rating', 'technical_supervison_rating'];
$count = 0;
foreach ($propdata as $propdatas) {
    if ($performanceevaluation->$propdatas !== null) {
        $count++;
    }
}
@endphp
@php
$totalsum=($performanceevaluation->proficiency_supervison_rating)+($performanceevaluation->quality_supervison_rating)
+($performanceevaluation->quantity_supervison_rating)+($performanceevaluation->planning_supervison_rating)
+($performanceevaluation->initiative_supervison_rating)+($performanceevaluation->interpersonal_supervison_rating)
+($performanceevaluation->verbal_supervison_rating)+($performanceevaluation->writing_supervison_rating)
+($performanceevaluation->team_supervison_rating)+($performanceevaluation->discretion_supervison_rating)
+($performanceevaluation->people_supervison_rating)+($performanceevaluation->level_supervison_rating)
+($performanceevaluation->commitment_supervison_rating)+($performanceevaluation->punctuality_supervison_rating)
+($performanceevaluation->technical_supervison_rating);
//dd($totalsum);
@endphp
@php
$persectionration=($totalsum/$count);
//dd($persectionration);
@endphp
@php
$totalsumrating=($performanceevaluation->proficiency_self_rating)+($performanceevaluation->quality_self_rating)
+($performanceevaluation->quantity_self_rating)+($performanceevaluation->planning_self_rating)
+($performanceevaluation->initiative_self_rating)+($performanceevaluation->interpersonal_self_rating)
+($performanceevaluation->verbal_self_rating)+($performanceevaluation->writing_self_rating)
+($performanceevaluation->team_self_rating)+($performanceevaluation->discretion_self_rating)
+($performanceevaluation->people_self_rating)+($performanceevaluation->level_self_rating)
+($performanceevaluation->commitment_self_rating)+($performanceevaluation->punctuality_self_rating)
+($performanceevaluation->technical_self_rating);
//dd($totalsum);
@endphp

                                        <tr>
                                            <td><b>Total</b><br><br>
                                            </td>
                                            <td><input type="text" readonly name="total_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->total_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text" readonly name="total_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->total_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="total_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{round($totalsumrating) ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="total_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{round($totalsum) ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <h4 class="fs-16 font-weight-600 mb-0">
                                    (FOR REPORTING PARTNERS) Section II - Total Rating :&nbsp;
                                    
                                        {{round($persectionration) ??''}}&nbsp;
                                    <small>(Add “Final/Supervisors Ratings” for each factor, then divide by total number
                                        of factors applied)
                                    </small>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Employee’s Comments on Performance Factors (If
                                    any):</label>
                                <textarea type="text" readonly name="employee_factors"
                                    placeholder="Enter Employee’s Comments on Performance Factors (If any)" value=""
                                    class="form-control">{{$performanceevaluation->employee_factors ??''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Supervisor’s Comments on Performance Factors (If
                                    any):</label>
                                <textarea type="text" readonly name="supervisor_factors"
                                    placeholder="Enter Supervisor’s Comments on Performance Factors (If any)" value=""
                                    class="form-control">{{$performanceevaluation->supervisor_factors ??''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm ">
                        <div class="col-12"><br>
                            <table class="table table-bordered">
                                <fieldset class="form-group">
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center;"><b>Section III - DEVELOPMENT
                                                    GOALS (To be filled by REPORTING PARTNERS)</b></td>

                                        </tr>
                                    </tbody>
                            </table>
                            <h4 class="fs-16 font-weight-600 mb-0">
                                This section should include the development goals which are to be achieved in the future
                                performance. These may include formal training or education courses, temporary project
                                assignments or mentoring programs, enhancement on any specific performance factor. This
                                should include an assessment of how much a priority the development goal is: (C) =
                                Critical; (M) = Moderate; and (VA) = Value Added.
                            </h4>

                        </div>
                    </div>
                    <br>
                    <div class="row row-sm ">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tr style="background: #37A000;color:#F4F4F5;">
                                    <th>Sr.No</th>
                                    <th>Development Goals/Purpose</th>
                                    <th>Priority</th>

                                </tr>
                                <tbody>
                                    @php
                                    $performancepartData = DB::table('performancesectionthrees')
                                    ->where('performance_eva_id', $performanceevaluation->id)->get();

                                    $i=1;
                                    @endphp
                                    @foreach($performancepartData as $performancepartDatas)
                                    <tr>
                                        <td>
                                            <small>{{$i++}}</small>
                                        </td>
                                        <td>{{$performancepartDatas->development ??''}}</td>
                                        <td>{{$performancepartDatas->priority ??''}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm ">
                        <div class="col-12"><br>
                            <table class="table table-bordered">
                                <fieldset class="form-group">
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center;"><b>Section IV - OVERALL
                                                    PERFORMANCE RATING (To be filled by REPORTING PARTNERS only)</b>
                                            </td>
                                        </tr>
                                    </tbody>
                            </table>
                            <h4 class="fs-16 font-weight-600 mb-0">
                                Enter the Total Ratings for KRAs (Section I) and Performance Factors (Section II). Add
                                the Total Ratings and divide the sum by 2 to calculate the Overall Rating.
                            </h4>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm ">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><b></b></td>
                                        <td><b>Total Rating</b></td>
                                    </tr>
                                    @php
									if($performancecount!=0)
									{
                                    $totalsect=($sum/$performancecount);
									}
									else
									{
									$totalsect=0;
									}
                                    @endphp
                                    <tr>
                                        <td><b>(a) Section I: Key Responsibilities (Section I)</b></td>
                                        <td><input type="number" readonly name="resp_applicable"
                                                placeholder="Enter Not Applicable"
                                                value="{{ round($totalsect) }}"
                                                class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>(b) Section II: Performance Factors (Section II) (b)</b></td>
                                        <td><input type="number" readonly name="performance_factor"
                                                placeholder="Enter Not Applicable"
                                                value="{{ round($persectionration) }}"
                                                class="form-control"></td>
                                    </tr>
                                    @php
                                       $totalsumData=round($totalsect)+$persectionration;
                                       //dd($totalsumData);
                                    @endphp
                                    <tr>
                                        <td><b>SUBTOTAL:<br></b>
                                            <span>Add lines (a) and (b)</span>
                                        </td>
                                        <td><input type="number" readonly name="subtotal"
                                                placeholder="Enter Not Applicable"
                                                value="{{ round($totalsumData) }}" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>OVERALL RATING
                                                Divide line (c) by 2
                                            </b>
                                        </td>
                                       
                                       @php
                                       $totaldatar=($totalsumData/2);
                                       //dd($totaldatar);
                                    @endphp
                                        <td><input type="number" readonly name="overall_rating"
                                                placeholder="Enter Not Applicable"
                                                value="{{round($totaldatar) ??''}}"
                                                class="form-control"></td>
									</tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <h4 class="fs-16 font-weight-600 mb-0">
                                    NAME OR SIGNATURE OF THE PARTNER REVIEWED &nbsp;&nbsp;&nbsp;
            <input type="text" readonly name="name_of_signature" placeholder="" value="{{$performanceevaluation->name_of_signature ??''}}"
                class="form">
                                </h4>
                            </div>
                        </div>
                    </div>

                    <br>


                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
@endsection
