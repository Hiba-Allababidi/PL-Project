<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * @method static create(array $array)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name', 'photo_name','photo_path', 'category', 'quantity','expiry_date', 'price', 'phone_number','views'
    ];


    public function user()
    {
        return $this->belongsTo('User', 'User_ID', 'id');
    }

}
