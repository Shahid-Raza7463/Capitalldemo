
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Confirmation List</small>
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
                           
                            <th> Name</th>
                            <th>Amount</th>
                            <th>Remark</th>
                            <th>File</th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($debtorconfirmation as $taskData)
                        <tr>
                            <td>{{ $taskData->name ??''}}</td>
							                             <td>{{ $taskData->amount ??''}}</td>
                                                        <td>{{ $taskData->remark ??''}}</td>
							                            <td><a target="blank"
                                href="{{ url('storage/app/backEnd/image/confirmationfile/'. $taskData->file) }}">{{ $taskData->file ??''}}<a></td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


