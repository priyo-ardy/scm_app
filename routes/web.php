<?php

use App\Http\Controllers\Print\PurchaseRequisitionPrintController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/print-pr/{record}', [PurchaseRequisitionPrintController::class, 'print'])
    ->name('print.pr')
    ->middleware(['auth']);
