 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">


 <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
 @extends('backEnd.layouts.layout') @section('backEnd_content')
     <style>
         .select2-container {
             width: 48% !important;
         }
     </style>
     <!--Content Header (Page header)-->
     <div class="content-header row align-items-center m-0">
         <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
             @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                 @if (Request::is('teamapplication/store'))
                     <a href="{{ url('applyleave') }}" style="float: right" class="btn btn-success ml-2">Back</a>
                 @endif
                 @if (Request::is('applyleave'))
                     <a href="{{ url('applyleave/create/') }}" style="float: right;" class="btn btn-success ml-2">Apply
                         Leave</a>
                 @endif
             @endif
             <form method="post" action="{{ url('teamapplication/store') }}" enctype="multipart/form-data">
                 @csrf
                 <button type="submit" style="float: right;" class="btn btn-success" style="float:right"> Submit</button>
                 <select class="language form-control" id="exampleFormControlSelect1" name="member"
                     @if (Request::is('applyleave/*/edit')) > <option disabled style="display:block">Please Select One
                 </option>

                 @foreach ($teammember as $teammemberData)
                 <option value="{{ $teammemberData->id }}"
                     {{ $applyleave->Approver == $teammemberData->id ?? '' ? 'selected="selected"' : '' }}>
                     {{ $teammemberData->team_member }}( {{ $teammemberData->role->rolename }} )</option>
                 @endforeach


                 @else
                 <option></option>
                 <option value="">Please Select One</option>
                 @foreach ($teammember as $teammemberData)
                 <option value="{{ $teammemberData->id }}">
                     <a href="{{ url('teamapplication/' . $teammemberData->id) }}"> {{ $teammemberData->team_member }} </a></option>

                 @endforeach @endif
                     </select>
             </form>

         </nav>
         <div class="col-sm-8 header-title p-0">
             <div class="media">
                 <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                 <div class="media-body">
                     <h1 class="font-weight-bold">Home</h1>
                     <small>From now on you will start your activities.</small>
                 </div>
             </div>
         </div>
     </div>
     <div class="body-content">



     </div>
     <!--/.Content Header (Page header)-->
     <div class="body-content">
         <div class="card mb-4">
             <div class="card-header" style="background:#37A000">

                 <div class="d-flex justify-content-between align-items-center">

                     <div>
                         <h6 class="fs-17 font-weight-600 mb-0">
                             <span style="color:white;">Apply Leave List</span>

                         </h6>
                     </div>

                 </div>
             </div>
             <div class="card-body">
                 @component('backEnd.components.alert')
                 @endcomponent
                 <div class="table-responsive">
                     {{-- filtering functionality --}}
                     <div class="row row-sm">
                         <div class="col-4">
                             <div class="form-group">
                                 <label class="font-weight-600">Employee</label>
                                 <select class="language form-control" id="employee1" name="employee">
                                     <option value="">Please Select One</option>
                                     @php
                                         $displayedValues = [];
                                     @endphp
                                     @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                         @if (!in_array($applyleaveDatas->team_member, $displayedValues))
                                             <option value="{{ $applyleaveDatas->createdby }}">
                                                 {{ $applyleaveDatas->team_member }}
                                             </option>
                                             @php
                                                 $displayedValues[] = $applyleaveDatas->team_member;
                                             @endphp
                                         @endif
                                     @endforeach
                                 </select>
                             </div>
                         </div>

                         <div class="col-4">
                             <div class="form-group">
                                 <label class="font-weight-600">Leave Type</label>
                                 <select class="language form-control" id="leave1" name="leave">
                                     <option value="">Please Select One</option>
                                     @php
                                         $displayedValues = [];
                                     @endphp
                                     @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                         @if (!in_array($applyleaveDatas->name, $displayedValues))
                                             <option value="{{ $applyleaveDatas->leavetype }}">
                                                 {{ $applyleaveDatas->name }}
                                             </option>
                                             @php
                                                 $displayedValues[] = $applyleaveDatas->name;
                                             @endphp
                                         @endif
                                     @endforeach
                                 </select>
                             </div>
                         </div>

                         <div class="col-4">
                             <div class="form-group ">
                                 <label class="font-weight-600">Status</label>
                                 <select class="language form-control" id="status1" name="status">
                                     <option value="">Please Select One</option>
                                     @php
                                         $displayedValues = [];
                                     @endphp
                                     @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                         @if (!in_array($applyleaveDatas->status, $displayedValues))
                                             <option value="{{ $applyleaveDatas->status }}">
                                                 @if ($applyleaveDatas->status == 0)
                                                     Created
                                                 @elseif($applyleaveDatas->status == 1)
                                                     Approved
                                                 @else
                                                     Rejected
                                                 @endif
                                             </option>
                                             @php
                                                 $displayedValues[] = $applyleaveDatas->status;
                                             @endphp
                                         @endif
                                     @endforeach
                                 </select>
                                 <button id="clickExcell" style="display: none; float:right;position: relative; top: -42px;"
                                     class="btn btn-success">Download</button>
                             </div>
                         </div>
                     </div>

                     <div class="row row-sm">
                         <div class="col-3">
                             <div class="form-group">
                                 <label class="font-weight-600">Start Request Date</label>
                                 <input type="datetime-local" class="form-control startclass" id="start1" name="start">
                             </div>
                         </div>
                         <div class="col-3">
                             <div class="form-group">
                                 <label class="font-weight-600">End Request Date</label>
                                 <input type="datetime-local" class="form-control endclass" id="end1" name="end">
                             </div>
                         </div>
                         <div class="col-3">
                             <div class="form-group">
                                 <label class="font-weight-600">Start Leave Period</label>
                                 <input type="date" class="form-control startclass" id="startperiod1" name="startperiod">

                             </div>
                         </div>
                         <div class="col-3">
                             <div class="form-group">
                                 <label class="font-weight-600">End Leave Period</label>
                                 <input type="date" class="form-control endclass" id="endperiod1" name="endperiod">
                             </div>
                         </div>
                     </div>

                     <table id="examplee" class="display nowrap">
                         <thead>
                             <tr>
                                 <div class="refresh-btn-container"
                                     style="position: relative; left: 305px; top: 34px; z-index: 1;">
                                     <a href="{{ url('/applyleave') }}" class="btn btn-success">Refresh</a>
                                 </div>
                             </tr>
                             <tr>
                                 <th style="display: none;">id</th>
                                 <th>Employee</th>
                                 <th>Date of Request</th>
                                 <th>Status</th>
                                 <th>Leave Type</th>
                                 <th>Leave Period</th>
                                 <th>Days</th>
                                 <th>Approver</th>
                                 <th>Reason for Leave</th>
                                 <th>Reason For Reject</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                 <tr>
                                     <td style="display: none;">{{ $applyleaveDatas->id }}</td>
                                     <td> <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}">
                                             {{ $applyleaveDatas->team_member ?? '' }}</a>
                                     </td>
                                     <td>{{ date('d-m-Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td>
                                     <td class="columnSize">
                                         @if ($applyleaveDatas->status == 0)
                                             <span class="badge badge-pill badge-warning"><span
                                                     style="display: none;">A</span>Created</span>
                                         @elseif($applyleaveDatas->status == 1)
                                             <span class="badge badge-success"><span
                                                     style="display: none;">B</span>Approved</span>
                                         @elseif($applyleaveDatas->status == 2)
                                             <span class="badge badge-danger">Rejected</span>
                                         @endif
                                     </td>

                                     <td>

                                         {{ $applyleaveDatas->name ?? '' }}<br>
                                         @if ($applyleaveDatas->type == '0')
                                             <b>Type :</b> <span>Birthday</span><br>
                                             <span><b>Birthday Date :
                                                 </b>{{ date(
                                                     'F d,Y',
                                                     strtotime(
                                                         App\Models\Teammember::select('dateofbirth')->where('id', $applyleaveDatas->createdby)->first()->dateofbirth,
                                                     ),
                                                 ) ?? '' }}</span>
                                         @elseif($applyleaveDatas->type == '1')
                                             <span>Religious Festival</span>
                                         @endif
                                     </td>
                                     <td>{{ date('d-m-Y', strtotime($applyleaveDatas->from)) ?? '' }} -
                                         {{ date('d-m-Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
                                     @php
                                         $to = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->to ?? '');
                                         $from = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->from);
                                         $diff_in_days = $to->diffInDays($from) + 1;
                                         $holidaycount = DB::table('holidays')
                                             ->where('startdate', '>=', $applyleaveDatas->from)
                                             ->where('enddate', '<=', $applyleaveDatas->to)
                                             ->count();
                                     @endphp
                                     <td>{{ $diff_in_days - $holidaycount ?? '' }}</td>
                                     <td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleaveDatas->approver)->first()->team_member ?? '' }}
                                     </td>
                                     <td>
                                         <div style="font-size: 15px; width: 7rem;text-wrap: wrap;">
                                             {{ $applyleaveDatas->reasonleave ?? '' }}
                                         </div>
                                     </td>
                                     <td>
                                         <div style="font-size: 15px; width: 7rem;text-wrap: wrap;">
                                             {{ $applyleaveDatas->remark ?? '' }}
                                         </div>

                                     </td>
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
 <script>
     $(document).ready(function() {
         $('#examplee').DataTable({
             dom: 'Bfrtip',
             "pageLength": 25,
             "order": [
                 [3, "asc"]
             ],
             buttons: [{
                     extend: 'copyHtml5',
                     exportOptions: {
                         columns: [0, ':visible']
                     }
                 },
                 {
                     extend: 'excelHtml5',
                     filename: 'Apply Report List',
                     //  Change value Acreated to created and AApproved to Approved
                     customizeData: function(data) {
                         for (var i = 0; i < data.body.length; i++) {
                             for (var j = 0; j < data.body[i].length; j++) {
                                 if (data.body[i][j] === 'ACreated') {
                                     data.body[i][j] = 'Created';
                                 } else if (data.body[i][j] === 'BApproved') {
                                     data.body[i][j] = 'Approved';
                                 } else if (data.body[i][j] === 'Rejected') {
                                     data.body[i][j] = 'Rejected';
                                 }
                             }
                         }
                     },
                     exportOptions: {
                         columns: ':visible'
                     }
                 },
                 {
                     extend: 'pdfHtml5',
                     filename: 'Apply Report List',
                     //  Change value Acreated to created and AApproved to Approved
                     customize: function(doc) {
                         // Assuming the status column is at index 3, adjust as needed
                         for (var i = 0; i < doc.content[1].table.body.length; i++) {
                             var originalValue = doc.content[1].table.body[i][3].text;
                             if (originalValue === 'ACreated') {
                                 doc.content[1].table.body[i][3].text = 'Created';
                             } else if (originalValue === 'BApproved') {
                                 doc.content[1].table.body[i][3].text = 'Approved';
                             } else if (originalValue === 'CRejected') {
                                 doc.content[1].table.body[i][3].text = 'Rejected';
                             }
                         }
                     },
                     exportOptions: {
                         columns: [0, 1, 2, 5]
                     }
                 },
                 'colvis'
             ]
         });
     });
 </script>


 {{-- add library for excell download after filter  --}}
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

 {{-- filter on apply leave --}}
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <script>
     $(document).ready(function() {
         // Common function to render table rows
         function renderTableRows(data) {
             $('table tbody').html("");
             $('#clickExcell').show();

             if (data.length === 0) {
                 $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
             } else {
                 $.each(data, function(index, item) {
                     var url = '/applyleave/' + item.id;
                     var createdAt = formatDate(item.created_at);
                     var fromDate = formatDate(item.from);
                     var toDate = formatDate(item.to);
                     var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                         60 * 1000)) + 1;

                     $('table tbody').append('<tr>' +
                         '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                         '<td>' + createdAt + '</td>' +
                         '<td>' + getStatusBadge(item.status) + '</td>' +
                         '<td>' + item.name + '</td>' +
                         '<td>' + fromDate + ' to ' + toDate + '</td>' +
                         '<td>' + holidays + '</td>' +
                         '<td>' + item.approvernames + '</td>' +
                         '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                         '</tr>');
                 });
             }
         }

         // Common function to export data to Excel
         function exportToExcel(data) {
             const filteredData = data.map(item => {
                 const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                     1000)) + 1;
                 const createdAt = formatDate(item.created_at);
                 const fromDate = formatDate(item.from);
                 const toDate = formatDate(item.to);

                 return {
                     Employee: item.team_member,
                     Date_of_Request: createdAt,
                     status: getStatusText(item.status),
                     Leave_Type: item.name,
                     from: fromDate,
                     to: toDate,
                     Days: holidays,
                     Approver: item.approvernames,
                     Reason_for_Leave: item.reasonleave
                 };
             });

             const ws = XLSX.utils.json_to_sheet(filteredData);
             const headerCellStyle = {
                 font: {
                     bold: true
                 }
             };

             ws['!cols'] = [{
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 30
                 }
             ];

             Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                 ws[key].s = headerCellStyle;
             });

             const wb = XLSX.utils.book_new();
             XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
             const excelBuffer = XLSX.write(wb, {
                 bookType: "xlsx",
                 type: "array"
             });
             const dataBlob = new Blob([excelBuffer], {
                 type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
             });
             saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
         }

         // Common function to format date
         function formatDate(dateString) {
             return new Date(dateString).toLocaleDateString('en-GB', {
                 day: '2-digit',
                 month: '2-digit',
                 year: 'numeric'
             });
         }

         // Common function to get status text
         function getStatusText(status) {
             return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
         }

         // Common function to get status badge
         function getStatusBadge(status) {
             if (status === 0) {
                 return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
             } else if (status === 1) {
                 return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
             } else if (status === 2) {
                 return '<span class="badge badge-danger">Rejected</span>';
             } else {
                 return '';
             }
         }

         // Function to handle status change
         function handleStatusChange() {
             var status1 = $('#status1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                 }
             });
         }

         // Function to handle leave type change
         function handleLeaveTypeChange() {
             var leave1 = $('#leave1').val();
             var employee1 = $('#employee1').val();
             var status1 = $('#status1').val();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                 }
             });
         }

         // Function to handle employee change
         function handleEmployeeChange() {
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                 }
             });
         }

         // Function to handle leave period end date change
         function handleleaveperiodendChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                 }
             });
         }

         //  end Request Date end date wise
         function handleEndRequestDateChange() {
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             var status1 = $('#status1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                 }
             });
         }

         // Event handlers
         $('#status1').change(handleStatusChange);
         $('#leave1').change(handleLeaveTypeChange);
         $('#employee1').change(handleEmployeeChange);
         $('#endperiod1').change(handleleaveperiodendChange);
         $('#end1').change(handleEndRequestDateChange);

         //** start date wise
         $('#start1').change(function() {
             var start1 = $(this).val();
             var end1 = $('#end1').val();
             var status1 = $('#status1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             //  alert(start1);
             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     // Replace the table body with the filtered data
                     $('table tbody').html("");
                     // Clear the table body
                     if (data.length === 0) {
                         // If no data is found, display a "No data found" message
                         $('table tbody').append(
                             '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                         );
                     } else {
                         $.each(data, function(index, item) {

                             // Create the URL dynamically
                             var url = '/applyleave/' + item.id;

                             var createdAt = new Date(item.created_at)
                                 .toLocaleDateString('en-GB', {
                                     day: '2-digit',
                                     month: '2-digit',
                                     year: 'numeric'
                                 });
                             var fromDate = new Date(item.from)
                                 .toLocaleDateString('en-GB', {
                                     day: '2-digit',
                                     month: '2-digit',
                                     year: 'numeric'
                                 });
                             var toDate = new Date(item.to)
                                 .toLocaleDateString('en-GB', {
                                     day: '2-digit',
                                     month: '2-digit',
                                     year: 'numeric'
                                 });

                             var holidays = Math.floor((new Date(item.to) -
                                 new Date(item.from)) / (24 * 60 * 60 *
                                 1000)) + 1;

                             // Add the rows to the table
                             $('table tbody').append('<tr>' +
                                 '<td><a href="' + url + '">' + item
                                 .team_member +
                                 '</a></td>' +
                                 '<td>' + createdAt + '</td>' +
                                 '<td>' + getStatusBadge(item.status) + '</td>' +
                                 '<td>' + item.name + '</td>' +
                                 '<td>' + fromDate + ' to ' + toDate +
                                 '</td>' +
                                 '<td>' + holidays + '</td>' +
                                 '<td>' + item.approvernames + '</td>' +
                                 '<td style="width: 7rem;text-wrap: wrap;">' +
                                 item.reasonleave + '</td>' +
                                 '</tr>');
                         });

                         // Function to handle the status badge
                         function getStatusBadge(status) {
                             if (status == 0) {
                                 return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                             } else if (status == 1) {
                                 return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                             } else if (status == 2) {
                                 return '<span class="badge badge-danger">Rejected</span>';
                             } else {
                                 return '';
                             }
                         }

                         //   remove pagination after filter
                         $('.paging_simple_numbers').remove();
                         $('.dataTables_info').remove();
                     }
                 }
             });
         });

     });
 </script>

 {{-- validation for comparision date --}}
 <script>
     $(document).ready(function() {
         var startDateInput = $('.startclass');
         var endDateInput = $('.endclass');

         function compareDates() {
             var startDate = new Date(startDateInput.val());
             var endDate = new Date(endDateInput.val());

             if (startDate > endDate) {
                 alert('End date should be greater than or equal to the Start date');
                 endDateInput.val(''); // Clear the end date input
             }
         }

         startDateInput.on('input', compareDates);
         endDateInput.on('blur', compareDates);
     });
 </script>

 {{-- validation for block 4 digit to  year --}}
 <script>
     $(document).ready(function() {
         $('.startclass').on('change', function() {
             var startclear = $('.startclass');
             var startDateInput1 = $('.startclass').val();
             var startDate = new Date(startDateInput1);
             var startyear = startDate.getFullYear();
             var yearLength = startyear.toString().length;
             if (yearLength > 4) {
                 alert('Enter four digits for the year');
                 startclear.val('');
             }
         });
         $('.endclass').on('change', function() {
             var endclear = $('.endclass');
             var endDateInput1 = $('.endclass').val();
             var endtDate = new Date(endDateInput1);
             var endyear = endtDate.getFullYear();
             var endyearLength = endyear.toString().length;
             if (endyearLength > 4) {
                 alert('Enter four digits for the year');
                 endclear.val('');
             }
         });
     });
 </script>
