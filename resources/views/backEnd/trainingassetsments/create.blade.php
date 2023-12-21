 <!--Third party Styles(used by this page)--> 
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">


@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4" >
                <div class="card-header" style="background: #37A000">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Add Training Assessment Form</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('trainingassetsments.store')}}" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                        @include('backEnd.trainingassetsments.form')
                    </form>
                   
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_buttonn'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var x = 1; //Initial field counter is 1
        var fieldHTML = '<div class="row row-sm "><div class="col-2"><div class="form-group"><label class="font-weight-600">Name of Team / Member*</label><select class="language form-control" name="teammemberid[]" id="key'+ x +'"><option>Please Select One</option>@foreach($teammember as $teammemberData)<option value="{{$teammemberData->id}}" @if(!empty($store->financial) && $store->financial==$teammemberData->id) selected @endif>  {{ $teammemberData->team_member }} ( {{$teammemberData->role->rolename}} )</option>@endforeach</select></div></div><div class="col-4"><div class="form-group"><label class="font-weight-600">Please Specify Training Topic *</label> <input type="text" name="trainingtype[]" id="key'+ x +'" value="{{ $assignmentmapping->stdcost ?? ''}}" class=" form-control key" placeholder="Enter Training Type"></div></div>  <div class="col-3"><div class="form-group"><label class="font-weight-600">Select Topics for Soft Skills Training *</label><select required class="form-control " name="softskillstraining[]" ><option value="">Please Select One</option>@foreach($softskillstraining as $softskillstrainingData)<option value="{{$softskillstrainingData->id}}">{{ $softskillstrainingData->name }}</option>@endforeach</select></div></div><div class="col-2" ><div class="form-group"><label class="font-weight-600">Other Skills ( optional )</label><input type="text" id="key'+ x +'" name="other[]" class=" form-control key" placeholder="Enter Other Skills"></div></div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}" /></a></div></div>'; //New input field html 
     
       
//   var last_id = $('input[type="text"]:last').attr('id');
//   last_id++;
//   $('input[type="text"]:last').append('<input type="text" name="'+last_id+' id="'+last_id+'">');
//var a = document.getElementById.("key");
//alert(a);
document.getElementById('key').id = 'div2';
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
       <script>
        $(function(){
           $('#category').on('change',function(){
               var category_id =$(this).val();
    
            $.ajax({
                type: "GET",
                url: "{{ url('client/create') }}",
                data: "category_id="+category_id,
                success : function(res){
                
                    $('#subcategory_id').html(res);
    
                    
                },
                error : function(){
    
                },
            });
           });
         }); 
     </script>