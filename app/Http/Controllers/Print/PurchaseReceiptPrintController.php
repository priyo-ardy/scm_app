<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;
use App\Models\PurchaseReceiptHeader;

class PurchaseReceiptPrintController extends Controller
{
    public function print(PurchaseReceiptHeader $record)
    {
        $record->load(['supplier', 'details.material', 'details.units']);

        return view('print.purchase-receipt', [
            'record' => $record
        ]);
    }
}
