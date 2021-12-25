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
        'user_id', 'name', 'photo_name', 'photo_path', 'category', 'quantity', 'expiry_date', 'price', 'phone_number', 'discount2','discount3', 'views','likes'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}


