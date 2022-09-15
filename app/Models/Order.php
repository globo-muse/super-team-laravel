<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'responder_id', 'name', 'email', 'occasion', 'instructions', 'status'];

    public function responder()
    {
        return $this->hasOne(User::class, 'id', 'responder_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }
}
