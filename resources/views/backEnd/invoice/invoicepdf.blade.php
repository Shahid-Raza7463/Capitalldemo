
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
        <meta name="author" content="Bdtask">
        <title>K.G.Somani</title>
        
         <!-- stylesheet start -->
    @include('backEnd.layouts.includes.stylesheet')
    <!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
    <!-- stylesheet end -->
		 <style>
        @media print {
  @page { margin: 0; }
  div.page {page-break-before: always;}
  .footer { position: fixed; bottom: 0px; }
      .footer:before { content: counter; }
  .footerr { position: fixed; bottom: 0px; }
      .footerr:before { content: counter; }
} 

    </style>
    </head>
    <body class="fixed">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <div class="wrapper">
    
<!--Content Header (Page header)-->
<div class="content-wrapper">
    <div class="main-content">
       <!--Content Header (Page header)-->

       <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

            <button style="float: right;" class="btn btn-success ml-2" onclick="printDiv('printableArea')"><i
                    class="typcn typcn-printer mr-1"></i>Print Invoice</button>
          
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="media-body">

                </div>

            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
     <div id="printableArea">
            <div class="body-content">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                @if($invoice->companydetails_id == 1)
                                <img src="{{ url('backEnd/image/kgsomani.png')}}" style="max-width:300px;"
                                    class="img-fluid mb-2" alt="">
                                <br>
                                @else
                                <address>
                                    <h2><strong style="color:rgb(0,31,95)">K G SOMANI & CO LLP</strong></h2>
                                    <strong style="margin-left: 66px;color:rgb(0,31,95)" >CHARTERED ACCOUNTANTS</strong><br>
                                </address>
                                @endif
                            </div>
                            <div class="col-sm-6 text-right">@if($invoice->companydetails_id == 1)<br><br>@else @endif
                                <div style="@if($invoice->companydetails_id == 2) color:rgb(0,0,0);font-size:21px  @else font-size:27px @endif">www.kgsomani.com</div>
                                <div class="text-@if($invoice->companydetails_id == 1)success @endif m-b-15" style="@if($invoice->companydetails_id == 2) color:rgb(0,0,0);font-size:21px  @else font-size:27px @endif">office@kgsomani.com</div>
                                @if($invoice->companydetails_id == 2)
                                <div style="font-size:17px;@if($invoice->companydetails_id == 2) color:rgb(0,0,0) @endif">LLP Identification No. AAX-5330
                                </div>@endif
                            </div>
                        </div>
                        <div class="">
                            <br/>
                            <br/>
                            <br/>
                            <h4>Kind Attn:<strong> {{ $invoice->contactname}}</strong><br> <b>{{ $invoice->client_name}}</b></h4>
                            <br/>
                            <br>
                           
                            <div class="clearfix"></div>
                            <p style="font-size:27px;">Dear Sir/Mam,</p>
                            <br>
                            <p style="font-size:27px;">We append a memo of our charges for @if($invoice->export == 1) {{ $invoice->code  }} @else
							 INR @endif {{ number_format($invoice->total) }} in connection with {{ $invoice->service }}</p>
                   <br/>
                   <br/>

                            <p style="font-size:21px;"><strong> @if($invoice->companydetails_id == 1) For K.G. Somani & Co. @else K G SOMANI & CO LLP  @endif</strong><br>
                  <b>Chartered Accountants   </b></p><br>
                   <br><br><br>  <br/>
                        <br/>  <br/>
                        <br/>
                    <p style="font-size:27px;">Authorised Signatory                   </p>
                        </div>
                        <br/>
                        <br/>
                        <br/>
					  <br/>
                        <br/>
               	
                    </div>
					  <div class="footer">
                        @if($invoice->companydetails_id == 1)
                        <div style="text-align:center; font-size:27px;" class="text-success m-b-15">3/15, ASAF ALI ROAD
                            NEW DELHI-110002 Tel: +91-1123252225, 23277677, 41403938
                        </div>
                        @else
                        <div style="text-align:center; font-size:18px;" class="text-success m-b-15"><span style="color:rgb(32,87,104)" >Regd. Office: 3/15, ASAF ALI ROAD NEW DELHI-110002
                            <br>  Corp Office: 4/1 Asaf Ali Road, 3rd Floor, Delite Cinema Building, Delhi 110002. Tel: +91-11-41403938, 23277677, 23252225
                        </span> <br><b><span style="color:rgb(0,31,95)">Converted from K G Somani & Co (Partnership firm) w.e.f 24th June 2021</span></b>
                          </div>

                        @endif
                    </div>
                </div>
                <br>
                <div class="card page">

                    <div class="card-body">
                        <div class="row">
                         <div class="col-sm-6">
                                @if($invoice->companydetails_id == 1)
                                <img src="{{ url('backEnd/image/kgsomani.png')}}" style="max-width:150px;"
                                    class="img-fluid mb-2" alt="">
                                @else
                                <address>
                                    <h2><strong style="color:rgb(0,31,95)">K G SOMANI & CO LLP</strong></h2>
                                    <strong style="margin-left: 66px;color:rgb(0,31,95)" >CHARTERED ACCOUNTANTS</strong><br>
                                </address>
                                @endif
                                <br>
                                @if($invoice->companydetails_id == 1)
                                <address>
                                    <strong>GSTIN No - 07AAAFK5666L1ZZ </strong><br>
                                    State: Delhi<br>
                                    State Code: 07 <br>
                                    {{-- <abbr title="Phone">P:</abbr> (123) 456-7890 --}}
                                </address>
                                @else
                                <address>
                                    <strong>GSTIN No - 07AAXFK6191P1Z6</strong><br>
                                    State: Delhi<br>
                                    State Code: 07 <br>
                                    {{-- <abbr title="Phone">P:</abbr> (123) 456-7890 --}}
                                </address>
                                @endif
                                <address>
                                    <strong>Email</strong><br>
                                    <a href="mailto:office@kgsomani.com">office@kgsomani.com</a>
                                </address>
                            </div>
                            <div class="col-sm-6 text-right">
                                @if($invoice->companydetails_id == 2)
                                <div style="font-size:21px;">www.kgsomani.com</div>
                                <div class="text m-b-15" style="color:rgb(0,0,0);font-size:21px">office@kgsomani.com</div>
                              
                                <div style="font-size:14px;">LLP Identification No. AAX-5330
                                </div>@endif
                                <h1 class="h5">Invoice No. {{ $invoice->invoice_id }}</h1>
								@if($invoice->gstno != null)
                                <strong>GSTIN No -  {{ $invoice->gstno }} </strong><br>
                                @endif
								@if($invoice->panno != null)
                                <strong>PAN No -  {{ $invoice->panno }} </strong><br>
                                @endif
								 @if($invoice->statecode != null)
								  <div> State Code: {{ $invoice->statecode }}</div>
								@endif
                                <div>Issued {{ date('F d,Y', strtotime($invoice->invoicedate)) }}</div>
                                {{-- <div class="text-danger m-b-15">Payment due April 21th, 2017</div> --}}
                                <address>
                                    <strong> {{ $invoice->client_name }}</strong><br>
                                    {{ $invoice->clientaddress }}<br>
                                    <abbr>Ph:</abbr>   {{ $invoice->phone }}
                                </address>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description of Services</th>
                                        <th>Service Accounting
                                            Code(SAC)
                                            </th>
                                        
                                          <th align="right">Amount @if($invoice->currency == 1)
											($) @endif @if($invoice->currency == 2)
											(AED) @endif
											@if($invoice->export == 2 || $invoice->export == 3 || $invoice->export == NULL) (₹) @endif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <small>{{ $invoice->service }}</small>
                                         </td>
                                       
                                        <td>{{ $invoice->saccode }}
                                        </td>
                                        {{-- <td>{{ $invoice->tax }}% @if($invoice->tax=='9')
                                            <span >CGST</span>
                                           @else
                                           <span>   IGST</span>
                                           @endif</td> --}}
                                        <td align="right">{{ number_format($invoice->amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td><small>Out Of Pocket Expense Amount</small></td>
                                        <td></td>
                                        <td align="right">{{ number_format($invoice->pocketexpenseamount) }}</td>
                                    </tr>
                                <tr>
                                   <td> <div><strong>Total</strong></div></td>
                                   <td></td>
                                   <td align="right">{{ number_format($invoice->amount +  $invoice->pocketexpenseamount) }}</td>
                                </tr>
                                 <tr>
                                   <td> @if($invoice->cgst !=null) <small>CGST{{ $invoice->cgst }}%</small>
                                    @else
                                    <small>CGST9%</small>
                                    @endif</td>
                                   <td></td>
                                   <td align="right">@if($invoice->cgst != null)
                                    {{ number_format(($invoice->amount +  $invoice->pocketexpenseamount)*$invoice->cgst/100) }}
                                @else
                            0
                            @endif</td>
                                </tr>
                                 <tr>
                                   <td>@if($invoice->sgst !=null) <small>SGST{{ $invoice->sgst }}%</small>
                                    @else
                                    <small>SGST9%</small>
                                    @endif
                                </td>
                                   <td></td>
                                   <td align="right">@if($invoice->sgst !=null)
                                    {{ number_format(($invoice->amount +  $invoice->pocketexpenseamount)*$invoice->sgst/100) }}
                                @else
                            0
                            @endif</td>
                                </tr>
                               <tr>
                                    <td>@if($invoice->igst !=null) <small>IGST{{ $invoice->igst }}%</small>
                                        @else
                                        <small>IGST18%</small>
                                        @endif
                                    </td>
                                   <td></td>
                                   <td align="right">@if($invoice->igst !=null)
                                    {{ number_format(($invoice->amount +  $invoice->pocketexpenseamount)*$invoice->igst/100) }}
                                @else
                            0
                            @endif</td>
                                </tr>
                                <tr>
                                   <td><div><strong>Total GST</strong></div></td>
                                   <td></td>
                                   <td align="right">@if($invoice->igst !=null)
                                    <b>{{ number_format(($invoice->amount +  $invoice->pocketexpenseamount)*$invoice->igst/100)  }}</b>
                                @else
                               <b> {{ number_format(($invoice->amount +  $invoice->pocketexpenseamount)*$invoice->cgst/100 + ($invoice->amount +  $invoice->pocketexpenseamount)*$invoice->sgst/100) }}</b>
                                @endif</td>
                                </tr>
                                <tr>
                                   <td><div><strong>Invoice Total</strong></div></td>
                                   <td></td>
                                   <td align="right"><b>{{ number_format($invoice->total) }}</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                @php
       $number = $invoice->total;
                                 $no = floor($number);
                                 $point = round($number - $no, 2) * 100;
                                 $hundred = null;
                                 $digits_1 = strlen($no);
                                 $i = 0;
                                 $str = array();
                                 $words = array('0' => '', '1' => 'one', '2' => 'two',
                                  '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                                  '7' => 'seven', '8' => 'eight', '9' => 'nine',
                                  '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                                  '13' => 'thirteen', '14' => 'fourteen',
                                  '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                                  '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                                  '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                                  '60' => 'sixty', '70' => 'seventy',
                                  '80' => 'eighty', '90' => 'ninety');
                                 $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
                                 while ($i < $digits_1) {
                                   $divider = ($i == 2) ? 10 : 100;
                                   $number = floor($no % $divider);
                                   $no = floor($no / $divider);
                                   $i += ($divider == 10) ? 1 : 2;
                                   if ($number) {
                                      $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                                      $hundred = null;
                                      $str [] = ($number < 21) ? $words[$number] .
                                          " " . $digits[$counter] . $plural . " " . $hundred
                                          :
                                          $words[floor($number / 10) * 10]
                                          . " " . $words[$number % 10] . " "
                                          . $digits[$counter] . $plural . " " . $hundred;
                                   } else $str[] = null;
                                }
                                $str = array_reverse($str);
                                $result = implode('', $str);
                                $points = ($point) ?
                                  "." . $words[$point / 10] . " " . 
                                        $words[$point = $point % 10] : '';
                              
                                @endphp
															    @php
                                  $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                                  @endphp
                              @if($invoice->export == 1)
                                <b>Amount chargeable (in words) </b>: {{ $invoice->value ??''}} {{ ucfirst($f->format($invoice->total)) }} only
                                @else
                                <b>Amount chargeable (in words) </b>: Rs. {{ $result }} only
                                @endif
                               <p> Company’s PAN: @if($invoice->companydetails_id == 1) AAAFK5666L @else
                                            AAXFK6191P @endif
                                        </p>
                                        @if($invoice->companydetails_id == 1)
                                        <p><b>Bank Details: </b>Account Name- K G Somani & Co, A/C Type-
                                            Current Account, HDFC Bank, A/c No 50200012225945, IFSC Code -HDFC0000314,
                                            Branch – Ansari Road , Daryaganj</p>
                                        @else
                                        <p><b>Bank Details: </b>Account Name- K G SOMANI AND CO. LLP, A/C Type-
                                            Current Account, HDFC Bank, A/c No 50200060133301, IFSC Code -HDFC0000314,
                                            Branch – Daryaganj</p>
                                        @endif
<p><b>Terms & Conditions: </b></p>
                                <p>1)   Please note that no TDS is deductible on G.S.T. included in the above Bill. </p>
                                 <p> 2)   As the G.S.T. charged in this invoice is to be deposited by us to the Government Account upon raising of the invoice (whether payment received or not), you are requested to make the payment within 15 days from the date of invoice.
                                    </p>
                                <p><strong>Thank you very much for choosing us. It was a pleasure to
                                        have worked with you.</strong></p>
								@if($invoice->export == 1)
								<p>Supply Meant For Export Under Letter Of Undertaking</p>
								@endif
                                <img src="assets/dist/img/credit/AM_mc_vs_ms_ae_UK.png" class="img-responsive" alt="">

                            </div>
                            <br>
                            <div class="col-sm-4">
                                <ul class="list-unstyled text-right">
                                    <li>
                                     <strong> @if($invoice->companydetails_id == 1) For K.G. Somani & Co. @else K G
                                            Somani & Co LLP @endif</strong> </li>
<br><br><br><br>             <li>
                                        <strong>Authorized Signatory</strong></li>
                                </ul>
                            </div>
                        </div>
						<br>
                       </div>
                       <div class="footerr">
                        @if($invoice->companydetails_id == 1)
                        <div style="text-align:center; font-size:27px;" class="text-success m-b-15">3/15, ASAF ALI ROAD
                            NEW DELHI-110002 Tel: +91-1123252225, 23277677, 41403938
                        </div>
                        @else
                        <div style="text-align:center; font-size:18px;" class="text-success m-b-15"><span style="color:rgb(32,87,104)" >Regd. Office: 3/15, ASAF ALI ROAD NEW DELHI-110002
                            <br>  Corp Office: 4/1 Asaf Ali Road, 3rd Floor, Delite Cinema Building, Delhi 110002. Tel: +91-11-41403938, 23277677, 23252225
                        </span> <br><b><span style="color:rgb(0,31,95)">Converted from K G Somani & Co (Partnership firm) w.e.f 24th June 2021</span>
                        </b> </div>

                        @endif
                    </div>
                </div>

            </div>
        </div>
        <!--/.body content-->
    </div>
    <!--/.main content-->

      <div class="overlay"></div>
</div>

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

</script>


</div><!--/.main content-->
</div><!--/.wrapper-->
</div>
<!-- js bar start-->
@include('backEnd.layouts.includes.js')


<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>

<!-- js bar end -->
</body>
</html>