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
 <a href="{{ url()->previous() }}" class="btn btn-success ml-2"  >Back <i class="fa fa-reply"></i></a>
                <button style="float: right;" class="btn btn-success ml-2" onclick="printDiv('printableArea')"><i
                        class="typcn typcn-printer mr-1"></i>Print Invoice</button>
                   
            </nav>
            <div class="col-sm-8 header-title p-0">
                <div class="media">
                    <div class="header-icon text-success mr-3"><i class="typcn typcn-document-text"></i></div>
                    <div class="media-body">
                        <h1 class="font-weight-bold">Invoice</h1>
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
                            <strong style="margin-left: 66px;color:rgb(0,31,95)">CHARTERED ACCOUNTANTS</strong><br>
                        </address>

                    </div>
                    <div class="col-sm-6 text-right">
                        <b>
                            <div style=" font-size:17px">www.kgsomani.com</div>
                            <div class="text m-b-15" style="font-size:17px ">office@kgsomani.com</div>

                            <div style="font-size:17px;color:rgb(0,0,0)">LLP Identification No. AAX-5330
                            </div>
                        </b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;text-align:justify;'>
                            <strong>&nbsp;</strong></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;text-align:justify;'>
                            <strong>&nbsp;</strong></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;text-align:justify;'>
                            <strong><span style='font-size:13px;font-family:"Arial","sans-serif";'>Date : {{date('F d,Y', strtotime($staffappointmentData->appointment_letter_date)) ??''}}</span></strong>
                        </p>

                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;margin-top:.1pt;'>
                            <strong> <span style='font-size:13px;font-family:"Arial","sans-serif";'>Name : Mr./Ms.
                            {{$staffappointmentData->team_member ??''}} ({{$staffappointmentData->rolename ??''}})</span></strong></p>

                        <p
                            style='margin-right:-3.15pt;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;'>
                            <strong>   <span style='font-size:13px;font-family:"Arial","sans-serif";'>Permanent Address :
                                  {{$staffappointmentData->permanentaddress ??''}}</span></strong></p>
                        <p
                            style='margin-right:-3.15pt;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;'>
                            <strong>    <span style='font-size:13px;font-family:"Arial","sans-serif";'>Communication Address :
                                 {{$staffappointmentData->permanentaddress ??''}}</span></strong></p>
                        <p
                            style='margin-right:.5in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;line-height:9.65pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                        <p
                            style='margin-right:.5in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;line-height:9.65pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                        <p
                            style='margin-right:.5in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;line-height:9.65pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                        <p
                            style='margin-right:.5in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;line-height:9.65pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                        <p
                            style='margin-right:.5in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;text-align:justify;line-height:9.65pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;margin-top:.1pt;'>
                            <span style='font-size:12px;font-family:"Calibri","sans-serif";'>&nbsp;</span></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;margin-top:.1pt;'>
                            <span style='font-size:12px;font-family:"Calibri","sans-serif";'>&nbsp;</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:center;line-height:150%;'>
                            <strong><span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>Subject:
                                    Appointment for post of&nbsp;</span></strong><strong><span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>{{$staffappointmentData->designation ??''}}</span></strong></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>Dear Amar,</span></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>Welcome
                                to<strong>&nbsp;K G Somani &amp; Co LLP</strong></span></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>We
                                are pleased to offer you, the position of<strong>&nbsp;<span>{{$staffappointmentData->designation ??''}}</span></strong></span><strong><span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;</span></strong><span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>with
                                K G Somani &amp; Co LLP on the following terms and conditions.</span></p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:12.75pt;margin-top:0in;background:white;'>
                            <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div
                            style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>
                            <ol style="margin-bottom:0in;list-style-type: undefined;margin-left:-0.25in;">
                                <li
                                    style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>
                                    <strong><span
                                            style='line-height:107%;font-family:"Arial","sans-serif";font-size:13px;'>Commencement
                                            of Employment</span></strong></li>

                                <p
                                    style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;text-indent:34.15pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>1.1 &nbsp; &nbsp;Your
                                        employment will be effective as of <strong>
                                                {{date('F d,Y', strtotime($staffappointmentData->employee_effective_date ??''))}}</strong></span></p>
                              
                                <p
                                    style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                                <li
                                    style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>
                                    <strong><span
                                            style='line-height:107%;font-family:"Arial","sans-serif";font-size:13px;'>Assignment</span></strong>
                                </li>
                                <p
                                    style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                                <p
                                    style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>2.1 &nbsp; Y<span
                                            style="background:white;">our present position will be that
                                            of&nbsp;</span><strong>{{$staffappointmentData->designation ??''}}</strong> <span
                                            style="background:white;">to be posted at our<strong>&nbsp;{{$staffappointmentData->location ??''}}</strong> office.
                                            The company may however reassign and/or transfer you to any other similar
                                            position in the company, anywhere in India. You will be expected to
                                            undertake such reasonable duties as the company shall from time to time
                                            determine. You may also be required to perform duties for other group
                                            companies if necessary.</span></span></p>
                                <p
                                    style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>

                                <li
                                    style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>
                                    <strong><span style="font-size:10.0pt;;">Probation period</span></strong>
                                </li>

                                <p
                                    style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:12.0pt;text-align:justify;'>
                                    <strong><span
                                            style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></strong>
                                </p>
                                <p
                                    style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:12.0pt;text-align:justify;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>You will have a
                                        period of 3 months (extendable upto one year at the discretion of the Company)
                                        of probation You will be considered for confirmation in the Company&acute;s
                                        service if the Company is satisfied with reference to your overall
                                        work/performance and conduct during the period of probation. After the
                                        successful completion of your probation period you will be entitled for the
                                        leaves mentioned in the Appointment letter. Kindly refer to clause 5.1 &amp;
                                        5.2.</span></p>
                                <li
                                    style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>
                                    <strong><span
                                            style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>Salary</span></strong>
                                </li>
                                <p
                                    style='margin-right:-17.0pt;margin-left:19.85pt;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;text-indent:16.15pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                                <p
                                    style='margin-right:-.1in;margin-left:-.1in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;text-indent:16.15pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>4.1 Your total Cost
                                        to the Company will be <strong>Rs. {{$staffappointmentData->salary ??''}} /- per month.</strong></span>
                                </p>
                                <p
                                    style='margin-right:-.1in;margin-left:-.1in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp;</span></p>
                                <p
                                    style='margin-right:-.1in;margin-left:-.1in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;text-indent:16.15pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>4.2 Your salary will
                                        be reviewed periodically as per your performance and company policy.</span></p>
                                <p
                                    style='margin-right:0in;margin-left:.4in;font-size:16px;font-family:"Times New Roman","serif";margin-top:0in;margin-bottom:.0001pt;'>
                                    <span style='font-size:13px;font-family:"Arial","sans-serif";'>You will be liable to
                                        pay taxes &amp; accountabilities as required under Indian Tax Law. Except for
                                        the obligation to withhold taxes from your remuneration, KGS assumes no
                                        responsibility for your personal tax affairs.</span></p>
                                <li><strong><span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>Annual
                                            Leave/Holidays</span></strong>
                                </li><span
                                    style='line-height:107%;font-family:"Arial","sans-serif";font-size:13px;'><br>&nbsp;<br>&nbsp;On
                                    the completion on probation period, your will be eligible for 24 days leave
                                    in the full calendar year-</span>

                                <ol class="decimal_type" style="list-style-type: ;">
                                    <li><span
                                            style='line-height:150%;font-family:"Arial","sans-serif";font-family:"Arial","sans-serif";font-size:10.0pt;color:windowtext;'>You
                                            are entitled to casual leave of 18 days.&nbsp;</span></li>
                                    <li><span
                                            style='line-height:150%;font-family:"Arial","sans-serif";font-family:"Arial","sans-serif";font-size:10.0pt;color:windowtext;'>You
                                            are entitled to 6 working days of paid sick leave.&nbsp;</span></li>
                                    <li><span
                                            style='line-height:150%;font-family:"Arial","sans-serif";font-family:"Arial","sans-serif";font-size:10.0pt;color:windowtext;'>Apart
                                            from the above-mentioned leaves you will also be eligible for public
                                            holidays for each calendar year as approved by
                                            Management.&nbsp;</span></li>
                                </ol>

                    </ol>
                  </div>
                  <hr>
                  <div class="footerr">
                       
                        <div style="text-align:center; font-size:14px;" class="text-success m-b-15"><span style="color:rgb(32,87,104)" >Regd. Office: 3/15, ASAF ALI ROAD NEW DELHI-110002
                            <br>  Corp Office: 4/1 Asaf Ali Road, 3rd Floor, Delite Cinema Building, Delhi 110002. Tel: +91-11-41403938, 23277677, 23252225
                        </span> <br><b><span style="color:rgb(0,31,95)">Converted from K G Somani & Co (Partnership firm) w.e.f 24th June 2021</span></b>
                          </div>
                          </div>

                    </div>

                </div>

                        
    </div>
    
                        </div>
                </div>
        

        <div class="body-content">
                <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-6">

                        <address>
                            <h2><strong style="color:rgb(0,31,95)">K G SOMANI & CO. LLP</strong></h2>
                            <strong style="margin-left: 66px;color:rgb(0,31,95)">CHARTERED ACCOUNTANTS</strong><br>
                        </address>

                    </div>
                    <div class="col-sm-6 text-right">
                        <b>
                            <div style=" font-size:17px">www.kgsomani.com</div>
                            <div class="text m-b-15" style="font-size:17px ">office@kgsomani.com</div>

                            <div style="font-size:17px;color:rgb(0,0,0)">LLP Identification No. AAX-5330
                            </div>
                        </b>
                    </div>
                </div>
                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                <div class="row">
                    <div class="col-sm-12">
                        <div
                            style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>
                                
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>

                            <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           6.&nbsp; Nature of duties</span></strong>
                            
     
                        <p
                            style='margin-right:0in;margin-left:.25in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <strong><span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;</span></strong>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>6.1
                                You will perform to the best of your ability all the duties as are inherent in
                                your post and such additional duties as the company may call upon you to
                                perform, from time to time.</span></p>
                                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                                <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           7.&nbsp; Responsibility</span></strong>
                                
     
                        <p
                            style='margin-right:0in;margin-left:.25in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <strong>
                                <span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;</span></strong>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                7.1 You will be governed by the Policies of the company as may be applicable to you from time to time.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                7.2 Regular Attendance and Punctuality will not be compromised.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                7.3 Any act of dishonesty, disobedience, insubordination, incivility, irregularity in attendance or other misconduct or
