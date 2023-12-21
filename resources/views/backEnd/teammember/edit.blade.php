@extends('backEnd.layouts.layout') @section('backEnd_content')
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <h6 style="color:white;"  class="fs-17 font-weight-600 mb-0">Edit Team Member</h6>
						 </div>
						<div class="col-md-6">
							 @php
                                $reset = DB::table('users')->where('teammember_id',$teammember->id)->first();
                            @endphp
                            @if($reset != null)
                                
                           
							 <a style="float: right;" href="{{url('/resetpassword/'.$teammember->id)}}" class="btn btn-info-soft btn-sm">Reset Password<i class="fas fa-unlock-alt"></i></a>
                             @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('teammember.update', $teammember->id)}}"  enctype="multipart/form-data">
                        @method('PATCH') 
                        @csrf            
                        @component('backEnd.components.alert')

                        @endcomponent   
                    @include('backEnd.teammember.form')
                </form>
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->

@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
