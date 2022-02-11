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

            return $msg = Message::create($message);
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

            return $msg = Message::create($message);
        }
    }

    public function searchUser(Request $request){
        if($request->search != ''){
            $users = User::where(function ($query) use($request){
                    return $query->where('first_name','LIKE',"%{$request->search}%")
                        ->orWhere('last_name','LIKE',"%{$request->search}%")
                        ->orWhere('email','LIKE',"%{$request->search}%");
                })->get();
            if($users){

                return response()->json([
                    'error' => 'not matched any record'
                ]);
            }
            return response()->json([
                'users' => $users,
            ]);
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
        if($conversations){
            foreach($conversations as $conversation){
                if($conversation->moderator_id == $user->id){
                    $conversation->recipient = User::find($conversation->participant_id);
                }else{
                    $conversation->recipient = User::find($conversation->moderator_id);
                }
                $conversation->message = $conversation->getLastMessage();
            }
        }

        return [
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
}
