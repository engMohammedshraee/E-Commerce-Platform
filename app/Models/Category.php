<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * العلاقة مع المنتجات (Category has many Products)
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * إنشاء slug تلقائي عند الحفظ
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = self::generateUniqueSlug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = self::generateUniqueSlug($category->name, $category->id);
        });
    }

    /**
     * توليد slug فريد (تم تعديله ليكون static)
     */
    private static function generateUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)
                  ->when($id, function($query) use ($id) {
                      $query->where('id', '!=', $id);
                  })
                  ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
