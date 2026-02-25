<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    // Autoriza o preenchimento desses campos no PostgreSQL
    protected $fillable = [
        'name',
        'unit',
        'purchase_price',
        'package_size'
    ];

    protected $appends = ['unit_cost'];

    /**
     * Get the cost per unit of the ingredient.
     */
    public function getUnitCostAttribute()
    {
        if ($this->package_size > 0) {
            return $this->purchase_price / $this->package_size;
        }
        return 0;
    }
    /**
     * The recipes that belong to this ingredient.
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class , 'recipe_ingredient')->withPivot('quantity_used')->withTimestamps();
    }
}