@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			 @if($recruitmentform->status=='0')
            <li class="breadcrumb-item"><a href="">Edit
                RecruitmentForm</a></li>
			    @endif
			<li> <a class="btn btn-primary" href="{{ url('recruitmentform') }}">
        back</a></li>

        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
               <a href="{{route('recruitmentform.edit', $recruitmentform->id)}}"> <small>RecruitmentForm
                    Details</small></a>
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:420px;">
                <div class="card-body">
                  
                    <br><br>
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Category : </b></td>
                                    <td>{{ $recruitmentform->categoryname}}</td>
                                    <td><b>Required Experience : </b></td>
                                    <td>{!! $recruitmentform->required_experience !!}</td>
                                </tr>
                                <tr>
                                    <td><b>Required for Client  : </b></td>
                                    <td>@foreach($recruitmentclient as $recruitmentclients)   <span style="font-size: 12px;" class="badge badge-info">
                                        {{ $recruitmentclients->client_name }} </span>,
                                   @endforeach</td>
                                    <td><b>Required for Assignment/Project  : </b></td>
                                    <td>{!! $recruitmentform->assignment_project !!}</td>

                                </tr>

                                <tr>
                                    <td><b>Number ofvacancies: </b></td>
                                    <td>{{ $recruitmentform->number_of_vacancies}}</td>
                                    <td><b>Timeline  : </b></td>
                                    <td>{{ date('F d,Y', strtotime($recruitmentform->timeline)) }}</td>

                                </tr>
                                <tr>
                                    <td><b>Priority : </b></td>
                                    <td>{{ $recruitmentform->priority}}</td>
                                    <td><b>Detailed Job Profile : </b></td>
                                    <td>{{$recruitmentform->detailed_Job_profile}}</td>

                                </tr>
                                <tr>
                                    <td><b>Any Specific Skills Required : </b></td>
                                    <td>{{ $recruitmentform->specific_skills }}</td>
                                    @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                    <td><b>Status  : </b></td>
                                    <td>@if($recruitmentform->status==0)
                                    <span class="badge badge-pill badge-success">Open</span>
                                    @elseif($recruitmentform->status==1)
                                    <span class="badge badge-danger">Close</span>
                                    @elseif($recruitmentform->status==2)
                                    <span class="badge badge-warning">Hold</span>
                                    @endif</td>
                                    @endif

                                </tr>
                                <tr>
                                    <td><b>Name of Approving Authority  : </b></td>
                                    @php
                                    $recruitmentformData = DB::table('recruitmentforms')
                                    ->leftjoin('teammembers','teammembers.id','recruitmentforms.teammember_id')
                  ->where('recruitmentforms.id',$recruitmentform->id)->select('recruitmentforms.*','teammembers.team_member')->get();
                  
                         @endphp
                             <td>@foreach($recruitmentformData as $recruitmentformData) {{ $recruitmentformData->team_member ??''}}
                             @endforeach
                             </td>
                                   
                                    <td><b>Createdby : </b></td>
                                     <td>{{ App\Models\Teammember::select('team_member')->where('id',$recruitmentform->createdby)->first()->team_member ?? ''}}</td>

                                </tr>
                                <tr>
                                    @if(Request::is('view/*'))
                                    @if(Auth::user()->teammember_id == $recruitmentform->teammember_id || Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                    @if($recruitmentform->status=='0')
                                    <td><b>Action :</b></td>
                                    <td>  
                                        <div class="row">
                                          
                                    <form method="post" action="{{ route('recruitmentform.update', $recruitmentform->id)}}"  enctype="multipart/form-data">
                                        @method('PATCH') 
                                        @csrf   
                                    <button type="submit" class="btn btn-success" > On hold</button>
                                    <input type="text" hidden id="example-date-input" name="Status" value="2" class="form-control"
                                    placeholder="Enter Location">
                                    </form>
                                    <form method="post" action="{{ route('recruitmentform.update', $recruitmentform->id)}}"  enctype="multipart/form-data">
                                        @method('PATCH') 
                                        @csrf 
                                    <button style="margin-left:11px;" type="submit" class="btn btn-danger" > Closed</button>
                                    <input hidden type="text" id="example-date-input" name="Status" value="1" class="form-control"
                                    placeholder="Enter Location">
                                </form>
                           
                                    </div>
                                    </td>
                                    @endif
                                    @endif
                                    @endif
                                </tr>
                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>


        </div>
    </div>

</div>
@endsection
