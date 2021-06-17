<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Drink
 * @package App\Models
 *
 * @table
 * @col
 */
class Drink extends BaseModel
{
    //protected $table = '';
    //protected $casts = [];

    //=== RELATIONSHIPS ===//
    public function log(): HasMany
    {
        return $this->hasMany(DrinkLog::class);
    }

    //=== ATTRIBUTES ===//

    //=== SCOPES ===//

}
