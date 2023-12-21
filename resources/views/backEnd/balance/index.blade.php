 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">


 <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
 @extends('backEnd.layouts.layout') @section('backEnd_content')

 <!--Content Header (Page header)-->
 <div class="content-header row align-items-center m-0">
     <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
         <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
             <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Balance</a></li>
         </ol>
     </nav>
     <div class="col-sm-8 header-title p-0">
         <div class="media">
             <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
             <div class="media-body">
                 <h1 class="font-weight-bold">Home</h1>
                 <small>Balance
                     List</small>
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
             <div class="table-responsive">
                 <table id="examplee" class="display nowrap">
                     <thead>
                         <tr>
                             <th style="display: none;">id</th>
                             <th>Company</th>
							  <th>Bank </th>
                             <th>Bank Balance</th>
                             <th>Swipping FDR Balance</th>
                             <th>Created By</th>
                             <th>Date</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach($balanceDatas as $balanceData)
                         <tr>

                             <td style="display: none;">{{$balanceData->id }}</td>
                             <td>{{ $balanceData->company_name ??''}} </td>
							  <td>{{ $balanceData->balance ??''}} </td>
                             <td>{{ $balanceData->bank_balance ??''}} </td>
                             <td>{{ $balanceData->swipping_fdr_balance ??''}} </td>
                             <td>{{ $balanceData->Name ??''}} </td>
                             <td>{{ date('F d,Y', strtotime($balanceData->created_at ??'')) }}</td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

 </div>
 <!--/.body content-->
 <!-- Modal -->
 <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <form method="post" action="{{ route('balance.store')}}" enctype="multipart/form-data">

                 @csrf
                 <div class="modal-header" style="background: #37A000">
                     <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Balance
                     </h5>
                     <div>
                         <ul>
                             @foreach ($errors->all() as $e)
                             <li style="color:red;">{{$e}}</li>
                             @endforeach
                         </ul>
                     </div>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="row row-sm">
                         <div class="col-sm-6">
                             <label for="name" class="font-weight-600">Company :</label>
                             <select required class="language form-control" id="leave" name="companydetails_id">
                                 <option value="">Please Select One</option>
                                 @foreach($company as $companyData)
                                 <option value="{{$companyData->id}}">
                                     {{ $companyData->company_name }}</option>

                                 @endforeach
                             </select>
                         </div>
                         <div class="col-sm-6">
                            <label for="name" class="font-weight-600">Bank Name :</label>
                            <input required placeholder=" Enter Bank Name" class="form-control"
                                name="balance" type="text">

                        </div>
                     </div>
                     <br>
                     <div class="row row-sm">
                        <div class="col-sm-6">
                            <label for="name" class="font-weight-600">Bank Balance :</label>
                            <input id="contactemail" required placeholder=" Enter Bank Balance" class="form-control"
                                name="bank_balance" type="text">

                        </div>
                         <div class="col-sm-6">
                             <label for="name" class="font-weight-600">Sweeping FDR Balance :</label>
                             <input id="contactemail" required placeholder=" Enter Swipping FDR Balance" class="form-control"
                                 name="swipping_fdr_balance" type="text">

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
         $('#examplee').DataTable({
             dom: 'Bfrtip',
             "order": [
                 [0, "desc"]
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
