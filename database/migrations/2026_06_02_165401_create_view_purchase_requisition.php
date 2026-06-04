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
        DB::statement("DROP VIEW IF EXISTS vw_purchase_requisition");
        DB::statement("
            CREATE VIEW vw_purchase_requisition AS
            select
                prd.id,
                prh.code,
                prh.doc_date,
                d.name as department_name,
                u.name as requestor,
                prh.priority,
                prh.doc_status,
                prh.is_closed,
                prh.reason,
                m.code as material_code,
                m.name as material_name,
                m.specification as material_specification,
                u2.code as uom,
                prd.qty,
                prd.qty_remaining,
                prd.remark,
                prd.is_closed as close_by_row
            from purchase_requisition_details prd
	            left join purchase_requisition_headers prh on prd.purchase_requisition_header_id = prh.id
	            left join departments d on prh.department_id = d.id
	            left join users u on prh.requester_id = u.id
	            left join materials m on prd.material_id = m.id
	            left join units u2 on prd.unit_id = u2.id
            where prh.deleted_at is null
            order by prh.code desc
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_purchase_requisition");
    }
};
