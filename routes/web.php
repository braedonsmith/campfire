<?php

use App\Http\Controllers\KanbanController;
use App\Http\Middleware\CheckLoginAllowed;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified', CheckLoginAllowed::class])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::controller(KanbanController::class)->group(function() {
        Route::get('/kanban', 'listPage');
    });
});

require __DIR__.'/settings.php';
