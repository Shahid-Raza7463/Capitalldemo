
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
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Details</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Income From Salary List</small>
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
                            <th>Name of the Employer</th>
                            <th>TAN of employer</th>
                           
                            <th>Salary Income</th>
                            <th>Employer's Address </th>
							 <th>Any Other Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrsalarys as $ilrsalary)
                        <tr>
                            <td><a style="color: #37A000" id="editCompany" 
                                title="edit details" data-toggle="modal" data-id="{{ $ilrsalary->id }}"
                                data-target="#exampleModal13">{{$ilrsalary->nameoftheemployee ??''}}</a></td>
                            <td>{{$ilrsalary->tanoftheemployee }}</td>
                           
                            <td><span><b>Salary :</b></span>{{ $ilrsalary->salaryincome }}<br>
                            <span><b>Attachment :</b><a href="{{url('backEnd/image/ilrsalary/'.$ilrsalary->salaryincomefile)}}">
                                {{$ilrsalary->salaryincomefile }}</a></span></td>
                            <td>{{$ilrsalary->employeeaddress }}</td>
							 <td><span><b>Details :</b></span>{{ $ilrsalary->anyotherdetail }}<br><span>
                                <b>Attachment : </b><a href="{{url('backEnd/image/anyotherdetail/'.$ilrsalary->anyotherdetailfile)}}">
                                {{$ilrsalary->anyotherdetailfile }}</a></span>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('client/ilrsalary/store')}}"
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Name of the Employer </label>
                                    <input type="text" name="nameoftheemployee"  class="form-control"
                                        placeholder="Enter Name of the Employer">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">TAN of Employer</label>
                                    <input type="text" name="tanoftheemployee" class="form-control"
                                        placeholder="Enter TAN of Employer">
                                    <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                                        placeholder="Enter Account No">
                                </div>
                            </div>
                        </div>
                       
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Salary Income </label>
                                  
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="salaryincome" value="{{ $personals->anyotherdetail ?? ''}}"
                                                    class="form-control" placeholder="Enter Salary Income">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="file" name="salaryincomefile"
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
                                    <label class="font-weight-600">Employer's Address</label>
                                    <textarea rows="4" name="employeeaddress" value="" class="form-control"
                                    placeholder="Enter Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                               
                                    <label class="font-weight-600">Any Other Details</label>
                                    
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="anyotherdetail" value="{{ $personals->anyotherdetail ?? ''}}"
                                                class="form-control" placeholder="Enter Any Other Details">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="anyotherdetailfile"
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
        <div class="modal fade" id="exampleModal13" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('client/ilrsalary/update')}}"
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Name of the Employer </label>
                                    <input type="text" id="nameoftheemployee" name="nameoftheemployee"  class="form-control"
                                        placeholder="Enter Name of the Employer">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">TAN of Employer</label>
                                    <input type="text" id="tanoftheemployee" name="tanoftheemployee" class="form-control"
                                        placeholder="Enter TAN of Employer">
                                    <input type="text" id="id" hidden name="id" class="form-control"
                                        placeholder="Enter Account No">
                                </div>
                            </div>
                        </div>
                       
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Salary Income </label>
                                  
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" id="salaryincome" name="salaryincome" value="{{ $personals->anyotherdetail ?? ''}}"
                                                    class="form-control" placeholder="Enter Salary Income">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="file" name="salaryincomefile"
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
                                    <label class="font-weight-600">Employer's Address</label>
                                    <textarea rows="4" id="employeeaddress" name="employeeaddress" value="" class="form-control"
                                    placeholder="Enter Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                               
                                    <label class="font-weight-600">Any Other Details</label>
                                    
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" id="anyotherdetail" name="anyotherdetail" value="{{ $personals->anyotherdetail ?? ''}}"
                                                class="form-control" placeholder="Enter Any Other Details">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="anyotherdetailfile"
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

                url: "{{ url('client/ilrsalary/edit') }}",
                data: "id=" + id,
                success : function(response){
                    $("#id").val(response.id);
					$("#nameoftheemployee").val(response.nameoftheemployee);
					$("#salaryincome").val(response.salaryincome);
					$("#tanoftheemployee").val(response.tanoftheemployee);
					$("#employeeaddress").val(response.employeeaddress);
					$("#anyotherdetail").val(response.anyotherdetail);
        },
                error: function () {

                },
            });
        });
    });

</script>                                          

                                   

