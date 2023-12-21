 
 <!--Third party Styles(used by this page)-->
 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
<style>
    .right-align {
        text-align: right;
    }
</style>
 @extends('backEnd.layouts.layout') @section('backEnd_content')

 <!--Content Header (Page header)-->
 <div class="content-wrapper">
     <div class="main-content">
         <nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
             <div class="sidebar-toggle-icon" id="sidebarCollapse">
                 sidebar toggle<span></span>
             </div>
             <!--/.sidebar toggle icon-->
             <div class="d-flex flex-grow-1">
                 <ul class="navbar-nav flex-row align-items-center ml-auto">
                     <li class="nav-item dropdown quick-actions">
                         <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                             <i class="typcn typcn-th-large-outline"></i>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right">
                             <div class="nav-grid-row row">
                                 <a href="#" class="icon-menu-item col-4">
                                     <i class="typcn typcn-cog-outline d-block"></i>
                                     <span>Settings</span>
                                 </a>
                                 <a href="#" class="icon-menu-item col-4">
                                     <i class="typcn typcn-group-outline d-block"></i>
                                     <span>Users</span>
                                 </a>
                                 <a href="#" class="icon-menu-item col-4">
                                     <i class="typcn typcn-puzzle-outline d-block"></i>
                                     <span>Components</span>
                                 </a>
                                 <a href="#" class="icon-menu-item col-4">
                                     <i class="typcn typcn-chart-bar-outline d-block"></i>
                                     <span>Profits</span>
                                 </a>
                                 <a href="#" class="icon-menu-item col-4">
                                     <i class="typcn typcn-time d-block"></i>
                                     <span>New Event</span>
                                 </a>
                                 <a href="#" class="icon-menu-item col-4">
                                     <i class="typcn typcn-edit d-block"></i>
                                     <span>Tasks</span>
                                 </a>
                             </div>
                         </div>
                     </li>
                     <!--/.dropdown-->
                     <li class="nav-item">
                         <a class="nav-link" href="chat.html"><i class="typcn typcn-messages"></i></a>
                     </li>
                     <li class="nav-item dropdown notification">
                         <a class="nav-link dropdown-toggle badge-dot" href="#" data-toggle="dropdown">
                             <i class="typcn typcn-bell"></i>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right">
                             <h6 class="notification-title">Notifications</h6>
                             <p class="notification-text">You have 2 unread notification</p>
                             <div class="notification-list">
                                 <div class="media new">
                                     <div class="img-user"><img src="assets/dist/img/avatar.png" alt=""></div>
                                     <div class="media-body">
                                         <h6>Congratulate <strong>Socrates Itumay</strong> for work
                                             anniversaries</h6>
                                         <span>Mar 15 12:32pm</span>
                                     </div>
                                 </div>
                                 <!--/.media -->
                                 <div class="media new">
                                     <div class="img-user online"><img src="assets/dist/img/avatar2.png" alt=""></div>
                                     <div class="media-body">
                                         <h6><strong>Joyce Chua</strong> just created a new blog post
                                         </h6>
                                         <span>Mar 13 04:16am</span>
                                     </div>
                                 </div>
                                 <!--/.media -->
                                 <div class="media">
                                     <div class="img-user"><img src="assets/dist/img/avatar3.png" alt=""></div>
                                     <div class="media-body">
                                         <h6><strong>Althea Cabardo</strong> just created a new blog
                                             post</h6>
                                         <span>Mar 13 02:56am</span>
                                     </div>
                                 </div>
                                 <!--/.media -->
                                 <div class="media">
                                     <div class="img-user"><img src="assets/dist/img/avatar4.png" alt=""></div>
                                     <div class="media-body">
                                         <h6><strong>Adrian Monino</strong> added new comment on your
                                             photo</h6>
                                         <span>Mar 12 10:40pm</span>
                                     </div>
                                 </div>
                                 <!--/.media -->
                             </div>
                             <!--/.notification -->
                             <div class="dropdown-footer"><a href="">View All Notifications</a></div>
                         </div>
                         <!--/.dropdown-menu -->
                     </li>
                     <!--/.dropdown-->
                     <li class="nav-item dropdown user-menu">
                         <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                             <!--<img src="assets/dist/img/user2-160x160.png" alt="">-->
                             <i class="typcn typcn-user-add-outline"></i>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right">
                             <div class="dropdown-header d-sm-none">
                                 <a href="" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                             </div>
                             <div class="user-header">
                                 <div class="img-user">
                                     <img src="assets/dist/img/avatar-1.jpg" alt="">
                                 </div><!-- img-user -->
                                 <h6>Naeem Khan</h6>
                                 <span>example@gmail.com</span>
                             </div><!-- user-header -->
                             <a href="" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                             <a href="" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit
                                 Profile</a>
                             <a href="" class="dropdown-item"><i class="typcn typcn-arrow-shuffle"></i> Activity
                                 Logs</a>
                             <a href="" class="dropdown-item"><i class="typcn typcn-cog-outline"></i>
                                 Account Settings</a>
                             <a href="page-signin.html" class="dropdown-item"><i class="typcn typcn-key-outline"></i>
                                 Sign Out</a>
                         </div>
                         <!--/.dropdown-menu -->
                     </li>
                 </ul>
                 <!--/.navbar nav-->
                 <div class="nav-clock">
                     <div class="time">
                         <span class="time-hours">19</span>
                         <span class="time-min">23</span>
                         <span class="time-sec">39</span>
                     </div>
                 </div><!-- nav-clock -->
             </div>
         </nav>
         <!--/.navbar-->
         <!--Content Header (Page header)-->

         <div class="content-header row align-items-center m-0">
             <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                 <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                     <button style="float: right;" class="btn btn-success ml-2" onclick="printDiv('printableArea')"><i
                             class="typcn typcn-printer mr-1"></i>Print</button>
                 </ol>
             </nav>
             <div class="col-sm-8 header-title p-0">
                 <div class="media">
                     <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                     <div class="media-body">
                         <h1 class="font-weight-bold">Home</h1>
                         <small>Payslip</small>
                     </div>
                 </div>
             </div>
         </div>
         <!--/.Content Header (Page header)-->
         <div id="printableArea">
             <div class="body-content container px-5">
                 <div class="card">

                     <div class="card-body">

                         <div class="row">
                       
                        <div class="col-sm-12" style="text-align:center;">
                        <img style="height:60px;" src="{{url('backEnd/image/images.png')}}">
                        </div>
							    @php
                             $payrollData = DB::table('teammembers')
                             ->leftjoin('roles','roles.id','teammembers.role_id')
                             ->where('teammembers.id',$payroll->teammember_id)->first();
                          //  dd($payrollData);  
                        @endphp
                             <div class="col-sm-12" style="text-align:center;">
                                 <h3><strong style="color:rgb(0,31,95)">Payslip for the month  of {{$payroll->month ??''}} 2023</strong></h3>
                                 <h6><strong style="color:rgb(0,31,95)">3/15 ASAF ALI ROAD, DELHI GATE, DELHI-110002</strong></h6>
                             </div>
                         </div>
                         <br><br><br>
                      
                         <div class="row">
                             <div class="col-sm-6">
                                 <address style="margin-left:10%;">
                                     <p><strong style="color:rgb(0,31,95)">Name :  {{$payrollData->team_member ?? ''}}</strong></p>
                                     <p><strong style="color:rgb(0,31,95)">Joining Date : {{date('F d,Y', strtotime($payrollData->joining_date ?? ''))}}</strong></p>
                                     <p><strong style="color:rgb(0,31,95)">Designation : {{$payrollData->rolename ?? ''}}</strong></p>
                                     <p><strong style="color:rgb(0,31,95)">Bank Name : {{$payrollData->nameofbank ?? ''}}</strong></p>
                                     <p><strong style="color:rgb(0,31,95)">A/c No : {{$payrollData->bankaccountnumber ?? ''}}</strong></p>
                                 </address>
                             </div>
                             <div class="col-sm-6">
                                 <address>
                                     <p><strong style="color:rgb(0,31,95)">PF Applicable : {{$payrollData->pf_applicable ?? ''}}</strong></p>
                                     <p><strong style="color:rgb(0,31,95)">Pan Number : {{$payrollData->pancardno ?? ''}}</strong></p>
                                     <p><strong style="color:rgb(0,31,95)"> No. of Days in Month : {{$payroll->totaldays ?? ''}}</strong></p>
                                     <p><strong style="color:rgb(0,31,95)">Effective Work days : {{$payroll->no_of_day_present ?? ''}}</strong></p>
                                 </address>
                             </div>
                         </div>
     
                         <div class="row mx-4">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                               <table class="table my-2">
    <thead>
        <tr>
            <th>Earnings</th>
            <th>Actual</th>
            <th>Deductions</th>
            <th>Actual</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $amount = $payroll->amount ?? '';
        $basic = $amount * 0.4;
        $hra = $basic * 0.5;
        $lta = $basic * 0.1;
        $telephonic = $amount * 0.05;
        $conveyance = $amount * 0.1;
        $medical = $amount * 0.05;
        $education = 200;
        $special = $amount - $basic - $hra - $lta - $telephonic - $conveyance - $medical - $education;
        $arrears = $payroll->Arrear ?? 0;
        $bonus = $payroll->bonus ?? 0;
        $tds = $payroll->tds ?? 0;
        $advance = $payroll->advance ?? 0;

        $totalearning = $basic + $hra + $lta + $telephonic + $conveyance + $medical + $education + $special + $arrears + $bonus;
        $totaldeduction = $payroll->employee_contribution + $tds + $advance;

        function numberToWords($net)
        {
            $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
            return $formatter->format($net);
        }

        $net = $totalearning - $totaldeduction;
        $words = numberToWords(round($net));
        ?>


