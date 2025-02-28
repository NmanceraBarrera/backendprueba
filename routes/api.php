<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserFilterController;
use App\Http\Controllers\UserStatsController;
use App\Http\Controllers\ActivityController;

Route::middleware('auth:sanctum')->get('/activities', [ActivityController::class, 'index']);
Route::get('/usuarios/estadisticas', [UserStatsController::class, 'estadisticas']);

Route::post('/usuarios/filtro', [UserFilterController::class, 'filtro']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/reportes/usuarios-30-dias', [usuarioController::class, 'usersLast30Days']);
Route::get('/reportes/logins-usuarios', [usuarioController::class, 'loginCounts']);
Route::get('/reportes/usuarios-creados-dia', [usuarioController::class, 'usersCreatedPerDay']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/users', [usuarioController::class, 'index']
);

Route::get('/users/{id}', [usuarioController::class, 'unUsuario']
);

Route::post('/users', [usuarioController::class, 'crear']
);



Route::put('/users/{id}', [usuarioController::class, 'actualizar']
);

Route::delete('/users/{id}', [usuarioController::class, 'eliminar']
);
