<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;

/*
|--------------------------------------------------------------------------
| USER / PASIEN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\QueueController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\RatingController;

/*
|--------------------------------------------------------------------------
| AUTH VIEWS
|--------------------------------------------------------------------------
*/

/*
|------------------------------------------------------------------
| Login Pasien
|------------------------------------------------------------------
*/


/*
|------------------------------------------------------------------
| Login Admin
|------------------------------------------------------------------
*/

Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

/*
|--------------------------------------------------------------------------
| ROOT REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    // Belum login
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    // Admin
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Pasien
    return redirect()->route('user.dashboard');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze / Auth)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| REDIRECT AFTER LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/redirect', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Appointments
        |--------------------------------------------------------------------------
        */

        Route::resource('appointments', AppointmentController::class);

        Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

        Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class);
        });

        /*
        |--------------------------------------------------------------------------
        | Patients
        |--------------------------------------------------------------------------
        */

        Route::resource('patients', PatientController::class);

        /*
        |--------------------------------------------------------------------------
        | Doctors
        |--------------------------------------------------------------------------
        */

        Route::resource('doctors', DoctorController::class);

        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])
            ->name('reports.pdf');

        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings/profile', [SettingsController::class, 'profile'])
            ->name('settings.profile');

        Route::patch('/settings/profile', [SettingsController::class, 'updateProfile'])
            ->name('settings.update');
    });

/*
|--------------------------------------------------------------------------
| USER / PASIEN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [HomeController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Doctor Detail
        |--------------------------------------------------------------------------
        */

        Route::get('/doctors/{doctor}', [HomeController::class, 'showDoctor'])
            ->name('doctors.show');

        /*
        |--------------------------------------------------------------------------
        | Queue
        |--------------------------------------------------------------------------
        */

        Route::get('/queue', [QueueController::class, 'index'])
            ->name('queue.index');

        Route::get('/queue/create', [QueueController::class, 'create'])
            ->name('queue.create');

        Route::post('/queue/store', [QueueController::class, 'store'])
            ->name('queue.store');

        /*
        |--------------------------------------------------------------------------
        | Ticket
        |--------------------------------------------------------------------------
        */

        Route::get('/queue/{appointment}/ticket', [QueueController::class, 'ticket'])
            ->name('queue.ticket');

        /*
        |--------------------------------------------------------------------------
        | Payments
        |--------------------------------------------------------------------------
        */

        Route::get('/payments', [PaymentController::class, 'index'])
            ->name('payments.index');

        Route::get('/payments/{appointment}', [PaymentController::class, 'show'])
            ->name('payments.show');

        Route::get('/payments/{appointment}/pay', [PaymentController::class, 'pay'])
            ->name('payments.pay');

        Route::get('/ticket/{appointment}', [PaymentController::class, 'ticket'])
            ->name('ticket');

        /*
        |--------------------------------------------------------------------------
        | Ratings
        |--------------------------------------------------------------------------
        */

        Route::get('/ratings/{appointment}', [RatingController::class, 'create'])
            ->name('ratings.create');

        Route::post('/ratings/{appointment}', [RatingController::class, 'store'])
            ->name('ratings.store');

        /*
        |--------------------------------------------------------------------------
        | Account
        |--------------------------------------------------------------------------
        */

        Route::get('/account', [AccountController::class, 'index'])
        ->name('account.index');

        Route::get('/account/edit', [AccountController::class, 'edit'])
        ->name('account.edit');

        Route::put('/account/update', [AccountController::class, 'update'])
        ->name('account.update');
    });