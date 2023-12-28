<?php

use App\Console\Commands\BirthdayReminder;
use App\Console\Commands\CalculateAttendance;
use App\Console\Commands\TimesheetMonday;
use App\Console\Commands\TimesheetnotfilllastweekReminder;
use App\Console\Commands\TimesheetnotfillReminder;
use App\Console\Commands\TimesheetnotfillstaffReminder;
use App\Console\Commands\TimesheetReminder;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataanalyticsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AssignmentfolderfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CyclingeventController;
use App\Http\Controllers\AssignmentfolderController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\CourierinoutController;
use App\Http\Controllers\PerformanceevaluationformController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\DeclarationformController;
use App\Http\Controllers\HrtaskController;
use App\Http\Controllers\AuditticketController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ClientSpecificIndependenceController;
use App\Http\Controllers\StaffappointmentletterController;
use App\Http\Controllers\NeftController;
use App\Http\Controllers\PenalityController;
use App\Http\Controllers\AdminitrController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\QuestionpaperController;
use App\Http\Controllers\SecretarialTaskController;
use App\Http\Controllers\ExamAnswerController;
use App\Http\Controllers\MeetingfolderController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AtrController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\IfcfolderController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\IfcController;
use App\Http\Controllers\AssetprocurementController;
use App\Http\Controllers\TravelfeedbackController;
use App\Http\Controllers\EmployeeonboardingController;
use App\Http\Controllers\IcardController;
use App\Http\Controllers\ArticleonboardingController;
use App\Http\Controllers\CandidateboardingController;
use App\Http\Controllers\AssignmentevaluationController;
use App\Http\Controllers\DraftemailController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\StaffassignController;
use App\Http\Controllers\LeavetypeController;
use App\Http\Controllers\ContractandSubscriptionController;
use App\Http\Controllers\ApplyleaveController;
use App\Http\Controllers\StaffdetailController;
use App\Http\Controllers\RecruitmentformController;
use App\Http\Controllers\BackEndController;
use App\Http\Controllers\ClientuserloginController;
use App\Http\Controllers\CreditnoteController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\OutstationconveyanceController;
use App\Http\Controllers\TabController;
use App\Http\Controllers\LocalconveyancesController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\QuestionnaireroundoneController;
use App\Http\Controllers\ArticlefileController;
use App\Http\Controllers\PbdController;
use App\Http\Controllers\FullandfinalController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ReimbursementclaimController;
use App\Http\Controllers\HbrController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\TeammemberController;
use App\Http\Controllers\LetterheadController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TeamloginController;
use App\Http\Controllers\EmployeereferralController;
use App\Http\Controllers\AppointmentletterController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\OutstandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TeamprofileController;
use App\Http\Controllers\AnnualIndependenceDeclarationController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\KnowledgebaseController;
use App\Http\Controllers\AssignmentbudgetingController;
use App\Http\Controllers\Client\MisController;
use App\Http\Controllers\AdminmisController;
use App\Http\Controllers\AssignmentmappingController;
use App\Http\Controllers\Student\StudenthomeController;
use App\Http\Controllers\Student\StudentExamController;
use App\Http\Controllers\TeamlevelController;
use App\Http\Controllers\CompanydetailController;
use App\Http\Controllers\GnattchartController;
use App\Http\Controllers\TrainingassessmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\JobapplicationController;
use App\Http\Controllers\TravelformController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\AssetasignController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\TimesheetrequestController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\AssetticketController;
use App\Http\Controllers\AssignmentconfirmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChecklistanswerController;
use App\Http\Controllers\StaffrequestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ClientLoginController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Client\ClienthomeController;
use App\Http\Controllers\InformationresourceController;
use App\Http\Controllers\Client\InformationController;
use App\Http\Controllers\Client\InternalauditController;
use App\Http\Controllers\Client\ItrController;
use App\Http\Controllers\Client\ClientAtrController;
use App\Http\Controllers\PerformanceappraisalController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DiscusesController;
use App\Http\Controllers\DirectapplicationController;
use App\Http\Controllers\EmployeepayrollController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\TestingController;
use App\Models\Attendance;
use App\Models\Teammember;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//? only testing purpose
Route::resource('/test', TestingController::class);
Route::get('/testreminder2', [TimesheetnotfillstaffReminder::class, 'handle']);
Route::get('/testreminder4', [BirthdayReminder::class, 'handle']);
Route::get('/testreminder5', [TimesheetnotfilllastweekReminder::class, 'handle']);
Route::get('/testreminder', [TimesheetnotfillReminder::class, 'handle']);
// Route::get('/testreminder', [TimesheetReminder::class, 'handle']);
//? only testing purpose end

//? 
//? apply leave filtering 
Route::get('/filtering-applyleve', [ApplyleaveController::class, 'filterDataAdmin']);
// Route::get('/filter-dataadmin', [TimesheetController::class, 'filterDataAdmin']);
//? exem leave request
Route::get('/examleaverequest/{id}',  [ApplyleaveController::class, 'exampleleaveshow']);
Route::get('/examleaverequestlist', [ApplyleaveController::class, 'examleaverequestlist']);
Route::post('/applyleaverequest',  [ApplyleaveController::class, 'leaverequeststore'])->name('applyleaverequest');
Route::any('/examleaverequestapprove/{id}', [ApplyleaveController::class, 'examleaverequest'])->name('examleaveapprove');

//? read and unread notification. notification read
// Route::get('/notifications', 'NotificationController@index')->name('notifications.index');
Route::get('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');;

//? Assignment rejected module. assrejected
Route::get('/assignment/reject/{id}/{status}/{teamid}', [StepController::class, 'assignmentreject']);
//? timesheet rejected module
Route::get('/rejectedlist', [TimesheetController::class, 'rejectedlist']);
Route::get('/rejectedlist/team', [TimesheetController::class, 'rejectedlistteam']);
Route::get('/timesheet/reject/{id}', [TimesheetController::class, 'timesheetreject']);
Route::post('/timesheetupdate/submit',  [TimesheetController::class, 'timesheeteditstore']);
Route::get('/timesheetreject/edit/{id}',  [TimesheetController::class, 'timesheetEdit']);
Route::get('/rejectedtimesheetlog', [TimesheetController::class, 'rejectedtimesheetlog']);
//? Done it
// zip download
Route::get('/assignmentzip/{assignmentfolder_id}', [AssignmentfolderfileController::class, 'zipfile'])->name('zip');
//? Done it


Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showloginForm']);
Route::get('/forgetpassword', [App\Http\Controllers\Auth\ClientLoginController::class, 'forgetPassword']);
Route::group(['middleware' => 'throttle:4,1'], function () {
  Route::post('/forgetpassword/store', [App\Http\Controllers\Auth\ClientLoginController::class, 'forgetpasswordStore']);
});
Route::get('/reset/newpassword/{id}', [App\Http\Controllers\Auth\ClientLoginController::class, 'newPassword']);
Route::post('/newpassowrd/store/{id}', [App\Http\Controllers\Auth\ClientLoginController::class, 'passwordStore']);
Route::get('/privacypolicy', function () {
  return view('privacypolicy');
});
Route::get('/calculate-attendance', [HomeController::class, 'calculateAttendance']);
Route::get('/candidateonboardingform/kgs', [HomeController::class, 'candidateonboardingFormKgs']);
Route::get('/candidateonboardingform/capitall', [HomeController::class, 'candidateonboardingFormCapitall']);
Route::get('/candidateonboardingform/kgs-advisors', [HomeController::class, 'candidateonboardingFormKgsAdvisors']);
Route::get('/candidateonboardingform/womennovator', [HomeController::class, 'candidateonboardingFormWomennovator']);
Route::get('/candidateonboardingform/intern/kgs', [HomeController::class, 'candidateonboardingFormInternKgs']);
Route::get('/candidateonboardingform/intern/capitall', [HomeController::class, 'candidateonboardingFormInternCapitall']);
Route::get('/candidateonboardingform/intern/kgs-advisors', [HomeController::class, 'candidateonboardingFormInternKgsAdvisors']);
Route::get('/candidateonboardingform/intern/womennovator', [HomeController::class, 'candidateonboardingFormInternWomennovator']);



Route::post('/candidateonboarding/store', [HomeController::class, 'store']);
Route::get('/questionnaireroundone', [App\Http\Controllers\QuestionnaireroundoneController::class, 'showquestionnaireForm']);
Route::post('/questionnaireroundone/store', [App\Http\Controllers\QuestionnaireroundoneController::class, 'store']);
Route::get('/database', [HomeController::class, 'cron']);
Route::get('/cron', [HomeController::class, 'scheduler']);
Route::get('/att', [HomeController::class, 'Att']);
Route::get('/timesheetreminder', [HomeController::class, 'timesheetreminder']);
Route::get('/holidayreminder', [HomeController::class, 'holidayReminder']);
Route::get('/update-attendance', [HomeController::class, 'UpdateAttendance']);
Route::get('/invoicereminder', [HomeController::class, 'invoiceReminder']);
Route::get('/timesheetduplicate', [HomeController::class, 'timesheetDuplicate']);
Route::get('/outstandingreminder', [HomeController::class, 'outstandingReminder']);
Route::get('/birthdayreminder', [HomeController::class, 'birthdayReminder']);

Route::get('/timesheetnotfillstaffreminder', [HomeController::class, 'timesheetnotfillstaffreminder']);
Route::get('/timesheetnotfillreminder', [HomeController::class, 'timesheetnotfillreminder']);
Route::get('/timesheetnotfilllastweekreminder', [HomeController::class, 'timesheetnotfilllastweekreminder']);

Route::get('/timesheetmonday', [HomeController::class, 'timesheetmonday']);


Route::get('/update-attendance', [HomeController::class, 'UpdateAttendance']);
Route::get('/ats', [HomeController::class, 'ats']);
//Route::get('/', [LoginController::class, 'index']);
// Articleonboardingform //
Route::get('/articleonboardingform', [HomeController::class, 'articleonboardingForm']);
Route::post('/articleonboardingform/store', [HomeController::class, 'articlestore']);

Route::get('/authforgetpassword', [App\Http\Controllers\Auth\LoginController::class, 'forgetPassword']);
Route::post('/authforgetpassword/store', [App\Http\Controllers\Auth\LoginController::class, 'authforgetpasswordStore']);

Route::get('/authreset/newpassword/{id}', [App\Http\Controllers\Auth\LoginController::class, 'newPassword']);
Route::post('/authnewpassowrd/store/{id}', [App\Http\Controllers\Auth\LoginController::class, 'passwordStore']);



Route::get('/employeepayroll/create', [EmployeepayrollController::class, 'payrollform']);
Route::post('/employeepayrollform/store', [EmployeepayrollController::class, 'store']);
Route::get('/payrolldata', [EmployeepayrollController::class, 'payrollData']);
Route::get('/employeepayroll/view/{id}',  [EmployeepayrollController::class, 'emloyeepayrollview']);
Route::get('/employeepayroll',  [EmployeepayrollController::class, 'index']);
Route::post('/payroll/approve',  [EmployeepayrollController::class, 'payrollApprove'])->name('payroll-approve');
Route::post('/payroll/clarification',  [EmployeepayrollController::class, 'payrollClarification'])->name('payroll-clarification');
Route::get('/export', [ExportController::class, 'export'])->name('export');

