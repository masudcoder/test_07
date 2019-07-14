<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;   

class ImportTemplate extends Model
{
   protected $primaryKey = 'template_row_id';  
   
   public function csv_heads() {    
     return $this->hasMany('App\Models\TemplateCsvHead', 'template_row_id', 'template_row_id');
   }
   
    public function csv_head_values() {    
     return $this->hasMany('App\Models\TemplateCsvValue', 'template_row_id', 'template_row_id');
   }
   
   
   
}
