<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Employee Onboarding List</small>
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
				 @if(Auth::user()->role_id == 16)
             <table id="examples" class="display" style="width:100%">
                    <thead>
                        <tr>
							  <th style="display: none;">id</th>
                             <th>Employee Name</th>
							<th>Joining Date</th>
                            <th>Personal Email ID</th>
                             <th>Role</th> 
                            <th>Department</th>
                             <th>Phone No</th>
							<th>Photo </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employeeonboardingDatas as $employeeonboardingData)
                        <tr>
							 <td style="display: none;">{{$employeeonboardingData->id }}</td>
                        <td> {{ $employeeonboardingData->your_full_name }}</td>
							  <td>{{ date('F d,Y', strtotime($employeeonboardingData->dateofjoining)) }}</td>
                        <td> {{ $employeeonboardingData->personal_email }}</td>
                        <td> {{ $employeeonboardingData->rolename }}</td>
							<td>@if($employeeonboardingData->department==1)
                                <span >IDT</span>
                                @elseif($employeeonboardingData->department==2)
                                <span >ASM</span>
                             
                                @elseif($employeeonboardingData->department==3)
                                <span>Audit</span>
                               
                                @elseif($employeeonboardingData->department==4)
                                <span >Statutory Audit</span>
								 @elseif($employeeonboardingData->department==5)
                                <span >Internal Audit</span>
								 @elseif($employeeonboardingData->department==6)
                                <span >Taxation</span>
								 @elseif($employeeonboardingData->department==7)
                                <span >Valuation</span>
								 @elseif($employeeonboardingData->department==8)
                                <span >It</span>
								 @elseif($employeeonboardingData->department==9)
                                <span >Accounts</span>
								 @elseif($employeeonboardingData->department==10)
                                <span >Forensic Audit</span>
								 @elseif($employeeonboardingData->department==11)
                                <span >Administration</span>
								 @elseif($employeeonboardingData->department==12)
                                <span >Data Management</span>
								 @elseif($employeeonboardingData->department==13)
                                <span >Digital Marketing</span>
								 @elseif($employeeonboardingData->department==14)
                                <span >IBC</span>
								 @elseif($employeeonboardingData->department==15)
                                <span >Direct Taxation</span>
								 @elseif($employeeonboardingData->department==16)
                                <span >HR</span>
                                @else
                                <span >Management</span>
                                @endif</td>
							<td> {{ $employeeonboardingData->phoneno }}</td>
							 <td><a target="blank"
                                      href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/'.$employeeonboardingData->photograph, now()->addMinutes(30)) }}">
                                      {{ $employeeonboardingData->photograph ??'Not Uploaded'}} </a>
                              </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
				@endif
					 @if(Auth::user()->role_id == 17)
            <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                             <th>Employee Name</th>
							<th>Joining Date</th>
                             <th>Role</th> 
                          <th> Designation</th>
                             <th>Phone No</th>
							<th>Pan number </th>
							 <th>Your name as per the Bank Account </th>
                       <th>Name of Bank</th>
                       <th>Account Number</th>
                       <th>IFSC Code</th>
                       <th>Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employeeonboardingDatas as $employeeonboardingData)
                        <tr>
                        <td> {{ $employeeonboardingData->your_full_name }}</td>
							  <td>{{ date('F d,Y', strtotime($employeeonboardingData->dateofjoining)) }}</td>
                        <td> {{ $employeeonboardingData->rolename }}</td>
							  <td> {{ $employeeonboardingData->designation }}</td>
							<td> {{ $employeeonboardingData->phoneno }}</td>
							<td><a target="blank"
                                      href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/'.$employeeonboardingData->pancard, now()->addMinutes(30)) }}">
                                      {{ $employeeonboardingData->pancard ??'Not Uploaded'}} </a>
                              </td>
							  <td> {{ $employeeonboardingData->bankholder_name }}</td>
                              <td> {{ $employeeonboardingData->bank_name }}</td>
                              <td> {{ $employeeonboardingData->account_number }}</td>
                              <td> {{ $employeeonboardingData->ifsc_code }}</td>
                              <td> {{ $employeeonboardingData->branch }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
				@endif
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>                               
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>   
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>    
<script>
$(document).ready(function() {
    $('#examples').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 0, "desc" ]],
        
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