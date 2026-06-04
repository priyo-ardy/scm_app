<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderView extends Model
{
    protected $table = 'vw_purchase_order';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
}
