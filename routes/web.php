<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\PrintReportController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\EmailNotificationController;

Route::get('/', [CustomAuthController::class, 'home']); 
Route::get('signup', [CustomAuthController::class, 'signup'])->name('register');
Route::post('postsignup', [CustomAuthController::class, 'signupsave'])->name('register');


//menu validasi
Route::get('showpdf', [EventsController::class, 'showpdf'])->name('showpdf');
Route::get('events/accept{id}',[EventsController::class, 'accept'])->name('accept');
Route::get('events/deny{id}',[EventsController::class, 'deny'])->name('deny');
Route::get('events/sendEmail{id}',[EventsController::class, 'sendEmail'])->name('sendEmail');
Route::get('events/cancelOrder{id}',[EventsController::class, 'cancelOrder'])->name('cancelOrder');
Route::get('events/bookRoom{id}',[BookingsController::class, 'bookRoom'])->name('bookRoom');


Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});


route::auth();
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Rooms
    Route::delete('rooms/destroy', 'RoomsController@massDestroy')->name('rooms.massDestroy');
    Route::resource('rooms', 'RoomsController');

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::resource('events', 'EventsController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');

    Route::get('search-room', 'BookingsController@searchRoom')->name('searchRoom');
    Route::post('book-room', 'BookingsController@bookRoom')->name('bookRoom');

    Route::get('my-credits', 'BalanceController@index')->name('balance.index');
    Route::post('add-balance', 'BalanceController@add')->name('balance.add');

    Route::resource('transactions', 'TransactionsController')->only(['index']);    
    
    
});
