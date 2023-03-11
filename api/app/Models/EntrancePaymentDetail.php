<?php

/**
 * EntrancePaymentDetail
 * 
 * Parking payment detail for using the parking lot.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class EntrancePaymentDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $table = "entrance_payment_details";

    protected $fillable = ['payment_type','minutes','total','entrance_id'];

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
     * Get the entrance information.
     * 
     * @return BelongsTo entrance entity
     */
    public function entrance(): BelongsTo {
        return $this->belongsTo(Entrance::class);
    }
}