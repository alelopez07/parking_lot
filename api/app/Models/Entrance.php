<?php

/**
 * Entrance
 *
 * Entity to register an entrance to the parking lot.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Entrance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $table = 'entrances';

    protected $fillable = ['license_plate', 'started_at', 'finalized_at', 'state', 'vehicle_type_id', 'user_id'];

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
     * Get the vehicle type information
     *
     * @return BelongsTo vehicle type entity
     */
    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Get the user information
     *
     * @return BelongsTo user entity
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
