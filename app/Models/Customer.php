<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getImageAttribute($value){
         if($value){
              return asset('uploads/customers/'.$value);
         }else{
              return 'https://via.placeholder.com/350x150';
         }
    }
}
