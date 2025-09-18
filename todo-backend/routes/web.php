<?php


// Dans routes/web.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Routes de test
Route::get('/test', function () {
    return 'Laravel fonctionne !';
});

// Routes API temporaires dans web.php
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::get('/api/health', function () {
    return response()->json(['message' => 'Server is running!']);
});

// Testez maintenant :
// http://localhost:8000/api/health
