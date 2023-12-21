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

                                <h3><strong style="color:rgb(0,31,95)">K G SOMANI & CO. LLP</strong></h3>
                                <strong style="color:rgb(0,31,95)">Annual Independence Declaration Form </strong><br>

                            </div>
                        </div><br><br><br>
                        <div class="row">
                            <div class="col-sm-6">

                                <address>
                                    <p><strong style="color:rgb(0,31,95)">Name and Address of the Client being Audited :
                                            XYZ ( Delhi )</strong></p>
                                    <p><strong style="color:rgb(0,31,95)">Declaration for the FY :
                                            {{$clientspecific->year ??''}}</strong></p>
                                    <p><strong style="color:rgb(0,31,95)">Name of Article/Manager/Employee of the
                                            Firm : {{$clientspecific->team_member ??''}}</strong></p>
                                    <p><strong style="color:rgb(0,31,95)">Name of Partner :
                                            {{$clientspecific->partners ??''}}</strong></p>

                                </address>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Sr No.</th>
                                        <th>Particulars</th>
                                        <th>Yes/No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <small>1</small>
                                        </td>

                                        <td>Do you have a direct or indirect holding of more than 2% Capital of any
                                            client or its subsidiaries/affiliates?</td>
                                        <td>@if($clientspecific->subsidiaries == 1)
                                            <span>Yes ,
                                                {{ $clientspecific->subsidiariesother ??'' }}</span>

                                            @elseif($clientspecific->subsidiaries == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>2</small>
                                        </td>

                                        <td>Do you have a financial interest of more than 2% in any major competitors,
                                            investors in or affiliates of any client of the Firm?</td>
                                        <td>@if($clientspecific->financial == 1)
                                            <span>Yes ,
                                                {{ $clientspecific->financialother ??'' }}</span>
                                            @elseif($clientspecific->financial == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>3</small>
                                        </td>

                                        <td>Do you have any outside business relationship with any client of the Firm
                                            or an officer, director or principal shareholder of any Clients of the Firm
                                            having the objective of financial gain?</td>
                                        <td>@if($clientspecific->outside == 1)
                                            <span>Yes , {{ $clientspecific->outsideother ??'' }}</span>
                                            @elseif($clientspecific->outside == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>4</small>
                                        </td>

                                        <td>Do you owe any client any amount?</td>
                                        <td>@if($clientspecific->client == 1)
                                            <span>Yes , {{ $clientspecific->clientother ??'' }}</span>
                                            @elseif($clientspecific->client == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>5</small>
                                        </td>

                                        <td>Do you have the authority to sign cheques for any client of the Firm?</td>
                                        <td>@if($clientspecific->authority == 1)
                                            <span>Yes ,
                                                {{ $clientspecific->authorityother ??'' }}</span>
                                            @elseif($clientspecific->authority == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>6</small>
                                        </td>

                                        <td>Are you connected with any client of the Firm as a promoter, underwriter or
                                            voting trustee, director, partner, officer or in any capacity equivalent to
                                            a member of management or an employee?</td>
                                        <td>@if($clientspecific->underwriter == 1)
                                            <span>Yes ,
                                                {{ $clientspecific->underwriterother ??'' }}</span>
                                            @elseif($clientspecific->underwriter == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>7</small>
                                        </td>

                                        <td>Do you serve as a director, Partner, trustee, officer, or employee of any
                                            client of the Firm?</td>
                                        <td>@if($clientspecific->trustee == 1)
                                            <span>Yes , {{ $clientspecific->trusteeother ??'' }}</span>
                                            @elseif($clientspecific->trustee == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>8</small>
                                        </td>

                                        <td>Has your spouse or children or relative is employed by any client of the
                                            Firm?</td>
                                        <td>@if($clientspecific->spouse == 1)
                                            <span>Yes , {{ $clientspecific->spouseother ??'' }}</span>
                                            @elseif($clientspecific->spouse == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>9</small>
                                        </td>

                                        <td>Are you connected with any client of the Firm in any other capacity
                                            directly or indirectly which may compromise your independence?</td>
                                        <td>@if($clientspecific->compromise == 1)
                                            <span>Yes ,
                                                {{ $clientspecific->compromiseother ??'' }}</span>
                                            @elseif($clientspecific->compromise == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>10</small>
                                        </td>

                                        <td>Do you have any pending litigation with any client of the Firm?</td>
                                        <td>@if($clientspecific->litigation == 1)
                                            <span>Yes ,
                                                {{ $clientspecific->litigationother ??'' }}</span>
                                            @elseif($clientspecific->litigation == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>11</small>
                                        </td>

                                        <td>Are you relative of any client of the Firm</td>
                                        <td>@if($clientspecific->relative == 1)
                                            <span>Yes , {{ $clientspecific->relativeother ??'' }}</span>
                                            @elseif($clientspecific->relative == 2)
                                            <span>No</span>
                                            @endif</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <p><strong style="color:rgb(0,31,95)">Note:</strong></p><br>
                                <p><strong style="margin-left:40px;color:rgb(0,31,95)">1. Relative means a relative as
                                        defined in Companies Act 2013.</strong></p>
                                <p><strong style="margin-left:40px;color:rgb(0,31,95)">2. Where answer is yes, please
                                        provide complete details in a separate sheet.</strong></p>
                                <p style="margin-left:40px;"><strong>Date :
                                        {{ date('F d,Y', strtotime($clientspecific->created_at)) }}</strong>
                                </p>



                            </div>

                            <div class="col-sm-6">
                                <br><br>
                                <p style="margin-left:30%;"><strong>Signature : E-Verified through CapITall by
                                        {{ $clientspecific->team_member }} on
                                        {{ date('F d,Y', strtotime($clientspecific->created_at)) }}
                                        {{ date('h:i A', strtotime($clientspecific->created_at)) }}</strong>
                                </p>
                                <p style="margin-left:30%;"><strong>Name :
                                        {{$clientspecific->team_member ??''}}</strong></p>
                                <p style="margin-left:30%;"><strong>Designation :
                                        {{ $clientspecific->rolename ??''}}</strong></p>

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
