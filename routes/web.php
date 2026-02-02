<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('{student}/pdf', [InvoiceController::class, 'generatePdf'])
    ->name('student.pdf');
