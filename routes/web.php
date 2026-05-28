<?php

use App\Http\Controllers\Print\PurchaseOrderPrintController;
use App\Http\Controllers\Print\PurchaseReceiptPrintController;
use App\Http\Controllers\Print\PurchaseRequisitionPrintController;
use App\Livewire\PoPicker;
use App\Models\PurchaseOrderHeader;
use App\Models\PurchaseReceiptHeader;
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

Route::get('/print-receipt/{record}', [PurchaseReceiptPrintController::class, 'print'])
    ->name('print.receipt')
    ->middleware(['auth']);

Route::post('/purchase-orders/{record}/increment-print', function (PurchaseOrderHeader $record) {
    // Memanggil method increment yang benar dari Eloquent Laravel
    $record->increment('printed_count');

    return response()->json([
        'success' => true,
        'new_count' => $record->printed_count,
    ]);
})->name('purchase-orders.increment-print')->middleware(['auth']);

Route::post('/purchase-receipt/{record}/increment-print', function (PurchaseReceiptHeader $record) {
    // Memanggil method increment yang benar dari Eloquent Laravel
    $record->increment('print_count');

    return response()->json([
        'success' => true,
        'new_count' => $record->print_count,
    ]);
})->name('purchase-receipt.increment-print')->middleware(['auth']);

Route::get('/po-picker', PoPicker::class);