Route::get('/employeepayroll/upload-form', [EmployeepayrollController::class, 'excelUploadForm'])->name('uploadExcel.form');;
Route::post('/employeepayroll/upload', [EmployeepayrollController::class, 'excelUpload'])->name('uploadExcel');



// Discuss route
Route::resource('/discuss', DiscusesController::class);
Route::post('/participate/update',  [DiscusesController::class, 'participateUpdate']);
Route::post('/Discussteam/update',  [DiscusesController::class, 'DiscussTeamUpdate']);
Route::post('/discuss/update', [DiscusesController::class, 'discussupdate']);
Route::get('/discussfilter',  [DiscusesController::class, 'discussfilter']);
Route::get('/discussfilter1',  [DiscusesController::class, 'discussfilter']);
Route::post('/discuss/editupdate',  [DiscusesController::class, 'Editupdate']);
Route::get('/discuss/delete/{id}',  [DiscusesController::class, 'discussDelete']);
Route::post('/distopic/update',  [DiscusesController::class, 'TopicUpdate']);
Route::post('/description/update',  [DiscusesController::class, 'DescriptionUpdate']);

Route::get('discussstatus',  [DiscusesController::class, 'discussStatus']);
Route::get('/discuss/deletes/{id}',  [DiscusesController::class, 'discussDeletes']);
Route::post('/discuss/excel',  [DiscusesController::class, 'ExcelStore']);

Route::get('/indexchart',  [DiscusesController::class, 'indexchart']);
// Directapplication route
// Directapplication route
Route::resource('/directapplication', DirectapplicationController::class);
Route::get('/direct_articleship-applications',  [DirectapplicationController::class, 'articleship']);
Route::get('/direct_internship-applications',  [DirectapplicationController::class, 'internship']);
Route::get('/direct_ca-applications',  [DirectapplicationController::class, 'caapplication']);
Route::get('/direct_other-applications',  [DirectapplicationController::class, 'otherapplications']);
Route::get('/articleshipdetails/{sno}',  [DirectapplicationController::class, 'articleshipDetails']);
Route::get('/cadetails/{sno}',  [DirectapplicationController::class, 'caDetails']);
Route::get('/internshipdetails/{sno}',  [DirectapplicationController::class, 'internshipDetails']);
Route::get('/interviewinternresume',  [DirectapplicationController::class, 'interviewintenshipResume']);
Route::post('/forwardinternresume',  [DirectapplicationController::class, 'internshipforwardResume']);
Route::get('/internstatusupdate', [DirectapplicationController::class, 'internstatusUpdate']);
Route::post('/internrating',  [DirectapplicationController::class, 'internRating']);
Route::get('/otherresume',  [DirectapplicationController::class, 'otherResume']);
Route::post('/forwardotherresume',  [DirectapplicationController::class, 'otherforwardResume']);
Route::get('/otherdetails/{sno}',  [DirectapplicationController::class, 'otherdetails']);
Route::post('/otherrating',  [DirectapplicationController::class, 'otherRating']);
Route::get('/otherstatusupdate', [DirectapplicationController::class, 'otherstatusUpdate']);
//performance appraisal
Route::resource('/performanceappraisal', PerformanceappraisalController::class);
//Check-In
Route::resource('/check-In', CheckInController::class);
Route::post('/check-In/update/', [CheckInController::class, 'update'])->name('check-In.checkout');
Route::post('/check-In/search/', [CheckInController::class, 'search']);
Route::get('/check-In-assignment', [CheckInController::class, 'assignment']);



