 
 <!--Third party Styles(used by this page)-->
 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

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
                         <!-- <small>Article Details</small> -->
                     </div>
                 </div>
             </div>
         </div>
         <!--/.Content Header (Page header)-->
         <div id="printableArea">
             <div class="body-content">
                 <div class="card">

                     <div class="card-body">

                         <div class="row">
                       
                        <div class="col-sm-12" style="text-align:center;">
                        <img style="height:60px;" src="{{url('backEnd/image/images.png')}}">
                        </div>
                        
                             <div class="col-sm-12" style="text-align:center;">
                                 <h3><strong style="color:rgb(0,31,95)">K G SOMANI & CO. LLP</strong></h3>
                                 <strong style="color:rgb(0,31,95); font-size:16px;"><b>(To be submitted by all Partners and Managers by 10th April each year and on any subsequent change) </b></strong><br>

                             </div>
                         </div><br><br><br>
                         <div class="row">
                             <div class="col-sm-6">
                                 <address>
                                     <p><strong style="color:rgb(0,31,95)">To</strong></p>
                                     <p><strong style="color:rgb(0,31,95)">M/s KG Somani & Co LLP</strong></p>
                                     <p><strong style="color:rgb(0,31,95)">Delight Cinema Building
                                        <br>Asaf Ali Road, New Delhi 110002
                                     </strong></p>
                                 </address>
                                 
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-sm-12">
                                 <address>
                                 <p><strong style="color:rgb(0,31,95)">Subject :  <b>Declaration regarding position held as Director/Partner/Trustee/Office Bearer in any Companies/ Bodies Corporate/ Firms / Society/ Trust/
                                 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 Co-operative Society/Association of Individuals</b>
                                     </strong></p>
                                 </address>
                             </div>
                         </div>
                         <br>
                         <div class="row">
                             <div class="col-sm-12">
                                 <address>
                                     <p><strong style="color:rgb(0,31,95)">Dear Sirs,</strong></p>
									 <p><strong style="color:rgb(0,31,95)">I <b>{{$declarationform->team_member ??''}}</b>, son/daughter/spouse of <b>{{$declarationform->relative_name ??''}}</b>, resident of <b>{{$declarationform->resident ??''}}</b> being a <b>{{ $declarationform->relation ??''}}</b> in the Firm (KG Somani & Co LLP) hereby declare my and my family members interest or concern in the following company or companies, bodies corporate, Firms or Society or Trust or Co-operative Society or Association of Individuals: -</strong></p>
                                 </address>
                             </div>
                         </div>
                         <br>
                         <div class="table-responsive">
                             <table class="table table-bordered">
                                 <thead>
                                     <tr>
                                         <th style="width: 80px;">Sr No.</th>
                                         <th>Names of the Companies/ Bodies Corporate/ Firms / Society/ Trust /Co-operative Society / Association of Individuals</th>
                                         <th>Nature of interest or concern/ change in interest or concern (i.e., Director / Partner / Trustee / Office Bearer etc.)</th>
                                         <th>Shareholding, if any</th>
                                         <th>Date on which interest or concern arose/changed</th>
                                        </tr>
                                 </thead>
                                 <tbody>
                                    @php
                                    $declarationdetails = DB::table('declarationformdetails')
                                      ->where('declarationformdetails.declaration_id', $declarationform->id)->get();

                                    $i=1;
                                    @endphp
                                    @foreach($declarationdetails as $declarationdetailsDatas)
                                     <tr>
                                         <td>
                                             <small>{{$i++}}</small>
                                         </td>
                                         <td>{{$declarationdetailsDatas->company_name ??''}}</td>
                                         <td>{{$declarationdetailsDatas->interest ??''}}</td>
                                         <td>{{$declarationdetailsDatas->shareholding ??''}}</td>
                                         <td>{{$declarationdetailsDatas->date ??''}}</td>
                                     </tr>
                                 @endforeach
                                 </tbody>
                             </table>
                         </div>

                         <div class="row">
                             <div class="col-sm-6">
                                 <!-- <p><strong style="color:rgb(0,31,95)">Note:</strong></p><br> -->
                                 <br><br>
                                 <p><strong style="margin-left:40px;color:rgb(0,31,95)">Date : {{ date('F d,Y', strtotime($declarationform->created_at)) }}</strong></p>
                                         <p style="margin-left:40px;"><strong>Place : {{ $declarationform->place ??''}}
                                            </strong>
                                    </p>
                             </div>
                      
                             <div class="col-sm-6">
                               <br><br>
                                 <p style="margin-left:30%;"><strong>Signature of {{ $declarationform->relation ??''}}</strong></p>
                                 <p style="margin-left:30%;"><strong>Name : E-Verified through CapITall by
                                         {{ $declarationform->team_member }} on
                                         {{ date('F d,Y', strtotime($declarationform->created_at)) }}
                                         {{ date('h:i A', strtotime($declarationform->created_at)) }}
                                         </strong></p>
                                 <p style="margin-left:30%;"><strong>@if($declarationform->dinno != null)DIN : {{$declarationform->dinno ??''}}@endif</strong></p>

                             </div>
                         </div>
                         <div class="row">
                             <div class="col-sm-12">
                                 <p><strong style="color:rgb(0,31,95)">Note:</strong></p><br>
                                 <p><strong style="margin-left:40px;color:rgb(0,31,95)">1. Family here means Grand Parents, Father, Mother, Spouse, Son, Daughter, Brother, Sister
                                            </strong></p>
                                <p><strong style="margin-left:40px;color:rgb(0,31,95)">2. Form is to be submitted to the Nodal Partner looking after HR Department</strong></p>
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
