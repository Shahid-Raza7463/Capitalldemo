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
                    href="{{url('/attendances?'.'month='.'January')}}">January</a>
					<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'February')}}">February</a>
                   	<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'March')}}">March</a>
						<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'April')}}">April</a>
					<a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'May')}}">May</a>
                    <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'June')}}">June</a>
                    <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'July')}}">July</a>
                    <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'August')}}">August</a>
                    <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'September')}}">September</a>
                    <a style="color: #37A000" class="dropdown-item"
                        href="{{url('/attendances?'.'month='.'October')}}">October</a>
                    <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'November')}}">November</a>
					  <a style="color: #37A000" class="dropdown-item"
                    href="{{url('/attendances?'.'month='.'December')}}">December</a>
                </div>
            </div></li>
         
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Support Staff Attendance Sheet
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
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true">Support Staff</a>
                </li>


                

            </ul>

            <br>
            <hr>
            <div class="tab-content" id="pills-tabContent">
                {{-- <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table id="examplee" class="display nowrap">
                            <thead>
                                <tr>
                                    <th style="display: none;">id</th>
                                    <th>Employee Name</th>
									<th>Role</th>
                                    <th>Employee Status</th>
                                    <th>Date Of Joining</th>
                                    <th>Month</th>
                                    <th>26</th>
                                    <th>27 </th>
                                    <th>28</th>
                                    <th>29</th>
                                    <th>30</th>
                                    <th>31</th>
                                    <th>01</th>
                                    <th>02</th>
                                    <th>03</th>
                                    <th>04</th>
                                    <th>05</th>
                                    <th>06</th>
                                    <th>07</th>
                                    <th>08</th>
                                    <th>09</th>
                                    <th>10</th>
                                    <th>11</th>
                                    <th>12</th>
                                    <th>13</th>
                                    <th>14</th>
                                    <th>15</th>
                                    <th>16</th>
                                    <th>17</th>
                                    <th>18</th>
                                    <th>19</th>
                                    <th>20</th>
                                    <th>21</th>
                                    <th>22</th>
                                    <th>23</th>
                                    <th>24</th>
                                    <th>25</th>
                                    <th>Total Number of days
                                    </th>
                                    <th>No of days Present
                                    </th>
                                    <th>Casual Leave (CL)
                                    </th>
                                    <th>Sick Leave (SL)
                                    </th>
                                    <th>Comp Off (CO)
                                    </th>
                                    <th>Birthday/religious Holiday
                                    </th>
                                    <th>LWP (Leave Without Pay)
                                    </th>
                                    <th>Total Days to be paid
                                    </th>
                                    <th>Comment (If any)
                                    </th>
                                   
        
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceDatas as $attendanceData)
                                <tr>
                                    <td style="display: none;">{{$attendanceData->id }}</td>
                                    <td>{{ $attendanceData->team_member }} </td>
									<td>{{ $attendanceData->rolename }}</td>
                                    <td> {{ $attendanceData->employment_status }}</td>
                                    <td>@if($attendanceData->joining_date !=  null){{ date('F d,Y', strtotime($attendanceData->joining_date ??'')) }}@endif</td>
                                    <td> {{ $attendanceData->month }}</td>
                                    <td> {{ $attendanceData->twentysix ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyseven ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyeight ??'0' }}</td>
                                    <td> {{ $attendanceData->twentynine ??'0' }}</td>
                                    <td> {{ $attendanceData->thirty ??'0' }}</td>
                                    <td> {{ $attendanceData->thirtyone ??'0' }}</td>
                                    <td> {{ $attendanceData->one ??'0' }}</td>
                                    <td> {{ $attendanceData->two ??'0' }}</td>
                                    <td> {{ $attendanceData->three ??'0' }}</td>
                                    <td> {{ $attendanceData->four ??'0' }}</td>
                                    <td> {{ $attendanceData->five ??'0' }}</td>
                                    <td> {{ $attendanceData->six ??'0' }}</td>
                                    <td> {{ $attendanceData->seven ??'0' }}</td>
                                    <td> {{ $attendanceData->eight ??'0' }}</td>
                                    <td> {{ $attendanceData->nine??'0' }}</td>
                                    <td> {{ $attendanceData->ten ??'0' }}</td>
                                    <td> {{ $attendanceData->eleven ??'0' }}</td>
                                    <td> {{ $attendanceData->twelve ??'0' }}</td>
                                    <td> {{ $attendanceData->thirteen ??'0' }}</td>
                                    <td> {{ $attendanceData->fourteen ??'0' }}</td>
                                    <td> {{ $attendanceData->fifteen ??'0' }}</td>
                                    <td> {{ $attendanceData->sixteen ??'0' }}</td>
                                    <td> {{ $attendanceData->seventeen ??'0' }}</td>
                                    <td> {{ $attendanceData->eighteen ??'0' }}</td>
                                    <td> {{ $attendanceData->ninghteen ??'0' }}</td>
                                    <td> {{ $attendanceData->twenty ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyone ??'0' }}</td>
                                    <td> {{ $attendanceData->twentytwo ??'0' }}</td>
                                    <td> {{ $attendanceData->twentythree ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyfour ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyfive ??'0' }}</td>
                                    <td> {{ $attendanceData->total_no_of_days }}</td>
                                    <td> {{ $attendanceData->no_of_days_present }}</td>
                                    <td> {{ $attendanceData->casual_leave }}</td>
                                    <td> {{ $attendanceData->sick_leave }}</td>
                                    <td> {{ $attendanceData->comp_off }}</td>
                                    <td> {{ $attendanceData->birthday_religious }}</td>
                                    <td> {{ $attendanceData->lwp }}</td>
                                    <td> {{ $attendanceData->totaldaystobepaid }}</td>
                                    <td> {{ $attendanceData->comment }}</td>
                                   
                                   
        
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table id="examplee" class="display nowrap">
                            <thead>
                                <tr>
                                    <th style="display: none;">id</th>
                                    <th>Employee Name</th>
                                    <th>Role</th>
                                    <th>Employee Status</th>
                                    <th>Date Of Joining</th>
                                    <th>Month</th>
                                    <th>26</th>
                                    <th>27 </th>
                                    <th>28</th>
                                    <th>29</th>
                                    <th>30</th>
                                    <th>31</th>
                                    <th>01</th>
                                    <th>02</th>
                                    <th>03</th>
                                    <th>04</th>
                                    <th>05</th>
                                    <th>06</th>
                                    <th>07</th>
                                    <th>08</th>
                                    <th>09</th>
                                    <th>10</th>
                                    <th>11</th>
                                    <th>12</th>
                                    <th>13</th>
                                    <th>14</th>
                                    <th>15</th>
                                    <th>16</th>
                                    <th>17</th>
                                    <th>18</th>
                                    <th>19</th>
                                    <th>20</th>
                                    <th>21</th>
                                    <th>22</th>
                                    <th>23</th>
                                    <th>24</th>
                                    <th>25</th>
                                    <th>Total Number of days
                                    </th>
                                    <th>No of days Present
                                    </th>
                                    <th>Casual Leave (CL)
                                    </th>
                                    <th>Sick Leave (SL)
                                    </th>
                                    <th>Comp Off (CO)
                                    </th>
                                    <th>Birthday/religious Holiday
                                    </th>
                                    <th>LWP (Leave Without Pay)
                                    </th>
                                    <th>Total Days to be paid
                                    </th>
                                    <th>Comment (If any)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceDatas as $attendanceData)
                                <tr data-toggle="modal" data-target="#updateModal{{$attendanceData->id}}">
                                    <td style="display: none;">{{$attendanceData->id }}</td>
                                    <td>{{ $attendanceData->team_member }}</td>
                                    <td>{{ $attendanceData->rolename }}</td>
                                    <td>{{ $attendanceData->employment_status }}</td>
                                    <td>@if($attendanceData->joining_date !=  null){{ date('F d, Y', strtotime($attendanceData->joining_date ??'')) }}@endif</td>
                                    <td> {{ $attendanceData->month }}</td>
                                    <td> {{ $attendanceData->twentysix ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyseven ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyeight ??'0' }}</td>
                                    <td> {{ $attendanceData->twentynine ??'0' }}</td>
                                    <td> {{ $attendanceData->thirty ??'0' }}</td>
                                    <td> {{ $attendanceData->thirtyone ??'0' }}</td>
                                    <td> {{ $attendanceData->one ??'0' }}</td>
                                    <td> {{ $attendanceData->two ??'0' }}</td>
                                    <td> {{ $attendanceData->three ??'0' }}</td>
                                    <td> {{ $attendanceData->four ??'0' }}</td>
                                    <td> {{ $attendanceData->five ??'0' }}</td>
                                    <td> {{ $attendanceData->six ??'0' }}</td>
                                    <td> {{ $attendanceData->seven ??'0' }}</td>
                                    <td> {{ $attendanceData->eight ??'0' }}</td>
                                    <td> {{ $attendanceData->nine??'0' }}</td>
                                    <td> {{ $attendanceData->ten ??'0' }}</td>
                                    <td> {{ $attendanceData->eleven ??'0' }}</td>
                                    <td> {{ $attendanceData->twelve ??'0' }}</td>
                                    <td> {{ $attendanceData->thirteen ??'0' }}</td>
                                    <td> {{ $attendanceData->fourteen ??'0' }}</td>
                                    <td> {{ $attendanceData->fifteen ??'0' }}</td>
                                    <td> {{ $attendanceData->sixteen ??'0' }}</td>
                                    <td> {{ $attendanceData->seventeen ??'0' }}</td>
                                    <td> {{ $attendanceData->eighteen ??'0' }}</td>
                                    <td> {{ $attendanceData->ninghteen ??'0' }}</td>
                                    <td> {{ $attendanceData->twenty ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyone ??'0' }}</td>
                                    <td> {{ $attendanceData->twentytwo ??'0' }}</td>
                                    <td> {{ $attendanceData->twentythree ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyfour ??'0' }}</td>
                                    <td> {{ $attendanceData->twentyfive ??'0' }}</td>
                                    <td> {{ $attendanceData->total_no_of_days }}</td>
                                    <td> {{ $attendanceData->no_of_days_present }}</td>
                                    <td> {{ $attendanceData->casual_leave }}</td>
                                    <td> {{ $attendanceData->sick_leave }}</td>
                                    <td> {{ $attendanceData->comp_off }}</td>
                                    <td> {{ $attendanceData->birthday_religious }}</td>
                                    <td> {{ $attendanceData->lwp }}</td>
                                    <td> {{ $attendanceData->totaldaystobepaid }}</td>
                                    <td> {{ $attendanceData->comment }}</td>
                                </tr>
                                <!-- Update Modal -->
                                <div class="modal fade" id="updateModal{{$attendanceData->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModal{{$attendanceData->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateModal{{$attendanceData->id}}Label">Update Attendance Data</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('updateAttendance') }}" method="POST">
                                                @csrf
                                            <div class="modal-body">
                                                
                                                    <input type="hidden" name="attendance_id" value="{{$attendanceData->id}}">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="team_member">Employee Name :</label>
                                                                <input type="text" name="team_member" id="team_member" class="form-control" value="{{ $attendanceData->team_member }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="total_no_of_days">Total Number of days:</label>
                                                                <input type="number" name="total_no_of_days" id="total_no_of_days" class="form-control" value="{{$attendanceData->total_no_of_days}}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="no_of_days_present">No of days Present:</label>
                                                                <input type="number" name="no_of_days_present" id="no_of_days_present" class="form-control" value="{{$attendanceData->no_of_days_present}}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="casual_leave">Casual Leave (CL):</label>
                                                                <input type="number" name="casual_leave" id="casual_leave" class="form-control" value="{{$attendanceData->casual_leave}}">
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="sick_leave">Sick Leave (SL):</label>
                                                                <input type="number" name="sick_leave" id="sick_leave" class="form-control" value="{{$attendanceData->sick_leave}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="comp_off">Comp Off (CO):</label>
                                                                <input type="number" name="comp_off" id="comp_off" class="form-control" value="{{$attendanceData->comp_off}}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="birthday_religious">Birthday/Religious Holiday:</label>
                                                                <input type="number" name="birthday_religious" id="birthday_religious" class="form-control" value="{{$attendanceData->birthday_religious}}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lwp">LWP (Leave Without Pay):</label>
                                                                <input type="number" name="lwp" id="lwp" class="form-control" value="{{$attendanceData->lwp}}">
                                                            </div>
                                                        </div>
                                                        
                                                       
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="absent">Absent:</label>
                                                                <input type="number" name="absent" id="absent" class="form-control" value="{{$attendanceData->absent}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="totaldaystobepaid">Total Days to be paid:</label>
                                                                <input type="number" name="totaldaystobepaid" id="totaldaystobepaid" class="form-control" value="{{$attendanceData->totaldaystobepaid}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="comment">Comment (If any):</label>
                                                                <textarea name="comment" id="comment" class="form-control">{{$attendanceData->comment}}</textarea>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="row">
                                                        
                                                        
                                                        
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="one">One:</label>
                                                                <input type="text" name="one" id="one" class="form-control" value="{{ $attendanceData->one ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="two">Two:</label>
                                                                <input type="text" name="two" id="two" class="form-control" value="{{ $attendanceData->two ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="three">Three:</label>
                                                                <input type="text" name="three" id="three" class="form-control" value="{{ $attendanceData->three ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="four">Four:</label>
                                                                <input type="text" name="four" id="four" class="form-control" value="{{ $attendanceData->four ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="five">Five:</label>
                                                                <input type="text" name="five" id="five" class="form-control" value="{{ $attendanceData->five ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="six">Six:</label>
                                                                <input type="text" name="six" id="six" class="form-control" value="{{ $attendanceData->six ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="seven">Seven:</label>
                                                                <input type="text" name="seven" id="seven" class="form-control" value="{{ $attendanceData->seven ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="eight">Eight:</label>
                                                                <input type="text" name="eight" id="eight" class="form-control" value="{{ $attendanceData->eight ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="nine">Nine:</label>
                                                                <input type="text" name="nine" id="nine" class="form-control" value="{{ $attendanceData->nine ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="ten">Ten:</label>
                                                                <input type="text" name="ten" id="ten" class="form-control" value="{{ $attendanceData->ten ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="eleven">Eleven:</label>
                                                                <input type="text" name="eleven" id="eleven" class="form-control" value="{{ $attendanceData->eleven ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twelve">Twelve:</label>
                                                                <input type="text" name="twelve" id="twelve" class="form-control" value="{{ $attendanceData->twelve ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="thirteen">Thirteen:</label>
                                                                <input type="text" name="thirteen" id="thirteen" class="form-control" value="{{ $attendanceData->thirteen ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="fourteen">Fourteen:</label>
                                                                <input type="text" name="fourteen" id="fourteen" class="form-control" value="{{ $attendanceData->fourteen ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="fifteen">Fifteen:</label>
                                                                <input type="text" name="fifteen" id="fifteen" class="form-control" value="{{ $attendanceData->fifteen ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="sixteen">Sixteen:</label>
                                                                <input type="text" name="sixteen" id="sixteen" class="form-control" value="{{ $attendanceData->sixteen ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="seventeen">Seventeen:</label>
                                                                <input type="text" name="seventeen" id="seventeen" class="form-control" value="{{ $attendanceData->seventeen ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="eighteen">Eighteen:</label>
                                                                <input type="text" name="eighteen" id="eighteen" class="form-control" value="{{ $attendanceData->eighteen ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="nineteen">Nineteen:</label>
                                                                <input type="text" name="ninghteen" id="ninghteen" class="form-control" value="{{ $attendanceData->ninghteen ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twenty">Twenty:</label>
                                                                <input type="text" name="twenty" id="twenty" class="form-control" value="{{ $attendanceData->twenty ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentyone">Twenty-One:</label>
                                                                <input type="text" name="twentyone" id="twentyone" class="form-control" value="{{ $attendanceData->twentyone ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentytwo">Twenty-Two:</label>
                                                                <input type="text" name="twentytwo" id="twentytwo" class="form-control" value="{{ $attendanceData->twentytwo ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentythree">Twenty-Three:</label>
                                                                <input type="text" name="twentythree" id="twentythree" class="form-control" value="{{ $attendanceData->twentythree ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentyfour">Twenty-Four:</label>
                                                                <input type="text" name="twentyfour" id="twentyfour" class="form-control" value="{{ $attendanceData->twentyfour ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentyfive">Twenty-Five:</label>
                                                                <input type="text" name="twentyfive" id="twentyfive" class="form-control" value="{{ $attendanceData->twentyfive ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentysix">Twenty-Six:</label>
                                                                <input type="text" name="twentysix" id="twentysix" class="form-control" value="{{ $attendanceData->twentysix ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentyseven">Twenty-Seven:</label>
                                                                <input type="text" name="twentyseven" id="twentyseven" class="form-control" value="{{ $attendanceData->twentyseven ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentyeight">Twenty-Eight:</label>
                                                                <input type="text" name="twentyeight" id="twentyeight" class="form-control" value="{{ $attendanceData->twentyeight ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="twentynine">Twenty-Nine:</label>
                                                                <input type="text" name="twentynine" id="twentynine" class="form-control" value="{{ $attendanceData->twentynine ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="thirty">Thirty:</label>
                                                                <input type="text" name="thirty" id="thirty" class="form-control" value="{{ $attendanceData->thirty ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="thirtyone">Thirty-One:</label>
                                                                <input type="text" name="thirtyone" id="thirtyone" class="form-control" value="{{ $attendanceData->thirtyone ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Update Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                <br>
                
            </div>
           
        </div>
        <!--/.body content-->
        <!-- Modal -->
      
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
						"pageLength": 100,
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
        <script>
            $(document).ready(function () {
                $('#examples').DataTable({
						"pageLength": 100,
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
        <script>
            $(document).ready(function () {
                $('#exampless').DataTable({
						"pageLength": 100,
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
