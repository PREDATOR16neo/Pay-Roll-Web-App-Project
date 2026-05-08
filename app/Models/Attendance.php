<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the user that owns the attendance record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to filter attendance by date
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope to filter attendance by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get latest attendance records
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('date', 'desc');
    }
}
