<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redis;
use App\Conversation;

class ConversationController extends Controller
{
    public function store(Request $request)
    {
    	$c1 = Conversation::where('user1','=', Auth::user()->id)->where('user2','=', $request->get('user_id'))->count();
    	$c2 = Conversation::where('user2','=', Auth::user()->id)->where('user1','=',$request->get('user_id'))->count();
    	if ($c1 != 0 || $c2 != 0) {
    		return redirect()->back();
    	}else {
    		$c = new Conversation;
    		$c->user1 = Auth::user()->id;
    		$c->user2 = $request->get('user_id');
    		$c->save();
    		return redirect()->back();
    	}
    }

    public function show($id)
    {  
    	$conversation = Conversation::findOrFail($id);
    	if ($conversation->user1 == Auth::user()->id || $conversation->user2 == Auth::user()->id) {
    		return view('conversation.show', compact('conversation'));
    	}else{
    		return redirect()->back();
    	}
    	
    }
}
