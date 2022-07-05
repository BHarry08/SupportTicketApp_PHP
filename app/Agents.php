<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agents extends Authenticatable
{

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
