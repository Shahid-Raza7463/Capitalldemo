<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-wrapper">
    <div class="main-content">
     
<div class="content-header row align-items-center m-0">
  
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>IFCS Charts</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
        
        <div id="printableArea">
            <div class="body-content">
            <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                        <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"> Key Controls</h3>
    </div>
    <div class="panel-body" align="center">
     <div id="pie_chart" style="height:450px; width:440px;">

     </div>
    </div>
   </div>
    </div>

    <div class="col-sm-6">
                        <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Design Gap </h3>
    </div>
    <div class="panel-body" align="center">
     <div id="pie_chart1" style="height:450px; width:440px;">

     </div>
    </div>
   </div>
    </div>

    </div>
    <div class="row">
                            <div class="col-sm-6">
                        <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"> Result</h3>
    </div>
    <div class="panel-body" align="center">
     <div id="pie_chart2" style="height:450px; width:440px;">

     </div>
    </div>
   </div>
    </div>

    

    </div>
       </div>
       </div>
       </div>
       </div>
     
      
@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 
  <style type="text/css">
   .box{
    width:800px;
    margin:0 auto;
   }
  </style>
  <script type="text/javascript">
   var analytics = <?php echo $whether_key; ?>

   google.charts.load('current', {'packages':['corechart']});

   google.charts.setOnLoadCallback(drawChart);

  

   function drawChart()
   {
    var data = google.visualization.arrayToDataTable(analytics);
    var options = {
     title : 'Percentage of Key Controls',
  colors: ['#3366cc', 'red', '#37a000', '#f3b49f', '#f6c7b6']
    };
    var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
    chart.draw(data, options);
   
   }
   var analytics1 = <?php echo $process_design_gap; ?>
//dd(analytics1);
google.charts.load('current', {'packages':['corechart']});

google.charts.setOnLoadCallback(drawChart1);
   function drawChart1()
   {
    var data = google.visualization.arrayToDataTable(analytics1);
    var options = {
     title : 'Percentage of Design Gap',
     colors: ['#3366cc', 'red', '#37a000', '#f3b49f', '#f6c7b6']
    };
  
    var chart = new google.visualization.PieChart(document.getElementById('pie_chart1'));
    chart.draw(data, options);
   }

   var analytics2 = <?php echo $Results; ?>
//dd(analytics1);
google.charts.load('current', {'packages':['corechart']});

google.charts.setOnLoadCallback(drawChart2);
   function drawChart2()
   {
    var data = google.visualization.arrayToDataTable(analytics2);
    var options = {
     title : 'Percentage of Result',
     colors: ['#3366cc', 'green', 'red', '#f3b49f', '#f6c7b6']
    };
  
    var chart = new google.visualization.PieChart(document.getElementById('pie_chart2'));
    chart.draw(data, options);
   }
  </script>