 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
  <link href="{{url('backEnd/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
  
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
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


   
<div class="body-content">



<div class="card mb-2">
        <div class="card-header">
            <form id="formevv">

            @php
								$teammember=App\Models\Teammember::join('roles','roles.id','teammembers.role_id')
                                ->where('status','!=',0)
                                ->where('team_member','!=',NULL)->select('teammembers.*','roles.rolename')->get();
								
                                $client=App\Models\Client::where('client_name','!=',NULL)->get();
                           //    dd($client);
                               
                                @endphp
							

               <div class="row row-sm">
                <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Client Name </label>
                            <select required class="language form-control"  multiple="" name="client[]" id="clientev">
                    
                    <option value="">Please Select One</option>
                    @foreach($client as $clientData)
                    <option value="{{$clientData->id}}">
                        {{ $clientData->client_name }}</option>

                    @endforeach

                  </select>

                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                        <label class="font-weight-600">Assignment Name *</label>
                <select required class="language form-control"  multiple="" name="assignment[]"  id="assignmentev">
					<option value="">Please Select One</option>
                    @foreach($assignment as $assignmentData)
                    <option value="{{$assignmentData->id}}">
                        {{ $assignmentData->assignment_name }}</option>

                    @endforeach

                   
                     </select>

                        </div>
                    </div>
                    <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>
                <select class="language form-control"  multiple="" id="partnerev" name="partner[]"> 
					
					<option value="">Please Select One</option>
                    @foreach($partner as $partnerData)
                    <option value="{{$partnerData->id}}">
                        {{ $partnerData->team_member }}</option>

                    @endforeach

                </select>
            </div>
        </div>
                    <div class="col-3">
                    <div class="form-group">
                    <label class="font-weight-600">Employee Name</label>
                    <select class="language form-control"  multiple="" id="employeeev" name="employeeid[]">
                    
                    <option value="">Please Select One</option>
                    @foreach($employeename as $employeeData)
                    <option value="{{$employeeData->id}}">
                        {{ $employeeData->team_member }}</option>

                    @endforeach

                  </select>
                        </div>
                    </div>
                     
                    <div class="col-3">
                        <div class="form-group">
                        <label class="font-weight-600">Status </label>
                        <select  class="form-control" name="" id="status">
                            <option value="">Select One</option>
                            <option value="3">Assignment Evaluation Created</option>
                            <option value="4">Not Submitted</option>
                            <option value="0">Pending for Evaluation</option>
                            <option value="1">Evaluated</option>
                   
                   
                        </select>
                    </div>
                    </div>


                   


                 
</div>
</div>
</div>


    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table id="example"  class="table display table-bordered table-striped table-hover">
                    <thead>
                    <tr><th>ID</th>
                             <th>Employee Name</th>
                             <th>Role</th>
                             <th >Status</th>
                             <th >Client’s name</th> 
                            <th >Assignment Name</th>
							<th >Assignment Generate Id</th>
                            <th>Partner</th>
                              <!--  <th >Start Date Of Assignment</th> -->
                            <th>End Date Of Assignment</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach($assignmentDa as $assignmentDatas)
                        <tr>
                        <td>AV00{{$assignmentDatas->id}}</td>
                        <td><a href="{{url('view/assignmentevaluation/'.$assignmentDatas->id)}}"> {{ App\Models\Teammember::select('team_member')
                            ->where('id',$assignmentDatas->createdby)->first()->team_member ?? ''}}</td>
                           <td>{{$assignmentDatas->rolename ??''}}</td> 
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
                        <td> {{ $assignmentDatas->client_name }}</td>
                           <td> {{ $assignmentDatas->assignment_name }}</td>
							<td>{{$assignmentDatas->assignmentgenerate_id ??''}}</td>
                            <td>{{$assignmentDatas->partner_team_member ??''}}</td>
                         <!--   <td > {{ date('F d,Y', strtotime($assignmentDatas->start_date_of_assignment)) }}</td>-->
                            <td> {{ date('F d,Y', strtotime($assignmentDatas->end_date_of_assignment)) }}</td>
                         
                    </tr>
                    @endforeach
                 </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->

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
    