<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
      use HasFactory;

    protected $fillable = [
        'type',
        'address1',
        'address2',
        'state',
        'city',
        'zipcode',
        'isMain',
        'cuntry_code',
        'user_id'
    ];

    // أنواع العناوين المتاحة
    public const TYPES = [
        'shp' => 'Shipping',
        'bil' => 'Billing',
        'hom' => 'Home'
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع الطلبات
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_Address_id');
    }

    /**
     * عند الإنشاء، إذا كان العنوان رئيسي،
     * يتم تعيين جميع عناوين المستخدم الأخرى غير رئيسية
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($address) {
            if ($address->isMain) {
                self::where('user_id', $address->user_id)
                    ->update(['isMain' => false]);
            }
        });

        static::updating(function ($address) {
            if ($address->isMain) {
                self::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id)
                    ->update(['isMain' => false]);
            }
        });
    }

    /**
     * الحصول على العنوان الكامل
     */
    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->address1,
            $this->address2,
            $this->city,
            $this->state,
            $this->zipcode,
            $this->country_code
        ]));
    }

    /**
     * الحصول على نوع العنوان ككلمة كاملة
     */
    public function getTypeNameAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
