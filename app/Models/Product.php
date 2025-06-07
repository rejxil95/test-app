<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; // Enables the factory feature to generate dummy data for testing

    // Specify which fields are mass assignable (i.e., can be bulk assigned)
    protected $fillable = ['name', 'price', 'stock', 'description'];

    public function category()
    {
        // Indicates that a Product belongs to a Category
        return $this->belongsTo(Category::class);
    }

}
