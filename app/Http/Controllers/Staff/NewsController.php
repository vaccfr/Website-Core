<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\DiscordAnnouncer;
use App\Models\General\News;
use DateTime;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function dashboard()
    {
        $newslist = News::orderBy('created_at', 'DESC')
        ->with('author')
        ->get();
        return view('app.staff.news_dashboard', [
            'newslist' => $newslist,
        ]);
    }

    public function newItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'content' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('toast-error', 'Error occured');
        }

        News::create([
            'id' => (new Snowflake)->id(),
            'title' => request('title'),
            'content' => $request->get('content'),
            'author_id' => auth()->user()->id,
        ]);

        return redirect()->route('app.staff.news.dashboard', app()->getLocale())->with('toast-success', 'News published');
    }

    public function editItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postid' => ['required'],
            'edittitle' => ['required'],
            'editcontent' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('toast-error', 'Error occured');
        }

        $post = News::where('id', $request->get('postid'))->first();
        if (is_null($post)) {
            return redirect()->back()->with('toast-error', 'Post was not found and could not be edited');
        }

        $post->title = $request->get('edittitle');
        $post->content = $request->get('editcontent');
        $post->save();

        if (!is_null($post->discord_msg_id)) {
            $timestamp = date_create_from_format('Y-m-d H:i:s', $post->created_at)->format(DateTime::ATOM);
            app(DiscordAnnouncer::class)->editAnnouncement(
                $post->discord_msg_id,
                request('edittitle'),
                request('editcontent'),
                $request->user()->fname." ".$request->user()->lname,
                $timestamp,
            );
        }

        return redirect()->route('app.staff.news.dashboard', app()->getLocale())->with('toast-info', 'Post content edited');
    }

    public function publishDiscord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('toast-error', 'Error occured');
        }

        $post = News::where('id', $request->get('postid'))->first();
        if (is_null($post)) {
            return redirect()->back()->with('toast-error', 'Post was not found');
        }
        $timestamp = date_create_from_format('Y-m-d H:i:s', $post->created_at)->format(DateTime::ATOM);
        $dmsgid = app(DiscordAnnouncer::class)->sendAnnouncement(
            $post->title,
            $post->content,
            $request->user()->fname." ".$request->user()->lname,
            $timestamp,
        );
        $post->discord_msg_id = $dmsgid;
        $post->save();

        return redirect()->route('app.staff.news.dashboard', app()->getLocale())->with('toast-info', 'Post published');
    }

    public function deleteDiscord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('toast-error', 'Error occured');
        }

        $post = News::where('id', $request->get('postid'))->first();
        if (is_null($post)) {
            return redirect()->back()->with('toast-error', 'Post was not found');
        }

        $res = app(DiscordAnnouncer::class)->delAnnouncement($post->discord_msg_id);
        $post->discord_msg_id = null;
        $post->save();
        if ($res == false) {
            return redirect()->route('app.staff.news.dashboard', app()->getLocale())->with('toast-error', 'Error occured deleting');
        } else {
            return redirect()->route('app.staff.news.dashboard', app()->getLocale())->with('toast-info', 'Deleted message');
        }
    }

    public function deleteItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('toast-error', 'Error occured');
        }

        $post = News::where('id', $request->get('postid'))->first();
        if (is_null($post)) {
            return redirect()->back()->with('toast-error', 'Post was not found and could not be delete');
        }
        $res = app(DiscordAnnouncer::class)->delAnnouncement($post->discord_msg_id);
        $post->delete();
        return redirect()->route('app.staff.news.dashboard', app()->getLocale())->with('toast-info', 'Post deleted');
    }
}
