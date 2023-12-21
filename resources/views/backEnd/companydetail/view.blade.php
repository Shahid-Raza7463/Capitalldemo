@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('companydetail/create')}}">Add Company Detail</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>
                    List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
        @component('backEnd.components.alert')

        @endcomponent
        <div class="card-body">
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:530px;">
                <div class="card-body">
                    <fieldset  class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Company Name : </b></td>
                                    <td>{{ $company->company_name}}</td>
                                    <td><b>Address : </b></td>
                                    <td>{{ $company->address}}</td>
                                  

                                </tr>
                                <tr>
                                    <td><b>State : </b></td>
                                    <td>{{ $company->state}}</td>
                                    <td><b>City : </b></td>
                                    <td>{!! $company->city !!}</td>

                                </tr>
                               
                                <tr>
                                    <td><b>GST Number : </b></td>
                                    <td>{{ $company->gstno}}</td>
                                    <td><b>Company Email : </b></td>
                                    <td>{!! $company->company_email!!}</td>

                                </tr>
                                <tr>
                                    <td><b> Phone Number : </b></td>
                                    <td>{{ $company->phone_no}}</td>
                                    <td><b>Created By : </b></td>
                                    <td>{{$company->team_member ??''}}</td>
                      

                                </tr>
                                <tr>
                                    <td><b>  Updated By: </b></td>
                                    <td>{{ $company->updated_by}}</td>
                                    <td><b>Created At : </b></td>
                                  <td>{{date('F d,Y', strtotime($company->created_at))}}</td>

                                   

                                </tr>
                                <tr>
                                  
                                    <td><b>Updated_At: </b></td>
                                    <td>{{date('F d,Y', strtotime($company->updated_at))}}</td>
                                    <td><b> Company Logo : </b></td>
                                   <!-- <td>{{ $company->companylogo}}</td> -->
                                   <td><img src="{{asset('image/companylogo')}}/{{$company->companylogo}}" style="max-width:60px;"></td>
                                </tr>
                                <tr>
                                   
                                    <td><b>Pan Card Number: </b></td>
                                    <td>{!! $company->pancard_no!!}</td>
                                    <td><b> Website : </b></td>
                                    <td>{{ $company->website}}</td>

                                </tr>
                                <tr>
                                  
                                    <td><b>Bank Name: </b></td>
                                    <td>{!! $company->bankname!!}</td>
                                    <td><b> Account Name : </b></td>
                                    <td>{{ $company->accountname}}</td>

                                </tr>
                                <tr>
                                   
                                    <td><b>Account Type: </b></td>
                                    <td>{!! $company->accounttype!!}</td>
                                    <td><b> Account Number : </b></td>
                                    <td>{{ $company->accountnumber}}</td>
                                </tr>

                                <tr>
                                 
                                    <td><b>IFSC Code: </b></td>
                                    <td>{!! $company->ifsc_code!!}</td>
                                    <td><b>Bank Branch Address:</b></td>
                                <td>{{$company -> bankbranchaddress}}</td>

                            
                               
                                </tr>
                            

                            </tbody>
                           
                        </table>
                                       
                    </fieldset>
                        <div class="form-group">
                      
                                <a class="btn btn-secondary" href="{{ url('companydetail') }}">Back</a>
                            
                            </div>
                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>


@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    //jQuery.noConflict();
    /*function readURL(input) {
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
    }); */

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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