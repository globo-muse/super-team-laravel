<?php

namespace App\Models;

use App\Enums\VideoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /**
     * Possibles options for Status
     */
    const STATUS_NO = 'NO';
    const STATUS_WAITING = 'WAITING';
    const STATUS_SENDED = 'SENDED';
    const STATUS_COMPLETED = 'COMPLETED';

    protected $fillable = ["order_id", "is_public", "vimeo_id", "hash", "thumb", "link_play", "status"];
}
