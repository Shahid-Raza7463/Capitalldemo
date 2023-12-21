 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: white;" class="fs-17 font-weight-600 mb-0">Introduction Email -Preview/Edit</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('employeeonboarding/sendmail/'.$id)}}" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                  <div class="row row-sm">
                        <div class="col-12">
                                <div class="form-group">
                                    <input name="id" hidden value="{{$employeeonboarding->id}}">
                                    <input name="emp_id" hidden value="{{$id}}">
                                    <textarea rows="6" name="content" value="  " class="centered form-control" id="summernote"
                                placeholder="Enter Description" id="editors" style="height:500px;">
                            
                            
                                <p>Dear All,</p>
<br>
<center>
<img src="{{url('/backEnd/image/photograph/'.$employeeonboarding->photograph)}}" alt="profile Pic" height="200" width="200">
</center>
<br>
<p>
Please join us in welcoming {{ucwords(strtolower($employeeonboarding->name)) ??''}} who have joined us as  {{$employeeonboarding->designation ??''}}.</p>
<p>@php
$splitName = explode(' ', $employeeonboarding->name, 2); 

$first_name = $splitName[0];

@endphp
{{ucwords(strtolower($first_name)) ??''}} holds {{$employeeonboarding->degree ??''}}  in {{$employeeonboarding->Stream ??''}} from 
{{$employeeonboarding->university ??''}}, {{$employeeonboarding->location ??''}} . 
</p>
<p>
    @if($employeeonboarding->gender=="Female")
She
 @else 
 He 
 @endif has Total Work Experience of {{$employeeonboarding->exp_year ??''}} Years and {{$employeeonboarding->exp_month ??''}} months.</p>
<p> @if($employeeonboarding->gender=="Female")
She
 @else 
 He 
 @endif was working with {{$employeeonboarding->pre_org ??''}} as a {{$employeeonboarding->pre_des ??''}}. @if($employeeonboarding->gender=="Female")
She
 @else 
 He 
 @endif handled various 
assignments in {{$employeeonboarding->work_area ??''}} .</p>
<p> @if($employeeonboarding->gender=="Female")
She
 @else 
 He 
 @endif likes {{$employeeonboarding->hobbies ??''}}.  @if($employeeonboarding->gender=="Female")
Her
 @else 
 His 
 @endif email ID is {{$employeeonboarding->off_email ??''}} .

</p>
<p>Wishing  @if($employeeonboarding->gender=="Female")
Her
 @else 
 Him  
 @endif luck for all the assignments and a long and rewarding career at KGS. </p>
<br>
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
                                 


 
                            </textarea>                   
                        </div>
                            </div>
                    </div>
                    <div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Send Mail</button>
    <a class="btn btn-secondary" href="{{ url('employeeonboarding') }}">
        Back</a>

</div>

                    </form>
                   
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });

</script>

<script type="text/javascript">
    //jQuery.noConflict();
    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                jQuery('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    jQuery("#profile-img").change(function () {
        readURL(this);
    });

</script>
@endsection
