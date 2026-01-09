<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    protected $appends = [
        'subtotal_price',
    ];
    public function getSubtotalAttribute(): float
    {
        if ($this->product->discount_price) {
            return $this->quantity * $this->product->discount_price;
        }
        return $this->quantity * $this->product->price;
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
