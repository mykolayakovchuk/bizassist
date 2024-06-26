<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Participant;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Создание чата пользователем
     * @param  \Illuminate\Http\Request  $request
     * @return json (status)
     */
    public function startConversation(Request $request){

        $request->validate([
            'idRecipient' => 'required|integer',
            'subject' => 'required|string|max:255'
        ]);

        $result = DB::transaction(function () use ($request) {
            $conversation = new Conversation;
            $conversation->subject = $request->subject;
            $conversation->save();
            $participatnsArray = [ Auth::id(), $request->idRecipient];
            foreach ($participatnsArray as $id) {
                $participant = new Participant;
                $participant->conversation_id = $conversation->id;
                $participant->user_id = $id;
                $participant->save(); 
            }
        });
        return $this->dbTransactionAnswer($result);
    }

    /**
     * удаление чата
     * @param  \Illuminate\Http\Request  $request
     * @return json (status)
     */
    public function deleteConversation(Request $request){
        $request->validate([
            'idConversation' => 'exists:App\Models\Conversation,id',
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
        $result = $conversation->delete();
        return $this->dbAnswer($result);
    }

    /**
     * Получение списка чатов текущего пользователя по id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return json (список чатов)
     */
    public function getMyConversations(){
        $participation = Participant::where('user_id', Auth::id())->get();
        if ( $participation->isEmpty() ) {
            return json_encode(["message"=>"you have no chats"]);
          }
        $conversations = collect();
        foreach ($participation as $participant){
            $conversation = collect();
            $conversation->put('chatInfo', $participant->conversation);
            $conversation->put('lastMessage', $participant->conversation->messages->last());
            foreach ($participant->conversation->participants as $conversationParticipant){
                if($conversationParticipant->user_id !== Auth::id()){
                    $conversation->put('interlocutorId', $conversationParticipant->user->id);
                    $conversation->put('interlocutorName', $conversationParticipant->user->name);
                }
            }
            $conversations->push($conversation);
        }
        return $conversations->toJson();
    }

        /**
     * получение чата по id
     * @param  \Illuminate\Http\Request  $request
     * @return json (Collection)
     */
    public function getChatById(Request $request){
        $request->validate([
            'idConversation' => 'exists:App\Models\Conversation,id',
        ]);
        //заголовок чата
        $conversation= Conversation::find($request->idConversation);
        $conversationBelongsThisUser = false;
        foreach ($conversation->participants as $participant){
            if ($participant->user_id == Auth::id()){
                $conversationBelongsThisUser = true;
            }
        }
        if($conversationBelongsThisUser == false){
            return json_encode(["message"=>"this is not your chat. reading prohibited"]);
        }
        $chat = collect();
        $chat->put("header", $conversation);
        //сообщения чата
        $messageList = collect();
        $messages = $conversation->messages;
        foreach ($messages as $message){
            $messageBody = collect();
            $messageBody->put("message", $message);
            $messageBody->put("author", $message->user->name);
            $messageBody->put("idAuthor", $message->user->id);
            $messageList->push($messageBody);
        }
        $chat->put("messages", $messageList);
        //собеседник
        foreach ($conversation->participants as $conversationParticipant){
            if($conversationParticipant->user_id !== Auth::id()){
                $chat->put('interlocutorId', $conversationParticipant->user->id);
                $chat->put('interlocutorName', $conversationParticipant->user->name);
            }
        }

        return $chat->toJson();
    }
}
