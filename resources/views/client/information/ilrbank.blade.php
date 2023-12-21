
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
                <small>Detail of Banks</small>
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
                            <th>Bank Name</th>
                            <th>Account No</th>
                            <th>Type</th>
                            <th>IFSC</th>
                            <th>Address</th>
                            <th>Bank Statement</th>
                           
							 <th>Other Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrbanks as $ilrbank)
                        <tr>
                            <td> <a style="color: #37A000" id="editCompany" 
                                title="edit bank details" data-toggle="modal" data-id="{{ $ilrbank->id }}"
                                data-target="#exampleModal12">{{$ilrbank->bank_name ??''}}</a></td>
                            <td>{{$ilrbank->accountno }}</td>
                            <td>{{$ilrbank->type }}</td>
                            <td>{{$ilrbank->ifsc }}</td>
							<td>{{$ilrbank->address }}</td>
                           
                            <td><a href="{{url('backEnd/image/ilrbank/'.$ilrbank->bankstatement)}}">{{$ilrbank->bankstatement }}</a></td>
                             <td>{{$ilrbank->otherdetail }}</td>
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
                     <form id="detailsForm" method="post" action="{{ url('client/ilrbank/store')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Bank Details</h5>
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
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Bank Name </label>
                                    <input type="text" name="bank_name"  class="form-control"
                                        placeholder="Enter Bank Name">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Account No </label>
                                    <input type="text" name="accountno" class="form-control"
                                        placeholder="Enter Account No">
                                    <input type="text" value="{{ $id }}" hidden name="informationresource_id" class="form-control"
                                        placeholder="Enter Account No">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">IFSC </label>
                                    <input type="text" name="ifsc"  class="form-control"
                                        placeholder="Enter IFSC">
                                </div>
                            </div>
                           
                        </div> 
                        <div class="row row-sm">
                         
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Type </label>
                                    <select name="type" class="form-control">
                                        <!--placeholder-->
                                     
                                        <option value="">Please Select One</option>
                                        <option value="Current A/C">Current A/C</option>
                                        <option value="Saving A/C">Saving A/C</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Bank Statement </label>
                                    <input type="file" name="bankstatement" class="form-control"
                                        placeholder="Enter Bank Statement">
                                </div>
                            </div>
                        </div> 
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Enter Address </label>
                                    <textarea rows="4" name="address" value="" class="form-control"
                                        placeholder="Enter Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Other Details </label>
                                <input type="text" name="otherdetail" class="form-control"
                                    placeholder="Enter Other Details">
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
   <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('client/ilrbank/update')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Edit Bank Details</h5>
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
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Bank Name </label>
                                    <input type="text" id="bank_name" name="bank_name"  class="form-control"
                                        placeholder="Enter Bank Name">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Account No </label>
                                    <input type="text" id="accountno" name="accountno" class="form-control"
                                        placeholder="Enter Account No">
                                    <input type="text" id="id" hidden name="id" class="form-control"
                                        placeholder="Enter Account No">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">IFSC </label>
                                    <input type="text" id="ifsc" name="ifsc"  class="form-control"
                                        placeholder="Enter IFSC">
                                </div>
                            </div>
                           
                        </div> 
                        <div class="row row-sm">
                         
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Type </label>
                                    <select name="type" class="form-control">
                                        <!--placeholder-->
                                     
                                        <option value="">Please Select One</option>
                                        <option value="Current A/C">Current A/C</option>
                                        <option value="Saving A/C">Saving A/C</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Bank Statement </label>
                                    <input type="file" name="bankstatement" class="form-control"
                                        placeholder="Enter Bank Statement">
                                </div>
                            </div>
                        </div> 
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Enter Address </label>
                                    <textarea rows="4" id="address" name="address" value="" class="form-control"
                                        placeholder="Enter Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Other Details </label>
                                <input type="text" id="otherdetail" name="otherdetail" class="form-control"
                                    placeholder="Enter Other Details">
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

                url: "{{ url('client/ilrbank/edit') }}",
                data: "id=" + id,
                success : function(response){
                    $("#id").val(response.id);
					$("#accountno").val(response.accountno);
					$("#address").val(response.address);
					$("#bank_name").val(response.bank_name);
					$("#ifsc").val(response.ifsc);
					$("#otherdetail").val(response.otherdetail);
        },
                error: function () {

                },
            });
        });
    });

</script>                     

                                   

