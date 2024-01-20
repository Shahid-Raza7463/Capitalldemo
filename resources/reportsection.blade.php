<!-- <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet"> -->

<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
      
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-green mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="" style="color:white;" onClick="window.location.reload();">Reset Filters</a>
            </li>
           <!-- <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Upload File</a></li>
            <li class="breadcrumb-item active">+</li>-->
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Report Section </small>
                    
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
        <div class="card-header">
        <form id="formselect">

                <div class="row row-sm">
                <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Client Name </label>
                            <select required class="language form-control"  multiple="" name="client[]" id="client">
                    
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
                <select required class="language form-control"  multiple="" name="assignment[]"  id="assignment">
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
                <select class="language form-control"  multiple="" id="partner" name="partner[]"> 
					
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
                    <select class="language form-control"  multiple="" id="employee" name="employeeid[]">
                    
                    <option value="">Please Select One</option>
                    @foreach($employeename as $employeeData)
                    <option value="{{$employeeData->id}}">
                        {{ $employeeData->team_member }}</option>

                    @endforeach

                  </select>
                        </div>
                    </div>
                    <div class="col-6">
                    <div class="form-group">
                    <label class="font-weight-600">Work Item</label>
                    <input class="language form-control" id="workitem" name="">
                    
                    
                
                        </div>
                    </div>
                    
                    <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Billable Status</label>
                <select required class="form-control key" id="billable" name="billable_status">
                    <option value="">Please Select One</option>
                    <option value="Billable">Billable</option>
                    <option value="Non Billable">Non Billable</option>

                </select>
            </div>
        </div>
					  <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600"> Type</label>
                <select required class="form-control key" id="type" name="type">
                    <option value="">Please Select One</option>
                    <option value="Yearly">Yearly</option>
                    <option value="Monthly">Monthly</option>
					<option value="Quarterly">Quarterly</option>
					<option value="Custom Date">Custom Date</option>

                </select>
            </div>
        </div>
					<div class="col-3" id="year" style="display:none;">
                        <div class="form-group">
                            <label class="font-weight-600">Select Year *</label>
                           <select required class="language form-control"   id="yearly" name="yearly" 
                        @if(Request::is('timesheet/search'))> 
  						 <option value="">Select one</option>
                        
                        @foreach($years as $year )
                        <option value="{{$monthData->month}}">
                            {{ $year }}</option>
                        @endforeach
                        
    
                        @else
						<option value="">Select one</option>
                        @foreach($years as $year)
                        <option value="{{$year}}">
                            {{ $year }}
                        </option>

                        @endforeach
                        @endif
                    </select>
                        </div>
                  
                    </div>
                   
					 <div class="col-3" id="quarterly"  style="display:none;">
            <div class="form-group">
                <label class="font-weight-600">Quarterly</label>
                <select required class="form-control key" id="quarter" name="quarter">
                    <option value="">Please Select One</option>
                    <option value="Q1">Q1</option>
                    <option value="Q2">Q2</option>
					<option value="Q3">Q3</option>
					<option value="Q4">Q4</option>

                </select>
            </div>
        </div>

        <div class="col-3" id="month"  style="display:none;">
            <div class="form-group">
                <label class="font-weight-600">Month </label>
                <select required class="form-control key" id="month" name="month">
                <option value=''>--Select Month--</option>
            <option  value='1'>Janaury</option>
            <option value='2'>February</option>
            <option value='3'>March</option>
            <option value='4'>April</option>
            <option value='5'>May</option>
            <option value='6'>June</option>
            <option value='7'>July</option>
            <option value='8'>August</option>
            <option value='9'>September</option>
            <option value='10'>October</option>
            <option value='11'>November</option>
            <option value='12'>December</option>
           
                </select>
            </div>
        </div>
        <div class="col-3" id="cust_date"  style="display:none;">
                        <div class="form-group">
                        <label class="font-weight-600">Date </label>
                <input class="form-control key dateFilter" type="text" name="daterange" id="daterange"
                value=" ">
                </div>
                    </div>
                   

                </div>

                
</form>
			
			<div class="row">
<div class="col-md-6">
</div>
<div class=" col-md-5 alert alert-info alert-dismissible" role="alert" style="color:green;">
                                         
	<h6>Billable Hours : <b id="billabledata" ></b></h6>

    <h6>  Non Billable Hours :<b id="nonbillabledata"></b></h6>
                                        </div>
</div>

        </div>
        <div class="card-body">

            @component('backEnd.components.alert')

            @endcomponent


            <div class="table-responsive">
            <table id="tableData" class="table key-buttons text-md-nowrap  table-bordered table-striped display" >
				<thead>

                            <th style="display: none;">id</th>
                            <th>Employee Name</th>
                           <!-- <th>Created Date</th>-->
                            <th>Date</th>
                           <!-- <th>Day</th>-->
                            <th>Client Name</th>
                             <th>Assignment Name</th>
                            <th>Work Item</th>
                            <th>Partner</th>
                            <th>Billing Status</th>
                            <th>Hour</th>
                            <th>Total Hour</th>
                        
                    </thead>
                    <tbody >
                      
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
<!--/.body content-->
<style>
    .addCol{position:absolute;left:-17px;}
 .fix-table table{position:relative;table-layout:fixed;overflow:hidden;border-collapse:collapse;}
.fix-table thead{position:relative;display:block;overflow:visible;}
.fix-table thead th{min-width:220px;height:32px;white-space:normal;}


 .fix-table tbody{position:relative;display:block;overflow:scroll;max-height: 500px;}
.fix-table tbody td{min-width:220px;white-space:normal;}


.fix-table table.dataTable tbody td {
    padding: 8px 10px;
    padding-right: 30px;}
</style>


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

<script>
  $(document).ready(function(){
  $('#type').on('change', function() {
    if ( this.value == 'Yearly')
    {
        $("#year").show();
		$("#month").hide();
		$("#quarterly").hide();
		$("#cust_date").hide();


       
    }
    
    else if ( this.value == 'Quarterly')
    {
     $("#year").show();
		$("#month").hide();
		$("#quarterly").show();
		$("#cust_date").hide();

}
    else if ( this.value == 'Monthly')
    {
     $("#year").hide();
		$("#month").show();
		$("#quarterly").hide();
		$("#cust_date").hide();

}
   
    else if ( this.value == "Custom Date")
    {
       $("#year").hide();
		$("#month").hide();
		$("#quarterly").hide();
		$("#cust_date").show();

 }
  });
});
</script>


@endsection



  

 
