<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Define the one-to-many relationship:
    // A single category can be associated with many products.
    public function products()
    {
        // This sets up the Eloquent relationship so you can do:
        // $category->products to get all products in this category
        return $this->hasMany(Product::class);
    }
}
