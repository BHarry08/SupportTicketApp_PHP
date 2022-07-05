<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admins extends Authenticatable
{
    protected $guard = 'admins';
    protected $table = "admins";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'emails', 'password','phone','state','city','zip'
    ];

    /**
     * Get all agent tickets
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentTickets(){
        return $this->hasMany("App\Tickets","assigned_agent_id","id");
    }
}
