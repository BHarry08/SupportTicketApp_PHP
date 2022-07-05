<?php

namespace App\Http\Controllers\Admin;

use App\Agents;
use App\Http\Controllers\Controller;
use App\Http\CustomTraits\TicketTrait;
use App\Http\Requests\AddReply;
use App\Status;
use App\TicketReplies;
use App\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    use TicketTrait;

    /**
     * TicketController constructor.
     * Created By : Robert M. Prescott
     * Created Date : 29/10/2021
     * Use : Auth Middleware  to check valid user
     */
    public function __construct()
    {
        $this->middleware('AdminAuth');
    }

    /**
     * Created By : Robert M. Prescott
     * Created Date : 29/10/2021
     * Use : Display a listing of the ticket.
     * @return \Illuminate\Http\Response
     */
    public function listAgents(Request $request)
    {
        try {
            return view("admins.agents.list");
        } catch (\Exception $e) {
            $data = [
                "params" => $request->all(),
                "action" => "Admin Ticket Listing",
                "exception" => $e->getMessage()
            ];
            Log::info(json_encode($data));
            abort(500);
        }
    }

    /**
     * Created By : Robert M. Prescott
     * Created Date : 29/10/2021
     * Use : Display a listing of the ticket.
     * @return \Illuminate\Http\Response
     */
    public function listAgentsData(Request $request)
    {
        try {
            $order = $request->order;
            if($order[0]['column'] == 0){
                $sortBy = "id";
            }elseif ($order[0]['column'] == 1){
                $sortBy = "name";
            }elseif ($order[0]['column'] == 2){
                $sortBy = "emails";
            }elseif ($order[0]['column'] == 5){
                $sortBy = "created_at";
            }
            $allAgents = Agents::all();
            if($request->search['value'] != NULL){
                $agents = \App\Agents::where('name', 'like', '%' . $request->search['value'] . '%')->with("agentTickets")->skip($request->start)->take($request->length)->orderBy("$sortBy",$order[0]['dir'])->get();
            }else{
                $agents = \App\Agents::with("agentTickets")->skip($request->start)->take($request->length)->orderBy("$sortBy",$order[0]['dir'])->get();
            }
            $data = array(
                "draw"=> $request->draw,
                "recordsTotal"=> count($allAgents),
                "recordsFiltered"=> count($allAgents),
                "data" => json_decode(json_encode($agents), true),
            );
            return  response()->json($data);
        } catch (\Exception $e) {
            $data = [
                "params" => $request->all(),
                "action" => "Admin Ticket Listing",
                "exception" => $e->getMessage()
            ];
            Log::info(json_encode($data));
            abort(500);
        }
    }


    /**
     * Created By : Robert M. Prescott
     * Created Date : 29/10/2021
     * Display the specified ticket.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $ticket = Tickets::findOrFail($id);
            return view("admins.tickets.view")->with(compact("ticket"));
        } catch (\Exception $e) {
            $data = [
                "params" => $id,
                "action" => "Ticket View",
                "exception" => $e->getMessage()
            ];
            Log::info(json_encode($data));
            abort(500);
        }
    }

    /**
     * Created By : Robert M. Prescott
     * Created Date : 29/10/2021
     * Display the specified ticket.
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function ListAgentTickets($id)
    {
        return view("admins.tickets.list")->with(compact("id"));
    }

    /**
     * Created By : Robert M. Prescott
     * Created Date : 29/10/2021
     * Display the specified ticket.
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function agentTicketData(Request  $request, $id){
        try {
            $order = $request->order;
            $sortBy = "id";
            if($order[0]['column'] == 0){
                $sortBy = "id";
            }elseif ($order[0]['column'] == 2){
                $sortBy = "title";
            }elseif ($order[0]['column'] == 5){
                $sortBy = "created_at";
            }
            $alltickets = Tickets::where("assigned_agent_id",$id)->count();
            if($request->search['value'] != NULL){
                $tickets = Tickets::where('title', 'like', '%' . $request->search['value'] . '%')->where("assigned_agent_id",$id)->skip($request->start)->take($request->length)->with("user","TicketStatus")->orderBy("$sortBy",$order[0]['dir'])->get()->toArray();
            }else{
                $tickets = Tickets::where("assigned_agent_id",$id)->skip($request->start)->take($request->length)->with("user","TicketStatus")->orderBy("$sortBy",$order[0]['dir'])->get()->toArray();
            }
            $data = array(
                "draw"=> $request->draw,
                "recordsTotal"=> $alltickets,
                "recordsFiltered"=> $alltickets,
                "data" => json_decode(json_encode($tickets), true),
            );
            return  response()->json($data);
        }catch (\Exception $e){
            dd($e->getMessage());
            $data = [
                "params" => $request->all(),
                "action" => "Ticket Listing by Admin",
                "exception" => $e->getMessage()
            ];
            Log::info(json_encode($data));
            abort(500);
        }
    }

}
