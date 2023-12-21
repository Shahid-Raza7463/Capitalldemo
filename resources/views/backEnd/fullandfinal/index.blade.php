
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    @if(Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('fullandfinal/create')}}">Add fullandfinal</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    @endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>fullandfinal
                    List</small>
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
                            <th>Created By</th>
                            <th>Raised Date</th>
                            <th>Approved Date</th>
                            <th>Name</th>
                            <th>Designation </th>
                            <th>Reporting Head</th>
                            <th>Date of Joining</th>
                        
                            <th>Date of Leaving</th>
                            @if(Auth::user()->role_id != 16)
                            <th>Date of Resignation</th>
                            <th>Assignment Data Handover </th>
                            @endif
                            <th>Laptop Handover </th>
                            @if(Auth::user()->role_id == 17 || Auth::user()->role_id == 18 || Auth::user()->role_id ==
                            11)
                            <th>Notice Period Served </th>
							@if(Auth::user()->teammember_id != 501)
                            <th>Status of Leaving </th>
                           @endif

                            <th>Full and Final (Days) to be released</th>
								@if(Auth::user()->teammember_id != 501)
                            <th>Reason of Leaving</th>
							@endif
                            <th>Remark</th>
                          
                            <th>Account Clearance</th>
							<th>E-KYC Status</th>
                            <th> Status of Full and Final </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fullandfinalDatas as $fullandfinalData)
                        <tr>
                            @php
                            $reporting = DB::table('teammembers')
                            ->leftjoin('roles','roles.id','teammembers.role_id')
                            ->where('teammembers.id',$fullandfinalData->Reporting_Head)
                            ->select('teammembers.team_member','roles.rolename')->first();
                            $team = DB::table('teammembers')
                            ->leftjoin('roles','roles.id','teammembers.role_id')
                            ->where('teammembers.id',$fullandfinalData->createdby)
                            ->select('teammembers.team_member as team','roles.rolename as role')->first();
                            @endphp
							  <td style="display: none;">{{$fullandfinalData->id }}</td>
                            <td>{{ $team->team ??''}} ( {{ $team->role ??''}} )</td>
                            <td>{{ date('F d,Y', strtotime($fullandfinalData->created_at ??'')) }}</td>
							<td>@if($fullandfinalData->approved_date != null){{ date('F d,Y', strtotime($fullandfinalData->approved_date ??'')) }}@endif</td>
                            <td>

                                <a href="{{url('fullandfinal', $fullandfinalData->id)}}">
                                    {{$fullandfinalData->Name }} ( {{ $fullandfinalData->rolename ??''}} )</a></td>

                            <td>@if($fullandfinalData->Designation == 0)
                                <span>Article</span>
                                @elseif($fullandfinalData->Designation == 1)
                                <span>Partner</span>
                                @elseif($fullandfinalData->Designation == 2)
                                <span>Manager</span>
                                @elseif($fullandfinalData->Designation == 3)
                                <span>Auditor</span>
                                @else
                                <span>C.A</span>
                                @endif
                            </td>

                            <td>{{ $reporting->team_member ??''}}</td>
                            @if($fullandfinalData->Date_of_Joining != null)
                            <td>{{ date('F d,Y', strtotime($fullandfinalData->Date_of_Joining ??'')) }}</td>
                            @else
                            <td></td>
                            @endif
                         
                            @if($fullandfinalData->Date_of_Leaving != null)
                            <td>{{ date('F d,Y', strtotime($fullandfinalData->Date_of_Leaving ??'')) }}</td>
                            @else
                            <td></td>
                            @endif
                            @if(Auth::user()->role_id != 16)
                            @if($fullandfinalData->Date_of_Resignation != null)
                            <td>{{ date('F d,Y', strtotime($fullandfinalData->Date_of_Resignation ??'')) }}</td>
                            @else
                            <td></td>
                            @endif
                            <td> @if($fullandfinalData->Assignment_Data_Hanover =='0')
                                <span>Done</span>
                                @elseif($fullandfinalData->Assignment_Data_Hanover =='1')
                                <span>Pending</span>
                                @endif</td>
                                @endif
                            <td> @if($fullandfinalData->Laptop_Hanover=='0')
                                <span>Yes</span>
                                @elseif($fullandfinalData->Laptop_Hanover=='1')
                                <span>No</span>
                                @endif</td>
                            @if(Auth::user()->role_id == 17 || Auth::user()->role_id == 18 || Auth::user()->role_id ==
                            11)
                            <td>{{ $fullandfinalData->Notice_Period_Served ??''}}</td>
								@if(Auth::user()->teammember_id != 501)
                            <td> @if($fullandfinalData->Status=='0')
                                <span>Voluntary</span>
                                @else
                                <span>In Voluntary</span>
                                @endif</td>
                          @endif

                            <td>{{ $fullandfinalData->Full_and_Final_to_be_released ??''}}</td>
								@if(Auth::user()->teammember_id != 501)
                            <td>{{ $fullandfinalData->Reason_of_Leaving ??''}}</td>
							@endif
                            <td>{{ $fullandfinalData->remark ??''}}</td>

                           
                            <td> @if($fullandfinalData->fnfstatus=='0')
                                <span>Done</span>
                                @elseif($fullandfinalData->fnfstatus=='1')
                                <span>Pending</span>
                                @endif</td>
							
							<td> @if($fullandfinalData->kycstatus=='1')
                                <span class="badge badge-pill badge-success">Yes</span>
								
								 @elseif($fullandfinalData->kycstatus=='2')
                                <span class="badge badge-pill badge-Secondary">Not Applicable</span>
                                
                                @elseif($fullandfinalData->kycstatus=='0')
                                <span class="badge badge-pill badge-warning">No</span>
                                @endif
							</td>
                             
                            <td>@if($fullandfinalData->Final_Status_of_Full_and_Final == 1)
                                <span class="badge badge-pill badge-warning">On Hold</span>
                                @elseif($fullandfinalData->Final_Status_of_Full_and_Final == 0)
                                <span class="badge badge-pill badge-success">Done</span>
								 @elseif($fullandfinalData->Final_Status_of_Full_and_Final == 3)
                                <span class="badge badge-pill badge-primary">Not to be Done</span>
                                
                                @else
                                <span class="badge badge-pill badge-secondary">Not Done</span>
                                @endif
                            </td>
                            @endif
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

