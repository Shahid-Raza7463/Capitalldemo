@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"> Income from Other Sources</h6>
                        </div>
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-1">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"><a
                                    href="{{ url()->previous() }}">Back <i class="fa fa-reply"></i></a></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Interest from Savings Bank A/C </label>

                                <div class="row">

                                    <div class="col-sm-6">
                                        <input readonly type="text" name="interestfromsaving"
                                            value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                            placeholder="Enter Interest from Savings Bank A/C ">
                                    </div>
                                    <div class="col-sm-6">
                                        @if(!empty($personals->interestfromsavingfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->interestfromsavingfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->interestfromsavingfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                        </div>
                                        @endif
                                        <input readonly type="text" hidden value="{{ $id }}"
                                            name="informationresource_id" class="form-control"
                                            placeholder="Enter Tenant Name ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Interest from FDR
                                </label>

                                <div class="row">

                                    <div class="col-sm-6">
                                        <input readonly type="text" name="interestfromfdr"
                                            value="{{ $personals->interestfromfdr ?? ''}}" class="form-control"
                                            placeholder="Enter Interest from FDR">
                                    </div>
                                    <div class="col-sm-6">
                                        @if(!empty($personals->interestfromfdrfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->interestfromfdrfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->interestfromfdrfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
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
                                <label class="font-weight-600">Other Interest (Please Specify)
                                </label>

                                <div class="row">

                                    <div class="col-sm-6">
                                        <input readonly type="text" name="other" value="{{ $personals->other ?? ''}}"
                                            class="form-control" placeholder="Enter Other Interest">
                                    </div>
                                    <div class="col-sm-6">
                                        @if(!empty($personals->otherfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->otherfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->otherfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
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
                                <label class="font-weight-600">Dividend Income </label>

                                <div class="row">

                                    <div class="col-sm-6">
                                        <input readonly type="text" name="dividend"
                                            value="{{ $personals->dividend ?? ''}}" class="form-control"
                                            placeholder="Enter Dividend Income ">
                                    </div>
                                    <div class="col-sm-6">
                                        @if(!empty($personals->dividendfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->dividendfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->dividendfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
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
                                <label class="font-weight-600">Any Other Income Not Covered Above
                                </label>

                                <div class="row">

                                    <div class="col-sm-6">
                                        <input readonly type="text" name="anyother"
                                            value="{{ $personals->dividend ?? ''}}" class="form-control"
                                            placeholder="Enter Any Other Income Not Covered Above">
                                    </div>
                                    <div class="col-sm-6">
                                        @if(!empty($personals->anyotherfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->anyotherfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->anyotherfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
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
