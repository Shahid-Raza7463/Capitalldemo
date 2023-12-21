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
                          <h6 style="color:white" class="fs-17 font-weight-600 mb-0">Add Conveyance</h6>
                       </div>
                   </div>
               </div>
               <div class="card-body">
                   <form method="post" action="{{ route('outstationconveyance.store')}}" enctype="multipart/form-data">
                       @csrf
                 @component('backEnd.components.alert')

                 @endcomponent
                       @include('backEnd.outstationconveyance.form')
                   </form>
                  
                   <hr class="my-4">

               </div>
           </div>
       </div>
   </div>
</div>
<!--/.body content-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
       var maxField = 10; //Input fields increment limitation
       var addButton = $('.add_buttonn'); //Add button selector
       var wrapper = $('.field_wrapper'); //Input field wrapper
       var fieldHTML = '<div class="row row-sm "><div class="col-6"><div class="form-group"><label class="font-weight-600">Name</label><select class="language form-control" name="teammember_id[]" id="key"><option>Please Select One</option>@foreach($teammember as $teammemberData)<option value="{{$teammemberData->id}}" @if(!empty($store->financial) && $store->financial==$teammemberData->id) selected @endif>  {{ $teammemberData->team_member }} ( {{$teammemberData->role->rolename}} )</option>@endforeach</select></div></div><div class="col-5"><div class="form-group"><label class="font-weight-600">Amount *</label> <input type="number" value="{{ $outstationconveyance->amount ?? ''}}" class="form-control key" name="amount[]" id="key" placeholder="Enter Amount"></div></div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}" /></a></div></div>'; //New input field html 
       var x = 1; //Initial field counter is 1
       
      

       //Once add button is clicked
       $(addButton).click(function(){
           //Check maximum number of input fields
           if(x < maxField){ 
               x++; //Increment field counter
               $(wrapper).append(fieldHTML); //Add field html
           }
       });
       
       //Once remove button is clicked
       $(wrapper).on('click', '.remove_button', function(e){
           e.preventDefault();
           $(this).parent('div').remove(); //Remove field html
           x--; //Decrement field counter
       });
   });
   </script>
    </script>
   
    <script>
       $(function(){
          $('#client').on('change',function(){
              var cid =$(this).val();
          // alert(category_id);
           $.ajax({
               type: "get",
               url: "{{ url('outstationconveyance/create') }}",
               data: "cid="+cid,
               success : function(res){
                   $('#conveyance').html(res);
               },
               error : function(){
               },
           });
          });
        }); 
    </script>
     <script>
       $(function(){
          $('#conveyance').on('change',function(){
              var name = $('#conveyance').val();
          //    alert(name);
          if(name=='Outstation Conveyance')
          {
             
              document.getElementById('outstation').style.display = 'block'; 
              document.getElementById('outstationn').style.display = 'block'; 
              document.getElementById('outstationnn').style.display = 'block'; 
              document.getElementById('local').style.display = 'none';
              document.getElementById('locals').style.display = 'none';
			     document.getElementById("attachment").required = true;
          }
          if(name=='Local Conveyance')
          {
                document.getElementById("Travelsupportingfile").required = true;
			  document.getElementById("Recoverable").required = true;
			  
              document.getElementById('local').style.display = 'block'; 
              document.getElementById('locals').style.display = 'block'; 
              document.getElementById('outstation').style.display = 'none';
              document.getElementById('outstationn').style.display = 'none'; 
              document.getElementById('outstationnn').style.display = 'none'; 
          }
      
         
          })
        })
    </script>
     <script>
       $(function(){
          $('#conveyancenongenerateconveyance').on('change',function(){
              var name = $('#conveyancenongenerateconveyance').val();
          //    alert(name);
          if(name=='Outstation Conveyance')
          {
             
              document.getElementById('outstation').style.display = 'block'; 
              document.getElementById('outstationn').style.display = 'block'; 
              document.getElementById('outstationnn').style.display = 'block'; 
              document.getElementById('local').style.display = 'none';
              document.getElementById('locals').style.display = 'none';
			  document.getElementById("attachment").required = true;
          }
          if(name=='Local Conveyance')
          {
               document.getElementById("Travelsupportingfile").required = true;
			  document.getElementById("Recoverable").required = true;
              document.getElementById('bill').style.display = 'none'; 
          //    document.getElementById('Supporting').style.display = 'none'; 
            //  document.getElementById('Remarks').style.display = 'none'; 
              document.getElementById('localadvacne').style.display = 'none'; 
              document.getElementById('localadvacneheading').style.display = 'none'; 
              document.getElementById('local').style.display = 'block'; 
              document.getElementById('locals').style.display = 'block'; 
              document.getElementById('outstation').style.display = 'none';
              document.getElementById('outstationn').style.display = 'none'; 
              document.getElementById('outstationnn').style.display = 'none'; 
          }
      
         
          })
        })
    </script>
@endsection


