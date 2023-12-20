<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;

Route::post('/feedback',[FeedbackController::class, 'storeFeedback']);
Route::get('/feedback-list', [FeedbackController::class, 'listFeedbacks']);