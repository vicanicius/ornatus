<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\CrudController;

class ProductsController extends CrudController {

    public function __construct() 
    {
        parent::__construct(Product::class);
    }
}