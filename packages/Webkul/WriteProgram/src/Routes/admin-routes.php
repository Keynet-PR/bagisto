<?php

use Illuminate\Support\Facades\Route;
use Webkul\WriteProgram\Http\Controllers\Admin\WriteProgramController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/writeprogram'], function () {
    Route::controller(WriteProgramController::class)->group(function () {
        Route::get('', 'index')->name('admin.writeprogram.index');
    });
});