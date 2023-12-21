<!-- <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet"> -->

<!--Third party Styles(used by this page)-->
<!-- <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet"> -->
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
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
                    href="{{url('/barchart?'.'partners='.$partnerData->id )}}">{{ $partnerData->team_member }}</a> 
                    @endforeach
                   
                
                </div>
            </div></li>
            <li class="breadcrumb-item"><a href="{{ url('invoiceassignmentreport/barchart')}}" class="btn btn-info-soft btn-sm" >Back</a></li>
        
        </ol>
@endif
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Summary of Invoices and Recoverables​</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
 <div class="row row-sm">
                    <div class="col-6">
               
    <div class="card mb-4">
        <div class="card-header">
        <form id="formselect">
                        <div class="form-group">
                        <div class="map_canvas">
  <label for="">Difference Between invoice date and final report date</label>
  <br>
  <br>
            <canvas id="myChart" width="auto" height="200" width="50"></canvas>
</div>

                        </div>
                   
					</form>
					</div>

					</div>  
					</div>

				
	
	

      <div class="col-6">
	
	 <div class="card mb-4">
        <div class="card-header">
        <form id="formselect">
                        <div class="form-group">
                        <div class="map_canvas">
                        <label for="">Difference Between Due date of recovery and invoice date</label>
  <br>
  <br>
  
            <canvas id="myChart2" width="auto" height="218" width="50"></canvas>
</div>

                        </div>
                    
</form>
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
                max: 100,
                min: 0,
                ticks: {
                    stepSize: 2
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

<script>
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels2) ?>,
        datasets: [{
            label: '',
            data: <?php echo json_encode($amounts2); ?>,
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
                max: 100,
                min: 0,
                ticks: {
                    stepSize: 2
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

  
