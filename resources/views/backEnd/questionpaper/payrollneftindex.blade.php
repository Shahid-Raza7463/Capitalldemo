<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
  <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
    <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
        <li class="breadcrumb-item"> <div class="btn-group mb-2 mr-1">
            <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Choose Month
            </button>
            <div class="dropdown-menu">
                <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/payrollarticleneftss?'.'month='.'October')}}">October</a>
                <a style="color: #37A000" class="dropdown-item"
                href="{{url('/payrollarticleneftss?'.'month='.'September')}}">September</a>
                
            </div>
        </div></li>
      
    </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
                <a href="{{url('home')}}">
                    <h1 class="font-weight-bold" style="color:black;">Home</h1>
                </a>
                <small>NEFT Format List</small>
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
                <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
  <th>Month</th>
                            <th>Transaction_Ref_No</th>
                            <th>Amount</th>
                            <th>ValueDate</th>
                            <th>Branch_Code</th>
                            <th>Sender_Account_Type</th>
                            <th>Remitter_Account_No</th>
                            <th>Remitter_Name</th>
                            <th>IFSC_Code</th>
                            <th>Debit_Account</th>
                            <th>Beneficiary_Account_type</th>
                            <th>Bank_Account_Number</th>
                            <th>Beneficiary_Name</th>
							 <th>Employee_Name</th>
                            <th>Remittance_Details</th>
                            <th>Debit_Account_System</th>
                            <th>SMSEML</th>
                            <th>Employment Status</th>
                             <th>Bank Account Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($neftData as $information => $neftDatas)
                        <tr>
<td>{{$neftDatas->month ??'' }}</td>
                            <td>NEFT{{$information  + 1 }}</td>
                            <td>{{$neftDatas->totalconveyance }}</td>
                            <td> {{ date('F d,Y', strtotime($neftDatas->created_at)) }}</td>
                            <td> 0314</td>
                            <td> 11</td>
                            <td> 50200060133301</td>
                            <td> KG SOMANI & CO. LLP</td>
                            <td>{{$neftDatas->ifsccode }}</td>
                            <td>50200060133301</td>
                            <td>SAVING</td>
                            <td>{{$neftDatas->bankaccountnumber}}</td>
                            <td>{{$neftDatas->name_as_per_bankaccount }}</td>
							@php
							$team  = DB::table('teammembers')->where('id',$neftDatas->teammember_id)->first();
							@endphp
                            <td>{{$team->team_member }}</td>
                            <td>NEFT</td>
                            <td>2</td>
                            <td>SMS</td>
                            <td>{{$neftDatas->employeestatus }}</td>
							 <td>@if($neftDatas->verify==1)
                                <span class="badge badge-pill badge-success">Verified</span>
                                @else
                                <span class="badge badge-pill badge-danger">Not Verified</span>
                                @endif
                            </td>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>                               
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>    
<script>$(document).ready(function() {
    $('#examplee').DataTable( {
					"pageLength": 150,
        dom: 'Bfrtip',
        "order": [[ 0, "asc" ]],
        
        buttons: [
            
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
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
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            'colvis'      
    ]  
    } );
} );</script>                                

