<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\CartResource;
use inertia\Inertia;
use App\Helpers\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;

use function Pest\Laravel\delete;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;

class CartController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $totalquantity = CartItem::sum('quantity');

        $quantity = $request->input('quantity', 1);
        $user = $request->user();
        if ($user) {
            $cartitems = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if ($cartitems) {
                $cartitems->increment('quantity');
            } else {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => 1
                ]);
            }
        } else {
            $cartitems = Cart::getCookiesCartitems();
            $isProductExist = false;
            foreach ($cartitems as $item) {
                if ($item['product_id'] == $product->id) {
                    $item['quantity'] = $quantity;
                    $isProductExist = true;
                    break;
                }
            }
            if (!$isProductExist) {
                $cartitems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
            }
            Cart::setCookiesCartitem($cartitems);
        }
        return redirect()->back()->with('success', 'cart added successfly');
    }
    public function view(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            $Cartitems = CartItem::with('product')->where('user_id', $user->id)->get();
            $userAddress = UserAddress::where('user_id', $user->id)->where('isMain',1)->first();
            if (count($Cartitems) > 0) {
                return inertia::render('User/CartList', [
                    'Cartitems' => $Cartitems,
                    'userAddress' => $userAddress
                ]);
            } else {
                $Cartitems = Cart::getCookiesCartitems();
                if (count($Cartitems) > 0) {
                    $Cartitems = new CartResource(Cart::getProductAndCartitems());
                    return inertia::render('User/CartList', [
                        'Cartitems' => $Cartitems,
                    ]);
                } else {
                    return redirect()->back();
                }
            }
        }

    }
    public function update(Request $request, Product $product)
    {

        $quantity = $request->integer('quantity');
        $user = $request->user();
        if ($user) {
            CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->update(['quantity' => $quantity]);
        } else {
            $cartitems = Cart::getCookiesCartitems();
            foreach ($cartitems as $item) {
                if ($item['product_id'] == $product->id) {
                    $item['quantity'] += $quantity;
                    break;
                }
            }
            Cart::setCookiesCartitem($cartitems);
        }
        return redirect()->back();
    }
    public function delete(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            CartItem::query()->where(['user_id' => $user->id, 'product_id' => $product->id])
                ->first()?->delete();
            if (CartItem::count() <= 0) {
                return redirect()->route('home')->with('info', 'your cart is empty');
            } else {
                return redirect()->back()->with('success', 'item remove successfly');
            }
        } else {

            $cartitems = Cart::getCookiesCartitems();
            foreach ($cartitems as $i => $item) {
                if ($item['product_id'] == $product->id) {
                    array_splice($cartitems, $i, 1);
                    break;
                }
            }
            Cart::setCookiesCartitem($cartitems);

            if (count($cartitems) <= 0) {
                return redirect()->route('home')->with('info', 'your cart is empty');
            } else {
                return redirect()->back()->with('success', 'item remove successfly');
            }
        }
    }
}
