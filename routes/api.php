<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgenteParticipantePresupuesto;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LapMaestroController;
use App\Http\Controllers\AuthController;

Route::post('/feedback',[FeedbackController::class, 'storeFeedback']);
Route::get('/feedback-list', [FeedbackController::class, 'listFeedbacks']);
Route::get('/maestro/dni', [LapMaestroController::class, 'searchDni']);
Route::get('/maestro/name', [LapMaestroController::class, 'searchByName']);
Route::post('/lap-maestro', [LapMaestroController::class, 'storeLapMaestro']);
Route::get('/dashboard/laptops/entregadas', [LapMaestroController::class, 'laptopsEntregadas']);
Route::post('/laptops/entregadas', [LapMaestroController::class, 'laptopsEntregadasList']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refreshToken']);
Route::get('/report/list/maestros', [LapMaestroController::class, 'totalListMaestro']);
Route::get('/report/list/provincia', [LapMaestroController::class, 'totalLaptopsProvincia']);
Route::post('/agente/participante/presupuesto', [AgenteParticipantePresupuesto::class, 'store']);
Route::get('/agente', [AgenteParticipantePresupuesto::class, 'list'])->middleware('auth:api');