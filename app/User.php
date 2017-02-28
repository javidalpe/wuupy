<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    public function followers()
    {
        return $this->hasMany('App\Subscription', 'following_id', 'id');
    }

}
