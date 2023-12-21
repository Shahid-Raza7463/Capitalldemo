
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
                <small>Income from Capital Gains</small>
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
                        @foreach($personals as $personalData)
                        <tr>
                            <td>{{$personalData->assetsold ??''}}</td>
                            <td>{{$personalData->saledeed ??''}}
                                @if(!empty($personalData->saledeedfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personalData->saledeedfile ??'')}}"
                                target="blank">{{ $personalData->saledeedfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personalData->purchasedate ??''}}</td>
                            <td>{{$personalData->purchasedeed ??''}}
                                @if(!empty($personalData->purchasedeedfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personalData->purchasedeedfile ??'')}}"
                                target="blank">{{ $personalData->purchasedeedfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personalData->cost ??''}}
                                @if(!empty($personalData->costfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personalData->costfile ??'')}}"
                                target="blank">{{ $personalData->costfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personalData->anyinvestment ??''}}
                                @if(!empty($personalData->anyinvestmentfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personalData->anyinvestmentfile ??'')}}"
                                target="blank">{{ $personalData->anyinvestmentfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personalData->mutualfund ??''}}
                                @if(!empty($personalData->mutualfundfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personalData->mutualfundfile ??'')}}"
                                target="blank">{{ $personalData->mutualfundfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personalData->Purchase ??''}}
                                @if(!empty($personalData->Purchasefile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personalData->Purchasefile ??'')}}"
                                target="blank">{{ $personalData->Purchasefile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personalData->capitalgain ??''}}@if(!empty($personalData->capitalgainfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personalData->capitalgainfile ??'')}}"
                                target="blank">{{ $personalData->capitalgainfile ??''}}</a></span>
                            @endif</td>
                            <td>{{$personalData->other ??''}}
                                @if(!empty($personalData->otherfile))
                                <span><b>Attachment</b>:  
                                <a href="{{ url('backEnd/image/ilrbp/'.$personalData->otherfile ??'')}}"
                                target="blank">{{ $personalData->otherfile ??''}}</a></span>
                            @endif</td>
                           
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
@endsection
                                   

