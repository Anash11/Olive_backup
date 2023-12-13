<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteSeller extends Model
{
    use HasFactory;
    protected $table = 'favourite_sellers';

 
    public function seller()
    {
        return $this->hasOne(Seller::class, 'id','seller_id');
    }

}
