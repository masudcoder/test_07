<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;   

class TemplateCsvHead extends Model
{
   protected $primaryKey = 'csv_head_row_id';  
   
    public function csv_head_values() {    
     return $this->hasMany('App\Models\TemplateCsvValue', 'csv_head_row_id', 'csv_head_row_id');
   }
   
}
