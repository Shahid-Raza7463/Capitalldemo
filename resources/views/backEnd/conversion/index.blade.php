@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    {{-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('conversion/create')}}">Add conversion</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav> --}}
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
                <a href="{{url('home')}}">
                    <h1 class="font-weight-bold" style="color:black;">Home</h1>
                </a>
                <small>Conversion List</small>
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

                            <th>Client Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Partner</th>
                            <th>Mail Status</th>
                            <th>Acknowledged</th>
 <th>Attachment</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conversionDatas as $conversionData)
                        <tr>
                            <td> <a data-toggle="modal" style="color: green" id="editCompany" data-id="{{ $conversionData->id }}"
                                data-target="#exampleModal12">{{ $conversionData->Client_Name ??''}}</a></td>
                            <td>{{ $conversionData->Contact_Person ??''}}</td>
                            <td>{{ $conversionData->Email_ID ??''}}</td>
                            <td>{{ $conversionData->Mobile_No ??''}}</td>
                            <td>{{ $conversionData->team_member ??''}}</td>
                            <td>{{ $conversionData->Mail_Sent_or_not ??''}}</td>
                            <td>{{ $conversionData->Acknowledged ??''}}</td>
  @if($conversionData->file != null)
                            <td><a target="blank" href="{{url('/backEnd/image/conversion/'.$conversionData->file)}}"><i class="fas fa-file-pdf"> {{ $conversionData->file ??''}}</i></a></td>
						    @else
<td></td>
                            @endif
                            @if($conversionData->date != null)
                            <td>{{ date('F d,Y', strtotime($conversionData->date)) }}</td>
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

</div>
<!--/.body content-->

<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/connection/statusupdate')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Conversion Update</h5>
                 
                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row row-sm">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Mail Status :</label>
                        <div class="col-sm-6">
                            <select name="Mail_Sent_or_not" class="form-control">
                                <!--placeholder-->
                                 <option value="">Please Select one</option>
                                 <option value="Yes">Yes</option>
                                <option value="No">No</option>
                           
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Acknowledged :</label>
                        <div class="col-sm-6">
                            <select name="Acknowledged" class="form-control">
                                <!--placeholder-->
                                <option value="">Please Select one</option>
                                 <option value="Yes">Yes</option>
                                <option value="No">No</option>
                           
                            </select>
                            <input hidden placeholder="Enter Subject" id="id"  class="form-control" name="conversionid" type="text">
                        </div>
                    </div>
                  <div class="row row-sm">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Attachment :</label>
                        <div class="col-sm-6">
                          
                            <input placeholder="Enter Subject" class="form-control" name="file" type="file">
                        </div>
                    </div>
                    <br>
                    <div class="row row-sm">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Date :</label>
                        <div class="col-sm-6">
                          
                            <input placeholder="Enter Subject" class="form-control" name="date" type="date">
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

                url: "{{ url('conversionupdate') }}",
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
