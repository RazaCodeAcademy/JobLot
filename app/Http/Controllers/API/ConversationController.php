<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// use model class here
use App\Models\User;
use App\Models\Job;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Participant;

class ConversationController extends Controller
{
    public function checkConversationExist($job_id, $user_id){
        $user = Auth::user();
        $conversation = Conversation::where([
                ['job_id', $job_id],
                ['user_id', $user_id],
            ])->first();

        if($conversation){
            return $conversation;
        }else{
            return $conversation = false;
        }
    }

    public function getName($job_id, $user_id){
        $job_title = Job::find($job_id)->title;
        $user_name = User::find($user_id)->first_name;
        return $user_name. ',' .$job_title;
    }

    public function sendMessage(Request $request){
        $user_id = $request->user_id;
        $job_id = $request->job_id;
        $send_by = $request->send_by;
        $message = $request->message;

        $conversation = $this->checkConversationExist($job_id, $user_id);
        
        if($conversation){
            $message = [
                'user_id' => $user_id,
                'job_id' => $job_id,
                'send_by' => $send_by,
                'conversation_id' => $conversation->id,
                'text' => $message,
            ];

            $msg = Message::create($message);
            $conversation->user_id = $user_id;
            $conversation->update();
            
            notifications(
                null,
                $send_by == 1 ? $user_id : $job_id,
                Conversation::class, 
                "sends message to you at: (". date('d-M-y') .")"
            );

            return $msg;
        }else{
            $conversation = Conversation::create([
                'user_id' => $user_id,
                'job_id' => $job_id,
                'name' => $this->getName($job_id, $user_id),
            ]);
            $message = [
                'user_id' => $user_id,
                'job_id' => $job_id,
                'send_by' => $send_by,
                'conversation_id' => $conversation->id,
                'text' => $message,
            ];

            $msg = Message::create($message);

            notifications(
                null,
                $send_by == 1 ? $user_id : $job_id, 
                Conversation::class, 
                "sends message to you at: (". date('d-M-y') .")"
            );

            return $msg;
        }
    }

    public function searchConversation(Request $request){
        $send_by = $request->send_by;
        if($request->search != ''){
            $conversations = Conversation::where('name','LIKE',"%{$request->search}%")->get();
            return $this->get_list($conversations, $send_by);
        }else{
            return [
                'success' => false,
                'message' => 'You must have to enter something! '
            ];
        }
    }

    public function get_list($conversations, $send_by){
        $totalUnread = 0;
        if($conversations){
            foreach($conversations as $conversation){
                $unread_counts = 0;
                $conversation->last_message = $conversation->getLastMessage();
                foreach ($conversation->messages as $key => $message) {
                    if($message->is_read != 1 && $message->send_by != $send_by){
                        $totalUnread++;
                        $unread_counts++;
                    }
                }
                unset($conversation->messages);
                $conversation->unread_counts = $unread_counts;
            }

        }

        return [
            'count' => count($conversations),
            'totalUnread' => $totalUnread,
            'conversations' => $conversations,
        ];
    }

    public function getConversationList(Request $request){
        $sender_id = $request->sender_id;
        $send_by = $request->send_by;
        if($send_by == 1){
            $conversations = Conversation::where('user_id', $sender_id)
            ->where('deleted_by_employee', 0)
            ->orderBy('updated_at', 'desc')
            ->get();
        }else{
            $conversations = Conversation::where('job_id', $sender_id)
            ->where('deleted_by_employer', 0)
            ->orderBy('updated_at', 'desc')
            ->get();
        }
        return $this->get_list($conversations, $send_by);
    }

    public function getConversationChat(Request $request){
        $revceiver_id = $request->revceiver_id;
        $send_by = $request->send_by;
        if($send_by == 1){
            $conversation = Conversation::where('user_id', $revceiver_id)->first();
        }else{
            $conversation = Conversation::where('job_id', $revceiver_id)->first();
        }
        
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
    
    public function delete_conversation(Request $request)
    {
        $conversation = Conversation::find($request->id);

        if($conversation){
            if ($request->send_by == 1) {
                $conversation->deleted_by_employee = true;
            }else{
                $conversation->deleted_by_employer = true;
            }
            $conversation->update();
            return response()->json([
                'success' => false,
                'message' => 'Conversation deleted successfuly!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'There is no conversation against your query!',
        ]);
    }
}