neglect of duty, or incompetence in the discharge of duty on your part of the breach of any of the terms, conditions
and stipulations contained herein will lead to strict action by the Management.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>

                    
                            <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           8.&nbsp; Company Property</span></strong>
                                <!-- </li> -->
     
                        <p
                            style='margin-right:0in;margin-left:.25in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <strong>
                                <span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;</span></strong>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                8.1 You will always maintain in good condition Company property, which may be entrusted to you for official use
during your employment. Upon the termination of your employment for any reason, On your last working day, you
will return to the Company all Company documents (and all copies thereof) and other Company property within
your possession, custody or control, including, but not limited to, Company-provided laptops, computers, cell
phones, wireless electronic mail devices or other equipment, or documents and property belonging to the
Company, Identity Cards, Visiting Cards, Credit Cards, Company files, notes, financial and operational
information, client/customer lists and contact information, product and services information,
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                8.2 In addition, if you have used any personally-owned computer, server, or e-mail system to receive, store,
review, prepare or transmit any confidential or proprietary data, materials or information of the Company, On the
last working day of your Separation, you must provide the Company with a computer-useable copy of such
information and permanently delete and expunge such confidential or proprietary information from those systems
without retaining any reproductions
<p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        

(in whole or in part); and you agree to provide the Company access to your system, as requested, to verify that
the necessary copying and deletion is done.
                            </span>
                        </p>
                        
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                8.3 In case you do not return the company asset and the company do not hear anything from you about returning
the company asset as per the above mentioned clause 8.1 &amp; 8.2, Company shall take a legal action against you
to recover its assets or documents&quot;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>

                </div>
                <hr>
                  <div class="footerr">
                       
                        <div style="text-align:center; font-size:14px;" class="text-success m-b-15"><span style="color:rgb(32,87,104)" >Regd. Office: 3/15, ASAF ALI ROAD NEW DELHI-110002
                            <br>  Corp Office: 4/1 Asaf Ali Road, 3rd Floor, Delite Cinema Building, Delhi 110002. Tel: +91-11-41403938, 23277677, 23252225
                        </span> <br><b><span style="color:rgb(0,31,95)">Converted from K G Somani & Co (Partnership firm) w.e.f 24th June 2021</span></b>
                          </div>
                          </div>
                </div>
            </div>
            </div>
                </div>
            </div>
        <!--/.body content-->
        <div class="body-content">
                <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-6">

                        <address>
                            <h2><strong style="color:rgb(0,31,95)">K G SOMANI & CO. LLP</strong></h2>
                            <strong style="margin-left: 66px;color:rgb(0,31,95)">CHARTERED ACCOUNTANTS</strong><br>
                        </address>

                    </div>
                    <div class="col-sm-6 text-right">
                        <b>
                            <div style=" font-size:17px">www.kgsomani.com</div>
                            <div class="text m-b-15" style="font-size:17px ">office@kgsomani.com</div>

                            <div style="font-size:17px;color:rgb(0,0,0)">LLP Identification No. AAX-5330
                            </div>
                        </b>
                    </div>
                </div>
                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                <div class="row">
                    <div class="col-sm-12">
                        <div
                            style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>
                            <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                   <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                            9.&nbsp; Confidentiality-</span></strong>
                
     
                        <p
                            style='margin-right:0in;margin-left:.25in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <strong>
                                <span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;</span></strong>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                9.1 You must always maintain the highest degree of confidentiality and keep as confidential the records, documents and other Confidential Information relating to the business of the Company which may be known to you or confided in you by any means and you will use such records, documents and information only in a duly authorized manner in the interest of the Company. 
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                9.2	Confidential Information’ means information about the Company’s business and that of its customers/clients which is not available to the general public and which may be learnt by you during your employment. This includes, but is not limited to, information relating to the organization, its clients/customer lists, employment policies, personnel, and information about the Company’s products, processes including ideas, concepts, projections, technology, manuals, designs, specifications, records and other documents containing such Confidential Information.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                9.3	At no time, will you remove any Confidential Information from the office without permission.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                9.4	Your duty to safeguard and not disclose Confidential Information will survive till the expiration or after termination of your employment with the Company.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                9.5	Breach of the conditions of this clause will render you liable to summary dismissal under clause above in addition to any other remedy the Company may have against you in law. 
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                9.6	You agree to sign engagement specific non-disclosure/confidential agreements, if so required by the company or certain client of the company.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                9.7	You recognize and acknowledge that a violation of this condition, either during or after termination may result in your employment termination and/or the initiation of legal proceedings against you. you will be personally liable to the company and its clients.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p> 
            
                        <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           10.&nbsp; Privacy and Data Security</span></strong>
                        
     
                        <p
                            style='margin-right:0in;margin-left:.25in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <strong>
                                <span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;</span></strong>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                10.1. You as an employee acknowledges that the any data or document or information regardless of media on which it is stored (paper, computer, videos, recorders etc) or  personal information, transmitted 
