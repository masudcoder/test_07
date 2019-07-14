<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = array();
    protected $primaryKey = 'product_row_id';  
	
	public function attributeName()
	 {
	    return $this->hasMany('\App\Models\Product_attribute', 'product_row_id', 'product_row_id');
	 }
}
