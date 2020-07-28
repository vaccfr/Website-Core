<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\General\InternalMessage;
use App\Models\Users\User;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InternalMessagingController extends Controller
{
    public function inbox()
    {
        $inbox = InternalMessage::orderBy('created_at', 'DESC')
        ->where('recipient_id', auth()->user()->id)
        ->with('recipient')
        ->with('sender')
        ->where('recipient_archived', false)
        ->where('recipient_trashed', false)
        ->get();
        return view('app.messaging.inbox', [
            'header' => 'Messages',
            'display' => $inbox,
        ]);
    }

    public function trash()
    {
        $inbox = InternalMessage::orderBy('created_at', 'DESC')
        ->where('recipient_id', auth()->user()->id)
        ->with('recipient')
        ->with('sender')
        ->where('recipient_archived', false)
        ->where('recipient_trashed', true)
        ->get();
        return view('app.messaging.inbox', [
            'header' => 'Trash',
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
            return redirect()->route('app.inmsg.inbox', app()->getLocale())->with('pop-error', 'Your message could not be found');
        } elseif ($msg->recipient_id !== auth()->user()->id) {
            return redirect()->route('app.inmsg.inbox', app()->getLocale());
        }
        if ($msg->read == false) {
            $msg->read = true;
            $msg->save();
        }
        return view('app.messaging.read', [
            'msg' => $msg,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'msgsubject' => ['required', 'max:150'],
            'msgbody' => ['required'],
            'msgrecipient' => ['required'],
        ]);

        $recipient = User::where('id', $request->get('msgrecipient'))->first();
        if ($validator->fails() || is_null($recipient)) {
            return redirect()->back()->with('pop-error', 'An error occurred and the message could not be sent');
        }

        $formattedBody = nl2br($request->get('msgbody'));

        InternalMessage::create([
            'id' => (new Snowflake)->id(),
            'sender_id' => auth()->user()->id,
            'recipient_id' => $request->get('msgrecipient'),
            'subject' => $request->get('msgsubject'),
            'body' => $formattedBody,
        ]);

        return redirect()->back()->with('toast-success', 'Your message was sent');
    }

    public function deleteMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'msgid' => ['required'],
        ]);

        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()->back()->with('pop-error', 'An error occurred and the message could not be deleted');
        } else {
            $msg = InternalMessage::where('id', $request->get('msgid'))->first();
            if (is_null($msg)) {
                return redirect()->back()->with('pop-error', 'An error occurred and the message could not be deleted');
            } elseif (!$msg->recipient_id == auth()->user()->id) {
                return redirect()->back();
            }
        }

        $msg->recipient_trashed = true;
        $msg->save();

        return redirect()->back()->with('toast-success', 'Message deleted');
    }
}
