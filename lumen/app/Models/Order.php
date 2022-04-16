<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    protected $table = 'orders';

    protected $fillable = [
        'amount'
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}
