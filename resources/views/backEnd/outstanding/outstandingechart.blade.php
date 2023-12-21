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
      <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        @if(Auth::user()->role_id == 11)
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			 <li class="breadcrumb-item"> <div class="btn-group mb-2 mr-1">
                <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Choose Partner
                </button>
                <div class="dropdown-menu">
                    @foreach ($partner as $partnerData)
                    <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/partnerchart?'.'partners='.$partnerData->id )}}">{{ $partnerData->team_member }}</a> 
                    @endforeach
                   
                
                </div>
            </div></li>
            <li class="breadcrumb-item"><a href="{{ url('outstandingdashboard')}}" class="btn btn-info-soft btn-sm" >Back</a></li>
        
        </ol>
@endif
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Outstanding Charts</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
        
        <div id="printableArea">
            <div class="body-content">
            <div class="card-body">
                      
    <div class="row">

    <div class="col-sm-7">
    <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"> Summary of Outstanding</h3>
    </div>
    <div class="panel-body" align="center">

    <div class="map_canvas">
  
  <canvas id="myChart" width="auto" height="height:700px; width:450px;"></canvas>
</div>
</div>
</div>



    </div>

                            <div class="col-sm-5">
                        <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"> Outstanding</h3>
    </div>
    <div class="panel-body" align="center">
     <div id="pie_chart2" style="height:348px; width:450px;">

     </div>
    </div>
   </div>
    </div>


    
    

    </div>
       </div>
       </div>
       </div>
       </div>
     </div>

     <script src="https://cdnjs.com/libraries/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels) ?>,
        datasets: [{
            label: '',
            data: <?php echo json_encode($amounts); ?>,
            backgroundColor: [
                'rgba(31, 58, 147, 1)',
                'rgba(37, 116, 169, 1)',
                'rgba(92, 151, 191, 1)',
                'rgb(200, 247, 197)',
                'rgb(77, 175, 124)',
                'rgb(30, 130, 76)'
            ],
            borderColor: [
                'rgba(31, 58, 147, 1)',
                'rgba(37, 116, 169, 1)',
                'rgba(92, 151, 191, 1)',
                'rgb(200, 247, 197)',
                'rgb(77, 175, 124)',
                'rgb(30, 130, 76)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
               max: 1000000,
                min: 0,
                ticks: {
                    stepSize: 60000
                }
            }
        },
        plugins: {
            title: {
                display: false,
                text: 'Custom Chart Title'
            },
            legend: {
                display: false,
            }
        }
    }
});
</script>

      
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
   
   var analytics = <?php echo $outstandingdata; ?>

   google.charts.load('current', {'packages':['corechart']});

   google.charts.setOnLoadCallback(drawChart);

  

   function drawChart()
   {
    var data = google.visualization.arrayToDataTable(analytics);
    var options = {
     title : 'Percentage of Key Controls',
     width: 400,
  height: 240,
  title: 'Outstanding',
  colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
    };
    var chart = new google.visualization.PieChart(document.getElementById('pie_chart2'));
    chart.draw(data, options);
   
   }
//    var analytics1 = 
// //dd(analytics1);
// google.charts.load('current', {'packages':['corechart']});

// google.charts.setOnLoadCallback(drawChart1);
//    function drawChart1()
//    {
//     var data = google.visualization.arrayToDataTable(analytics1);
//     var options = {
//      title : 'Percentage of Design Gap'
//     };
  
//     var chart = new google.visualization.PieChart(document.getElementById('pie_chart1'));
//     chart.draw(data, options);
//    }

//    var analytics2 = 
// //dd(analytics1);
// google.charts.load('current', {'packages':['corechart']});

// google.charts.setOnLoadCallback(drawChart2);
//    function drawChart2()
//    {
//     var data = google.visualization.arrayToDataTable(analytics2);
//     var options = {
//      title : 'Percentage of Result'
//     };
  
//     var chart = new google.visualization.PieChart(document.getElementById('pie_chart2'));
//     chart.draw(data, options);
//    }
  </script>
  
  