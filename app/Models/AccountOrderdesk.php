<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;   

class AccountOrderdesk extends Model
{
   protected $primaryKey = 'id';
   protected $fillable = ['order_served_status'];
}
