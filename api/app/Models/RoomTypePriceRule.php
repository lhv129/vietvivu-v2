<?php

namespace App\Models;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomTypePriceRule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'room_type_id',
        'type',
        'start_date',
        'end_date',
        'amount',
        'amount_type',
        'days_of_week',
        'is_active'
    ];

    protected $table = 'room_type_price_rules';

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'days_of_week' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', self::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', self::INACTIVE);
    }
}
