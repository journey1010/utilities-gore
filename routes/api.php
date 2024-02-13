<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LapMaestroController;

Route::post('/feedback',[FeedbackController::class, 'storeFeedback']);
Route::get('/feedback-list', [FeedbackController::class, 'listFeedbacks']);
Route::get('/maestro/dni', [LapMaestroController::class, 'searchDni']);
Route::get('/maestro/name', [LapMaestroController::class, 'searchByName']);
Route::post('/lap-maestro', [LapMaestroController::class, 'storeLapMaestro']);