<?php

namespace App\Models;

use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
      use HasFactory;
      protected $fillable = [
        'total_prices',
        'status',
        'user_Address_id',
        'created_by',
        'updated_by',
        'session_id'
    ];

        /**
     * العلاقة مع عناصر الطلب
     */
    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    }
    // public function payments(){
    //     return $this->hasMany(Payment::class)
    // }
    // حالات الطلب المتاحة
    public const STATUSES = [
        'pending' => 'قيد الانتظار',
        'processing' => 'قيد المعالجة',
        'shipped' => 'تم الشحن',
        'delivered' => 'تم التوصيل',
        'cancelled' => 'ملغي'
    ];

    /**
     * العلاقة مع عنوان المستخدم
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class, 'user_Address_id');
    }

    /**
     * العلاقة مع مستخدم إنشاء الطلب
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * العلاقة مع مستخدم تحديث الطلب
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }



    /**
     * التحقق من حالة الطلب
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * حساب المجموع الفرعي لعناصر الطلب
     */
    // public function calculateSubtotal(): float
    // {
    //     return $this->items->sum(function ($item) {
    //         return $item->quantity * $item->unit_price;
    //     });
    // }
}
