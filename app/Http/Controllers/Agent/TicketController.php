<?php

namespace App\Http\Controllers\Agent;

use App\Agents;
use App\Http\Controllers\Controller;
use App\Http\CustomTraits\TicketTrait;
use App\Http\Requests\AddReply;
use App\Http\Requests\CreateTicket;
use App\Http\Requests\StoreTicket;
use App\Status;
use App\TicketReplies;
use App\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    use TicketTrait;

    /**
     * TicketController constructor.
     * Created By : Robert M. Prescott
     * Created Date : 10/01/2021
     * Use : Auth Middleware  to check valid user
     */
    public function __construct()
    {
        $this->middleware('AgentAuth');
    }
    /**
     * Created By : Robert M. Prescott
     * Created Date : 01/11/2021
     * Use : Display a listing of the ticket.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return view("agents.tickets.list");
        }catch (\Exception $e){
            $data = [
                "params" => $request->all(),
                "action" => "Ticket Listing View",
                "exception" => $e->getMessage()
            ];
            Log::info(json_encode($data));
            abort(500);
        }
    }

    /**
     * Created By : Robert M. Prescott
     * Created Date : 01/11/2021
     * Use : Display a listing of the ticket.
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
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
            $user = Auth::guard('agents')->user();
            $alltickets = Tickets::where("assigned_agent_id",$user->id)->count();
            if($request->search['value'] != NULL){
                $tickets = Tickets::where('title', 'like', '%' . $request->search['value'] . '%')->where("assigned_agent_id",$user->id)->skip($request->start)->take($request->length)->with("user","TicketStatus")->orderBy("$sortBy",$order[0]['dir'])->get()->toArray();
            }else{
                $tickets = Tickets::where("assigned_agent_id",$user->id)->skip($request->start)->take($request->length)->with("user","TicketStatus")->orderBy("$sortBy",$order[0]['dir'])->get()->toArray();
           }
            $data = array(
                "draw"=> $request->draw,
                "recordsTotal"=> $alltickets,
                "recordsFiltered"=> $alltickets,
                "data" => json_decode(json_encode($tickets), true),
            );
            return  response()->json($data);
        }catch (\Exception $e){
            $data = [
                "params" => $request->all(),
                "action" => "Ticket Listing",
                "exception" => $e->getMessage()
            ];
            Log::info(json_encode($data));
            abort(500);
        }
    }


    /**
     * Created By : Robert M. Prescott
     * Created Date : 01/11/2021
     * Display the specified ticket.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $ticket = Tickets::findOrFail($id);
            return view("agents.tickets.view")->with(compact("ticket"));
        }catch (\Exception $e){
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
     * Created Date : 01/11/2021
     * Show the form for editing the specified ticket.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $statuses = Status::all();
            $ticket = Tickets::findOrFail($id);
            return view("agents.tickets.edit")->with(compact("ticket","statuses"));
        }catch (\Exception $e){
            $data = [
                "params" => $id,
                "action" => "Ticket Edit View",
                "exception" => $e->getMessage()
            ];
            Log::info(json_encode($data));
            abort(500);
        }

    }

    /**
     * Created By : Robert M. Prescott
     * Created Date : 01/11/2021
     * Update the specified ticket in database.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddReply $request, $id)
    {
        try {
            $user = Auth::guard("agents")->user();
            $data["ticket_id"] = $id;
            $data["reply_by_id"] = $user->id;
            $data["reply_description"] = $request->description;
            $data["reply_status"] = $request->status;
            TicketReplies::create($data);
            Tickets::where("id",$id)->update(array("status"=>$request->status));
            Session::flash('message', 'Ticket Reply added successfully!');
            Session::flash('alert-class', 'alert-success');
            return  redirect("/agent/view/$id");
        }catch (\Exception $e){
            $data = [
                "params" => $id,
                "action" => "Add reply on ticket",
                "exception" => $e->getMessage()
            ];
            Log::info(json_encode($data));
            abort(500);
        }
    }
}
