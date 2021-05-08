<?php
// File: packages/mpemburn/rolevue/routes/api.php

use Illuminate\Support\Facades\Route;
use Mpemburn\RoleVue\Controllers\RolesController;
use Mpemburn\RoleVue\Controllers\PermissionsController;
use Mpemburn\RoleVue\Controllers\UserRolesController;

Route::apiResource('roles', RolesController::class);
Route::apiResource('permissions', PermissionsController::class);
Route::apiResource('user_roles', UserRolesController::class)->only('index', 'show', 'store');
