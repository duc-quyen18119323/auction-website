<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function messages()
    {
        $conversation = \App\Models\Conversation::firstOrCreate(
            ['user_id' => auth()->id()],
            ['admin_id' => 1]
        );
        $messages = $conversation->messages()->orderBy('created_at')->get()->map(function($msg){
            return [
                'message' => $msg->message,
                'is_admin' => $msg->is_admin,
                'created_at' => $msg->created_at->format('H:i d/m/Y')
            ];
        });
        return response()->json($messages);
    }

    public function sendAjax(\Illuminate\Http\Request $request)
    {
        $conversation = \App\Models\Conversation::where('user_id', auth()->id())->firstOrFail();
        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_admin' => false
        ]);
        $conversation->touch();
        return response()->json(['success'=>true]);
    }

    //
}
