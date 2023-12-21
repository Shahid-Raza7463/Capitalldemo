<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
<nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('directapplication/create')}}">Add Applications</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>All Other Applications</small>
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
                <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
                            <th style="display: none;">id</th>
							   <th>Applied On</th>
                            <th> MRN/NRO/CRO/WRO NO.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Age</th>
                            <th>Scheme</th>
                            <th>Job Profile</th>
                            <th>Reference</th>
                         
                            <th>Resume</th>
							<th>Comment of HR</th>
                            <th>Interviewer 1</th>
                            <th>Interviewer 1 Rating</th>
                            <th>Interviewer 1 Feedback</th>
                            <th>Interviewer 2</th>
                            <th>Interviewer 2 Rating</th>
                            <th>Interviewer 2 Feedback</th>
                            @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                            <th>Status</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($other as $otherDatas)
                        @if($otherDatas->type == 1)
                        <tr>
                            <td style="display: none;">{{$otherDatas->sno }}</td>
							 <td>{{ date('F d,Y', strtotime($otherDatas->applied_on)) }} {{ date('h:i A', strtotime($otherDatas->applied_on)) }}</td>
                            <td>

                                @if(Auth::user()->role_id != 18)<a
                                    href="{{url('/otherdetails/'.$otherDatas->sno)}}">@endif
                                    {{$otherDatas->mrn_nro_cro_wro }}
                                    @if(Auth::user()->role_id == 18)</a>@endif
                                @if(Auth::user()->role_id == 18 || Auth::user()->teammember_id == 434)
                                <a class="btn btn-secondary" style="color: #F4F4F5" data-toggle="modal"
                                    style="color: green" id="editCompany" data-id="{{ $otherDatas->sno }}"
                                    data-target="#exampleModal12">
                                    <span class="fa fa-share"></span>
                                </a>
                                @endif
                            </td>
                            <td>{{$otherDatas->name }}</td>
                            <td>{{$otherDatas->email }}</td>
                            <td>{{$otherDatas->contact_no }}</td>
                            <td>{{$otherDatas->age }}</td>
                            <td>{{$otherDatas->scheme }}</td>
                            <td>{{$otherDatas->jobprofile ??''}}</td>
                            <td>{{$otherDatas->reference }}</td>
                           
                            <td><a target='blank'
                                    href="{{'backEnd/documents/directapplications/'.$otherDatas->resume ??'' }}">{{ str_ireplace('documents/job_applications/other/','',$otherDatas->resume) ??''  }}</a>
                            </td>
							<td>{{ $otherDatas->hrcomment ??''}}</td>
                            <td>{{$otherDatas->team_member ??''}} </td>
                            <td>
                                @if($otherDatas->ratingone != null) @for($i=0;$i<$otherDatas->
                                    ratingone;$i++)
                                    <span class="fa fa-star checked" style="color: #f90"></span>
                                    @endfor
                                    @endif
                            </td>
                            <td>{{$otherDatas->feedbackone ??''}} </td>
                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$otherDatas->interviewertwo)->first()->team_member ?? ''}}
                            </td>
                            <td>
                                @if($otherDatas->ratingtwo != null) @for($i=0;$i<$otherDatas->
                                    ratingtwo;$i++)
                                    <span class="fa fa-star checked" style="color: #f90"></span>
                                    @endfor
                                    @endif
                            </td>
                            <td>{{$otherDatas->feedbacktwo ??''}} </td>
                            @if(Auth::user()->role_id == 18)
                            <td>
                                @if($otherDatas->status == null)
                                <div class="btn-group mb-2 mr-1">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Choose Status
                                    </button>
                                    <div class="dropdown-menu">
                                        <a style="color: #37A000" class="dropdown-item"
                                            href="{{url('/otherstatusupdate?'.'sno='.$otherDatas->sno.'&&'.'status='.'1')}}">Shortlisted</a>
                                        <a style="color: #37A000" class="dropdown-item"
                                            href="{{url('/otherstatusupdate?'.'sno='.$otherDatas->sno.'&&'.'status='.'2')}}">Selected</a>
                                        <a style="color: #37A000" class="dropdown-item"
                                            href="{{url('/otherstatusupdate?'.'sno='.$otherDatas->sno.'&&'.'status='.'3')}}">On
                                            Hold</a>
                                        <a style="color: #37A000" class="dropdown-item"
                                            href="{{url('/otherstatusupdate?'.'sno='.$otherDatas->sno.'&&'.'status='.'4')}}">Rejected</a>
                                    </div>
                                </div>
                                @else

                                @if($otherDatas->status==3)
                                <span class="badge badge-pill badge-warning">On Hold</span>
                                @elseif($otherDatas->status==2)
                                <span class="badge badge-pill badge-success">Selected</span>

                                @elseif($otherDatas->status==1)
                                <span class="badge badge-pill badge-info">Shortlisted</span>

                                @elseif($otherDatas->status==4)
                                <span class="otherDatas badge-pill badge-danger">Rejected</span>

                                @endif

                                @endif
                            </td>
                            @endif
                            @if(Auth::user()->role_id == 11)
                            <td>
                                @if($otherDatas->status==3)
                                <span class="badge badge-pill badge-warning">On Hold</span>
                                @elseif($otherDatas->status==2)
                                <span class="badge badge-pill badge-success">Selected</span>

                                @elseif($otherDatas->status==1)
                                <span class="badge badge-pill badge-info">Shortlisted</span>

                                @elseif($otherDatas->status==4)
                                <span class="otherDatas badge-pill badge-danger">Rejected</span>

                                @endif
                            </td>
                            @endif
                        </tr>
                       
                       @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/forwardotherresume')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Forward Resume</h5>

                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row row-sm">

                        <div class="col-sm-6">
                            <label for="name" class="font-weight-600">Interviewer 1 :</label>
                            <select name="interviewerone" class="form-control">
                                <option value="">Please Select One</option>
                                @foreach($team as $teammemberData)
                                <option value="{{$teammemberData->id}}">
                                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} )</option>

                                @endforeach

                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="name" class="font-weight-600">Interviewer 2 :</label>
                            <select name="interviewertwo" class="form-control">
                                <option value="">Please Select One</option>
                                @foreach($team as $teammemberData)
                                <option value="{{$teammemberData->id}}">
                                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} )</option>

                                @endforeach

                            </select>
                            <input hidden id="sno" class="form-control" name="sno" type="number">
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Job Profile</label>
                                <input type="text" id="jobprofile" name="jobprofile" placeholder="Enter Job Profile"
                                    required class="form-control" />
                            </div>
                        </div>
                    </div>
					<br>
					  <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">HR Comment</label>
                                <input type="text" id="hrcomment" name="hrcomment" placeholder="Enter Comment"
                                    required class="form-control" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            //        debugger;
            var id = $(this).data('id');
            debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('otherresume') }}",
                data: "id=" + id,
                success: function (response) {
                    debugger;
                    $("#sno").val(response.sno);
                    $("#jobprofile").val(response.jobprofile);
					$("#hrcomment").val(response.hrcomment);
                    debugger;

                },
                error: function () {

                },
            });
        });
    });

</script>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function () {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });

</script>
