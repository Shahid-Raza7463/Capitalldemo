@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Add Assignment</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('assignment.store')}}" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                        @include('backEnd.assignment.form')
                    </form>
                   
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
    
        <div class="card-body">
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>View</th>
                            {{-- <th>View Assignment</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignmentDatas as $assignmentData => $value)
                        <tr>
                            <td>{{$assignmentData+1}}</td>
                            <td>{{$value->assignment_name}}</td>
                            @if(App\Models\Financialstatementclassification::where('assignment_id',$value->id)->first())
                             <td><a href="{{url('/step/check/'.$value->id)}}" class="btn btn-primary">Checklist</a></td>
                              {{--  <td><a href="{{url('/viewassignment/'.$assignmentData->id)}}" class="btn btn-primary">View</a></td> --}}
                             @else
                    <td></td>
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

