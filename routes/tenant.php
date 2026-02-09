<?php

declare(strict_types=1);

use App\Http\Controllers\App\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return redirect()->route('app.login');
    });

    // Auth Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('app.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('app.logout');

    Route::middleware('auth')->get('/dashboard', function () {
        return 'You are logged in! <form action="'.route('app.logout').'" method="POST">'.csrf_field().'<button type="submit">Logout</button></form>';
    })->name('tenant.dashboard');
});
