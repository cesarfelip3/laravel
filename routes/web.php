<?php

Route::get('roles', function () {
    $roles = Defender::rolesList();

    $roles = $roles->map(function ($name, $id) {
        return [
            'id' => $id,
            'name' => $name
        ];
    });

    dd($roles);
});

foreach (File::files(app()->path() . '/Routes/guest') as $file) {
    require $file;
}

Route::group(['middleware' => ['auth']], function () {
    foreach (File::files(app()->path() . '/Routes/auth') as $file) {
        require $file;
    }
});
