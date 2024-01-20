{{-- ! Old code  --}}

{{-- <!doctype html>
<html lang="en">

<head>
    <!--  meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- Bootstrap CSS -->

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('backEnd/image/kgsomani.png') }}">
    <!--Global Styles(used by all pages)-->
    <link href="{{ url('backEnd/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/typicons/src/typicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/themify-icons/themify-icons.min.css') }}" rel="stylesheet">
    <!--Third party Styles(used by this page)-->
    <link href="{{ url('backEnd/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!--Start Your Custom Style Now-->
    <link href="{{ url('backEnd/dist/css/style.css') }}" rel="stylesheet">

    <!--summernote-->

    <!--Third party Styles(used by this page)-->
    <link href="{{ url('backEnd/plugins/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">

    <!--wysihtml5-->
    <!--Third party Styles(used by this page)-->
    <link href="{{ url('backEnd/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" rel="stylesheet">


    <!--Third party Styles(used by this page)-->
    <link href="{{ url('backEnd/plugins/icheck/skins/all.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <style>
        .mm-active2 {
            background-color: #37a000 !important;
            color: #fff !important;
            display: block;
        }
    </style>

</head>

<body style="background-color:white;">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-12 col-xl-12">
                    <div class=" shadow-2-strong card-registration">

                        <div class="card-body p-md-5">
                            <div class="row row-sm">
                                <h3>Dear All,</h3>
                                <div>
                                    <br>
                                    <br>
                                    <div class="row row-sm">
                                        <div class="col-2"></div>
                                        <div class="col-8">
                                            <p style="text-align:center;"><b><a
                                                        href="mailto:{{ $bithdayemail }}">{{ $bithdayteam }}</a></b>
                                                is
                                                celebrating
                                                @if ($gender == 'Male')
                                                    his
                                                @elseif($gender == 'Female')
                                                    her
                                                @endif Birthday today.
                                            </p>
                                            <p style="text-align:center;">Wishing
                                                @if ($gender == 'Male')
                                                    him
                                                @elseif($gender == 'Female')
                                                    her
                                                @endif
                                                a very Happy Birthday on the
                                                behalf of entire KGS Family.
                                            </p>
                                            <p style="text-align:center;"><b>@<a
                                                        href="mailto:{{ $bithdayemail }}">{{ $bithdayteam }}</a></b>
                                                We
                                                are thrilled to
                                                be able to share this great day with you, and glad to have you as a
                                                valuable
                                                member of our KGS Family.</p>
                                            <p style="text-align:center;">We wish you the best on your
                                                special day!</p>
                                        </div>
                                    </div><br>
                                    <div class="row row-sm">

                                        <div class="col-4"></div>
                                        <div class="col-4" style="margin-left:25%; margin-right:25%;">

                                            <img class="card-img-top" style="width:100%;height:70%;"
                                                src="{{ url('backEnd/image/HappyBirthday.png') }}" alt="Card image">

                                        </div>
                                        <div class="col-4"></div>
                                    </div><br>
                                    <div class="row row-sm">
                                        <p style="font-size: 12px;">Human Resource Department <br><br>K G Somani & Co.
                                            LLP (Formerly K G Somani & Co) , 4/1, Delite Cinema Building Asaf Ali road,
                                            3rd Floor, New Delhi
                                            110002 India<br><br>
                                            Email- <a href="mailto:hr@kgsomani.com"><span
                                                    style="color: #4040F3">hr@kgsomani.com</span></a> , Web - <a
                                                href="www.kgsomani.com"><span
                                                    style="color: #4040F3">www.kgsomani.com</span></a>
                                            <br><br>
                                            Registered Address: 3/15 Asaf Ali Road, 4th Floor, Delhi 110002<br><br>
                                            <span style="color: green">
                                                Think before Printing - Save planet by planting a tree<br><br>
                                                Go green with</span> <a href="www.Gvriksh.in">
                                                <span style="color: #4040F3">www.Gvriksh.in</span></a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
    </section>
    <!--Global script(used by all pages)-->
    <script data-cfasync="false" src="{{ url('backEnd/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}">
    </script>
    @if (Request::is('gnattchart') || Request::is('gnattchart/store'))
    @else
        <script src="{{ url('backEnd/plugins/jQuery/jquery-3.4.1.min.js') }}"></script>
        <!--Page Active Scripts(used by this page)-->
        <script src="{{ url('backEnd/dist/js/pages/dashboard.js') }}"></script>
    @endif
    <script src="{{ url('backEnd/dist/js/popper.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/chartJs/Chart.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/sparkline/sparkline.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!--Page Scripts(used by all page)-->
    <script src="{{ url('backEnd/dist/js/sidebar.js') }}"></script>

    <!--colorpicker(used by all page)-->
    <script src="{{ url('backEnd/dist/js/jscolor.js') }}"></script>

    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/datatables/data-basic.active.js') }}"></script>


    <!--summernote-->
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/summernote/summernote.active.js') }}"></script>

    <!--wysihtml5-->
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/wysihtml5.js') }}"></script>
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/wysihtml5.active.js') }}"></script>

    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/datatables/data-bootstrap4.active.js') }}"></script>


    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/jquery.sumoselect/jquery.sumoselect.min.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/dist/js/pages/demo.select2.js') }}"></script>
    <script src="{{ url('backEnd/dist/js/pages/demo.jquery.sumoselect.js') }}"></script>


    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/dist/js/pages/icheck.active.js') }}"></script>
    @if (Request::is('invoice/create') || Request::is('invoice/*/edit') || Request::is('timesheet/create'))
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function() {
                $('#datepicker').datepicker({
                    dateFormat: 'dd-mm-yy'
                });
            });
            $(function() {
                $("#datepickers").datepicker({
                    maxDate: new Date
                });
            });
        </script>
    @endif
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/jQuery-mask-plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/jQuery-mask-plugin/examples.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script>
        $(document).keypress(
            function(event) {
                if (event.which == '13') {
                    event.preventDefault();
                }
            });
    </script>
    <script>
        $(function() {
            var current = location.pathname;
            $('.metismenu li a').each(function() {
                var $this = $(this);
                // if the current path is like this link, make it active
                if ($this.attr('href').indexOf(current) !== -1) {
                    $this.addClass('mm-active2');
                }
            })
        })
    </script>

