
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item">  <button onclick="printDiv('printableArea')" class="btn btn-info"><i class="fa fa-print"></i> Print</button></li>
           
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Confirmation Pdf</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content" >
    <div class="card mb-4 invoice">
        <div class="card-body" id="printableArea">
          
<p><strong>{{ $debtorpdf->name ??'' }}</strong></p> <br /> <br />
<p><strong>Reg. Confirmation of Balance as on 31.03.2021 (DATE)</strong> <br /> <br /> Dear Sir, <br /> We <strong>M/s
        K.G.Somani &amp; Co. Chartered accountants</strong> are the statutory Auditors of M/s ( {{ $debtorpdf->name}} ) for the
    Financial Year {{ $debtorpdf->year ??'' }}. For the Audit purpose, we require the confirmation of the outstanding balance of the company in
    your books of account as on {{ date('F d,Y', strtotime($debtorpdf->date)) }}. <br /> <br /> We request you to confirm the balance at the place provided below
    and send the duly signed copy of the same to our address given below. Also share the balance confirmation copy
    through mail on our mail id <a href="mailto:office@kgsomani.com">office@kgsomani.com</a> <br /> <br /> M/s K G
    Somani &amp; Co. (Chartered Accountants)<br /> 3rd Floor, Gate no.2, Delite Cinema Building, Asaf Ali Road,<br />
    New Delhi &ndash; 110002<br /> <br /> An early action would be highly appreciated <br /> <br /> Thanking You, <br />
    <br /> <strong>Yours Faithfully</strong> <br /> <br /> <strong>FOR K.G Somani &amp; Co.</strong> <br />
    <strong>Chartered Accountants</strong> <br /> <br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />
    <strong>(Authorised Signatory)</strong> </p>
<p>&nbsp;</p>
<hr />
<p><br /> <br /> <span style="text-decoration: underline;"><strong>Confirmation</strong></span><br /> <br /> We
    confirm that the in our books of account, the outstanding balance of M/s Banswara Syntex Limited as on 31.03.2021 is
    <span style="color: #ff6600;">Rs ______</span> <br /> </p>

<p>&nbsp;</p>
<p><em>NOTICE: Information, including attachments if any, contained through this email is confidential and intended for
        a specific individual and purpose, and is protected by law. If you are not the intended recipient any use,
        distribution, transmission, copying or disclosure of this information in any way or in any manner is strictly
        prohibited. You should delete this message and inform the sender. </em></p>
<p>&nbsp;</p>


        </div>
		
    </div>
	  <div class="card mb-4">
<div class="card-body">
	    <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                           
                            <th> Name</th>
                            <th>Amount</th>
                            <th>Remark</th>
                            <th>File</th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($debtorconfirmation as $taskData)
                        <tr>
                            <td>{{ $taskData->name ??''}}</td>
							                             <td>{{ $taskData->amount ??''}}</td>
                                                        <td>{{ $taskData->remark ??''}}</td>
							                            <td><a target="blank"
                                href="{{ url('storage/app/backEnd/image/confirmationfile/'. $taskData->file) }}">{{ $taskData->file ??''}}<a></td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
	</div>
</div>
</div><!--/.body content-->
<script>
  function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
@endsection


