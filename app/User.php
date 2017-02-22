<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user' => 'array',
    ];

    public function followers()
    {
        return $this->belongsToMany('App\User', 'subscriptions', 'following_id', 'follower_id')
          ->withTimestamps()->withPivot(['plan', 'id']);
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'subscriptions', 'follower_id', 'following_id')
          ->withTimestamps()->withPivot(['plan', 'id']);
    }

}
