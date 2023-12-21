@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('creditnote/create')}}">Add Creditnote</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>creditnote
                    List</small>
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
               <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>CreditNote No.</th>
                            <th>Credit Date </th>
                            <th>Client</th>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>Amount</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($creditnoteDatas as $creditnoteData)
                        <tr>
                            <td>
                                <a href="{{route('creditnote.show', $creditnoteData->id)}}">
                                    {{$creditnoteData->credit_note_number }}</a></td>
                            <td>{{ date('F d,Y', strtotime($creditnoteData->credit_date)) ??''}}</td>
                            <td>{{$creditnoteData->client_name??''}}</td>
                            <td>{{ $creditnoteData->invoice_id ??''}}</td>
                            <td>{{ date('F d,Y', strtotime($creditnoteData->invoice_date)) ??''}}</td>
                             <td>{{ $creditnoteData->total ??''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
