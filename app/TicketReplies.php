<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketReplies extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id', 'reply_by_id','reply_description','reply_status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function TicketRepliesBy(){
        return $this->hasOne("App\User","id","reply_by_id");
    }

    public function TicketRepliesStatus(){
        return $this->hasOne("App\Status","id","reply_status");
    }
}
