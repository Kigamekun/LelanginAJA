<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','description','start_from','end_auction','condition','saleroom_notice' ,'created_by','catalogue_note','thumb'];
    
    use HasFactory;
}
