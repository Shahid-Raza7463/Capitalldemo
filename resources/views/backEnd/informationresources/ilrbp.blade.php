

@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">
                   
						<div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Income from Business & Profession</h6>
                        </div>
						<div class="col-md-5">
						</div>
						<div class="col-md-1">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"><a href="{{ url()->previous() }}" >Back <i class="fa fa-reply"></i></a></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                 
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Name of the Business / Profession
                                        </label>
                                   <input readonly type="text" name="nameofthebusiness" value="{{ $personals->nameofthebusiness ?? ''}}" class="form-control"
                                        placeholder="Enter Name of the Business / Profession">
                                       <input readonly type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                                        placeholder="Enter Tenant Name ">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Nature of Business / Profession
                                        </label>
                                   <input readonly type="text" name="natureofthebusiness" value="{{ $personals->natureofthebusiness ?? ''}}" class="form-control"
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
                                               <input readonly type="text" name="If_company_is_covered"
                                                    value="{{ $personals->If_company_is_covered ?? ''}}" class="form-control"
                                                    placeholder="Enter ur details">
                                            </div>
                                            <div class="col-sm-6">
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
                                               <input readonly type="text" name="If_company_is_not_covered"
                                                    value="{{ $personals->If_company_is_not_covered ?? ''}}" class="form-control"
                                                    placeholder="Enter ur details">
                                            </div>
                                            <div class="col-sm-6">
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
                                               <input readonly type="text" name="Books_of_accounts"
                                                    value="{{ $personals->Books_of_accounts ?? ''}}" class="form-control"
                                                    placeholder="Enter ur details">
                                            </div>
                                            <div class="col-sm-6">
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
                                               <input readonly type="text" name="other"
                                                    value="{{ $personals->other ?? ''}}" class="form-control"
                                                    placeholder="Enter Any other details">
                                            </div>
                                            <div class="col-sm-6">
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
                      


                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
@endsection
                      

