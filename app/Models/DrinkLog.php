<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DrinkLog
 * @package App\Models
 *
 * @table
 * @col
 */
class DrinkLog extends BaseModel
{
    protected $table = 'drink_log';
    //protected $casts = [];

    //=== RELATIONSHIPS ===//
    public function drink(): BelongsTo
    {
        return $this->belongsTo(Drink::class);
    }

    //=== ATTRIBUTES ===//

    //=== SCOPES ===//

}
