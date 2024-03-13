<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'status',
    ];

    /**
     * @return HasMany
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(JobPost::class);
    }
}
