<?php

/**
 * Vehicle
 *
 * Main entity. Register vehicles.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $table = 'vehicles';

    protected $fillable = ['license_plate', 'vehicle_type_id'];

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
     * Get the vehicle type information.
     *
     * @return BelongsTo vehicle type
     */
    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Get the entrances of parking lot.
     *
     * @return HasMany entrances
     */
    public function entrances(): HasMany
    {
        return $this->hasMany(Entrance::class);
    }
}
