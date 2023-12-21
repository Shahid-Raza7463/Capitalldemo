<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Send Mail</a></li>
                <li class="breadcrumb-item active">+</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Draft Email list</small>
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
                    <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th> Date</th>
                                <th> Name</th>
                                <th> Email</th>
                                <th> Role</th>
                                <th> Reporting Head</th>
                                <th> Department</th>
                                <th> Designation</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($draftemail as $draftemailDatas)
                                <tr>
                                    <td style="display: none;">{{ $draftemailDatas->id }}</td>
                                    <td>{{ date('F d,Y', strtotime($draftemailDatas->created_at)) }}</td>
                                    <td>{{ $draftemailDatas->name }}</td>
                                    <td>{{ $draftemailDatas->email }}</td>
                                    <td>{{ $draftemailDatas->rolename }}</td>
                                    <td>{{ $draftemailDatas->team_member }}</td>
                                    <td>{{ $draftemailDatas->departmentname }}</td>
                                    <td>{{ $draftemailDatas->designation }}</td>
                                    <td>{{ date('F d,Y', strtotime($draftemailDatas->joiningdate)) }}</td>
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
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('draftemail.store') }}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Send Mail</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row row-sm">
                            <div class="col-sm-12">
                                <select class="form-control" id="entitySelect" name="entity">
                                    <option selected disabled value="">Please Select An Entity</option>
                                    <option value="K G Somani Co & LLP">K G Somani Co & LLP</option>
                                    <option value="CapiTall India Pvt. Ltd.">CapiTall India Pvt. Ltd.</option>
                                    <option value="KGS Advisors LLP">KGS Advisors LLP</option>
                                    <option value="Womennovator">Womennovator</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            <div class="col-sm-6">
                                <label for="name" class="font-weight-600">Name :</label>
                                <input required placeholder=" Enter Name" class="form-control" name="name"
                                    type="text">
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="font-weight-600">Email :</label>
                                <input id="contactemail" required placeholder=" Enter Email" class="form-control"
                                    name="email" type="text">

                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">

                            <div class="col-sm-6">
                                <label for="name" class="font-weight-600">Role :</label>
                                <select class="form-control" required id="roleSelect" name="role_id">
                                    <option value="">Please Select One</option>
                                    @foreach ($roles as $teamroleData)
                                        <option value="{{ $teamroleData->id }}">
                                            {{ $teamroleData->rolename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="font-weight-600">Department :</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="department_id">
                                    <option value="">Please Select One</option>
                                    @foreach ($department as $departmentData)
                                        <option value="{{ $departmentData->id }}">
                                            {{ $departmentData->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            <div class="col-sm-6">
                                <label for="name" class="font-weight-600">Reporting Head :</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="reportinghead">
                                    <option value="">Please Select One</option>
                                    @foreach ($teammember as $teamroleData)
                                        <option value="{{ $teamroleData->id }}">
                                            {{ $teamroleData->team_member }} ( {{ $teamroleData->role->rolename }} )
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="font-weight-600">Date Of Joining :</label>
                                <input placeholder=" Enter Joining date" class="form-control" name="joiningdate"
                                    type="date">
                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">

                            <div class="col-sm-12">
                                <label for="name" class="font-weight-600">Designation :</label>
                                <input placeholder=" Enter Designation" class="form-control" name="designation"
                                    type="text">
                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            <div class="col-sm-12">
                                <textarea rows="4" name="description" id="summernote" class="centered form-control" id="summernote"
                                    placeholder="Enter Description">
                                    <p>Congratulations once again on your Selection with KGS !</p>
                                    <p>As part of your journey with KGS, there are certain documents to be submitted, signed, and verified to initiate your Onboarding into the company.</p>
                                    <p>We suggest to please keep all your Educational and previous employers documents handy before starting the Documentation process. Please click this <a href="{{ url('candidateonboardingform') }}" id="link"><span style="color:blue;">link</span></a> to submit the required documents, and start right away with all the steps assigned to you. For any doubts or clarifications, please feel free to ping us.  </p>
                                    <p>Happy Onboarding!</p>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{ url('backEnd/ckeditor/ckeditor.js') }}"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>

    <script>
        $(document).ready(function() {
            // Listen for changes in the entity selection
            $('#entitySelect').change(function() {
                updateTextareaContent();
                //updateLink();
            });

            // Listen for changes in the role selection
            $('#roleSelect').change(function() {
                updateLink();
            });

            function updateTextareaContent() {
                // Get the selected entity value
                var selectedEntity = $('#entitySelect').val();

                // Update the textarea content based on the selected entity
                switch (selectedEntity) {
    case 'CapiTall India Pvt. Ltd.':
        $('#summernote').summernote(
            'code',
            '<p>Congratulations once again on your Selection with CapiTall India Pvt. Ltd.!</p><p>As part of your journey with CapiTall India Pvt. Ltd., there are certain documents to be submitted, signed, and verified to initiate your Onboarding into the company.</p><p>We suggest to please keep all your Educational and previous employers documents handy before starting the Documentation process. Please click this <a href="{{ url('candidateonboardingform') }}" id="link"><span style="color:blue;">link</span></a> to submit the required documents, and start right away with all the steps assigned to you. For any doubts or clarifications, please feel free to ping us.</p><p>Happy Onboarding!</p>'
        );
        break;
    case 'K G Somani Co & LLP':
        $('#summernote').summernote(
            'code',
            '<p>Congratulations once again on your Selection with K G Somani Co & LLP!</p><p>As part of your journey with K G Somani Co & LLP, there are certain documents to be submitted, signed, and verified to initiate your Onboarding into the company.</p><p>We suggest to please keep all your Educational and previous employers documents handy before starting the Documentation process. Please click this <a href="{{ url('candidateonboardingform') }}" id="link"><span style="color:blue;">link</span></a> to submit the required documents, and start right away with all the steps assigned to you. For any doubts or clarifications, please feel free to ping us.</p><p>Happy Onboarding!</p>'
        );
        break;
    case 'KGS Advisors LLP':
        $('#summernote').summernote(
            'code',
            '<p>Congratulations once again on your Selection with KGS Advisors LLP!</p><p>As part of your journey with KGS Advisors LLP, there are certain documents to be submitted, signed, and verified to initiate your Onboarding into the company.</p><p>We suggest to please keep all your Educational and previous employers documents handy before starting the Documentation process. Please click this <a href="{{ url('candidateonboardingform') }}" id="link"><span style="color:blue;">link</span></a> to submit the required documents, and start right away with all the steps assigned to you. For any doubts or clarifications, please feel free to ping us.</p><p>Happy Onboarding!</p>'
        );
        break;
    case 'Womennovator':
        $('#summernote').summernote(
            'code',
            '<p>Congratulations once again on your Selection with Womennovator!</p><p>As part of your journey with Womennovator, there are certain documents to be submitted, signed, and verified to initiate your Onboarding into the company.</p><p>We suggest to please keep all your Educational and previous employers documents handy before starting the Documentation process. Please click this <a href="{{ url('candidateonboardingform') }}" id="link"><span style="color:blue;">link</span></a> to submit the required documents, and start right away with all the steps assigned to you. For any doubts or clarifications, please feel free to ping us.</p><p>Happy Onboarding!</p>'
        );
        break;
    default:
        // If no entity is selected or an invalid selection is made, show a default message
        $('#summernote').summernote(
            'code',
            '<p>Congratulations once again on your Selection with KGS!</p><p>As part of your journey with KGS, there are certain documents to be submitted, signed, and verified to initiate your Onboarding into the company.</p><p>We suggest to please keep all your Educational and previous employers documents handy before starting the Documentation process. Please click this <a href="{{ url('candidateonboardingform') }}" id="link"><span style="color:blue;">link</span></a> to submit the required documents, and start right away with all the steps assigned to you. For any doubts or clarifications, please feel free to ping us.</p><p>Happy Onboarding!</p>'
        );
}

            }

            function updateLink() {
                // Get the selected role value
                var selectedRole = $('#roleSelect').val();

                // Get the selected entity value
                var selectedEntity = $('#entitySelect').val();

                // Update the link based on the selected role and entity
                var link = '';
                switch (selectedRole) {
                    case '15':
                        if (selectedEntity === 'CapiTall India Pvt. Ltd.') {
                            link = 'https://kgs.capitall.io/articleonboardingform';
                        } else if (selectedEntity === 'K G Somani Co & LLP') {
                            link = 'https://kgs.capitall.io/articleonboardingform';
                        } else if (selectedEntity === 'KGS Advisors LLP') {
                            link = 'https://kgs.capitall.io/articleonboardingform';
                        } else if (selectedEntity === 'Womennovator') {
                            link = 'https://kgs.capitall.io/articleonboardingform';
                        }
                        break;
                    case '19':
                        if (selectedEntity === 'CapiTall India Pvt. Ltd.') {
                            link = 'https://kgs.capitall.io/candidateonboardingform/intern/kgs';
                        } else if (selectedEntity === 'K G Somani Co & LLP') {
                            link = 'https://kgs.capitall.io/candidateonboardingform/intern/kgs';
                        } else if (selectedEntity === 'KGS Advisors LLP') {
                            link = 'https://kgs.capitall.io/candidateonboardingform/intern/kgs-advisors';
                        } else if (selectedEntity === 'Womennovator') {
                            link = 'https://kgs.capitall.io/candidateonboardingform/intern/womennovator';
                        }
                        break;
                    default:
                        if (selectedEntity === 'CapiTall India Pvt. Ltd.') {
                            link = 'https://kgs.capitall.io/candidateonboardingform/kgs';
                        } else if (selectedEntity === 'K G Somani Co & LLP') {
                            link = 'https://kgs.capitall.io/candidateonboardingform/kgs';
                        } else if (selectedEntity === 'KGS Advisors LLP') {
                            link = 'https://kgs.capitall.io/candidateonboardingform/kgs-advisors';
                        } else if (selectedEntity === 'Womennovator') {
                            link = 'https://kgs.capitall.io/candidateonboardingform/womennovator';
                        }
                        break;
                }

                // Replace the link and entity text
                $('#link').attr('href', link);
                //$('#link').text(link);
                $('#entityText').text(selectedEntity);
            }
        });
    </script>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
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
