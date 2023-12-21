<div class="row row-sm ">
    <div class="col-12">
        <table class="table table-bordered">
        <fieldset class="form-group">
            <tbody>
            <tr>
                <td><b>Name</b></td>
                <td>
                <select class="form-control basic-multiple language" name="teammember_ids" 
                @if(Request::is('performanceevaluationform/*/edit'))>  
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}"
                    {{$performanceevaluation->teammember_ids== $teammemberData->id??'' ?'selected="selected"' : ''}}>
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </td>
                <td><b>TEAM MANAGER/PARTNER</b></td>
                <td>
                <select class="form-control basic-multiple language" name="partner_id" 
                @if(Request::is('performanceevaluationform/*/edit'))>  
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}"
                    {{$performanceevaluation->partner_id== $teammemberData->id??'' ?'selected="selected"' : ''}}>
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select> 
               </td>                
               </tr>
               <tr>
                <td><b>DATE OF JOINING</b></td>
                <td><input type="date" name="date_of_joining" value="{{$performanceevaluation->date_of_joining ??''}}"
                class="form-control"></td>
                <td><b>DESIGNATION</b></td>
                <td><input type="text" name="designation" placeholder="Enter Designation" value="{{$performanceevaluation->designation ??''}}"
                class="form-control"></td>
               </tr>
               <tr>
                <td><b>DEPARTMENT</b></td>
                <td><input type="text" name="department" value="{{$performanceevaluation->department ??''}}" placeholder="Enter Department"
                class="form-control"></td>
                <td><b>DATE OF REVIEW</b></td>
                <td><input type="date" name="date_of_review" placeholder="Enter Date of Review" value="{{$performanceevaluation->date_of_review ??''}}"
                class="form-control">
              </td>
               </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row row-sm ">
    <div class="col-12"><br>
    <h4 style="color:green;" class="fs-16 font-weight-600 mb-0">MEASUREMENT RATING CRITERIA</h4>
    <h4 style="color:green; text-align:center;" class="fs-16 font-weight-600 mb-0">RATINGS SCALES</h4>
        <table class="table table-bordered">
        <fieldset class="form-group">
            <tbody>
            <tr>
                <td colspan="5" style="text-align:center;"><b>Rating Level</b></td>
               </tr>
               <tr>
                <td><b>1 = Below Standards</b><br><br><br> 
Performance is below standards. Employee does not fully achieve assigned goals. Work assignments are not consistent in meeting quality standards or deadlines. Employee requires close supervision and does not consistently demonstrate the ability to perform job functions at expected level of proficiency.
</td>
                <td><b>2 = Requires Improvement</b><br><br><br>

Performance of some job requirements is unacceptable and does not achieve results expected by the department. Incidents of problem work performance are not typical in the class of work performed and improvement is required.

                </td>
                <td><b>3 = Meets Expectations</b><br><br><br>
Satisfactorily performs assigned activities and achieves expected outcomes. Work assignments typically are completed and meet all quality standards. Employee works under general supervision, with demonstrated.
understanding of all job functions and expected standards.
</td>
                <td>
                <b>4 = Exceeds Requirements</b><br><br><br>
Performance of job requirements exceeds established expectations or requirements for quality, quantity, and timeliness; and while performance at this level can still be improved, and employee at this level exceeds the performance expected of a fully capable employee in most aspects of job performance.
                
                </td>
                <td>
                <b>5 = Superior</b><br><br><br>
Performance of job requirements noticeably exceed established expectations and standards for quality, quantity and timeliness: outcomes are well above fully competent performance; performs more than asked explores improved methods of accomplishing tasks, and small room for improvement.

                </td>
               </tr>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12"><br>
        <table class="table table-bordered">
        <fieldset class="form-group">
            <tbody>
            <tr>
                <td colspan="5" style="text-align:center;"><b>Section I - Key Responsibility Areas</b></td>    
            </tr>
            </tbody>
        </table>
        <h4 style="color:green;" class="fs-16 font-weight-600 mb-0">
               List down the Key responsibility Areas and the outcome or achievements linked with those KRAs. Employees to mention the Key Responsibilities, outcome/achievements linked with those KRAs and give self-rating.
