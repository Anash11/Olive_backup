<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        "FK_seller_id",
        "title",
        "terms",
        "description",
        "from_amount",
        "to_amount",
        "status",
        "create_by"
    ];
}
