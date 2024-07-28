<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Storage\Http\Controllers\IconFetchController;
use Narsil\Storage\Http\Controllers\ImageFetchController;

#endregion

Route::middleware([
    'web'
])->group(function ()
{
    Route::get('icons/fetch', IconFetchController::class)->name('icons.fetch');
    Route::get('images/fetch', ImageFetchController::class)->name('icons.fetch');
});
