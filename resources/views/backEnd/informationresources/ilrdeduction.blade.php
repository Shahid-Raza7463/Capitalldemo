@extends('backEnd.layouts.layout') @section('backEnd_content')
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Add Details of Deductions</h6>
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
                    <form method="post" action="{{ url('client/ilrdeduction/store')}}" enctype="multipart/form-data">
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">PPF Contribution ( Attach PPF Account Statement )
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="ppf" value="{{ $personals->ppf ?? ''}}"
                                                class="form-control" placeholder="Enter PPF Contribution">
                                            <input type="text" hidden value="{{ $id }}" name="informationresource_id"
                                                class="form-control" placeholder="Enter Tenant Name ">
                                        </div>
                                        <div class="col-sm-6">

                                            @if(!empty($personals->ppffile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->ppffile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->ppffile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
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
                                    <label class="font-weight-600">House loan repayment details ( Attach Loan Statement)
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="house_loan"
                                                value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                placeholder="Enter House loan repayment details">
                                        </div>
                                        <div class="col-sm-6">

                                            @if(!empty($personals->house_loanfile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->house_loanfile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->house_loanfile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
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
                                    <label class="font-weight-600">Insurance Premium Amounts ( Attach Premium Receipts)
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="insurance" value="{{ $personals->insurance ?? ''}}"
                                                class="form-control" placeholder="Enter Insurance Premium Amounts">
                                        </div>
                                        <div class="col-sm-6">

                                            @if(!empty($personals->insurancefile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->insurancefile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->insurancefile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
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
                                    <label class="font-weight-600">Investment in Mutual Fund ( Attach Statement )
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="mutual_fund"
                                                value="{{ $personals->insurance ?? ''}}" class="form-control"
                                                placeholder="Enter Investment in Mutual Fund">
                                        </div>
                                        <div class="col-sm-6">

                                            @if(!empty($personals->interestfromsaving))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->interestfromsaving ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->interestfromsaving ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
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
                                    <label class="font-weight-600">Children Education Fees ( Only tuition fees paid for
                                        two children , Attach school fees receipt)
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="children" value="{{ $personals->children ?? ''}}"
                                                class="form-control" placeholder="Enter Children Education Fees">
                                        </div>
                                        <div class="col-sm-6">

                                            @if(!empty($personals->childrenfile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->childrenfile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->childrenfile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
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
                                    <label class="font-weight-600">Investment in National Pension Scheme ( Attach
                                        receipt )

                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="investment" value="{{ $personals->children ?? ''}}"
                                                class="form-control"
                                                placeholder="Enter Investment in National Pension Scheme">
                                        </div>
                                        <div class="col-sm-6">
                                            @if(!empty($personals->investmentfile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->investmentfile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->investmentfile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
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
                                    <label class="font-weight-600"><b>Amount of Donation Under Section 80G (Attached
                                            Donation Receipt)</b>
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="amount" value="{{ $personals->amount ?? ''}}"
                                                class="form-control"
                                                placeholder="Enter Amount of Donation Under Section">
                                        </div>
                                        <div class="col-sm-6">
                                            @if(!empty($personals->amountfile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->amountfile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->amountfile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600"> Name of Donee
                                    </label>
                                    <input type="text" name="name_of_donee" value="{{ $personals->name_of_donee ?? ''}}"
                                        class="form-control"
                                        placeholder="Enter  Name of Donee                                        ">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">PAN of Donee
                                    </label>
                                    <input type="text" name="pan_of_donee" value="{{ $personals->pan_of_donee ?? ''}}"
                                        class="form-control" placeholder="Enter PAN of Donee">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Address of Donee
                                    </label>
                                    <input type="text" name="address_of_done"
                                        value="{{ $personals->address_of_done ?? ''}}" class="form-control"
                                        placeholder="Enter Address of Donee">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600"><b>Mediclaim Premium for health insurance and
                                            preventive health check-up (Attach receipt)
                                        </b>
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="Mediclaim" value="{{ $personals->Mediclaim ?? ''}}"
                                                class="form-control"
                                                placeholder="Enter Mediclaim Premium for health insurance and preventive health check-up">
                                        </div>
                                        <div class="col-sm-6">
                                            @if(!empty($personals->Mediclaimfile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->Mediclaimfile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->Mediclaimfile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
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
                                    <label class="font-weight-600"> Whether you and any of your family member(excluding
                                        parents) is a senior citizen?
                                    </label>
                                    <input type="text" name="citizen" value="{{ $personals->citizen ?? ''}}"
                                        class="form-control"
                                        placeholder="Enter  Whether you and any of your family member(excluding parents) is a senior citizen">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600"><b>Mediclaim Premium for health insurance and
                                            preventive health check-up for parents (Attach receipt)

                                        </b>
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="parents" value="{{ $personals->parents ?? ''}}"
                                                class="form-control"
                                                placeholder="Enter Mediclaim Premium for health insurance and preventive health check-up">
                                        </div>
                                        <div class="col-sm-6">
                                            @if(!empty($personals->parentsfile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->parentsfile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->parentsfile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
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
                                    <label class="font-weight-600"> Whether any of your parent is a senior citizen?

                                    </label>
                                    <input type="text" name="senior" value="{{ $personals->senior ?? ''}}"
                                        class="form-control"
                                        placeholder="Enter  Whether any of your parent is a senior citizen">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Any other eligible deduction (Please Specify)

                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="eligible" value="{{ $personals->eligible ?? ''}}"
                                                class="form-control" placeholder="Enter Any other eligible deduction">
                                        </div>
                                        <div class="col-sm-6">
                                            @if(!empty($personals->eligiblefile))
                                            <div class="col-sm-6">
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->eligiblefile ??'')}}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $personals->eligiblefile ??'' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i>
                                                    View</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>

                        </div> --}}

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
@endsection
