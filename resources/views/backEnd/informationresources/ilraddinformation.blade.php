@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Additional Information</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('client/ilraddinformation/store')}}" enctype="multipart/form-data">
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Have you deposited amount or aggregate of amounts
                                        exceeding Rs. 1 Crore in one or more current account during the previous year?
                                        If yes, provide the amount.
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Have_you" value="{{ $ilraddinformation->Have_you ??'' }}" class="form-control">
                                  
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Have you incurred expenditure of an amount or
                                        aggregate of amount exceeding Rs. 2 lakhs for travel to a foreign country for
                                        yourself or for any other person? If yes, provide the amount.
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Have_you_incurred" value="{{ $ilraddinformation->Have_you_incurred ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Have you incurred expenditure of amount or aggregate
                                        of amount exceeding Rs. 1 lakh on consumption of electricity during the previous
                                        year?If yes, provide the amount.
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Have_you_incurred_expenditure" value="{{ $ilraddinformation->Have_you_incurred_expenditure ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Do you hold partnerships in any firm,
                                            if yes, then provide the following details - </b>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Name of Partnership Firm
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Name_of_Partnership" value="{{ $ilraddinformation->Name_of_Partnership ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Share of profit (%)
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Share_of_profit" value="{{ $ilraddinformation->Share_of_profit ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Remuneration
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Remuneration" value="{{ $ilraddinformation->Remuneration ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Interest
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Interest" value="{{ $ilraddinformation->Interest ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Profit
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Profit" value="{{ $ilraddinformation->Profit ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Capital Balance
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Capital_Balance" value="{{ $ilraddinformation->Capital_Balance ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Expenses
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Expenses" value="{{ $ilraddinformation->Expenses ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Whether you were Director in a company
                                            at any time during the previous year?If yes, provide the following details.
                                        </b>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Name of the Company

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Name_of_the_Company" value="{{ $ilraddinformation->Name_of_the_Company ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">PAN

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="PAN" value="{{ $ilraddinformation->PAN ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Company Type

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Company_Type" value="{{ $ilraddinformation->Company_Type ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Whether it's share are listed or unlisted


                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Whether_share" value="{{ $ilraddinformation->Whether_share ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Director Identification Number(DIN)

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="DIN" value="{{ $ilraddinformation->DIN ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Whether you have held unlisted equity
                                            shares at any time during the previous year? If yes, provide the following
                                            details.

                                        </b>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Name of the Company

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Name_of_the" value="{{ $ilraddinformation->Name_of_the ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">PAN

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="PANN" value="{{ $ilraddinformation->PANN ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Company Type

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Company" value="{{ $ilraddinformation->Company ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Opening Balance of shares (Number of shares)

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Opening_Balance" value="{{ $ilraddinformation->Opening_Balance ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Cost of Acquisition of shares

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Cost_of" value="{{ $ilraddinformation->Cost_of ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Number of shares acquired during the year


                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Number_of_shares" value="{{ $ilraddinformation->Number_of_shares ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Date of subscription/purchase


                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Date_of" value="{{ $ilraddinformation->Date_of ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Face Value per share


                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Face" value="{{ $ilraddinformation->Face ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Issue price per share(in case of fresh issue)


                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Issue_price" value="{{ $ilraddinformation->Issue_price ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Purchase price per share(in case of purchase from
                                        existing shareholders)


                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Purchase_price" value="{{ $ilraddinformation->Purchase_price ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">No. of Shares transferred during the year

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="of_Shares" value="{{ $ilraddinformation->of_Shares ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Sales Consideration

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Sales_Consideration" value="{{ $ilraddinformation->Sales_Consideration ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Closing Balance of shares (Number of shares)

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Closing_Balance" value="{{ $ilraddinformation->Closing_Balance ??'' }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Cost of Acquisition


                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Cost_of_Acquisition" value="{{ $ilraddinformation->Cost_of_Acquisition ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Do you have at any time during the previous year
                                        hold, as beneficial owner, beneficiary or otherwise any asset (including
                                        financial interest in any entity) located outside india?

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="beneficiary" value="{{ $ilraddinformation->beneficiary ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Do you have at any time during the previous year
                                        signing authority in any account located outside India?

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="authority" value="{{ $ilraddinformation->authority ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Do you have at any time during the previous year
                                        income from any source outside India?

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="outside" value="{{ $ilraddinformation->outside ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">In case of Non-Resident, is there a any permanent
                                        establishment in India?

                                        <span class="tx-danger">*</span></label>
                                    <input type="text" readonly name="Non_Resident" value="{{ $ilraddinformation->Non_Resident ??'' }}" class="form-control">
                                </div>
                            </div>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
@endsection
