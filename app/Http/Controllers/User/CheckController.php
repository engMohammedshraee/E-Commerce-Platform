<?php

namespace App\Http\Controllers\User;

use inertia\Inertia;
use Stripe\Stripe;
use App\Helpers\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\CartItem;
use Stripe\StripeClient;
use App\Models\OrderItems;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $products = $request->products;
        $carts = $request->carts;
        $mergedData = [];
        // loop with cart and products
        foreach ($carts as $cartitem) {
            foreach ($products as $product) {
                if ($cartitem['product_id'] == $product['id']) {
                    $mergedData[] = array_merge($cartitem, ['title' => $product['title'], 'price' => $product['price']]);
                }
            }
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));
        $LienItems = [];
        foreach ($mergedData as $item) {
            $LienItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => (int)($item['price'] * 100), // 50.00 USD
                ],
                'quantity' => $item['quantity'],
            ];
        }


        //  Stripe::setApiKey(env('STRIPE_KEY'));

        $checkoutSession = $stripe->checkout->sessions->create([
            'line_items' => $LienItems,
            'mode' => 'payment',
            'success_url' => route('check.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);
        $newAddress = $request->address;
        if ($newAddress['address1'] != null) {
            $address = UserAddress::where('iaMain', 1)->count();
            if ($address > 0) {
                $address = UserAddress::where('isMain', 1)->update(['isMain' => 0]);
            }

            $address = new UserAddress();
            $address->address1 = $newAddress['addres1'];
            $address->city = $newAddress['city'];
            $address->zipcode = $newAddress['zipcode'];
            $address->type = $newAddress['type'];
            $address->cuntry_code = $newAddress['cuntry_code'];
            $address->state = $newAddress['state'];
            $address->user_id = Auth::user()->id;

            $address->save();
        }
        $mainAddress = $user->user_address()->where('isMain', 1)->first();
        if ($mainAddress) {
            $order = new Order();
            $order->status = 'unpaid';
            $order->total_prices = $request->total;
            $order->user_Address_id = $mainAddress->id;
            $order->session_id = $checkoutSession->id;
            $order->created_by = $user->id;
            $order->save();
            $cartitems = CartItem::where(['user_id' => $user->id])->get();
            foreach ($cartitems as $cartitem) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $cartitem->product_id,
                    'quantity' => $cartitem->quantity,
                    'unit_price' => $cartitem->product->price


                ]);
                $cartitem->delete();
                //remove cart item from cookies
                $cartitems = Cart::getCookiesCartitems();
                foreach ($cartitems as $item) {
                    unset($item);
                }
                array_splice($cartitems, 0, count($cartitems));
                Cart::setCookiesCartitem($cartitems);
            }
            $paymentData = [
                'order_id' => $order->id,
                'amount' => $request->total,
                'status' => 'pending',
                'type' => 'stripe',
                'created_bu' => $user->id,
                'updated_by' => $user->id
            ];
            Payment::create($paymentData);
        }
        return inertia::location($checkoutSession->url);
    }
    public function success1(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            throw new NotFoundHttpException();
        }

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);

            $order = Order::where('session_id', $session->id)->first();

            if (!$order) {
                throw new NotFoundHttpException();
            }

            if ($order->status === 'unpaid') {
                $order->status = 'paid';
                $order->save();
            }

            return Inertia::render('Dashboard');
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
        $sessionid = $request->get('session_id');

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionid);

            if (!$session) {
                throw new NotFoundHttpException();
            }
            $order = Order::where('session_id', $session->id)->first();
            if (!$order) {
                throw new NotFoundHttpException();
            }
            if ($order->status == 'unpaid') {
                $order->status = 'paid';
                $order->save();
            }
            return inertia::render('Dashboard');
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }
}
