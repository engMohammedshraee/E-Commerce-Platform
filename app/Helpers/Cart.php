<?php

namespace App\Helpers;

use auth;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class Cart
{
    public static function getCount()
    {
        if ($user = Auth()->user()) {
            return CartItem::whereUserId($user->id)->count();
        }else{
            return array_reduce(self::getCookiesCartitems(),fn($carry,$item)=>$carry+$item['quantity'],0);
        }
    }
    public static function getCartitems()
    {
        if ($user = auth()->user()) {
            return CartItem::where('user_id', $user->id)
                ->get() // أضف هذه السطر لتحويل النتائج إلى Collection
                ->map(fn(CartItem $item) => [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ]);
        }else{
            return self::getCookiesCartitems();
        }
    }

    public static function getCookiesCartitems()
    {
        return json_decode(request()->cookie('cart_items', '[]'), true);
    }
    public static function setCookiesCartitem(array $cartitems)
    {
        Cookie::queue('cart_items', json_encode($cartitems),60*24*30);
    }
    public static function savCookieCartitems()
    {
        $user = auth()->user();
        $userCartitems = CartItem::where(['user_id' => $user->id])->get()->keyBy('product_id');
        $savedCartitems = [];
        foreach (self::getCookiesCartitems() as $Cartitem) {
            if (isset($userCartitems[$Cartitem['product_id']])) {
                $userCartitems[$Cartitem['product_id']]->update(['quantity' => $Cartitem['quantity']]);
                continue;
            }
            $savedCartitems[] = [
                'user_id' => $user->id,
                'product_id' => $Cartitem['product_id'],
                'quantity' => $Cartitem['quantity'],
            ];
            if (!empty($savedCartitems)) {
                CartItem::insert($savedCartitems);
            }
        }
    }
    public static function moveCartitemsintoDb()
    {
        $request = request();
        $Cartitems = self::getCookiesCartitems();
        $newCartitems = [];
        foreach ($Cartitems as $Cartitem) {
            //ckeck if record already exit in d atabase
            $existCartitem = CartItem::where([
                'user_id' => request()->user->id,
                'product_id' => $Cartitem['product_id']
            ])->first();
            if (!$existCartitem) {
                //only insert if is not existi
                $newCartitems[] = [
                    'user_id' => request()->user->id,
                    'product_id' => $Cartitem['product_id'],
                    'quantity' => $Cartitem['quantity']

                ];
            }
        }

        if (!empty($newCartitems)) {
            CartItem::insert($newCartitems);
        }
    }
    public static function getProductAndCartitems()
    {
        $cartitems = self::getCartitems();
        $ids = Arr::pluck($cartitems, 'product_id');
        $products = Product::whereIn('id', $ids)->with('product_images')->get();
        $cartitems = Arr::keyBy($cartitems, 'product_id');
        return [$products , $cartitems];
    }
}
