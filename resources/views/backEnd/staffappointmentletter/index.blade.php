<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('staffappointmentletter/create')}}">Add Staff Appointment Letter</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
                <a href="{{url('home')}}">
                    <h1 class="font-weight-bold" style="color:black;">Home</h1>
                </a>
                <small>Staff Appointment Letter List</small>
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
                <table id="exampleee" class="display nowrap">
                    <thead>
                        <tr>
							<th>Send for E-Verification</th>
                            <th>Team Member</th>  
							<th>Email</th>  
							<th>Status</th>  
                            <th>Appointment Letter Date</th>
                            <th>Designation</th>
                            <th>Employee Effective Date</th>
                            <th>Organization</th>
                            <th>Location</th>
                            <th>Salary ( Per Month )</th>
                            <th>Salary Remarks</th>
                            <th>Notice Period</th>
                            <th>Createdby</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffappointmentData as $staffappointmentDatas)
                        <tr>
                            <td>
                            @if($staffappointmentDatas->otp==null)
                            @if($staffappointmentDatas->e_verify==0)
                            <a href="{{url('staffappointmentletter/mailverify', $staffappointmentDatas->id)}}" class="btn btn-success">Send for E-Verification</a>
							
                            <!--<button id="button_1"  data-id="{{$staffappointmentDatas->id}}" class="button_1 btn btn-success">E-Verification</button>-->
                            @else
                            <span class="btn btn-success">Sent</span>
                            @endif
                            @else
                            <span class="badge badge-success">Acknowledged</span>
                
                            @endif
                            </td>
                         <td><a href="{{url('staffappointmentletter/view', $staffappointmentDatas->id)}}">{{$staffappointmentDatas->team_member }}({{ $staffappointmentDatas->rolename ??''}})</a></td>   
							<td>{{ $staffappointmentDatas->emailid ??''}}</td>
							<td> @if($staffappointmentDatas->otp==null)
                                <span class="badge badge-danger">Not Acknowledge</span>
								@elseif($staffappointmentDatas->otp==2)
                                <span class="badge badge-info">Auto Acknowledge</span>
                                @else
                                <span class="badge badge-success">Acknowledge</span>
                                @endif
                            </td>
                            <td> {{ date('F d,Y', strtotime($staffappointmentDatas->appointmentletterdate)) }}</td>
                            <td>{{$staffappointmentDatas->designation }}</td>
                            <td> {{ date('F d,Y', strtotime($staffappointmentDatas->employeeeffectivedate)) }}</td>
                            <td>{{$staffappointmentDatas->company_name }}</td>
                            <td>{{$staffappointmentDatas->location }}</td>
                            <td>{{$staffappointmentDatas->salary }}</td>
                            <td>{{$staffappointmentDatas->salaryremarks }}</td>
                            <td>{{$staffappointmentDatas->noticeperiod }}</td>
                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$staffappointmentDatas->createdby)->first()->team_member ?? ''}}</td>
                            <td>  <a href="{{route('staffappointmentletter.edit', $staffappointmentDatas->id)}}" title="Edit" class="btn btn-info">
                                <i class="far fa-edit"></i></a>
                            </td>
                           
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

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
        $('#exampleee').DataTable({
			"pageLength": 50,
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

