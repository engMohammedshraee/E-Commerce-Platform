<?php

namespace App\Http\Resources;

use App\Helpers\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$products, $cartitems] =$this->resource;

        return [
            'count' => Cart::getCount(),
           'total' => $products->reduce(fn(?float $carry,Product $product)=>$carry + $product->price * $cartitems[$product->id]['quantity']),
            'items' => $cartitems,
            'products' => ProductResource::collection($products)
        ];
    }
    // protected function calculateTotal($products, $cartitems): float
    // {
    //     return $products->reduce(function (?float $carry, Product $product) use ($cartitems) {
    //         $quantity = $cartitems[$product->id]['quantity'] ?? 0;
    //         return ($carry ?? 0) + ($product->price * $quantity);
    //     }, 0);
    // }
}
