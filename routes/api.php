<?php

use App\Http\Controllers\KanbanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/kanban/{kanbanItem}', response()->json(...));
    
    Route::controller(KanbanController::class)->group(function() {
        Route::get('/kanban', 'getAll');
        Route::post('/kanban', 'store');
    });
});
