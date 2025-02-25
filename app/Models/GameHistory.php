<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $user_id
 * @property int $number
 * @property string $status
 * @property float $prize
 * @property int $created_at
 * @property int $updated_at
 * @method static oldest()
 * @method static create(array $array)
 * @method static latest()
 * @method static count()
 */
class GameHistory extends Model
{
    protected $fillable = ['user_id', 'number', 'status', 'prize'];

    protected $casts = [
        'created_at' => 'datetime'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