Auth::routes();
Route::get('/adminlogin', [App\Http\Controllers\Auth\AdminLoginController::class, 'showloginForm']);
Route::post('/admin/loginstore', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::group(['prefix' => 'user'], function () {

//  Route::get('/home', [UserController::class, 'index'])->name('home');

//});
//Route::get('/student/login', [App\Http\Controllers\Auth\StudentLoginController::class, 'studentloginForm']);
Route::post('/student/loginstore', [App\Http\Controllers\Auth\StudentLoginController::class, 'studentlogin'])->name('student.login');
Route::post('student/logout', [App\Http\Controllers\Auth\StudentLoginController::class, 'logout'])->name('student.logout');

//Route::get('/student/register', [App\Http\Controllers\Auth\StudentLoginController::class, 'studentregisterForm']);
Route::post('/student/store', [App\Http\Controllers\Auth\StudentLoginController::class, 'StudentregidterStore']);

Route::group(['prefix' => 'students'], function () {
  Route::get('/home', [StudenthomeController::class, 'index'])->name('students.home');
  Route::get('/resetpassword/{id}', [StudenthomeController::class, 'resetPassword']);
  Route::post('/password/update/{id}', [StudenthomeController::class, 'passwordUpdate']);
  Route::resource('/studentexam', StudentExamController::class);
  Route::get('/thanks', [StudentExamController::class, 'examEnd']);
  Route::get('/result/{id}', [StudentExamController::class, 'studentResult']);
});

Route::get('/clientlogin', [App\Http\Controllers\Auth\ClientLoginController::class, 'showloginForm']);
Route::post('/client/loginstore', [App\Http\Controllers\Auth\ClientLoginController::class, 'login'])->name('client.login');
Route::post('client/logout', [App\Http\Controllers\Auth\ClientLoginController::class, 'logout'])->name('client.logout');
Route::get('/loginotp/{id}', [ClientLoginController::class, 'loginOtp']);
Route::post('/otp/store', [ClientLoginController::class, 'otpStore']);
Route::get('/otp/resend/{id?}',  [ClientLoginController::class, 'otpResend']);

Route::group(['prefix' => 'client'], function () {
  Route::get('/home', [ClienthomeController::class, 'index'])->name('client.home');
  Route::get('/switchaccount/{id}', [ClienthomeController::class, 'switchaccount']);
  Route::get('/clientfilelist', [ClienthomeController::class, 'clientFile']);
  Route::post('/clientfile/upload', [ClienthomeController::class, 'store']);
  Route::get('/clientfile/{id}', [ClienthomeController::class, 'getFile']);
  Route::post('/clientfolder/store', [ClienthomeController::class, 'folderStore']);
  Route::get('/folderlist/{id}', [ClienthomeController::class, 'folderList']);
  Route::get('/folderlist/destroy/{id}', [ClienthomeController::class, 'folderListDelete']);
  Route::get('/folderlist/requestdelete/{id}', [ClienthomeController::class, 'folderListRequest']);
  Route::get('/filelist', [ClienthomeController::class, 'fileList']);
  Route::get('/resetpassword/{id}', [ClienthomeController::class, 'resetPassword']);
  Route::post('/password/update/{id}', [ClienthomeController::class, 'passwordUpdate']);
  Route::get('/information', [InformationController::class, 'index']);
  Route::get('/informationlist/{id}', [InformationController::class, 'indexlist']);
  Route::get('/information/create/{id}', [InformationController::class, 'informationCreate']);
  Route::post('/information/store', [InformationController::class, 'informationStore']);
  Route::post('/information/updatestatus', [InformationController::class, 'updateStatus']);
  Route::get('/information/status',  [InformationController::class, 'informationstatusUpdate']);
  Route::get('/ilr/download/{id}', [InformationController::class, 'ilrDownload']);
  Route::get('ilrbank', [InformationController::class, 'ilrbank']);
  Route::get('ilrhouse', [InformationController::class, 'ilrhouse']);
  Route::get('ilrsalary', [InformationController::class, 'ilrsalary']);
  Route::get('ilraddinformation', [InformationController::class, 'ilraddinformation']);
  Route::post('ilrsalary/store', [InformationController::class, 'ilrsalaryStore']);
  Route::post('/ilraddinformation/store', [InformationController::class, 'ilraddStore']);
  Route::post('ilrhouse/store', [InformationController::class, 'ilrhouseStore']);
  Route::post('ilrbank/store', [InformationController::class, 'ilrbankStore']);


  Route::get('/ilrlist', [InformationController::class, 'ilrlist']);
  Route::post('/ilrt/store', [InformationController::class, 'ilrtStore']);
  Route::get('/information/first',  [InformationController::class, 'informationFirst']);
  Route::get('/information/firstt',  [InformationController::class, 'informationFirstt']);
  Route::get('/ilralllist', [InformationController::class, 'ilralllist']);

  Route::post('/informationfolder/store', [InformationController::class, 'folderStore']);
  Route::post('/information/upload', [InformationController::class, 'informationUpload']);
  Route::get('/information/edit/question',  [InformationController::class, 'editrecords']);
  Route::post('/edit/question', [InformationController::class, 'editQuestion']);
  Route::get('/informationq/destroy/{id}', [InformationController::class, 'questionDelete']);
  Route::get('/informationquestion/destroy/{id}', [InformationController::class, 'answerDelete']);

  Route::post('ilraddinformationsecond/store', [ItrController::class, 'ilraddinformationsecondStore']);
  Route::post('ilraddinformationfirst/store', [ItrController::class, 'ilraddinformationfirstStore']);
  Route::post('ilraddinformationthird/store', [ItrController::class, 'ilraddinformationthirdStore']);
  Route::get('ilrdeduction', [ItrController::class, 'ilrdeduction']);
  Route::post('ilrdeduction/store', [ItrController::class, 'ilrdeductionStore']);
  Route::get('ilrbp', [ItrController::class, 'ilrbp']);
  Route::post('ilrbp/store', [ItrController::class, 'ilrbpStore']);
  Route::get('incomefromcapitalgains', [ItrController::class, 'income']);
  Route::post('incomefromcapitalgains/store', [ItrController::class, 'incomefromcapitalgainsStore']);
  Route::get('incomefromsources', [ItrController::class, 'incomefromsources']);
  Route::post('incomefromsources/store', [ItrController::class, 'incomefromsourcesStore']);
  Route::get('ilrpersonal', [ItrController::class, 'ilrpersonal']);
  Route::post('/ilrpersonalinformation/store', [ItrController::class, 'ilrperStore']);

  Route::get('ilrbank/edit', [ItrController::class, 'ilrbankEdit']);
  Route::post('ilrbank/update', [ItrController::class, 'ilrbankUpdate']);
  Route::get('ilrhouse/edit', [ItrController::class, 'ilrhouseEdit']);
  Route::post('ilrhouse/update', [ItrController::class, 'ilrhouseUpdate']);
  Route::get('ilrsalary/edit', [ItrController::class, 'ilrsalaryEdit']);
  Route::post('ilrsalary/update', [ItrController::class, 'ilrsalaryUpdate']);
  Route::get('incomefromcapitalgains/edit', [ItrController::class, 'incomefromcapitalgainsEdit']);
  Route::post('incomefromcapitalgains/update', [ItrController::class, 'incomefromcapitalgainsUpdate']);

  // Mis routes
  Route::resource('/mis', MisController::class);
  Route::get('/misimage',  [MisController::class, 'imageModal']);
  Route::get('/mis/details/{id}', [MisController::class, 'viewUpdate']);
  Route::post('/misclient/update', [MisController::class, 'misUpdate']);
  Route::get('/mis/destroy/{id}', [MisController::class, 'delete']);

  // Internalaudit routes
  Route::resource('/internalaudit', InternalauditController::class);
  Route::get('/actiontracker/index', [InternalauditController::class, 'actionTracker']);
  Route::get('/actionitem/index', [InternalauditController::class, 'actionItem']);
  Route::post('/actionitem/change/{id}', [InternalauditController::class, 'actionItemChange']);
  Route::post('/actiontracker/change/{id}', [InternalauditController::class, 'actionTrackerChange']);

  //Atr routes
  Route::get('/atrlist', [ClientAtrController::class, 'index']);
  Route::get('/atrview/{id}', [ClientAtrController::class, 'atrView']);
  Route::post('/atr/update', [ClientAtrController::class, 'atrUpdate']);
});

/*
|--------------------------------------------------------------------------
| Admin controller Routes
|--------------------------------------------------------------------------
|
| This section contains all admin Routes
| 
|
*/
Route::group(['middleware' => 'throttle:4,1'], function () {
  Route::get('verify/resend', [App\Http\Controllers\Auth\TwoFactorController::class, 'resend'])->name('verify.resend');
});
Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);
Route::group(['middleware' => ['twofactor']], function () {
  Route::get('/home', [BackEndController::class, 'index'])->name('home');
  //   Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard');
  Route::get('/userprofile/{id}', [BackEndController::class, 'userProfile']);
  Route::get('/userlog', [BackEndController::class, 'userLog']);
  Route::post('/userprofile/update', [BackEndController::class, 'update']);
  Route::get('/activitylog', [BackEndController::class, 'activityLog']);
  Route::get('/traininglist', [BackEndController::class, 'traininglist']);
  Route::get('/training/list/{id}', [BackEndController::class, 'traininglistshow']);
  Route::post('/training', [BackEndController::class, 'training']);
  Route::post('/training/reminder', [BackEndController::class, 'trainingMail']);
  Route::get('/training/reminderall', [BackEndController::class, 'trainingreminderMail']);
  Route::get('/authotp',  [BackEndController::class, 'authotp']);
  Route::post('/otpap/store', [BackEndController::class, 'otpapstore']);
  Route::get('/appointmentletters', [BackEndController::class, 'appointmentletter']);
  Route::get('/training/create', [BackEndController::class, 'create']);
  Route::post('/clientfolder/folderstore', [ClientController::class, 'folderStore']);
  Route::get('/folderlist/{id}', [ClientController::class, 'folderList']);
  Route::get('/clientfolderlist/destroy/{id}', [ClientController::class, 'folderDestroy']);
  Route::get('/client/add-document/{id}', [ClientController::class, 'addDocument']);
  Route::post('/client/store-document', [ClientController::class, 'storeDocument'])->name('client.storeDocument');

  Route::get('/client-list', [ClientController::class, 'client_list']);

  //Tab routes
  Route::resource('/tab', TabController::class);

  // articleonboarding routes
  Route::get('/articleonboarding', [ArticleonboardingController::class, 'index']);
  Route::get('/articleprevious',  [ArticleonboardingController::class, 'articleprevious']);

  //Question routes admin
  Route::resource('/questionpaper', QuestionpaperController::class);
  Route::resource('/examanswer', ExamAnswerController::class);
  Route::get('/examanswer/edit/{id}', [ExamAnswerController::class, 'studentexamList']);


  //Assetprocurement routes
  Route::resource('/assetprocurement', AssetprocurementController::class);
  Route::get('/assetfetch',  [AssetprocurementController::class, 'assetfetch_id']);
  Route::post('/assetupdate',  [AssetprocurementController::class, 'assetupdate']);

  //Travel routes
  Route::resource('/travel', TravelController::class);
  Route::get('/transaction',  [TravelController::class, 'transaction']);

  //IcardController routes
  Route::resource('/icards', IcardController::class);
  Route::post('/icardsconfirm',  [IcardController::class, 'icardConfirm']);

  //Group routes
  Route::resource('/group', GroupController::class);

  //ArticlefileController routes
  Route::resource('/articlefiles', ArticlefileController::class);
  Route::get('/zip/{id}', [ArticlefileController::class, 'zip']);

  //AppointmentletterController routes
  Route::resource('/appointmentletter', AppointmentletterController::class);
  //Assignment routes
  Route::resource('/assignment', AssignmentController::class);
  Route::post('/checklist/upload',  [AssignmentController::class, 'checklist_upload']);
  Route::get('/assignmentotp',  [AssignmentController::class, 'assignmentotp']);
  Route::post('/assignmentotp/store', [AssignmentController::class, 'assignmentotpstore']);


  //Template
  Route::resource('/template',  TemplateController::class);

  //Route::resource('/mis', AdminmisController::class);
  Route::get('/viewmis/{id}', [AdminmisController::class, 'viewMis']);
  Route::get('/viewmislist/{id}', [AdminmisController::class, 'viewUpdate']);
  Route::post('/mis/update', [AdminmisController::class, 'misUpdate']);
  Route::get('/misstatus/destroy/{id}', [AdminmisController::class, 'delete']);

  //ConfirmationController routes
  Route::get('/confirmation/{id}', [ConfirmationController::class, 'indexview']);
  Route::post('/confirmation/mail', [ConfirmationController::class, 'mail']);
  Route::get('/confirmationtem',  [ConfirmationController::class, 'template']);
  Route::get('/viewconfirmation/{id}', [ConfirmationController::class, 'view']);

  //Assignmentbudgeting routes
  Route::resource('/assignmentbudgeting', AssignmentbudgetingController::class);
  Route::get('/clientassignmentlist',  [AssignmentbudgetingController::class, 'list']);

  Route::get('/assignmentpartnerlist',  [AssignmentController::class, 'assignmentpartnerlist']);
  Route::get('/assignmentcosting/{id}',  [AssignmentController::class, 'assignment_costing']);
  Route::get('/assignmentprofitloss',  [AssignmentController::class, 'assignmentprofitloss']);
  Route::get('/pandl/{id}',  [AssignmentController::class, 'assignment_profitloss']);
  Route::get('/partnerpandl',  [AssignmentController::class, 'partnerpandl']);
  Route::get('/assignmentpandl',  [AssignmentController::class, 'assignmentpandl']);


  //Assignmentmapping routes
  Route::get('/clientassignmentlist/{id}', [AssignmentmappingController::class, 'clientassignmentList']);
  Route::get('/yearwise', [AssignmentmappingController::class, 'yearWise']);
  Route::resource('/assignmentmapping', AssignmentmappingController::class);
  Route::get('/assignmentmapping/edit/{id}',  [AssignmentmappingController::class, 'assignmentmappingEdit']);
  Route::get('/teamconfirm/',  [AssignmentconfirmController::class, 'teamConfirm']);
  Route::get('/debtorconfirm/',  [AssignmentconfirmController::class, 'debtorconfirm']);
  Route::post('confirmation/confirm',   [AssignmentconfirmController::class, 'confirmationConfirm']);

  // leavetype routes
  Route::resource('/leavetype', LeavetypeController::class);

  // Jobapplications routes
  Route::get('/articleship-applications',  [JobapplicationController::class, 'articleship']);
  Route::get('/internship-applications',  [JobapplicationController::class, 'internship']);
  Route::get('/ca-applications',  [JobapplicationController::class, 'caapplication']);
  Route::get('/caapplicationsearch', [JobapplicationController::class, 'caapplicationsearch']);
  Route::post('/carating',  [JobapplicationController::class, 'caRating']);
  Route::get('/other-applications',  [JobapplicationController::class, 'other']);
  Route::get('/interviewresume',  [JobapplicationController::class, 'interviewResume']);
  Route::post('/forwardresume',  [JobapplicationController::class, 'forwardResume']);
  Route::post('/caforwardresume',  [JobapplicationController::class, 'caforwardResume']);
  Route::post('/articlerating',  [JobapplicationController::class, 'articleRating']);
  Route::get('/articleshipdetails/{sno}',  [JobapplicationController::class, 'articleshipDetails']);
  Route::get('/cadetails/{sno}',  [JobapplicationController::class, 'caDetails']);
  Route::get('/castatusupdate', [JobapplicationController::class, 'castatusUpdate']);
  Route::get('/articlestatusupdate', [JobapplicationController::class, 'articlestatusUpdate']);
  Route::get('/interviewcaresume',  [JobapplicationController::class, 'interviewcaResume']);

  // applyleave routes
  Route::resource('/applyleave', ApplyleaveController::class);
  Route::get('/leave/teamapplication',  [ApplyleaveController::class, 'teamApplication']);
  Route::post('/teamapplication/store',  [ApplyleaveController::class, 'teamapplicationStore']);


  // Policy routes
  Route::resource('/policy', PolicyController::class);
  Route::get('/policy/list/{id}', [PolicyController::class, 'policylist']);
  Route::get('/policyupdate',  [PolicyController::class, 'policy']);
  Route::get('/policy/acknowledgelist/{id}',  [PolicyController::class, 'acknowledgelist']);
  Route::post('/policy/statusupdate', [PolicyController::class, 'policyAcknowledge']);
  Route::get('/policy/reminder/{id}', [PolicyController::class, 'show']);

  // Recruitmentform routes
  Route::resource('/recruitmentform', RecruitmentformController::class);
  Route::get('/view/recruitmentform/{id}', [RecruitmentformController::class, 'view']);

  //Material routes
  Route::resource('/material', MaterialController::class);
  Route::post('/material/update/{id}', [MaterialController::class, 'senderupdate']);
  Route::post('/material/receiver/{id}', [MaterialController::class, 'receiverupdate']);

  // Travelform routes
  Route::resource('/travelform', TravelformController::class);
  Route::post('/travelform/update', [TravelformController::class, 'travelupdate']);

  // Travelfeedback routes
  Route::get('/travelformfeedback',  [TravelfeedbackController::class, 'feedback']);
  Route::post('/feedbackinsert', [TravelfeedbackController::class, 'store']);
  Route::get('/travelfeedback', [TravelfeedbackController::class, 'index']);

  //Attendance routes
  Route::resource('/attendance', AttendanceController::class);
  Route::post('/attendance/update', [AttendanceController::class, 'update'])->name('updateAttendance');
  Route::get('/attendances', [AttendanceController::class, 'attendances']);

  //Tax
  Route::resource('/tax', TaxController::class);
  Route::post('/tax/upload', [TaxController::class, 'tax_upload']);

  //Meetingfolder
  Route::resource('/meetingfolder', MeetingfolderController::class);
  Route::post('/meeting/upload', [MeetingfolderController::class, 'meeting_upload']);
  Route::post('/meetingfolder/store', [MeetingfolderController::class, 'folderStore']);
  Route::post('/meetingsubfolderstore', [MeetingfolderController::class, 'meetingsubfolderstore']);
  Route::post('/meetingfolder/update', [MeetingfolderController::class, 'meetingfolder_update']);
  Route::get('/meetingfiles/{id}', [MeetingfolderController::class, 'meetingfiles']);
  Route::get('/meeting/filenameedit', [MeetingfolderController::class, 'meeting_filenameedit']);

  // Declaration Form route
  Route::resource('declarationform', DeclarationformController::class);

  //Invoice
  Route::resource('/invoice',  InvoiceController::class);
  Route::get('/invoiceajax/create',  [InvoiceController::class, 'clientList']);
  Route::get('/invoicecompany/create',  [InvoiceController::class, 'companyList']);
  Route::get('/invoiceassignment',  [InvoiceController::class, 'invoiceAssignment']);
  Route::get('/companycode/create',  [InvoiceController::class, 'companyCode']);
  Route::get('/invoiceview/{id}',  [InvoiceController::class, 'invoiceView']);
  Route::get('/downloadpdf/{id}',  [InvoiceController::class, 'downloadpdf']);
  Route::post('invoiceupdate/{id}',   [InvoiceController::class, 'invoiceUpdate']);
  Route::get('/search',  [InvoiceController::class, 'search']);
  Route::get('/invoicereport',  [InvoiceController::class, 'invoicereport']);
  Route::get('/invoiceassignmentreport',  [InvoiceController::class, 'invoiceassignmentreport']);
  Route::get('/invoiceassignmentreport/barchart', [InvoiceController::class, 'echartt']);
  Route::get('/barchart',  [InvoiceController::class, 'bar_chart']);

  //Teammember routes
  Route::resource('/teammember', TeammemberController::class);
  Route::get('/ourteam', [TeammemberController::class, 'ourTeam']);
  Route::get('/resetpassword/{id}', [TeammemberController::class, 'resetPassword']);
  Route::post('/password/update/{id}', [TeammemberController::class, 'passwordUpdate']);
  Route::get('qualification/delete/{id}', [BackEndController::class, 'deletequalification']);
  Route::get('/resetpasswords/{id}', [TeammemberController::class, 'resetPasswords']);
  Route::post('/authpassword/update/{id}', [TeammemberController::class, 'authpassword_Update']);

  Route::get('changeteamStatus',  [TeammemberController::class, 'changeteamStatus']);

  Route::get('teamstatus',  [TeammemberController::class, 'teamstatus']);


  Route::get('/teammemberupdatedetail',  [TeammemberController::class, 'teamUpdate']);
  Route::post('/teamupdate', [TeammemberController::class, 'teamsupdate']);
  Route::get('/relieve/teammember',  [TeammemberController::class, 'relievingTeammember']);

  Route::get('/userpasswordotp',  [TeammemberController::class, 'userpasswordotp']);
  Route::post('/userresetotp/store', [TeammemberController::class, 'userotpstore']);

  //Companydetail route
  Route::resource('/companydetail', CompanydetailController::class);
  Route::get('/view/companydetail/{id}', [CompanydetailController::class, 'viewinvoice']);

  //lead Controller
  Route::resource('/lead', LeadController::class);
  Route::post('/lead/observer', [LeadController::class, 'leadreplyDone']);
  Route::get('/lead/view/{id}', [LeadController::class, 'show']);

  // Cyclingevent routes
  Route::resource('/cyclingevent', CyclingeventController::class);


  //Pbd
  Route::resource('/pbd',  PbdController::class);

  // Assignmentevaluation routes
  Route::resource('/assignmentevaluation', AssignmentevaluationController::class);
  Route::get('/view/assignmentevaluation/{id}', [AssignmentevaluationController::class, 'view']);
  Route::get('assignmentevaluation/type/{value}', [AssignmentevaluationController::class, 'assignmentevaluationonType']);
  Route::get('assignmentevaluation/report', [AssignmentevaluationController::class, 'show']);
  Route::get('assignmentevaluationreport', [AssignmentevaluationController::class, 'assignmentevaluationreport']);
  Route::get('filter/assignmentevaluation', [AssignmentevaluationController::class, 'Filters']);

  //Report routes
  Route::get('/assignment_report', [ReportController::class, 'assignment_report']);

  // Job routes
  Route::resource('/job', JobController::class);
  Route::get('/view/job/{id}', [JobController::class, 'view']);

  // Atr routes
  Route::resource('/atr', AtrController::class);
  Route::post('/atr/upload', [AtrController::class, 'atrUpload']);
  Route::post('/atr/assign', [AtrController::class, 'atrAssign']);
  Route::get('/view/atr/{id}', [AtrController::class, 'view']);
  Route::get('/atr/{id}', [AtrController::class, 'show']);
  Route::get('/atrassigned', [AtrController::class, 'assigned']);
  Route::post('/atr/update', [AtrController::class, 'atrUpdate']);
  Route::post('/assign/person', [AtrController::class, 'assignPerson']);
  Route::get('/atr/reminder/{id}', [AtrController::class, 'atrReminder']);

  //target
  Route::resource('/questionnaireform', QuestionnaireroundoneController::class);

  // project routes
  Route::resource('/project', ProjectController::class);
  Route::get('/view/project/{id}', [ProjectController::class, 'view']);

  //fullandfinal
  Route::resource('/fullandfinal',  FullandfinalController::class);
  Route::get('/fullandfinalreminder/{id}', [FullandfinalController::class, 'fullandfinalReminder']);
  Route::get('/fullandfinalajax/create',  [FullandfinalController::class, 'teammemberDetail']);
  Route::get('/fullandfinal/delete/{id}', [FullandfinalController::class, 'delete']);
  Route::get('/fullandfinal/{id}', [FullandfinalController::class, 'show']);
  Route::post('/fullandfinal/updatestatus/{id}', [FullandfinalController::class, 'updatestatus']);

  Route::get('ilrpersonal', [AdminitrController::class, 'ilrpersonal']);
  Route::get('ilrbp', [AdminitrController::class, 'ilrbp']);
  Route::get('incomefromcapitalgains', [AdminitrController::class, 'income']);
  Route::get('incomefromsources', [AdminitrController::class, 'incomefromsources']);
  Route::get('ilrdeduction', [AdminitrController::class, 'ilrdeduction']);

  //letterhead Controller
  Route::resource('/letterhead', LetterheadController::class);
  Route::get('/letterhead/{id}', [LetterheadController::class, 'show']);

  // Staffdetail routes
  Route::resource('/staffdetail', StaffdetailController::class);

  //Teamlevel routes
  Route::get('/teamlevel',  [TeamlevelController::class, 'index']);
  Route::post('/teamlevel/store',  [TeamlevelController::class, 'store']);
  Route::get('/teamlevel/create',  [TeamlevelController::class, 'create']);
  Route::get('/teamlevel/edit/{id}', [TeamlevelController::class, 'edit']);
  Route::post('/teamlevel/update/{id}', [TeamlevelController::class, 'update']);

  // Notification routes
  Route::resource('/notification', NotificationController::class);

  // Secretary of Task routes
  Route::resource('/secretaryoftask', SecretarialTaskController::class);
  Route::post('/secretaryoftask/update', [SecretarialTaskController::class, 'secretarialtaskUpdate']);
  Route::get('/view/secretaryoftask/{id}', [SecretarialTaskController::class, 'viewsecretarialTask']);
  Route::post('/secretaryoftask/complete', [SecretarialTaskController::class, 'secretarialtaskComplete']);

  // Hr Ticket routes
  Route::resource('/hrticket', HrtaskController::class);
  Route::post('/hrticket/update', [HrtaskController::class, 'hrticketUpdate']);
  Route::get('/view/hrticket/{id}', [HrtaskController::class, 'viewhrticketTask']);
  Route::post('/hrticket/complete', [HrtaskController::class, 'hrticketComplete']);

  // Auditticket of Task routes
  Route::resource('/auditticket', AuditticketController::class);
  Route::post('/auditticket/update', [AuditticketController::class, 'auditticketUpdate']);
  Route::get('/view/auditticket/{id}', [AuditticketController::class, 'viewauditticketTask']);
  Route::post('/auditticket/complete', [AuditticketController::class, 'auditticketComplete']);

  // Dataanalytics of Task routes
  Route::resource('/dataanalytics', DataanalyticsController::class);
  Route::post('/dataanalytics/update', [DataanalyticsController::class, 'dataanalyticsUpdate']);
  Route::get('/view/dataanalytics/{id}', [DataanalyticsController::class, 'viewdataanalyticsticket']);
  Route::post('/dataanalytics/complete', [DataanalyticsController::class, 'dataanalyticsComplete']);

  // Feed routes
  Route::get('/feed', [FeedController::class, 'feed']);

  // ILR routes
  Route::get('/ilr/download/{id}', [InformationresourceController::class, 'ilrDownload']);
  Route::get('/informations/delete/{id}', [InformationresourceController::class, 'informationDelete']);
  Route::get('/ilr/delete/{id}', [InformationresourceController::class, 'questionDelete']);
  Route::resource('/informationresources', InformationresourceController::class);
  Route::get('/informationlist/{id}', [InformationresourceController::class, 'indexview']);
  Route::get('/information/{id}', [InformationresourceController::class, 'ilrfolder']);
  Route::post('/information/upload', [InformationresourceController::class, 'informationUpload']);
  Route::post('/ilr/question', [InformationresourceController::class, 'questionUpload']);
  Route::get('/information/create/{id}', [InformationresourceController::class, 'informationCreate']);
  Route::post('/informations/store', [InformationresourceController::class, 'informationStore']);
  Route::post('/informationfolder/store', [InformationresourceController::class, 'folderStore']);
  Route::post('/edit/question', [InformationresourceController::class, 'editQuestion']);
  Route::get('/information/edit/question',  [InformationresourceController::class, 'editrecords']);
  Route::post('assign/folder', [InformationresourceController::class, 'assignfolderStore']);
  Route::get('ilrbank', [InformationresourceController::class, 'ilrbank']);
  Route::get('ilrhouse', [InformationresourceController::class, 'ilrhouse']);
  Route::get('ilrsalary', [InformationresourceController::class, 'ilrsalary']);
  Route::get('ilraddinformation', [InformationresourceController::class, 'ilraddinformation']);

  // ClientuserloginController routes
  // Route::resource('/clientuserlogin', ClientuserloginController::class);
  Route::get('/clientuserlogin/{id}', [ClientuserloginController::class, 'indexview']);
  Route::post('/clientuserlogin/upload', [ClientuserloginController::class, 'informationUpload']);
  Route::get('/clientuserlogin/create/{id}', [ClientuserloginController::class, 'clientCreate']);
  Route::post('/clientuserlogin/store', [ClientuserloginController::class, 'clientStore']);
  Route::get('/clientuserlogin/resetpassword/{id}', [ClientuserloginController::class, 'resetPassword']);
  Route::post('/clientuserlogin/password/update/{id}', [ClientuserloginController::class, 'passwordUpdate']);
  Route::get('changeclientloginStatus',  [ClientuserloginController::class, 'changeclientloginStatus']);
  Route::get('/client/loginid',  [ClientuserloginController::class, 'clientlogin']);
  Route::get('/client/staffpermission',  [ClientuserloginController::class, 'staffpermission']);
  Route::post('/client/assign',  [ClientuserloginController::class, 'clientassign']);
  Route::post('/client/permissionstore',  [ClientuserloginController::class, 'permissionStore']);

  // Profile routes
  Route::resource('/profile', ProfileController::class);

  //Staffappointmentletter
  Route::resource('/staffappointmentletter', StaffappointmentletterController::class);
  Route::get('/staffappointmentletter/view/{id}', [StaffappointmentletterController::class, 'staffappointmentView']);
  Route::get('/staffappointmentletter/destroy/{id}', [StaffappointmentletterController::class, 'destroy']);
  Route::get('/staffappointmentletter/mailverify/{id}', [StaffappointmentletterController::class, 'mailVerify']);

  //hrb Controller
  Route::resource('/hbrtools', HbrController::class);

  // courierinout routes
  Route::resource('/courierinout', CourierinoutController::class);
  Route::post('/courierinout/update/{id}', [CourierinoutController::class, 'senderupdate']);
  Route::post('/courierinout/sender/{id}', [CourierinoutController::class, 'sender']);
  Route::post('/courierinout/receiver/{id}', [CourierinoutController::class, 'receiverupdate']);

  // Outstanding route
  Route::resource('/outstanding', OutstandingController::class);
  Route::get('/outstandingdashboard',  [OutstandingController::class, 'echartt']);
  Route::get('/reminder/sendmail',  [OutstandingController::class, 'sendMail']);
  Route::post('/outstanding/reminder',  [OutstandingController::class, 'oustandingMail']);
  Route::get('/reminder/mailshow',  [OutstandingController::class, 'mailshow']);
  Route::get('/partnerchart',  [OutstandingController::class, 'echart_search']);

  // Finance routes
  Route::get('/assetassignedreport', [AssetasignController::class, 'assetassigned_report']);
  Route::resource('/assetassign', AssetasignController::class);
  Route::get('/assetassigned/view/{id}', [AssetasignController::class, 'financeView']);
  Route::get('/assetassign/viewit/{id}', [AssetasignController::class, 'financeViewit']);
  Route::post('/account/update', [AssetasignController::class, 'accountUpdate']);
  Route::post('/it/update', [AssetasignController::class, 'itUpdate']);
  Route::post('/assetassign/upload', [AssetasignController::class, 'financeUpload']);

  // Performance Evaluation Form Form route
  Route::resource('performanceevaluationform', PerformanceevaluationformController::class);

  //Knowledgebase routes
  Route::resource('/knowledgebase', KnowledgebaseController::class);
  Route::get('/knowledgebase/create/{id}',  [KnowledgebaseController::class, 'knowledgebaseCreate']);

  //Knowledgebase routes
  Route::resource('/article', ArticleController::class);
  Route::get('/knowledgebase/article/{id}',  [ArticleController::class, 'articleIndex']);
  Route::get('/article-view/{id}', [ArticleController::class, 'articleView']);
  Route::get('/article/create/{id}', [ArticleController::class, 'articleCreate']);

  // employeereferral routes
  Route::resource('/employeereferral', EmployeereferralController::class);

  // Generate ticket route
  Route::get('/generateticket/{id}', [BackEndController::class, 'ticketIndex']);

  // Payment route
  Route::resource('/payment', PaymentController::class);
  Route::get('/paymentlist/{id}', [PaymentController::class, 'paymentList']);
  Route::get('/payment/create/{id}', [PaymentController::class, 'paymentCreate']);
  Route::post('payments/store/{id}', [PaymentController::class, 'paymentsStore']);
  Route::get('paymentsearch', [PaymentController::class, 'paymentSearch']);

  // clientstaffassign routes
  Route::get('/clientstaffassign/{id}', [StaffassignController::class, 'index']);
  Route::post('staff/assign', [StaffassignController::class, 'staffassignStore']);

  Route::get('/profileimage/{id}', [BackEndController::class, 'profileImage']);

  // Staffrequest route
  Route::get('/staffrequest/list/{id}', [StaffrequestController::class, 'viewList']);
  Route::resource('/staffrequest', StaffrequestController::class);
  Route::get('/viewstaff/{id}', [StaffrequestController::class, 'viewStaff']);
  Route::post('staffrequest/complete', [StaffrequestController::class, 'staffRequest']);
  Route::get('staffrequest/delete/{id}', [StaffrequestController::class, 'destroy']);

  // Proposal routes
  Route::resource('/proposal', ProposalController::class);
  Route::post('/proposal/status',  [ProposalController::class, 'proposalStatus']);


  // Vendor routes
  Route::resource('/vendor', VendorController::class);
  Route::post('/vendor/store', [VendorController::class, 'store']);
  Route::get('/vendorlist', [VendorController::class, 'index']);
  Route::get('/vendorlist/fetch',  [VendorController::class, 'vendorList']);
  Route::get('/vendorfetch',  [VendorController::class, 'vendorfetch_id']);
  Route::post('/vendorupdate',  [VendorController::class, 'vendorupdate']);

  // Payroll routes
  Route::resource('/payroll', PayrollController::class);
  Route::post('/payroll/upload', [PayrollController::class, 'payroll_upload']);
  Route::post('/payrollarticle/upload', [PayrollController::class, 'payrollarticle_upload']);
  Route::get('/payroll/neft', [PayrollController::class, 'payroll_neft']);
  Route::post('/payrollneftprocess',  [PayrollController::class, 'payrollneftprocess']);
  Route::get('/payrollarticle', [PayrollController::class, 'payroll_index']);
  Route::post('/payrollarticleneftprocess',  [PayrollController::class, 'payrollarticleneftprocess']);
  Route::get('/payrolls', [PayrollController::class, 'payroll']);
  Route::get('/payrollarticless', [PayrollController::class, 'payrollarticless']);

  // NEFT routes
  Route::get('/payrollarticleneftss', [NeftController::class, 'payrollarticleneftss']);
  Route::resource('/neft', NeftController::class);
  Route::get('/neftajax/create',  [NeftController::class, 'teamList']);
  Route::get('/getconveyancesneft',  [NeftController::class, 'get_conveyacne']);
  Route::get('/getconveyancesnefttotal',  [NeftController::class, 'get_conveyancesnefttotal']);
  Route::get('/neftstatus', [NeftController::class, 'neft_status']);
  Route::post('/neftstatusupdate', [NeftController::class, 'neft_statusupdate']);
  Route::get('/payrollneft', [NeftController::class, 'payrollneft']);
  Route::get('/payrollneftsalary', [NeftController::class, 'payrollneftsalary']);

  Route::get('/neftformat', [NeftController::class, 'neft_format']);
  Route::get('/payrollarticleneft', [NeftController::class, 'payrollarticleneft']);
  Route::get('/neftdate', [NeftController::class, 'neftdate']);

  //Ifcfolder
  Route::get('/ifcfolder/{id}', [IfcfolderController::class, 'index']);
  Route::get('ifcfolders', [IfcfolderController::class, 'staffindex']);
  Route::resource('/ifcfolder', IfcfolderController::class);
  Route::get('/ifclist/{id}',  [IfcfolderController::class, 'ifclist']);
  Route::get('/ifclist/{id}',  [IfcfolderController::class, 'ifclist']);

  //IFC
  Route::get('/ifc/{id}', [IfcController::class, 'index']);
  Route::get('/ifc/view/{id}', [IfcController::class, 'ifcView']);
  Route::post('/ifc/update/{id}', [IfcController::class, 'ifcUpdate']);
  //Route::post('/ifcmanagementupdate', [IfcController::class, 'ifcmanagementupdate']);
  Route::post('/ifc/upload', [IfcController::class, 'ifcUpload']);
  Route::post('/ifc/uploadanswer', [IfcController::class, 'ifcUpload_answer']);
  Route::post('/ifcassign/person', [IfcController::class, 'ifcassignPerson']);
  Route::get('/ifcdocument',  [IfcController::class, 'ifcdocument']);
  Route::post('/ifcresposible/person',  [IfcController::class, 'ifcresposiblePerson']);
  Route::get('/ifcdocuments',  [IfcController::class, 'ifcdocuments']);
  Route::get('echarts/ifc/{id}', [IfcController::class, 'echart']);

  Route::get('/employee_payroll',  [EmployeepayrollController::class, 'employee_payroll']);
  Route::post('/employeepayroll_update',  [EmployeepayrollController::class, 'employeepayroll_update']);


  // outstationconveyance routes
  Route::post('/conveyanceneft',  [OutstationconveyanceController::class, 'conveynace_neft']);
  Route::resource('/outstationconveyance', OutstationconveyanceController::class);
  Route::get('/assignmentoutstation',  [OutstationconveyanceController::class, 'assignmentOutstation']);
  Route::get('/assignmentfunctionn',  [OutstationconveyanceController::class, 'assignmentFunction']);
  Route::post('/outstationconveyanceupdate',  [OutstationconveyanceController::class, 'accountupdate']);
  Route::get('/conveyacnelocal',  [OutstationconveyanceController::class, 'conveyacnelocal']);
  Route::get('/conveyacneoutstation',  [OutstationconveyanceController::class, 'conveyacneoutstation']);

  // Gnatt route
  Route::get('/gnattchart', [GnattchartController::class, 'index']);
  Route::get('/gnattchart/assignlist', [GnattchartController::class, 'gnattchartAssignlist']);
  Route::get('/gnattchart/editassign/{id}', [GnattchartController::class, 'editAssign']);
  Route::post('/gnattchart/assign/update/{id}', [GnattchartController::class, 'updateAssign']);
  Route::post('/gnattchart/store', [GnattchartController::class, 'gnattStore']);
  Route::post('/ganttchart/upload', [GnattchartController::class, 'ganttUpload']);
  Route::post('/ganttchart/client/store', [GnattchartController::class, 'ganttchartClientStore']);

  //Assignmentfiles
  Route::resource('/assignmentfiles', AssignmentfolderfileController::class);
  Route::get('/assignmentfolderfiles/{id}', [AssignmentfolderfileController::class, 'index_list']);
  Route::post('/assignmentfiles/upload', [AssignmentfolderfileController::class, 'store']);
  Route::get('/bulkfile/delete/{id}', [AssignmentfolderfileController::class, 'destroy']);

  //Assignmentfolder
  Route::resource('/assignmentfolder', AssignmentfolderController::class);
  Route::get('/assignmentfolders/{id}', [AssignmentfolderController::class, 'indexlist']);
  Route::get('/assignmentfolderdelete/{id}', [AssignmentfolderController::class, 'assignmentfolderdelete']);
  Route::get('assignmentfoldernameupdate', [AssignmentfolderController::class, 'foldername_update']);
  Route::post('/assignmentfolder_nameupdate', [AssignmentfolderController::class, 'assignmentfolderupdate']);

  //Step routes
  Route::resource('/step', StepController::class);
  Route::get('/tags/create', [StepController::class, 'tag_create']);
  Route::get('/step/check/{id}', [StepController::class, 'checkList']);
  Route::post('/checklist/store', [StepController::class, 'checklistStore']);
  Route::post('/modify/excel', [StepController::class, 'excelStore']);
  Route::get('/viewassignment/{id}', [StepController::class, 'viewAssignment']);
  Route::delete('/uidindata/{id}', [StepController::class, 'UdinDelete'])->name('uidindata.delete');


  Route::get('/auditchecklist', [StepController::class, 'auditChecklist']);
  Route::get('/auditchecklistanswer', [StepController::class, 'auditchecklistAnswer']);
  Route::get('/deleteassignmentchecklist/{id}', [StepController::class, 'deleteassignmentChecklist']);
  Route::get('/assignmentudin/close/{id}', [StepController::class, 'assignmentclose']);
  Route::post('/assignmentudin/store', [StepController::class, 'UdinStore']);
  // Teamlogin routes
  Route::resource('/teamlogin', TeamloginController::class);

  // Teamprofile routes
  Route::resource('/teamprofile', TeamprofileController::class);

  // Development route
  Route::resource('/development', DevelopmentController::class);

  // Balance routes
  Route::resource('/balance', BalanceController::class);

  //  Connection routes
  Route::resource('/connection', ConnectionController::class);
  Route::get('/view/connection/{id}', [ConnectionController::class, 'viewConnection']);
  Route::get('/connectioncompanies/destroy/{id}', [ConnectionController::class, 'connectionDestroy']);
  Route::get('/connection/list/destroy/{id}', [ConnectionController::class, 'destroy']);

  //Auditchecklistanswer routes
  Route::post('/assignmentna', [ChecklistanswerController::class, 'assignment_na']);
  Route::post('/auditchecklistanswer/tag/store', [ChecklistanswerController::class, 'checklistAnswer_tag']);
  Route::get('/assignmentclosed', [ChecklistanswerController::class, 'assignmentclosed']);
  Route::post('/auditchecklistanswer/store', [ChecklistanswerController::class, 'checklistAnswer']);
  Route::get('/criticalnotes', [ChecklistanswerController::class, 'criticalNotesview']);
  Route::post('/criticalnotes/store', [ChecklistanswerController::class, 'criticalNotes']);
  Route::get('/assignmentlist/{id}', [ChecklistanswerController::class, 'assignmentList']);
  Route::post('/teammapping/update', [ChecklistanswerController::class, 'teammappingUpdate']);

  // ContractandSubscriptionController routes
  Route::resource('/contract', ContractandSubscriptionController::class);
  Route::get('/view/contract/{id}', [ContractandSubscriptionController::class, 'view']);

  // Client routes
  Route::get('/clientpan', [ClientController::class, 'clientpan']);
  Route::resource('/client', ClientController::class);
  Route::get('/client/contactedit/{id}', [ClientController::class, 'editContact']);
  Route::post('/client/contactupdate/{id}', [ClientController::class, 'contactUpdate']);
  Route::get('/client/destroy/{id}', [ClientController::class, 'destroyClient']);
  Route::get('/clientdocument/destroy/{id}', [ClientController::class, 'destroyClientdocument']);
  Route::get('/clientfile/delete/{id}', [ClientController::class, 'clientfileDelete']);
  Route::get('/clientcontact/delete/{id}', [ClientController::class, 'clientcontactDelete']);
  Route::get('/debtor/pdf/{id}', [ClientController::class, 'debtorPdf']);
  Route::get('/clientcontact', [ClientController::class, 'clientContact']);
  Route::get('/clientfile', [ClientController::class, 'clientFile']);
  Route::get('/clientfile/create', [ClientController::class, 'clientCreate']);
  Route::post('/clientfile/store', [ClientController::class, 'clientfileStore']);
  Route::post('/clientcontact/upload', [ClientController::class, 'clientcontactUpload']);
  Route::get('/clientdocument/open/{id}', [ClientController::class, 'clientdocumentOpen']);
  Route::post('/viewassignment/contactupdate', [ClientController::class, 'assignmentContactUpdate']);
  Route::get('/viewclient/{id}', [ClientController::class, 'viewClient']);
  Route::get('changeStatus',  [ClientController::class, 'changeStatus']);
  Route::post('/debtor/excel', [ClientController::class, 'debtorExcel']);
  Route::post('/admin/file', [ClientController::class, 'adminFile']);
  Route::get('/viewclientlist/{client_name}', [ClientController::class, 'viewclientlist']);
  Route::get('/client/add/{clientid?}', [ClientController::class, 'add']);

  // Service routes
  Route::resource('/service', ServiceController::class);

  // Creditnote routes
  Route::resource('/creditnote', CreditnoteController::class);
  Route::get('/creditnoteinvoice',  [CreditnoteController::class, 'invoiceList']);
  Route::get('/creditnoteinvoice/create',  [CreditnoteController::class, 'companyList']);
  Route::get('/creditnoteinvoices/create',  [CreditnoteController::class, 'companyCode']);

  // localconveyance routes
  Route::resource('/localconveyance', LocalconveyancesController::class);
  Route::get('/assignmentfunction',  [LocalconveyancesController::class, 'assignmentFunction']);

  // claim routes
  Route::resource('/reimbursementclaim', ReimbursementclaimController::class);
  Route::post('/reimbursementclaimupdate',  [ReimbursementclaimController::class, 'accountupdate']);
  Route::get('reimbursementclaimupdate', [ReimbursementclaimController::class, 'reimbursementclaimupdate']);

  // Asset routes
  Route::resource('/asset', AssetController::class);
  Route::post('/assetconfirm',  [AssetController::class, 'assetConfirm']);

  // holiday routes
  Route::resource('/holiday', HolidayController::class);
  Route::get('/holidays', [HolidayController::class, 'holidays']);
  Route::get('holiday/delete/{id}', [HolidayController::class, 'destroy']);

  // Timesheetrequest routes
  Route::get('/timesheetrequestlist', [TimesheetrequestController::class, 'index']);
  Route::get('/timesheetrequest/view/{id}', [TimesheetrequestController::class, 'show']);
  Route::post('/timesheetrequest/update/{id}',  [TimesheetrequestController::class, 'update']);
  Route::post('/timesheet/submit',  [TimesheetrequestController::class, 'timesheet_submit']);
  Route::get('/timesheetupdatesubmit', [TimesheetrequestController::class, 'timesheetupdatesubmit']);
  Route::post('/timesheetsubmits',  [TimesheetrequestController::class, 'timesheetsubmit']);
  Route::get('/timesheetsubmission', [TimesheetrequestController::class, 'timesheetsubmission']);


  // filter on timesheet routes
  // Route::get('/testclient', [TimesheetController::class, 'testclient']);
  // vcvc

  // it is implemented submitte timesheet tab on admin and patner 
  Route::get('/filter-dataadmin', [TimesheetController::class, 'filterDataAdmin']);

  // timesheet routes
  Route::get('/timesheet/destroy/{id}', [TimesheetController::class, 'destroy']);
  Route::get('/timesheet/mylist', [TimesheetController::class, 'timesheet_mylist']);

  Route::get('/timesheet/fulllist', [TimesheetController::class, 'full_list']);
  Route::get('/timesheet/allteamsubmitted', [TimesheetController::class, 'allteamsubmitted']);

  Route::get('/timesheet/teamlist', [TimesheetController::class, 'timesheet_teamlist']);
  Route::get('/timesheet/partnersubmitted', [TimesheetController::class, 'partnersubmitted']);

  Route::get('/filter-weeklist', [TimesheetController::class, 'filterweeklylist']);

  Route::get('/weeklylist', [TimesheetController::class, 'weeklylist']);
  Route::get('timesheet/search', [TimesheetController::class, 'show']);
  Route::get('timesheet/search', [TimesheetController::class, 'show']);
  Route::resource('/timesheet', TimesheetController::class);
  Route::get('/view/timesheet/{id}', [TimesheetController::class, 'view']);
  Route::get('/timesheet/edit/{date}', [TimesheetController::class, 'edit']);
  Route::post('/timesheet/updated/', [TimesheetController::class, 'update']);
  Route::post('timesheetexcel/store', [TimesheetController::class, 'timesheetexcelStore']);
  Route::post('timesheetrequest/store', [TimesheetController::class, 'timesheetrequestStore']);
  Route::get('/reportsection',  [TimesheetController::class, 'Reportsection']);
  Route::get('/filtersection',  [TimesheetController::class, 'filtersection']);




  // Conversion routes
  Route::resource('/conversion', ConversionController::class);
  Route::get('/conversionupdate',  [ConversionController::class, 'conversion']);
  Route::post('/connection/statusupdate',  [ConversionController::class, 'conversionUpdate']);

  // Trainingassessment routes

  Route::resource('/trainingassetsments', TrainingassessmentController::class);

  //candidateboarding routes
  //Route::get('/candidate/article/convert/{id}', [CandidateboardingController::class, 'articleconvert']);
  Route::resource('/candidateboarding', CandidateboardingController::class);
  Route::get('/candidateconvert/{id}', [CandidateboardingController::class, 'candidateconvert']);


  Route::get('/candidateupdate',  [CandidateboardingController::class, 'candidatedetails']);
  Route::post('/candidateonboarding/update',  [CandidateboardingController::class, 'candidateupdate']);

  Route::get('/articleupdate',  [CandidateboardingController::class, 'articledetails']);
  Route::post('/articleonboarding/update',  [CandidateboardingController::class, 'articleupdate']);

  Route::get('/capitallarticle', [CandidateboardingController::class, 'capitallarticle']);
  Route::post('/capitallarticlepreview', [CandidateboardingController::class, 'capitallarticlepreview'])
    ->name('capitallarticlepreview');

  Route::post('/candidate/article/convert/{id}', [CandidateboardingController::class, 'articleconvert'])
    ->name('articleconvert');


  // employeeonboarding routes
  Route::get('/employeeonboarding', [EmployeeonboardingController::class, 'index']);
  Route::get('/employeeonboarding/sendmail/{id}', [EmployeeonboardingController::class, 'sendMailform']);
  Route::post('/employeeonboarding/sendmailpreview/{id}', [EmployeeonboardingController::class, 'sendMailPreview']);
  Route::post('/employeeonboarding/sendmail/{id}', [EmployeeonboardingController::class, 'sendMail']);
  Route::get('/capitallcred', [EmployeeonboardingController::class, 'capitallcred'])->name('capitallcred');
  Route::post('/sendcapitallcred', [EmployeeonboardingController::class, 'sendcapitallcred'])->name('sendcapitallcred');

  //draftemail
  Route::resource('/draftemail', DraftemailController::class);

  // AnnualIndependenceDeclaration route
  Route::resource('annualindependencedeclaration', AnnualIndependenceDeclarationController::class);

  // ClientSpecificIndependenceDeclaration route
  Route::resource('clientspecificindependence', ClientSpecificIndependenceController::class);



  // Penality routes

  Route::resource('/penality', PenalityController::class);
  Route::post('/penality/update', [PenalityController::class, 'taskUpdate']);
  Route::get('/view/penality/{id}', [PenalityController::class, 'viewTask']);
  Route::post('/penality/complete', [PenalityController::class, 'taskComplete']);
  Route::get('penality/delete/{id}', [PenalityController::class, 'destroy']);
  Route::get('penality/list/{id}', [PenalityController::class, 'list']);


  // Task routes

  Route::resource('/task', TaskController::class);
  Route::get('/taskassignment',  [TaskController::class, 'taskAssignment']);
  Route::get('/taskassignment/{id}',  [TaskController::class, 'taskassignmentlist']);
  Route::post('/tasktrail/update', [TaskController::class, 'taskUpdate']);
  Route::post('/update/subtask', [TaskController::class, 'update_subtask']);
  Route::get('/view/task/{id}', [TaskController::class, 'viewTask']);
  Route::post('/task/complete', [TaskController::class, 'taskComplete']);
  Route::get('task/delete/{id}', [TaskController::class, 'destroy']);
  Route::get('task/repeat/{id}', [TaskController::class, 'task_repeat']);
  Route::get('task/list/{id}', [TaskController::class, 'list']);
  Route::post('/task/reminder',  [TaskController::class, 'taskMail']);
  Route::get('taskreport', [TaskController::class, 'Reportsection']);
  Route::get('/taskfiltersection',  [TaskController::class, 'taskfiltersection']);
  // Assetticket routes
  Route::post('/generateticket/store', [AssetticketController::class, 'ticketStore']);
  Route::post('/ticket/reply', [AssetticketController::class, 'ticketreplyDone']);
  Route::get('/ticket/{id}', [AssetticketController::class, 'ticketReply']);
  Route::get('/ticketsupport', [AssetticketController::class, 'index']);
  Route::get('/createticket', [AssetticketController::class, 'createTicket']);


  // databasebackup routes
  Route::resource('/backup', BackupController::class);
  Route::get('/dbbackup', [BackupController::class, 'dbBackup']);
  Route::get('download/{file}', [BackupController::class, 'getFiles']);

  //Tender routes
  Route::resource('/tender', TenderController::class);
  Route::get('/tender/list/{id}', [TenderController::class, 'List']);
  Route::get('/tender/view/{id}',  [TenderController::class, 'tenderView']);
  Route::post('tender/assigned',  [TenderController::class, 'tenderAssigned']);
  Route::post('tenderssigned/store',  [TenderController::class, 'tenderssignedStore']);
  Route::post('tendercreatedby/store',  [TenderController::class, 'tendercreatedBystore']);
  Route::get('tenderexpirelist',  [TenderController::class, 'tenderexpireList']);
  Route::post('tenderSubmit/store',  [TenderController::class, 'tenderSubmitstore']);
});

Route::get('/payroll-data', function (Request $request) {
  // Define the month you want to filter (e.g., May)
  $currentDate = now();
  $totalDays = now()->subMonth()->daysInMonth;
  $currentMonth = $currentDate->format('F');
  $currentYear = $currentDate->format('Y');

  if ($currentDate->day == 29) {
    $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
      ->where('attendances.month', $currentMonth)
      ->whereYear('attendances.created_at', $currentYear)
      ->get();


    foreach ($teammembers as $team) {

      $keysToFilter = [
        'twentysix',
        'twentyseven',
        'twentyeight',
        'twentynine',
        'thirty',
        'thirtyone',
        'one',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine',
        'ten',
        'eleven',
        'twelve',
        'thirteen',
        'fourteen',
        'fifteen',
        'sixteen',
        'seventeen',
        'eighteen',
        'ninghteen',
        'twenty',
        'twentyone',
        'twentytwo',
        'twentythree',
        'twentyfour',
        'twentyfive'
      ];

      $daysToRemove = [];

      if ($totalDays < 31) {
        $daysToRemove[] = 'thirtyone';
      }

      if ($totalDays < 30) {
        $daysToRemove[] = 'thirty';
      }

      if ($totalDays < 29) {
        $daysToRemove[] = 'twentynine';
      }

      $keysToFilter = array_diff($keysToFilter, $daysToRemove);



      $days = array_intersect_key($team->toArray(), array_flip($keysToFilter));

      $co = 0;
      $cl = 0;
      $sl = 0;
      $birthday = 0;
      $dayspresent = 0;
      $totalCount = 0;
      $absentCount = 0; //leave without pay
      $holidayCount = 0;

      $dayMapping = [
        'twentysix' => 26,
        'twentyseven' => 27,
        'twentyeight' => 28,
        'twentynine' => 29,
        'thirty' => 30,
        'thirtyone' => 31,
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
        'ten' => 10,
        'eleven' => 11,
        'twelve' => 12,
        'thirteen' => 13,
        'fourteen' => 14,
        'fifteen' => 15,
        'sixteen' => 16,
        'seventeen' => 17,
        'eighteen' => 18,
        'ninghteen' => 19,
        'twenty' => 20,
        'twentyone' => 21,
        'twentytwo' => 22,
        'twentythree' => 23,
        'twentyfour' => 24,
        'twentyfive' => 25,
      ];

      switch ($totalDays) {
        case 30:
          unset($dayMapping['thirtyone']);
          break;
        case 29:
          unset($dayMapping['thirtyone'], $dayMapping['thirty']);
          break;
        case 28:
          unset($dayMapping['thirtyone'], $dayMapping['thirty'], $dayMapping['twentynine']);
          break;
      }



      foreach ($days as $key => $value) {
        if ($value === null) {

          // Absent
          // Check if the day's date is not in the holidays table
          $dayOfMonth = $dayMapping[$key] ?? 0;

          $month = $currentMonth;

          if (in_array($dayOfMonth, [26, 27, 28, 29, 30, 31])) {
            // Adjust the month if the day falls within 26-31 range
            $currentDate = DateTime::createFromFormat('F', $currentMonth)->modify('first day of')->format('Y-m-d');
            $previousMonth = DateTime::createFromFormat('Y-m-d', $currentDate)->modify('-1 month')->format('F');
            $month = $previousMonth;
          }
          $monthNumeric = date('m', strtotime($month));
          $absentDate = date('Y-m-d', strtotime("$currentYear-$monthNumeric-$dayOfMonth"));
          //echo "$dayOfMonth: $absentDate\n";

          $isHoliday = DB::table('holidays')->where(function ($query) use ($absentDate) {
            $query->where('startdate', '<=', $absentDate)
              ->where('enddate', '>=', $absentDate);
          })->exists();


          if (!$isHoliday) {
            // Absent
            // Increment the absent count
            $absentCount++;
          } else {
            $holidayCount++;
          }
          continue;
        }

        switch ($value) {
          case 'CO/A':
          case 'CO/C':
            $co++;
            break;
          case 'CL/A':
          case 'CL/C':
            $cl++;
            break;
          case 'SL/A':
          case 'SL/C':
            $sl++;
            break;
          case 'EL/A':
          case 'EL/C':
            // Do nothing
            break;
          case 'BL/A':
          case 'BL/C':
            $birthday++;
            break;
          default:

            $dayspresent++;
            break;
        }
      }


      $totalCount = $dayspresent + $cl + $sl + $co + $birthday + $holidayCount;

      if ($team->monthly_gross_salary !== null) {
        $amount = ($team->monthly_gross_salary / $totalDays) * $totalCount;
      } else {
        $amount = 0;
      }

      if ($team->pf_applicable == 'No') {
        $totalAmountpaid = number_format($amount, 2, '.', '');
        $pfAmount = 0;
        $pfAmountEmployer = 0;
      } else {
        $basic = $amount * 0.4;

        if ($basic < 15000) {
          $pfAmount = $basic * 0.12;
          $pfAmountEmployer = $pfAmount;
        } else {
          $pfAmount = 1800;
          $pfAmountEmployer = $pfAmount;
        }

        $totalAmount = $amount - $pfAmount;
        $totalAmountpaid = number_format($totalAmount, 2, '.', '');
        $pfAmount = number_format($pfAmount, 2, '.', '');
        $pfAmountEmployer = number_format($pfAmountEmployer, 2, '.', '');
      }

      $payrollData = [
        'month' => $team->month,
        'teammember_id' => $team->employee_name,
        'no_of_day_present' => $totalCount,
        'day_to_be_paid' => $totalDays,
        'amount' => $totalAmountpaid,
        'employee_contribution' => $pfAmount,
        'employer_contribution' => $pfAmountEmployer,
        'advance' => 0,
        'tds' => 0,
        'Arrear' => 0,
        'bonus' => 0,
        'total_amount_to_paid' => $totalAmountpaid,
        'lwp' => $absentCount,
        'holiday' => $holidayCount,
      ];

      DB::table('employeepayrolls')->insert($payrollData);

      // Perform any further operations or calculations as needed
    }
    //dd("hii");
  }

  return "inserted";
});

Route::get('/attendance-data', function (Request $request) {
  // Define the month you want to filter (e.g., May)
  $currentDate = now()->modify('-1 day');
  $totalDays = now()->subMonth()->daysInMonth;
  $currentMonth = $currentDate->format('F');
  $currentYear = $currentDate->format('Y');

  if ($currentDate->day == 30) {
    $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
      ->where('attendances.month', $currentMonth)
      ->whereYear('attendances.created_at', $currentYear)
      ->get();


    foreach ($teammembers as $team) {

      $keysToFilter = [
        'twentysix',
        'twentyseven',
        'twentyeight',
        'twentynine',
        'thirty',
        'thirtyone',
        'one',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine',
        'ten',
        'eleven',
        'twelve',
        'thirteen',
        'fourteen',
        'fifteen',
        'sixteen',
        'seventeen',
        'eighteen',
        'ninghteen',
        'twenty',
        'twentyone',
        'twentytwo',
        'twentythree',
        'twentyfour',
        'twentyfive'
      ];

      $daysToRemove = [];

      if ($totalDays < 31) {
        $daysToRemove[] = 'thirtyone';
      }

      if ($totalDays < 30) {
        $daysToRemove[] = 'thirty';
      }

      if ($totalDays < 29) {
        $daysToRemove[] = 'twentynine';
      }

      $keysToFilter = array_diff($keysToFilter, $daysToRemove);



      $days = array_intersect_key($team->toArray(), array_flip($keysToFilter));

      $co = 0;
      $cl = 0;
      $sl = 0;
      $birthday = 0;
      $dayspresent = 0;
      $totalCount = 0;
      $absentCount = 0; //leave without pay
      $holidayCount = 0;

      $dayMapping = [
        'twentysix' => 26,
        'twentyseven' => 27,
        'twentyeight' => 28,
        'twentynine' => 29,
        'thirty' => 30,
        'thirtyone' => 31,
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
        'ten' => 10,
        'eleven' => 11,
        'twelve' => 12,
        'thirteen' => 13,
        'fourteen' => 14,
        'fifteen' => 15,
        'sixteen' => 16,
        'seventeen' => 17,
        'eighteen' => 18,
        'ninghteen' => 19,
        'twenty' => 20,
        'twentyone' => 21,
        'twentytwo' => 22,
        'twentythree' => 23,
        'twentyfour' => 24,
        'twentyfive' => 25,
      ];

      switch ($totalDays) {
        case 30:
          unset($dayMapping['thirtyone']);
          break;
        case 29:
          unset($dayMapping['thirtyone'], $dayMapping['thirty']);
          break;
        case 28:
          unset($dayMapping['thirtyone'], $dayMapping['thirty'], $dayMapping['twentynine']);
          break;
      }



      foreach ($days as $key => $value) {
        if ($value === null) {

          // Absent
          // Check if the day's date is not in the holidays table
          $dayOfMonth = $dayMapping[$key] ?? 0;

          $month = $currentMonth;

          if (in_array($dayOfMonth, [26, 27, 28, 29, 30, 31])) {
            // Adjust the month if the day falls within 26-31 range
            $currentDate = DateTime::createFromFormat('F', $currentMonth)->modify('first day of')->format('Y-m-d');
            $previousMonth = DateTime::createFromFormat('Y-m-d', $currentDate)->modify('-1 month')->format('F');
            $month = $previousMonth;
          }
          $monthNumeric = date('m', strtotime($month));
          $absentDate = date('Y-m-d', strtotime("$currentYear-$monthNumeric-$dayOfMonth"));
          //echo "$dayOfMonth: $absentDate\n";

          $isHoliday = DB::table('holidays')->where(function ($query) use ($absentDate) {
            $query->where('startdate', '<=', $absentDate)
              ->where('enddate', '>=', $absentDate);
          })->exists();


          if (!$isHoliday) {
            // Absent
            // Increment the absent count
            $absentCount++;
          } else {
            $holidayCount++;
          }
          continue;
        }

        switch ($value) {
          case 'CO/A':
          case 'CO/C':
            $co++;
            break;
          case 'CL/A':
          case 'CL/C':
            $cl++;
            break;
          case 'SL/A':
          case 'SL/C':
            $sl++;
            break;
          case 'EL/A':
          case 'EL/C':
            // Do nothing
            break;
          case 'BL/A':
          case 'BL/C':
            $birthday++;
            break;
          default:

            $dayspresent++;
            break;
        }
      }


      $totalCount = $dayspresent + $cl + $sl + $co + $birthday + $holidayCount;

      if ($team->monthly_gross_salary !== null) {
        $amount = ($team->monthly_gross_salary / $totalDays) * $totalCount;
      } else {
        $amount = 0;
      }

      if ($team->pf_applicable == 'No') {
        $totalAmountpaid = number_format($amount, 2, '.', '');
        $pfAmount = 0;
        $pfAmountEmployer = 0;
      } else {
        $basic = $amount * 0.4;

        if ($basic < 15000) {
          $pfAmount = $basic * 0.12;
          $pfAmountEmployer = $pfAmount;
        } else {
          $pfAmount = 1800;
          $pfAmountEmployer = $pfAmount;
        }

        $totalAmount = $amount - $pfAmount;
        $totalAmountpaid = number_format($totalAmount, 2, '.', '');
        $pfAmount = number_format($pfAmount, 2, '.', '');
        $pfAmountEmployer = number_format($pfAmountEmployer, 2, '.', '');
      }

      $payrollData = [


        'no_of_days_present' => $dayspresent,
        'totaldaystobepaid' => $totalCount,
        'total_no_of_days' => $totalDays,
        'lwp' => $absentCount,
        'casual_leave' => $cl,
        'sick_leave' => $sl,
        'comp_off' => $co,
        'birthday_religious' => $birthday
      ];
      // dd($currentMonth);
      DB::table('attendances')->where('employee_name', $team->employee_name)->where('month', $currentMonth)->update($payrollData);

      // Perform any further operations or calculations as needed
    }
    //dd("hii");
  }

  return "inserted";
});

Route::get('/payroll-data', function (Request $request) {
  // Define the month you want to filter (e.g., May)
  $currentDate = now()->modify('-2 day');
  // $totalDays = now()->subMonth()->daysInMonth;
  $totalDays = 30;
  $currentMonth = $currentDate->format('F');
  $currentYear = $currentDate->format('Y');

  if ($currentDate->day == 31) {
    $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
      ->where('teammembers.role_id', '!=', 15)
      ->where('teammembers.role_id', '!=', 19)
      ->where('teammembers.status', '=', 1)
      ->whereNotIn('teammembers.id', [336, 169, 256, 341, 161])
      ->where('attendances.month', $currentMonth)
      ->whereYear('attendances.created_at', $currentYear)
      ->distinct()
      ->get();

    $teammemberfullpay = Teammember::where('timesheet_applicable', "No")->get();
    // dd($teammemberfullpay);
    foreach ($teammemberfullpay as $team) {

      if ($team->timesheet_applicable !== null) {
        if ($team->monthly_gross_salary !== null) {
          $amount = $team->monthly_gross_salary;
        } else {
          $amount = 0;
        }
      }

      if ($team->pf_applicable == 'No') {
        $totalAmountpaid = number_format($amount, 2, '.', '');
        $pfAmount = 0;
        $pfAmountEmployer = 0;
      } else {
        $basic = $amount * 0.4;

        if ($basic < 15000) {
          $pfAmount = $basic * 0.12;
          $pfAmountEmployer = $pfAmount;
        } else {
          $pfAmount = 1800;
          $pfAmountEmployer = $pfAmount;
        }

        $totalAmount = $amount - $pfAmount;
        $totalAmountpaid = number_format($totalAmount, 2, '.', '');
        $pfAmount = number_format($pfAmount, 2, '.', '');
        $pfAmountEmployer = number_format($pfAmountEmployer, 2, '.', '');
      }


      $payrollData = [
        'month' => "May",
        'teammember_id' => $team->id,
        'no_of_day_present' => 30,
        'sl' => 0,
        'cl' => 0,
        'co' => 0,
        'birthday' => 0,
        'totaldays' => 30,
        'day_to_be_paid' => 30,
        'amount' => $amount,
        'employee_contribution' => $pfAmount,
        'employer_contribution' => $pfAmountEmployer,
        'advance' => 0,
        'tds' => 0,
        'Arrear' => 0,
        'bonus' => 0,
        'total_amount_to_paid' => $totalAmountpaid,
        'lwp' => 0,
        'holiday' => 0,
      ];

      DB::table('employeepayrolls')->insert($payrollData);
    }

    foreach ($teammembers as $team) {

      $keysToFilter = [
        'twentysix',
        'twentyseven',
        'twentyeight',
        'twentynine',
        'thirty',
        'thirtyone',
        'one',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine',
        'ten',
        'eleven',
        'twelve',
        'thirteen',
        'fourteen',
        'fifteen',
        'sixteen',
        'seventeen',
        'eighteen',
        'ninghteen',
        'twenty',
        'twentyone',
        'twentytwo',
        'twentythree',
        'twentyfour',
        'twentyfive'
      ];

      $daysToRemove = [];

      if ($totalDays < 31) {
        $daysToRemove[] = 'thirtyone';
      }

      if ($totalDays < 30) {
        $daysToRemove[] = 'thirty';
      }

      if ($totalDays < 29) {
        $daysToRemove[] = 'twentynine';
      }

      $keysToFilter = array_diff($keysToFilter, $daysToRemove);



      $days = array_intersect_key($team->toArray(), array_flip($keysToFilter));

      $co = 0;
      $cl = 0;
      $sl = 0;
      $birthday = 0;
      $dayspresent = 0;
      $totalCount = 0;
      $absentCount = 0; //leave without pay
      $holidayCount = 0;

      $dayMapping = [
        'twentysix' => 26,
        'twentyseven' => 27,
        'twentyeight' => 28,
        'twentynine' => 29,
        'thirty' => 30,
        'thirtyone' => 31,
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
        'ten' => 10,
        'eleven' => 11,
        'twelve' => 12,
        'thirteen' => 13,
        'fourteen' => 14,
        'fifteen' => 15,
        'sixteen' => 16,
        'seventeen' => 17,
        'eighteen' => 18,
        'ninghteen' => 19,
        'twenty' => 20,
        'twentyone' => 21,
        'twentytwo' => 22,
        'twentythree' => 23,
        'twentyfour' => 24,
        'twentyfive' => 25,
      ];

      switch ($totalDays) {
        case 30:
          unset($dayMapping['thirtyone']);
          break;
        case 29:
          unset($dayMapping['thirtyone'], $dayMapping['thirty']);
          break;
        case 28:
          unset($dayMapping['thirtyone'], $dayMapping['thirty'], $dayMapping['twentynine']);
          break;
      }



      foreach ($days as $key => $value) {
        if ($value === null) {

          // Absent
          // Check if the day's date is not in the holidays table
          $dayOfMonth = $dayMapping[$key] ?? 0;

          $month = $currentMonth;

          if ($dayOfMonth >= 26 && $dayOfMonth <= 31) {
            $currentDate = new DateTime("{$currentMonth}-{$dayOfMonth}");
            $currentDate->modify('-1 month');
            $month = $currentDate->format('F');
            $monthNumeric = $currentDate->format('m');
          } else {
            $monthNumeric = date('m', strtotime($currentMonth));
          }


          $absentDate = date('Y-m-d', strtotime("$currentYear-$monthNumeric-$dayOfMonth"));

          $isHoliday = DB::table('holidays')->where(function ($query) use ($absentDate) {
            $query->where('startdate', '<=', $absentDate)
              ->where('enddate', '>=', $absentDate);
          })->exists();


          if ($isHoliday) {
            if ($team->joining_date < $absentDate) {
              $holidayCount++;
            }
          }
          continue;
        }

        switch ($value) {
          case 'CO/A':
          case 'CO/C':
            $co++;
            break;
          case 'CL/A':
          case 'CL/C':
            $cl++;
            break;
          case 'SL/A':
          case 'SL/C':
            $sl++;
            break;
          case 'EL/A':
          case 'EL/C':
            // Do nothing
            break;
          case 'BL/A':
          case 'BL/C':
            $birthday++;
            break;
          case 'LWP':
            $absentCount++;
            break;

          default:

            $dayspresent++;
            break;
        }
      }


      //  $totalCount = $dayspresent + $cl + $sl + $co + $birthday +$holidayCount;
      $presentDaysWithHoliday = $dayspresent + $holidayCount;
      $totalCount = $presentDaysWithHoliday + $cl + $sl + $co + $birthday;

      if ($team->monthly_gross_salary !== null) {
        $amount = ($team->monthly_gross_salary / $totalDays) * $totalCount;
      } else {
        $amount = 0;
      }

      if ($team->pf_applicable == 'No') {
        $totalAmountpaid = number_format($amount, 2, '.', '');
        $pfAmount = 0;
        $pfAmountEmployer = 0;
      } else {
        $basic = $amount * 0.4;

        if ($basic < 15000) {
          $pfAmount = $basic * 0.12;
          $pfAmountEmployer = $pfAmount;
        } else {
          $pfAmount = 1800;
          $pfAmountEmployer = $pfAmount;
        }

        $totalAmount = $amount - $pfAmount;
        $totalAmountpaid = number_format($totalAmount, 2, '.', '');
        $pfAmount = number_format($pfAmount, 2, '.', '');
        $pfAmountEmployer = number_format($pfAmountEmployer, 2, '.', '');
      }

      $payrollData = [
        'month' => $team->month,
        'teammember_id' => $team->employee_name,
        'no_of_day_present' => $presentDaysWithHoliday,
        'sl' => $sl,
        'cl' => $cl,
        'co' => $co,
        'birthday' => $birthday,
        'totaldays' => $totalDays,
        'day_to_be_paid' => $totalCount,
        'amount' => $amount,
        'employee_contribution' => $pfAmount,
        'employer_contribution' => $pfAmountEmployer,
        'advance' => 0,
        'tds' => 0,
        'Arrear' => 0,
        'bonus' => 0,
        'total_amount_to_paid' => $totalAmountpaid,
        'lwp' => $absentCount,
        'holiday' => $holidayCount,
      ];
      DB::table('employeepayrolls')->insert($payrollData);

      // Perform any further operations or calculations as needed
    }
    //dd("hii");
  }

  return "inserted";
});
