<?php

use App\Http\Controllers\Print\PurchaseOrderPrintController;
use App\Http\Controllers\Print\PurchaseRequisitionPrintController;
use App\Models\PurchaseOrderHeader;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/print-pr/{record}', [PurchaseRequisitionPrintController::class, 'print'])
    ->name('print.pr')
    ->middleware(['auth']);

Route::get('/print-po/{record}', [PurchaseOrderPrintController::class, 'print'])
    ->name('print.po')
    ->middleware(['auth']);

Route::post('/purchase-orders/{record}/increment-print', function (PurchaseOrderHeader $record) {
    // Memanggil method increment yang benar dari Eloquent Laravel
    $record->increment('printed_count');

    return response()->json([
        'success' => true,
        'new_count' => $record->printed_count,
    ]);
})->name('purchase-orders.increment-print')->middleware(['auth']);

Route::get('/po-picker', \App\Livewire\PoPicker::class);
