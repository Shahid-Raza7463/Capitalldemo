<style>
    /* component */

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        font-size: 1.5em;
        justify-content: space-around;
        padding: 0 .2em;
        text-align: center;
        width: 8em;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        color: #ccc;
        cursor: pointer;
    }

    .star-rating :checked~label {
        color: #f90;
    }

    .star-rating label:hover,
    .star-rating label:hover~label {
        color: #fc0;
    }

    /* explanation */

    article {
        background-color: #ffe;
        color: #006;
        font-family: cursive;
        font-style: italic;
        margin: 4em;
        max-width: 30em;
        padding: 2em
    }

</style>
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('ca-applications')}}">Back</a></li>

        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>CA
                    Details</small>
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:510px;">
                <div class="card-body">
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Name : </b></td>
                                    <td>{!! $ca->name !!}</td>
                                    <td><b>Gender : </b></td>
                                    <td>{{ $ca->gender}}</td>
                                    <td><b>Age : </b></td>
                                    <td>{!! $ca->age !!}</td>
                                </tr>
                                <tr>
                                    <td><b>Address : </b></td>
                                    <td>{!! $ca->address !!}</td>
                                    <td><b>Email : </b></td>
                                    <td>{!! $ca->email !!}</td>
                                    <td><b>Contact No : </b></td>
                                    <td>{!! $ca->contact_no !!}</td>
                                </tr>
                                <tr>
                                    <td><b>Marks 12 : </b></td>
                                    <td>{!! $ca->marks_12 !!}</td>
                                    <td><b>Year : </b></td>
                                    <td>{!! $ca->year_12 !!}</td>
                                    <td><b>Work Experience : </b></td>
                                    <td>{!! $ca->work_experience !!}</td>
                                </tr>
                                <tr>

                                    <td><b>Reference : </b></td>
                                    <td>{!! $ca->reference !!}</td>
                                    <td><a target='blank'
                                            href="{{'https://kgsomani.com/media/'.$ca->resume ??'' }}">{{   str_ireplace('documents/job_applications/chartered_accountant/','',$ca->resume) ??'' }}
                                    </td>
                                    <td><b>Remarks : </b></td>
                                    <td>{!! $ca->remarks !!}</td>

                                </tr>
                                <tr>

                                    <td><b>Applied On : </b></td>
                                    <td>{{ date('F d,Y', strtotime($ca->applied_on)) }}</td>
                                    <td><b>Overall Rating</b></td>

                                    @if(Auth::user()->teammember_id == $ca->interviewerone &&
                                    $ca->ratingone == null )
                                    <form method="post" action="{{ url('/carating')}}" enctype="multipart/form-data">
                                        @csrf
                                        <td>

                                            <div class="star-rating ">
                                                <input type="radio" id="10-stars" name="rating" value="10" />
                                                <label for="10-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="9-stars" name="rating" value="9" />
                                                <label for="9-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="8-stars" name="rating" value="8" />
                                                <label for="8-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="7-stars" name="rating" value="7" />
                                                <label for="7-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="6-stars" name="rating" value="6" />
                                                <label for="6-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="5-stars" name="rating" value="5" />
                                                <label for="5-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="4-stars" name="rating" value="4" />
                                                <label for="4-stars" class="star">&#9733;</label>
                                                <input type="radio" id="3-stars" name="rating" value="3" />
                                                <label for="3-stars" class="star">&#9733;</label>
                                                <input type="radio" id="2-stars" name="rating" value="2" />
                                                <label for="2-stars" class="star">&#9733;</label>
                                                <input type="radio" id="1-star" name="rating" value="1" />
                                                <label for="1-star" class="star">&#9733;</label>

                                            </div>

                                            <input hidden type="text" class="form-control" name="sno"
                                                value="{{ $ca->sno ??''}}" />
                                        </td>

                                        <td>
                                            <textarea rows="2" name="feedback" style="width: 161px;"
                                                class="form-control" placeholder="Enter Feedback"></textarea></td>
                                        <td> <button type="submit" class="btn btn-success">Save</button></td>
                                    </form>
                                    @endif
                                    @if(Auth::user()->teammember_id == $ca->interviewertwo &&
                                    $ca->ratingtwo == null )
                                    <form method="post" action="{{ url('/carating')}}" enctype="multipart/form-data">
                                        @csrf
                                        <td>

                                            <div class="star-rating ">
                                                <input type="radio" id="10-stars" name="rating" value="10" />
                                                <label for="10-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="9-stars" name="rating" value="9" />
                                                <label for="9-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="8-stars" name="rating" value="8" />
                                                <label for="8-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="7-stars" name="rating" value="7" />
                                                <label for="7-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="6-stars" name="rating" value="6" />
                                                <label for="6-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="5-stars" name="rating" value="5" />
                                                <label for="5-stars" class="star ">&#9733;</label>
                                                <input type="radio" id="4-stars" name="rating" value="4" />
                                                <label for="4-stars" class="star">&#9733;</label>
                                                <input type="radio" id="3-stars" name="rating" value="3" />
                                                <label for="3-stars" class="star">&#9733;</label>
                                                <input type="radio" id="2-stars" name="rating" value="2" />
                                                <label for="2-stars" class="star">&#9733;</label>
                                                <input type="radio" id="1-star" name="rating" value="1" />
                                                <label for="1-star" class="star">&#9733;</label>

                                            </div>

                                            <input hidden type="text" class="form-control" name="sno"
                                                value="{{ $ca->sno ??''}}" />
                                        </td>

                                        <td>
                                            <textarea rows="2" name="feedback" style="width: 161px;"
                                                class="form-control" placeholder="Enter Feedback"></textarea></td>
                                        <td> <button type="submit" class="btn btn-success">Save</button></td>
                                    </form>
                                    @endif
                                    @if($ca->ratingone != null && Auth::user()->teammember_id ==
                                    $ca->interviewerone)
                                    <td>
                                        @for($i=0;$i<$ca->ratingone;$i++)
                                            <span class="fa fa-star checked" style="color: #f90"></span>
                                            @endfor</td>
                                    @endif
                                    @if($ca->ratingtwo != null && Auth::user()->teammember_id ==
                                    $ca->interviewertwo)
                                    <td>
                                        @for($i=0;$i<$ca->ratingtwo;$i++)
                                            <span class="fa fa-star checked" style="color: #f90"></span>
                                            @endfor</td>
                                    @endif
                                </tr>


                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>


        </div>
    </div>

</div>
@endsection
