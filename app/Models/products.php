<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'product',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }
}
