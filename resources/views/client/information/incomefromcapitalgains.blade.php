


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
                <small>Add Income from Capital Gains</small>
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
                            <th>Details of Asset sold other than mutual fund</th>
                            <th>Sale deed or Sale receipt</th>
                            <th>Date of purchase</th>
                            <th>Purchase deed or purchase receipt</th>
                            <th>Cost of Improvement</th>
                            <th>Any Investment made for claiming Exemption</th>
                            <th>Mutual Funds/share sale details</th>
                            <th>Purchase Prices Of Mutual Fund/Shares Sold With Dates</th>
                            <th>Capital Gain statement from DP</th>
                            <th>Any Other Details/Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($personal as $personals)
                        <tr>
                            <td><a style="color: #37A000" id="editCompany" title="edit details" data-toggle="modal"
                                    data-id="{{ $personals->id }}"
                                    data-target="#exampleModal13">{{$personals->assetsold ??''}}</a></td>
                            <td>{{$personals->saledeed ??''}}
                                @if(!empty($personals->saledeedfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->saledeedfile ??'')}}"
                                target="blank">{{ $personals->saledeedfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personals->purchasedate ??''}}</td>
                            <td>{{$personals->purchasedeed ??''}}
                                @if(!empty($personals->purchasedeedfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->purchasedeedfile ??'')}}"
                                target="blank">{{ $personals->purchasedeedfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personals->cost ??''}}
                                @if(!empty($personals->costfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->costfile ??'')}}"
                                target="blank">{{ $personals->costfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personals->anyinvestment ??''}}
                                @if(!empty($personals->anyinvestmentfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->anyinvestmentfile ??'')}}"
                                target="blank">{{ $personals->anyinvestmentfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personals->mutualfund ??''}}
                                @if(!empty($personals->mutualfundfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->mutualfundfile ??'')}}"
                                target="blank">{{ $personals->mutualfundfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personals->Purchase ??''}}
                                @if(!empty($personals->Purchasefile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->Purchasefile ??'')}}"
                                target="blank">{{ $personals->Purchasefile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personals->capitalgain ??''}}@if(!empty($personals->capitalgainfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->capitalgainfile ??'')}}"
                                target="blank">{{ $personals->capitalgainfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personals->other ??''}}
                                @if(!empty($personals->otherfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->otherfile ??'')}}"
                                target="blank">{{ $personals->otherfile ??''}}</a></span>
                            @endif</td>
                           
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg show" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('client/incomefromcapitalgains/store')}}"
                    enctype="multipart/form-data">
                    
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Income from Capital Gains</h5>
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
                                    <label class="font-weight-600">Details of Asset sold other than mutual fund or shares sales details
                                    </label>
                                    <input type="text" name="assetsold" 
                                        class="form-control" placeholder="Enter Details of Asset sold other than mutual fund or shares sales details">
                                    <input hidden type="text" name="informationresource_id" value="{{ $id ?? ''}}"
                                        class="form-control" placeholder="Enter Details of Asset sold">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Sale deed or Sale receipt
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="saledeed" 
                                                class="form-control" placeholder="Enter Sale deed or Sale receipt">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="saledeedfile"
                                               class="form-control"
                                                placeholder="Enter Interest from Savings Bank a/c
