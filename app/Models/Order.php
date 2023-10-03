<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['costumer_id','number','total_price','status','shipping_price','notes'];

    public function costumer():BelongsTo{
        return $this->belongsTo(Costumer::class);
    }
    public function item():HasMany{
        return $this->hasMany(OrderItem::class);
    }
}
