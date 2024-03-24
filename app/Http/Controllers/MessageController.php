<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;

class MessageController extends Controller
{
    /**
     * Отправка сообщения пользователем
     * @param  \Illuminate\Http\Request  $request
     * @return json (status)
     */
    public function send(Request $request){
        $request->validate([
            'body' => 'required|string',
            'idConversation' => 'exists:App\Models\Conversation,id'
        ]);
        $conversation= Conversation::find($request->idConversation);
        $conversationBelongsThisUser = false;
        foreach ($conversation->participants as $participant){
            if ($participant->user_id == Auth::id()){
                $conversationBelongsThisUser = true;
            }
        }
        if($conversationBelongsThisUser == false){
            return json_encode(["message"=>"this is not your chat. editing prohibited"]);
        }
        $message = new Message;
        $message->conversation_id = $request->idConversation;
        $message->user_id = Auth::id();
        $message->text = $request->body;
        $result = $message->save();
        return $this->dbAnswer($result);
    }

    /**
     * Удаление сообщения пользователем
     * @param  \Illuminate\Http\Request  $request
     * @return json (status)
     */
    public function delete(Request $request){
        $request->validate([
            'idMessage' => 'exists:App\Models\Message,id'
        ]);
        $message = Message::find($request->idMessage);
        if ($message->user_id != Auth::id()){
            return json_encode(["message"=>"this is not your message. deleting prohibited"]);
        }
        $result = $message->delete();
        return $this->dbAnswer($result);
    }
}
