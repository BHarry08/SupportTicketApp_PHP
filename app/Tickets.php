<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description','user_id','assigned_agent_id'
    ];

    /**
     * List all ticket replies
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function TicketReplies(){
        return $this->hasMany("App\TicketReplies","ticket_id","id");
    }

    /**
     * Get Ticket status
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function TicketStatus(){
        return $this->hasOne("App\Status","id","status");
    }

    /**
     * Get user who created ticket
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo("App\User","user_id","id");
    }




}
