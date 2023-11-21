<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function stock_type()
    {
        return $this->belongsTo(StockType::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function known_by_user()
    {
        return $this->belongsTo(User::class, 'known_by');
    }

    public function approved_by_user()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
