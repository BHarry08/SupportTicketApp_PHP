<?php

namespace App\Http\Requests;

use App\Tickets;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AddReply extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        $user = Auth::user();
        $ticket = Tickets::findOrFail($request->id);
        if($user){
            if($ticket && $ticket->user_id == $user->id){
                return  true;
            }
        }
        $agent = Auth::guard("agents")->user();
        if($agent){
            if($ticket->assigned_agent_id == $agent->id ){
                return  true;
            }
        }
        return  false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => ['required', 'string', 'max:1000'],
        ];
    }
}