(Important Note - </h4><span>Be specific and use numbers only while mentioning the outcomes for your Business Development/Marketing Targets etc. Take note of your achievements throughout the year)
</span>
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12">
        <table class="table table-bordered">
            <tr style="background: #37A000;color:#F4F4F5;">
               <th>Sr.No</th>    
                <th>KEY RESPONSIBILITY</th>
                <th>OUTCOME/ACHIEVEMENT</th>
                <th>SELF RATING </th>
                <th>REPORTING MANAGER/PARTNER’S RATING </th>
                <th> <button type="button" name="add_row" id="add_row"><i class="fe fe-plus"></i><img
                        src="{{ url('backEnd/image/add-icon.png')}}" /></button></th>
            </tr>
            <tbody id="performanceevaluation">
                <td><span id="sr_no">1</span></td>
                <td><input type="text" value="{{$performanceDatas->key_responsibility ??''}}" name="key_responsibility[]" data-srno="1" placeholder="Enter key Responsibility" class="form-control" /></td>
                <td><input type="text" value="{{$performanceDatas->outcome_achievement ??''}}" name="outcome_achievement[]" data-srno="1" placeholder="Enter Outcome Achievement" class="form-control" />
                </td>
                <td><input type="number" value="{{$performanceDatas->self_rating ??''}}" name="self_rating[]" data-srno="1" placeholder="Enter Self Rating" class="form-control" />
                </td>
                <td><input type="number" value="{{$performanceDatas->reporting_rating ??''}}" name="reporting_rating[]" data-srno="1" placeholder="Enter Reporting Manager Rating" class="form-control" />
                </td>
               <td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>
        </tbody>
       
        </table>
    </div>
</div>
<br>
<div class="row row-sm">
<div class="col-12">
        <div class="form-group">
            <h4 class="fs-16 font-weight-600 mb-0">
(FOR REPORTING PARTNERS) - Section I = Total Rating: &nbsp;&nbsp;&nbsp; 
<input type="number" readonly name="section_total_rating" placeholder="Enter Total Rating" 
     value="" class="form">&nbsp;
    <small>(Add “Final Ratings” for each responsibility, then divide by total number of Key Responsibilities) 
   </small>
</h4>
        </div>
    </div>
</div>
<br>
<div class="row row-sm">
<div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Employee’s Comments on KRAs/achievements (If any):</label>
            <textarea type="text" name="employee_kra_achievement" placeholder="Enter Employee’s Comments on KRAs/achievements (If any):" value="" class="form-control">
            {{$performanceevaluation->employee_kra_achievement ??''}}
            </textarea>
        </div>
    </div>
