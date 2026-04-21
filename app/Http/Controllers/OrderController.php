<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Panier vide !');
        }

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'en_attente',
            'total' => $total,
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Commande passée avec succès !');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }
}