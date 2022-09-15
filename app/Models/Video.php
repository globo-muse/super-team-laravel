<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ["order_id", "is_public", "vimeo_id", "hash", "thumb", "link_play", "status"];
}
