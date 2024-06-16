<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    use HasFactory;
    protected $table = 'tableReservations';
    protected $fillable = [
        'user_id',
        'table_id',
        'date',
        'timeFrom',
        'timeTo'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
