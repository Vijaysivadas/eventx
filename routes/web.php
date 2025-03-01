<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\user\InboxController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\user\UserAnnouncementsController;
use App\Http\Controllers\user\UserEventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthManagerController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/user/login', [AuthManagerController::class, 'showUserLogin'])->name('user.login');
Route::post('/user/login', [AuthManagerController::class, 'loginUser'])->name('user.login.post');

Route::get('/user/register', [AuthManagerController::class, 'showUserRegister'])->name('user.register');
Route::post('/user/register', [AuthManagerController::class, 'registerUser'])->name('user.register.post');
//admin
Route::get('/admin/login', [AuthManagerController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthManagerController::class, 'loginAdmin'])->name('admin.login.post');

Route::get('/admin/register', [AuthManagerController::class, 'showAdminRegister'])->name('admin.register');
Route::post('/admin/register', [AuthManagerController::class, 'registerAdmin'])->name('admin.register.post');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/jobs',[JobController::class, 'index'])->name('admin.jobs.index');
    Route::post('/jobs/create',[JobController::class, 'create'])->name('admin.jobs.create');
    Route::post('/jobs/delete/',[JobController::class, 'delete'])->name('admin.jobs.delete');
 Route::post('/jobs/approve/',[JobController::class, 'approve'])->name('admin.jobs.approve');
 Route::post('/jobs/decline/',[JobController::class, 'decline'])->name('admin.jobs.decline');
    Route::post('/logout', [AuthManagerController::class, 'logoutAdmin'])->name('admin.logout');
Route::get('/events',[EventsController::class, 'index'])->name('admin.events');
Route::post('/events/create',[EventsController::class, 'create'])->name('admin.events.create');
Route::post('/events/delete',[EventsController::class, 'delete'])->name('admin.events.delete');
Route::get('/announcements',[AnnouncementController::class, 'index'])->name('admin.announcements');
Route::post('/announcements/create',[AnnouncementController::class, 'sendMessage'])->name('admin.announcements.create');
Route::post('/announcements/delete',[AnnouncementController::class, 'delete'])->name('admin.announcements.delete');
});
Route::group(['prefix' => 'user', 'middleware' => 'auth:web'], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('/events', [UserEventController::class, 'index'])->name('user.events');
    Route::post('/events/apply', [UserEventController::class, 'apply'])->name('user.events.apply');
    Route::get('/inbox', [InboxController::class, 'index'])->name('user.inbox');
Route::post('/inbox/apply', [InboxController::class, 'apply'])->name('user.inbox.apply');
Route::get('/announcements', [UserAnnouncementsController::class, 'index'])->name('user.announcements');
    Route::post('/logout', [AuthManagerController::class, 'logoutUser'])->name('user.logout');
});

Route::post('/logout', function () {
Auth::logout();
return redirect()->route('login')->with('success', 'Logged out successfully.');
})->name('logout')->middleware('auth');
