@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('connection.edit', $connection->id)}}">Edit Connection</a></li>
           
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Connection
                    Details</small>
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
			
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:420px;">
                <div class="card-body">
					  <a style="float: right;" href="{{url('/connection/list/destroy/'.$connection->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger-soft btn-sm"><i
                        class="far fa-trash-alt"></i></a>
                        <br><br>
                    <fieldset    class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Connection Name : </b></td>
                                    <td>{{ $connection->connectionname}}</td>
                                    <td><b>Email  : </b></td>
                                    <td>{!! $connection->emailid !!}</td>
                                </tr>
                                <tr>
                                    <td><b>Phone No : </b></td>
                                    <td>{{ $connection->phoneno}}</td>
                                    <td><b>Connected Through  : </b></td>
                                    <td>{!! $connection->connectedthrough !!}</td>

                                </tr>
                               
                                <tr>
                                    <td><b>Connected Email  : </b></td>
                                    <td>{{ $connection->connectedemail}}</td>
                                    <td><b>Connected Phone  : </b></td>
                                    <td>{!! $connection->connectedphone !!}</td>

                                </tr>
                                <tr>
                                    <td><b>Relationship Through  : </b></td>
                                    <td>{{ $connection->relationshipthrough}}</td>
                                    <td><b>Other Comment  : </b></td>
                                    <td>{!! $connection->othercomments !!}</td>

                                </tr>
                        
                            </tbody>
                           
                        </table>
                  
                        
                    </fieldset>
                    <div class="table-responsive">
                        <table class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="font-weight-800">Company Name</th>
                                    <th class="font-weight-800">Designation</th>
                                    <th class="font-weight-800">Expertise</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($connectioncompany as $connectioncompaniesData)
                                <tr>
                                    <td>{{$connectioncompaniesData->companyname }}</td>
                                    <td>{{$connectioncompaniesData->designation }}</td>
                                    <td>{{$connectioncompaniesData->expertise }}</td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            
           
        </div>
    </div>

</div>
@endsection
