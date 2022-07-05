<?php

namespace App;

use App\Events\SendWelcomeEmailEvent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'emails', 'password','phone','state','city','zip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send welcome email one user registered
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => SendWelcomeEmailEvent::class,
    ];

    /**
     * Get all user tickets
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function userTickets(){
        return $this->hasMany("App\Tickets","user_id","id");
    }

    /**
     * Get all agent tickets
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentTickets(){
        return $this->hasMany("App\Tickets","assigned_agent_id","id");
    }
}
