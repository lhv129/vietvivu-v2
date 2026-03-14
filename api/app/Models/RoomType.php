<?php

namespace App\Models;

use App\Models\Hotel;
use App\Models\RoomTypeCalendar;
use App\Models\RoomTypePriceRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'hotel_id',
        'name',
        'max_guests',
        'total_rooms',
        'base_price',
        'currency',
        'featured_image',
        'is_active'
    ];

    protected $table = 'room_types';

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function priceRules()
    {
        return $this->hasMany(RoomTypePriceRule::class);
    }

    public function calendars()
    {
        return $this->hasMany(RoomTypeCalendar::class);
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
