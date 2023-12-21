
@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="card mb-4">
        <div class="card-body">
           <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:260px;">
                <div class="card-body">
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Assignment Name : </b></td>
                                    <td>{{ $assignmentbudgetingDatas->assignment_name}}</td>

                                    <td><b>Assignment Code :</b></td>
                                    <td>{{ $assignmentbudgetingDatas->assignmentgenerate_id}}</td>

                                </tr>
                                <tr>
                                    <td><b>Client Name : </b></td>
                                    <td>{{ $assignmentbudgetingDatas->client_name}}</td>
                                    <td><b>Period End : </b></td>
                                    <td style="color: cornflowerblue;">{{ $assignmentbudgetingDatas->periodend}}</td>

                                </tr>
								<!--
								<tr>
                                    <td><b>File Creation Date : </b></td>
                                    <td>@if(!empty($assignmentbudgetingDatas->filecreationdate))
                                        {{ date('F d,Y', strtotime($assignmentbudgetingDatas->filecreationdate)) }}@endif</td>

                                    <td><b>Modified Date :</b></td>
                                    <td>@if(!empty($assignmentbudgetingDatas->modifieddate))
                                        {{ date('F d,Y', strtotime($assignmentbudgetingDatas->modifieddate)) }}@endif</td>

                                </tr>
                                <tr>
                                    <td><b>Audit Completion Date : </b></td>
                                    <td>@if(!empty($assignmentbudgetingDatas->auditcompletiondate))
                                        {{ date('F d,Y', strtotime($assignmentbudgetingDatas->auditcompletiondate)) }}@endif</td>

                                    <td><b>Documentaion Date :</b></td>
                                    <td>@if(!empty($assignmentbudgetingDatas->documentationdate))
                                        {{ date('F d,Y', strtotime($assignmentbudgetingDatas->documentationdate)) }}@endif</td>

                                </tr> -->
                                <tr>
                                    <td><b>Status : </b></td>
                                    <td>@if($assignmentbudgetingDatas->status==1)
                                        <span class="badge badge-primary">OPEN</span>
                                        @else
                                        <span class="badge badge-danger">CLOSED</span>
                                        @endif</td>
                                    <td><b>Billing Frequency : </b></td>
                                    <td>@if($assignmentbudgetingDatas->billingfrequency==0)
                                        <span>Monthly</span>
                                        @elseif($assignmentbudgetingDatas->billingfrequency==1)
                                        <span>Quarterly</span>
                                        @elseif($assignmentbudgetingDatas->billingfrequency==2)
                                        <span>Half Yearly</span>
                                        @else
                                        <span>Yearly</span>
                                        @endif
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
			<br>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                            <div class="card-body">
                                <div class="card-head">
                                    <b>Invoice</b>
                                </div>
                                <hr>
                                <div class="table-responsive example">
                                    <table class="table display table-bordered table-striped table-hover ">
                                        <thead>
                                            <tr>
                                                <th>Invoice No</th>
												<th>Date </th>
												 <th>Invoice Amount</th>
												 <th>Amount  Received</th>
												<th> Outstanding</th>
												<th> Outstanding Days</th>
												<th>Notional Interest</th> 
                                              
    
                                            </tr>
                                        </thead>
                                        <tbody>
											@php
											 $total = 0;
											$out = 0;
											$pendingday = 0;
											$notion = 0;
											@endphp
                                            @foreach($invoicecosting as $invoicecostingData)
                                            <tr>
												@php
												   $paymentData = DB::table('payments')
                        ->where('invoiceid',$invoicecostingData->invoice_id)->select('payments.*')->first();
												
                        $outstandingData = DB::table('outstandings')
                        ->where('BILL_NO',$invoicecostingData->invoice_id)->select('outstandings.*')->first();
                       // dd($outstandingData);

 if ($outstandingData != null) {
    $current=Carbon\Carbon::now();
                        $formatted_dt1=Carbon\Carbon::parse($current);
                        $pendingdays=$formatted_dt1->diffInDays($outstandingData->DATE);

 }                                       
												//dd($paymentData);
												@endphp
                                                <td>{{$invoicecostingData->invoice_id }}</td>
                                                <td> @if($invoicecostingData->invoicedate != null)
                             {{ date('F d,Y', strtotime($invoicecostingData->invoicedate)) }}
                                @endif</td>
                                                <td>{{$invoicecostingData->total }}
                                                </td>
												<td>
                                @if($paymentData != null)
                                {{$paymentData->amountreceived + $paymentData->tds + $paymentData->roundoff + $paymentData->tdscgst
                                    + $paymentData->tdsigst + $paymentData->tdssgst}}
                               
                                @endif
													 @php
													if($paymentData != null){
                $total += $paymentData->amountreceived + $paymentData->tds + $paymentData->roundoff + $paymentData->tdscgst
                                    + $paymentData->tdsigst + $paymentData->tdssgst;
												//	dd($total);
													}
													 if($outstandingData != null){
                             $out +=  $outstandingData->AMT; 
													$pendingday += $pendingdays;
													$notion += $outstandingData->AMT * $pendingdays *10/36500;
                                }
            @endphp
													
                            </td>
												   <td>
                                
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
												<td>@if($outstandingData != null)
                                {{ number_format($outstandingData->AMT * $pendingdays *10/36500)}}
                                @endif</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td><b>Total Amount</b>

                                                </td>
												<td></td>
												
                                                <td><b>{{ $invoicecostingtotal }}</b></td>
												<td><b>
													
													{{ $total }}</b></td>
												<td><b>{{ $out }}</b></td>
												<td><b>{{ $pendingday }}</b></td>
												<td><b>{{ number_format($notion) }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card " style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                            <div class="card-body">
    
                                <div class="card-head">
                                    <b>Costing</b>
                                   
                                </div>
                                <hr>
                                <div class="table-responsive example">
                                    <table class="table display table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Teammember</th>
                                                <th> Hour Cost ( Time in Hours)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											@php
    $sum = 0;
@endphp
                                            @foreach($costing as $costingData)

                                            @php
                                             $avgcost =  DB::table('teammembers')->where('id',$costingData->createdby)->first();
											//dd($avgcost);
											$userhour = DB::table('timesheetusers')->
											where('assignmentgenerate_id', '=',$id)
                ->where('createdby', '=',$costingData->createdby)
                ->sum('totalhour');
											
                                            @endphp
                                            <tr>
                                                <td>{{$avgcost->team_member }}</td>
                                               
                                                <td>{{ $userhour * $avgcost->cost_hour }} ( {{ $userhour }} )</td>
												@php
												 $sum += $userhour * $avgcost->cost_hour;
											
                                              //  dd($sv);
												@endphp
                                            </tr>
                                            @endforeach
											 <tr>
                                                <td><b>Total Hour Cost</b>

                                                </td>
                                                <td><b>{{ $sum }} <br>
													</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
         <br>
			<div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                <div class="card-body">
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Net Profit / Loss : </b></td>
                                    <td>{{ $invoicecostingtotal - $sum }}</td>
                                    
                                
                                </tr>
                               

                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->

@endsection
