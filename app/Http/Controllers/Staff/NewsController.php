<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\General\News;
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
            return redirect()->back()->with('toast-error', 'Event was not found and could not be edited');
        }

        $post->title = $request->get('edittitle');
        $post->content = $request->get('editcontent');
        $post->save();
        return redirect()->route('app.staff.news.dashboard', app()->getLocale())->with('toast-info', 'Post content edited');
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
            return redirect()->back()->with('toast-error', 'Event was not found and could not be edited');
        }

        $post->delete();
        return redirect()->route('app.staff.news.dashboard', app()->getLocale())->with('toast-info', 'Post deleted');
    }
}
