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
                            <a href="" class="dropdown-item"><i class="typcn typcn-arrow-shuffle"></i> Activity Logs</a>
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

                <a href="{{route('letterhead.edit', $letterhead->id)}}" style="float: right;" class="btn btn-success ml-2"><i
                        class="typcn typcn-printer mr-1"></i>Edit</a>
               <!-- <button style="float: right;" class="btn btn-success ml-2" onclick="printDiv('printableArea')"><i
                        class="typcn typcn-printer mr-1"></i>Print</button> -->
              
            </nav>
            <div class="col-sm-8 header-title p-0">
                <div class="media">
                    <div class="header-icon text-success mr-3"><i class="typcn typcn-document-text"></i></div>
                    <div class="media-body">
                        <h1 class="font-weight-bold">letterhead</h1>
                        <small>From now on you will start your activities.</small>
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
                            <div class="col-sm-6">
                             
                                  <address>
                                    <h2><strong style="color:rgb(0,31,95)">K G SOMANI & CO. LLP</strong></h2>
                                    <strong style="margin-left: 66px;color:rgb(0,31,95)" >CHARTERED ACCOUNTANTS</strong><br>
                                </address>
                              
                            </div>
                            <div class="col-sm-6 text-right">
                                <div style="font-size:27px; color:rgb(0,0,0)">www.kgsomani.com</div>
                                <div class="text- m-b-15" style="font-size:27px;color:rgb(0,0,0)">office@kgsomani.com</div>
                              
                                <div style="font-size:17px;color:rgb(0,0,0)">LLP Identification No. AAX-5330
                                </div>
                            </div>
                        </div>
                        <div class="">
                            {!! $letterhead->description ??''!!}
                        </div>

                    </div>
                     <div style="text-align:center; font-size:18px;" class="text-success m-b-15"><span style="color:rgb(32,87,104)" >Regd. Office: 3/15, ASAF ALI ROAD NEW DELHI-110002
                            <br>  Corp Office: 4/1 Asaf Ali Road, 3rd Floor, Delite Cinema Building, Delhi 110002. Tel: +91-11-41403938, 23277677, 23252225
                        </span> <br><b><span style="color:rgb(0,31,95)">Converted from K G Somani & Co (Partnership firm) w.e.f 24th June 2021</span>
                        </b> </div>
                </div>
                <br>
             

            </div>
        </div>
        <!--/.body content-->
    </div>
    <!--/.main content-->

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
