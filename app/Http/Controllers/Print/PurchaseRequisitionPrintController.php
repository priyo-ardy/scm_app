<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequisitionHeader;
use Illuminate\Http\Request;

class PurchaseRequisitionPrintController extends Controller
{
    public function print(PurchaseRequisitionHeader $record)
    {
        $record->load(['details.supplier', 'details.material', 'details.units', 'company', 'department', 'requestor', 'creator', 'updater', 'approver',]);

        return view('print.purchase-request', [
            'record' => $record,
        ]);
    }
}
