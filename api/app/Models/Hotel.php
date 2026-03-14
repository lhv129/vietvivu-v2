<?php

namespace App\Models;

use App\Models\Media;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'location_id',
        'author_id',
        'title',
        'slug',
        'address',
        'featured_image',
        'review_score',
        'review_count',
        'status',
        'is_active',
        'sort_order'
    ];

    protected $table = 'hotels';

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
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // tất cả media
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable')
            ->orderBy('sort_order');
    }

    // chỉ images
    public function images()
    {
        return $this->media()->where('type', 'image');
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
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

    /*
    |--------------------------------------------------------------------------
    | Static
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::deleting(function ($hotel) {

            foreach ($hotel->media as $media) {
                \App\Helpers\ImageHelper::delete($media->path);
            }

            $hotel->media()->delete();
        });
    }
}
