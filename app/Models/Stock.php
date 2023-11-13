<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function stock_type()
    {
        return $this->belongsTo(StockType::class);
    }
}
