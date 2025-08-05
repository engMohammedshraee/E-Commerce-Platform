<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
        protected $fillable = [
        'image',
        'product_id'
    ];

    /**
     * العلاقة مع المنتج
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * الحصول على مسار الصورة الكامل
     */
    public function getImageUrlAttribute(): string
    {
        return asset(path: 'storage/' . $this->image );
    }

    /**
     * الحصول على مسار الصورة المصغرة (إذا كنت تستخدم thumbnails)
     */
    public function getThumbnailUrlAttribute(): string
    {
        return asset('storage/thumbnails/' . $this->image);
    }

}
