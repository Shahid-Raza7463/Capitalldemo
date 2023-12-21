 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
   <div class="row">
       <div class="col-md-12 col-lg-12">
           <div class="card mb-4">
               <div class="card-header" style="background:#37A000">
                   <div class="d-flex justify-content-between align-items-center">
                       <div>
                          <h6 style="color:white" class="fs-17 font-weight-600 mb-0">Add Correspondence</h6>
                       </div>
                   </div>
               </div>
               <div class="card-body">
                   <form method="post" action="{{ route('courierinout.store')}}" enctype="multipart/form-data">
                       @csrf
                 @component('backEnd.components.alert')

                 @endcomponent
                       @include('backEnd.courierinout.form')
                   </form>
                  
                   <hr class="my-4">

               </div>
           </div>
       </div>
   </div>
</div>
<!--/.body content-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
  $('#type').on('change', function() {
    if ( this.value == '0')
    {
      $("#sender").show();
      document.getElementById("sender").required = true;
       $("#receiver").hide();	  
    }
    
    else if ( this.value == '1')
    {
      $("#receiver").show();
		  document.getElementById("receiver").required = true;
      $("#sender").hide();
    }
    else
    {
      $("#sender").hide();	 
       $("#receiver").hide();
    }
  });
});
</script>

@endsection


