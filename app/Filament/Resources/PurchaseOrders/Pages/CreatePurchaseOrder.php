<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['doc_status'] = 'approved';

        $totalAmount = 0;
        $totalTax = 0;

        if (isset($data['details'])) {
            foreach ($data['details'] as $detail) {
                $amount = (float) str_replace(',', '', $detail['total_amount'] ?? 0);
                $tax = (float) str_replace(',', '', $detail['tax_amount'] ?? 0);

                $totalAmount += $amount;
                $totalTax += $tax;
            }
        }

        $data['total_amount'] = $totalAmount;
        $data['tax_amount'] = $totalTax;

        return $data;
    }
}
