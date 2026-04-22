<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
public function store(Request $request, $productId)
{

   $product = \App\Models\Product::findOrFail($productId);
if ($product->user_id === Auth::id()) {
    return redirect()->back()->with('error', 'Vous ne pouvez pas noter votre propre produit !');
}
    $existingReview = Review::where('user_id', Auth::id())
                            ->where('product_id', $productId)
                            ->first();

    if ($existingReview) {
        return redirect()->back()->with('error', 'Vous avez déjà laissé un avis sur ce produit !');
    }

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    Review::create([
        'user_id' => Auth::id(),
        'product_id' => $productId,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return redirect()->back()->with('success', 'Avis ajouté !');
}
public function destroy($id)
{
    $review = Review::findOrFail($id);

    if ($review->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
        abort(403, 'Action non autorisée.');
    }

    $review->delete();

    return redirect()->back()->with('success', 'Avis supprimé !');
}
}   