through any source, electronic media, face to face conversation, internet or any additional system software, is considered to be sensitive and confidential. You understand that access to this information is to a legitimate, “need to know” basis and is restricted to information directly related to your assigned duties within the organization
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                10.2. Any User ID and/or password issued to your exclusive use, is not to be shared with or delegated to others and you will be responsible for the same.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                10.3. Some information disclosed or acquired by reason of your employment may be confidential and you agree not to disclose any confidential information, data, or access or security codes, passwords, anytime , except for a “need to know” basis during or after your employment.
                                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                                You will be responsible for the data you retrieve, and ultimately for documents you produce, publish, store, or otherwise communicate.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                10.4. Company laptops/Desktops are to be used only for the authorized purposes only. You understand that you are to restrict data retrieval and other computing activities only to information you are specifically permitted to access as elated to assigned duties.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                10.5. You understand and agree that it is your duty to maintain confidentiality continues after you are no longer employed with the company.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                10.6. When in doubt, you will confer with concerned personal or the supervisor. You agree to report any known security violation to Data Security
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                10.7. Failure to abide by the rules may result in data access being discontinued and/or disciplinary action, up to and including termination of employment and may subject the user to further civil or criminal penalties.
                            </span>
                        </p>
                        


                </div>
                <hr>
                  <div class="footerr">
                       
                        <div style="text-align:center; font-size:14px;" class="text-success m-b-15"><span style="color:rgb(32,87,104)" >Regd. Office: 3/15, ASAF ALI ROAD NEW DELHI-110002
                            <br>  Corp Office: 4/1 Asaf Ali Road, 3rd Floor, Delite Cinema Building, Delhi 110002. Tel: +91-11-41403938, 23277677, 23252225
                        </span> <br><b><span style="color:rgb(0,31,95)">Converted from K G Somani & Co (Partnership firm) w.e.f 24th June 2021</span></b>
                          </div>
                          </div>
                </div>
            </div>
            </div>
                </div>
            </div>
            <!--/.body content-->
        <div class="body-content">
                <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-6">

                        <address>
                            <h2><strong style="color:rgb(0,31,95)">K G SOMANI & CO. LLP</strong></h2>
                            <strong style="margin-left: 66px;color:rgb(0,31,95)">CHARTERED ACCOUNTANTS</strong><br>
                        </address>

                    </div>
                    <div class="col-sm-6 text-right">
                        <b>
                            <div style=" font-size:17px">www.kgsomani.com</div>
                            <div class="text m-b-15" style="font-size:17px ">office@kgsomani.com</div>

                            <div style="font-size:17px;color:rgb(0,0,0)">LLP Identification No. AAX-5330
                            </div>
                        </b>
                    </div>
                </div>
                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                <div class="row">
                    <div class="col-sm-12">
                        <div
                            style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>
                            <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p> 
                       
                        <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           11.&nbsp; Non-Solicitation</span></strong>
                                
     
                        <p
                            style='margin-right:0in;margin-left:.25in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <strong>
                                <span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;</span></strong>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                11.1	Upon leaving the company, you will not without prior written consent of the company, for a period of 18 month from the date of ceasing employment or contract, solicit, interfere with or entice away any person, firm who has, at any time during your employment  with the firm, been:
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                11.1.1	A client of firm with whom you had contact or been involved in the provisions of services or,
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                11.1.2	An employee of the firm
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                11.2	To prevent any potential conflict of interest or breach of confidentiality, you will not accept an appointment offered by any client for whom an assignment is being performed you or on which you are working for 6 months aft er the assignment is completed, unless appropriate written consent is being obtained from the firm. It is mandatory to immediately notify your director or partner about such offer.
                         </span>
                        </p>

                            <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                                <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           12.&nbsp; Notice Period/Termination-</span></strong>
                        
                        <p
                            style='margin-right:0in;margin-left:.25in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <strong>
                                <span
                                    style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;</span></strong>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                12.1 Either party may terminate the services by giving each other a notice of <strong>{{$staffappointmentData->notice_period ??''}}</strong> days. The notice period may be reduced if the company agrees.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                12.2 Notwithstanding the aforementioned, Company shall be entitled to terminate your employment without notice, indemnities and compensation in any of the following events: 
                            </span>
                        </p>

                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                12.1.1 if you are, in the opinion of the Company, guilty of dishonesty, misconduct or negligence in the performance of your duties; 
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                12.1.2  if you have been found to have committed a serious breach or continual material breach of any of your duties or obligations;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                12.1.3  if you are found to have made illegal monetary profit or received any gratuities or other rewards, in cash or in kind, out of any of the Company’s affairs or any of its subsidiaries or related companies.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                12.1.4  If, at any time in future, it comes to the knowledge of the management that any of this information (information furnished in your application for employment) is incorrect or any relevant information has been withheld then your employment based on this letter of appointment is liable to be terminated without notice or any compensation in lieu thereof.
                            </span>
                        </p>

                </div>
                <hr>
                  <div class="footerr">
                       
                        <div style="text-align:center; font-size:14px;" class="text-success m-b-15"><span style="color:rgb(32,87,104)" >Regd. Office: 3/15, ASAF ALI ROAD NEW DELHI-110002
                            <br>  Corp Office: 4/1 Asaf Ali Road, 3rd Floor, Delite Cinema Building, Delhi 110002. Tel: +91-11-41403938, 23277677, 23252225
                        </span> <br><b><span style="color:rgb(0,31,95)">Converted from K G Somani & Co (Partnership firm) w.e.f 24th June 2021</span></b>
                          </div>
                          </div>
                </div>
            </div>
            </div>
                </div>
            </div>
        <div class="body-content">
                <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-6">

                        <address>
                            <h2><strong style="color:rgb(0,31,95)">K G SOMANI & CO. LLP</strong></h2>
                            <strong style="margin-left: 66px;color:rgb(0,31,95)">CHARTERED ACCOUNTANTS</strong><br>
                        </address>

                    </div>
                    <div class="col-sm-6 text-right">
                        <b>
                            <div style=" font-size:17px">www.kgsomani.com</div>
                            <div class="text m-b-15" style="font-size:17px ">office@kgsomani.com</div>

                            <div style="font-size:17px;color:rgb(0,0,0)">LLP Identification No. AAX-5330
                            </div>
                        </b>
                    </div>
                </div>
                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                                <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>
                <div class="row">
                    <div class="col-sm-12">
                        <div
                            style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman","serif";'>

                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                       
                        <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           13.&nbsp; Exit Formalities</span></strong>
                        
     
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                Before termination of employment, you will be required to complete Exit Formalities and sign necessary forms in this regard, as per the policy of the firm,
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                You will be required to return to the firm, all documents including copies thereof any property including but not limited to Laptop, Mobile phone, Corporate Credit Card, Internet data card etc. You are also specifically retrained from keeping the copies or extracts of any of the document.
                            </span>
                        </p>

                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        
                        <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           14.&nbsp; Set Off</span></strong>
                        
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                You as an employee explicitly agree that your full and final settlement of dues shall happen within 30-45 days of the completion of aforesaid formalities and first adjusting all dues under whatsoever head them due to the company. In case of shortfall in the amounts to be recovered. You shall forthwith settle
with remaining amount without protest. The exit formalities shall be kept in abeyance till the deficit amount is paid in full.

                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>

                        <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;'>
                           15.&nbsp; General</span></strong>
     
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                As an employee of the firm, you are required to book proper time and expense. Use only the official Email ID provided by the firm, not share your access card with anyone, dress in a professional manner at all the time.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                It is also mandatory to keep the HR informed about any changes in your personal particulars or documents, address change, updated adhaar or pan card, Driving license etc.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                The conditions contained herein in the contract of employment are indicative only and can be modified time to time. For any clarification on the firm’s policy, please feel free to get in touch with the Human Resource Department
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                All other standard and general rules, practices and policies of the Company as existing now and which may be amended from time to time will be applicable to you and you will be expected to abide by the same.
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>
                                We are delighted to have you in the company. Please indicate your understanding and acceptance of the above terms and conditions by signing and returning the duplicate copy of this letter.
                            </span>
                        </p>
                 
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>

                        <!-- <strong>
                           <span style='font-family:"Arial","sans-serif";background:white;font-size:13px;background:yellow;'>
                           16.&nbsp; Should give a “text box “in case any other clause is required to be added. If no clause is being added, it should show Nill</span></strong> -->
     
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <p
                            style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Cambria","serif";margin:0in;margin-bottom:.0001pt;color:black;text-align:justify;line-height:150%;'>
                            <span
                                style='font-size:13px;line-height:150%;font-family:"Arial","sans-serif";color:windowtext;'>&nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            </span>
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
    <strong>                        
