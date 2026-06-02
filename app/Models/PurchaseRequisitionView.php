<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequisitionView extends Model
{
    protected $table = 'vw_purchase_requisition';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
}
