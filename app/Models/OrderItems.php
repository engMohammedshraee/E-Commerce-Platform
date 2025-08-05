<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItems extends Model
{
      use HasFactory;
protected $table = 'order_items'; // ✅ صحيح
 protected $fillable=['order_id','product_id','quantity','unit_price'];
 public function order(){
    return $this->belongsTo(Order::class);
 }
 public function product(){
    return $this->belongsTo(Product::class);
 }
}
