<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    
    protected $fillable = [ 
        'id',
    'user_id',
    'total_amount',
    'status',
    'payment_method',
    'stripe_charge_id', // Store the Stripe charge ID if applicable
    'shipping_address', // If applicable
    'quantity','product_id',
    'created_at',
    'updated_at',
];
 // Relationships
 public function user()
 {
     return $this->belongsTo(User::class); // Assuming you have a User model
 }
 public function cart()
 {
     return $this->hasMany(Cart::class); // Assuming you have a Cart model
 }


}
