<?php

use Illuminate\Support\Facades\Route;
use Webkul\DownloadLinks\Http\Controllers\Admin\DownloadCustomerLinkController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::get('/download-customer-links', [DownloadCustomerLinkController::class, 'index'])->name('download-customer-links.admin.index');
    Route::get('/download-customer-links/{id}', [DownloadCustomerLinkController::class, 'view'])->name('download-customer-links.admin.view');
    Route::post('/download-customer-links/send-file/{id}', [DownloadCustomerLinkController::class, 'sendFile'])->name('downloadable-links.admin.send-file');
    Route::get('/download-customer-links/downloadable-link/{id}', [DownloadCustomerLinkController::class, 'downloadableLink'])->name('downloadable-links.admin.download-link');
    Route::post('/download-customer-links/store', [DownloadCustomerLinkController::class, 'store'])->name('download-customer-links.admin.store');
   // Route::post('/download-customer-links/update-stock-status', [DownloadCustomerLinkController::class, 'updateStockStatus'])->name('download-customer-links.admin.updateStockStatus');
});