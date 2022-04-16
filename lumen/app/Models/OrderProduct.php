<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;
    
    protected $table = 'orders_products';

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'amount'
    ];
}
