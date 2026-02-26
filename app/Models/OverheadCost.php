<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OverheadCost extends Model
{
    protected $fillable = ['name', 'type', 'value'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'overhead_cost_product')
            ->withTimestamps();
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_overhead_cost')
            ->withTimestamps();
    }
}