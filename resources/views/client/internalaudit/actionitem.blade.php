@extends('client.layouts.layout') @section('client_content')
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    {{-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('task/create')}}">Add task</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav> --}}
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Action Tracker Database List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
     @component('backEnd.components.alert')

        @endcomponent
       
            <div class="card-body">
                <div class="row">
            <div class="col-md-4">
                <!--Active users indicator-->
                <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
                    <div style="color:white;" class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">No. Open Findings</div>
                    <div class="fs-32 text-monospace">{{ count($statuscount) }}</div>
                    {{-- <small>Latest Assignment</small> --}}
                </div>
            </div>
            <div class="col-md-4">
                <!--Active users indicator-->
                <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                    <div style="color:white;" class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">No. Actions</div>
                    <div class="fs-32 text-monospace">{{ count($internalaudit) }}</div>
                    {{-- <small>active Assignment</small> --}}
                </div>
            </div>
          <div class="col-md-4">
                <!--Active users indicator-->
                <div class="p-2 bg-danger text-white rounded mb-3 p-3 shadow-sm text-center">
                    <a href="{{url('tender')}}" >
                    <div style="color:white;" class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">No. Overdue Findings</div>
                    <div style="color:white;" class="fs-32 text-monospace">{{ count($Overdue) }}</div>
                    {{-- <small style="color:white;" >latest tender</small> --}}
                    </a>
                </div>
            </div>
            </div>
                    <div class="table-responsive">
                        <table class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Business Entity</th>
                                    <th>Open</th>
                                    <th>Overdue</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                             @foreach ($business as $entity)
                                     <tr>
                                        <td>{{$entity->Business_Entity}}</td>
                                        <td><input onchange="change(event , {{$entity->id}},'Open')" type="number" min="0" value="{{$entity->Open ? $entity->Open : 0}}" style="width: 70px; -moz-appearance: textfield; "></td>
                                        <td><input onchange="change(event , {{$entity->id}},'Overdue')" type="number" min="0" value="{{$entity->Overdue ? $entity->Overdue : 0}}" style="width: 70px; -moz-appearance: textfield; "></td>  
                                     </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
            
            </div>
     
        </div>
            <div class="card mb-4">
             
                <div class="card-body">
                   
                        <div id="barchart_material" style="height: 400px;"></div>
                   
                </div>
            </div>
    </div>
<!--/.body content-->


@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 
  function hello(xyz)
  {
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(function(){
    drawChart(xyz);
  });
  }
  
  var abc = @php
    echo $business;
  @endphp;

  hello(abc);
  
 
  function drawChart(response) {
    
    var dataArray = [['Business Entity','Open','Overdue']];  
    $.each(response,function (index, business) {  
        dataArray.push([business.Business_Entity,business.Open,business.Overdue]);  
    });
    // console.log(dataArray);
    var data = google.visualization.arrayToDataTable(dataArray);

    var options = {
      chart: {
        title: 'Open Actions Per Business Entity',
      },
      bars: 'vertical',
      // legend: { position: 'top', maxLines: 3 },
      isStacked: true,
    };
    var chart = new google.charts.Bar(document.getElementById('barchart_material'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
  }


  function change(event,id,type)
  {
    // alert(event.currentTarget.value);
    $.ajax({
      type: "POST",
      data: {
        'value': event.currentTarget.value,
        'type': type,
        _token: "{{ csrf_token() }}",
      },
      url: "{{ url('/client/actionitem/change') }}"+"/"+id, 
      success: function(result){
           drawChart(result);
      }});    
  }

</script>