</div>
<br>
<div class="row row-sm">
<div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Supervisor’s Comments on KRAs/ achievements (If any):</label>
            <textarea type="text" name="supervisor_kra_achievement" placeholder="Enter Supervisor’s Comments on KRAs/ achievements (If any):" 
             class="form-control">{{$performanceevaluation->supervisor_kra_achievement ??''}}</textarea>
        </div>
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12"><br>
        <table class="table table-bordered">
        <fieldset class="form-group">
            <tbody>
            <tr>
                <td colspan="5" style="text-align:center;"><b>SECTION II - PERFORMANCE FACTORS</b></td>
                     
               </tr>
            </tbody>
        </table>
        <h4 class="fs-16 font-weight-600 mb-0">
        The following factors are important indicators of the skills and abilities an employee brings to the performance of his or her duties. In addition to evaluating key responsibilities and performance objectives, these performance factors help to assess total performance
    <br><br>
    Self-rating may be given by the employees, The supervisor rates the degree – <br>
    1. Below Standards/Expectations<br> 
    2 Requires Improvement <br>
    3 Meets Expectations <br>
    4. Exceeds Expectations <br>
    5. Superior 
    </h4>
    
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12"><br>
    <table class="table table-bordered">
                                <fieldset class="form-group">
                                    <tbody>
                                        <tr>
                                            <td><b>Performance Factors</b></td>
                                            <td><b>Applies</b></td>
                                            <td><b>Not Applicable</b></td>
                                            <td><b>Self -Rating</b></td>
                                            <td><b>Supervisor Rating</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    PROFICIENCY IN CURRENT ROLE:</b><br><br>
                                                <span>
                                                    • Demonstrates knowledge of position and/or team role.<br>
                                                    • Understands how position and responsibilities fit within the
                                                    &nbsp;&nbsp;&nbsp;organization and contribute to department results.
                                                </span>
                                            </td>
                                            <td><input type="text"  name="proficiency_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->proficiency_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="proficiency_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->proficiency_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="proficiency_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->proficiency_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="proficiency_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->proficiency_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    QUALITY OF WORK:</b><br><br>
                                                <span>• Maintains standards consistently. Is consistent in achieving
                                                    accuracy.<br>
                                                    • neatness, thoroughness, overall effectiveness and attentiveness to
                                                    detail.

                                                </span>
                                            </td>
                                            <td><input type="text"  name="quality_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->quality_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="quality_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->quality_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="quality_self_rating"
                                                    placeholder="Enter Self Rating"
                                                    value="{{$performanceevaluation->quality_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="quality_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->quality_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    QUANTITY OF WORK:</b><br><br>
                                                <span>
                                                    • Produces expected volume of work in a timely manner.
                                                </span>
                                            </td>
                                            <td><input type="text"  name="quantity_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->quantity_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="quantity_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->quantity_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="quantity_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->quantity_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="quantity_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->quantity_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    PLANNING AND ORGANIZATION OF WORK:</b><br><br>
                                                <span>
                                                    • Establishes priorities. Anticipates and prepares for changing
                                                    workload or working conditions.<br>
                                                    • Coordinates and uses available resources to get work done to
                                                    assure important deadlines are met.
                                                </span>
                                            </td>
                                            <td><input type="text"  name="planning_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->planning_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="planning_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->planning_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="planning_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->planning_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="planning_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->planning_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    INITIATIVE:</b><br><br>
                                                <span>
                                                    • Shows ability to work independently in context of the job.<br>
                                                    • Demonstrates willingness to assume additional responsibility.<br>
                                                    • Suggests ways to enhance work processes or operations.
                                                </span>
                                            </td>
                                            <td><input type="text"  name="initiative_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->initiative_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="initiative_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->initiative_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="initiative_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->initiative_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="initiative_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->initiative_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    INTERPERSONAL RELATIONS:</b><br><br>
                                                <span>
                                                    • Maintains positive working relationships.<br>
                                                    • Is flexible and willing to cooperate with others.<br>
                                                    • Demonstrates ability to listen and understand.

                                                </span>
                                            </td>
                                            <td><input type="text"  name="interpersonal_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->interpersonal_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="interpersonal_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->interpersonal_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="interpersonal_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->interpersonal_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="interpersonal_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->interpersonal_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    VERBAL & LISTENING SKILLS:</b><br><br>
                                                <span>
                                                    • Expresses self well verbally, using language appropriate for the
                                                    intended audience.<br>
                                                    • Listens actively and acknowledges understanding.

                                                </span>
                                            </td>
                                            <td><input type="text"  name="verbal_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->verbal_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="verbal_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->verbal_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="verbal_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->verbal_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="verbal_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->verbal_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    WRITING SKILLS:</b><br><br>
                                                <span>
                                                    • Presents ideas clearly in written format, using appropriate
                                                    language, grammar and style.
                                                </span>
                                            </td>
                                            <td><input type="text"  name="writing_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->writing_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="writing_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->writing_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="writing_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->writing_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="writing_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->writing_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    TEAM PARTICIPATION:</b><br><br>
                                                <span>
                                                    • Proactively builds partnerships and seeks involvement with other
                                                    constituencies/employees & Works cooperatively and effectively with
                                                    team members.<br>
                                                    • Demonstrates clear understanding of team goals and contributes to
                                                    their achievement.
                                                </span>
                                            </td>
                                            <td><input type="text"  name="team_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->team_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="team_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->team_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="team_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->team_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="team_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->team_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    DISCRETION AND CONFIDENTIALITY</b><br><br>
                                                <span>
                                                    • Demonstrates ability to maintain sensitive information in
                                                    confidence, sharing only with appropriate contacts.
                                                </span>
                                            </td>
                                            <td><input type="text"  name="discretion_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->discretion_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="discretion_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->discretion_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="discretion_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->discretion_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="discretion_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->discretion_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    PEOPLE MANAGEMENT/TEAM MANAGEMENT</b><br><br>

                                            </td>
                                            <td><input type="text"  name="people_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->people_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="people_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->people_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="people_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->people_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="people_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->people_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    LEVEL OF EFFORTS</b><br><br>
                                                <span>
                                                    • Is self-motivated and maintains effort despite obstacles and
                                                    setback
                                                </span>
                                            </td>
                                            <td><input type="text"  name="level_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->level_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="level_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->level_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="level_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->level_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="level_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->level_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                    COMMITMENT TO SERVICE</b><br><br>
                                            </td>
                                            <td><input type="text"  name="commitment_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->commitment_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="commitment_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->commitment_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="commitment_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->commitment_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="commitment_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->commitment_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>PUNCTUALITY AND ATTENDANCE:</b><br><br>
                                                <span>
                                                    • Arrives and is ready to begin working at scheduled time.<br>
                                                    • Maintains acceptable record of attendance.
                                                </span>
                                            </td>
                                            <td><input type="text"  name="punctuality_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->punctuality_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="punctuality_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->punctuality_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="punctuality_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->punctuality_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="punctuality_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->punctuality_supervison_rating ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TECHNICAL SKILLS</b><br><br>
                                            </td>
                                            <td><input type="text"  name="technical_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->technical_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="technical_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->technical_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="technical_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$performanceevaluation->technical_self_rating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number"  name="technical_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$performanceevaluation->technical_supervison_rating ??''}}"
                                                    class="form-control"></td>

                                        </tr>


                                        <tr>
                                            <td><b>Total</b><br><br>
                                            </td>
                                            <td><input type="text" name="total_applies"
                                                    placeholder="Enter Applies"
                                                    value="{{$performanceevaluation->total_applies ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="text"  name="total_not_applicable"
                                                    placeholder="Enter Not Applicable"
                                                    value="{{$performanceevaluation->total_not_applicable ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="total_self_rating"
                                                    placeholder="Enter Self -Rating"
                                                    value="{{$totalsumrating ??''}}"
                                                    class="form-control"></td>
                                            <td><input type="number" readonly name="total_supervison_rating"
                                                    placeholder="Enter Supervisor Rating"
                                                    value="{{$totalsum ??''}}"
                                                    class="form-control"></td>
                                        </tr>
                                    </tbody>
                            </table>
    </div>
