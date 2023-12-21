<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	@if(Auth::user()->teammember_id == 522 || Auth::user()->teammember_id == 409 || Auth::user()->teammember_id == 404 || Auth::user()->teammember_id == 432)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('reimbursementclaim/create')}}">Add Reimbursement Claim</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav> 
	@endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Reimbursement Claim
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
                            <th>Employee Name</th>
							 <th>Approver</th>
                            <th>Status</th>
							  <th>Paid Date</th>
                            <th>Processing Date</th>
                            <th>Created Date</th>
                            <th>Date of Expense</th>
                            <th>Type of Expense</th>
                            <th>Approved Amount</th>
                            <th>Actual Amount</th>
                            <th>Location</th>
                            <th>File</th>
                           


                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reimbursementDatas as $reimbursementDatas)
                        <tr>
                            <td style="display: none;">{{$reimbursementDatas->id }}</td>
                            <td><a href="{{route('reimbursementclaim.show', $reimbursementDatas->id)}}">{{ App\Models\Teammember::select('team_member')->where('id',$reimbursementDatas->createdby)->first()->team_member ?? ''}}
                            </a></td>
							   <td>{{ $reimbursementDatas->team_member }} ( {{ $reimbursementDatas->rolename }} )</td>
                              <td>
                                @if(Auth::user()->role_id == 17)<a id="editCompany" data-toggle="modal" data-id="{{ $reimbursementDatas->id }}"
                                    data-target="#modaldemo1">
                                    @endif
                                    @if($reimbursementDatas->Status==0)
                                <span class="badge badge-info">Created</span>
                                @elseif($reimbursementDatas->Status==1)
                                <span class="badge badge-success">Approved</span>
                                @elseif($reimbursementDatas->Status==2)
                                <span class="badge badge-danger">Rejected</span>
                                @elseif($reimbursementDatas->Status==4)
                                <span class="badge badge-primary">Processing Amount</span>
                                @elseif($reimbursementDatas->Status==5)
                                <span class="badge badge-success">Paid</span>
                                @else
                                <span class="badge badge-warning">Submitted</span>
                                @endif
                                @if(Auth::user()->role_id == 17)</a>@endif</td>
							                    <td>@if($reimbursementDatas->paiddate != null){{ date('F d,Y', strtotime($reimbursementDatas->paiddate)) }}@endif</td>
                            <td>@if($reimbursementDatas->processingdate != null){{ date('F d,Y', strtotime($reimbursementDatas->processingdate)) }}@endif</td>
                            <td>{{ date('F d,Y', strtotime($reimbursementDatas->created_at)) }}</td>
                            <td>{{ date('F d,Y', strtotime($reimbursementDatas->Date_of_Expense)) }}</td>
                            <td> {{ nl2br(e($reimbursementDatas->Type_of_Expense)) }}</td>
                            <td>{{$reimbursementDatas->Approved_Amount }}</td>
                            <td>{{$reimbursementDatas->Actual_Amount }}</td>
                            <td>{{$reimbursementDatas->Location }}</td>
                            <td><a download target="blank"
                                    href="{{url('/backEnd/image/claim/'.$reimbursementDatas->attachment)}}">{{ $reimbursementDatas->attachment ??''}}</a>
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
<!-- Modal -->
<div class="modal fade bd-example-modal-sm"  id="modaldemo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5  style="color: white"class="modal-title font-weight-600" id="exampleModalLabel1">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" method="post" action="{{ url('reimbursementclaimupdate')}}"
            enctype="multipart/form-data">
                        @csrf     
            <div class="modal-body">
                <select name="Status" required id="exampleFormControlSelect1" class="form-control">
                
                   
                    <option value="">Please Select One</option>
                    <option value="4">Processing Amount</option>
                    <option value="5">Paid</option>
               
                </select>
                <input class="form-control" hidden value="" name="reimbursementid" id="id" type="text">
            </div>
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
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('reimbursementclaimupdate') }}",
                data: "id=" + id,
                success : function(response){
          debugger;
           $("#id").val(response.id);

            
        },
                error: function () {

                },
            });
        });
    });

</script>