<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [

        'FK_user_id',
        'FK_seller_id',
        'FK_voucher_id',
        'is_scratched'
    ];
    protected $hidden = [
        'FK_user_id',
        'FK_seller_id',
        'FK_voucher_id'

    ];
    public function seller()
    {
        return
            $this->hasOne(Seller::class,  'id', 'FK_seller_id');
    }
    public function voucher()
    {
        return
            $this->hasOne(Voucher::class,  'id', 'FK_voucher_id');
    }
}
