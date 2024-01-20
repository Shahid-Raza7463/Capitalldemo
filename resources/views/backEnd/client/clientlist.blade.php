<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <nav aria-label="breadcrumb" class="col-sm-6 order-sm-last mb-3 mb-sm-0 p-0 ">
    </nav>

    <div class="col-sm-6 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Client List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            {{-- <form action="{{ url('/search') }}" method="GET"
            role="search">

            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search invoice by amount , invoice no , partner , client"> <span
                    class="input-group-btn">
                    <button type="submit" style="font-size: 17px;" class="btn btn-success">
                        <i class="fas fa-search"></i>
                    </button>

                </span>
            </div>
            </form> --}}
            <br>
            @component('backEnd.components.alert')

            @endcomponent
            @if(isset($client))
                <div class="table-responsive">
                    <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Company Name</th>
                                <th>Legal Status</th>
								        <th>client Id</th>
                                <th>Communication Address</th>
                           
                                <th>Pan Card No </th>
                                <th>Tan No </th>
                                <th>Gst No </th>
                                <th>Client Classification </th>

                            </tr>
                        </thead>

                        @foreach($client as $clients)
                            <tr>
                                <td style="display: none;">{{ $clients->id }}</td>
                                <td><a href="{{url('/viewclient/'.$clients->id )}}">{{ $clients->client_name ??'' }}</a></td>
                                <td>@if($clients->legalstatus==2)
                                    <span>Individual</span>
                                @elseif($clients->legalstatus==3)
                                    <span>Proprietorship</span>

                                @elseif($clients->legalstatus==4)
                                    <span> Firm</span>

                                @elseif($clients->legalstatus==5)
                                    <span>Private Limited Company</span>
                                @elseif($clients->legalstatus==6)
                                    <span> Public Company</span>
                                @elseif($clients->legalstatus==7)
                                    <span>Listed Company</span>
                                @elseif($clients->legalstatus==8)
                                    <span>Society</span>
                                @elseif($clients->legalstatus==9)
                                    <span>Trust</span>
                                @elseif($clients->legalstatus==10)
                                    <span>Section 8 Company</span>
                                @elseif($clients->legalstatus==11)
                                    <span>AOP</span>
                                @elseif($clients->legalstatus==12)
                                    <span> Foreign Company</span>
                                @elseif($clients->legalstatus==13)
                                    <span>LLP</span>
									 @elseif($clients->legalstatus==14)
                                    <span>HUF</span>
                        @endif
                        </td>
								  <td>{{ $clients->client_code ??'' }}</td>
                                <td>{{ $clients->c_address ??'' }}</td>
                           
                        <td>{{ $clients->panno ??'' }}</td>
                        <td>{{ $clients->tanno ??'' }}</td>
                        <td>{{ $clients->gstno ??'' }}</td>
                        <td>@if($clients->classification==1)
                            <span>NFRA</span>
                        @elseif($clients->classification==2)
                            <span>Quality Review</span>

                        @elseif($clients->classification==3)
                            <span> Peer Review</span>

                        @elseif($clients->classification==4)
                            <span>Others {{ $clients->otherclassification ??'' }}</span>
            @endif
            </td>
            </tr>
            @endforeach
            </>
            </table>
            {{-- {!! $client->render() !!} --}}
        </div>
    @elseif(isset($message))
        <p>{{ $message }}</p>

        @endif
    </div>
</div>

</div>
<!--/.body content-->

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function () {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [1, "asc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
					 filename: 'All Client List',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });

</script>
