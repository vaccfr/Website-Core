<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\General\InternalMessage;
use Illuminate\Http\Request;

class InternalMessagingController extends Controller
{
    public function inbox()
    {
        $inbox = InternalMessage::orderBy('created_at', 'DESC')
        ->where('recipient_id', auth()->user()->id)
        ->with('recipient')
        ->with('sender')
        ->where('archived', false)
        ->where('trashed', false)
        ->get();
        return view('app.messaging.inbox', [
            'inbox_count' => session()->get('inbox_count'),
            'display' => $inbox,
        ]);
    }

    public function read(Request $request)
    {
        $msg = InternalMessage::where('id', $request->get('msgid'))
        ->with('sender')
        ->with('recipient')
        ->first();
        if (is_null($msg)) {
            return redirect()->route('app.inmsg.inbox', app()->getLocale())->with('pop-error', 'Your message could not be found.');
        }
        return view('app.messaging.read', [
            'inbox_count' => session()->get('inbox_count'),
            'msg' => $msg,
        ]);
    }
}
