<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('assetprocurement/create')}}">Add Asset Procurement Form</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Asset Procurement Form
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
                            <th>Raised Date</th>
								  <th>Paid Date</th>
                            <th>Status</th>
                            <th>Approver </th>
                            <th>Company Name</th>
                            <th>Item Name</th>
                         
                            <th>Start Date</th>
                            <th>End Date </th>
                            <th>Place Of Purchase</th>
                            <th>Amount Required </th>
                            <th>Bill / PO</th>
                            <th>Payment Type</th>
                          

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assetprocurementDatas as $assetprocurementData)
                        <tr>
                            <td style="display: none;">{{$assetprocurementData->id }}</td>
                            <td> <a href="{{route('assetprocurement.show', $assetprocurementData->id)}}">
                                    {{ App\Models\Teammember::select('team_member')->where('id',$assetprocurementData->createdby)->first()->team_member ?? ''}}</a>
                            </td>
                            <td>{{ date('F d,Y', strtotime($assetprocurementData->created_at ??'')) }}</td>
							<td> @if($assetprocurementData->processingdate != null)
								{{ date('F d,Y', strtotime($assetprocurementData->processingdate ??'')) }}
							@endif</td>
                              <td>  
                                @if(Auth::user()->role_id == 17)
                                @if($assetprocurementData->Status > 0)
                                <a id="editCompany" data-toggle="modal" data-id="{{ $assetprocurementData->id }}"
                            data-target="#modaldemo1">
                                    @endif
                                     @endif
                                  @if($assetprocurementData->Status==0)
                                <span class="badge badge-info">Created</span>
                                @elseif($assetprocurementData->Status==1)
                                <span class="badge badge-success">Approved</span>
                                @elseif($assetprocurementData->Status==2)
                                <span class="badge badge-danger">Rejected</span>
                                @elseif($assetprocurementData->Status==3)
                                <span class="badge badge-primary">Paid</span>
                                @endif
                                @if(Auth::user()->role_id == 17)
                                @if($assetprocurementData->Status > 0)
                                </a>
                                    @endif
                                     @endif
                            </td>
                            <td>{{ $assetprocurementData->team_member }}</td>
                           
                                <td>{{ $assetprocurementData->companyname ??''}}</td>
                                <td>{{ $assetprocurementData->itemname ??''}}</td>
                              
                                <td>  @if($assetprocurementData->startdate != null)
                                    {{ date('F d,Y', strtotime($assetprocurementData->startdate ??'')) }}@endif
                                </td>
                                <td>  @if($assetprocurementData->enddate != null)
                                    {{ date('F d,Y', strtotime($assetprocurementData->enddate ??'')) }}@endif
                                </td>
                                <td>{{ $assetprocurementData->placeofpurchase ??''}}</td>
                                <td>{{ $assetprocurementData->amount ??''}}</td>
                                <td><a target="blank" href="{{url('/backEnd/image/assetprocurements/'.$assetprocurementData->bill ??'')}}">
                                    {{ $assetprocurementData->bill ??''}}</a></td>

                            <td>@if($assetprocurementData->paymenttype == 0)
                                <span >Reimbursement</span>
                               
                                @else
                                <span>Advance</span>
                                @endif
                            </td>
                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/.body content-->
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
            <form method="post" method="post" action="{{ url('assetupdate')}}"
            enctype="multipart/form-data">
                        @csrf     
            <div class="modal-body">
                <select name="Status" required id="exampleFormControlSelect11" class="form-control">
                
                   
                    <option value="">Please Select One</option>
                    <option value="3">Paid</option>
               
                </select>
                <input class="form-control" hidden value="" name="assetprocurementid" id="id" type="text">
				 <br>
                <div class="form-group" >
                    
                      <input type="text" required name="payment" class="form-control"
                      placeholder="Enter NEFT/CHEQUE/RTGS Details">
                </div>
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
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('assetfetch') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $("#id").val(response.id);

            
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
