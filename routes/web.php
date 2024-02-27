<?php

use Illuminate\Support\Facades\Route;
Route::prefix('admin')->group(function(){
    require __DIR__.'/admin.php';
});