</body>

</html> --}}





<!doctype html>
<html lang="en">

<head>
    <!--  meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- Bootstrap CSS -->

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('backEnd/image/kgsomani.png') }}">
    <!--Global Styles(used by all pages)-->
    <link href="{{ url('backEnd/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/typicons/src/typicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/themify-icons/themify-icons.min.css') }}" rel="stylesheet">
    <!--Third party Styles(used by this page)-->
    <link href="{{ url('backEnd/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!--Start Your Custom Style Now-->
    <link href="{{ url('backEnd/dist/css/style.css') }}" rel="stylesheet">

    <!--summernote-->

    <!--Third party Styles(used by this page)-->
    <link href="{{ url('backEnd/plugins/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">

    <!--wysihtml5-->
    <!--Third party Styles(used by this page)-->
    <link href="{{ url('backEnd/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" rel="stylesheet">


    <!--Third party Styles(used by this page)-->
    <link href="{{ url('backEnd/plugins/icheck/skins/all.css') }}" rel="stylesheet">
    <link href="{{ url('backEnd/plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <style>
        .mm-active2 {
            background-color: #37a000 !important;
            color: #fff !important;
            display: block;
        }

        .text {
            font-weight: bold;
        }
    </style>

</head>

<body style="background-color:white;">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-12 col-xl-12">
                    <div class=" shadow-2-strong card-registration">

                        <div class="card-body p-md-5">
                            <div class="row row-sm">
                                <div>
                                    <p class="text">Dear <span class="text">{{ $name }}</span>,</p>
                                </div>
                                <div>
                                    <p>We value your special day just as much as we value you. On your birthday, we send
                                        you our warmest and
                                        most heartfelt wishes.
                                    </p>
                                    <img src="{{ url('backEnd/image/thumbnail_MTk3MDIwNDE3MjU1Mjg2NDEy.jpg') }}"
                                        class="img-fluid" alt="Responsive image">
                                    <p>We are thrilled to be able to share this great day with you, and glad to have you
                                        as a valuable member of
                                        the team. We appreciate everything you’ve done to help us flourish and grow.</p>
                                    <p>Our entire family at V. Sankar Aiyar & Co. wishes you a very happy birthday and
                                        wish you the best on your
                                        special day!</p>
                                    <p></p>
                                </div>
                                <div>
                                    <p>Regards,</p>
                                    <p>V. Sankar Aiyar & Co.</p>
                                </div>
                            </div>
                        </div>
                    </div>
    </section>
    <!--Global script(used by all pages)-->
    <script data-cfasync="false" src="{{ url('backEnd/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}">
    </script>
    @if (Request::is('gnattchart') || Request::is('gnattchart/store'))
    @else
        <script src="{{ url('backEnd/plugins/jQuery/jquery-3.4.1.min.js') }}"></script>
        <!--Page Active Scripts(used by this page)-->
        <script src="{{ url('backEnd/dist/js/pages/dashboard.js') }}"></script>
    @endif
    <script src="{{ url('backEnd/dist/js/popper.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/chartJs/Chart.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/sparkline/sparkline.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!--Page Scripts(used by all page)-->
    <script src="{{ url('backEnd/dist/js/sidebar.js') }}"></script>

    <!--colorpicker(used by all page)-->
    <script src="{{ url('backEnd/dist/js/jscolor.js') }}"></script>

    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/datatables/data-basic.active.js') }}"></script>


    <!--summernote-->
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/summernote/summernote.active.js') }}"></script>

    <!--wysihtml5-->
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/wysihtml5.js') }}"></script>
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/wysihtml5.active.js') }}"></script>

    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/datatables/data-bootstrap4.active.js') }}"></script>


    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/jquery.sumoselect/jquery.sumoselect.min.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/dist/js/pages/demo.select2.js') }}"></script>
    <script src="{{ url('backEnd/dist/js/pages/demo.jquery.sumoselect.js') }}"></script>


    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/dist/js/pages/icheck.active.js') }}"></script>
    @if (Request::is('invoice/create') || Request::is('invoice/*/edit') || Request::is('timesheet/create'))
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function() {
                $('#datepicker').datepicker({
                    dateFormat: 'dd-mm-yy'
                });
            });
            $(function() {
                $("#datepickers").datepicker({
                    maxDate: new Date
                });
            });
        </script>
    @endif
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/jQuery-mask-plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ url('backEnd/plugins/jQuery-mask-plugin/examples.js') }}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script>
        $(document).keypress(
            function(event) {
                if (event.which == '13') {
                    event.preventDefault();
                }
            });
    </script>
    <script>
        $(function() {
            var current = location.pathname;
            $('.metismenu li a').each(function() {
                var $this = $(this);
                // if the current path is like this link, make it active
                if ($this.attr('href').indexOf(current) !== -1) {
                    $this.addClass('mm-active2');
                }
            })
        })
    </script>

</body>

</html>
