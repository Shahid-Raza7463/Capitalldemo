@extends('backEnd.layouts.layout') @section('backEnd_content')

        <div class="body-content">
            <div class="row">
                <div class="col-md-12 col-lg-2">
                    
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header" style="background: #37A000">
                            <div style="text-align: center">
                                <div>
                                    <h6 style="color: white" class="fs-17 font-weight-600 mb-0"><b>Open Ticket</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('generateticket/store')}}" enctype="multipart/form-data">
                                @csrf
            
                                @if(session()->has('success'))
                                <div class="alert alert-success">
                                    @if(is_array(session()->get('success')))
                                    @foreach (session()->get('success') as $message)
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
                                <div class="form-group row">
                                    <label for="staticEmail"
                                        class="col-sm-3 col-form-label font-weight-600">Model :</label>
                                        <input type="text" hidden name="asset_id" class="form-control-plaintext" id="staticEmail"
                                            value="{{ $ticket->id }}">
                                    <div class="col-sm-9">
                                        <label style="margin-top:9px;">
                                        {{ $ticket->modal_name}}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail"
                                        class="col-sm-3 col-form-label font-weight-600">Sno :</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="" class="form-control-plaintext" id="staticEmail"
                                            value="{{ $ticket->sno }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail"
                                        class="col-sm-3 col-form-label font-weight-600">Description :</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="" class="form-control-plaintext" id="staticEmail"
                                            value="   {!! $ticket->description !!}">
                                    </div>
                                </div>
								 <div class="form-group row">
                                    <label for="inputPassword"
                                        class="col-sm-3 col-form-label font-weight-600">Concern :</label>
                                    <div class="col-sm-9">
                                        <select name="type" required class="form-control">
                              
                                            <option value="">Please Select One</option>
                                            <option value="0">IT</option>
                                            <option value="1">Accounts/Finance</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword"
                                        class="col-sm-3 col-form-label font-weight-600">Subject :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="subject" class="form-control" id="inputPassword"
                                            placeholder="Enter Subject">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword"
                                        class="col-sm-3 col-form-label font-weight-600">Priority :</label>
                                    <div class="col-sm-9">
                                        <select name="priority" class="form-control">
                                            <option>Select Priority</option>
                                            <option value="0">High</option>
                                            <option value="1">Medium</option>
                                            <option value="2">Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword"
                                        class="col-sm-3 col-form-label font-weight-600">Message :</label>
                                    <div class="col-sm-9">
                                            <textarea rows="6" name="message" value="" class="form-control"
                                                placeholder="Enter Message"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword"
                                        class="col-sm-3 col-form-label font-weight-600">Attachment :</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="attachment" class="form-control" id="inputPassword"
                                            placeholder="Enter Message">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col-sm-5">
                                    </div>
                                    <div class="col-sm-4">
                                    <button class="btn btn-primary w-100p mb-2 mr-1" type="submit">Submit</button>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-2">
                </div>
                <div class="w-100"></div>

            </div>
        </div>
        <!--/.body content-->
    </div>
    <!--/.main content-->
</div>
<!--/.wrapper-->

<!--/.main content-->
@endsection
