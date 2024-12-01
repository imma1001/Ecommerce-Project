<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use App\Models\Cart;
use Stripe\Customer;

class PaymentController extends Controller
{
    // Show the payment form
    public function showCheckoutForm()
    {
        return view('checkout'); // Return the view for payment processing
    }

    // Process the payment
    public function processPayment(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
       
        $amount = session('cart_total', 0) * 100; // Convert to cents

        // Validate the request data
        $validatedData = $request->validate([
            'stripeToken' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'nullable|string',  // Make phone optional
            
        ]);

        // Set the Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Check if the user already exists, if not, create a new customer
        $customer = Customer::create([
            'email' => $validatedData['email'], // Use validated email
            'name' => $validatedData['name'], // You can also save the name if needed
            'address' => [
            'line1' => $validatedData['address'],
            // Add other address details here if required (e.g., city, postal code)
        ],
            'phone' => 'phone', // Use validated email
            'source' => $validatedData['stripeToken'], // Payment source from Stripe.js
        ]);

        // Charge the customer
        try {
            Charge::create([
                'amount' => $amount, // Amount in cents (e.g., $50.00)
                'currency' => 'usd',
                'customer' => $customer->id, // Use the created customer ID
                'description' => 'Payment for order', // Description of the charge
            ]);

             // Retrieve cart items for the user
             $cartItems = Cart::where('user_id', $userId)->get();
              //dd($cartItems);
             if ($cartItems->isEmpty()) {
                 return back()->with('error', 'Your cart is empty.');
             }
 
             // Create a single order for all cart items
             $order = new Order();
             $order->user_id = $userId;
             $order->total_amount = $amount / 100; // Store in dollars
             $order->payment_method = 'credit_card';
             $order->status = 'Paid';
             $order->shipping_address = $validatedData['address'];
             $order->save();
               //
             // Attach cart items to the order
             foreach ($cartItems as $item) {
                 $order->products()->attach($item->product_id, [
                     'quantity' => $item->quantity,
                 ]);
 
                 // Remove item from the cart
                 $item->delete();
             }

            return redirect()->route('checkout.form')->with('success', 'Payment completed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
