<?php

use App\Http\Controllers\Web\Auth\PasswordController;
use App\Http\Controllers\Web\Auth\ProfileController;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'));

    Route::prefix('login/')->name('login')->controller(\App\Http\Controllers\Web\Auth\LoginController::class)->group(function () {
        Route::get('/', 'create');
        Route::post('/', 'store');
    });

    Route::prefix('register/')->name('register')->controller(\App\Http\Controllers\Web\Auth\RegisterController::class)->group(function () {
        Route::get('/', 'create');
        Route::post('/', 'store');
    });
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', \App\Http\Controllers\Web\Auth\LogoutController::class)->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/telegram', \App\Http\Controllers\Web\Telegram::class)->name('telegram.link');
    Route::get('/edit-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::post('/update-password', [PasswordController::class, 'update'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('calendar.index'));
    Route::get('/calendar', \App\Http\Controllers\Web\CalendarController::class)->name('calendar.index');

    Route::prefix('events')->name('event.')->controller(\App\Http\Controllers\Web\EventController::class)->group(function () {
        Route::get('/edit/{event}', 'edit')->name('edit');
        Route::put('/update/{event}', 'update')->name('update');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::post('/destroy/{event} ', 'destroy')->name('destroy');
    });

    Route::prefix('reminders')->name('reminder.')->controller(\App\Http\Controllers\Web\ReminderController::class)->group(function () {
        Route::get('/edit/{reminder}', 'edit')->name('edit');
        Route::put('/update/{reminder}', 'update')->name('update');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::post('/destroy/{reminder} ', 'destroy')->name('destroy');
    });
});

Route::post('/telegram-webhook', function (\Illuminate\Http\Request $request) {
    $update = $request->all();
    if (isset($update['message']['text']) && $update['message']['text'] === '/start') {
        $chatId = $update['message']['chat']['id'];
        $firstName = $update['message']['chat']['first_name'] ?? 'User';
        \Illuminate\Support\Facades\Log::info("Користувач {$firstName} (chat_id: {$chatId}) натиснув /start");
    }
    return response()->json(['ok' => true]);
});
