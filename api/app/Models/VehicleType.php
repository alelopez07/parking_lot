<?php

/**
 * VehicleType
 *
 * The API clasify the vehicles by types.
 * ["residents", "officials", "externals", "another_useful_type_of"]
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class VehicleType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $table = 'vehicle_types';

    protected $fillable = ['name', 'value'];

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['id'];
    }

    /**
     * Get the vehicles related to the type.
     *
     * @return HasMany vehicles
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}
