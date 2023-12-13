<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'category';
    protected $hidden = [
        "FK_admin_id"
    ];
    protected $fillable  = ['title', 'image_url', 'summary'];
    public function seller()
    {
        return $this->hasMany(
            Seller::class,
            'FK_category_id',
            'id'
        );
    }
    public function sellers()
    {
        return $this->seller()
            ->where('status', '=', 'Active')
            ->limit(10);
    }
    public function defaultCategoryImage()
    {
        return $this->hasMany(
            Categorydefault::class,
            'cat_id',
            'id'
        );
    }
    
}
