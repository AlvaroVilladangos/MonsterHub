<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\guildController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hunterController;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('/registrar', [RegisteredUserController::class, 'create'])->name('registrar');
    Route::post('/registrar', [RegisteredUserController::class, 'store'])->name('registrar.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/dashboard', [hunterController::class, 'index'])->name('dashboard');

    Route::get('/edit', [hunterController::class, 'edit'])->name('edit');
    Route::put('/edit', [hunterController::class, 'update'])->name('edit');

    Route::delete('/edit/comment/delete/{id}', [hunterController::class, 'destroyComment'])->name('comment.destroy');

    Route::resource('/guilds', guildController::class)->middleware('checkguild')->only(['index', 'create', 'store']);

    Route::resource('/guild', guildController::class)->middleware('checkLeader:guild') ->only(['edit', 'update',]);

    Route::put('/guild/{guild}/join', [guildController::class, 'join'])->middleware('checkguild')->name('guild.join');

    Route::put('/hunter/leave', [hunterController::class, 'leaveGuild'])->name('hunter.leaveGuild');

   /*  Route::resource('/guilds', guildController::class)->middleware('checkguild')->only(['show']); */

    Route::resource('/guild', guildController::class)->only(['show']);
});
