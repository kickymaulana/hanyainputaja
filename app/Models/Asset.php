<?php

namespace App\Models;

use Database\Factories\AssetFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'asset_code', 'category_id', 'description', 'location_id', 'department_id',
    'user_name', 'user_position', 'asset_status_id', 'asset_condition_id',
    'serial_number', 'brand', 'acquisition_date', 'notes',
])]
class Asset extends Model
{
    /** @use HasFactory<AssetFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['acquisition_date' => 'date'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(AssetStatus::class, 'asset_status_id');
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(AssetCondition::class, 'asset_condition_id');
    }
}
