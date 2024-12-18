<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'photo',
        'quantity',
        'price',
        'category_id',
        
    ];
    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}
public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
