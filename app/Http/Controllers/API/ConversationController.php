<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// use model class here
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Participant;

class ConversationController extends Controller
{
    public function checkConversationExist($participantId){
        $user = Auth::user();
        $conversation = Conversation::where([
                ['moderator_id', $user->id],
                ['participant_id', $participantId],
            ])->orWhere([
                ['moderator_id', $participantId],
                ['participant_id', $user->id],
            ])->first();

        if($conversation){
            return $conversation;
        }else{
            return $conversation = false;
        }
    }

    public function sendMessage(Request $request){
        $user = Auth::user();
        $participantId = $request->participant_id;
        $message = $request->message;

        $conversation = $this->checkConversationExist($participantId);
        
        if($conversation){
            $message = [
                'user_id' => $user->id,
                'conversation_id' => $conversation->id,
                'text' => $message,
            ];

            $msg = Message::create($message);

            notifications(
                null,
                $participantId, 
                Conversation::class, 
                "sends message to you at: (". date('d-M-y') .")"
            );

            return $msg;
        }else{
            $conversation = Conversation::create([
                'moderator_id' => $user->id,
                'participant_id' => $participantId,
            ]);
            $message = [
                'user_id' => $user->id,
                'conversation_id' => $conversation->id,
                'text' => $message,
            ];

            $conversation->recipient()->attach([$participantId, $user->id]);

            $msg = Message::create($message);

            notifications(
                null,
                $participantId, 
                Conversation::class, 
                "sends message to you at: (". date('d-M-y') .")"
            );

            return $msg;
        }
    }

    public function searchUser(Request $request){
        $users = [];
        if($request->search != ''){
            $user = Auth::user();
            $conversation_ids = Participant::select('conversation_id')->where([
                ['user_id', $user->id]
            ])->get();

        $conversations = Conversation::whereIn('id',$conversation_ids)->orderBy('updated_at', 'desc')->get();
        if($conversations){
            foreach($conversations as $conversation){
                $recipient = '';
                if($conversation->moderator_id == $user->id){
                    $recipient = User::where('id', $conversation->participant_id)
                    ->where(function ($query) use($request){
                        return $query->where('first_name','LIKE',"%{$request->search}%")
                        ->orWhere('last_name','LIKE',"%{$request->search}%")
                        ->orWhere('email','LIKE',"%{$request->search}%");
                    })->first();
                }else{
                    $recipient = User::where('id', $conversation->moderator_id)
                    ->where(function ($query) use($request){
                        return $query->where('first_name','LIKE',"%{$request->search}%")
                        ->orWhere('last_name','LIKE',"%{$request->search}%")
                        ->orWhere('email','LIKE',"%{$request->search}%");
                    })->first();
                }
                
                if (!empty($recipient)) {
                    $conversation->recipient = $recipient;
                    $conversation->message = $conversation->getLastMessage();
                    array_push($users, $conversation);
                }
            }
        }

        return [
            'count' => count($users),
            'conversations' => $users,
        ];

        }else{
            return response()->json([
                'error' => 'query required'
            ]);
        }
    }

    public function getConversationList(Request $request){
        $user = Auth::user();
        $conversation_ids = Participant::select('conversation_id')->where([
            ['user_id', $user->id]
        ])->get();

        $conversations = Conversation::whereIn('id',$conversation_ids)->orderBy('updated_at', 'desc')->get();
        $totalUnread = 0;
        if($conversations){
            foreach($conversations as $conversation){
                $unread_counts = 0;
                if($conversation->moderator_id == $user->id){
                    $conversation->recipient = User::find($conversation->participant_id);
                }else{
                    $conversation->recipient = User::find($conversation->moderator_id);
                }
                $conversation->message = $conversation->getLastMessage();
                foreach ($conversation->messages as $key => $message) {
                    if($message->is_read != 1 && $user->id != $message->user_id){
                        $totalUnread++;
                        $unread_counts++;
                    }
                }
                $conversation->unread_counts = $unread_counts;
            }

        }

        return [
            'count' => count($conversations),
            'totalUnread' => $totalUnread,
            'conversations' => $conversations,
        ];
    }

    public function getConversationChat(Request $request){
        $conversation = Conversation::where([
            ['participant_id', $request->participant_id],
            ['moderator_id', Auth::Id()],
        ])->orWhere([
            ['participant_id', Auth::Id()],
            ['moderator_id', $request->participant_id],
        ])->first();
            if($conversation){
                 return response()->json([
            'messages' => $conversation->messages,
        ]);
            }
            else{
                 return response()->json([
            'messages' => [],
        ]);
            }
    }

    public function readMessage(Request $request)
    {
        $messages = Message::where('conversation_id', $request->conversation_id)
        ->where('user_id', '!=', Auth::id())
        ->get();

        if(count($messages) < 1){
            return response()->json([
                'success' => true,
                'message' => 'There is no meesage to read against your request!',
            ]);
        }

        foreach ($messages as $message) {
            $message->is_read = 1;
            $message->update();
        }

        return response()->json([
            'success' => true,
            'message' => 'Messages read successfuly!',
        ]);
    }
}