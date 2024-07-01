<?php

use Illuminate\Support\Facades\Route;
use Webkul\WriteProgram\Http\Controllers\Shop\WriteProgramController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'writeprogram'], function () {
    Route::get('', [WriteProgramController::class, 'index'])->name('shop.writeprogram.index');
});