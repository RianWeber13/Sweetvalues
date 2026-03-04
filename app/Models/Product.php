<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'category', 'profit_margin'];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class , 'product_recipe')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function overheadCosts()
    {
        return $this->belongsToMany(OverheadCost::class , 'overhead_cost_product')
            ->withTimestamps();
    }

    /**
     * Calculate the total cost of materials (based on recipes).
     */
    public function getMaterialCostAttribute()
    {
        $cost = 0;
        foreach ($this->recipes as $recipe) {
            // Recipe total_cost is already calculated per unit of yield?
            // Recipe total_cost is the cost of the *entire* recipe batch.
            // We need to know how much of the recipe is used. 
            // The pivot 'quantity' likely represents "how many recipes" or "fraction of recipe"?
            // Let's assume 'quantity' is "Number of whole recipes" or "Units of recipe"?
            // Usually, a Product is like "Cake" made of 1 "Sponge Cake Recipe" and 1 "Frosting Recipe".
            // Or "Box of 6 Cupcakes".
            // If Recipe has a 'yield_quantity', valid logic is:
            // cost += ($recipe->total_cost / $recipe->yield_quantity) * $pivot->quantity
            // IF pivot->quantity is in the same unit as yield.

            // However, looking at the migration, quantity is just a decimal.
            // Let's assume for now that the Recipe 'total_cost' is the cost of the BATCH.
            // And we are adding 'quantity' of BATCHES? No, that's unlikely for a product.
            // A product usually consumes a portion.

            // Let's look at Recipe model again.
            // Recipe has 'total_cost' accessor.
            // Recipe has yield_unit and yield_quantity.

            // If I add a recipe to a product, I probably specify how much of that recipe I use.
            // E.g. Product "Slice of Cake". Recipe "Whole Cake" (yields 8 slices).
            // Quantity for Product would be 1/8? Or 1? 

            // Re-reading user request: "a product can have multiple recipes".
            // Let's stick to simplest interpretation: 
            // The pivot quantity is the Multiplier of the Recipe's Total Cost? 
            // OR the pivot quantity is the AMOUNT of yield used?

            // Let's assume pivot quantity is the AMOUNT of yield used.
            // Cost = (Recipe Total Cost / Recipe Yield Quantity) * Pivot Quantity.

            if ($recipe->yield_quantity > 0) {
                $unitCost = $recipe->total_cost / $recipe->yield_quantity;
                $cost += $unitCost * $recipe->pivot->quantity;
            }
        }
        return $cost;
    }

    /**
     * Calculate the suggested price including overheads and profit margin.
     */
    public function getSuggestedPriceAttribute()
    {
        $materialCost = $this->material_cost;
        // Use associated overhead costs instead of all
        $overheadCosts = $this->overheadCosts;

        $totalOverhead = 0;

        // Apply overheads
        foreach ($overheadCosts as $overhead) {
            if ($overhead->type === 'fixed') {
                $totalOverhead += $overhead->value;
            }
            elseif ($overhead->type === 'percentage') {
                $totalOverhead += $materialCost * ($overhead->value / 100);
            }
        }

        $totalCost = $materialCost + $totalOverhead;

        // Apply profit margin
        if ($this->profit_margin > 0) {
            return $totalCost * (1 + ($this->profit_margin / 100));
        }

        return $totalCost;
    }
}