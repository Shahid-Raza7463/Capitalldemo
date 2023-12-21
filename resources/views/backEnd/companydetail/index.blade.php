
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('companydetail/create')}}">Add Company Detail</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Company Detail</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
     @component('backEnd.components.alert')

        @endcomponent
        <div class="card-body">
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                           
                            <th> Company Name</th>
                            <th>Address</th>
                          
                            <th>GST Number</th>
                            <th>Company Email</th>
                            <th>Phone Number</th>
                           
                            <th>Creted By</th>
                            
                            <th>Edit</th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companyDatas as $company)
                        <tr>
                            <td><a href="{{url('view/companydetail', $company->id)}}" >{{$company->company_name ??''}}</a></td>
                            <td>{{$company->address ??'' }}</td>
                            
                            <td>{{$company->gstno ??''}}</td>
                          <td>{{$company->company_email ??''}}</td>
                          <td>{!! $company->phone_no ??''!!}</td>
                       
                          <td>{{$company->team_member ??''}}</td>
                            @if($company->created_by ==  Auth::user()->teammember_id)
                            <td>  <a href="{{route('companydetail.edit', $company->id)}}" class="btn btn-info-soft btn-sm">
                            <i class="far fa-edit"></i></a></td>  
                           @else
                           <td></td>
                                @endif    
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


