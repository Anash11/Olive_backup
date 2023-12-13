<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferScan extends Model
{
    protected $fillable = [
        'FK_offer_id',
        'FK_seller_id',
        'FK_user_id'
    ];

    public function seller()
    {
        return
            $this->hasOne(Seller::class,  'id', 'FK_seller_id');
    }
    public function user()
    {
        return
            $this->hasOne(User::class,  'id', 'FK_user_id');
    }
    public function offer()
    {
        return
            $this->hasOne(Offer::class,  'id', 'FK_offer_id');
    }
}
