<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function detail(): Attribute
    {
        return Attribute::make(get: fn(mixed $value) => json_decode($value));
    }
}
