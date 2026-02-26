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

    protected $appends = ['total_cost', 'ingredient_cost'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
            ->withPivot('quantity_used')
            ->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_recipe')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function overheadCosts()
    {
        return $this->belongsToMany(OverheadCost::class, 'recipe_overhead_cost')
            ->withTimestamps();
    }

    public function getIngredientCostAttribute()
    {
        return $this->ingredients->sum(function ($ingredient) {
            return $ingredient->unit_cost * $ingredient->pivot->quantity_used;
        });
    }

    public function getTotalCostAttribute()
    {
        $ingredientCost = $this->ingredient_cost;
        $overheadTotal = 0;

        foreach ($this->overheadCosts as $overhead) {
            if ($overhead->type === 'fixed') {
                $overheadTotal += $overhead->value;
            } elseif ($overhead->type === 'percentage') {
                $overheadTotal += $ingredientCost * ($overhead->value / 100);
            }
        }

        return $ingredientCost + $overheadTotal;
    }
}
