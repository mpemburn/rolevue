<?php
// File: packages/mpemburn/rolevue/routes/api.php
Route::apiResource('roles', 'RolesController');
Route::apiResource('permissions', 'PermissionsController');
Route::apiResource('user_roles', 'UserRolesController')->only('index', 'show', 'store');
