<?php

Route::resource('user', 'Api\UsersController', ['except' => ['show', 'create', 'edit']]);
Route::get('current-user', 'Api\CurrentUserController')->name('current.user');