@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        {{-- <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('policy/create')}}">Add Policy</a></li>
        <li class="breadcrumb-item active">+</li>
        </ol> --}}
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>List</small>
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

                            <th>File Name</th>
                            <th>file</th>

                            <th>Description</th>
                            <th>Share With</th>
                            <th>Valid Upto</th>
                            <th>Policy Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($policy as $policyDatas)
                        <tr>
                     @php
 $policyy = DB::table('policiessharewith')
 ->leftjoin('roles','roles.id','policiessharewith.sharewith')
  ->where('policiessharewith.policy_id','=',$policyDatas->id)->select('roles.rolename')->get();
 // dd($policyy);
                     @endphp
                            <td><a style="font-size: 16px;"
                                    href="{{ url('policy/acknowledgelist', $policyDatas->id)}}"><b>{{$policyDatas->filename }}</b></a>
                            </td>
                            <td><a href="{{asset('backEnd/image/policy/'.$policyDatas->file)}}"> {{ $policyDatas->file }}</a></td>
                            <td>{{ $policyDatas->descripation }}</td>
                         
                            <td> @foreach($policyy as $policyData)
                                {{ $policyData->rolename ??''}} ,
                                @endforeach
                            </td>
                            <td>{{ date('F d,Y', strtotime($policyDatas->date)) }}</td>
                          
                        
                            <td>{{ date('F d,Y', strtotime($policyDatas->created_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/policy/statusupdate')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Acknowledged Update</h5>
                 
                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    
                    <div class="row row-sm">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Acknowledged :</label>
                        <div class="col-sm-6">
                            <select name="Acknowledged" class="form-control">
                                <!--placeholder-->
                                <option value="">Please Select one</option>
                                 <option value="Yes">Mark As Read</option>
                                <option value="No">Mark As Unread</option>
                           
                            </select>
                            <input hidden placeholder="Enter Subject" id="id"  class="form-control" name="policyid" type="text">
                        </div>
                    </div>
                
                  <br>
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
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('policyupdate') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           $("#id").val(response.id);
debugger;
            
        },
                error: function () {

                },
            });
        });
    });

</script>  
@endsection
