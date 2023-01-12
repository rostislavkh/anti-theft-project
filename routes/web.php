<?php

use Illuminate\Support\Facades\Route;

Route::get('/security-project', function () {

    $is_active = true;

    $path = config('security.url') . '/is-active/' . config('security.slug');

    try {
        $is_active = json_decode(file_get_contents($path)) == false ? false : true;
    } catch (Exception $e) {
        $is_active = true;
    }

    if (Route::getCurrentRoute()->getName() != 'security-project' && !$is_active) {
        return view('security');
    }

    return redirect()->route('login');
})->name('security-project');