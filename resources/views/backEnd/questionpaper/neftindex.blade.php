<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
  
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
                <a href="{{url('home')}}">
                    <h1 class="font-weight-bold" style="color:black;">Home</h1>
                </a>
                <small>NEFT Format List</small>
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
            <div class="table-responsive">
                <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>

                            <th>Transaction_Ref_No</th>
                            <th>Amount</th>
                            <th>ValueDate</th>
                            <th>Branch_Code</th>
                            <th>Sender_Account_Type</th>
                            <th>Remitter_Account_No</th>
                            <th>Remitter_Name</th>
                            <th>IFSC_Code</th>
                            <th>Debit_Account</th>
                            <th>Beneficiary_Account_type</th>
                            <th>Bank_Account_Number</th>
                            <th>Beneficiary_Name</th>
                            <th>Remittance_Details</th>
                            <th>Debit_Account_System</th>
                            <th>SMSEML</th>
                            {{-- <th>Edit</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($neftData as $information => $neftDatas)
                        <tr>

                            <td>NEFT{{$information  + 1 }}</td>
                            <td>{{$neftDatas->totalconveyance }}</td>
                            <td> {{ date('F d,Y', strtotime($neftDatas->created_at)) }}</td>
                            <td> 0314</td>
                            <td> 11</td>
                            <td> 50200060133301</td>
                            <td> KG SOMANI & CO. LLP</td>
                            <td>{{$neftDatas->ifsccode }}</td>
                            <td>50200060133301</td>
                            <td>SAVING</td>
                            <td>{{$neftDatas->bankaccountnumber}}</td>
                            <td>{{$neftDatas->name_as_per_bankaccount }}</td>
                            <td>NEFT</td>
                            <td>2</td>
                            <td>SMS</td>
                          
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
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
        dom: 'Bfrtip',
        "order": [[ 0, "asc" ]],
        
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

