<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotifEmailController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\WebHookController;
use App\Http\Controllers\SubsListController;
use App\Mail\NotifEmail;
use App\Models\Subscriber;
use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Notification;

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

/*Route::get('/', function () {
    return view('welcome');
});*/


//Automatically show login page when entering site
Route::get('/', [LoginController::class, 'login'])->name('login');
//This route does the login process (sends username and password)
Route::post('loginprocess', [LoginController::class, 'loginprocess'])->name('loginprocess');

//Middleware(auth) -> only accessible for logged in users
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('logoutprocess', [LoginController::class, 'logoutprocess'])->name('logoutprocess')->middleware('auth');

//Register
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('registerprocess', [RegisterController::class, 'registerprocess'])->name('registerprocess');
Route::get('newuseradmin', [RegisterController::class, 'newuseradmin'])->name('newuseradmin');
Route::post('newuserprocess', [RegisterController::class, 'newuserprocess'])->name('newuserprocess');

Route::get('forgotpass', [RegisterController::class, 'forgotpass'])->name('forgotpass');
Route::post('forgotpass2', [RegisterController::class, 'forgotpass2'])->name('forgotpass2');
Route::post('changepass', [RegisterController::class, 'changepass'])->name('changepass');

//User List
Route::get('userlist', [UserListController::class, 'view'])->name('userlist');

//Edit and Delete users
Route::get('userlist/edit/{user_id}', [UserListController::class, 'edituser'])->name('edituser')->middleware('auth');
Route::post('userlist/save', [UserListController::class, 'updateuser'])->name('updateuser')->middleware('auth');
Route::get('userlist/del/{user_id}', [UserListController::class, 'deleteuser'])->name('deleteuser')->middleware('auth');
Route::get('userlist/ban/{user_id}', [UserListController::class, 'banuser'])->name('banuser')->middleware('auth');
Route::get('userlist/unban/{user_id}', [UserListController::class, 'unbanuser'])->name('unbanuser')->middleware('auth');

Route::get('setwebhook', [WebHookController::class, 'setwebhook'])->name('setwebhook');

//Manage subscribers (similar to user list but unable to update)
Route::get('subslist', [SubsListController::class, 'view'])->name('subslist');
Route::get('subslist/del/{sub_id}', [SubsListController::class, 'deletesub'])->name('deletesub')->middleware('auth');

Route::get('newmessage', [MessageController::class, 'newmessage'])->name('newmessage')->middleware('auth');
Route::post('savemessage', [MessageController::class, 'savemessage'])->name('savemessage')->middleware('auth');
Route::get('sendmessage', [MessageController::class, 'sendmessage'])->name('sendmessage')->middleware('auth');
Route::post('sendmessagep', [MessageController::class, 'sendmessagep'])->name('sendmessagep')->middleware('auth');
Route::get('sendmessage2', [MessageController::class, 'sendmessage2'])->name('sendmessage2')->middleware('auth');

Route::get('sendmenu', [MessageController::class, 'sendmenu'])->name('sendmenu')->middleware('auth');

Route::get('sendtestmail', [NotifEmailController::class, 'send'])->name('sendtestmail')->middleware('auth');

Route::get('testview', function() {
    return view('testview');
});

Route::get('profile', function() {
    return view('profile');
})->middleware('auth');
Route::get('settings', function() {
    if(Auth::user()->active == 1)
    return view('settings');
    else return view('banned');
})->middleware('auth');
Route::get('clearnotifhist', [MessageController::class, 'clearNotifHistory'])->name('clearnotifhist')->middleware('auth');

Route::get('editdetails', [LoginController::class, 'edit'])->name('editself')->middleware('auth');
Route::post('editdetails/save', [LoginController::class, 'update'])->name('updateself')->middleware('auth');

Route::get('messagelist', [MessageController::class, 'loadMessageList'])->name('messagelist');
Route::get('messagelist/edit/{id}', [MessageController::class, 'editMessage'])->name('editmessage')->middleware('auth');
Route::post('messagelist/save', [MessageController::class, 'updateMessage'])->name('updatemessage')->middleware('auth');
Route::get('messagelist/del/{id}', [MessageController::class, 'deleteMessage'])->name('deletemessage')->middleware('auth');

Route::get('banned', function() {
    return view('banned');
});

Route::get('registeremail/{sub_id}', [SubsListController::class, 'addsubmail'])->name('registeremail')->middleware('auth');
Route::post('registeremailproc', [SubsListController::class, 'registeremail'])->name('registeremailproc')->middleware('auth');
Route::post('/laravel-mailbox/mailgun/mime', [NotifEmailController::class, 'handlemailgun']);
Route::get('setdriver', [NotifEmailController::class, 'createDriver'])->name('setdriver');

Route::get('querylist', [MessageController::class, 'querylist'])->name('querylist')->middleware('auth');
Route::get('addsendquery', [MessageController::class, 'addquery'])->name('addsendquery')->middleware('auth');
Route::post('savequery', [MessageController::class, 'savequery'])->name('savequery')->middleware('auth');
Route::get('querylist/del/{id}', [MessageController::class, 'deleteQuery'])->name('deletequery')->middleware('auth');

Route::post('filtersubs', [SubsListController::class, 'filtersubs'])->name('filtersubs')->middleware('auth');
Route::get('exportexcel', [SubsListController::class, 'exportexcel'])->name('exportexcel')->middleware('auth');
Route::post('sortsubs', [SubsListController::class, 'sortsubs'])->name('sortsubs')->middleware('auth');

Route::get('notifhistory', function() {
    if(Auth::user()->active == 1) { 
        $notifs = Notification::with('message')->select('*')
                        ->groupBy('sent_at')->orderBy('sent_at', 'desc')->simplePaginate(10);
        return view('notifhistory', ['notifs' => $notifs]);
    }
    else return view('banned');
})->name('notifhistory')->middleware('auth');
Route::get('filternotifs', [MessageController::class, 'filternotifs'])->name('filternotifs')->middleware('auth');
Route::post('findmessage', [MessageController::class, 'findmessage'])->name('findmessage')->middleware('auth');