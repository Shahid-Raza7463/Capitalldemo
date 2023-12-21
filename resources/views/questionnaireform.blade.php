<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center justify-content-center text-center"
    style="background-image:url('backEnd/image/unnamed.jpg'); height:550px; margin-top:-200px;">


    <div class="form-wrapper m-auto">
        <!-- <div>
                <img src="{{ url('backEnd/image/1108c10e.jpeg')}}" alt="">
            </div> -->
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <div style="background-color:white;">
            {{-- <img src="{{ url('backEnd/image/0fc4e385.png')}}" style="width:300px; margin-left:-30px;" alt=""> --}}
            {{-- <br><br>
            <h4 style="font-weight: 600;">CapITall</h4>
            <h6>Human resources  - Round one Questionnaire </h6> --}}
            <div class="card-header" style="background:#37A000">
                <div class="align-items-center">
                    <div>
                        <h4 style="color: white" style="font-weight: 600;">CapITall</h4>
                    </div>
                </div>
            </div>
            
            <div class="body-content" style="box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);background:#F4F4F5;">
                <h6>Human resources  - Round one Questionnaire </h6>
                <hr><br>
                <form method="POST" action="{{ url('questionnaireroundone/store') }}" enctype="multipart/form-data">
                    @csrf
                    @component('backEnd.components.alert')

                    @endcomponent


					<div class="row row-sm">
  <div class="col-6">
        <div class="form-group text-left">
            <label class="font-weight-600">Name <span style="color:red;">*</span> </label>
            <input type="text"  name="name" value="" class="form-control"
                placeholder="" required>       
          
        </div>
    </div>
  <div class="col-6">
        <div class="form-group text-left">
            <label class="font-weight-600">Email <span style="color:red;">*</span> </label>
            <input type="email"  name="email" value="" class="form-control"
                placeholder="" required>       
          
        </div>
    </div>
    </div>
					<div class="row row-sm">
  <div class="col-6">
        <div class="form-group text-left">
            <label class="font-weight-600">Phone <span style="color:red;">*</span> </label>
            <input type="tel"  name="phone" value="" class="form-control"
                placeholder="" required>       
          
        </div>
    </div>
						  <div class="col-6">
        <div class="form-group text-left">
            <label class="font-weight-600">Attachment </label>
            <input type="file"  name="file" class="form-control">       
          
        </div>
    </div>
    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group text-left">
                                <label class="font-weight-600">What do you know about our company’s services?<span
                                        style="color:red;">*</span> </label>
                                <textarea name="services"class="form-control" required> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group text-left">
                                <label class="font-weight-600">Describe a tough experience you had with a colleague or a
                                    manager and how you handled it.<span style="color:red;">*</span> </label>
                                <textarea type="text" name="experience" value="" class="form-control" placeholder=""
                                    required> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group text-left">
                                <label class="font-weight-600">How versatile are you working with software systems in
                                    HR? Which software you found effective and why ?<span
                                        style="color:red;">*</span></label>
                                <textarea type="text" name="systems" value="" class="form-control" placeholder=""
                                    required> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group text-left">
                                <label class="font-weight-600">How have you coped leading a hiring team? Describe a
                                    practical experience.<span style="color:red;">*</span></label>
                                <textarea type="text" name="leadings" value="" class="form-control" placeholder=""
                                    required> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group text-left">
                                <label class="font-weight-600">How have you handled cost reduction efforts as an HR
                                    employee?<span style="color:red;">*</span></label>
                                <textarea type="text" name="handled" value="" class="form-control" placeholder=""
                                    required> </textarea>
                            </div>
                        </div>
                    </div>
                    <br> <br>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

</div>

@endsection
