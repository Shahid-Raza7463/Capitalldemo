<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
        <meta name="author" content="Bdtask">
        <title>K.G.Somani</title>
        
         <!-- stylesheet start -->
    @include('backEnd.layouts.includes.stylesheet')
    <!-- stylesheet end -->
    </head>
    <body class="bg-white">
    <div class="d-flex align-items-center justify-content-center text-center h-100vh" style="background-image:url('backEnd/image/unnamed.jpg');">
        <div class="form-wrapper m-auto">
            <div class="form-container my-4">
                <div class="register-logo text-center mb-4">
                   
                </div>
                <div class="panel">
                    <div class="panel-header text-center mb-3">
                        <img src="{{ url('backEnd/image/green-check.png')}}" style="height:100px;" alt="">
                        <h2><b>Thank You For Confirm!</b></h2>
                       
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
 <!--/.main content-->

<!-- js bar start-->
@include('backEnd.layouts.includes.js')
<!-- js bar end -->
</body>
</html>
