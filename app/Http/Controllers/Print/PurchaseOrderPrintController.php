<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrderHeader;

class PurchaseOrderPrintController extends Controller
{
    public function print(PurchaseOrderHeader $record)
    {
        $record->load(['supplier', 'details.material', 'details.units', 'company']);

        return view('print.purchase-order', [
            'record' => $record,
        ]);
    }
}