</div>
<br>
<div class="row row-sm">
<div class="col-12">
        <div class="form-group">
            <h4 class="fs-16 font-weight-600 mb-0">
            (FOR REPORTING PARTNERS) Section II - Total Rating: &nbsp;&nbsp;&nbsp; 
<input type="number" readonly name="section2_rating" placeholder="Enter Total Rating" value="{{$performanceevaluation->section2_rating ??''}}"
                class="form">&nbsp;
    <small>(Add “Final/Supervisors Ratings” for each factor, then divide by total number of factors applied) 
   </small>
</h4>
        </div>
    </div>
</div>
<div class="row row-sm">
<div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Employee’s Comments on Performance Factors (If any):</label>
            <textarea type="text" name="employee_factors" placeholder="Enter Employee’s Comments on Performance Factors (If any)" class="form-control">
            {{$performanceevaluation->employee_factors ??''}}
            </textarea>
        </div>
    </div>
</div>
<br>
<div class="row row-sm">
<div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Supervisor’s Comments on Performance Factors (If any):</label>
            <textarea type="text" name="supervisor_factors" placeholder="Enter Supervisor’s Comments on Performance Factors (If any)" class="form-control">
            {{$performanceevaluation->supervisor_factors ??''}}
            </textarea>
        </div>
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12"><br>
        <table class="table table-bordered">
        <fieldset class="form-group">
            <tbody>
            <tr>
                <td colspan="5" style="text-align:center;"><b>Section III - DEVELOPMENT GOALS (To be filled by REPORTING PARTNERS)</b></td>
                     
               </tr>
            </tbody>
        </table>
        <h4 class="fs-16 font-weight-600 mb-0">
        This section should include the development goals which are to be achieved in the future performance. These may include formal training or education courses, temporary project assignments or mentoring programs, enhancement on any specific performance factor. This should include an assessment of how much a priority the development goal is: (C) = Critical; (M) = Moderate; and (VA) = Value Added. 
        </h4>
    
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12">
        <table class="table table-bordered">
            <tr style="background: #37A000;color:#F4F4F5;">
            <th>Sr.No</th>   
            <th>Development Goals/Purpose</th>    
                <th>Priority</th>
                <th> <button type="button" name="add_row" id="add_row1"><i class="fe fe-plus"></i><img
                        src="{{ url('backEnd/image/add-icon.png')}}" /></button></th>
            </tr>
            <tbody id="performancesector">
                <td><span id="sr_no">1</span></td>
                <td><input type="text" value="{{$performancepartDatas->development ??''}}" name="development[]" data-srno="1" placeholder="Enter Development Goals/Purpose" class="form-control" /></td>
                <td><input type="text" value="{{$performancepartDatas->priority ??''}}" name="priority[]" data-srno="1" placeholder="Enter Priority" class="form-control" />
                </td>
               <td><button type="button" name="remove_row1" id="'+count+'" class="btn btn-danger btn-xs remove_row1">X</button></td>
        </tbody>
        </table>
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12"><br>
        <table class="table table-bordered">
        <fieldset class="form-group">
            <tbody>
            <tr>
                <td colspan="5" style="text-align:center;"><b>Section IV - OVERALL PERFORMANCE RATING (To be filled by REPORTING PARTNERS only)</b></td>       
               </tr>
            </tbody>
        </table>
        <h4 class="fs-16 font-weight-600 mb-0">
        Enter the Total Ratings for KRAs (Section I) and Performance Factors (Section II). Add the Total Ratings and divide the sum by 2 to calculate the Overall Rating.    
       </h4>
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12">
        <table class="table table-bordered">
            <tbody>
            <tr>
              <td><b></b></td>
              <td><b>Total Rating</b></td>
           </tr>
           <tr>
              <td><b>(a) Section I: Key Responsibilities (Section I)</b></td>
              <td><input type="number" readonly name="resp_applicable" placeholder="Enter Not Applicable" 
              value="{{$performanceevaluation->resp_applicable ??''}}" class="form-control">
            </td>
           </tr>
           <tr>
              <td><b>(b) Section II: Performance Factors (Section II)	(b)</b></td>
              <td><input type="number" readonly name="performance_factor" placeholder="Enter Not Applicable" 
              value="{{$performanceevaluation->performance_factor ??''}}" class="form-control"></td>
           </tr>
           <tr>
              <td><b>SUBTOTAL:<br></b>
               <span>Add lines (a) and (b)</span>
             </td>
              <td><input type="number" readonly name="subtotal" placeholder="" value=""
                class="form-control"></td>
           </tr>
           <tr>
              <td><b>OVERALL RATING
                 Divide line (c) by 2
              </b>
            </td>
              <td><input type="number" readonly name="overall_rating" placeholder="" value=""
                class="form-control"></td>
           </tr>
        </tbody>
        </table>
    </div>
</div>
<br><br>
<div class="row row-sm">
<div class="col-12">
        <div class="form-group">
            <h4 class="fs-16 font-weight-600 mb-0">
            NAME OR SIGNATURE OF THE PARTNER REVIEWED &nbsp;&nbsp;&nbsp;
            <input type="text" name="name_of_signature" placeholder="" value="{{$performanceevaluation->name_of_signature ??''}}"
                class="form">
</h4>
        </div>
    </div>
</div>
    
<br>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right">Submit</button>
    <a class="btn btn-secondary" href="{{ url('performanceevaluationform') }}">Back</a>

</div>