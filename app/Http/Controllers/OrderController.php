<?php

namespace App\Http\Controllers;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;
use App\Mail\OrderNotification;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{



     // Display a listing of the orders
     public function index()
     {
         // Fetch orders with related user data
         $orders = Order::all();
        // dd($orders);
         return view('admin.orders', compact('orders')); // Adjust view name as needed
     }
     public function Cash_order()
     {
        $user = Auth::user();
        $userid = $user->id;
        // Access the user's address
        $userAddress = $user->address;

       //dd($userAddress);
       $data = Cart::where('user_id','=',$userid)->get();
       foreach($data as $d){
        $sessionValue = session('cart_total');
        $sessionItem = session('cart_items');
        $order = new Order;
        //$order->id = $d->id;
        $order->user_id = $d->user_id;
        $order->product_id = $d->product_id;
        $order->payment_method = 'in-delivery';
        $order->quantity = $d->quantity;
        $order->total_amount = $sessionValue;
        $order->status = 'Pending';
        $order->shipping_address = $userAddress;
        $order->save();
        $cart_id=$d->id;
        $cart=Cart::find($cart_id);
        $cart->delete();
        
       }
       return redirect()->back()->with('mess',"we have recived your Orders.");
     }
    
      // Update the status of a specific order
    public function updateStatus(Request $request, Order $order)
    {
        // Validate the incoming status value
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,canceled,failed,refunded'
        ]);

        // Update the order status
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('message', 'Order status updated successfully!');
    }
    public function createCreditCardOrder(Request $request)
{
    $user = Auth::user();
    $useid = $user->id;
    $userAddress = $user->address;

    // Assuming you have a session value for the total amount
    $amount = session('cart_total', 0) * 100; // Convert to cents

    $sessionValue = session('cart_total'); // Or calculate the total based on cart items

   // Set the Stripe API key
   Stripe::setApiKey(config('services.stripe.secret'));

        

   // Charge the customer
   try {
    Charge::create([
        'amount' => $amount, // Amount in cents (e.g., $50.00)
        'currency' => 'usd',
        'customer' => $customer->id, // Use the created customer ID
        'description' => 'Payment for order', // Description of the charge
    ]);

    // If payment is successful, save the order to the database
    $data = Cart::where('user_id','=',$userid)->get();
       foreach($data as $d){
        $sessionValue = session('cart_total');
        $order = new Order;
        $order->id = $d->id;
        $order->user_id = $d->user_id;
        $order->payment_method = 'in-delivery';
        $order->product_id = $d->product_id;
        $order->quantity = $d->quantity;
        $order->total_amount = $sessionValue;
        $order->status = 'Pending';
        $order->shipping_address = $userAddress;
        $order->save();
        $cart_id=$d->id;
        $cart=Cart::find($cart_id);
        $cart->delete();
        
       }
       return redirect()->back()->with('mess',"we have recived your Orders.");
}
    catch (\Exception $e) {
        // Handle payment failure
        return redirect()->back()->withErrors('Payment failed: ' . $e->getMessage());
    }
   
}

    public function downloadOrderDetails($id)
    {
        // Retrieve the order details by ID
        $order = Order::findOrFail($id);
       // dd($order);

        // Pass the order data to the PDF view
        $pdf = PDF::loadView('admin.order_details_pdf', compact('order'));

        // Return the PDF as a downloadable response
        return $pdf->download('order_' . $order->id . '_details.pdf');
    }

    public function showOrderEmailForm()
{
    $orders = Order::all(); // Retrieve all orders from the database
    return view('admin.orders', compact('orders')); // Pass $orders to the view
}
public function sendOrderEmail($orderId)
{
    // Find the specific order by its ID
    $order = Order::find($orderId);
   // dd($order);
    // Check if the order exists
    if (!$order) {
        return back()->with('error', 'Order not found.');
    }

    // Get associated user details
    $user = $order->user; // Assuming the Order model has a 'user' relationship
    if (!$user) {
        return back()->with('error', 'User not associated with this order.');
    }

    $details = [
        'user_name'=> $user->name,
        'email' => $user->email,
        'subject' => 'Order Notification',
        'message' => 'Details regarding your order with ID: ' . hash('sha256', $order->id),
    ];

    // Send email using a Mailable class
    Mail::to($user->email)->send(new OrderNotification($details));

    return back()->with('success', "Email sent to user: {$user->name}");
}
}