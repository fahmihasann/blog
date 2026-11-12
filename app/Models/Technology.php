<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Technology extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'icon',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
