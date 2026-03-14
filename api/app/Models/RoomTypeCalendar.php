<?php

namespace App\Models;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomTypeCalendar extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'room_type_id',
        'date',
        'price',
        'available_rooms',
        'is_active'
    ];

    protected $table = 'room_type_calendars';

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date' => 'date'
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
