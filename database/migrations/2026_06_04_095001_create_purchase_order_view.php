<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_purchase_order");
        DB::statement("
            CREATE VIEW vw_purchase_order AS
            SELECT
                pod.id,
                poh.id as header_id,
                poh.code,
                poh.doc_date,
                poh.doc_status,
                poh.is_closed,
                poh.department_id,
                d.name as department_name,
                poh.supplier_id,
                s.name as supplier_name,
                poh.currency_id,
                c.name currency_name,
                poh.exchange_rate,
                poh.payment_term_id,
                pt.name as payment_term,
                poh.shipping_address,
                poh.remark,
                m.code as material_code,
                m.name as material_name,
                m.specification as material_specification,
                pod.unit_id,
                u.code as uom,
                pod.qty,
                pod.unit_price,
                pod.amount,
                pod.discount_rate,
                pod.discount_amount,
                pod.price_after_discount,
                pod.tax_rate,
                pod.tax_amount,
                pod.price_after_tax,
                pod.total_amount,
                pod.row_status,
                pod.is_closed as row_closed,
                pod.delivery_date,
                pod.remark as remark_detail
            FROM purchase_order_details pod
                LEFT JOIN purchase_order_headers poh ON pod.po_id = poh.id
                LEFT JOIN materials m ON pod.material_id = m.id
                LEFT JOIN units u ON pod.unit_id = u.id
                LEFT JOIN suppliers s ON poh.supplier_id = s.id
                LEFT JOIN departments d ON poh.department_id = d.id
                LEFT JOIN payment_terms pt ON poh.payment_term_id = pt.id
                LEFT JOIN currencies c ON poh.currency_id = c.id
            WHERE
                poh.deleted_at IS NULL
            ORDER BY poh.created_at DESC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_purchase_order");
    }
};
