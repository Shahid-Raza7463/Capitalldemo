
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
      <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			<li class="breadcrumb-item"><h5><b>Total Received</b> = <span>Rs.{{ number_format($totalreceived)}}/-</h5></span>
    </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Outstanding
                Received</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
     @if(Auth::user()->role_id == 11 )
        <div class="card-header">
            <form method="GET" action="{{ url('paymentsearch')}}">

                <div class="row row-sm">

                    <div class="col-5">
                        <div class="form-group">
                            <label class="font-weight-600">Payment Start Date *</label>
                            <input type="date" required name="startdate" value="" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="font-weight-600">Payment End Date *</label>
                            <input type="date" required  name="enddate" value="" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <br>
                           
                            <button type="submit" class="btn btn-success" style="margin-top: 9px;"> Save</button>
                            <a href="{{ url('payment')}}" class="btn btn-info" style="margin-top: 8px;">Back <i class="fa fa-reply"></i></a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        @endif
        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent   
            <div class="table-responsive">
               <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            
                            <th>Invoice No</th>
                            <th> Client</th>
                            <th>Payment Mode</th>
                            <th>Transaction Id</th>
							   <th>Invoice Amount</th>
                            <th>Amount Received</th>
                            <th>Date of Invoice</th>
							 @if(Auth::user()->role_id == 11 )
                            <th>Payment Date</th>
                            @endif
							  @if(Auth::user()->teammember_id == 173)
							  <th>TDS</th>
                           <th>Roundoff</th>
                           <th>TDSCGST</th>
                           <th>TDSIGST</th>
							  <th>TDSSGST</th>
                           <th>Payment Date</th>
                           <th>Note</th>
                           <th>Delete</th>
							@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentDatas as $paymentData)
                        <tr>
                           @php
                        $invoiceid = App\Models\Invoice::select('id')->where('invoice_id',$paymentData->invoiceid)->first()->id;
                           @endphp
                            <td><a href="{{url('/invoiceview/'.$invoiceid )}}" >{{$paymentData->invoiceid }}</a></td>
                            <td>{{$paymentData->client_name ??''}}</td>
                            <td>@if($paymentData->paymentmode ==  0)
                                <span >Bank</span>
                                @elseif($paymentData->paymentmode ==  1)
                                <span >Online</span>
                                @else
                                <span>Cheque</span>
                                @endif
                            </td>
                                <td>{{$paymentData->transaction_id }}</td>
							 <td>{{$paymentData->total }}</td>
                             <td>{{$paymentData->amountreceived + $paymentData->tds + $paymentData->roundoff + $paymentData->tdscgst
                                + $paymentData->tdsigst + $paymentData->tdssgst}}</td>
                            <td>{{ date('F d,Y', strtotime($paymentData->invoicedate)) }}</td>
							     @if(Auth::user()->role_id == 11 )
                            <td>{{ date('F d,Y', strtotime($paymentData->paymentdate)) }}</td>
                            @endif
						 @if(Auth::user()->teammember_id == 173)
							   <td>{{$paymentData->tds }}</td>
                         <td>{{$paymentData->roundoff }}</td>
                         <td>{{$paymentData->tdscgst }}</td>
                         <td>{{$paymentData->tdsigst }}</td>
                         <td>{{$paymentData->tdssgst }}</td>
                         <td>{{ date('F d,Y', strtotime($paymentData->paymentdate)) }}</td>
                         <td>{{ $paymentData->note ??''}}</td>
                          <td>  <a href="{{route('payment.edit', $paymentData->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-info-soft btn-sm"><i
                                class="fa fa-trash"></i></a></td>
                        @endif
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


