<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    
    public function seller()
    {
        return $this->hasOne(Seller::class, 'id', 'seller_id');
    }
}
