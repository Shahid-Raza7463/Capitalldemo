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
                            <h6 style="color: white;" class="fs-17 font-weight-600 mb-0">Article Onboarding Email -Preview</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('candidate/article/convert/'.$article->id)}}" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                  <div class="row row-sm">
                        <div class="col-12">
                                <div class="form-group">
                                    <input name="id" hidden value="{{$article->id}}">
                                    <input name="partner" hidden value="{{$partner_id}}">
                                    <input name="approval" hidden value="{{$approval}}">
                                    <input name="date_of_completion" hidden value="{{$date_of_completion}}">
                                    <input name="date_of_registration" hidden value="{{$date_of_registration}}">
                                    <input name="location" hidden value="{{$location}}">
                                    <textarea rows="6" name="content" value="" class="centered form-control" id="summernote"
                                placeholder="Enter Description" id="editors" style="height:800px;">
                            
                            
                                
<br>
<p>
Dear Team,
<br>    
<br>
Below are the details of New Joinee Article.
</p>

<p><br></p><table border="1" cellpadding="1" cellspacing="1" ><tbody><tr><td><b>Name of Joinee</b></td><td><b>Designation</b></td><td><b>Qualification</b></td>
<td><b>DOJ of Previous Organisation</b></td><td><b>DOL of Previous Organisation</b></td>
<td><b>Date of Joining</b></td><td><b>Date of Completion</b></td><td><b>Contact Number</b></td>
<td><b>Personal Email Id</b></td><td><b>CRO/NRO</b></td><td><b>Date of Registration</b></td>
<td><b>Partner</b></td><td><b>Partner Approval</b></td><td><b><p>Current&nbsp;</p><p>Location</p></b>
</td><td><b><p>Emergency</b></p><p><b>Contact</b></p></td><td><b>Passport Size Photograph</b></td></tr>
<tr><td>{{$article->name ??''}}<br></td><td>{{$article->designation ??''}}<br></td>
<td>{{$article->qualification ??''}} <br></td><td>
@if($previous==null) 
NA
@else   
    
@foreach($previous as $pre) {{$pre->date_of_joining ??''}}, @endforeach @endif
<br></td><td>
@if($previous==null) 
NA
@else   
@foreach($previous as $pre) {{$pre->date_of_leaving ??''}}, @endforeach @endif<br></td>
<td>{{$article->doj ??''}}<br>
</td><td>{{$date_of_completion ??''}}<br></td><td>{{$article->contactno ??''}}<br></td>
<td>{{$article->emailid ??''}}<br></td><td>{{$article->cro_nro_no ??''}}<br></td>
<td>{{$date_of_registration}}<br></td>
<td>{{$partner ??''}}<br></td><td>{{$approval ??''}}<br></td><td>{{$location ??''}}<br></td>
<td>{{$article->emergencycontactnumber ??''}}<br>
</td><td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$article->photograph, now()->addMinutes(30)) }}">
                                    {{ $article->photograph ??'Not Uploaded'}} </a></td></tr></tbody></table><p><br></p>
<p>
@Mohit Arora / @Amit Gaur- Please provide them an official Email ID and ID card, provide laptop as per the allocation.


</p>
<p>
@Admin KGS - For your records
<br>
@V K Verma – For your records
</p>
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
