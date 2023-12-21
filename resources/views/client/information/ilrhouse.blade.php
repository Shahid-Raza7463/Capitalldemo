
@extends('client.layouts.layout') @section('client_content')
<style>
    a{
        cursor: pointer;
    }
</style>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('client/informationlist/'.$folderid->parent_id) }}" >Back <i class="fa fa-reply"></i></a></li>
            <li class="breadcrumb-item"><a data-toggle="modal" data-target=".bd-example-modal-lg">Add Details</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Income From House Property</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
    
        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent   
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>House Type</th>
                            <th>Tenant Name</th>
                            <th>Tenant Adhaar</th>
                            <th>Tenant PAN</th>
                            <th>Address of House Property</th>
                            <th>Rent Received During The Year</th>
                            <th>Per Month Rent Amount</th>
                            <th>Period of Vacancy</th>
                            <th>Municipal/House Tax paid</th>
                            <th>Payment of Interest on Housing Loan</th>
                            <th>Ownership Share</th>
                            <th>Any other details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrhouses as $ilrhouse)
                        <tr>
                              <td> <a style="color: #37A000" id="editCompany" 
                                title="edit house details" data-toggle="modal" data-target=".cd-example-modal-lg" data-id="{{ $ilrhouse->id }}"
                         >{{$ilrhouse->house_type ??''}}</a></td>
                            <td>{{$ilrhouse->tenant_name }}</td>
                            <td>{{$ilrhouse->tenant_adhar }}</td>
                            <td>{{$ilrhouse->tenant_pan }}</td>
                            <td>{{$ilrhouse->address_of_house_property }}</td>
                            <td><span><b>Details</b> : </span>{{ $ilrhouse->rent_received }}<br>
                            <span><b>Attachment</b> : </span><a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->rent_receivedfile)}}">{{$ilrhouse->rent_receivedfile }}</a></td>
                            <td><span><b>Details</b> : </span>{{ $ilrhouse->rent_amount }}<br>
                                <span><b>Attachment</b> : </span><a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->rent_amountfile)}}">
                                    {{$ilrhouse->rent_amountfile }}</a></td>
                            <td>{{$ilrhouse->period_vacancy }}</td>
                            <td><span><b>Details</b> : </span>{{ $ilrhouse->tax_paid }}<br>
                                <span><b>Attachment</b> : </span>  <a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->tax_paid)}}">
                                    {{$ilrhouse->tax_paidfile }}</a></td>
                            <td><span><b>Details</b> : </span>{{ $ilrhouse->payment }}<br>
                                <span><b>Attachment</b> : </span>  <a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->paymentfile)}}">{{$ilrhouse->paymentfile }}</a></td>
                            <td>{{$ilrhouse->ownership }}</td>
                            <td><span><b>Details</b> : </span>{{ $ilrhouse->anyotherdetails }}<br>
                                <span><b>Attachment</b> : </span>   <a href="{{url('backEnd/image/ilrhouse/'.$ilrhouse->anyotherdetailsfile)}}">{{$ilrhouse->anyotherdetailsfile }}</a></td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('client/ilrhouse/store')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Details</h5>
                        <div >
                            <ul>
                        @foreach ($errors->all() as $e)
                          <li style="color:red;">{{$e}}</li>
                        @endforeach
                    </ul>
                    </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">House Type </label>
                                    <select name="house_type" class="form-control">
                                        <!--placeholder-->
                                     
                                        <option value="">Please Select One</option>
                                        <option value="Rented">Rented</option>
                                        <option value="Self Occupied">Self Occupied</option>
                                        <option value="Deemed Let Out">Deemed Let Out</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Tenant Name  </label>
                                    <input type="text" name="tenant_name" class="form-control"
                                        placeholder="Enter Tenant Name">
                                    <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                                        placeholder="Enter Tenant Name ">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Tenant Adhaar </label>
                                    <input type="text" name="tenant_adhar"  class="form-control"
                                        placeholder="Enter Tenant Adhaar ">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Tenant PAN </label>
                                    <input type="text" name="tenant_pan" class="form-control"
                                        placeholder="Enter Tenant PAN">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Address of House Property </label>
                                    <input type="text" name="address_of_house_property" class="form-control"
                                        placeholder="Enter Address of House Property">
                                </div>
                            </div>
                           
                        </div> 
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Rent Received During The Year  </label>
                                 
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="rent_received" value="{{ $personals->anyotherdetail ?? ''}}"
                                                    class="form-control" placeholder="Enter Rent Received During The Year">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="file" name="rent_receivedfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Per Month Rent Amount  </label>
                                 
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="rent_amount" value="{{ $personals->anyotherdetail ?? ''}}"
                                                    class="form-control" placeholder="Enter Per Month Rent Amount">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="file" name="rent_amountfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                           
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Period of Vacancy  </label>
                                    <input type="text" name="period_vacancy" class="form-control"
                                        placeholder="Enter Period of Vacancy">
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Ownership Share (in %) </label>
                                    <input type="text" name="ownership" class="form-control"
                                        placeholder="Enter Ownership Share">
                                </div>
                            </div>
                        </div> 
                            <div class="row row-sm">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Municipal/House Tax Paid (Receipt) </label>
                                     
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <input type="text" name="tax_paid" value="{{ $personals->tax_paid ?? ''}}"
                                                        class="form-control" placeholder="Enter Municipal/House Tax Paid">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="file" name="tax_paidfile"
                                                        value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                        placeholder="Enter Interest from Savings Bank a/c
        ">
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                              
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Payment of Interest on Housing Loan  (Provide Interest Certificate) </label>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <input type="text" name="payment" value="{{ $personals->anyotherdetail ?? ''}}"
                                                        class="form-control" placeholder="Enter Payment of Interest on Housing Loan">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="file" name="paymentfile"
                                                        value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                        placeholder="Enter Interest from Savings Bank a/c
        ">
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Any Other Details/Information</label>
                                       
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <input type="text" name="anyotherdetails" value="{{ $personals->anyotherdetail ?? ''}}"
                                                        class="form-control" placeholder="Enter Any Other Details/Information">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="file" name="anyotherdetailsfile"
                                                        value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                        placeholder="Enter Interest from Savings Bank a/c
        ">
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div> 
                     </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
