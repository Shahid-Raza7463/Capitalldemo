<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <a href="{{ url('check-In/create/') }}" style="float: right;" class="btn btn-success ml-2">Check-In</a>
		  <a href="{{ url('check-In/'.auth()->user()->teammember_id.'/edit') }}" style="float: right;" class="btn btn-success ml-2"> Check-Out</a>
      
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>From now on you will start your CheckIn.</small>
            </div>
        </div>
    </div>
</div>

<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">


    <div class="card-header">
            <form method="GET" action="{{ url('check-In/search')}}">

                <div class="row row-sm">

                    <div class="col-5">
                        <div class="form-group">
                            <label class="font-weight-600">Select Month *</label>
                           <select required class=" form-control" id="category" name="month"> 
                           <option selected value=''>--Select Month--</option>
                            <option  value='1'>January</option>
                            <option value='2'>February</option>
                            <option value='3'>March</option>
                            <option value='4'>April</option>
                            <option value='5'>May</option>
                            <option value='6'>June</option>
                            <option value='7'>July</option>
                            <option value='8'>August</option>
                            <option value='9'>September</option>
                            <option value='10'>October</option>
                            <option value='11'>November</option>
                            <option value='12'>December</option>
                            
                        
                    </select>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
           
            <br>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive example">

                        <div class="table-responsive">
                             <table id="exampleee" class="display nowrap">
                    <thead>
                    <tr>
                                        <th style="display:none">Id </th>
                                        <th>Date </th>
                                        <th>Time </th>
                                        <th>Employee Name</th>
                                        <th>Checked in</th>
                                        <th>Type</th>
                                        <th>Client</th>
                                        <td>Assigment</td>
                                        <th>Client Place</th>
										<th>Check-In Location </th>
										 <th>Check Out Time</th>
                                        <!--<th>Send on whatsapp</th>-->
                                       

                                    </tr>
                                     </thead>
                                <tbody>
                                @foreach($checkIn as $checkIns)
                                    <tr>
                                        <td style="display:none;">{{$checkIns->id ??''}}</td>
                                        <td>{{ date('F d,Y', strtotime($checkIns->date)) ??''}}</td>
                                       
                                        <td>{{ date('h:i a', strtotime($checkIns->time)) ??''}}</td>
                                        
                                        <td>


                                            {{ App\Models\Teammember::where('id',$checkIns->teammember_id)->pluck('team_member')->first() ??''}}<br>
                                     </td>
                                     <td>{{$checkIns->checkin_from ??''}}</td>
                                     <td>{{$checkIns->typeval ??''}}</td>
                                     <td>{{$checkIns->client_name ??''}}</td>
                                     <td>{{$checkIns->assignment_name ??''}}</td>
                                     <td>{{$checkIns->place ??''}}</td>
										@if($checkIns->place !=NULL)
										<td>
                                            <a href="https://maps.google.com/?q={{ $checkIns->latitude }},{{ $checkIns->longitude }}" class="btn btn-success"> <i class="fas fa-map"></i></a>
 </td>

										@else
										<td></td>
										@endif
										
                                     @if($checkIns->checkout_time!=null)
                                     <td>{{ date('h:i a', strtotime($checkIns->checkout_time)) ??''}}</td>
                                     @else
                                     <td></td>
                                     @endif
                                    <!-- <td><i class="hvr-buzz-out fab fa-whatsapp"></i></td>-->
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

                <br>
                <div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--/.body content-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>

<script>
     $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
         
        $.ajax({
              type: "GET",
              dataType: "json",
              url: "{{ url('/changeteamStatus') }}",
              data: {'status': status, 'user_id': user_id},
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
  </script>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function () {
        $('#exampleee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"],
                [1, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });

</script>
<script>$(document).ready(function() {
    $('#examplee').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 0, "desc" ]],
        
        buttons: [
            
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            'colvis'      
    ]  
    } );
} );</script> 
     <!-- Modal -->
