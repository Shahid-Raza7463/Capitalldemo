<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    @if(Auth::user()->role_id == 11)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item">
                <div class="btn-group mb-2 mr-1">
                    <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Choose Partner
                    </button>
                    <div class="dropdown-menu">
                        @foreach ($partner as $partnerData)
                        <a style="color: #37A000" class="dropdown-item"
                            href="{{url('/partnerpandl?'.'partners='.$partnerData->id.'&&'.'fy='.$id )}}">{{ $partnerData->team_member }}</a>
                        @endforeach


                    </div>
                </div>
            </li>
            <li class="breadcrumb-item">
                <div class="btn-group mb-2 mr-1">
                    <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Choose Assignment
                    </button>
                    <div class="dropdown-menu">
                        @foreach ($assignments as $partnerData)
                        <a style="color: #37A000" class="dropdown-item"
                            href="{{url('/assignmentpandl?'.'assignment_id='.$partnerData->id.'&&'.'fy='.$id )}}">{{ $partnerData->assignment_name }}</a>
                        @endforeach


                    </div>
                </div>
            </li>


        </ol>
    </nav>
    @endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Assignment P & L Report List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            {{-- <form action="{{ url('/search')}}" method="GET" role="search">

            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search invoice by amount , invoice no , partner , client"> <span
                    class="input-group-btn">
                    <button type="submit" style="font-size: 17px;" class="btn btn-success">
                        <i class="fas fa-search"></i>
                    </button>

                </span>
            </div>
            </form> --}}
            <br>
            @component('backEnd.components.alert')

            @endcomponent
            @if(isset($invoiceData))
            <div class="table-responsive">
                <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
                            <th>Partner</th>
                            <th>Assignment</th>
                            <th>Client</th>
                             <th>Total Invoice Amount</th>
                          <th>Assignment Cost</th>
                          
                          
                            <th>PROFIT/LOSS</th>
                        </tr>
                    </thead>
                    <tbody>
						
                        @foreach($invoiceData as $invoiceDatas)

                        @php
                       $invoiceDatastotal = DB::table('invoices')->where('assignmentgenerate_id',$invoiceDatas->assignmentgenerate_id)->sum('total');
                       
                        // $paymentData = DB::table('payments')
                        // ->where('invoiceid',$invoiceDatas->invoice_id)->select('payments.*')->first();


                        // $outstandingData = DB::table('outstandings')
                        // ->where('BILL_NO',$invoiceDatas->invoice_id)->select('outstandings.*')->first();
                        // // dd($outstandingData);





                        // if ($outstandingData != null) {
                        // $current=Carbon\Carbon::now();
                        // $formatted_dt1=Carbon\Carbon::parse($current);
                        // $pendingdays=$formatted_dt1->diffInDays($outstandingData->DATE);

                        // }

                         $costing = DB::table('timesheetusers')
                         ->leftjoin('teammembers','teammembers.id', 'timesheetusers.createdby')
                        ->select('timesheetusers.createdby', DB::raw('SUM(totalhour) as total_hour'))
                         ->where('timesheetusers.assignmentgenerate_id', $invoiceDatas->assignmentgenerate_id)
                         ->groupBy('timesheetusers.createdby')
                         ->get();
                        // dd($costing);
                         $sum = 0;

                         foreach($costing as $costingData){

                         $avgcost = DB::table('teammembers')->where('id',$costingData->createdby)->pluck('cost_hour')->first();
                         if($avgcost == null){
                         $avgcost = '0';
                         }

                         $userhour = DB::table('timesheetusers')->where('assignmentgenerate_id',$invoiceDatas->assignmentgenerate_id)
                         ->where('createdby', '=',$costingData->createdby)
                         ->sum('totalhour');

                        // // dd($userhour);
                        $sum += $costingData->total_hour * $avgcost;

                        }
                        // dd($sum);
                        @endphp
                        <tr>
                            <td>{{$invoiceDatas->team_member }}</td>
                            <td>
                                @if($invoiceDatas->assignment_name != null)
								<a target="blank" href="{{ url('assignmentcosting/'.$invoiceDatas->assignmentgenerate_id)}}"> <span>{{$invoiceDatas->assignment_name  ??''}} ( {{ $invoiceDatas->assignmentgenerate_id }} )</span></a>
                                @endif</td>
                            <td>{{$invoiceDatas->client_name }}</td>



                             <td>{{ $invoiceDatastotal }}</td>
                            <td>{{ $sum ??''}}</td>
                            

                         {{--   <td>

                                @if($outstandingData != null)
                                {{ number_format($outstandingData->AMT) }}
                                @endif
                            </td>
                            <td>
                                @if($outstandingData != null)
                                @if($pendingdays>90)<span class="badge badge-pill badge-danger">{{ $pendingdays }}
                                </span>
                                @else
                                {{ $pendingdays }}
                                @endif
                                @endif
                            </td>
                            <td>
                                @if($outstandingData != null)
                                {{ number_format($outstandingData->AMT * $pendingdays *10/36500) }}
                                @endif
                            </td>
                            <td>
                                @if($outstandingData != null)
                                {{ number_format($sum + $outstandingData->AMT * $pendingdays *10/36500)}}
                                @endif
                            </td>--}}
                            <td>{{ $invoiceDatastotal - $sum }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {!! $invoiceData->render() !!} --}}
            </div>
            @elseif(isset($message))
            <p>{{ $message }}</p>

            @endif
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
