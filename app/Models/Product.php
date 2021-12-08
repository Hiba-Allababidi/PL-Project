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
        'Name', 'Photo_Path', 'Category', 'Quantity', 'Price', 'Phone_Number'
    ];


    public function user()
    {
        return $this->belongsTo('User', 'User_ID', 'id');
    }

}
