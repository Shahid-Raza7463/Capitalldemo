@extends('client.layouts.layout') @section('client_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Additional Information</h6>
                        </div>
						<div class="col-md-5">
						</div>
						<div class="col-md-1">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"><a href="{{ url()->previous() }}" >Back <i class="fa fa-reply"></i></a></h6>
                        </div> --}}
                        <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Additional Information</h6>
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-1">
                             <a data-toggle="modal" data-target="#exampleModal12" style="color:white;">Action</a>
                        </div>
                        <div class="col-md-1">

                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"><a
                                    href="{{ url()->previous() }}">Back <i class="fa fa-reply"></i></a></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(empty($info->type))
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
                                    <input type="text" name="Have_you" value="{{ $info->Have_you ??''}}" class="form-control">
                                    <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                                    placeholder="Enter Account No">
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
                                    <input type="text" name="Have_you_incurred" value="{{ $info->Have_you_incurred ??''}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Have you incurred expenditure of amount or aggregate
                                        of amount exceeding Rs. 1 lakh on consumption of electricity during the previous
                                        year? If yes, provide the amount.
                                        <span class="tx-danger">*</span></label>
                                    <input type="text" name="Have_you_incurred_expenditure" value="{{ $info->Have_you_incurred_expenditure ??''}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-11">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Do you hold partnerships in any firm,
                                            if yes, then provide the following details - </b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group" >
                                    <a data-toggle="modal" data-target=".cd-example-modal-lg" title="Add Details"><img
                                            src="{{ url('backEnd/image/add-icon.png')}}" /></a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table display table-bordered table-striped table-hover basic">
                                <thead>
                                    <tr>
                                        <th>Name of Partnership Firm</th>
                                        <th>Share of profit (%)</th>
                                        <th>Remuneration</th>
                                        <th>Interest</th>
                                        <th>Profit </th>
                                        <th>Capital Balance </th>
                                        <th>Expenses  </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ilraddinformationthird as $ilrbank)
                                    <tr>
                                        <td> <a style="color: #37A000" id="editCompany" 
                                            title="edit bank details" data-toggle="modal" data-id="{{ $ilrbank->id }}"
                                            data-target="#exampleModal12">{{$ilrbank->Name_of_Partnership ??''}}</a></td>
                                        <td>{{$ilrbank->Share_of_profit ??''}}</td>
                                        <td>{{$ilrbank->Remuneration ??''}}</td>
                                        <td>{{$ilrbank->Interest ??''}}</td>
                                        <td>{{$ilrbank->Profit ??''}}</td>
                                        <td>{{$ilrbank->Capital_Balance ??''}}</td>
                                        <td>{{$ilrbank->Expenses ??''}}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row row-sm ">
                            <div class="col-11">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Whether you were Director in a company
                                            at any time during the previous year? If yes, provide the following details.
                                        </b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group" >
                                    <a data-toggle="modal" data-target=".bd-example-modal-lg" title="Add Details"><img
                                            src="{{ url('backEnd/image/add-icon.png')}}" /></a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table display table-bordered table-striped table-hover basic">
                                <thead>
                                    <tr>
                                        <th>Name of the Company</th>
                                        <th>PAN</th>
                                        <th>Company Type</th>
                                        <th>Whether it's share are listed or unlisted *</th>
                                        <th>Director Identification Number(DIN) *</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ilraddinformationfirst as $ilrbank)
                                    <tr>
                                        <td> <a style="color: #37A000" id="editCompany" 
                                            title="edit bank details" data-toggle="modal" data-id="{{ $ilrbank->id }}"
                                            data-target="#exampleModal12">{{$ilrbank->nameofthecompany ??''}}</a></td>
                                        <td>{{$ilrbank->pann ??''}}</td>
                                        <td>{{$ilrbank->companytype ??''}}</td>
                                        <td>{{$ilrbank->whethershare ??''}}</td>
                                        <td>{{$ilrbank->director ??''}}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row row-sm ">
                            <div class="col-11">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Whether you have held unlisted equity
                                            shares at any time during the previous year? If yes, provide the following
                                            details.

                                        </b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group" >
                                    <a data-toggle="modal" data-target=".bd-example-modal-xl" title="Add Details"><img
                                            src="{{ url('backEnd/image/add-icon.png')}}" /></a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table display table-bordered table-striped table-hover basic">
                                <thead>
                                    <tr>
                                        <th>Name of the Company</th>
                                        <th>PAN</th>
                                        <th>Company Type</th>
                                        <th>Opening Balance of shares (Number of shares)</th>
                                        <th>Cost of Acquisition of shares</th>
                                        <th>Number of shares acquired during the year </th>
                                        <th>Date of subscription/purchase</th>
                                        <th>Face Value per share</th>
                                        <th>Issue price per share(in case of fresh issue</th>
                                        <th>Purchase price per share(in case of purchase from existing shareholders)</th>
                                        <th>No. of Shares transferred during the year</th>
                                        <th>Sales Consideration</th>
                                        <th>Closing Balance of shares (Number of shares)</th>
                                        <th>Do you have at any time during the previous year hold</th>
                                        <th>Do you have at any time during the previous year signing </th>
                                        <th>Do you have at any time during the previous year income </th>
                                        <th>In case of Non-Resident, is there a any permanent establishment in India</th>
                                        <th>Cost of Acquisition</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ilraddinformationsecond as $ilrbank)
                                    <tr>
                                        <td> <a style="color: #37A000" id="editCompany" 
                                            title="edit bank details" data-toggle="modal" data-id="{{ $ilrbank->id }}"
                                            data-target="#exampleModal12">{{$ilrbank->Name_of_the ??''}}</a></td>
                                        <td>{{$ilrbank->pannn ??''}}</td>
                                        <td>{{$ilrbank->Company ??''}}</td>
                                        <td>{{$ilrbank->Opening_Balance ??''}}</td>
                                        <td>{{$ilrbank->Cost_of ??''}}</td>
                                        <td>{{$ilrbank->Number_of_shares ??''}}</td>
                                        <td>{{$ilrbank->Date_of ??''}}</td>
                                        <td>{{$ilrbank->Face ??''}}</td>
                                        <td>{{$ilrbank->Issue_price ??''}}</td>
                                        <td>{{$ilrbank->Purchase_price ??''}}</td>
                                        <td>{{$ilrbank->of_Shares ??''}}</td>
                                        <td>{{$ilrbank->Sales_Consideration ??''}}</td>
                                        <td>{{$ilrbank->Closing_Balance ??''}}</td>
                                        <td>{{$ilrbank->Cost_of_Acquisition ??''}}</td>
                                        <td>{{$ilrbank->beneficiary ??''}}</td>
                                        <td>{{$ilrbank->authority ??''}}</td>
                                        <td>{{$ilrbank->outside ??''}}</td>
                                        <td>{{$ilrbank->Non_Resident ??''}}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>


                        </div>

                    </form>
                    @else
                    <h5 style="text-align: center"><span>Not Applicable</span></h5>

                  @endif

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
            <form method="post" action="{{ url('client/ilraddinformation/store')}}" enctype="multipart/form-data">

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

        </div>
    </div>
