
@extends('client.layouts.layout') @section('client_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    {{-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('task/create')}}">Add task</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav> --}}
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Action Tracker Database List</small>
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
                            <th>Audit Ref</th> 
                            <th>Audit Report</th> 
                            <th>Report Year</th> 
                            <th style="background: red;color:white;">Report Rating</th> 
                            <th>Report Issue Date</th> 
                            <th>Year Month</th> 
                            <th>Finding Ref</th> 
                            <th>Finding</th> 
                            <th>Sub Action</th> 
                            <th>Finding Description</th> 
                            <th>Finding Rating</th> 
                            <th>Recommendation</th> 
                            <th>Management Action</th> 
                            <th>Responsible Owner</th> 
                            <th>Entity</th> 
                            <th>Business Unit</th> 
                            <th>Due Date</th> 
                            <th>Extended Date</th> 
                            <th>No Extensions</th> 
                            <th>Status</th> 
                            <th style="padding-right: 300px;">Management Update</th> 
                            <th>Update provided</th> 
                            <th>Date of last update</th> 
                            <th>Reporting Month</th> 
                            <th>Ageing against original due date</th> 
                            <th>Internal Audit Comment</th> 
                            <th>Date Closed</th> 
                            <th>Closed YearMonth</th> 
                            <th>Reason for closure</th> 
                            <th>Management Sign Off Provided</th> 
                            <th>Management Sign Off Link</th> 
                            <th>Supporting Evidence</th> 
                            <th>Internal Audit Assessor</th> 
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach($internalauditData as $internalauditData)
                        <tr>
                            <td>{{$internalauditData->Audit_Ref }}</td>
                            <td>{{$internalauditData->Audit_Report }}</td>
                            <td>{{$internalauditData->Report_Year }}</td>
                            <td style="background: red;color:white;">{{$internalauditData->Report_Rating }}</td>
                            <td>{{$internalauditData->Report_Issue_Date }}</td>
                            <td>{{$internalauditData->YearMonth }}</td>
                            <td style="color:red;">{{$internalauditData->Finding_Ref }}</td>
                            <td style="color:red;">{{$internalauditData->Finding }}</td>
                            <td>{{$internalauditData->Sub_Action }}</td>
                            <td>{{$internalauditData->Finding_Description }}</td>
                            @if($internalauditData->Finding_Rating == "High")
                            <td style="background:#ffc500;color:white;">High</td>
                            @elseif($internalauditData->Finding_Rating == "Critical")
                            <td style="background:red;color:white;">Critical</td>
                            @elseif($internalauditData->Finding_Rating == "Medium")
                            <td style="background:yellow;">Medium</td>
                            @elseif($internalauditData->Finding_Rating == "Low")
                            <td style="background:green;color:white;">Low</td>
                            @else
                            <td style="background:#F4F4F5;color:white;">N/A</td>
                            @endif
                            <td>{{$internalauditData->Recommendation }}</td>
                            <td>{{$internalauditData->Management_Action }}</td>
                            <td>{{$internalauditData->Responsible_Owner }}</td>
                            <td>{{$internalauditData->Entity }}</td>
                            <td>{{$internalauditData->Business_Unit }}</td>
                            <td>{{$internalauditData->Due_Date }}</td>
                            <td>{{$internalauditData->Extended_Date }}</td>
                            <td>{{$internalauditData->No_Extensions }}</td>
                            <td>
                                <select onchange="change(event , {{$internalauditData->id}},'Status')" style="width: 180px;">
                                    <option {{$internalauditData->Status == "Closed - Completed"? "selected":""}} >Closed - Completed</option>
                                    <option {{$internalauditData->Status == "Open - Extended"? "selected":""}} >Open - Extended</option>
                                    <option {{$internalauditData->Status == "Overdue"? "selected":""}} >Overdue</option>
                                    <option {{$internalauditData->Status == "Closed - No longer relevant"? "selected":""}} >Closed - No longer relevant</option>
                                    <option {{$internalauditData->Status == "Risk Accepted"? "selected":""}} >Risk Accepted</option>
                                    <option {{$internalauditData->Status == "Open - On Track"? "selected":""}} >Open - On Track</option>
                                </select>
                            </td>
                            <td>{{$internalauditData->Management_Update }}</td>
                            <td>{{$internalauditData->Update_provided }}</td>
                            <td>{{$internalauditData->Date_of_last_update }}</td>
                            <td>{{$internalauditData->Reporting_Month }}</td>
                            <td>{{$internalauditData->Ageing_against_original_due_date }}</td>
                            <td>{{$internalauditData->Internal_Audit_Comment }}</td>
                            <td>{{$internalauditData->Date_Closed }}</td>
                            <td>{{$internalauditData->Closed_YearMonth }}</td>
                            <td>{{$internalauditData->Reason_for_closure }}</td>
                            <td>{{$internalauditData->Management_Sign_Off_Provided }}</td>
                            <td>{{$internalauditData->Management_Sign_Off_Link }}</td>
                            <td>{{$internalauditData->Supporting_Evidence }}</td>
                            <td>{{$internalauditData->Internal_Audit_Assessor }}</td>
						
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

<script type="text/javascript">
    function change(event,id,column)
    {
        $.ajax({
            type: "POST",
            data: {
                'value' : event.currentTarget.value,
                'column' : column,
                _token : "{{ csrf_token()}}",
            },
            url: "{{ url('/client/actiontracker/change') }}"+"/"+id,
            success: function(result){
                alert(result.data);
            }
        });
    }
</script>

@endsection


