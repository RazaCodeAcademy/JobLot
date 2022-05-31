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
        $total_unread = 0;
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
                    $message_unread = Message::where([['conversation_id', $conversation->id],
                    ['user_id', '!=', Auth::user()->id]])
                    ->where('is_read',0)
                    ->get();
                    $message_unread = count($message_unread);
                    $total_unread += $message_unread;
                    $conversation->unread_counts = $message_unread;
                    array_push($users, $conversation);
                }
            }
        }

        return [
            'count' => count($users),
            'total_unread' => $total_unread,
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
        $total_unread = 0;
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
                $message_unread = Message::where([['conversation_id', $conversation->id],
                ['user_id', '!=', Auth::user()->id]])
                ->where('is_read',0)
                ->get();
                $message_unread = count($message_unread);
                $total_unread += $message_unread;
                $conversation->unread_counts = $message_unread;
            }
        }

        return [
            'count' => count($conversations),
            'total_unread' => $total_unread,
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

    public function checkreadMessage(Request $request)
    {
        // $check = Message::where([['id', $request->id],['conversation_id', $request->conversation_id]])->where('is_read',0)->first();
        // $total_unread = Message::where('user_id',Auth::user()->id)->where('is_read',0)->get();
        $total_unread = Message::where([['conversation_id', $request->conversation_id],
        ['user_id','!=',Auth::user()->id]])
        ->where('is_read',0)
        ->get();

        if($total_unread){
            return response()->json([
                'Total Unread_Message' => count($total_unread),
                'success' => true,
                'message' => 'These messages are unRead'
            ], 200);
  
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'This message is Read'
            ], 200);
        }
        
    }

    public function readMessage(Request $request)
    {
        $unread_messages = Message::where('conversation_id', $request->conversation_id)
        ->where('user_id', "!=", Auth::user()->id)
        ->where('is_read',0)
        ->get();

        foreach ($unread_messages as $key => $message) {
            $message->update(['is_read' => 1]);
        }


        if($unread_messages){
            return response()->json([
                'success' => true,
                'message' => 'These messages are Read'
            ], 200);
  
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'This message is unread'
            ], 200);
        }

    }

    public function delete_conversation(Request $request){
        $conversation = Conversation::where([['id', $request->id]])->first();
        $messages =Message::where('conversation_id',$request->id)
        ->where('user_id', '!=' ,Auth::user()->id)->get();
        foreach ($messages as $key => $value) {
           $value->delete();
        }
        if($conversation->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Conversation has been deleted successfuly!'
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong please try again!'
            ], 400);
        }
    }
    
}