<?php
// File: packages/mpemburn/rolevue/routes/api.php

use Illuminate\Support\Facades\Route;

Route::apiResource('roles', RolesController::class);
Route::apiResource('permissions', PermissionsController::class);
Route::apiResource('user_roles', UserRolesController::class)->only('index', 'show', 'store');