<tr>
    <td>Basic</td>
    <td class="right-align">{{ str_pad(round($basic ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
    <td>Provident Fund</td>
    <td class="right-align">
        @if($payroll->employee_contribution != null)
            {{ str_pad(round($payroll->employee_contribution ?? 0), 8, ' ', STR_PAD_LEFT) }}
        @else
            0
        @endif
    </td>
</tr>
<tr>
    <td>HRA</td>
    <td class="right-align">{{ str_pad(round($hra ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
    <td>TDS</td>
    <td class="right-align">
        @if($payroll->tds != null)
            {{ str_pad(round($payroll->tds ?? 0), 8, ' ', STR_PAD_LEFT) }}
        @else
            0
        @endif
    </td>
</tr>
<tr>
    <td>LTA</td>
    <td class="right-align">{{ str_pad(round($lta ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
    <td>Advance</td>
    <td class="right-align">
        @if($payroll->advance != null)
            {{ str_pad(round($advance ?? 0), 8, ' ', STR_PAD_LEFT) }}
        @else
            0
        @endif
    </td>
</tr>
<tr>
    <td>Telephonic Reim.</td>
    <td class="right-align">{{ str_pad(round($telephonic ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
    <td>LWP</td>
    <td class="right-align">0</td>
</tr>
<tr>
    <td>Conveyance Allowance</td>
    <td class="right-align">{{ str_pad(round($conveyance ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
</tr>
<tr>
    <td>Medical Reim.</td>
    <td class="right-align">{{ str_pad(round($medical ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
</tr>
<tr>
    <td>Education Allowance</td>
    <td class="right-align">{{ str_pad(round($education ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
</tr>
<tr>
    <td>Special Allowance</td>
    <td class="right-align">{{ str_pad(round($special ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
</tr>
@if($arrears != 0)
    <tr>
        <td>Arrears</td>
        <td class="right-align">{{ str_pad(round($arrears ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
    </tr>
@endif
@if($bonus != 0)
    <tr>
        <td>Bonus</td>
        <td class="right-align">{{ str_pad(round($bonus ?? 0), 8, ' ', STR_PAD_LEFT) }}</td>
    </tr>
@endif
<tr>
    <th>Total Earnings: INR.</th>
    <th class="right-align">{{ str_pad(round($totalearning ?? 0), 8, ' ', STR_PAD_LEFT) }}</th>
    <th>Total Deductions: INR.</th>
    <th class="right-align">{{ str_pad(round($totaldeduction ?? 0), 8, ' ', STR_PAD_LEFT) }}</th>
</tr>



    </tbody>
</table>
											</div>
                                            <hr class="my-3">
                                            <h6 class="text-uppercase font-weight-bold">Net Pay For the Month: &nbsp;{{round($net) ??''}} </h6>
                                            <p class="text-muted mb-0 ">
                                              <h6 class="text-uppercase font-weight-bold"> Rupees &nbsp;<u>{{$words  ??''}} 															&nbsp;only</u></h6>
                                            </p><br><br><br>
                                            <hr class="my-3">
                                            <h6 style="text-align:center;">This is a system generated payslip and does not require a signature </h6>
                                        </div>
                                    </div>        
                     </div>
               </div>
             </div>
         </div>
         <div class="overlay"></div>
     </div>

     <!--Page Active Scripts(used by this page)-->
     <script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
     <!--Page Scripts(used by all page)-->
     <script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
     <script>
         function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
         }

     </script>

@endsection

     <!--Page Active Scripts(used by this page)-->
     <script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
     <!--Page Scripts(used by all page)-->
     <script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
