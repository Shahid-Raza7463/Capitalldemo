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
                         <div class="col-3">
                             <div class="form-group">
                                 <label class="font-weight-600">Employee</label>
                                 <select class="language form-control" id="employee1" name="employee">
                                     <option value="">Please Select One</option>
                                     @php
                                         $displayedValues = [];
                                     @endphp
                                     @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                         @if (!in_array($applyleaveDatas->team_member, $displayedValues))
                                             <option value="{{ $applyleaveDatas->id }}">
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

                         <div class="col-3">
                             <div class="form-group">
                                 <label class="font-weight-600">Leave Type</label>
                                 <select class="language form-control" id="leave1" name="leave">
                                     <option value="">Please Select One</option>
                                     @php
                                         $displayedValues = [];
                                     @endphp
                                     @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                         @if (!in_array($applyleaveDatas->name, $displayedValues))
                                             <option value="">
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
                         <div class="col-3">
                             <div class="form-group">
                                 <label class="font-weight-600">Start Date</label>
                                 <input type="date" class="form-control" id="start" name="start">

                             </div>
                         </div>
                         <div class="col-3">
                             <div class="form-group">
                                 <label class="font-weight-600">End Date</label>
                                 <input type="date" class="form-control" name="end" id="end">
                             </div>
                         </div>
                     </div>



                     <table id="examplee" class="display nowrap">
                         <thead>
                             <tr>
                                 <th style="display: none;">id</th>
                                 <th>Employee</th>
                                 <th>Leave Type</th>
                                 <th>Approver</th>
                                 <th>Reason for Leave</th>
                                 <th>Leave Period</th>
                                 <th>Days</th>
                                 <th>Date of Request</th>
                                 <th>Status</th>
                             </tr>
                         </thead>
                         <style>
                             .columnSize {
                                 width: 7rem;
                                 font-size: 15px;
                             }
                         </style>
                         <tbody>
                             {{-- @php
                                 dd($teamapplyleaveDatas);
                             @endphp --}}
                             @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                 <tr>
                                     <td style="display: none;">{{ $applyleaveDatas->id }}</td>
                                     <td class="columnSize"> <a
                                             href="{{ route('applyleave.show', $applyleaveDatas->id) }}">
                                             {{ $applyleaveDatas->team_member ?? '' }}</a></td>
                                     <td class="columnSize">

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
                                     <td class="columnSize">
                                         {{ App\Models\Teammember::select('team_member')->where('id', $applyleaveDatas->approver)->first()->team_member ?? '' }}
                                     </td>
                                     <td>
                                         <div style="font-size: 15px; width: 7rem;text-wrap: wrap;">
                                             {{ $applyleaveDatas->reasonleave ?? '' }}
                                         </div>
                                     </td>
                                     {{-- <td>{{ date('F d,Y', strtotime($applyleaveDatas->from)) ?? '' }} -
                                         {{ date('F d,Y', strtotime($applyleaveDatas->to)) ?? '' }}</td> --}}
                                     <td class="columnSize">{{ date('d-m-Y', strtotime($applyleaveDatas->from)) ?? '' }} to
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
                                     <td class="columnSize">{{ $diff_in_days - $holidaycount ?? '' }}</td>
                                     {{-- <td>{{ date('F d,Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td> --}}
                                     <td class="columnSize">
                                         {{ date('d-m-Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td>
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
             "pageLength": 50,
             "order": [
                 [8, "asc"]
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
