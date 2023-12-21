<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Bootstrap 4 client &amp; Dashboard Template">
        <meta name="author" content="Bdtask">
        <title>K.G.Somani</title>
        
         <!-- stylesheet start -->
    @include('client.layouts.includes.stylesheet')
    <!-- stylesheet end -->
    </head>
    <body class="fixed">
        <!-- Page Loader 
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
         #END# Page Loader -->
        <div class="wrapper">
             <!-- leftsidebar start -->
 @include('client.layouts.includes.leftsidebar')
 <!-- leftsidebar end -->

          
            <!-- Page Content  -->
            <div class="content-wrapper">
                <div class="main-content">
   <!-- header start -->
   @include('client.layouts.includes.header')
   <!-- header end -->

   

                   <!-- Main Content start-->
    @yield('client_content')
    <!-- Main Content end-->


                </div><!--/.main content-->
              <!-- footer start -->
     @include('client.layouts.includes.footer')
     <!-- footer end -->
            </div><!--/.wrapper-->
        </div>
         <!-- js bar start-->
    @include('client.layouts.includes.js')
    <!-- js bar end -->
    </body>
</html>