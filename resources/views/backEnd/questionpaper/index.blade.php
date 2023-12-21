<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('neft/create')}}">Add Question Paper</a></li>
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
                <small>Question Paper List</small>
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

                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Name As Per Bank Account</th>
                            <th>Name of Bank</th>
                            <th>Bank Account</th>
                            <th>Bank Account</th>
                            <th>IFSC Code</th>
                            <th>Payment Type</th>
                            <th>Total Conveyance</th>
                            <th>Createdby</th>
                            {{-- <th>Edit</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($neftData as $neftDatas)
                        <tr>

                            <td>{{$neftDatas->team_member }}</td>
                            <td> {{ date('F d,Y', strtotime($neftDatas->created_at)) }}
                                {{ date('h:i A', strtotime($neftDatas->created_at)) }}</td>
                            <td>
                                @if(Auth::user()->role_id == 17)<a id="statusbtn" data-toggle="modal"
                                    data-id="{{ $neftDatas->id }}" data-target="#modal4">
                                    @endif
                                    @if($neftDatas->status==0)
                                    <span class="badge badge-info">Created</span>
                                    @elseif($neftDatas->status==2)
                                    <span class="badge badge-success">Paid</span>
                                    @endif
                                    @if(Auth::user()->role_id == 17)</a>
                                @endif
                            </td>
                            <td>{{$neftDatas->name_as_per_bankaccount }}</td>

                            <td>{{$neftDatas->nameofbank }}</td>
                            <td>{{$neftDatas->bankaccountnumber}}</td>
                            <td>{{$neftDatas->ifsccode }}</td>

                            <td>@if($neftDatas->paymenttype==0)
                                <span class="badge badge-pill badge-warning">Conveyance</span>
                                @elseif($neftDatas->paymenttype==1)
                                <span class="badge badge-pill badge-success">Salary</span>

                                @elseif($neftDatas->paymenttype==2)
                                <span class="badge badge-pill badge-info">Reimbursement</span>

                                @else
                                <span class="badge badge-pill badge-danger">Asset Procurement</span>
                                @endif
                            </td>
                            <td>{{$neftDatas->totalconveyance }}</td>
                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$neftDatas->createdby)->first()->team_member ?? '' }}
                            </td>
                            {{-- <td>
                            <a href="{{route('neft.edit', $neftDatas->id)}}" class="btn btn-info-soft btn-sm"><i
                                class="fa fa-edit"></i></a>
                            </td> --}}
                            {{-- <td> <form action="{{ route('neft.destroy', $neftDatas->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button onclick="return confirm('Are you sure you want to delete this item?');"
                                class="btn btn-info">Delete</button>
                            </form>
                            </td> --}}

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
<div class="modal fade" id="Modal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{url('neftstatusupdate')}}" enctype="multipart/form-data">

                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Status</label>
                                <select required class="form-control " name="status">
                                    <option value="">Please Select One</option>
                                    <option value="2">Paid</option>
                                </select>
                                <input hidden class="form-control" value="" name="id" id="ids" type="text">
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" style="float: right" class="btn btn-success">Save </button>
                </div>
            </form>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('body').on('click', '#statusbtn', function (event) {
            //        debugger;
            var id = $(this).data('id');
            debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('neftstatus') }}",
                data: "id=" + id,
                success: function (response) {
                    // alert(res);
                    debugger;
                    $("#ids").val(response.id);


                },
                error: function () {

                },
            });
        });
    });

</script>
