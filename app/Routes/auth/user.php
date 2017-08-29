<?php

Route::resource('users', 'Web\UsersController', ['only' => ['index']]);