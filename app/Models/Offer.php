<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'FK_shop_id',
        'offer_type',
        'offer_title',
        'offer_description',
        'offer_img_url',
        'offer_start_date',
        'offer_end_date',
        'offer_status',
        'create_by'
    ];
    public function seller()
    {
        return
            $this->hasOne(Seller::class,  'shop_id', 'FK_shop_id');
    }
}
