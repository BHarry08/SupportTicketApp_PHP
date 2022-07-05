<?php

namespace App\Http\CustomTraits;


use App\Agents;
use App\User;

trait TicketTrait {

    /**
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    function getAvailableAgent(){
        $agents = Agents::with("agentTickets")->get();
        $availableagent = $agents[0];
        $availableAgentTicketCount = $agents[0]->agentTickets->count();
        foreach ($agents as $agent){
            if($availableAgentTicketCount > $agent->agentTickets->count() ){
                $availableagent = $agent;
                $availableAgentTicketCount = $agent->agentTickets->count();
            }
        }
        return $availableagent;
    }
}
