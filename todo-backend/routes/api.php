<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes des tâches
    Route::apiResource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted']);

    // Route pour récupérer l'utilisateur connecté
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});

// Health check
Route::get('/health', function () {
    return response()->json(['message' => 'Server is running!']);
});
