@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Add Client Contact</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="@if(Request::is('client/contactedit/*'))
                        {{ url('client/contactupdate/'.$id) }}
                      @endif" enctype="multipart/form-data">
                 @csrf
                
                 @if(session()->has('status'))
                 <div class="alert alert-success">
                     @if(is_array(session()->get('status')))
                     @foreach (session()->get('status') as $message)
                     <p>{{ $message }}</p>
                     @endforeach
                     @else
                     <p>{{ session()->get('success') }}</p>
                     @endif
                 </div>
                 @endif
                 <div>
                     <ul>
                         @foreach ($errors->all() as $e)
                         <li style="color:red;">{{$e}}</li>
                         @endforeach
                     </ul>
                 </div>
                  <div class="row row-sm"> 
                  <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-600"> Name</label>
                        <input type="text" name="clientname" value="" class=" form-control"
                        placeholder="Enter Client Name">
                    <input type="text" name="client_id" hidden value="{{$client->id}}" class=" form-control"
                        placeholder="Enter Client Name">
                    </div>
                 </div>
                 <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-600"> Email</label>
                        <input type="text" name="clientemail" value="" class=" form-control"
                        placeholder="Enter Client Email">
                    </div>
                 </div>
                  </div>
                  <div class="row row-sm"> 
                    <div class="col-6">
                      <div class="form-group">
                          <label class="font-weight-600"> Phone</label>
                          <input type="text" name="clientphone" value="" class=" form-control"
                          placeholder="Enter Client Phone">
                      </div>
                   </div>
                   <div class="col-6">
                      <div class="form-group">
                          <label class="font-weight-600"> Designation</label>
                          <input type="text" name="clientdesignation" value="" class=" form-control"
                          placeholder="Enter Client Designation">
                      </div>
                   </div>
                    </div>
    <button type="submit" class="btn btn-success">Submit</button>

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
                           
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Designation</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contactDatas as $contactData)
                        <tr>
                      
                            <td>{{$contactData->clientname}}</td>
                            <td>{{$contactData->clientemail}}</td>
                            <td>{{$contactData->clientphone}}</td>
                            <td>{{$contactData->clientdesignation}}</td>
                            <td><a href="{{url('/client/destroy/'.$contactData->id)}}"
                                onclick="return confirm('Are you sure you want to delete this item?');"
                                class="btn btn-danger-soft btn-sm"><i
                                    class="far fa-trash-alt"></i></a>
                        </td>
                            
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection

