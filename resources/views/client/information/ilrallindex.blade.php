
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
            <li class="breadcrumb-item"><a href="{{ url()->previous() }}" >Back <i class="fa fa-reply"></i></a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>ILR List</small>
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
                            <th>id</th>
                            <th>Folder</th>
                            <th>List</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($informationresourcesDatas as $information => $informationresourcesData)
                        <tr>
                            <td>{{$information + 1 }}</td>
                            <td>{{$informationresourcesData->name }}</td>
                             <td><table class="table">
                                <thead>
                                    <tr>
                                      
                                        <th>Sub Folder</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Modify Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
$informationresources = DB::table('ilrfolders')
       ->leftjoin('informationresources','informationresources.ilrfolder_id','ilrfolders.id')
    ->leftjoin('ilranswers','ilranswers.informationresource_id','informationresources.id')
      ->where('ilrfolders.client_id',auth()->user()->client_id)
      ->where('ilrfolders.parent_id',$informationresourcesData->id)->get();
     // dd($informationresources);
                                    @endphp
                                    @foreach($informationresources as $information => $informationresourcesDa)
                                    <tr>
                                      
                                         <td>{{ $informationresourcesDa->name }}</td>
                                         <td>{{ $informationresourcesDa->question }}</td>
                                         <td><a   href="{{ Storage::disk('s3')->temporaryUrl('clientinfodocument/'.$informationresourcesDa->url, now()->addMinutes(3)) }}"> {{ $informationresourcesDa->url }}</a></td>
                                      <td>{{ date('F d,Y', strtotime($informationresourcesDa->updated_at)) }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table></td>
                          
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Information Answer</h5>
           
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="post" action="{{ url('client/information/store')}}" enctype="multipart/form-data">
                        @csrf
          
                        @include('client.information.form')
                    </form>
                   
                    <hr class="my-4">
                   <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                             <th>Attachment</th>
                             <th>Remark</th>
							  <th>Uploaded by</th>
                             <th>Date</th>
                             
                                               
                            
                        </tr>
                    </thead>
                   <tbody id="out_id">
                      
                    </tbody> 
                </table>
            </div> 
                </div>
            </div>
           
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            var id = $(this).data('id');
    // debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('client/information/first') }}",
                data: "id=" + id,

                success: function (response) {
                    document.getElementById('ilrid').value = id;
                    $("#questions").val(response.question);
//                     debugger;
//                     var	rows = '';
//                     $.each( response.ilranswers, function( key, value ) {
//                         rows = rows + '<tr>';
//                         	rows = rows + '<td>'+value.url+'</td>';
//                         	rows = rows + '<td>'+value.url+'</td>';
//                         	rows = rows + '<td>'+value.url+'</td>';
//                         	rows = rows + '<td>'+value.url+'</td>';
//                         	rows = rows + '</tr>';
//   });
//   $("ilrans").html(rows);
//   debugger;
                  
                },
                error: function () {

                },
            });
        });

    });

</script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('client/information/firstt') }}",
                data: "id=" + id,
                success : function(res){
           // alert(res);
            $('#out_id').html(res);

            
        },
                error: function () {

                },
            });
        });
    });

</script>     
@endsection
                                   

