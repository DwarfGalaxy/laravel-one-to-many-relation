<?php

use App\Http\Controllers\Admin\BlogController;
use Illuminate\Support\Facades\Route;

Route::resources([
    'blogs'=>BlogController::class,
]);