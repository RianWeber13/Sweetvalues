<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name',
        'description',
        'yield_quantity',
        'yield_unit',
    ];

    protected $appends = ['total_cost'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class , 'recipe_ingredient')
            ->withPivot('quantity_used')
            ->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class , 'product_recipe')
            ->withPivot('quantity')
            ->withTimestamps();
    }


    public function getTotalCostAttribute()
    {
        return $this->ingredients->sum(function ($ingredient) {
            return $ingredient->unit_cost * $ingredient->pivot->quantity_used;
        });
    }
}