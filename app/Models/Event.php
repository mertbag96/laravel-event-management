<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start_time',
        'end_time',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    /**
     * User that created the event.
     * @return BelongsTo<User, Event>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Attendees of the event.
     * @return HasMany<Attendee, Event>
     */
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
