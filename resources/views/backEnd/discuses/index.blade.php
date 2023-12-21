<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('discuss/create')}}">Add Meeting</a>
            </li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Meeting</small>
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
    
                    <div class="table-responsive example">
                        <div class="table-responsive">
                            <table id="exampleee" class="display nowrap">
                                <thead>
                                    <tr>
                                        <th>Topic</th>
                                        <th>Discuss With</th>
							            <th>Related To</th>
                                         <th>Created Date</th>
										 <th>No of Point</th>
                                        <th>Participate</th>
                                         <th>Createdby</th>
										<th>Delete</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($discussDatas as $discussData)
                                    <tr>
                                        <td><a href="{{route('discuss.show',encrypt($discussData->id))}}">{{$discussData->topic }}</a>
                                        </td>
                                        <td>
                                    @foreach(DB::table('discuses')
                                ->leftjoin('discusswithteams','discusswithteams.discuss_id','discuses.id')
                                ->leftjoin('teammembers','teammembers.id','discusswithteams.teammember_ids')->where('discuses.id',$discussData->id)->get()
                                as $sub)

                             @if($sub->profilepic == NULL)
                                <a class="avatar avatar-xs" data-toggle="tooltip" title="{{$sub->team_member}}">
                                <img src="{{url('backEnd/image/dummy.png')}}" class="avatar-img rounded-circle" alt="...">
                             
                       @else
                             <a class="avatar avatar-xs" data-toggle="tooltip" title="{{$sub->team_member}}">
                            <img src="{{asset('backEnd/image/teammember/profilepic/'.$sub->profilepic)}}" class="avatar-img rounded-circle" alt="...">
                        @endif
                    @endforeach
                            </td>
                                <td> 
                                @if($discussData->relatedto==0)
                                    {{ App\Models\Assignment::select('assignment_name')->where('id',$discussData->related_id)->first()->assignment_name ?? ''}}
                                 (Assignment Name)
                                @elseif($discussData->relatedto==1)
                                        {{ App\Models\Client::select('client_name')->where('id',$discussData->related_ids)->first()->client_name ?? ''}}
                                        (Client Name)
                                @else
                                            {{$discussData->other}}  (Other)  
                                @endif    
                                        </td>
                                        <td>{{ date('F d,Y', strtotime($discussData->created_at)) ??''}}</td>
                                                                 <td>
                                 @php
                                    $count = DB::table('discuses')
                                     ->leftjoin('discusstopics','discusstopics.discuss_id','discuses.id')
                                     ->where('discuses.id',$discussData->id)->count();
                                @endphp

                                   {{$count}}
                                </td>
                                      <td>
                                    @foreach(DB::table('discuses')
                                ->leftjoin('discusesteammebers','discusesteammebers.discuss_id','discuses.id')
                                ->leftjoin('teammembers','teammembers.id','discusesteammebers.teammember_id')->where('discuses.id',$discussData->id)->get()
                                as $sub)

                             @if($sub->profilepic == NULL)
                                <a class="avatar avatar-xs" data-toggle="tooltip" title="{{$sub->team_member}}">
                                <img src="{{url('backEnd/image/dummy.png')}}" class="avatar-img rounded-circle" alt="...">
                             
                       @else
                             <a class="avatar avatar-xs" data-toggle="tooltip" title="{{$sub->team_member}}">
                            <img src="{{asset('backEnd/image/teammember/profilepic/'.$sub->profilepic)}}" class="avatar-img rounded-circle" alt="...">
                        @endif
                    @endforeach
                            </td>
                   <td>{{ App\Models\Teammember::select('team_member')->where('id',$discussData->createdby)->first()->team_member ?? ''}}</td>
                                   <td><a href="{{url('discuss/deletes',$discussData->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" 
                                         class="btn ripple btn-danger text-white btn-icon" title="Delete" data-toggle="tooltip">
                                 <i class="fa fa-trash"></i></a></td>  
									</tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                <div>
                </div>
            </div>
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
        $('#exampleee').DataTable({
				"pageLength": 50,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
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


