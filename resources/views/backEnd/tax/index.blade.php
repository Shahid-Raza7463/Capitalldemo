@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('tax/create')}}">Add Investment Declaration</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Investment Declaration List</small>
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
                            <th>Createdby</th>
                            <th>Created Date</th>
							<th>Financial Year</th>
                            <th>Tax Regime</th>
                          
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taxData as $taxDatas)
                        <tr>
                            <td><a href="{{route('tax.show', $taxDatas->id)}}">{{$taxDatas->team_member }}</td>
                           
                            <td>{{ date('F d,Y', strtotime($taxDatas->created_at)) }}</td>
							 <td>@if($taxDatas->year==2022)
                                <span >2022-23</span>
								 @elseif($taxDatas->tax_regime==2023)
                                <span >2023-24</span>
                                @endif
                            </td>
                            <td>@if($taxDatas->tax_regime==0)
                                <span >Old</span>
								 @elseif($taxDatas->tax_regime==1)
                                <span >New</span>
                                @endif
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
