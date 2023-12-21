
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
          <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			 <li class="breadcrumb-item"> <div class="btn-group mb-2 mr-1">
                <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Choose Month
                </button>
                <div class="dropdown-menu">
					<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/payrollarticless?'.'month='.'May')}}">May</a>
					<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/payrollarticless?'.'month='.'April')}}">April</a>
					<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/payrollarticless?'.'month='.'March')}}">March</a>
					<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/payrollarticless?'.'month='.'February')}}">February</a>
					<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/payrollarticless?'.'month='.'January')}}">January</a>
					<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/payrollarticless?'.'month='.'December')}}">December</a>
                    <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/payrollarticless?'.'month='.'November')}}">November</a>
                    <a style="color: #37A000" class="dropdown-item"
                        href="{{url('/payrollarticless?'.'month='.'October')}}">October</a>
                      <a style="color: #37A000" class="dropdown-item"
                        href="{{url('/payrollarticless?'.'month='.'September')}}">September</a>
                   
                </div>
            </div></li>
            <li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"  data-toggle="modal" data-target="#exampleModal1">Add Excel</a></li>
        
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Article Payroll List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <form  method="post" >
                @csrf
            <div class="table-responsive">
                <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
                            <th><button type="submit"
                                onclick="return confirm('Are you sure you want to process this item?');"
                                 formaction="payrollarticleneftprocess" class="btn btn-danger-soft btn-sm">NEFT</button>
                                 <input type="checkbox" id="chkAll">
                               <i class="os-icon os-icon-trash"></i></th>
							<th>Bank Account Details</th>
                               <th>Status </th>
							  <th>Month </th>
                             <th>Name of Employee </th>
							 <th>Entity</th>
                            <th>Location</th>
                             <th>Category</th> 
                            <th>Date Of Joining</th>
                             <th>Year</th>
                            <th>Stipend</th>
                            <th>Total No of days</th>
                            <th>No Of Days Present</th>
                            <th> Leave</th>
                            <th>Compensatory Off (CO)</th>
                            <th>Birthday Leave</th>
                            <th>Total Days to be paid</th>
                            <th>Total Stipend</th>
                            <th>Arrear</th>
                          <th>Amount to be paid</th>
							
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payrollData as $payrollDatas)
                        <tr>
                            <td><input type="checkbox" name="ids[]" style="width: 18px;margin-left: 16px;"
                                class="selectbox" value="{{$payrollDatas->id}}"></td>
							  <td>@if($payrollDatas->verify==1)
                                <span class="badge badge-pill badge-success">Verified</span>
                                @else
                                <span class="badge badge-pill badge-danger">Not Verified</span>
                                @endif
                            </td>
                                <td>@if($payrollDatas->neftstatus==1)
                                    <span class="badge badge-pill badge-success">Neft Created</span>
                                    @else
                                    <span class="badge badge-pill badge-danger">Not Created</span>
                                    @endif
                                </td>
							 <td>{{ $payrollDatas->month ??'' }}</td>
                        <td>{{ $payrollDatas->team_member }}</td>
                          <td>{{ $payrollDatas->entity }}</td>
                            <td> {{ $payrollDatas->location }}</td>
                            <td> {{ $payrollDatas->category }}</td>
                            <td> {{ $payrollDatas->doj }}</td>
                            <td> {{ $payrollDatas->year }}</td>
                            <td> {{ $payrollDatas->stipend }}</td>
                            <td> {{ $payrollDatas->totalnoofdays }}</td>
                           <td> {{ $payrollDatas->noofdayspresent }}</td>
                           <td> {{ $payrollDatas->leave }}</td>
                           <td> {{ $payrollDatas->co }}</td>
                           <td> {{ $payrollDatas->birthdayleave }}</td>
                           <td> {{ $payrollDatas->totaldaystobepaid }}</td>
                           <td> {{ $payrollDatas->totalstipend }}</td>
                           <td> {{ $payrollDatas->arrear }}</td>
                           <td> {{ $payrollDatas->amounttobepaid }}</td>
							 
                             </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </form>
        </div>
    </div>

</div>
<!--/.body content-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('payrollarticle/upload')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

					 <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Select Month :</label>
                        <div class="col-sm-9">
                          <select name="month" required class="form-control">
            <!--placeholder-->
							     <option value="May">May</option>
							   <option value="April">April</option>
							  <option value="March">March</option>
							   <option value="February">February</option>
							  <option value="January">January</option>
     <option value="December">December</option>
            <option value="November">November</option>
            <option value="October">October</option>
            <option value="September">September</option>
           
        </select>
                          
                        </div>

                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="file" type="file">
                          
                        </div>

                    </div>

                    <div class="details-form-field form-group row">
                        <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                        <div class="col-sm-9">
                            <a href="{{ url('backEnd/Payrollarticle.xlsx')}}" class="btn btn-success btn">Download<i
                                    class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $.('.selectall').click(function(){
        $.('selectbox').prop('checked',$(this).prop('checked'));
    })
    $('.selectbox').change(function(){
        var total=$.('.selectbox').length;
        var number=$.('.selecbox:checked').length;
        if(total==number)
        {
            $('.selectall').prop('checked',true);
        }
        else
        $('.selectall').prop('checked',false);
       
    });
    </script>
<script type="text/javascript">
    $(function () {
        $("#chkAll").click(function () {
            $("input[name='ids[]']").attr("checked", this.checked);
        });
        $('#example11').DataTable({
        });
    });
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
<script>$(document).ready(function() {
    $('#examplee').DataTable( {
        "pageLength": 150,
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