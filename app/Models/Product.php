<?php

namespace App\Models;

use auth;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * الحقول القابلة للتعبئة (Fillable)
     */
    protected $fillable = [
        'id',
        'title',
        'slug',
        'quantity',
        'description',
        'published',
        'inStock',
        'price',
        'brand_id',
        'category_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * العلاقة مع العلامة التجارية (Brand)
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * العلاقة مع التصنيف (Category)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function cartitems()
    {
        return $this->hasMany(CartItem::class);
    }
    // filter logic for catefgories and band and privc
    public function scopefilter(Builder $quary)
    {
        $quary
            ->when(request('brands'), function (Builder $q) {
                $q->whereIn('brand_id', request('brands'));
            })
            ->when(request('categories'), function (Builder $q) {
                $q->whereIn('category_id', request('categories'));
            })
            ->when(request('prices'), function (Builder $q) {
                $q->whereBetween('price', [
                    request('prices.from', 0),
                    request('prices.to', 10000),

                ]);
            });
    }
    /**
     * العلاقة مع المستخدم الذي أنشأ المنتج
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * العلاقة مع المستخدم الذي قام بالتحديث
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * العلاقة مع المستخدم الذي قام بالحذف
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * إنشاء slug تلقائي من العنوان
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = \Illuminate\Support\Str::slug($product->title);

            $product->created_by = auth()->id();
        });
    }
}
