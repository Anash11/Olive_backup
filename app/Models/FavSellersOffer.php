<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavSellersOffer extends Model
{
    protected $fillable  = ['message', 'FK_offer_id', 'FK_user_id'];
    public function offer()
    {
        return $this->hasMany(
            Offer::class,
            'id',
            'FK_offer_id',
        );
    }
    // public function seller()
    // {
    //     return $this->offer();
    // }
}
