<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        $cartItems = Cart::with('product')->get();

        return view('products', compact('products','cartItems'));
    }

    public function listCartItems(){
        // Fetch cart items
        $cartItems = Cart::with('product')->get();
        // Return the HTML response
        return response()->json($cartItems);
    }

    public function addToCart(Request $request,Product $product) {

//        $productId = $request->product_id;
        $quantity = $request->quantity;
        if ($quantity > $product->quanity) {
            return response()->json('Out of stock');
        }

        $userId = auth()->id();

        // Insert into carts table
        Cart::create([
            'product_id' => $request->product_id,
            'quantity' => $quantity,
            'user_id' => $userId
        ]);

        return response()->json('Added to cart!');

    }

    public function cartItemsPage(){
        $cartItems = Cart::with('product')->get();
        return view('cart', compact('cartItems'));
    }

    public function deleteItem(Request $request){
        $cart = Cart::findOrFail($request->id);
        $cart->delete();
        return response()->json('Item deleted');
    }

    public function updateQuantity(Request $request){
        $cart = Cart::findOrFail($request->id);
        $cart->quantity = $request->quantity;
        $cart->save();
        return response()->json('Quantity updated');
    }

}
