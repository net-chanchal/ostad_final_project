<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'job_category_id',
        'title',
        'slug',
        'description',
        'vacancy',
        'deadline',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @return HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(JobPostAttribute::class)->with('attribute');
    }

    /**
     * @return HasOne
     */
    public function attributeOther(): HasOne
    {
        return $this->hasOne(JobPostAttributeOther::class);
    }

    /**
     * @return HasOne
     */
    public function location(): HasOne
    {
        return $this->hasOne(JobPostLocation::class)->with(['country', 'state', 'city']);
    }

    /**
     * @return HasOne
     */
    public function salary(): HasOne
    {
        return $this->hasOne(JobPostSalary::class);
    }

    /**
     * @return HasMany
     */
    public function jobApplies(): HasMany
    {
        return $this->hasMany(JobApply::class, 'job_post_id')
            ->with(['account']);
    }
}