">
                                        </div>
                                        {{-- @if($personals->saledeedfile ??'')
                                        <div class="col-sm-2">
                                                <label class="font-weight-600"></label>
                                                <a href="{{ url('backEnd/image/ilrbp/'.$personals->saledeedfile ??'')}}" target="blank" data-toggle="tooltip"
                                                title="{{ $personals->saledeedfile ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                         
                                        </div>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Date of purchase
                                    </label>
                                    <input type="text" name="purchasedate" 
                                        class="form-control" placeholder="Enter Date of purchase">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Purchase deed or purchase receipt
                                    </label>

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="purchasedeed"
                                               class="form-control"
                                                placeholder="Enter Purchase deed or purchase receipt">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="purchasedeedfile"
                                             class="form-control"
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
                                    <label class="font-weight-600">Cost of Improvement
                                    </label>

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="cost" 
                                                class="form-control" placeholder="Enter Cost of Improvement">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="costfile" class="form-control"
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
                                    <label class="font-weight-600">Any Investment made for claiming Exemption
                                    </label>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="anyinvestment" class="form-control"
                                                placeholder="Enter Any Investment made for claiming Exemption">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="anyinvestmentfile" class="form-control"
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
                                    <label class="font-weight-600">Mutual Funds/share sale details
                                    </label>

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="mutualfund" class="form-control"
                                                placeholder="Enter Mutual Funds/share sale details">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="mutualfundfile" class="form-control"
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
                                    <label class="font-weight-600">Purchase Prices Of Mutual Fund/Shares Sold With
                                        Dates
                                    </label>

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="Purchase"
                                                class="form-control" placeholder="Enter Purchase Prices Of Mutual Fund/Shares Sold With
                                        Dates">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="Purchasefile" class="form-control"
                                                placeholder="Enter Purchase prices of mutual fund/ shares sold with
                                        dates
">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Capital Gain statement from DP
                                    </label>

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="capitalgain" class="form-control"
                                                placeholder="Enter Capital Gain statement from DP">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="capitalgainfile" class="form-control"
                                                placeholder="Enter Capital Gain statement from DP
">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Any Other Details/Information
                                    </label>

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input type="text" name="other"
                                                class="form-control" placeholder="Enter Any Other Details/Information">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="otherfile" class="form-control"
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
  <div class="modal fade" id="exampleModal13" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('client/incomefromcapitalgains/update')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Edit Details
                    </h5>
                    <div>
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
                                <label class="font-weight-600">Details of Asset sold
                                </label>
                                <input type="text" name="assetsold" id="assetsold"
                                    value="{{ $personals->assetsold ??'' }}" class="form-control"
                                    placeholder="Enter Details of Asset sold">
                                <input hidden type="text" name="id" id="id" class="form-control"
                                    placeholder="Enter Details of Asset sold">

                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Sale deed or Sale receipt
                                </label>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <input type="text" name="saledeed" id="saledeed"
                                            value="{{ $personals->saledeed ??'' }}" class="form-control"
                                            placeholder="Enter Sale deed or Sale receipt">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="file" name="saledeedfile"
                                            value="{{ $personals->saledeedfile ??'' }}" class="form-control"
                                            placeholder="Enter Interest from Savings Bank a/c">
                                    </div>
                                    {{-- @if($personals->saledeedfile ??'')
                                <div class="col-sm-2">
                                        <label class="font-weight-600"></label>
                                        <a href="{{ url('backEnd/image/ilrbp/'.$personals->saledeedfile ??'')}}"
                                    target="blank" data-toggle="tooltip"
                                    title="{{ $personals->saledeedfile ??'' }}" class="btn btn-success-soft ml-2"><i
                                        class="fas fa-file"></i> View</a>

                                </div>
                                @endif --}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Date of purchase
                            </label>
                            <input type="text" name="purchasedate" id="purchasedate"
                                value="{{ $personals->purchasedate ??'' }}" class="form-control"
                                placeholder="Enter Date of purchase">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Purchase deed or purchase receipt
                            </label>

                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="text" name="purchasedeed" id="purchasedeed"
                                        value="{{ $personals->purchasedeed ??'' }}" class="form-control"
                                        placeholder="Enter Purchase deed or purchase receipt">
                                </div>
                                <div class="col-sm-6">
                                    <input type="file" name="purchasedeedfile"
                                        value="{{ $personals->purchasedeedfile ??'' }}" class="form-control"
                                        placeholder="Enter Interest from Savings Bank a/c">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Cost of Improvement
                            </label>

                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="text" name="cost" id="cost" value="{{ $personals->cost ??'' }}"
                                        class="form-control" placeholder="Enter Cost of Improvement">
                                </div>
                                <div class="col-sm-6">
                                    <input type="file" name="costfile" value="{{ $personals->costfile ??'' }}"
                                        class="form-control" placeholder="Enter Interest from Savings Bank a/c">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Any Investment made for claiming Exemption
                            </label>
                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="text" name="anyinvestment" id="anyinvestment"
                                        value="{{ $personals->anyinvestment ??'' }}" class="form-control"
                                        placeholder="Enter Any Investment made for claiming Exemption">
                                </div>
                                <div class="col-sm-6">
                                    <input type="file" name="anyinvestmentfile"
                                        value="{{ $personals->anyinvestmentfile ??'' }}" class="form-control"
                                        placeholder="Enter Interest from Savings Bank a/c">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">

                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Mutual Funds/share sale details
                            </label>

                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="text" name="mutualfund" id="mutualfund"
                                        value="{{ $personals->mutualfund ??'' }}" class="form-control"
                                        placeholder="Enter Mutual Funds/share sale details">
                                </div>
                                <div class="col-sm-6">
                                    <input type="file" name="mutualfundfile"
                                        value="{{ $personals->mutualfundfile ??'' }}" class="form-control"
                                        placeholder="Enter Interest from Savings Bank a/c">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Purchase Prices Of Mutual Fund/Shares Sold With
                                Dates
                            </label>

                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="text" name="Purchase" id="Purchase"
                                        value="{{ $personals->Purchase ??'' }}" class="form-control" placeholder="Enter Purchase Prices Of Mutual Fund/Shares Sold With
                                Dates">
                                </div>
                                <div class="col-sm-6">
                                    <input type="file" name="Purchasefile" value="{{ $personals->Purchasefile ??'' }}"
                                        class="form-control" placeholder="Enter Purchase prices of mutual fund/ shares sold with
                                dates">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Capital Gain statement from DP
                            </label>

                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="text" name="capitalgain" id="capitalgain"
                                        value="{{ $personals->capitalgain ??'' }}" class="form-control"
                                        placeholder="Enter Capital Gain statement from DP">
                                </div>
                                <div class="col-sm-6">
                                    <input type="file" name="capitalgainfile"
                                        value="{{ $personals->capitalgainfile ??'' }}" class="form-control"
                                        placeholder="Enter Capital Gain statement from DP">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Any Other Details/Information
                            </label>

                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="text" name="other" id="other" value="{{ $personals->other ??'' }}"
                                        class="form-control" placeholder="Enter Any Other Details/Information">
                                </div>
                                <div class="col-sm-6">
                                    <input type="file" name="otherfile" value="{{ $personals->otherfile ??'' }}"
                                        class="form-control" placeholder="Enter Interest from Savings Bank a/c">
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

                url: "{{ url('client/incomefromcapitalgains/edit') }}",
                data: "id=" + id,
                success: function (response) {
                    $("#id").val(response.id);
                    $("#assetsold").val(response.assetsold);
                    $("#saledeed").val(response.saledeed);
                    $("#saledeedfile").val(response.saledeedfile);
                    $("#purchasedate").val(response.purchasedate);
                    $("#purchasedeed").val(response.purchasedeed);
                    $("#purchasedeedfile").val(response.purchasedeedfile);
                    $("#cost").val(response.cost);
                    $("#costfile").val(response.costfile);
                    $("#anyinvestment").val(response.anyinvestment);
                    $("#anyinvestmentfile").val(response.anyinvestmentfile);
                    $("#mutualfund").val(response.mutualfund);
                    $("#mutualfundfile").val(response.mutualfundfile);
                    $("#Purchase").val(response.Purchase);
                    $("#Purchasefile").val(response.Purchasefile);
                    $("#capitalgain").val(response.capitalgain);
                    $("#capitalgainfile").val(response.capitalgainfile);
                    $("#other").val(response.other);
                    $("#otherfile").val(response.otherfile);
                },
                error: function () {

                },
            });
        });
    });

</script>
                                 

