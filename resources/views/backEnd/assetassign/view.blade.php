@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background:#37A000">
                    <div class="d-flex justify-content-between align-items-center">
                         
                        <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"> Finance</h6>
						 </div>
						<div class="col-md-6">
							<p  style="float: right;color: white"><a data-toggle="modal" data-target=".bd-example-modal-lg" ><b>Log</b></a></p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <fieldset class="form-group">
                        <table class="table display table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td><b>Model Name :</b></td>
                                    <td>{{ $finance->modal_name}}</td>
                                    <td><b>S No. :</b></td>
                                    <td>{{ $finance->sno}}</td>
                                </tr>
                                <tr>
                                    <td><b>Company Name :</b></td>
                                    <td>{{$finance->company_name}}</td>
                                    <td><b>Kgs :</b></td>
                                    <td>{{$finance->kgs}}</td>
                                </tr>
                                <tr>
                                    <td><b> Name :</b></td>
                                    <td>{{$finance->name}}</td>
                                    <td><b>Amount :</b></td>
                                    <td>{{$finance->amount}}</td>

                                </tr>
                             
                            </tbody>
                        </table>
                    </fieldset>
                    @if($finance)
                    <div class="row row-sm">
                         <div class="col-12">
                            <div class="form-group">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0">Problem :
                                        <small>{{$finance->problem}}</small> </h6>
                                   <br>
                                    <h6 class="fs-17 font-weight-600 mb-0">Solution :
                                        <small>{{$finance->solution}}</small> </h6>
                                        <hr>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    @endif
                    <form method="post" action="{{ url('account/update')}}" enctype="multipart/form-data">
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent
                      
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Finance Status</label>
                                    <select name="status" id="exampleFormControlSelect2" class="form-control">
                                        <!--placeholder-->
                                        @if(Request::is('finance/view/*'))
                                        @if($finance->status=='0')
                                        <option value="0">Pending</option>
                                        <option value="2">Reject</option>
                                        <option value="1">Approve</option>
                                      
                        
                        
                                        @elseif($finance->status=='2')
                                        <option value="2">Reject</option>
                                        <option value="1">Approve</option>
                                        <option value="0">Active</option>
                                       
                                        @else
                                        <option value="1">Approve</option>
                                        <option value="2">Reject</option>
                                         <option value="0">Active</option>
                        
                                        @endif
                                        @else
                        
                                        <option value="1">Approve</option>
                                        <option value="2">Reject</option>
                                         <option value="0">Active</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-6" style='display:none;' id='designation'>
                                <div class="form-group">
                                    <label class="font-weight-600">Comment</label>
                                    <input type="text" name="comment" value="{{$finance->comment}}" class="form-control" 
                                        placeholder="Enter Comment"></input>
                                    <input type="text" hidden name="id" value="{{$id}}" class="form-control" 
                                        placeholder="Enter Comment"></input>
                                </div>
                            </div>
                            @if(Auth::user()->role_id == 16)
                            <div class="col-6" >
                                <div class="form-group">
                                    <label class="font-weight-600">Comment</label>
                                    <input type="text" disabled name="comment" value="{{$finance->comment}}" class="form-control" 
                                        placeholder="Enter Comment"></input>
                                    <input type="text" hidden name="id" value="{{$id}}" class="form-control" 
                                        placeholder="Enter Comment"></input>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if(Auth::user()->teammember_id == 23) 
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('finance') }}">
                                Back</a>
                        
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
     
            <div class="modal-header" style="background:#37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Finance log</h5>
                <div>
                    <ul>
                        @foreach ($errors->all() as $e)
                        <li style="color:red;">{{$e}}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body">
                <div class="table-responsive">

                    <table class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
								<th>Vendor</th>
								<th>Refrence</th>
								<th>Bill</th>
                                <th>Issue</th>
                                <th>Solution</th>
                                <th>Comment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assetlog as $assetlog)
                          <tr>
                              <td>{{ $assetlog->description ??''}}</td>
                              <td>{{ $assetlog->amount ??''}}</td>
							    <td>{{ $assetlog->vendor ??''}}</td>
							   <td>{{ $assetlog->refrence ??''}}</td>
							   <td> <a  href="{{ Storage::disk('s3')->temporaryUrl('assetbill/'.$assetlog->bill, now()->addMinutes(3)) }}"
                                                    target="blank">{{ $assetlog->bill ??''}}</a></td>
                              <td>{{ $assetlog->problem ??''}}</td>
                              <td>{{ $assetlog->solution ??''}}</td>
                              <td>{{ $assetlog->comment ??''}}</td>
                              <td>{{ date('F d,Y', strtotime($assetlog->created_at)) }}   {{ date('h:i A', strtotime($assetlog->created_at)) }}</td>
                          </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
       
    </div>
</div>
</div>
@endsection