<p style="margin-left:10%;">Best Regards</span></p>
<p style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;background:white;'>&nbsp; &nbsp; &nbsp;</p>
<p style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;background:white;'>&nbsp;</p>
<p style="margin-left:10%;">&ldquo;<span style="background:yellow;">Signature</span>&rdquo;</p> 
<p style="margin-left:10%;"><span style='font-size:13px;font-family:"Arial","sans-serif";'>Human Resource</p>
<p style="margin-left:10%;"><span style='font-size:13px;font-family:"Arial","sans-serif";'>K G Somani &amp; Co LLP</span></p>
                                </strong>
</div>

<div class="col-sm-6">
        
<p style="margin-left:30%;">Accepted and Agreed</p>
<p style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;background:white;'><span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span></p>
<p style='margin-right:0in;margin-left:0in;font-size:16px;font-family:"Times New Roman","serif";margin:0in;margin-bottom:.0001pt;background:white;'><span style='font-size:13px;font-family:"Arial","sans-serif";'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span></p>
<p style="margin-left:30%;">Name of Employee - <strong>{{$staffappointmentData->team_member ??''}}( {{$staffappointmentData->rolename ??''}})</strong></span></p>
<p style="margin-left:30%;">Signature ___________________________</span></p>
                        </div>         
                  </div>
                  
                  <hr>
                  <div class="footerr">
                       
                       <div style="text-align:center; font-size:14px;" class="text-success m-b-15"><span style="color:rgb(32,87,104)" >Regd. Office: 3/15, ASAF ALI ROAD NEW DELHI-110002
                           <br>  Corp Office: 4/1 Asaf Ali Road, 3rd Floor, Delite Cinema Building, Delhi 110002. Tel: +91-11-41403938, 23277677, 23252225
                       </span> <br><b><span style="color:rgb(0,31,95)">Converted from K G Somani & Co (Partnership firm) w.e.f 24th June 2021</span></b>
                         </div>
                         </div>
                </div>
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
