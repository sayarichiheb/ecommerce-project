<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers    = User::count();
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('status', 'validee')->sum('total');
        $recentOrders  = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalProducts', 'totalOrders', 'totalRevenue', 'recentOrders'
        ));
    }

    public function users()
    {
        $users = User::withCount(['products', 'orders'])->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function orders()
    {
        $orders = Order::with('user', 'items.product')->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:en_attente,validee,annulee',
        ]);
        $oldStatus = $order->status;
$newStatus = $request->status;

$order->update(['status' => $newStatus]);

if ($newStatus === 'validee' && $oldStatus !== 'validee') {
    foreach ($order->items as $item) {
        $item->product->decrement('stock', $item->quantity);
    }
}

if ($oldStatus === 'validee' && $newStatus === 'annulee') {
    foreach ($order->items as $item) {
        $item->product->increment('stock', $item->quantity);
    }
}

return back()->with('success', 'Statut mis à jour !');
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Impossible de supprimer un administrateur.');
        }
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}