<?php
// File: packages/mpemburn/rolevue/routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/roles', function () {
    return view('rolevue::roles.index');
})->name('roles');

Route::get('/permissions', function () {
    return view('rolevue::permissions.index');
})->name('permissions');

Route::get('/user_roles', function () {
    return view('rolevue::user-roles.index');
})->name('user_roles');
