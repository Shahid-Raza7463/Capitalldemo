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
                          <h6 style="color:white" class="fs-17 font-weight-600 mb-0">Add Material</h6>
                       </div>
                   </div>
               </div>
               <div class="card-body">
                   <form method="post" action="{{ route('material.store')}}" enctype="multipart/form-data">
                       @csrf
                 @component('backEnd.components.alert')

                 @endcomponent
                       @include('backEnd.material.form')
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
      $("#In").show();
      document.getElementById("In").required = true;
       $("#Out").hide();	  
    }
    
    else if ( this.value == '1')
    {
      $("#Out").show();
		  document.getElementById("Out").required = true;
      $("#In").hide();
    }
    else
    {
      $("#In").hide();	 
       $("#Out").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#itemtype').on('change', function() {
    if ( this.value == '0')
    {
      $("#rentable").show();
      document.getElementById("rentable").required = true;
       $("#non-rentable").hide();	  
    }
    
    else if ( this.value == '1')
    {
      // $("#Out").show();
		  // document.getElementById("Out").required = true;
      $("#non-rentable").hide();
      $("#rentable").hide();
    }
    else
    {
      $("#rentable").hide();	 
       $("#non-rentable").hide();
    }
  });
});
</script>

@endsection


