<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\StaffrequestController;
use App\Http\Controllers\Api\TeammemberController;
use App\Http\Controllers\Api\FinanceController;
use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\Api\TenderController;
use App\Http\Controllers\Api\KnowledgebaseController;
use App\Http\Controllers\Api\AssetticketController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ClientloginController;
use App\Http\Controllers\Api\ClientinformationController;
use App\Http\Controllers\Api\ApplyleaveController;
use App\Http\Controllers\Api\AssetprocurementController;
use App\Http\Controllers\Api\AdvanceclaimController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\CheckInController;
use App\Http\Controllers\Api\DiscussController;
use App\Http\Controllers\Api\AssignmentwithclientController;
use App\Http\Controllers\Api\TimesheetController;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [UserController::class, 'login']);
Route::post('newuser', [UserController::class, 'newUser']);
Route::post('connectionlist', [ConnectionController::class, 'connectionList']);
Route::post('connectionupdate', [ConnectionController::class, 'connectionUpdate']);
Route::post('connectiondelete', [ConnectionController::class, 'connectionDelete']);
Route::post('insertconnection', [ConnectionController::class, 'insertConnection']);
Route::post('userdetail', [UserController::class, 'userDetail']);
Route::post('userupdate', [UserController::class, 'userUpdate']);
Route::post('inserttask', [TaskController::class, 'insertTask']);
Route::post('tasklist', [TaskController::class, 'taskList']);
Route::post('task/count', [TaskController::class, 'taskListCount']);
Route::post('staffrequest', [StaffrequestController::class, 'staffRequest']);
Route::post('staffrequestlist', [StaffrequestController::class, 'staffrequestList']);
 Route::post('ticketreplylist', [TicketController::class, 'ticketreplyList']);
Route::post('taskcomplete', [TaskController::class, 'taskComplete']);
Route::post('taskdetail', [TaskController::class, 'task_detail']);
Route::post('teammemberlist', [TeammemberController::class, 'teammemberList']);
Route::post('calendar/fetchbyid', [CalendarController::class, 'calendarList']);
Route::post('tender/fetchbyid', [TenderController::class, 'tenderDetails']);
Route::post('knowledgebaselist', [KnowledgebaseController::class, 'knowledgebaseList']);
Route::post('outstanding', [FinanceController::class, 'outstanding']);
Route::post('home', [HomeController::class, 'homeList']);
   //ticket route
  Route::post('insertticket', [AssetticketController::class, 'insert']);
  Route::post('asset/fetchbyid', [AssetController::class, 'assetList']);
 Route::post('assetassignlist', [AssetController::class, 'assetassignList']);
  Route::post('generateticket', [TicketController::class, 'insertTicket']);
 Route::post('ticketreply', [TicketController::class, 'ticketReply']);
  Route::post('notificationlist', [NotificationController::class, 'notificationList']);
  Route::post('ticket/fetchbyid', [TicketController::class, 'ticketList']);
  
  Route::post('clientlogin', [ClientloginController::class, 'login']);
Route::post('clientotpresend', [ClientloginController::class, 'otpResend']);
Route::post('clientinformation', [ClientinformationController::class, 'information']);
Route::post('informationupdate', [ClientinformationController::class, 'informationUpdate']);

Route::post('leavelist', [ApplyleaveController::class, 'leave_List']);
Route::post('leaveapproval', [ApplyleaveController::class, 'leave_approval']);

Route::post('assetprocurement', [AssetprocurementController::class, 'assetprocurement_List']);
Route::post('assetprocurementinsert', [AssetprocurementController::class, 'assetprocurement_Insert']);
Route::post('assetprocurementupdate', [AssetprocurementController::class, 'update_status']);
Route::post('assetprocurementapproverlist', [AssetprocurementController::class, 'teammemberList']);
Route::post('advanceclaimlist', [AdvanceclaimController::class, 'List']);
Route::post('invoicelist', [InvoiceController::class, 'invoice_List']);
Route::post('clientlist', [CheckInController::class, 'clientlist']);
//created by vinita yadav

Route::post('/check-In/store', [CheckInController::class, 'store']);
Route::get('/check-In', [CheckInController::class, 'checkInList']);
Route::get('assignments/', [AssignmentwithclientController::class, 'findByClientId']);
//created by prashant pandey
Route::get('clientlist', [CheckInController::class, 'clientlist']);
Route::get('clientlisttask', [CheckInController::class, 'clientlisttask']);
Route::post('/discuss/create', [DiscussController::class, 'store']);
Route::get('/discuss', [DiscussController::class, 'index']);
Route::get('/discuss/view', [DiscussController::class, 'show']);
Route::post('/discuss/update', [DiscussController::class, 'discussupdate']);

Route::post('/discuss/delete',  [DiscussController::class, 'discussDelete']);
Route::post('/discuss/editupdate',  [DiscussController::class, 'Editupdate']);
// Created by Santosh kumar
Route::post('/timesheet/store', [TimesheetController::class, 'store']);
Route::post('/timesheet', [TimesheetController::class, 'index']);
Route::post('/timesheet/partner', [TimesheetController::class, 'partner']);
//Team by vinita
Route::post('/team', [HomeController::class, 'teamList']);