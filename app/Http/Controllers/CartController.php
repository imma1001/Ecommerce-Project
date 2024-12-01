<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Products;
use App\Models\Cart;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function AddtoCart($id){
        $product = Products::find($id);
        if(!$product){
            return redirect()->back()->with('error',"Product not found");
        }
        if (Auth::check()){
            $cart = Cart::where('user_id',Auth::id())->where('product_id',$id)->first();
            if ($cart){
                $cart->quantity++;
                $cart->save();
            }
        else{
            Cart::create(['user_id'=>Auth::id(),
            'product_id'=>$id,
            'quantity'=>1,]);
        }
        return redirect()->back()->with('success', 'Product added to cart.');
        } 
        else {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }
    }
    public function showCartProducts(){
        $cartItems =Cart::where('user_id', Auth::id())->with('product')->get();
         // Calculate total price for the cart
    $total = $cartItems->sum(function ($item) {

        return $item->product->price * $item->quantity;
        
    });

    // Calculate total quantity for the cart (optional)
    $totalQuantity = $cartItems->sum('quantity');
    // Store total in session
    session(['cart_total' => $total]);
    session(['cart_items' => $cartItems]);

        return view('indexCart', compact('cartItems', 'total', 'totalQuantity'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::findOrFail($id);

        // Update the quantity of the cart item
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('update', 'Cart updated successfully');
    }

    // Remove function to delete an item from the cart
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);

        // Delete the item from the cart
        $cartItem->delete();

        return redirect()->route('cart.index')->with('remove', 'Item removed from cart');
    }

}
