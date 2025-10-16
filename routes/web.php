<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Administracion\PatrimonioController;
use App\Http\Controllers\Administracion\RrhhController;
use App\Http\Controllers\Informatica\FirmasdigitalesController;
use App\Http\Controllers\Informatica\IpsController;
use App\Http\Controllers\RoleController;

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::get('/permissions', [PermissionController::class, 'index'])->name('procesos.admin.permissions.index');

Route::middleware(['auth','can:procesos.admin.users.index'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('procesos.admin.users.index');
    Route::get('/users/{user}/roles', [UserController::class, 'editRoles'])->name('procesos.admin.users.roles.edit');
    Route::post('/users/{user}/roles', [UserController::class, 'updateRoles'])->name('procesos.admin.users.roles.update');

});

Route::middleware(['auth','can:procesos.admin.roles.index'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('procesos.admin.roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('procesos.admin.roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('procesos.admin.roles.store');
    // Nueva ruta para editar un rol
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('procesos.admin.roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('procesos.admin.roles.update');
});

//ADMINISTRACION
Route::middleware('auth','can:procesos.administracion.patrimonio.index')->group(function () {
    Route::resource('patrimonio', PatrimonioController::class)->names('procesos.administracion.patrimonio');
    Route::get('pdf/patrimonio/bien-asignado-acta/{id}', [PatrimonioController::class, 'exportarPDFAsignacion'])->name('pdf.patrimonio.bien-asignado-acta');
    Route::get('pdf/patrimonio/bieninformatico-traslado-acta/{id}', [PatrimonioController::class, 'exportarPDF'])->name('pdf.patrimonio.bieninformatico-traslado-acta');
});

Route::middleware('auth','can:procesos.administracion.rrhh.index')->group(function () {
    Route::resource('rrhh', RrhhController::class)->names('procesos.administracion.rrhh');
});

//INFORMATICA
Route::middleware('auth','can:procesos.informatica.ips.index')->group(function () {
    Route::resource('firmas', FirmasdigitalesController::class)->names('procesos.informatica.firmasdigitales');
    Route::get('pdf/informatica/token-acta/{id}', [FirmasdigitalesController::class, 'exportarPDF'])->name('pdf.informatica.token-acta');

    Route::resource('ips', IpsController::class)->names('procesos.informatica.ips');
    // Route::get('pdf/informatica/firmapc-acta/{id}', [IpsController::class, 'exportarPDF'])->name('pdf.informatica.firmapc-acta');
});

require __DIR__.'/auth.php';
