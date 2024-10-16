<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category',
    ];

    public function categories(): HasMany {
        return $this->hasmany(products::class);
    }
}
