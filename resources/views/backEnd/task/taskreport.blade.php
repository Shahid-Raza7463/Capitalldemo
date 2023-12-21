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
        <form id="taskformselect">

                <div class="row row-sm">       
                    <div class="col-3">
                    <div class="form-group">
                    <label class="font-weight-600">Employee Name</label>
                    <select class="language form-control" id="employee" name="employee"> 
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
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Status</label>
                <select required class="form-control key" id="status" name="status">
                   <option value=''>--Select Status--</option>
                    <option  value='0'>Open</option>
                    <option value='1'>Close</option>
                    <option value='2'>Cancelled Due to Non Completion</option>
            
            </select>
            </div>
        </div>
        <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Select Year *</label>
                           <select required class="language form-control" id="yearly" name="yearly"> 

						<option value="">--Select Year--</option>
                        @foreach($years as $year)
                        <option value="{{$year}}">
                            {{ $year }}
                        </option>
                        @endforeach
                    </select>
                        </div>
                  
                    </div>
      </div>
          
</form>
			
<div class="row">
<div class="col-md-6">
</div>
<!-- <div class=" col-md-5 alert alert-info alert-dismissible" role="alert" style="color:green;">
                                         
	<h6>Billable Hours : <b id="billabledata" ></b></h6>

    <h6>  Non Billable Hours :<b id="nonbillabledata"></b></h6>
</div> -->
</div>

        </div>
        <div class="card-body">

            @component('backEnd.components.alert')

            @endcomponent


            <div class="table-responsive">
            <table id="tableData" class="table key-buttons text-md-nowrap  table-bordered table-striped display" >
				<thead>
                            <th style="display: none;">id</th>
							<!-- <th> Related To</th> -->
                            <th> Name</th>
                            <th>Assign</th>
							<th>Assign By</th>
							<th>Support By</th>
                            <th>Created Date</th>
							<th>Due Date</th>
                            <th>Status</th>
                        
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

    var dataTable = $('#tableData').DataTable({
        dom: 'Bfrtip',
        columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }],
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
        ],
        "paging": true // Enable pagination
    });

    $('#taskformselect').on("change keyup", function () {
        var employeeid = $('#employee').val();
        var month = $('#month').val();
        var yearly = $('#yearly').val();
        var status = $('#status').val();

        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '{{url('taskfiltersection')}}',
            data: {
                employeeid: employeeid,
                month: month,
                yearly: yearly,
                status: status
            },
            success: function (response) {
                dataTable.clear().draw();

                if (response.length === 0) {

                  dataTable.draw();
            
                } else {
                    var data = [];

                    for (var i = 0; i < response.length; i++) {
                        var statusText, statusColor;
                        if (response[i].status === 0) {
                            statusText = 'Open';
                            statusColor = 'badge-success';
                        } else if (response[i].status === 1) {
                            statusText = 'Close';
                            statusColor = 'badge-danger';
                        } else if (response[i].status === 2) {
                            statusText = 'Cancelled Due to Non Completion';
                            statusColor = 'badge-primary';
                        } else {
                            statusText = '';
                            statusColor = '';
                        }
                        var createdDate = new Date(response[i].created_at);
                        var dueDate = new Date(response[i].duedate);

                        data.push([
                            '<a href="{{url('view/task')}}/' + response[i].id + '" class="task-link" style="margin-right: 10px;">' + (response[i].taskname || '') + '</a>',
                            response[i].assign || '',
                            response[i].assignby || '',
                            response[i].supportby || '',
                            createdDate.toLocaleDateString(),
                            dueDate.toLocaleDateString(),
                            '<span class="badge ' + statusColor + '">' + statusText + '</span>'
                        ]);
                    }

                    dataTable.rows.add(data).draw();
                }
            }
        });
    });
});
</script>


@endsection 