<!-- Modal -->
        <div class="modal fade cd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModal12" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('client/ilrhouse/update')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Edit Details</h5>
                        <div >
                            <ul>
                        @foreach ($errors->all() as $e)
                          <li style="color:red;">{{$e}}</li>
                        @endforeach
                    </ul>
                    </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">House Type </label>
                                    <select name="house_type" class="form-control">
                                        <!--placeholder-->
                                     
                                        <option value="">Please Select One</option>
                                        <option value="Rented">Rented</option>
                                        <option value="Self Occupied">Self Occupied</option>
                                        <option value="Deemed Let Out">Deemed Let Out</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Tenant Name  </label>
                                    <input type="text" id="tenant_name" name="tenant_name" class="form-control"
                                        placeholder="Enter Tenant Name">
                                    <input type="text" hidden id="id" name="id" class="form-control"
                                        placeholder="Enter Tenant Name ">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Tenant Adhaar </label>
                                    <input type="text" id="tenant_adhar" name="tenant_adhar"  class="form-control"
                                        placeholder="Enter Tenant Adhaar ">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Tenant PAN </label>
                                    <input type="text" id="tenant_pan" name="tenant_pan" class="form-control"
                                        placeholder="Enter Tenant PAN">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Address of House Property </label>
                                    <input type="text" id="address_of_house_property" name="address_of_house_property" class="form-control"
                                        placeholder="Enter Address of House Property">
                                </div>
                            </div>
                           
                        </div> 
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Rent Received During The Year  </label>
                                 
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" id="rent_received" name="rent_received" value="{{ $personals->anyotherdetail ?? ''}}"
                                                    class="form-control" placeholder="Enter Rent Received During The Year">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="file" name="rent_receivedfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Per Month Rent Amount  </label>
                                 
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" id="rent_amount" name="rent_amount" value="{{ $personals->anyotherdetail ?? ''}}"
                                                    class="form-control" placeholder="Enter Per Month Rent Amount">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="file" name="rent_amountfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                           
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Period of Vacancy  </label>
                                    <input type="text" id="period_vacancy" name="period_vacancy" class="form-control"
                                        placeholder="Enter Period of Vacancy">
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Ownership Share (in %) </label>
                                    <input type="text" id="ownership" name="ownership" class="form-control"
                                        placeholder="Enter Ownership Share">
                                </div>
                            </div>
                        </div> 
                            <div class="row row-sm">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Municipal/House Tax Paid (Receipt) </label>
                                     
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <input type="text" id="tax_paid" name="tax_paid" value="{{ $personals->tax_paid ?? ''}}"
                                                        class="form-control" placeholder="Enter Municipal/House Tax Paid">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="file" name="tax_paidfile"
                                                        value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                        placeholder="Enter Interest from Savings Bank a/c
        ">
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                              
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Payment of Interest on Housing Loan  (Provide Interest Certificate) </label>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <input type="text" id="payment" name="payment" value="{{ $personals->anyotherdetail ?? ''}}"
                                                        class="form-control" placeholder="Enter Payment of Interest on Housing Loan">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="file" name="paymentfile"
                                                        value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                        placeholder="Enter Interest from Savings Bank a/c
        ">
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Any Other Details/Information</label>
                                       
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <input type="text" id="anyotherdetails" name="anyotherdetails" value="{{ $personals->anyotherdetail ?? ''}}"
                                                        class="form-control" placeholder="Enter Any Other Details/Information">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="file" name="anyotherdetailsfile"
                                                        value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                        placeholder="Enter Interest from Savings Bank a/c
        ">
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div> 
                     </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
  $("#editors").html('');
 $("#contactemail").val('');
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('client/ilrhouse/edit') }}",
                data: "id=" + id,
                success : function(response){
                    $("#id").val(response.id);
					$("#tenant_name").val(response.tenant_name);
					$("#tenant_adhar").val(response.tenant_adhar);
					$("#tenant_pan").val(response.tenant_pan);
					$("#address_of_house_property").val(response.address_of_house_property);
					$("#rent_received").val(response.rent_received);
					$("#rent_amount").val(response.rent_amount);
					$("#period_vacancy").val(response.period_vacancy);
					$("#ownership").val(response.ownership);
					$("#tax_paid").val(response.tax_paid);
					$("#payment").val(response.payment);
					$("#anyotherdetails").val(response.anyotherdetails);
        },
                error: function () {

                },
            });
        });
    });

</script>                     

                    


                                   

