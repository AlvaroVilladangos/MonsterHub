<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\armorController;
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
use App\Http\Controllers\monsterController;
use App\Http\Controllers\roomController;
use App\Http\Controllers\weaponController;

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






Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/indexAdmin', [adminController::class, 'index']);

    Route::get('/usersAdmin', [adminController::class, 'users'])->name('usersAdmin');

    Route::resource('/hunter', hunterController::class)->only(['show']);

    Route::put('/blockUser/{id}', [adminController::class, 'blockUser'])->name('blockUser');
    Route::put('/unBlockUser/{id}', [adminController::class, 'unBlockUser'])->name('unBlockUser');

    Route::get('/guildsAdmin', [adminController::class, 'guilds'])->name('guildsAdmin');
    Route::delete('/guild/{id}/destroy', [guildController::class, 'destroy'])->name('guildDestroy');

    Route::get('/monstersAdmin', [adminController::class, 'monsters'])->name('monstersAdmin');
    Route::get('/monster/{id}/data', [monsterController::class, 'data']);
    Route::put('/monster/{id}/update', [monsterController::class, 'update'])->name('monsterUpdate');
    Route::delete('/monster/{id}/destroy', [monsterController::class, 'destroy'])->name('monsterDestroy');
    Route::post('/monsterCreate', [monsterController::class, 'store'])->name('monsterStore');
    Route::put('/monster/{id}/block', [monsterController::class, 'blockMonster'])->name('blockMonster');
    Route::put('/monster/{id}/unblock', [monsterController::class, 'unBlockMonster'])->name('unBlockMonster');

    Route::get('/weaponsAdmin', [adminController::class, 'weapons'])->name('weaponsAdmin');
    Route::get('/weapon/{id}/data', [weaponController::class, 'data']);
    Route::put('/weapon/{id}/update', [weaponController::class, 'update'])->name('weaponUpdate');
    Route::delete('/weapon/{id}/destroy', [weaponController::class, 'destroy'])->name('weaponDestroy');
    Route::post('/weaponCreate', [weaponController::class, 'store'])->name('weaponStore');
    Route::put('/weapon/{id}/block', [weaponController::class, 'blockWeapon'])->name('blockWeapon');
    Route::put('/weapon/{id}/unblock', [weaponController::class, 'unBlockWeapon'])->name('unBlockWeapon');

    Route::get('/armorsAdmin', [adminController::class, 'armors'])->name('armorsAdmin');
    Route::get('/armor/{id}/data', [armorController::class, 'data']);
    Route::put('/armor/{id}/update', [armorController::class, 'update'])->name('armorUpdate');
    Route::delete('/armor/{id}/destroy', [armorController::class, 'destroy'])->name('armorDestroy');
    Route::post('/armorCreate', [armorController::class, 'store'])->name('armorStore');
    Route::put('/armor/{id}/block', [armorController::class, 'blockArmor'])->name('blockArmor');
    Route::put('/armor/{id}/unblock', [armorController::class, 'unBlockArmor'])->name('unBlockArmor');

    Route::get('/hunter/{id}/comments', [adminController::class, 'hunterComments'])->name('hunterComments');

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

    Route::get('/dashboard', [hunterController::class, 'dashboard'])->name('dashboard');

    Route::get('/edit', [hunterController::class, 'edit'])->name('edit');
    Route::put('/edit', [hunterController::class, 'update'])->name('edit');

    Route::delete('/edit/comment/delete/{id}', [hunterController::class, 'destroyComment'])->name('comment.destroy');

    Route::resource('/guilds', guildController::class)->only(['index', 'create', 'store']);

    Route::resource('/guild', guildController::class)->middleware('checkLeader:guild') ->only(['edit', 'update', 'show']);
    Route::delete('/guild/{id}/destroy', [guildController::class, 'destroy'])->name('guildDestroy');

    Route::put('/guild/{guild}/join', [hunterController::class, 'joinGuild'])->middleware('checkguild')->name('hunter.joinGuild');

    Route::put('/hunter/leave', [hunterController::class, 'leaveGuild'])->name('hunter.leaveGuild');

    Route::put('/hunter/leaveRoom', [hunterController::class, 'leaveRoom'])->name('hunter.leaveRoom');
    Route::put('/hunter/joinRoom', [hunterController::class, 'joinRoom'])->name('hunter.joinRoom');

    Route::put('/guild/{guild}/expulsar/hunter/{member}', [guildController::class, 'expulsar'])->middleware('checkLeader:guild')->name('guild.expulsar');

    Route::put('/guild/{guild}/ascender/hunter/{member}', [guildController::class, 'ascender'])->middleware('checkLeader:guild')->name('guild.ascender');

    Route::resource('/hunter', hunterController::class)->only(['show']);

    Route::post('/hunter/{hunter/comment', [hunterController::class, 'comment'])->name('hunter.comment');

    Route::get('/hunters', [hunterController::class, 'index'])->name('hunters');

    Route::get('/rooms', [roomController::class, 'index'])->name('rooms');
   /*  Route::resource('/guilds', guildController::class)->middleware('checkguild')->only(['show']); */

    Route::resource('/guild', guildController::class)->only(['show']);

    Route::resource('/rooms', roomController::class)->only(['store']);

    Route::get('/friends', [hunterController::class, 'friendsList'])->name('friends');

    Route::post('/addfriend/{requesterId}/{receiverId}', [hunterController::class, 'addFriend'])->name('addfriend');

    Route::put('/accept', [hunterController::class, 'acceptFriend'])->name('acceptfriend');

    Route::delete('/delete', [hunterController::class, 'deleteFriend'])->name('deleteFriend');

});
