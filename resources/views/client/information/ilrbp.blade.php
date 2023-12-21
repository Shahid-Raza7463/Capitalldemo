
@extends('client.layouts.layout') @section('client_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">
                   
                        <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Add Income from Business &
                                Profession</h6>
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-1">
                             <a data-toggle="modal" data-target="#exampleModal12" style="color:white;">Action</a>
                        </div>
                        <div class="col-md-1">

                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"><a
                                    href="{{ url('client/informationlist/'.$folderid->parent_id) }}">Back <i class="fa fa-reply"></i></a></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
					    @if(empty($personals->type))
                    <form method="post" action="{{ url('client/ilrbp/store')}}" enctype="multipart/form-data">
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Name of the Business / Profession
                                        </label>
                                    <input type="text" required name="nameofthebusiness" value="{{ $personals->nameofthebusiness ?? ''}}" class="form-control"
                                        placeholder="Enter Name of the Business / Profession">
                                        <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                                        placeholder="Enter Tenant Name ">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Nature of Business / Profession
                                        </label>
                                    <input type="text" name="natureofthebusiness" value="{{ $personals->natureofthebusiness ?? ''}}" class="form-control"
                                        placeholder="Enter Nature of Business / Profession">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">If covered under section 44AD/44ADA/44AE of Income Tax Act, 1961. Provide income details.

                                        </label>
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="If_company_is_covered"
                                                    value="{{ $personals->If_company_is_covered ?? ''}}" class="form-control"
                                                    placeholder="Enter ur details">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="If_company_is_coveredfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
											<div class="col-sm-3">
                                                @if(!empty($personals->If_company_is_coveredfile))
                                                <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->If_company_is_coveredfile ??'')}}" target="blank" data-toggle="tooltip"
                                            title="{{ $personals->If_company_is_coveredfile ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                                </div>
                                                @endif
   
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">If not covered under section 44AD/44ADA/44AE of Income Tax Act, 1961 and books of accounts not maintained, provide income and expenses details

                                        </label>
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="If_company_is_not_covered"
                                                    value="{{ $personals->If_company_is_not_covered ?? ''}}" class="form-control"
                                                    placeholder="Enter ur details">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="If_company_is_not_coveredfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
											 <div class="col-sm-3">
                                                @if(!empty($personals->If_company_is_not_coveredfile))
                                                <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->If_company_is_not_coveredfile ??'')}}" target="blank" data-toggle="tooltip"
                                            title="{{ $personals->If_company_is_not_coveredfile ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">If Books of accounts are maintained, provide books of account.
                                        </label>
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="Books_of_accounts"
                                                    value="{{ $personals->Books_of_accounts ?? ''}}" class="form-control"
                                                    placeholder="Enter ur details">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="Books_of_accountsfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
											<div class="col-sm-3">
                                                @if(!empty($personals->Books_of_accountsfile))
                                                <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->Books_of_accountsfile ??'')}}" target="blank" data-toggle="tooltip"
                                            title="{{ $personals->Books_of_accountsfile ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                                </div>
                                                @endif
   
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Any other details
                                        </label>
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="other"
                                                    value="{{ $personals->other ?? ''}}" class="form-control"
                                                    placeholder="Enter Any other details">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="otherfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
											<div class="col-sm-3">
                                              @if(!empty($personals->otherfile))
    <div class="col-sm-6">
<a href="{{ url('backEnd/image/ilrbp/'.$personals->otherfile ??'')}}" target="blank" data-toggle="tooltip"
title="{{ $personals->otherfile ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
    </div>
    @endif
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                                  
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->


<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('client/ilrbp/store')}}" enctype="multipart/form-data">

                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Action</h5>

                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <select name="type" class="form-control">
                        <!--placeholder-->
                        <option value="0">Applicable</option>
                        <option value="1">Not Applicable</option>

                    </select>
                    <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                        placeholder="Enter Tenant Name ">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
            </form>
 @else
                    <h5 style="text-align: center"><span>Not Applicable</span></h5>

                  @endif
        </div>
    </div>
</div>
@endsection
                      

