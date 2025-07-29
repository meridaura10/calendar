<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    /** @use HasFactory<\Database\Factories\ReminderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'color',
        'datetime',
        'recurrence',
        'is_completed',
    ];

    protected $casts = [
        'datetime' => 'datetime:d m Y H:i',
        'recurrence_details' => 'array',
        'is_completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setRecurrenceAttribute($value): void
    {
        $this->attributes['recurrence'] = $value ? json_encode($value) : null;
    }
}