</div>

@endsection
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="{{ url('client/ilraddinformationfirst/store')}}" enctype="multipart/form-data">

                @csrf
            @csrf
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Whether you were Director in a company at any time during the previous year? If yes, provide the following details.</h5>
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
                            <label class="font-weight-600">Name of the Company   </label>
                            <input type="text" name="nameofthecompany" class="form-control"
                                placeholder="Enter Name of the Company ">
                                <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                                placeholder="Enter Account No">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">PAN </label>
                            <input type="text" name="pann"  class="form-control"
                                placeholder="Enter PAN ">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Company Type</label>
                            <input type="text" name="companytype" class="form-control"
                                placeholder="Enter Company Type">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                  
                    <div class="col-6">
                        <div class="form-group">
                            <label class="font-weight-600">Whether it's share are listed or unlisted *</label>
                            <input type="text" name="whethershare" class="form-control"
                                placeholder="Enter Whether it's share are listed or unlisted">
                          
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="font-weight-600">Director Identification Number(DIN) *</label>
                            <input type="text" name="director"  class="form-control"
                                placeholder="Enter Director Identification Number(DIN) ">
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
<div class="modal fade cd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="{{ url('client/ilraddinformationthird/store')}}" enctype="multipart/form-data">

                @csrf
            @csrf
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Do you hold partnerships in any firm, if yes, then provide the following details</h5>
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
                            <label class="font-weight-600">Name of Partnership Firm
                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Name_of_Partnership" value="{{ $info->Name_of_Partnership ??''}}" class="form-control">
                            <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                            placeholder="Enter Account No">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Share of profit (%)
                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Share_of_profit" value="{{ $info->Share_of_profit ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Remuneration
                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Remuneration" value="{{ $info->Remuneration ??''}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Interest
                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Interest" value="{{ $info->Interest ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Profit
                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Profit" value="{{ $info->Profit ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Capital Balance
                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Capital_Balance" value="{{ $info->Capital_Balance ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Expenses
                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Expenses" value="{{ $info->Expenses ??''}}" class="form-control">
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
<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" action="{{ url('client/ilraddinformationsecond/store')}}" enctype="multipart/form-data">

                @csrf
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Whether you have held unlisted equity shares at any time during the previous year? If yes, provide the following details.</h5>
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
                            <label class="font-weight-600">Name of the Company

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Name_of_the" value="{{ $info->Name_of_the ??''}}" class="form-control">
                            <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                            placeholder="Enter Account No">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">PAN

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="pannn" value="{{ $info->PANN ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Company Type

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Company" value="{{ $info->Company ??''}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Opening Balance of shares (Number of shares)

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Opening_Balance" value="{{ $info->Opening_Balance ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Cost of Acquisition of shares

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Cost_of" value="{{ $info->Cost_of ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Number of shares acquired during the year


                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Number_of_shares" value="{{ $info->Number_of_shares ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Date of subscription/purchase


                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Date_of" value="{{ $info->Date_of ??''}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Face Value per share


                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Face" value="{{ $info->Face ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Issue price per share(in case of fresh issue)


                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Issue_price" value="{{ $info->Issue_price ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Purchase price per share(in case of purchase from
                                existing shareholders)


                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Purchase_price" value="{{ $info->Purchase_price ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">No. of Shares transferred during the year

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="of_Shares" value="{{ $info->of_Shares ??''}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Sales Consideration

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Sales_Consideration" value="{{ $info->Sales_Consideration ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Closing Balance of shares (Number of shares)

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Closing_Balance" value="{{ $info->Closing_Balance ??''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Cost of Acquisition


                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Cost_of_Acquisition" value="{{ $info->Cost_of_Acquisition ??''}}" class="form-control">
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
                            <input type="text" name="beneficiary" value="{{ $info->beneficiary ??''}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Do you have at any time during the previous year
                                signing authority in any account located outside India?

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="authority" value="{{ $info->authority ??''}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Do you have at any time during the previous year
                                income from any source outside India?

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="outside" value="{{ $info->outside ??''}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">In case of Non-Resident, is there a any permanent
                                establishment in India?

                                <span class="tx-danger">*</span></label>
                            <input type="text" name="Non_Resident" value="{{ $info->Non_Resident ??''}}" class="form-control">
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