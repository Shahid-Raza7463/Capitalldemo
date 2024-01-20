
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	<div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Team List</small>
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
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Team Member Name</th>
                            <th>Team Role</th>						
                            <th>Mobile No</th>					
                        <th>Email</th>		
                         
							</tr>
                    </thead>
                    <tbody>
                        @foreach($teammemberDatas as $teammemberData)
                        <tr>
                            <td>
									{{$teammemberData->team_member}} ( {{$teammemberData->staffcode ??''}} )
							</td>
                            <td>{{$teammemberData->role->rolename ??''}}</td>
						
                            <td>{{$teammemberData->mobile_no}}</td>
						
							  <td><a href="mailto:{{$teammemberData->emailid}}">{{$teammemberData->emailid ??''}}</a></td>
						
					
                            
                          	
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
@endsection


