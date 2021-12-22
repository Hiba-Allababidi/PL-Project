<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static create(array $array)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name', 'photo_name','photo_path', 'category_id', 'quantity','expiry_date', 'price', 'phone_number','discount1','discount2','views'
    ];


    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id');
    }
}


