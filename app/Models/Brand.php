<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
      use HasFactory;
       protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * العلاقة مع المنتجات (Brand has many Products)
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * إنشاء slug تلقائي عند حفظ الموديل
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });

        static::updating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });
    }
}
