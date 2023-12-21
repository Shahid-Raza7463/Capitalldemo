@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->

<div class="content-header row align-items-center m-0"  >

    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
         
        <input type="button" onclick="printDiv('printableArea')" value="Print " />
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1><br>
                <br>

                <p style="color:#ffb158; font: 25px Arial, Geneva, Helvetica, sans-serif; margin-bottom: -10px;"><b>HBR
                        TOOLS</b></p>
                <p style="color:black ; font-size:20px"><b>BUSINESS VALUATION</b> </p>
            </div>
        </div>
    </div>
  </div>
 <!--Content Header (Page header)-->
  <div class="body-content"  >
    <div class="card mb-4" id="printableArea" >


        <div class="card-body" >
            @component('backEnd.components.alert')
            @endcomponent
            <p style="color:black ; font-size:20px ; font-weight: bold ;font-family: Brushstroke, fantasy; ">BOOK VALUE
                MODEL: YOUR MODEL </p>

            <div class="form-row"  >
                <div class="form-group col-md-6"  style=" background-color:#f9cd48bd;">
                    <label style="color:black ; font-size:20px ; font-weight: bold ;">Fiscal Year</label>
                </div>
                <div class="form-group col-md-3" style=" background-color:#f9cd48bd;">

                    <label
                        style="color:black ; font-size:20px ; font-weight: bold ;font-family:Arial, Helvetica, sans-serif">2020</label>
                </div>
                <div class="form-group col-md-3" style=" background-color:#f9cd48bd;">
                    <label
                        style="color:black ; font-size:20px ; font-weight: bold ;font-family:Arial, Helvetica, sans-serif">2021</label>
                </div>
               
                <div class="col-md-5">
                    <label>Total shareholders' equity</label>
                </div>
                <div class="form-group col-md-3">
                    <input  type="text" class="form-control" id="myInput1" onchange="myChangeFunction(this)">
                </div>
                <div class="form-group col-md-3">
                    <input  type="text" class="form-control" id="myInput3" onchange="myChangeFunctiontwo(this)">
                </div>
               
            </div> </div>

        <div class="card-body" >
            <p style="color:black ; font-size:20px ; font-weight: bold ;font-family: Brushstroke, fantasy; ">Weighted Book Value Multiple Methodology </p><br>
   
            <div class="form-row"  >
            <div class="form-group col-md-12" style="background-color:#c6cbd3;">
                    <label >Multiple</label>
                </div>
                <div class="col-md-5">
                    <label>Weighting</label>
                </div>
                <div class="form-group col-md-2 mb-2">
                    <input  type="text" class="form-control"  id="a">
                </div>
                <div class="form-group col-md-2 mb-2">
                    <input   type="text" class="form-control" onkeyup="add()" id="b">
                </div>
                <div class="form-group col-md-2 mb-2">
                    <input  type="text" class="form-control" id="c">
                </div>
            

                <div class="form-group col-md-6" style=" background-color:#f9cd48bd;">
                    <label style="color:black ; font-size:20px ; font-weight: bold ;">Fiscal Year</label>
                </div>
                <div class="form-group col-md-2"style=" background-color:#f9cd48bd;">

                    <label
                        style="color:black ; font-size:20px ; font-weight: bold ;font-family:Arial, Helvetica, sans-serif">2020</label>
                </div>
                <div class="form-group col-md-2"style=" background-color:#f9cd48bd;">
                    <label
                        style="color:black ; font-size:20px ; font-weight: bold ;font-family:Arial, Helvetica, sans-serif">2021</label>
                </div>
                <div class="form-group col-md-2"style=" background-color:#f9cd48bd;">
                    <label
                        style="color:black ; font-size:20px ; font-weight: bold ;font-family:Arial, Helvetica, sans-serif">Balance</label>
                </div>
               <br>
               <br>
                <div class="col-md-5">
                    <label>Weighted Book Value</label>
                </div>
                <div class="form-group col-md-2 ">
                    <input type="text" class="form-control"  id="myInput2" >
                </div>
                <div class="form-group col-md-2 ">
                    <input   type="text" class="form-control"  id="myInput4">
                </div>
                <div class="form-group col-md-2 ">
                    <input  type="text" class="form-control">
                </div>
                
           <br>
            
             <div class="form-group col-md-6"> </div>
                <div class="form-group col-md-2 ">
                    <input type="text"  class="form-control"></input>
                </div>
                <div class="form-group col-md-2">
                    <label
                        style="color:black ; font-size:20px ; font-weight: bold ;font-family:Arial">Weighted Average Book Value</label>
                </div>

                <div class="form-group col-md-8"> </div>
                <div class="form-group col-md-2">
                    <input type="text"  class="form-control"></input>
                </div>
                <div class="form-group col-md-2">
                    <label
                        style="color:black ; font-size:20px ; font-weight: bold ;font-family:Arial, Helvetica, sans-serif">Balance</label>
                </div>
               
               

            </div>



        </div>
    </div>
</div>

<script type="text/javascript">
//adition
function add() {
  var x = parseInt(document.getElementById("a").value);
  var y = parseInt(document.getElementById("b").value)
  document.getElementById("c").value = x * y;
}
//end

//print the page
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
//end 

//fetching the value
 function myChangeFunction(input1) {
    var input2 = document.getElementById('myInput2');
    input2.value = input1.value;
}
 //second
  function myChangeFunctiontwo(input3) {
    var input4 = document.getElementById('myInput4');
    input4.value = input3.value;
  }


</script>

<!--/.body content-->

@endsection