
@extends('backEnd.layouts.layout') @section('backEnd_content')<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    {{-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Bank Details</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav> --}}
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Bank Details</small>
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
                            <th>Other Detail</th>
                            <th>Bank Statement</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrbanks as $ilrbank)
                        <tr>
                            <td>{{$ilrbank->bank_name ??''}}</td>
                            <td>{{$ilrbank->accountno }}</td>
                            <td>{{$ilrbank->type }}</td>
                            <td>{{$ilrbank->ifsc }}</td>
                            <td>{{$ilrbank->otherdetail }}</td>
                            <td><a href="{{url('backEnd/image/ilrbank/'.$ilrbank->bankstatement)}}">{{$ilrbank->bankstatement }}</a></td>
                            <td>{{$ilrbank->address }}</td>
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Bank Name <span class="tx-danger">*</span></label>
                                    <input type="text" name="bank_name"  class="form-control"
                                        placeholder="Enter Bank Name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Account No <span class="tx-danger">*</span></label>
                                    <input type="text" name="accountno" class="form-control"
                                        placeholder="Enter Account No">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">IFSC <span class="tx-danger">*</span></label>
                                    <input type="text" name="ifsc"  class="form-control"
                                        placeholder="Enter IFSC">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Other Detail <span class="tx-danger">*</span></label>
                                    <input type="text" name="otherdetail" class="form-control"
                                        placeholder="Enter Other Detail">
                                </div>
                            </div>
                        </div> 
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Type <span class="tx-danger">*</span></label>
                                    <select name="type" class="form-control">
                                        <!--placeholder-->
                                     
                                        <option value="">Please Select One</option>
                                        <option value="0">Current</option>
                                        <option value="1">Saving</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Bank Statement <span class="tx-danger">*</span></label>
                                    <input type="file" name="bankstatement" class="form-control"
                                        placeholder="Enter Bank Statement">
                                </div>
                            </div>
                        </div> 
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Enter Address <span class="tx-danger">*</span></label>
                                    <textarea rows="4" name="address" value="" class="form-control"
                                        placeholder="Enter Address"></textarea>
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
                                   

