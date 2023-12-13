<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seller extends Model
{
    protected $fillable = [
        'business_name',
        'business_email',
        'business_phone',
        'FK_user_id',
        'FK_category_id',
        'status',
        'area',
        'city',
        'state',
        'zip',
        'longitude',
        'latitude',
        'document_img_url',
        'shop_contact',
        'shop_cover_image',
        'weekly_timing',
        'shop_logo_url',
        'owner_name',
        'address',
    ];
    protected $hidden = [
        // 'FK_user_id',
        // 'FK_category_id'

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->shop_id = (string) Str::orderedUuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
    public function category()
    {
        return $this->hasOne(
            Category::class,
            'id',
            'FK_category_id'
        );
    }
    public function user()
    {
        return $this->hasOne(
            User::class,
            'id',
            'FK_user_id'
        );
    }
    public function review()
    {
        return $this->hasOne(
            User::class,
            'id',
            'FK_user_id'
        );
    }
    public function all_offer()
    {
        return
            $this->hasMany(Offer::class, 'FK_shop_id', 'shop_id');
    }
    public function offers()
    {
        return $this->all_offer()
        ->where('offer_status', '=', 'Active')
        ->where('offer_end_date', '>=', date('Y-m-d'))
        ->where('offer_start_date', '<=', date('Y-m-d'))
        ->orderBy('offer_priority', 'DESC');
    }
    
    public function has_offers()
    {
        return
            $this->offers()->count() ? true : false;
    }
    public function offers_count()
    {
        return
            $this->offers()->count();
    }
    public function vouchers()
    {
        return
            $this->hasMany(Voucher::class, 'FK_seller_id', 'id');
    }
    public function open_vouchers()
    {
        return
            $this->vouchers()
            ->where('status', '=', 'Active');
    }
    public function scopeActive($query)
    {
        $query->where('status', 'Active');
    }
}
