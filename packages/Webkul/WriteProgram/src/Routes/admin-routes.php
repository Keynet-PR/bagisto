<?php

use Illuminate\Support\Facades\Route;
use Webkul\WriteProgram\Http\Controllers\Admin\WriteProgramController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/writeprogram'], function () {
    Route::controller(WriteProgramController::class)->group(function () {
        Route::get('', 'index')->name('admin.writeprogram.index');
        Route::get('/{id}', 'view')->name('admin.writeprogram.view');
        Route::post('/{id}', 'store')->name('admin.writeprogram.send-file');
        Route::get('/download-file/{id}', 'downloadableFile')->name('admin.writeprogram.download-file');
        
       // Route::post('/download-customer-links/store', [DownloadCustomerLinkController::class, 'store'])->name('download-customer-links.admin.store');
    });
});