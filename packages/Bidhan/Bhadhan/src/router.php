<?php

use Bidhan\Bhadhan\Http\Controllers\SchemaController;
use Illuminate\Support\Facades\Route;

Route::get("check-check", function () {
    return view('Bhadhan::dashboard');
});

Route::get("bhadhan/db-manager/schema", [SchemaController::class, 'index'])
    ->name('bhadhan-db-manager.schema');

Route::get("bhadhan/db-manager/performance-metrics", [SchemaController::class, 'performanceMetrics'])
    ->name('bhadhan-db-manager.performance');
