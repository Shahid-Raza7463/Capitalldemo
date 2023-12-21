<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->

        
        <!--/.navbar-->
        <!--Content Header (Page header)-->

        <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

<button style="float: right;" class="btn btn-success ml-2" onclick="printDiv('printableArea')"><i
        class="typcn typcn-printer mr-1"></i>Export PDF</button>

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
        <div class="body-content" style="margin-left:30%;" >
    <div class="row">
        <div class="col-md-12 col-lg-12">
        <!-- <a class="btn btn-primary" href="{{ URL::to('/employee/pdf') }}">Export to PDF</a>         -->
  <div class="card" style="width:310px; color:#023568; height:490px;">
  <img class="card-img-top" src="{{url('backEnd/image/images.png')}}" alt="Card image" style="width:40%; margin-left:30%; margin-top:10px;"><br>
	  <center>
    <img src="{{ $userInfo->profilepic ??''}}" alt="Card image" style="width: 112px;height: 97px;" >
	  </center>
    <div class="card-body" style="text-align:center;">
      <h6 class="card-title" style=" color:#68ca37; text-transform: uppercase;"><b>{{$userInfo->team_member ??''}}</b></h6>
      <h6 class="card-title" style="text-transform: uppercase;"><b>DELHI</b></h6><br>
      <p style="font-size:11px;"><b style="float:left;">CONTACT NO </b> <b style="margin-left:22%;">:</b>
      <b style="color:#68ca37; float:right;">
      &nbsp;{{$userInfo->mobile_no ??''}}</b></p>
      <p style="font-size:11px;"><b style="float:left;">EMERGENCY CONTACT NO &nbsp; :</b>
       <b style="color:#68ca37; float:right;">&nbsp;{{$userInfo->emergencycontactnumber ??''}}</b></p>
      <br><hr style="border-width:2; color:black; background-color:black">
      <p><b>4/1 First Floor, Delite Cinema Hall, 
      Asaf Ali Road, New Delhi 110002 India <br>
          Ph No : 011 41403938<br>
          Email Id : office@kgsomani.com
</b></p>
    </div>
  </div>
                

        </div>
    </div>
</div>
<!--/.body content-->
      </div>
        <!--/.body content-->


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
@endsection


