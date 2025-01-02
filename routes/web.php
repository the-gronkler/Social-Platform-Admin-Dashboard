<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\UsersServerController;

Route::get('/', function () {
    return redirect()->route('servers.index');
});

Route::resource('users', UserController::class);
Route::resource('servers', ServerController::class);


Route::controller(UsersServerController::class)->group(function () {
    Route::get('users_server/create-for-server/{server}', 'createForServer')->name('users_server.create-for-server');
    Route::get('users_server/create-for-user/{user}', 'createForUser')->name('users_server.create_for_user');
    Route::post('users_server/store', 'store')->name('users_server.store');
    Route::get('users_server/{users_server}', 'show')->name('users_server.show');
    Route::get('users_server/{users_server}/edit', 'edit')->name('users_server.edit');
    Route::put('users_server/{users_server}', 'update')->name('users_server.update');
    Route::delete('users_server/{users_server}', 'destroy')->name('users_server.destroy');
});
